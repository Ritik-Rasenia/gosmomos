@extends('emails.layout')

@section('title', 'Your GOS MOMO Order Confirmation')

@section('content')
<h2>Thank You for Your Order!</h2>
<p>Hello {{ $order->user->name }},</p>
<p>We've received your order and are currently preparing it. Your order number is <strong>{{ $order->order_number }}</strong>.</p>

<h3>Order Summary</h3>
<table class="table-data">
    <thead>
        <tr>
            <th>Item</th>
            <th style="text-align: center;">Qty</th>
            <th style="text-align: right;">Price</th>
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
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold; border-top: 2px solid #e9ecef;">Subtotal:</td>
            <td style="text-align: right; font-weight: bold; border-top: 2px solid #e9ecef;">₹{{ number_format($order->subtotal, 2) }}</td>
        </tr>
        @if($order->discount > 0)
        <tr>
            <td colspan="2" style="text-align: right; color: #dc3545;">Discount:</td>
            <td style="text-align: right; color: #dc3545;">-₹{{ number_format($order->discount, 2) }}</td>
        </tr>
        @endif
        <tr>
            <td colspan="2" style="text-align: right;">GST (5%):</td>
            <td style="text-align: right;">₹{{ number_format($order->tax, 2) }}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right;">Delivery Fee:</td>
            <td style="text-align: right;">₹{{ number_format($order->delivery_fee, 2) }}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold; font-size: 16px; color: #FF7A00;">Total Paid:</td>
            <td style="text-align: right; font-weight: bold; font-size: 16px; color: #FF7A00;">₹{{ number_format($order->total, 2) }}</td>
        </tr>
    </tbody>
</table>

<div style="margin: 20px 0; padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
    <strong>Delivery Details:</strong><br>
    @if($order->address)
        {{ $order->address->address_line_1 }}<br>
        @if($order->address->address_line_2)
            {{ $order->address->address_line_2 }}<br>
        @endif
        {{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->pcode }}
    @else
        Self-Pickup from Store
    @endif
    <br><br>
    <strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }} ({{ ucfirst($order->payment_status) }})
</div>

<div style="text-align: center;">
    <a href="{{ route('customer.orders.show', $order->id) }}" class="btn-action">Track Your Order</a>
</div>

<p>If you need to make any changes to your order, please contact our helpline immediately.</p>

<p>Warm regards,<br>Team GOS MOMO</p>
@endsection
