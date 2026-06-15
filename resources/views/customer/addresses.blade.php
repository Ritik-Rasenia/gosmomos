@extends('layouts.app')

@section('title', 'Manage Addresses — GOS MOMO')

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
.address-item {
    background: white;
    border-radius: 16px;
    border: 1px solid rgba(0,0,0,0.06);
    padding: 20px;
    margin-bottom: 15px;
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
                    <a href="{{ route('customer.addresses') }}" class="sidebar-link active">
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

        {{-- Addresses --}}
        <div class="col-lg-9">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">My Saved Addresses</h5>
                    <button class="btn btn-premium btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                        <i class="bi bi-plus-lg me-1"></i> Add Address
                    </button>
                </div>

                @if(session('success'))
                    <div class="alert alert-success rounded-3 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @php $addresses = Auth::user()->addresses; @endphp
                @forelse($addresses as $addr)
                <div class="address-item d-flex justify-content-between align-items-start">
                    <div>
                        <span class="badge bg-success mb-2">{{ ucfirst($addr->label) }}</span>
                        <div class="fw-bold text-dark">{{ $addr->address_line_1 }}</div>
                        <div class="text-muted small">{{ $addr->city }}, {{ $addr->state }} - {{ $addr->pincode }}</div>
                    </div>
                    <div>
                        <button class="btn btn-link text-danger p-0 small" onclick="deleteAddress({{ $addr->id }})">
                            <i class="bi bi-trash3"></i> Delete
                        </button>
                    </div>
                </div>
                @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-geo-alt fs-1 mb-2 d-block opacity-25"></i>
                    <p>No addresses saved yet.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 bg-success text-white py-3" style="border-radius:16px 16px 0 0;">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Add Delivery Address</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('customer.addresses.store') }}" method="POST" id="add-address-form">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Address Type</label>
                        <select name="label" class="form-select rounded-3" required>
                            <option value="home">Home</option>
                            <option value="work">Work / Office</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Street Address / Flat No *</label>
                        <input type="text" name="address_line_1" class="form-control rounded-3" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold small">City *</label>
                            <input type="text" name="city" class="form-control rounded-3" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold small">State *</label>
                            <input type="text" name="state" class="form-control rounded-3" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Postal Code / PIN *</label>
                            <input type="text" name="pincode" class="form-control rounded-3" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-premium rounded-pill px-4">Save Address</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Hidden Delete Form --}}
<form id="delete-address-form" action="" method="POST" class="d-none">
    @csrf
</form>

@endsection

@section('scripts')
<script>
function deleteAddress(id) {
    Swal.fire({
        title: 'Delete Address?',
        text: 'Are you sure you want to delete this saved address?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FF7A00',
        cancelButtonColor: '#0E101A',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('delete-address-form');
            form.action = `/customer/addresses/delete/${id}`;
            form.submit();
        }
    });
}
</script>
@endsection
