@extends('layouts.app')

@section('title', 'Our Story — GOS MOMO')

@section('styles')
<style>
/* Mobile background */
@media (max-width: 575.98px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/story-mobile.jpg') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
/* Tablet background */
@media (min-width: 576px) and (max-width: 991.98px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/story-tablet.png') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
/* Laptop background */
@media (min-width: 992px) and (max-width: 1199.98px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/story-laptop.png') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
/* Desktop background */
@media (min-width: 1200px) {
    .page-hero {
        background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/story-desktop.jpg') }}') !important;
        background-size: cover !important;
        background-position: center !important;
    }
}
.story-img-wrap {
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(15,81,50,0.15);
}
.story-img-wrap img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    display: block;
    transition: var(--transition-smooth);
}
@media (max-width: 991.98px) {
    .story-img-wrap img {
        height: 320px !important;
    }
}
@media (max-width: 575.98px) {
    .story-img-wrap img {
        height: 240px !important;
    }
}
.story-timeline {
    position: relative;
    max-width: 800px;
    margin: 60px auto;
    padding-left: 30px;
    border-left: 3px solid #FF7A00;
}
.timeline-item {
    position: relative;
    margin-bottom: 40px;
}
.timeline-item::before {
    content: '';
    position: absolute;
    left: -38px;
    top: 5px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #FF7A00;
    border: 3px solid #FF7A00;
}
</style>
@endsection

@section('content')
<section class="page-hero text-center">
    <div class="container" data-aos="fade-up">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3 text-uppercase">The Journey</span>
        <h1 class="display-4 fw-extrabold text-white mb-2">Our Story</h1>
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Our Story</li>
            </ol>
        </nav>
        <p class="lead text-white-75 max-width-600 mx-auto">From a small seed of passion for authentic flavors to India's next big food franchise.</p>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="story-img-wrap">
                    <img src="https://images.unsplash.com/photo-1625220194771-7ebedd0b4d11?auto=format&fit=crop&w=800&q=80" alt="Premium Momos Prep" class="w-100 img-fluid" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1563245372-f21724e3856d?auto=format&fit=crop&w=800&q=80';">
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="text-success fw-bold text-uppercase tracking-wider">How It Began</span>
                <h2 class="fw-bold text-primary-color mt-2 mb-4">Born from a Passion for Premium Taste</h2>
                <p class="text-muted">GOS MOMO started with a simple belief: street food deserves the highest level of hygiene, flavor, and visual appeal. We noticed that while momos are loved by millions across India, they are often prepared in unhygienic conditions or lack consistent quality.</p>
                <p class="text-muted">We set out to change that by crafting premium momos using fresh ingredients, thin wrapper dough, and signature home-style dipping sauces. Every single plate is made to order with love and precision.</p>
                <div class="row g-3 mt-4">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3 border-start border-4 border-success">
                            <h4 class="fw-bold text-success mb-1">100%</h4>
                            <span class="small text-muted">Fresh & Hygienic</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3 border-start border-4 border-warning">
                            <h4 class="fw-bold text-warning mb-1">Signature</h4>
                            <span class="small text-muted">Chutney Recipes</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold text-primary-color">Our Timeline</h2>
            <p class="text-muted">Important milestones in our growth journey</p>
        </div>

        <div class="story-timeline" data-aos="fade-up">
            <div class="timeline-item">
                <h5 class="fw-bold text-success">2024 — The Spark</h5>
                <p class="text-muted">Mahoksh Core conceptualized the GOS MOMO brand in Noida, India, aiming to revolutionize the street food industry with clean, franchise-scalable models.</p>
            </div>
            <div class="timeline-item">
                <h5 class="fw-bold text-success">2025 — Lucknow Launch</h5>
                <p class="text-muted">Launched our first pilot Lucknow Cart, serving hundreds of happy customers daily and refining our operating procedures for rapid expansion.</p>
            </div>
            <div class="timeline-item">
                <h5 class="fw-bold text-success">2026 — Digital Transformation & Expansion</h5>
                <p class="text-muted">Introduced a complete digital ordering system, custom wallet features, and franchise application dashboards to expand to 50+ locations across India.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white text-center">
    <div class="container py-5" data-aos="zoom-in">
        <h2 class="fw-bold text-primary-color mb-3">Join Our Journey</h2>
        <p class="text-muted mb-4 max-width-600 mx-auto">We are looking for passionate franchise partners to grow with us. Bring the taste of GOS MOMO to your city.</p>
        <a href="{{ route('franchise.index') }}" class="btn btn-premium btn-lg">Apply for Franchise</a>
    </div>
</section>
@endsection
