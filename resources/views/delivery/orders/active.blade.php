@extends('layouts.app')

@section('title', 'Active Delivery — GOS MOMO')

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
                    <a href="{{ route('delivery.dashboard') }}" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                    <a href="{{ route('delivery.orders') }}" class="sidebar-link">
                        <i class="bi bi-list-check"></i> Orders Pool
                    </a>
                    <a href="{{ route('delivery.active') }}" class="sidebar-link active">
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

        {{-- Active Delivery details --}}
        <div class="col-lg-9">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4">Active Delivery Details</h5>

                @php $activeOrder = \App\Models\Order::where('status', 'out_for_delivery')->first(); @endphp
                @if($activeOrder)
                <div class="row g-3">
                    <div class="col-md-6">
                        <h6 class="text-muted fw-bold">ORDER NUMBER</h6>
                        <h4 class="fw-bold text-success">#{{ $activeOrder->order_number }}</h4>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted fw-bold">CUSTOMER</h6>
                        <h4 class="fw-bold">{{ $activeOrder->user->name }}</h4>
                        <div class="small text-muted">{{ $activeOrder->user->phone }}</div>
                    </div>
                    <div class="col-12">
                        <h6 class="text-muted fw-bold">DELIVERY ADDRESS</h6>
                        <p class="fw-bold mb-0">{{ $activeOrder->address ? $activeOrder->address->address_line1 : 'N/A' }}, {{ $activeOrder->address ? $activeOrder->address->city : '' }}</p>
                    </div>
                    <div class="col-12 mt-4">
                        <button class="btn btn-success btn-lg w-100 rounded-pill"><i class="bi bi-check-circle me-1"></i> Mark as Delivered</button>
                    </div>
                </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-bicycle fs-1 mb-2 d-block opacity-25"></i>
                    <p class="mb-0">You have no active deliveries right now.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
