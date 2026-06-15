@extends('layouts.app')

@section('title', 'Franchise Portal — GOS MOMO')

@section('styles')
<style>
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
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row g-4">
        {{-- Sidebar --}}
        <div class="col-lg-3">
            <div class="fran-sidebar">
                <div class="text-center mb-4">
                    <div style="width:70px; height:70px; border-radius:50%; background: linear-gradient(135deg, #FF7A00, #FF7A00); color:white; display:flex; align-items:center; justify-content:center; font-size:30px; font-weight:700; margin: 0 auto 12px;">
                        🏢
                    </div>
                    <h5 class="fw-bold mb-1">Franchise Partner</h5>
                    <span class="badge bg-warning text-dark rounded-pill px-3">{{ Auth::user()->name }}</span>
                </div>
                <hr>
                <div class="d-flex flex-column gap-1">
                    <a href="{{ route('franchise.dashboard') }}" class="sidebar-link active">
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
                    <a href="{{ route('franchise.opportunities') }}" class="sidebar-link">
                        <i class="bi bi-geo-alt-fill"></i> Expansion Zones
                    </a>
                    <hr>
                    <a href="{{ route('logout') }}" class="sidebar-link text-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        {{-- Main dashboard --}}
        <div class="col-lg-9">
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="glass-card p-4">
                        <h6 class="text-muted fw-bold">Active Outlets</h6>
                        <h2 class="fw-extrabold text-success">1 Active</h2>
                        <small class="text-muted">Lucknow Cart #1</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-card p-4">
                        <h6 class="text-muted fw-bold">Daily Orders</h6>
                        <h2 class="fw-extrabold text-primary">148</h2>
                        <small class="text-muted">Today's count</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-card p-4">
                        <h6 class="text-muted fw-bold">Gross Sales (MTD)</h6>
                        <h2 class="fw-extrabold text-warning">₹4,12,500</h2>
                        <small class="text-muted">Month to date revenue</small>
                    </div>
                </div>
            </div>

            <div class="glass-card p-4 mb-4">
                <h5 class="fw-bold mb-3">Partner Performance Graph</h5>
                <div style="height:250px; background:rgba(0,0,0,0.02); border-radius:12px; display:flex; align-items:center; justify-content:center; border: 1px dashed #ced4da;">
                    <span class="text-muted small"><i class="bi bi-bar-chart me-1"></i> Interactive sales graph will display here.</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
