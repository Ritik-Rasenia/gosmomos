<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAddress;
use App\Models\Location;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;
use App\Mail\AdminNewOrderMail;

class CheckoutController extends Controller
{
    private function getCart()
    {
        return Cart::where('user_id', Auth::id())
            ->orWhere('session_id', session()->getId())
            ->first();
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to checkout.');
        }

        $cart = $this->getCart();
        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('menu.index')->with('error', 'Your cart is empty.');
        }

        $addresses = Auth::user()->addresses;
        $locations = Location::active()->get();
        $walletBalance = Auth::user()->wallet ? Auth::user()->wallet->balance : 0.00;

        // Default calculations
        $subtotal = $cart->total;
        $tax = round($subtotal * 0.05, 2); // 5% GST
        $deliveryFee = $subtotal > 300 ? 0.00 : 40.00; // Free delivery above 300
        $total = $subtotal + $tax + $deliveryFee;

        return view('checkout.index', compact('cart', 'addresses', 'locations', 'walletBalance', 'subtotal', 'tax', 'deliveryFee', 'total'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();
        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid coupon code.'], 422);
        }

        $cart = $this->getCart();
        if (!$cart || $cart->total == 0) {
            return response()->json(['success' => false, 'message' => 'Cart is empty.'], 422);
        }

        if (!$coupon->isValid(Auth::user(), $cart->total)) {
            return response()->json(['success' => false, 'message' => 'Coupon is not applicable.'], 422);
        }

        $discount = $coupon->calculateDiscount($cart->total);
        $subtotal = $cart->total;
        $tax = round(($subtotal - $discount) * 0.05, 2);
        $deliveryFee = ($subtotal - $discount) > 300 ? 0.00 : 40.00;
        $total = $subtotal - $discount + $tax + $deliveryFee;

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'code' => $coupon->code,
            'discount' => $discount,
            'tax' => $tax,
            'delivery_fee' => $deliveryFee,
            'total' => $total,
        ]);
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required|in:delivery,pickup',
            'address_id' => 'required_if:delivery_method,delivery|exists:user_addresses,id',
            'location_id' => 'required|exists:locations,id',
            'payment_method' => 'required|in:cod,razorpay,wallet',
            'coupon_code' => 'nullable|string|exists:coupons,code',
            'special_instructions' => 'nullable|string',
            'razorpay_payment_id' => 'required_if:payment_method,razorpay|nullable|string',
        ]);

        $cart = $this->getCart();
        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('menu.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cart->total;
        $discount = 0.00;
        $coupon = null;

        // Apply coupon if present
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();
            if ($coupon && $coupon->isValid(Auth::user(), $subtotal)) {
                $discount = $coupon->calculateDiscount($subtotal);
            }
        }

        $tax = round(($subtotal - $discount) * 0.05, 2);
        $deliveryFee = $request->delivery_method === 'pickup' ? 0.00 : (($subtotal - $discount) > 300 ? 0.00 : 40.00);
        $total = $subtotal - $discount + $tax + $deliveryFee;

        // Verify wallet balance if wallet selected
        $wallet = Auth::user()->wallet;
        if ($request->payment_method === 'wallet') {
            if (!$wallet || $wallet->balance < $total) {
                return back()->withErrors(['payment_method' => 'Insufficient wallet balance. Please add funds.'])->withInput();
            }
        }

        try {
            DB::beginTransaction();

            // Create Order
            $orderNumber = 'GOS-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'location_id' => $request->location_id,
                'address_id' => $request->delivery_method === 'delivery' ? $request->address_id : null,
                'status' => 'placed',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'delivery_fee' => $deliveryFee,
                'discount' => $discount,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'paid',
                'coupon_id' => $coupon ? $coupon->id : null,
                'special_instructions' => $request->special_instructions,
            ]);

            // Add Order Items
            foreach ($cart->items as $item) {
                $price = $item->variant ? $item->variant->price : $item->product->base_price;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'product_name' => $item->product->name,
                    'variant_name' => $item->variant ? $item->variant->name : null,
                    'price' => $price,
                    'quantity' => $item->quantity,
                    'total' => $price * $item->quantity,
                ]);
            }

            // Create Order Tracking
            $order->tracking()->create([
                'status' => 'placed',
                'description' => 'Your order has been placed successfully!',
            ]);

            // Handle wallet debit
            if ($request->payment_method === 'wallet') {
                $wallet->debit($total, "Paid for order " . $orderNumber);
            }

            // Record Coupon Usage
            if ($coupon) {
                CouponUsage::create([
                    'coupon_id' => $coupon->id,
                    'user_id' => Auth::id(),
                    'order_id' => $order->id,
                    'discount_amount' => $discount,
                ]);
            }

            // Create Payment log
            Payment::create([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'gateway' => $request->payment_method,
                'transaction_id' => $request->payment_method === 'razorpay' ? $request->razorpay_payment_id : null,
                'amount' => $total,
                'status' => $request->payment_method === 'cod' ? 'pending' : 'paid',
                'gateway_response' => $request->payment_method === 'razorpay' ? ['razorpay_payment_id' => $request->razorpay_payment_id] : null,
            ]);

            // Send Notifications
            \App\Models\Notification::send(
                Auth::id(),
                'order_placed',
                'Order Placed Successfully!',
                "Your order #{$order->order_number} of ₹" . number_format($total, 2) . " has been placed successfully. Thank you for choosing GOS MOMO!"
            );

            \App\Models\Notification::notifyAdmins(
                'new_order',
                'New Order Received',
                "A new order #{$order->order_number} has been placed by " . Auth::user()->name . " (Total: ₹" . number_format($total, 2) . ")."
            );

            // Send Emails
            try {
                Mail::to(Auth::user()->email)->send(new OrderPlacedMail($order));
                Mail::to(setting('contact_email', 'info@gosmomo.com'))->send(new AdminNewOrderMail($order));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Failed to send order placement emails for order #{$order->order_number}: " . $e->getMessage());
            }

            // Clear Cart
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            return redirect()->route('customer.orders.show', $order->id)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }
}
