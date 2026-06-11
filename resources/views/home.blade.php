@extends('layouts.app')

@section('title', 'GOS MOMO — The Taste India Will Queue For')

@section('styles')
<style>
/* =====================
   HERO SECTION
   ===================== */
.hero-section {
    min-height: 100vh;
    background: linear-gradient(135deg, #0a3620 0%, #0F5132 40%, #1a6b42 100%);
    position: relative;
    display: flex;
    align-items: center;
    overflow: hidden;
}
.hero-section::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='30'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    animation: float 20s linear infinite;
}
@keyframes float { 0% { background-position: 0 0; } 100% { background-position: 60px 60px; } }

.hero-badge {
    display: inline-block;
    background: rgba(212, 160, 23, 0.2);
    border: 1px solid rgba(212, 160, 23, 0.5);
    color: #D4A017;
    padding: 6px 18px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 20px;
    animation: pulse-glow 2s ease-in-out infinite;
}
@keyframes pulse-glow {
    0%, 100% { box-shadow: 0 0 0 0 rgba(212,160,23,0.3); }
    50% { box-shadow: 0 0 20px 5px rgba(212,160,23,0.15); }
}

.hero-title {
    font-size: clamp(2.5rem, 6vw, 5rem);
    font-weight: 800;
    color: white;
    line-height: 1.1;
    margin-bottom: 24px;
}
.hero-title .text-gold { color: #D4A017; }
.hero-title .text-accent { color: #E63946; }

.hero-subtitle {
    color: rgba(255,255,255,0.75);
    font-size: 1.15rem;
    margin-bottom: 36px;
    line-height: 1.7;
}

.hero-stats {
    display: flex; gap: 30px;
    margin-top: 40px;
}
.hero-stat { text-align: center; }
.hero-stat-number { font-size: 2rem; font-weight: 800; color: #D4A017; font-family: 'Outfit', sans-serif; line-height: 1; }
.hero-stat-label { font-size: 12px; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px; }

.hero-food-image {
    position: relative;
    animation: hero-bob 4s ease-in-out infinite;
    filter: drop-shadow(0 30px 60px rgba(0,0,0,0.5));
}
@keyframes hero-bob {
    0%, 100% { transform: translateY(0) rotate(-2deg); }
    50% { transform: translateY(-15px) rotate(2deg); }
}

.hero-floating-badge {
    position: absolute;
    background: white;
    border-radius: 12px;
    padding: 10px 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    display: flex; align-items: center; gap: 8px;
    font-weight: 600; font-size: 13px; color: #1A1A2E;
    animation: badge-float 3s ease-in-out infinite;
}
@keyframes badge-float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

/* =====================
   CATEGORY SLIDER SECTION
   ===================== */
.category-section { padding: 80px 0 60px; background: #FFF8F0; }
.section-badge {
    display: inline-block;
    background: rgba(15, 81, 50, 0.08);
    color: #0F5132;
    padding: 5px 16px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 12px;
}
.section-title { font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 800; color: #1A1A2E; margin-bottom: 10px; }
.section-subtitle { color: #6C757D; font-size: 1rem; margin-bottom: 0; }

.category-card {
    display: flex; flex-direction: column; align-items: center;
    padding: 24px 16px;
    background: white;
    border-radius: 16px;
    text-decoration: none;
    color: #1A1A2E;
    border: 2px solid transparent;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    cursor: pointer;
    white-space: nowrap;
}
.category-card:hover, .category-card.active {
    border-color: #0F5132;
    color: #0F5132;
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(15,81,50,0.1);
}
.category-icon-wrap {
    width: 60px; height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f0f9f4 0%, #d1fae5 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; color: #0F5132; margin-bottom: 12px;
    transition: all 0.3s ease;
}
.category-card:hover .category-icon-wrap {
    background: linear-gradient(135deg, #0F5132 0%, #157347 100%);
    color: white;
}
.category-name { font-size: 13px; font-weight: 600; text-align: center; }

/* =====================
   PRODUCT CARDS
   ===================== */
.trending-section { padding: 80px 0; background: white; }
.product-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    position: relative;
}
.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(15,81,50,0.1);
}
.product-card-img {
    width: 100%; height: 200px;
    object-fit: cover;
    background: linear-gradient(135deg, #0F5132, #D4A017);
}
.product-card-img-placeholder {
    width: 100%; height: 200px;
    background: linear-gradient(135deg, #0F5132 0%, #157347 50%, #D4A017 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: 60px;
}
.product-tag-bestseller { background: #E63946; color: white; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; }
.product-tag-new { background: #D4A017; color: white; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; }
.product-tag-veg { width: 22px; height: 22px; border: 2px solid #28a745; border-radius: 3px; display: flex; align-items: center; justify-content: center; }
.product-tag-veg::after { content: ''; width: 10px; height: 10px; background: #28a745; border-radius: 50%; }
.product-tag-nonveg { width: 22px; height: 22px; border: 2px solid #dc3545; border-radius: 3px; display: flex; align-items: center; justify-content: center; }
.product-tag-nonveg::after { content: ''; width: 10px; height: 10px; background: #dc3545; border-radius: 50%; transform: rotate(45deg); clip-path: polygon(50% 0%, 100% 100%, 0% 100%); }
.product-price { font-size: 1.3rem; font-weight: 800; color: #0F5132; font-family: 'Outfit', sans-serif; }
.product-strike { font-size: 0.9rem; text-decoration: line-through; color: #adb5bd; }
.product-rating { display: flex; align-items: center; gap: 4px; font-size: 13px; color: #D4A017; font-weight: 600; }
.btn-add-cart {
    background: linear-gradient(135deg, #0F5132, #157347);
    color: white; border: none;
    border-radius: 30px; padding: 8px 20px;
    font-weight: 600; font-size: 14px;
    transition: all 0.3s ease;
    cursor: pointer;
}
.btn-add-cart:hover { transform: scale(1.05); box-shadow: 0 4px 15px rgba(15,81,50,0.3); }

/* =====================
   TESTIMONIALS SECTION
   ===================== */
.reviews-section { padding: 80px 0; background: #FFF8F0; }
.review-card {
    background: white; border-radius: 16px;
    padding: 28px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.05);
    height: 100%;
}
.review-stars { color: #D4A017; font-size: 16px; margin-bottom: 12px; }
.review-text { color: #495057; font-size: 15px; line-height: 1.7; margin-bottom: 20px; font-style: italic; }
.reviewer-avatar {
    width: 48px; height: 48px; border-radius: 50%;
    background: linear-gradient(135deg, #0F5132, #D4A017);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 700; font-size: 18px; flex-shrink: 0;
}

/* =====================
   FRANCHISE CTA SECTION
   ===================== */
.franchise-section { padding: 100px 0; background: #0F5132; position: relative; overflow: hidden; }
.franchise-section::before {
    content: '';
    position: absolute; top: -50%; right: -20%;
    width: 600px; height: 600px;
    background: rgba(212,160,23,0.05);
    border-radius: 50%;
}

/* =====================
   LOCATION MAP
   ===================== */
.location-section { padding: 80px 0; background: white; }

/* =====================
   FINAL CTA
   ===================== */
.final-cta { padding: 100px 0; background: linear-gradient(135deg, #1A1A2E 0%, #16213e 100%); position: relative; overflow: hidden; }
</style>
@endsection

@section('content')

{{-- ================================
     SECTION 1: HERO BANNER
     ================================ --}}
<section class="hero-section" id="hero">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            {{-- Left: Hero Text --}}
            <div class="col-lg-6" data-aos="fade-right">
                <div class="hero-badge">
                    <i class="bi bi-star-fill me-1"></i> Premium Street Food Brand
                </div>
                <h1 class="hero-title">
                    Gos Momo —<br>
                    The Taste <span class="text-gold">India</span><br>
                    Will <span class="text-accent">Queue For</span>
                </h1>
                <p class="hero-subtitle">
                    Premium, hygienic, and insanely delicious street-style momos crafted with fresh ingredients every day. From Noida to Lucknow — and soon, everywhere.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('menu.index') }}" class="btn btn-gold btn-lg px-4 py-3 d-flex align-items-center gap-2">
                        <i class="bi bi-cart3"></i> Order Now
                    </a>
                    <a href="{{ route('menu.index') }}" class="btn btn-outline-light btn-lg px-4 py-3 d-flex align-items-center gap-2">
                        <i class="bi bi-card-checklist"></i> View Menu
                    </a>
                    <a href="{{ route('franchise.index') }}" class="btn btn-outline-light btn-lg px-4 py-3 d-flex align-items-center gap-2">
                        <i class="bi bi-briefcase"></i> Apply Franchise
                    </a>
                </div>

                <div class="hero-stats mt-5">
                    <div class="hero-stat">
                        <div class="hero-stat-number">10+</div>
                        <div class="hero-stat-label">Menu Items</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">500+</div>
                        <div class="hero-stat-label">Happy Customers</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">4.9★</div>
                        <div class="hero-stat-label">Avg. Rating</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">2</div>
                        <div class="hero-stat-label">Locations</div>
                    </div>
                </div>
            </div>

            {{-- Right: Hero Image / Momo Illustration --}}
            <div class="col-lg-6 text-center position-relative" data-aos="fade-left" data-aos-delay="200">
                <div class="hero-food-image d-inline-block position-relative">
                    {{-- Plate background glow --}}
                    <div style="width: 380px; height: 380px; border-radius: 50%; background: radial-gradient(circle, rgba(212,160,23,0.15) 0%, transparent 70%); display: flex; align-items: center; justify-content: center; margin: auto;">
                        <div style="font-size: 200px; line-height: 1;">🥟</div>
                    </div>

                    {{-- Floating badges --}}
                    <div class="hero-floating-badge" style="top: 20px; left: -20px; animation-delay: 0s;">
                        <span style="font-size: 20px;">⭐</span>
                        <span>4.9 Rating</span>
                    </div>
                    <div class="hero-floating-badge" style="bottom: 60px; right: -30px; animation-delay: 1s;">
                        <span style="font-size: 20px;">🔥</span>
                        <span>Bestseller</span>
                    </div>
                    <div class="hero-floating-badge" style="bottom: 0px; left: 10px; animation-delay: 2s;">
                        <span style="font-size: 20px;">✅</span>
                        <span>100% Hygienic</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 text-center d-none d-lg-block">
        <div style="animation: bounce 2s infinite; color: rgba(255,255,255,0.5);">
            <i class="bi bi-chevron-double-down fs-4"></i>
        </div>
    </div>
</section>

{{-- ================================
     SECTION 2: CATEGORY SLIDER
     ================================ --}}
<section class="category-section" id="categories">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">Explore by Category</span>
            <h2 class="section-title">What Are You <span style="color:#0F5132;">Craving</span> Today?</h2>
            <p class="section-subtitle">From classic steamed to crispy kurkure — we've got every momo mood covered.</p>
        </div>

        <div class="swiper categorySwiper" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper pb-3">
                @foreach($categories as $category)
                <div class="swiper-slide" style="width: auto;">
                    <a href="{{ route('menu.index', ['category' => $category->slug]) }}" class="category-card" style="min-width: 120px;">
                        <div class="category-icon-wrap">
                            <i class="bi {{ $category->icon ?? 'bi-grid' }}"></i>
                        </div>
                        <span class="category-name">{{ $category->name }}</span>
                    </a>
                </div>
                @endforeach
                {{-- Static Extras if empty --}}
                @if($categories->isEmpty())
                @foreach(['🥟 Steam Momos','🔥 Fried Momos','🌽 Kurkure','🍢 Tandoori','🫕 Gravy','🌯 Rolls','🎁 Combos','🥤 Beverages'] as $cat)
                <div class="swiper-slide" style="width: auto;">
                    <div class="category-card" style="min-width: 120px;">
                        <div class="category-icon-wrap">{{ explode(' ', $cat)[0] }}</div>
                        <span class="category-name">{{ implode(' ', array_slice(explode(' ', $cat), 1)) }}</span>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <div class="swiper-pagination mt-3"></div>
        </div>
    </div>
</section>

{{-- ================================
     SECTION 3: TRENDING ITEMS
     ================================ --}}
<section class="trending-section" id="trending">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-up">
            <div>
                <span class="section-badge">🔥 Hot Right Now</span>
                <h2 class="section-title mb-1">Trending <span style="color:#0F5132;">Items</span></h2>
                <p class="section-subtitle mb-0">Our customers' most-loved momos this week</p>
            </div>
            <a href="{{ route('menu.index') }}" class="btn btn-outline-success rounded-pill px-4 d-none d-md-flex align-items-center gap-2">
                Full Menu <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($trendingItems as $product)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="product-card">
                    {{-- Image or Placeholder --}}
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-card-img">
                    @else
                        <div class="product-card-img-placeholder">
                            🥟
                        </div>
                    @endif

                    {{-- Badges --}}
                    <div class="position-absolute top-0 start-0 p-3 d-flex gap-2" style="top:0; left:0;">
                        @if($product->is_bestseller)
                            <span class="product-tag-bestseller">Bestseller</span>
                        @endif
                        @if($product->is_new)
                            <span class="product-tag-new">New</span>
                        @endif
                    </div>

                    <div class="wishlist-btn position-absolute top-0 end-0 p-3">
                        <button class="btn btn-light btn-sm rounded-circle shadow-sm wishlist-toggle" data-product-id="{{ $product->id }}" style="width:36px; height:36px;">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="p-4">
                        {{-- Type indicator + Rating --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="{{ $product->is_veg ? 'product-tag-veg' : 'product-tag-nonveg' }}"></div>
                            <div class="product-rating">
                                <i class="bi bi-star-fill"></i>
                                <span>{{ $product->average_rating }}</span>
                            </div>
                        </div>

                        <h5 class="fw-bold mb-1">{{ $product->name }}</h5>
                        <p class="text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $product->short_description }}</p>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="product-price">₹{{ number_format($product->base_price, 0) }}</span>
                                @if($product->sale_price)
                                    <span class="product-strike ms-2">₹{{ number_format($product->sale_price, 0) }}</span>
                                @endif
                            </div>
                            <button class="btn-add-cart add-to-cart-btn"
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}"
                                data-price="{{ $product->base_price }}">
                                <i class="bi bi-plus-lg me-1"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            {{-- Placeholder cards when no data --}}
            @for($i = 0; $i < 3; $i++)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                <div class="product-card">
                    <div class="product-card-img-placeholder">🥟</div>
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="product-tag-veg"></div>
                            <div class="product-rating"><i class="bi bi-star-fill"></i> 5.0</div>
                        </div>
                        <h5 class="fw-bold mb-1">Signature Veg Momo</h5>
                        <p class="text-muted small mb-3">Freshly steamed vegetable momos with our secret spices</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="product-price">₹99</span>
                            <button class="btn-add-cart"><i class="bi bi-plus-lg me-1"></i> Add</button>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
            @endforelse
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('menu.index') }}" class="btn btn-premium btn-lg px-5 py-3 d-inline-flex align-items-center gap-2">
                <i class="bi bi-grid-3x3-gap"></i> See Full Menu
            </a>
        </div>
    </div>
</section>

{{-- ================================
     SECTION 4: POPULAR COMBOS
     ================================ --}}
@if($combos->count() > 0)
<section style="padding: 80px 0; background: #FFF8F0;" id="combos">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">🎁 Best Value</span>
            <h2 class="section-title">Popular <span style="color:#D4A017;">Combos</span></h2>
            <p class="section-subtitle">Get more momos, save more money!</p>
        </div>
        <div class="row g-4">
            @foreach($combos as $combo)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="product-card" style="border: 2px solid #D4A017;">
                    <div class="product-card-img-placeholder" style="background: linear-gradient(135deg, #D4A017, #0F5132);">🎁</div>
                    <div class="position-absolute top-0 start-0 p-3">
                        <span class="product-tag-bestseller">Best Value</span>
                    </div>
                    <div class="p-4">
                        <h5 class="fw-bold mb-1">{{ $combo->name }}</h5>
                        <p class="text-muted small mb-3">{{ $combo->short_description }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="product-price">₹{{ number_format($combo->base_price, 0) }}</span>
                            </div>
                            <button class="btn-add-cart add-to-cart-btn"
                                data-product-id="{{ $combo->id }}"
                                data-product-name="{{ $combo->name }}"
                                data-price="{{ $combo->base_price }}">
                                <i class="bi bi-cart3 me-1"></i> Add Combo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================
     SECTION 5: CUSTOMER REVIEWS
     ================================ --}}
<section class="reviews-section" id="reviews">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">💬 What People Say</span>
            <h2 class="section-title">Our Customers <span style="color:#E63946;">Love Us</span></h2>
            <p class="section-subtitle">Real reviews from real momo lovers</p>
        </div>

        <div class="swiper reviewSwiper" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">
                @forelse($testimonials as $testimonial)
                <div class="swiper-slide h-auto">
                    <div class="review-card">
                        <div class="review-stars">
                            @for($s=1; $s<=$testimonial->rating; $s++)
                                <i class="bi bi-star-fill"></i>
                            @endfor
                        </div>
                        <p class="review-text">"{{ $testimonial->content }}"</p>
                        <div class="d-flex align-items-center gap-3">
                            <div class="reviewer-avatar">{{ strtoupper(substr($testimonial->name, 0, 1)) }}</div>
                            <div>
                                <div class="fw-bold">{{ $testimonial->name }}</div>
                                <div class="text-muted small">{{ $testimonial->designation }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                @foreach([
                    ['name'=>'Aarav Sharma','role'=>'Food Blogger','text'=>'GOS MOMO has completely changed my perception of momos! The Kurkure Chicken Momo is an absolute masterpiece!','stars'=>5],
                    ['name'=>'Sneha Verma','role'=>'Tech Professional','text'=>'The hygiene is exceptional and the ordering experience is incredibly smooth. My go-to comfort food!','stars'=>5],
                    ['name'=>'Rohan Gupta','role'=>'Franchise Partner','text'=>'Best franchise decision I ever made. Full support, great brand, high ROI!','stars'=>5],
                ] as $t)
                <div class="swiper-slide h-auto">
                    <div class="review-card">
                        <div class="review-stars">{{ str_repeat('★', $t['stars']) }}</div>
                        <p class="review-text">"{{ $t['text'] }}"</p>
                        <div class="d-flex align-items-center gap-3">
                            <div class="reviewer-avatar">{{ strtoupper(substr($t['name'],0,1)) }}</div>
                            <div>
                                <div class="fw-bold">{{ $t['name'] }}</div>
                                <div class="text-muted small">{{ $t['role'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endforelse
            </div>
            <div class="swiper-pagination mt-4"></div>
        </div>
    </div>
</section>

{{-- ================================
     SECTION 6: LOCATION MAP
     ================================ --}}
<section class="location-section" id="location">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">📍 Find Us</span>
            <h2 class="section-title">Visit Our <span style="color:#0F5132;">Locations</span></h2>
            <p class="section-subtitle">Come find us in Lucknow & Noida</p>
        </div>
        <div class="row g-4 align-items-center">
            <div class="col-lg-5" data-aos="fade-right">
                @forelse($locations as $location)
                <div class="glass-card p-4 mb-4">
                    <div class="d-flex align-items-start gap-3">
                        <div style="width:48px; height:48px; border-radius:12px; background:linear-gradient(135deg,#0F5132,#157347); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi bi-geo-alt-fill text-white fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ $location->name }}</h5>
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 mb-2">{{ ucfirst($location->type) }}</span>
                            <p class="text-muted small mb-1">{{ $location->address }}, {{ $location->city }}</p>
                            @if($location->phone)
                                <p class="mb-1 small"><i class="bi bi-telephone-fill text-success me-1"></i>{{ $location->phone }}</p>
                            @endif
                            @if($location->opening_time && $location->closing_time)
                                <p class="mb-0 small"><i class="bi bi-clock-fill text-warning me-1"></i>{{ date('h:i A', strtotime($location->opening_time)) }} - {{ date('h:i A', strtotime($location->closing_time)) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="glass-card p-4 mb-4">
                    <div class="d-flex align-items-start gap-3">
                        <div style="width:48px; height:48px; border-radius:12px; background:linear-gradient(135deg,#0F5132,#157347); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi bi-geo-alt-fill text-white fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Lucknow Cart</h5>
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 mb-2">Cart</span>
                            <p class="text-muted small mb-1">Hazratganj, Near Cathedral School, Lucknow, UP</p>
                            <p class="mb-0 small"><i class="bi bi-clock-fill text-warning me-1"></i>12:00 PM - 11:00 PM</p>
                        </div>
                    </div>
                </div>
                @endforelse
                <a href="{{ route('locations') }}" class="btn btn-premium d-inline-flex align-items-center gap-2">
                    <i class="bi bi-map"></i> View All Locations
                </a>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="rounded-4 overflow-hidden shadow-lg" style="height: 380px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28489.87534!2d80.9462!3d26.8467!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399bfd991f32b16b%3A0x93ccba8909978be7!2sHazratganj%2C%20Lucknow%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1699999999999"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================
     SECTION 7: FRANCHISE OPPORTUNITY
     ================================ --}}
<section class="franchise-section" id="franchise">
    <div class="container position-relative">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-badge" style="background: rgba(212,160,23,0.15); color: #D4A017; border: 1px solid rgba(212,160,23,0.3);">💼 Business Opportunity</span>
                <h2 class="section-title text-white mt-2">Grow With<br><span style="color:#D4A017;">GOS MOMO</span></h2>
                <p class="text-white-50 mb-4 fs-5">Join the fastest growing premium momo brand in India. Start with as little as ₹3 Lakhs and enjoy high returns.</p>

                <div class="row g-3 mb-5">
                    @foreach([
                        ['icon'=>'bi-cart3','title'=>'Cart Model','subtitle'=>'Starting ₹3L','desc'=>'Mobile cart setup. Low investment, quick start.'],
                        ['icon'=>'bi-shop','title'=>'Kiosk Model','subtitle'=>'Starting ₹8L','desc'=>'Food court kiosk. High footfall locations.'],
                        ['icon'=>'bi-building','title'=>'Outlet Model','subtitle'=>'Starting ₹15L','desc'=>'Full outlet. Maximum revenue, brand presence.'],
                    ] as $model)
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 text-white h-100" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);">
                            <i class="bi {{ $model['icon'] }} fs-3 mb-2 d-block" style="color: #D4A017;"></i>
                            <div class="fw-bold">{{ $model['title'] }}</div>
                            <div class="small text-warning">{{ $model['subtitle'] }}</div>
                            <div class="small text-white-50 mt-1">{{ $model['desc'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('franchise.index') }}" class="btn btn-gold btn-lg px-5 py-3 d-inline-flex align-items-center gap-2">
                    <i class="bi bi-briefcase-fill"></i> Apply for Franchise
                </a>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 40px;">
                    <h4 class="text-white fw-bold mb-4">Why Choose GOS MOMO?</h4>
                    @foreach([
                        ['icon'=>'bi-graph-up-arrow','text'=>'35–45% Gross Profit Margin'],
                        ['icon'=>'bi-truck','text'=>'Full Supply Chain Support'],
                        ['icon'=>'bi-award','text'=>'Premium Brand Identity'],
                        ['icon'=>'bi-people-fill','text'=>'Comprehensive Training Program'],
                        ['icon'=>'bi-phone','text'=>'Digital Ordering System Included'],
                        ['icon'=>'bi-headset','text'=>'Dedicated Franchise Manager Support'],
                    ] as $point)
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:40px; height:40px; border-radius:10px; background: rgba(212,160,23,0.15); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi {{ $point['icon'] }}" style="color: #D4A017;"></i>
                        </div>
                        <span class="text-white-75">{{ $point['text'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================
     SECTION 8: GALLERY (Instagram style)
     ================================ --}}
<section style="padding: 80px 0; background: #FFF8F0;" id="gallery">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-badge">📸 Visual Stories</span>
            <h2 class="section-title">GOS MOMO <span style="color:#0F5132;">Gallery</span></h2>
            <p class="section-subtitle">Behind the scenes at GOS MOMO</p>
        </div>
        <div class="row g-3" data-aos="fade-up" data-aos-delay="100">
            {{-- Gallery grid placeholder items --}}
            @for($i = 0; $i < 6; $i++)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="rounded-3 overflow-hidden position-relative" style="aspect-ratio: 1/1; background: linear-gradient({{ $i*60 }}deg, #0F5132, #D4A017); cursor: pointer; transition: all 0.3s ease;"
                    onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <div class="d-flex align-items-center justify-content-center h-100" style="font-size: 50px;">
                        {{ ['🥟','🍽️','🔥','👨‍🍳','😋','⭐'][$i] }}
                    </div>
                    <div class="position-absolute inset-0 top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                        style="background: rgba(0,0,0,0); transition: background 0.3s ease;"
                        onmouseover="this.style.background='rgba(0,0,0,0.4)'" onmouseout="this.style.background='rgba(0,0,0,0)'">
                        <i class="bi bi-instagram text-white fs-3 opacity-0" style="transition: opacity 0.3s ease;"
                            onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'"></i>
                    </div>
                </div>
            </div>
            @endfor
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('gallery') }}" class="btn btn-outline-success rounded-pill px-4">
                <i class="bi bi-images me-1"></i> View Full Gallery
            </a>
        </div>
    </div>
</section>

{{-- ================================
     SECTION 9: FINAL CTA
     ================================ --}}
<section class="final-cta" id="cta">
    <div class="container text-center position-relative">
        {{-- Decorative circles --}}
        <div style="position: absolute; top: -100px; left: -100px; width: 300px; height: 300px; border-radius: 50%; background: rgba(15,81,50,0.2); pointer-events: none;"></div>
        <div style="position: absolute; bottom: -50px; right: -50px; width: 200px; height: 200px; border-radius: 50%; background: rgba(212,160,23,0.1); pointer-events: none;"></div>

        <div data-aos="zoom-in">
            <div style="font-size: 80px; margin-bottom: 24px;">🥟</div>
            <h2 class="text-white" style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; margin-bottom: 16px;">
                Ready to Taste the<br><span style="color: #D4A017;">GOS MOMO</span> Experience?
            </h2>
            <p class="text-white-50 mb-5 fs-5">Order online or visit us. Fresh momos delivered to your door.</p>

            <div class="d-flex justify-content-center flex-wrap gap-3">
                <a href="{{ route('menu.index') }}" class="btn btn-gold btn-lg px-5 py-3 d-inline-flex align-items-center gap-2">
                    <i class="bi bi-cart3"></i> Order Now
                </a>
                <a href="{{ route('franchise.index') }}" class="btn btn-outline-light btn-lg px-5 py-3 d-inline-flex align-items-center gap-2">
                    <i class="bi bi-briefcase"></i> Start Your Franchise
                </a>
            </div>

            <div class="mt-5 d-flex justify-content-center gap-4 flex-wrap">
                <a href="https://wa.me/918888877777" class="text-white-50 text-decoration-none d-flex align-items-center gap-2 small">
                    <i class="bi bi-whatsapp text-success fs-5"></i> Chat on WhatsApp
                </a>
                <a href="{{ route('catering') }}" class="text-white-50 text-decoration-none d-flex align-items-center gap-2 small">
                    <i class="bi bi-calendar-event text-warning fs-5"></i> Book for Your Event
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
$(document).ready(function() {

    // Category Swiper
    new Swiper('.categorySwiper', {
        slidesPerView: 'auto',
        spaceBetween: 16,
        freeMode: true,
        pagination: { el: '.categorySwiper .swiper-pagination', clickable: true },
        breakpoints: {
            640: { spaceBetween: 20 },
        }
    });

    // Review Swiper
    new Swiper('.reviewSwiper', {
        slidesPerView: 1,
        spaceBetween: 24,
        loop: true,
        autoplay: { delay: 4000, disableOnInteraction: false },
        pagination: { el: '.reviewSwiper .swiper-pagination', clickable: true },
        breakpoints: {
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        }
    });

    // Add to Cart AJAX
    $(document).on('click', '.add-to-cart-btn', function(e) {
        e.preventDefault();
        const btn = $(this);
        const productId = btn.data('product-id');
        const productName = btn.data('product-name') || 'Item';

        if (!productId) return;

        btn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i> Adding...');

        $.ajax({
            url: "{{ route('cart.add') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: productId,
                quantity: 1
            },
            success: function(response) {
                if (response.success) {
                    btn.html('<i class="bi bi-check-lg me-1"></i> Added!');
                    setTimeout(() => btn.prop('disabled', false).html('<i class="bi bi-plus-lg me-1"></i> Add'), 1500);

                    // Update cart count
                    const count = response.cart_count;
                    $('#desktop-cart-count, #mobile-cart-badge, #mobile-bottom-cart-badge, #floating-cart-badge')
                        .text(count).removeClass('d-none');

                    // Toast notification
                    showToast(productName + ' added to cart!', 'success');
                }
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="bi bi-plus-lg me-1"></i> Add');
                showToast('Please login to add items to cart.', 'warning');
            }
        });
    });

    // Simple Toast function
    function showToast(message, type = 'success') {
        const bg = type === 'success' ? '#0F5132' : '#D4A017';
        const toastEl = $('<div>')
            .text(message)
            .css({
                position: 'fixed', bottom: '90px', right: '20px', zIndex: 9999,
                background: bg, color: 'white',
                padding: '12px 20px', borderRadius: '12px',
                fontFamily: 'Poppins, sans-serif', fontWeight: '600',
                boxShadow: '0 8px 30px rgba(0,0,0,0.15)',
                transform: 'translateX(200%)', transition: 'transform 0.4s ease',
                maxWidth: '280px', fontSize: '14px'
            });
        $('body').append(toastEl);
        setTimeout(() => toastEl.css('transform', 'translateX(0)'), 10);
        setTimeout(() => { toastEl.css('transform', 'translateX(200%)'); setTimeout(() => toastEl.remove(), 400); }, 3000);
    }

    // Bounce animation keyframe
    $('<style>@keyframes bounce { 0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}</style>').appendTo('head');
});
</script>
@endsection
