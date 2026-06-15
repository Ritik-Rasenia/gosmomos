@extends('layouts.app')

@section('title', 'Orders Pool — GOS MOMO')

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
    color: #FF7A00;
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
                    <div style="width:70px; height:70px; border-radius:50%; background: linear-gradient(135deg, #FF7A00, #FF7A00); color:white; display:flex; align-items:center; justify-content:center; font-size:30px; font-weight:700; margin: 0 auto 12px;">
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
                    <a href="{{ route('delivery.orders') }}" class="sidebar-link active">
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

        {{-- Orders Pool --}}
        <div class="col-lg-9">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4">Orders Pool (Ready for Pickup)</h5>

                @forelse($poolOrders as $order)
                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                    <div>
                        <div class="fw-bold text-success">Order #{{ $order->order_number }}</div>
                        <div class="text-muted small">
                            <strong>Pickup:</strong> {{ $order->location->name }}<br>
                            <strong>Delivery:</strong> {{ $order->address ? $order->address->address_line_1 : 'Self Pickup' }}, {{ $order->address ? $order->address->city : '' }}
                        </div>
                    </div>
                    <div>
                        <form action="{{ route('delivery.orders.accept', $order->id) }}" method="POST" class="accept-order-form">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm rounded-pill px-3"><i class="bi bi-check-lg me-1"></i> Accept Delivery</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-bell-slash fs-1 mb-2 d-block opacity-25"></i>
                    <p class="mb-0">No orders ready for pickup right now.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.accept-order-form').on('submit', function(e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: 'Accept this delivery?',
            text: "You will be assigned to deliver this order.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#FF7A00',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Accept It!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection
