@extends('layouts.app')

@section('title', 'My Earnings — GOS MOMO')

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
                    <a href="{{ route('delivery.active') }}" class="sidebar-link">
                        <i class="bi bi-bicycle"></i> Active Delivery
                    </a>
                    <a href="{{ route('delivery.earnings') }}" class="sidebar-link active">
                        <i class="bi bi-currency-rupee"></i> My Earnings
                    </a>
                    <hr>
                    <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        {{-- Earnings Panel --}}
        <div class="col-lg-9">
            <div class="glass-card p-4 mb-4 text-center text-white" style="background: linear-gradient(135deg, #0F5132, #157347);">
                <h6 class="text-white-50 fw-bold mb-1">TOTAL EARNINGS (THIS WEEK)</h6>
                <h1 class="fw-extrabold mb-0">₹4,250.00</h1>
            </div>

            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4">Payout History</h5>
                @foreach([
                    ['date' => '05 Jun 2026', 'amount' => '₹1,240.00', 'desc' => 'Direct Bank Transfer', 'status' => 'Paid'],
                    ['date' => '29 May 2026', 'amount' => '₹1,500.00', 'desc' => 'Direct Bank Transfer', 'status' => 'Paid'],
                    ['date' => '22 May 2026', 'amount' => '₹1,510.00', 'desc' => 'Direct Bank Transfer', 'status' => 'Paid'],
                ] as $payout)
                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                    <div>
                        <div class="fw-bold text-dark">{{ $payout['desc'] }}</div>
                        <div class="text-muted small">Date: {{ $payout['date'] }}</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold fs-5 text-success">{{ $payout['amount'] }}</div>
                        <span class="badge bg-success-subtle text-success">{{ $payout['status'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
