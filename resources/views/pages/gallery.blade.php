@extends('layouts.app')

@section('title', 'Gallery — GOS MOMO')

@section('styles')
<style>
.gallery-card {
    border-radius: 16px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    cursor: pointer;
}
.gallery-card:hover {
    transform: scale(1.03);
    box-shadow: 0 15px 40px rgba(15,81,50,0.15);
}
.gallery-overlay {
    position: absolute; inset: 0;
    background: rgba(15, 81, 50, 0.8);
    display: flex; align-items: center; justify-content: center;
    color: white; opacity: 0; transition: opacity 0.3s ease;
}
.gallery-card:hover .gallery-overlay { opacity: 1; }
</style>
@endsection

@section('content')
<section class="page-hero text-center">
    <div class="container" data-aos="fade-up">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3 text-uppercase">Visuals</span>
        <h1 class="display-4 fw-extrabold text-white mb-2">GOS MOMO Gallery</h1>
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Gallery</li>
            </ol>
        </nav>
        <p class="lead text-white-75 max-width-600 mx-auto">Explore visual highlights of our preparations, outlets, events, and dishes.</p>
    </div>
</section>

<div class="container py-5">
    <div class="row g-4">
        @forelse($photos as $photo)
        <div class="col-6 col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
            <div class="gallery-card">
                @if($photo->image_url)
                    <img src="{{ $photo->image_url }}" alt="{{ $photo->title }}" class="w-100 h-100" style="object-fit:cover; min-height: 250px;">
                @else
                    <div style="min-height:250px; background:linear-gradient(135deg, #FF7A00, #FF7A00); display:flex; align-items:center; justify-content:center; font-size:60px;">🥟</div>
                @endif
                <div class="gallery-overlay p-3 text-center">
                    <div>
                        <h6 class="fw-bold mb-1">{{ $photo->title }}</h6>
                        <p class="small mb-0">{{ $photo->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        @empty
        {{-- Static Placeholder Gallery --}}
        @foreach(['🥟 Delicious Steamed Momos','🔥 Crispy Kurkure Momos','🍢 Fresh Tandoori Skewers','👨‍🍳 Our Master Chefs','📍 Lucknow Cart Launch','✨ Live Catering Buffet'] as $i => $item)
        <div class="col-6 col-md-4" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
            <div class="gallery-card">
                <div style="min-height: 250px; background: linear-gradient({{ $i*45 }}deg, #FF7A00, #FF7A00); display: flex; align-items: center; justify-content: center; font-size: 60px;">
                    {{ ['🥟','🔥','🍢','👨‍🍳','📍','✨'][$i] }}
                </div>
                <div class="gallery-overlay p-3 text-center">
                    <div>
                        <h6 class="fw-bold mb-1">{{ $item }}</h6>
                        <p class="small mb-0">Premium quality street food experience</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endforelse
    </div>
</div>
@endsection
