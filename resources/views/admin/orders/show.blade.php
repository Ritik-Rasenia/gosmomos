@extends('layouts.admin')
@section('title', 'Order details — GOS MOMO')

@section('content')
@php $order = \App\Models\Order::with(['items','user','location','address'])->find($id); @endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Order Details</h4>
        <p class="text-muted mb-0">Order #{{ $order ? $order->order_number : '' }} details and updates.</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-success rounded-pill px-3">
        ← Back to List
    </a>
</div>

@if($order)
<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card p-4 mb-4">
            <h5 class="fw-bold mb-3">Customer Details</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <span class="text-muted small">NAME</span>
                    <div class="fw-bold">{{ $order->user->name }}</div>
                </div>
                <div class="col-md-6">
                    <span class="text-muted small">PHONE</span>
                    <div class="fw-bold">{{ $order->user->phone }}</div>
                </div>
                <div class="col-12">
                    <span class="text-muted small">DELIVERY ADDRESS</span>
                    <div class="fw-bold">{{ $order->address ? $order->address->address_line_1 : 'Self Pickup' }}</div>
                    @if($order->address)
                        <div class="text-muted small">{{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->pincode }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="admin-card p-4">
            <h5 class="fw-bold mb-3">Items Summary</h5>
            @foreach($order->items as $item)
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div>
                    <div class="fw-bold">{{ $item->product_name }}</div>
                    @if($item->variant_name)
                        <span class="badge bg-light text-dark border">{{ $item->variant_name }}</span>
                    @endif
                    <div class="text-muted small">₹{{ number_format($item->price, 0) }} x {{ $item->quantity }}</div>
                </div>
                <div class="fw-bold text-success">₹{{ number_format($item->total, 0) }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="col-lg-4">
        <div class="admin-card p-4 mb-4">
            <h5 class="fw-bold mb-4">Update Status</h5>
            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Order Status</label>
                    <select name="status" class="form-select rounded-3">
                        @foreach(['placed','confirmed','preparing','packed','out_for_delivery','delivered','cancelled'] as $st)
                            <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$st)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Payment Status</label>
                    <select name="payment_status" class="form-select rounded-3">
                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success rounded-pill w-100 py-2">Update Order</button>
            </form>
        </div>
    </div>
</div>
@else
<div class="alert alert-danger">Order not found.</div>
@endif
@endsection
