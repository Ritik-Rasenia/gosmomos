@extends('emails.layout')

@section('title', 'Your GOS MOMO Order Status Updated')

@section('content')
<h2>Order Status Update</h2>
<p>Hello {{ $order->user->name }},</p>
<p>The status of your order <strong>#{{ $order->order_number }}</strong> has been updated to:</p>

<div class="highlight" style="text-transform: uppercase;">
    {{ str_replace('_', ' ', $order->status) }}
</div>

<div style="margin: 20px 0; padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
    <strong>Order Details:</strong><br>
    <ul>
        <li><strong>Order Number:</strong> {{ $order->order_number }}</li>
        <li><strong>Total:</strong> ₹{{ number_format($order->total, 2) }}</li>
        <li><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $order->status)) }}</li>
        @if($order->status == 'out_for_delivery' && $order->deliveryAssignment && $order->deliveryAssignment->partner)
            <li><strong>Delivery Partner:</strong> {{ $order->deliveryAssignment->partner->user->name }} ({{ $order->deliveryAssignment->partner->vehicle_number }})</li>
        @endif
    </ul>
</div>

<div style="text-align: center;">
    <a href="{{ route('customer.orders.show', $order->id) }}" class="btn-action">Track Live Location</a>
</div>

<p>Thank you for choosing GOS MOMO! Enjoy your meal!</p>

<p>Warm regards,<br>Team GOS MOMO</p>
@endsection
