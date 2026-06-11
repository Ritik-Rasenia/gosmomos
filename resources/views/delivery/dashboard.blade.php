@extends('layouts.app')

@section('title', 'Delivery Partner Dashboard — GOS MOMO')

@section('styles')
<style>
.del-sidebar {
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
            <div class="del-sidebar">
                <div class="text-center mb-4">
                    <div style="width:70px; height:70px; border-radius:50%; background: linear-gradient(135deg, #0F5132, #D4A017); color:white; display:flex; align-items:center; justify-content:center; font-size:30px; font-weight:700; margin: 0 auto 12px;">
                        🚴
                    </div>
                    <h5 class="fw-bold mb-1">Delivery Partner</h5>
                    <span class="badge bg-success text-white rounded-pill px-3">{{ Auth::user()->name }}</span>
                </div>
                <hr>
                <div class="d-flex flex-column gap-1">
                    <a href="{{ route('delivery.dashboard') }}" class="sidebar-link active">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                    <a href="{{ route('delivery.orders') }}" class="sidebar-link">
                        <i class="bi bi-list-check"></i> Orders Pool
                    </a>
                    <a href="{{ route('delivery.active') }}" class="sidebar-link">
                        <i class="bi bi-bicycle"></i> Active Delivery
                    </a>
                    <a href="{{ route('delivery.earnings') }}" class="sidebar-link">
                        <i class="bi bi-currency-rupee"></i> My Earnings
                    </a>
                    <hr>
                    <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        {{-- Main Dashboard --}}
        <div class="col-lg-9">
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="glass-card p-4">
                        <h6 class="text-muted fw-bold">Active Status</h6>
                        <h3 class="fw-extrabold text-success">ONLINE</h3>
                        <small class="text-muted">Receiving nearby orders</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-card p-4">
                        <h6 class="text-muted fw-bold">Today's Deliveries</h6>
                        <h3 class="fw-extrabold text-primary">12 Orders</h3>
                        <small class="text-muted">Completed today</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-card p-4">
                        <h6 class="text-muted fw-bold">Today's Earnings</h6>
                        <h3 class="fw-extrabold text-warning">₹640.00</h3>
                        <small class="text-muted">Including tips</small>
                    </div>
                </div>
            </div>

            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Active / Pending Delivery</h5>
                    <a href="{{ route('delivery.active') }}" class="btn btn-premium btn-sm rounded-pill">Track Active</a>
                </div>
                <div class="text-center py-4 text-muted">
                    <p class="mb-0">No active delivery right now. Go to Orders Pool to pick an order.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
