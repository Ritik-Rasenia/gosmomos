@extends('layouts.app')

@section('title', 'Help & Support — GOS MOMO')

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
    color: #FF7A00;
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
                    <div style="width:70px; height:70px; border-radius:50%; background: linear-gradient(135deg, #FF7A00, #FF7A00); color:white; display:flex; align-items:center; justify-content:center; font-size:30px; font-weight:700; margin: 0 auto 12px;">
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

        {{-- Support Listing --}}
        <div class="col-lg-9">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Support Tickets</h5>
                    <a href="{{ route('customer.support.create') }}" class="btn btn-premium btn-sm rounded-pill">
                        <i class="bi bi-chat-left-text me-1"></i> New Ticket
                    </a>
                </div>

                @php $tickets = \App\Models\SupportTicket::where('user_id', Auth::id())->latest()->get(); @endphp
                @forelse($tickets as $ticket)
                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                    <div>
                        <div class="fw-bold text-dark">{{ $ticket->subject }}</div>
                        <div class="text-muted small">Category: {{ ucfirst($ticket->category) }} • Raised: {{ $ticket->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="text-end">
                        @php
                            $pColors = ['low'=>'secondary','medium'=>'warning','high'=>'danger'];
                            $sColors = ['open'=>'success','resolved'=>'secondary','closed'=>'dark'];
                        @endphp
                        <span class="badge bg-{{ $sColors[$ticket->status] ?? 'secondary' }} rounded-pill px-2 py-1 small">{{ ucfirst($ticket->status) }}</span>
                        <a href="{{ route('customer.support.show', $ticket->id) }}" class="btn btn-outline-success btn-sm rounded-pill ms-2">View</a>
                    </div>
                </div>
                @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-chat-square-dots fs-1 mb-2 d-block opacity-25"></i>
                    <p>No support tickets raised yet.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
