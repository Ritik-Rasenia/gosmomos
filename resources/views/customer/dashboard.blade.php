@extends('layouts.app')

@section('title', 'Customer Dashboard — GOS MOMO')

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
                    <a href="{{ route('customer.dashboard') }}" class="sidebar-link active">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                    <a href="{{ route('customer.orders.index') }}" class="sidebar-link">
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

        {{-- Main Content --}}
        <div class="col-lg-9">
            <div class="row g-4 mb-4">
                @php
                    $walletBal = Auth::user()->wallet ? Auth::user()->wallet->balance : 0.00;
                    $ordersCount = \App\Models\Order::where('user_id', Auth::id())->count();
                @endphp
                <div class="col-md-6">
                    <div class="glass-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-muted mb-0 fw-bold">GOS Wallet</h6>
                            <i class="bi bi-wallet2 text-success fs-3"></i>
                        </div>
                        <h2 class="fw-bold text-success">₹{{ number_format($walletBal, 2) }}</h2>
                        <a href="{{ route('customer.wallet') }}" class="btn btn-premium btn-sm rounded-pill mt-2">Add Funds</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="glass-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-muted mb-0 fw-bold">Total Orders</h6>
                            <i class="bi bi-bag-check text-warning fs-3"></i>
                        </div>
                        <h2 class="fw-bold text-warning">{{ $ordersCount }} Orders</h2>
                        <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-warning btn-sm rounded-pill mt-2">View Orders</a>
                    </div>
                </div>
            </div>

            {{-- Recent Orders --}}
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4">Recent Orders</h5>
                @php $recent = \App\Models\Order::where('user_id', Auth::id())->latest()->take(3)->get(); @endphp
                @forelse($recent as $order)
                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                    <div>
                        <div class="fw-bold text-success">Order #{{ $order->order_number }}</div>
                        <div class="text-muted small">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-dark">₹{{ number_format($order->total, 0) }}</div>
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div>
                        <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-outline-success btn-sm rounded-pill">Details</a>
                        @if($order->status !== 'delivered' && $order->status !== 'cancelled')
                            <a href="{{ route('customer.orders.track', $order->id) }}" class="btn btn-warning btn-sm rounded-pill"><i class="bi bi-geo-alt"></i> Track</a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <p>No orders placed yet.</p>
                    <a href="{{ route('menu.index') }}" class="btn btn-premium btn-sm rounded-pill">Order Now</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
