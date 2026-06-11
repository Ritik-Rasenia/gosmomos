@extends('layouts.app')

@section('title', 'Order Details — GOS MOMO')

@section('styles')
<style>
.dashboard-sidebar {
    background: white;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
}
.sidebar-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 12px;
    color: #495057;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}
.sidebar-link:hover, .sidebar-link.active {
    background: rgba(15, 81, 50, 0.08);
    color: #0F5132;
}
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row g-4">
        {{-- Sidebar --}}
        <div class="col-lg-3">
            <div class="dashboard-sidebar">
                <div class="text-center mb-4">
                    <div style="width:70px; height:70px; border-radius:50%; background: linear-gradient(135deg, #0F5132, #D4A017); color:white; display:flex; align-items:center; justify-content:center; font-size:30px; font-weight:700; margin: 0 auto 12px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-1">{{ Auth::user()->name }}</h5>
                    <span class="badge bg-success-subtle text-success rounded-pill px-3">{{ ucfirst(Auth::user()->roles->first()?->name ?? 'Customer') }}</span>
                </div>
                <hr>
                <div class="d-flex flex-column gap-1">
                    <a href="{{ route('customer.dashboard') }}" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                    <a href="{{ route('customer.orders.index') }}" class="sidebar-link active">
                        <i class="bi bi-bag-check-fill"></i> My Orders
                    </a>
                    <a href="{{ route('customer.wallet') }}" class="sidebar-link">
                        <i class="bi bi-wallet2"></i> GOS Wallet
                    </a>
                    <a href="{{ route('customer.addresses') }}" class="sidebar-link">
                        <i class="bi bi-geo-alt-fill"></i> Manage Addresses
                    </a>
                    <a href="{{ route('customer.profile') }}" class="sidebar-link">
                        <i class="bi bi-person-fill"></i> My Profile
                    </a>
                    <a href="{{ route('customer.support.index') }}" class="sidebar-link">
                        <i class="bi bi-chat-square-text-fill"></i> Help & Support
                    </a>
                    <hr>
                    <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        {{-- Order Details --}}
        <div class="col-lg-9">
            @php $order = \App\Models\Order::with(['items','location','address'])->find($id); @endphp
            @if($order)
            <div class="glass-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Order Details</h5>
                    <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-success btn-sm rounded-pill">← Back to List</a>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="small text-muted">ORDER NUMBER</div>
                        <div class="fw-bold text-success">#{{ $order->order_number }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">PLACED ON</div>
                        <div class="fw-bold">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">PAYMENT METHOD</div>
                        <div class="fw-bold text-uppercase">{{ str_replace('_',' ',$order->payment_method) }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">STATUS</div>
                        @php
                            $statusColors = ['placed'=>'primary','confirmed'=>'info','preparing'=>'warning','packed'=>'secondary','out_for_delivery'=>'dark','delivered'=>'success','cancelled'=>'danger'];
                            $color = $statusColors[$order->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $color }} rounded-pill px-3 py-1">{{ ucfirst(str_replace('_',' ',$order->status)) }}</span>
                    </div>
                </div>

                <hr>

                <h6 class="fw-bold my-3">Items Summary</h6>
                @foreach($order->items as $item)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <div class="fw-semibold">{{ $item->product_name }}</div>
                        @if($item->variant_name)
                            <span class="badge bg-light text-dark border">{{ $item->variant_name }}</span>
                        @endif
                        <div class="text-muted small">₹{{ number_format($item->price, 0) }} x {{ $item->quantity }}</div>
                    </div>
                    <div class="fw-bold text-success">₹{{ number_format($item->total, 0) }}</div>
                </div>
                @endforeach

                <div class="mt-4 text-end">
                    <div class="d-flex justify-content-between mb-2 small">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($order->subtotal, 0) }}</span>
                    </div>
                    @if($order->discount > 0)
                    <div class="d-flex justify-content-between mb-2 small text-danger">
                        <span>Discount</span>
                        <span>-₹{{ number_format($order->discount, 0) }}</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between mb-2 small">
                        <span>GST (5%)</span>
                        <span>₹{{ number_format($order->tax, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span>Delivery Fee</span>
                        <span>₹{{ number_format($order->delivery_fee, 0) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Grand Total</span>
                        <span class="fw-bold fs-5 text-success">₹{{ number_format($order->total, 0) }}</span>
                    </div>
                </div>

                @if($order->status !== 'delivered' && $order->status !== 'cancelled')
                <div class="text-center mt-4">
                    <a href="{{ route('customer.orders.track', $order->id) }}" class="btn btn-warning btn-lg w-100 rounded-pill"><i class="bi bi-geo-alt me-1"></i> Live Order Tracking</a>
                </div>
                @endif
            </div>
            @else
            <div class="alert alert-danger">Order not found.</div>
            @endif
        </div>
    </div>
</div>
@endsection
