@extends('layouts.app')

@section('title', 'Ticket Details — GOS MOMO')

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
                    <a href="{{ route('customer.support.index') }}" class="sidebar-link active">
                        <i class="bi bi-chat-square-text-fill"></i> Help & Support
                    </a>
                    <hr>
                    <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        {{-- Ticket details --}}
        <div class="col-lg-9">
            @php $ticket = \App\Models\SupportTicket::find($id); @endphp
            @if($ticket)
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Ticket Details</h5>
                    <a href="{{ route('customer.support.index') }}" class="btn btn-outline-success btn-sm rounded-pill">← Back to List</a>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="small text-muted">SUBJECT</div>
                        <div class="fw-bold text-success">{{ $ticket->subject }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">CATEGORY</div>
                        <div class="fw-bold text-uppercase">{{ str_replace('_',' ',$ticket->category) }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">PRIORITY</div>
                        <div class="fw-bold text-uppercase">{{ $ticket->priority }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">STATUS</div>
                        @php
                            $sColors = ['open'=>'success','resolved'=>'secondary','closed'=>'dark'];
                        @endphp
                        <span class="badge bg-{{ $sColors[$ticket->status] ?? 'secondary' }} rounded-pill px-3 py-1">{{ ucfirst($ticket->status) }}</span>
                    </div>
                </div>

                <hr>

                <h6 class="fw-bold mb-3">Ticket Activity & Thread</h6>
                <div class="p-3 bg-light rounded-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-dark">{{ Auth::user()->name }}</span>
                        <span class="text-muted small">{{ $ticket->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    <p class="text-muted mb-0 small">{{ $ticket->description }}</p>
                </div>
            </div>
            @else
            <div class="alert alert-danger">Ticket not found.</div>
            @endif
        </div>
    </div>
</div>
@endsection
