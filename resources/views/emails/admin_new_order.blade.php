@extends('emails.layout')

@section('title', 'New Order Received - GOS MOMO Admin')

@section('content')
<h2 style="color: #dc3545;">New Order Received!</h2>
<p>Hello Admin,</p>
<p>A new order has been placed on GOS MOMO. Please find the order details below:</p>

<div style="margin: 20px 0; padding: 15px; background-color: #f8f9fa; border-radius: 8px; border-left: 5px solid #FF7A00;">
    <strong>Order ID:</strong> #{{ $order->order_number }}<br>
    <strong>Customer Name:</strong> {{ $order->user->name }} ({{ $order->user->email }} / {{ $order->user->phone }})<br>
    <strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}<br>
    <strong>Delivery Method:</strong> {{ ucfirst($order->delivery_method ?? 'delivery') }}<br>
    <strong>Total Amount:</strong> ₹{{ number_format($order->total, 2) }}<br>
    <strong>Payment Details:</strong> {{ strtoupper($order->payment_method) }} ({{ ucfirst($order->payment_status) }})
</div>

<h3>Items Ordered</h3>
<table class="table-data">
    <thead>
        <tr>
            <th>Item</th>
            <th style="text-align: center;">Qty</th>
            <th style="text-align: right;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
        <tr>
            <td>
                {{ $item->product_name }}
                @if($item->variant_name)
                    <br><small style="color: #6c757d;">({{ $item->variant_name }})</small>
                @endif
            </td>
            <td style="text-align: center;">{{ $item->quantity }}</td>
            <td style="text-align: right;">₹{{ number_format($item->total, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="text-align: center; margin-top: 30px;">
    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-action">Open Admin Dashboard</a>
</div>

<p>Please review the order details and dispatch it as soon as possible.</p>

<p>System Automated Notification,<br>GOS MOMO Engine</p>
@endsection
