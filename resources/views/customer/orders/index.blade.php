@extends('layouts.app')

@section('title', 'My Orders — GOS MOMO')

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

        {{-- Orders --}}
        <div class="col-lg-9">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4">Order History</h5>

                @php $orders = \App\Models\Order::where('user_id', Auth::id())->latest()->get(); @endphp
                @forelse($orders as $order)
                <div class="d-flex flex-wrap justify-content-between align-items-center border-bottom py-3 gap-2">
                    <div>
                        <div class="fw-bold text-success">Order #{{ $order->order_number }}</div>
                        <div class="text-muted small">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                        <div class="small text-dark mt-1">{{ $order->items->count() }} item(s)</div>
                    </div>
                    <div class="text-md-end">
                        <div class="fw-bold text-dark">₹{{ number_format($order->total, 0) }}</div>
                        @php
                            $statusColors = ['placed'=>'primary','confirmed'=>'info','preparing'=>'warning','packed'=>'secondary','out_for_delivery'=>'dark','delivered'=>'success','cancelled'=>'danger'];
                            $color = $statusColors[$order->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $color }} rounded-pill px-3 py-1">{{ ucfirst(str_replace('_',' ',$order->status)) }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-outline-success btn-sm rounded-pill">Details</a>
                        @if($order->status !== 'delivered' && $order->status !== 'cancelled')
                            <a href="{{ route('customer.orders.track', $order->id) }}" class="btn btn-warning btn-sm rounded-pill"><i class="bi bi-geo-alt"></i> Track</a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-bag-x fs-1 mb-2 d-block opacity-25"></i>
                    <p>No orders yet.</p>
                    <a href="{{ route('menu.index') }}" class="btn btn-premium btn-sm rounded-pill">Order Now</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
