@extends('layouts.app')

@section('title', 'Track Order — GOS MOMO')

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
.track-timeline {
    position: relative;
    padding-left: 40px;
}
.track-timeline::before {
    content: '';
    position: absolute; left: 15px; top: 0; bottom: 0;
    width: 4px; background: #e9ecef;
}
.track-node {
    position: relative;
    margin-bottom: 30px;
}
.track-node::before {
    content: '';
    position: absolute; left: -32px; top: 3px;
    width: 18px; height: 18px; border-radius: 50%;
    background: #ced4da; border: 4px solid #fff;
    box-shadow: 0 0 0 3px #ced4da;
}
.track-node.active::before {
    background: #0F5132; box-shadow: 0 0 0 3px #0F5132;
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

        {{-- Tracking Panel --}}
        <div class="col-lg-9">
            @php $order = \App\Models\Order::with(['tracking'])->find($id); @endphp
            @if($order)
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Live Order Tracking</h5>
                    <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-outline-success btn-sm rounded-pill">Details</a>
                </div>

                <div class="text-center p-4 bg-success-subtle text-success rounded-4 mb-4">
                    <h6 class="fw-bold mb-1">Estimated Delivery Time</h6>
                    <h2 class="fw-extrabold mb-0">25 - 35 Mins</h2>
                    <small class="text-muted">Preparing fresh momos at our Lucknow kitchen</small>
                </div>

                {{-- Status Timeline --}}
                <div class="track-timeline">
                    @php
                        $statuses = ['placed', 'confirmed', 'preparing', 'packed', 'out_for_delivery', 'delivered'];
                        $currentIndex = array_search($order->status, $statuses);
                        $currentIndex = $currentIndex === false ? 0 : $currentIndex;
                    @endphp

                    @foreach([
                        ['status' => 'placed', 'title' => 'Order Placed', 'desc' => 'Your order has been recorded successfully.'],
                        ['status' => 'confirmed', 'title' => 'Order Confirmed', 'desc' => 'The kitchen has accepted your order.'],
                        ['status' => 'preparing', 'title' => 'Preparing', 'desc' => 'Our chefs are steaming/frying your momos.'],
                        ['status' => 'packed', 'title' => 'Packed', 'desc' => 'Food packed hot and handed over to driver.'],
                        ['status' => 'out_for_delivery', 'title' => 'Out for Delivery', 'desc' => 'Our delivery partner is on the way.'],
                        ['status' => 'delivered', 'title' => 'Delivered', 'desc' => 'Enjoy your delicious hot momos!'],
                    ] as $i => $step)
                    <div class="track-node {{ $i <= $currentIndex ? 'active' : '' }}">
                        <h6 class="fw-bold mb-1 {{ $i <= $currentIndex ? 'text-success' : 'text-muted' }}">{{ $step['title'] }}</h6>
                        <p class="text-muted small mb-0">{{ $step['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="alert alert-danger">Order not found.</div>
            @endif
        </div>
    </div>
</div>
@endsection
