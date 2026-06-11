@extends('layouts.app')

@section('title', 'Legal Documents — GOS MOMO')

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
                    <a href="{{ route('franchise.documents') }}" class="sidebar-link active">
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

        {{-- Documents --}}
        <div class="col-lg-9">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4">Legal Documents & Agreements</h5>

                @foreach([
                    ['title'=>'Franchise Agreement Lucknow Cart #1','date'=>'15 Jan 2025','size'=>'2.4 MB'],
                    ['title'=>'Mutual NDA (Non-disclosure Agreement)','date'=>'12 Jan 2025','size'=>'1.1 MB'],
                    ['title'=>'Brand License & NOC','date'=>'18 Jan 2025','size'=>'850 KB'],
                ] as $doc)
                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                    <div>
                        <div class="fw-bold text-dark">{{ $doc['title'] }}</div>
                        <div class="text-muted small">Signed on: {{ $doc['date'] }} • Size: {{ $doc['size'] }}</div>
                    </div>
                    <div>
                        <button class="btn btn-outline-success btn-sm rounded-pill"><i class="bi bi-download me-1"></i> Download</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
