@extends('layouts.app')

@section('title', 'Locations — GOS MOMO')

@section('styles')
<style>
/* Mobile background */
@media (max-width: 575.98px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/location-mobile.jpg') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
/* Tablet background */
@media (min-width: 576px) and (max-width: 991.98px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/location-tablet.png') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
/* Laptop background */
@media (min-width: 992px) and (max-width: 1199.98px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/location-laptop.png') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
/* Desktop background */
@media (min-width: 1200px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/location-desktop.jpg') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
.loc-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    background: white;
    overflow: hidden;
}
.loc-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(15,81,50,0.12);
}
.loc-icon {
    width: 60px; height: 60px;
    border-radius: 16px;
    background: rgba(15, 81, 50, 0.1);
    color: #FF7A00;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
}
</style>
@endsection

@section('content')
<section class="page-hero text-center">
    <div class="container" data-aos="fade-up">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3 text-uppercase">Find Us</span>
        <h1 class="display-4 fw-extrabold text-white mb-2">Our Locations</h1>
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Locations</li>
            </ol>
        </nav>
        <p class="lead text-white-75 max-width-600 mx-auto">Find the nearest GOS MOMO outlet or cart and satisfy your cravings!</p>
    </div>
</section>

<div class="container py-5">
    <div class="row g-4">
        @forelse($locations as $loc)
        <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="loc-card h-100 d-flex flex-column justify-content-between">
                <div>
                    @if($loc->image)
                        <img src="{{ asset('storage/' . $loc->image) }}" alt="{{ $loc->name }}" class="w-100" style="height: 220px; object-fit: cover;">
                    @else
                        <img src="https://images.unsplash.com/photo-1528605248644-14dd04022da1?auto=format&fit=crop&w=600&q=80" alt="{{ $loc->name }}" class="w-100" style="height: 220px; object-fit: cover;">
                    @endif
                    <div class="p-4">
                        <div class="d-flex align-items-start gap-3 mb-2">
                            <div class="loc-icon flex-shrink-0">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold text-primary-color mb-1">{{ $loc->name }}</h4>
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 mb-3">{{ ucfirst($loc->type) }}</span>
                                <p class="text-muted mb-2"><i class="bi bi-map me-2"></i>{{ $loc->address }}, {{ $loc->city }}</p>
                                @if($loc->phone)
                                    <p class="text-muted mb-2"><i class="bi bi-telephone me-2"></i>{{ $loc->phone }}</p>
                                @endif
                                @if($loc->opening_time && $loc->closing_time)
                                    <p class="text-muted mb-0"><i class="bi bi-clock me-2"></i>{{ date('h:i A', strtotime($loc->opening_time)) }} - {{ date('h:i A', strtotime($loc->closing_time)) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 pb-4">
                    <a href="https://maps.google.com/?q={{ urlencode($loc->name . ' ' . $loc->address . ' ' . $loc->city) }}" target="_blank" class="btn btn-outline-success rounded w-100">
                        <i class="bi bi-compass me-1"></i> Get Directions
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div style="font-size: 80px;">📍</div>
            <h4 class="fw-bold mt-3">No locations available right now</h4>
            <p class="text-muted">We are setting up new locations soon. Stay tuned!</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
