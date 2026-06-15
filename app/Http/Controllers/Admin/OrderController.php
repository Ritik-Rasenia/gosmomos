<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdatedMail;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'location'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items', 'user', 'location', 'address', 'deliveryAssignment'])->findOrFail($id);
        $deliveryPartners = \App\Models\DeliveryPartner::with('user')->get();
        return view('admin.orders.show', compact('order', 'id', 'deliveryPartners'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:placed,confirmed,preparing,packed,out_for_delivery,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
            'delivery_partner_id' => 'nullable|exists:delivery_partners,id',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        if ($request->has('delivery_partner_id')) {
            $partnerId = $request->delivery_partner_id;
            if ($partnerId) {
                \App\Models\DeliveryAssignment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'delivery_partner_id' => $partnerId,
                        'status' => 'assigned',
                        'earnings' => max((float)$order->delivery_fee, 50.00),
                    ]
                );

                // Auto advance status to packed if it was placed/confirmed/preparing
                if (in_array($order->status, ['placed', 'confirmed', 'preparing'])) {
                    $order->update(['status' => 'packed']);
                }

                // Notify Delivery Partner
                $partner = \App\Models\DeliveryPartner::with('user')->find($partnerId);
                if ($partner) {
                    \App\Models\Notification::send(
                        $partner->user_id,
                        'order_assigned',
                        'New Delivery Assigned',
                        "You have been assigned order #{$order->order_number} for delivery. Please check your active orders pool."
                    );
                }
            } else {
                \App\Models\DeliveryAssignment::where('order_id', $order->id)->delete();
            }
        }

        // Notify Customer of Status Update
        \App\Models\Notification::send(
            $order->user_id,
            'order_status',
            'Order Status Updated',
            "Your order #{$order->order_number} status has been updated to: " . ucfirst(str_replace('_', ' ', $order->status)) . "."
        );

        // Send Status Update Email
        try {
            Mail::to($order->user->email)->send(new OrderStatusUpdatedMail($order));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send status update email for order #{$order->order_number}: " . $e->getMessage());
        }

        // Add tracking history node
        $order->tracking()->create([
            'status' => $order->status,
            'description' => 'Order status updated to ' . ucfirst(str_replace('_', ' ', $order->status)) . ' by Admin.',
        ]);

        return back()->with('success', 'Order updated successfully!');
    }
}
