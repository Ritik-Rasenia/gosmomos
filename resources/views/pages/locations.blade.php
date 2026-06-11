@extends('layouts.app')

@section('title', 'Locations — GOS MOMO')

@section('styles')
<style>
.location-hero {
    background: linear-gradient(135deg, #0F5132 0%, #157347 100%);
    padding: 80px 0 40px;
    color: white;
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
    color: #0F5132;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
}
</style>
@endsection

@section('content')
<div class="location-hero text-center">
    <div class="container">
        <h1 class="fw-bold">Our Locations</h1>
        <p class="text-white-75 mb-0">Find the nearest GOS MOMO outlet or cart and satisfy your cravings!</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        @forelse($locations as $loc)
        <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="loc-card p-4 h-100 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-start gap-3 mb-4">
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
                <div>
                    <a href="https://maps.google.com/?q={{ urlencode($loc->name . ' ' . $loc->address . ' ' . $loc->city) }}" target="_blank" class="btn btn-outline-success rounded-pill w-100">
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
