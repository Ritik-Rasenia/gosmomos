@extends('layouts.app')

@section('title', 'GOS Wallet — GOS MOMO')

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
.wallet-box {
    background: linear-gradient(135deg, #FF7A00 0%, #E26C00 100%);
    color: white;
    border-radius: 24px;
    padding: 35px;
    box-shadow: 0 10px 30px rgba(15,81,50,0.2);
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
                    <a href="{{ route('customer.wallet') }}" class="sidebar-link active">
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

        {{-- Wallet Main Panel --}}
        <div class="col-lg-9">
            <div class="wallet-box mb-4">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h6 class="text-white-50 fw-semibold mb-1">CURRENT BALANCE</h6>
                        <h1 class="fw-extrabold mb-3">₹{{ number_format(Auth::user()->wallet ? Auth::user()->wallet->balance : 0.00, 2) }}</h1>
                        <p class="small text-white-50 mb-0">Use wallet funds for instant refunds and super fast checkouts with no OTP dependencies.</p>
                    </div>
                    <div class="col-md-5 text-md-end mt-3 mt-md-0">
                        <button class="btn btn-gold btn-lg rounded-pill" data-bs-toggle="modal" data-bs-target="#addFundsModal">
                            <i class="bi bi-plus-circle me-1"></i> Add Funds
                        </button>
                    </div>
                </div>
            </div>

            {{-- Transactions --}}
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4">Transaction History</h5>

                @php $transactions = Auth::user()->wallet ? Auth::user()->wallet->transactions()->latest()->get() : collect(); @endphp
                @forelse($transactions as $tx)
                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                    <div>
                        <div class="fw-semibold text-dark">{{ $tx->description }}</div>
                        <div class="text-muted small">{{ $tx->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold fs-5 {{ $tx->type === 'credit' ? 'text-success' : 'text-danger' }}">
                            {{ $tx->type === 'credit' ? '+' : '-' }}₹{{ number_format($tx->amount, 2) }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-clock-history fs-1 mb-2 d-block opacity-25"></i>
                    <p>No transactions made yet.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Add Funds Modal -->
<div class="modal fade" id="addFundsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 bg-success text-white py-3" style="border-radius:16px 16px 0 0;">
                <h5 class="modal-title fw-bold">Add Wallet Funds</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Enter Amount (INR)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold">₹</span>
                            <input type="number" name="amount" class="form-control rounded-3" placeholder="500" min="10" required>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mb-3">
                        <button type="button" class="btn btn-outline-success btn-sm rounded-pill flex-fill" onclick="$('input[name=amount]').val(100)">+ ₹100</button>
                        <button type="button" class="btn btn-outline-success btn-sm rounded-pill flex-fill" onclick="$('input[name=amount]').val(500)">+ ₹500</button>
                        <button type="button" class="btn btn-outline-success btn-sm rounded-pill flex-fill" onclick="$('input[name=amount]').val(1000)">+ ₹1000</button>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-premium rounded-pill px-4">Pay & Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
