@extends('layouts.app')

@section('title', 'Expansion Zones — GOS MOMO')

@section('styles')
.fran-sidebar {
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
    background: rgba(212, 160, 23, 0.08);
    color: #B38613;
}
@endsection

@section('content')
<div class="container py-5">
    <div class="row g-4">
        {{-- Sidebar --}}
        <div class="col-lg-3">
            <div class="fran-sidebar">
                <div class="text-center mb-4">
                    <div style="width:70px; height:70px; border-radius:50%; background: linear-gradient(135deg, #0F5132, #D4A017); color:white; display:flex; align-items:center; justify-content:center; font-size:30px; font-weight:700; margin: 0 auto 12px;">
                        🏢
                    </div>
                    <h5 class="fw-bold mb-1">Franchise Partner</h5>
                    <span class="badge bg-warning text-dark rounded-pill px-3">{{ Auth::user()->name }}</span>
                </div>
                <hr>
                <div class="d-flex flex-column gap-1">
                    <a href="{{ route('franchise.dashboard') }}" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                    <a href="{{ route('franchise.roi') }}" class="sidebar-link">
                        <i class="bi bi-calculator-fill"></i> ROI Calculator
                    </a>
                    <a href="{{ route('franchise.training') }}" class="sidebar-link">
                        <i class="bi bi-journal-bookmark-fill"></i> Training Academy
                    </a>
                    <a href="{{ route('franchise.documents') }}" class="sidebar-link">
                        <i class="bi bi-file-earmark-lock-fill"></i> Legal Documents
                    </a>
                    <a href="{{ route('franchise.opportunities') }}" class="sidebar-link active">
                        <i class="bi bi-geo-alt-fill"></i> Expansion Zones
                    </a>
                    <hr>
                    <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        {{-- Expansion Zones --}}
        <div class="col-lg-9">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4">Expansion Zones & Target Cities</h5>
                <p class="text-muted">Explore high priority locations for GOS MOMO expansions where we support local logistics and supply chain.</p>

                <div class="row g-3">
                    @foreach([
                        ['city' => 'Lucknow', 'zones' => 'Hazratganj, Gomti Nagar, Aliganj', 'status' => 'High Demand'],
                        ['city' => 'Noida', 'zones' => 'Sector 62, Sector 18, Sector 137', 'status' => 'Head Office Support'],
                        ['city' => 'Kanpur', 'zones' => 'Kalyanpur, Swaroop Nagar', 'status' => 'Open for Booking'],
                    ] as $zone)
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-4 h-100">
                            <h6 class="fw-bold text-success mb-1">{{ $zone['city'] }}</h6>
                            <span class="badge bg-warning text-dark mb-3 small">{{ $zone['status'] }}</span>
                            <div class="small text-muted"><strong>Target Areas:</strong> {{ $zone['zones'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
