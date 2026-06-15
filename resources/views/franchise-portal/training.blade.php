@extends('layouts.app')

@section('title', 'Training Academy — GOS MOMO')

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
                    <a href="{{ route('franchise.dashboard') }}" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                    <a href="{{ route('franchise.roi') }}" class="sidebar-link">
                        <i class="bi bi-calculator-fill"></i> ROI Calculator
                    </a>
                    <a href="{{ route('franchise.training') }}" class="sidebar-link active">
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

        {{-- Training academy --}}
        <div class="col-lg-9">
            <div class="glass-card p-4">
                <h5 class="fw-bold mb-4">Training Academy</h5>
                <p class="text-muted">Standard Operating Procedures (SOP), kitchen manuals, preparation guides, and customer service standards.</p>

                <div class="row g-3">
                    @foreach([
                        ['icon'=>'bi-file-earmark-pdf-fill','title'=>'Kitchen Prep & Hygiene Manual','desc'=>'SOP for kitchen cleaning, raw material storage, and hygiene standards.','type'=>'PDF Document','color'=>'#E63946'],
                        ['icon'=>'bi-play-btn-fill','title'=>'Signature Momo Steaming SOP','desc'=>'Video tutorial on perfect dough folding and steaming timeline.','type'=>'Video Course','color'=>'#FF7A00'],
                        ['icon'=>'bi-people-fill','title'=>'Billing & POS System Guide','desc'=>'How to use the custom GOS POS system and process online orders.','type'=>'User Guide','color'=>'#FF7A00'],
                    ] as $course)
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <i class="bi {{ $course['icon'] }} fs-1 mb-2 d-block" style="color: {{ $course['color'] }}"></i>
                                <h6 class="fw-bold mb-1">{{ $course['title'] }}</h6>
                                <p class="text-muted small mb-3">{{ $course['desc'] }}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-secondary-subtle text-secondary small">{{ $course['type'] }}</span>
                                <a href="#" class="btn btn-premium btn-sm rounded-pill">Start Learning</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
