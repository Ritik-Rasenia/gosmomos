<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'location'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items', 'user', 'location', 'address'])->findOrFail($id);
        return view('admin.orders.show', compact('order', 'id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:placed,confirmed,preparing,packed,out_for_delivery,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        // Add tracking history node
        $order->tracking()->create([
            'status' => $request->status,
            'description' => 'Order status updated to ' . ucfirst(str_replace('_', ' ', $request->status)) . ' by Admin.',
        ]);

        return back()->with('success', 'Order status updated successfully!');
    }
}
