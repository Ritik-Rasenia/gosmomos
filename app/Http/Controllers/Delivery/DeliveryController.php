<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\DeliveryPartner;
use App\Models\DeliveryAssignment;
use App\Models\OrderTracking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdatedMail;

class DeliveryController extends Controller
{
    private function getPartner()
    {
        $user = Auth::user();
        $partner = $user->deliveryPartner;

        if (!$partner) {
            $partner = DeliveryPartner::create([
                'user_id' => $user->id,
                'vehicle_type' => 'Motorcycle',
                'vehicle_number' => 'UP32-AB-9999',
                'license_number' => 'DL-LKO-9999999',
                'is_verified' => true,
                'is_online' => true,
                'rating' => 5.0,
                'total_deliveries' => 0,
            ]);
        }

        return $partner;
    }

    public function dashboard()
    {
        $partner = $this->getPartner();

        // Active Delivery
        $activeAssignment = DeliveryAssignment::where('delivery_partner_id', $partner->id)
            ->where('status', 'active')
            ->first();

        $activeOrder = $activeAssignment ? Order::find($activeAssignment->order_id) : null;

        // Stats
        $todayDeliveriesCount = DeliveryAssignment::where('delivery_partner_id', $partner->id)
            ->where('status', 'delivered')
            ->whereDate('delivered_at', today())
            ->count();

        $todayEarnings = DeliveryAssignment::where('delivery_partner_id', $partner->id)
            ->where('status', 'delivered')
            ->whereDate('delivered_at', today())
            ->sum('earnings');

        return view('delivery.dashboard', compact('partner', 'activeOrder', 'todayDeliveriesCount', 'todayEarnings'));
    }

    public function orders()
    {
        $poolOrders = Order::where('status', 'packed')->orderBy('created_at', 'desc')->get();
        return view('delivery.orders.index', compact('poolOrders'));
    }

    public function acceptOrder(Request $request, $id)
    {
        $partner = $this->getPartner();

        // Check if partner already has an active delivery
        $activeAssignment = DeliveryAssignment::where('delivery_partner_id', $partner->id)
            ->where('status', 'active')
            ->first();

        if ($activeAssignment) {
            return back()->with('error', 'You already have an active delivery assignment. Complete it first!');
        }

        $order = Order::findOrFail($id);

        if ($order->status !== 'packed') {
            return back()->with('error', 'This order is no longer available for pickup.');
        }

        try {
            DB::beginTransaction();

            // Update order status
            $order->status = 'out_for_delivery';
            $order->save();

            // Create assignment
            // Driver gets at least ₹50 per delivery, or the delivery fee, whichever is higher
            $earnings = max((float)$order->delivery_fee, 50.00);

            DeliveryAssignment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'delivery_partner_id' => $partner->id,
                    'status' => 'active',
                    'picked_at' => now(),
                    'earnings' => $earnings,
                ]
            );

            // Add Order Tracking entry
            $order->tracking()->create([
                'status' => 'out_for_delivery',
                'description' => 'Delivery rider (' . $partner->user->name . ') has picked up your order and is on the way.',
            ]);

            // Send Out for Delivery Email
            try {
                Mail::to($order->user->email)->send(new OrderStatusUpdatedMail($order));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Failed to send out_for_delivery email for order #{$order->order_number}: " . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('delivery.active')->with('success', 'Order accepted successfully! You are now out for delivery.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to accept order: ' . $e->getMessage());
        }
    }

    public function active()
    {
        $partner = $this->getPartner();

        $activeAssignment = DeliveryAssignment::where('delivery_partner_id', $partner->id)
            ->where('status', 'active')
            ->first();

        $activeOrder = null;
        if ($activeAssignment) {
            $activeOrder = Order::with(['user', 'address', 'location', 'items'])->find($activeAssignment->order_id);
        }

        return view('delivery.orders.active', compact('activeOrder'));
    }

    public function markDelivered(Request $request, $id)
    {
        $partner = $this->getPartner();

        $assignment = DeliveryAssignment::where('order_id', $id)
            ->where('delivery_partner_id', $partner->id)
            ->where('status', 'active')
            ->first();

        if (!$assignment) {
            return back()->with('error', 'Active assignment not found for this order.');
        }

        $order = Order::findOrFail($id);

        try {
            DB::beginTransaction();

            // Update order status
            $order->status = 'delivered';
            if ($order->payment_method === 'cod') {
                $order->payment_status = 'paid';
            }
            $order->save();

            // Update assignment status
            $assignment->status = 'delivered';
            $assignment->delivered_at = now();
            $assignment->save();

            // Increment deliveries count
            $partner->increment('total_deliveries');

            // Add Order Tracking entry
            $order->tracking()->create([
                'status' => 'delivered',
                'description' => 'Your order has been delivered successfully! Thank you for ordering from GOS MOMO.',
            ]);

            // Update payment status logs if exists
            if ($order->payment) {
                $order->payment->status = 'paid';
                $order->payment->save();
            }

            // Send Delivery Confirmation Email
            try {
                Mail::to($order->user->email)->send(new OrderStatusUpdatedMail($order));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Failed to send delivered email for order #{$order->order_number}: " . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('delivery.dashboard')->with('success', 'Order marked as delivered successfully! Outstanding job.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to mark order as delivered: ' . $e->getMessage());
        }
    }

    public function earnings()
    {
        $partner = $this->getPartner();

        $weeklyEarnings = DeliveryAssignment::where('delivery_partner_id', $partner->id)
            ->where('status', 'delivered')
            ->where('delivered_at', '>=', now()->startOfWeek())
            ->sum('earnings');

        $completedAssignments = DeliveryAssignment::with('order')
            ->where('delivery_partner_id', $partner->id)
            ->where('status', 'delivered')
            ->orderBy('delivered_at', 'desc')
            ->paginate(10);

        return view('delivery.earnings', compact('weeklyEarnings', 'completedAssignments'));
    }
}
