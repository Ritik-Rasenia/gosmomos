@extends('layouts.app')

@section('title', 'Delicious Foods With Wonderful Eating — ' . setting('site_name', 'GOS MOMO'))

@section('styles')
<style>
    /* ==========================================================================
       GLOBAL ADJUSTMENTS & THEME OVERRIDES
       ========================================================================== */
    body {
        background-color: #FAF9F6;
        color: #0E101A;
    }
    
    .hover-orange-text {
        transition: color 0.2s ease-in-out;
    }
    .hover-orange-text:hover h4 {
        color: #FF7A00 !important;
    }
    
    .section-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background-color: rgba(255, 122, 0, 0.1);
        color: #FF7A00;
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
        font-family: var(--font-inter);
    }
    
    .section-title {
        font-family: var(--font-outfit);
        font-size: clamp(2rem, 4vw, 2.8rem);
        font-weight: 800;
        color: #0E101A;
        margin-bottom: 12px;
    }
    
    .section-subtitle {
        color: #6C757D;
        font-size: 1rem;
        margin-bottom: 40px;
    }

    /* ==========================================================================
       HERO BANNER
       ========================================================================== */
    .theme-hero {
        background-color: #0E101A;
        position: relative;
        padding: 100px 0;
        overflow: hidden;
    }
    
    .theme-hero::before {
        content: '';
        position: absolute;
        width: 600px;
        height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 122, 0, 0.08) 0%, transparent 70%);
        top: -10%;
        right: -10%;
        pointer-events: none;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        background-color: rgba(255, 122, 0, 0.15);
        color: #FF7A00;
        padding: 8px 18px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 24px;
        font-family: var(--font-inter);
    }

    .hero-heading {
        color: #FFFFFF;
        font-family: var(--font-outfit);
        font-size: clamp(2rem, 5vw, 3.2rem);
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 24px;
    }

    .hero-desc {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.1rem;
        line-height: 1.7;
        margin-bottom: 36px;
        max-width: 540px;
    }

    .hero-search-box {
        max-width: 480px;
        position: relative;
    }

    .hero-search-box input {
        width: 100%;
        padding: 16px 140px 16px 24px;
        border-radius: 50px;
        border: none;
        outline: none;
        font-size: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .hero-search-box button {
        position: absolute;
        right: 8px;
        top: 8px;
        bottom: 8px;
        padding: 0 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
    }

    .hero-circle-wrap {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        max-width: 100%;
        overflow: hidden;
    }

    .hero-main-dish {
        width: clamp(280px, 45vw, 480px);
        height: clamp(280px, 45vw, 480px);
        border-radius: 50%;
        object-fit: cover;
        border: 10px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 20px 50px rgba(0,0,0,0.4);
        z-index: 2;
    }

    .hero-circle-bg {
        position: absolute;
        width: 110%;
        height: 110%;
        border: 2px dashed rgba(255, 122, 0, 0.2);
        border-radius: 50%;
        animation: spin 30s linear infinite;
        pointer-events: none;
    }

    .hero-discount-badge {
        position: absolute;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background-color: #FF7A00;
        color: #FFFFFF;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        top: 10px;
        right: 10px;
        z-index: 3;
        font-family: var(--font-outfit);
        font-weight: 800;
        box-shadow: 0 10px 25px rgba(255, 122, 0, 0.4);
        transform: rotate(15deg);
        animation: bob 3s ease-in-out infinite alternate;
    }

    @keyframes spin { 100% { transform: rotate(360deg); } }
    @keyframes bob { 0% { transform: translateY(0) rotate(15deg); } 100% { transform: translateY(-10px) rotate(10deg); } }

    /* Hero Redesign Styles */
    .hero-gradient-text {
        background: linear-gradient(135deg, #FFF 30%, #FF7A00 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
        font-weight: 850;
    }
    
    .hero-features-list {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 30px;
        list-style: none;
        padding-left: 0;
    }

    .hero-feature-item {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 13.5px;
        color: rgba(255, 255, 255, 0.85);
        font-family: var(--font-inter);
        transition: var(--transition-smooth);
    }

    .hero-feature-item:hover {
        background: rgba(255, 122, 0, 0.08);
        border-color: rgba(255, 122, 0, 0.3);
        transform: translateY(-2px);
    }

    .hero-feature-item i {
        color: #FF7A00;
        font-size: 15px;
    }

    /* Floating container animation */
    .hero-circle-wrap {
        animation: floatContainer 6s ease-in-out infinite alternate;
    }

    @keyframes floatContainer {
        0% { transform: translateY(0); }
        100% { transform: translateY(-15px); }
    }

    /* Glow Orbs in Hero */
    .hero-orb {
        position: absolute;
        width: 350px;
        height: 350px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 122, 0, 0.09) 0%, transparent 70%);
        filter: blur(50px);
        pointer-events: none;
        z-index: 1;
    }
    .hero-orb-1 {
        top: 15%;
        left: -5%;
    }
    .hero-orb-2 {
        bottom: 5%;
        right: 25%;
    }

    /* ==========================================================================
       OFFER SECTION
       ========================================================================== */
    .offer-section {
        padding: 80px 0;
        background-color: #FAF9F6;
    }

    .offer-card {
        background-color: #FFFFFF;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: 0 8px 30px rgba(0,0,0,0.02);
        transition: var(--transition-smooth);
        height: 100%;
    }

    .offer-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(255, 122, 0, 0.08);
    }

    .offer-card-img {
        width: 100%;
        height: 100%;
        min-height: 200px;
        object-fit: cover;
    }

    .offer-card-content {
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
    }

    .offer-card-title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 10px;
        font-family: var(--font-outfit);
    }

    .offer-rating {
        color: #FF7A00;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .offer-desc {
        color: #6C757D;
        font-size: 14px;
        margin-bottom: 16px;
        line-height: 1.5;
    }

    .offer-price {
        font-size: 18px;
        font-weight: 800;
        color: #FF7A00;
        font-family: var(--font-outfit);
    }

    /* ==========================================================================
       BOOK TABLE SECTION
       ========================================================================== */
    .reserve-section {
        padding: 80px 0;
        background-color: #FFFFFF;
    }

    .reserve-banner {
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        height: 100%;
        min-height: 450px;
    }

    .reserve-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .reserve-card {
        background-color: #FF7A00;
        color: #FFFFFF;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 15px 40px rgba(255, 122, 0, 0.25);
    }

    .reserve-title {
        font-family: var(--font-outfit);
        font-weight: 800;
        font-size: 28px;
        margin-bottom: 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        padding-bottom: 12px;
    }

    .reserve-card .form-control, .reserve-card .form-select {
        background-color: #FFFFFF !important;
        border: 1px solid rgba(0, 0, 0, 0.1) !important;
        color: #0E101A !important;
        padding: 12px 18px;
        border-radius: 8px !important;
        height: 48px;
    }

    .reserve-card .form-control::placeholder {
        color: #6C757D !important;
    }

    .reserve-card option {
        color: #0E101A;
    }

    /* ==========================================================================
       POPULAR FOODS
       ========================================================================== */
    .popular-section {
        padding: 80px 0;
        background-color: #FAF9F6;
    }

    .filter-tabs {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    .filter-tab {
        background: #FFFFFF;
        border: 1px solid rgba(0,0,0,0.05);
        color: #0E101A;
        padding: 8px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: var(--transition-smooth);
    }

    .filter-tab.active, .filter-tab:hover {
        background-color: #FF7A00;
        color: #FFFFFF;
        border-color: #FF7A00;
        box-shadow: 0 4px 15px rgba(255, 122, 0, 0.2);
    }

    .food-card {
        background-color: #FFFFFF;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: 0 6px 20px rgba(0,0,0,0.02);
        transition: var(--transition-smooth);
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .food-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(255, 122, 0, 0.1);
    }

    .food-card-img-wrap {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
    }

    .food-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-smooth);
    }

    .food-card:hover .food-card-img {
        transform: scale(1.08);
    }

    .food-veg-tag {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: #28A745;
        color: white;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .food-nonveg-tag {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: #DC3545;
        color: white;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .food-card-body {
        padding: 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .food-card-title {
        font-family: var(--font-outfit);
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .food-card-rating {
        color: #FF7A00;
        font-size: 13px;
        margin-bottom: 12px;
    }

    .food-card-desc {
        color: #6C757D;
        font-size: 13px;
        line-height: 1.5;
        margin-bottom: 20px;
    }

    .food-card-footer {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* ==========================================================================
       EXPERT CHEFS
       ========================================================================== */
    .chefs-section {
        padding: 80px 0;
        background-color: #FFFFFF;
    }

    .chef-card {
        background-color: #FFFFFF;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: 0 6px 20px rgba(0,0,0,0.02);
        transition: var(--transition-smooth);
        text-align: center;
        padding-bottom: 30px;
        position: relative;
        overflow: visible; /* Allows overlapping chef avatar */
        margin-top: 50px;
    }

    .chef-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(255, 122, 0, 0.08);
    }

    .chef-accent-arch {
        height: 100px;
        background-color: #FF7A00;
        border-radius: 16px 16px 50% 50% / 16px 16px 20px 20px;
        margin-bottom: -50px;
        position: relative;
        z-index: 1;
    }

    .chef-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 5px solid #FFFFFF;
        object-fit: cover;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        position: relative;
        z-index: 2;
        margin-top: -10px;
    }

    .chef-name {
        font-family: var(--font-outfit);
        font-size: 19px;
        font-weight: 700;
        margin-top: 15px;
        margin-bottom: 4px;
    }

    .chef-role {
        color: #6C757D;
        font-size: 14px;
        margin-bottom: 16px;
    }

    .chef-socials {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .chef-socials a {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: rgba(255, 122, 0, 0.1);
        color: #FF7A00;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 14px;
        transition: var(--transition-smooth);
    }

    .chef-socials a:hover {
        background-color: #FF7A00;
        color: #FFFFFF;
    }

    /* ==========================================================================
       PROMO PAIR BANNERS
       ========================================================================== */
    .promo-section {
        padding: 60px 0;
        background-color: #FAF9F6;
    }

    .promo-banner-card {
        border-radius: 16px;
        padding: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        height: 100%;
        min-height: 180px;
        border: 1px solid rgba(0,0,0,0.02);
    }

    .promo-banner-text h4 {
        font-family: var(--font-outfit);
        font-weight: 800;
        font-size: 24px;
        margin-bottom: 6px;
    }

    .promo-banner-text p {
        font-size: 14px;
        color: #6C757D;
        margin-bottom: 16px;
    }

    .promo-banner-img {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border-radius: 50%;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    /* ==========================================================================
       EASY TO ORDER (APP SCREEN)
       ========================================================================== */
    .app-section {
        padding: 80px 0;
        background-color: #0E101A;
        color: #FFFFFF;
        position: relative;
        overflow: hidden;
    }

    .app-section::before {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 122, 0, 0.05) 0%, transparent 70%);
        bottom: -10%;
        left: -10%;
    }

    .app-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .app-btn {
        background-color: #FF7A00;
        color: #FFFFFF;
        padding: 12px 28px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        font-size: 14px;
        transition: var(--transition-smooth);
        box-shadow: 0 5px 15px rgba(255, 122, 0, 0.2);
    }

    .app-btn:hover {
        background-color: #E26C00;
        color: #FFFFFF;
        transform: translateY(-2px);
    }

    .app-plates-wrap {
        position: relative;
        display: flex;
        justify-content: center;
        height: 100%;
        min-height: 300px;
    }

    .app-plate-img {
        position: absolute;
        width: clamp(120px, 20vw, 220px);
        height: clamp(120px, 20vw, 220px);
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        border: 4px solid rgba(255,255,255,0.05);
    }

    /* ==========================================================================
       CUSTOMER FEEDBACKS
       ========================================================================== */
    .feedbacks-section {
        padding: 80px 0;
        background-color: #FAF9F6;
    }

    .feedback-card {
        background-color: #0E101A;
        color: #FFFFFF;
        border-radius: 16px;
        padding: 60px 40px 40px; /* Extra top padding for the avatar */
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border: 1px solid rgba(255, 255, 255, 0.03);
        margin-top: 40px; /* Space for the avatar overlap */
    }

    .feedback-quote-icon {
        color: #FF7A00;
        font-size: 32px;
        margin-bottom: 10px;
        line-height: 1;
    }

    .feedback-text {
        font-size: 15px;
        line-height: 1.7;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 20px;
        font-style: italic;
    }

    .feedback-user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #FAF9F6; /* Matches section bg */
        position: absolute;
        top: -40px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }

    /* ==========================================================================
       COUNTERS SECTION
       ========================================================================== */
    .counters-section {
        background-color: #06070B;
        padding: 60px 0;
        color: #FFFFFF;
    }

    .counter-item {
        text-align: center;
    }

    .counter-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 3px solid #FF7A00;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 800;
        color: #FF7A00;
        font-family: var(--font-outfit);
        background-color: rgba(255, 122, 0, 0.05);
        box-shadow: 0 0 20px rgba(255, 122, 0, 0.1);
    }

    .counter-label {
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: rgba(255, 255, 255, 0.7);
        font-weight: 500;
    }

    /* ==========================================================================
       LATEST FOOD BLOGS
       ========================================================================== */
    .blogs-section {
        padding: 80px 0;
        background-color: #FFFFFF;
    }

    .blog-card {
        background-color: #FFFFFF;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: 0 6px 20px rgba(0,0,0,0.02);
        transition: var(--transition-smooth);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(255, 122, 0, 0.08);
    }

    .blog-img-wrap {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .blog-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .blog-badge {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background-color: #FF7A00;
        color: #FFFFFF;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        text-transform: uppercase;
    }

    .blog-body {
        padding: 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .blog-meta {
        font-size: 12px;
        color: #6C757D;
        margin-bottom: 10px;
        display: flex;
        gap: 15px;
    }

    .blog-title {
        font-family: var(--font-outfit);
        font-size: 18px;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 12px;
    }

    .blog-excerpt {
        color: #6C757D;
        font-size: 13px;
        line-height: 1.6;
        margin-bottom: 16px;
    }

    .blog-link {
        color: #FF7A00;
        font-weight: 600;
        font-size: 13px;
        text-decoration: none;
        margin-top: auto;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: var(--transition-smooth);
    }

    .blog-link:hover {
        color: #E26C00;
        gap: 6px;
    }

    /* Testimonials Swiper CSS */
    .reviewSwiper {
        padding-bottom: 50px !important;
    }
    .reviewSwiper .swiper-slide {
        height: auto;
        display: flex;
        justify-content: center;
    }
    .reviewSwiper .swiper-pagination-bullet-active {
        background: #FF7A00 !important;
        width: 24px !important;
        border-radius: 5px !important;
    }
    .reviewSwiper .swiper-pagination-bullet {
        background: #FF7A00;
        opacity: 0.6;
        width: 8px;
        height: 8px;
        transition: all 0.3s ease;
    }
    .feedback-card {
        width: 100%;
        margin-top: 40px; /* Accounts for the avatar overlap */
        position: relative;
    }
</style>
@endsection

@section('content')

<!-- ==========================================
     1. HERO BANNER SECTION
     ========================================== -->
<section class="theme-hero" id="hero">
    <!-- Glow Orbs for visual depth -->
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>
    
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center g-5">
            <!-- Left content -->
            <div class="col-lg-6" data-aos="fade-right">
                <span class="hero-badge"><i class="bi bi-star-fill me-1"></i> The Taste India Will Queue For</span>
                <h1 class="hero-heading">
                    Delicious Foods With<br>
                    <span class="hero-gradient-text">Wonderful Eating</span>
                </h1>
                <p class="hero-desc">
                    Crafting the crunchiest, most delicious, and hygienic street-style momos in India. Fresh ingredients wrapped and steamed to perfection daily.
                </p>
                <div class="hero-search-box">
                    <form action="{{ route('menu.index') }}" method="GET">
                        <input type="text" name="search" placeholder="Search your favorite momos...">
                        <button type="submit" class="btn btn-premium btn-orange"><i class="bi bi-search me-1"></i> Search</button>
                    </form>
                </div>
                
                <!-- Brand Highlights -->
                <ul class="hero-features-list">
                    <li class="hero-feature-item">
                        <i class="bi bi-star-fill"></i>
                        <span>4.9+ Rated Momos</span>
                    </li>
                    <li class="hero-feature-item">
                        <i class="bi bi-shield-check"></i>
                        <span>100% Hygienic Kitchens</span>
                    </li>
                    <li class="hero-feature-item">
                        <i class="bi bi-patch-check-fill"></i>
                        <span>Hand-Crafted Fresh Daily</span>
                    </li>
                </ul>
            </div>

            <!-- Right circle graphic -->
            <div class="col-lg-6 text-center position-relative" data-aos="fade-left">
                <div class="hero-circle-wrap">
                    <div class="hero-circle-bg"></div>
                    <img src="https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=600&q=80" alt="Gosmomo Dish" class="hero-main-dish">
                    <div class="hero-discount-badge">
                        <span style="font-size: 20px;">35%</span>
                        <span style="font-size: 11px; text-transform: uppercase;">Discount</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     2. OFFERS SECTION (Horizontal cards)
     ========================================== -->
<section class="offer-section" id="offers">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-gift"></i> Tasty Offer</span>
            <h2 class="section-title">Up To 70% Off For This Day</h2>
            <p class="section-subtitle">Grab daily discounts on chef-curated premium platters.</p>
        </div>

        <div class="row g-4">
            @foreach($offerProducts as $index => $product)
            @php
                $displayName = $product->slug == 'classic-chicken-kurkure-momo' ? 'Chicken Crunchy Momo' : ($product->slug == 'signature-veg-steam-momo' ? 'Veg Steamed Momo' : $product->name);
                $rating = $product->slug == 'classic-chicken-kurkure-momo' ? 5.0 : 4.8;
                $desc = $product->slug == 'classic-chicken-kurkure-momo' 
                    ? 'Super crispy cornflake-crusted chicken momos served with fiery schezwan and mayonnaise.' 
                    : ($product->slug == 'signature-veg-steam-momo' 
                        ? 'Classic steamed vegetable momos made with fresh cabbage, carrot, paneer and spices.' 
                        : ($product->short_description ?? $product->description));
            @endphp
            <div class="col-lg-6" data-aos="{{ $index % 2 == 0 ? 'fade-right' : 'fade-left' }}">
                <div class="offer-card">
                    <div class="row g-0 align-items-center h-100">
                        <div class="col-md-5 h-100">
                            <a href="{{ route('menu.show', $product->slug) }}">
                                <img src="{{ $product->image_url ?? $product->image ?? 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=400&q=80' }}" alt="{{ $displayName }}" class="offer-card-img" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=400&q=80';">
                            </a>
                        </div>
                        <div class="col-md-7">
                            <div class="offer-card-content">
                                <a href="{{ route('menu.show', $product->slug) }}" class="text-decoration-none text-dark hover-orange-text">
                                    <h4 class="offer-card-title">{{ $displayName }}</h4>
                                </a>
                                <div class="offer-rating">
                                    @if($rating == 5.0)
                                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i> (5.0)
                                    @else
                                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i> (4.8)
                                    @endif
                                </div>
                                <p class="offer-desc">{{ $desc }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="offer-price">₹{{ number_format($product->base_price, 0) }}</span>
                                    <button class="btn btn-premium btn-sm btn-orange rounded-pill px-4 add-to-cart-btn"
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $displayName }}"
                                            data-price="{{ $product->base_price }}">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ==========================================
     3. BOOK TABLE SECTION (Catering leads logic)
     ========================================== -->
<section class="reserve-section" id="booking">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success rounded-3 p-3 mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="row g-4 align-items-stretch">
            <!-- Left Banner image -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="reserve-banner">
                    <img src="https://images.unsplash.com/photo-1563245372-f21724e3856d?auto=format&fit=crop&w=800&q=80" alt="Sharing Dim Sum and Momos">
                </div>
            </div>

            <!-- Right Form Card -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="reserve-card h-100">
                    <h3 class="reserve-title"><i class="bi bi-calendar-check me-2"></i>Book A Table</h3>
                    <form action="{{ route('catering.store') }}" method="POST">
                        @csrf
                        <!-- Lead Routing Parameters mapped to catering structure -->
                        <input type="hidden" name="event_type" value="Table Reservation">
                        <input type="hidden" name="city" value="Lucknow">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                            </div>
                            <div class="col-md-6">
                                <input type="tel" name="phone" class="form-control" placeholder="Phone Number (10 digits)" pattern="[0-9]{10}" required>
                            </div>
                            <div class="col-md-6">
                                <input type="date" name="event_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <select name="guest_count" class="form-select" required>
                                    <option value="" disabled selected>Number of Guests</option>
                                    <option value="2">2 Persons</option>
                                    <option value="4">4 Persons</option>
                                    <option value="6">6 Persons</option>
                                    <option value="10">10+ Persons (Bulk)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="message" class="form-select" required>
                                    <option value="" disabled selected>Select Time Slot</option>
                                    <option value="Lunch (1:00 PM - 3:00 PM)">Lunch Slot</option>
                                    <option value="Hi-Tea (4:30 PM - 6:30 PM)">Hi-Tea Slot</option>
                                    <option value="Dinner (8:00 PM - 11:00 PM)">Dinner Slot</option>
                                </select>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-dark w-100 py-3 fw-bold" style="letter-spacing: 0.5px; border-radius: 8px;">Book Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     4. POPULAR DELICIOUS FOODS
     ========================================== -->
<section class="popular-section" id="popular">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-fire"></i> Best Food</span>
            <h2 class="section-title">Popular Delicious Foods</h2>
            <p class="section-subtitle">Order our finest steamed, fried, and crispy variants online.</p>
        </div>

        <!-- Category tabs -->
        <div class="filter-tabs" data-aos="fade-up">
            <button class="filter-tab active" onclick="filterMenu('all')">All</button>
            @foreach($categories as $cat)
                <button class="filter-tab" onclick="filterMenu('{{ $cat->slug }}')">{{ $cat->name }}</button>
            @endforeach
        </div>

        <!-- Menu Grid -->
        <div class="row g-4" id="momo-grid">
            @forelse($trendingItems as $product)
            <div class="col-md-6 col-lg-4 menu-item" data-category="{{ $product->category->slug }}" data-aos="fade-up">
                <div class="food-card">
                    <div class="food-card-img-wrap">
                        <a href="{{ route('menu.show', $product->slug) }}">
                            <img src="{{ $product->image_url ?? 'https://images.unsplash.com/photo-1625220194771-7ebedd0b4d11?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $product->name }}" class="food-card-img" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1625220194771-7ebedd0b4d11?auto=format&fit=crop&w=600&q=80';">
                        </a>
                        <span class="{{ $product->is_veg ? 'food-veg-tag' : 'food-nonveg-tag' }}">
                            {{ $product->is_veg ? 'Veg' : 'Non-Veg' }}
                        </span>
                    </div>
                    <div class="food-card-body">
                        <a href="{{ route('menu.show', $product->slug) }}" class="text-decoration-none text-dark hover-orange-text">
                            <h4 class="food-card-title">{{ $product->name }}</h4>
                        </a>
                        <div class="food-card-rating">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i> (5.0)
                        </div>
                        <p class="food-card-desc">{{ $product->short_description }}</p>
                        <div class="food-card-footer">
                            <span class="product-price">₹{{ number_format($product->base_price, 0) }}</span>
                            <!-- Ajax Cart add button -->
                            <button class="btn btn-premium btn-sm btn-orange rounded-pill px-4 add-to-cart-btn"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-price="{{ $product->base_price }}">
                                <i class="bi bi-cart-plus me-1"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-muted col-12">No items listed. Create them in admin catalog.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- ==========================================
     5. EXPERT CHEFS SECTION
     ========================================== -->
<section class="chefs-section" id="chefs">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-people"></i> Team Members</span>
            <h2 class="section-title">Meet Our Expert Chefs</h2>
            <p class="section-subtitle">Crafting premium recipes and standardizing flavor profiles.</p>
        </div>

        <div class="row g-4">
            @forelse($chefs as $chef)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="chef-card">
                    <div class="chef-accent-arch"></div>
                    <img src="{{ $chef->image_url }}" alt="{{ $chef->name }}" class="chef-avatar">
                    <h4 class="chef-name">{{ $chef->name }}</h4>
                    <p class="chef-role">{{ $chef->role }}</p>
                    <div class="chef-socials">
                        @if($chef->facebook_url)<a href="{{ $chef->facebook_url }}" target="_blank"><i class="bi bi-facebook"></i></a>@endif
                        @if($chef->instagram_url)<a href="{{ $chef->instagram_url }}" target="_blank"><i class="bi bi-instagram"></i></a>@endif
                        @if($chef->twitter_url)<a href="{{ $chef->twitter_url }}" target="_blank"><i class="bi bi-twitter-x"></i></a>@endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted">
                <p>No expert chefs registered yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- ==========================================
     6. PROMO PAIR BANNERS
     ========================================== -->
<section class="promo-section" id="promos">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-right">
                <div class="promo-banner-card" style="background-color: #E6F4EA;">
                    <div class="promo-banner-text">
                        <h4 class="text-success">Save 30% Offer</h4>
                        <p>On all first-time steamed momos online orders.</p>
                        <a href="{{ route('menu.index') }}" class="btn btn-premium btn-orange btn-sm rounded-pill px-4">Order Now</a>
                    </div>
                    <img src="https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=200&q=80" alt="Promo dish 1" class="promo-banner-img">
                </div>
            </div>

            <div class="col-md-6" data-aos="fade-left">
                <div class="promo-banner-card" style="background-color: #FFF0F0;">
                    <div class="promo-banner-text">
                        <h4 class="text-danger">Get 20% Discount</h4>
                        <p>When purchasing our giant tandoori combos.</p>
                        <a href="{{ route('menu.index') }}" class="btn btn-premium btn-orange btn-sm rounded-pill px-4">Claim Deal</a>
                    </div>
                    <img src="https://images.unsplash.com/photo-1541832676-9b763b0239ab?auto=format&fit=crop&w=200&q=80" alt="Promo dish 2" class="promo-banner-img">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     7. APP DOWNLOAD SECTION
     ========================================== -->
<section class="app-section" id="app">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-badge" style="background-color: rgba(255, 122, 0, 0.15); color: #FF7A00;"><i class="bi bi-phone"></i> Download App</span>
                <h2 class="text-white fw-bold mb-3" style="font-family: var(--font-outfit); font-size: clamp(2rem, 5vw, 3.2rem);">Easy To Order Our All Food</h2>
                <p class="text-white-50 mb-4 fs-5">Get the Gosmomos App today to order piping-hot premium street momos and manage your wallet credits on the go.</p>
                <div class="app-buttons">
                    <a href="#" class="app-btn"><i class="bi bi-apple fs-4"></i> App Store</a>
                    <a href="#" class="app-btn"><i class="bi bi-play-fill fs-4"></i> Google Play</a>
                </div>
            </div>

            <div class="col-lg-6 text-center position-relative" data-aos="fade-left">
                <div class="app-plates-wrap">
                    <img src="https://images.unsplash.com/photo-1541832676-9b763b0239ab?auto=format&fit=crop&w=300&q=80" alt="Momo Plate" class="app-plate-img" style="top: 10px; left: 10%;">
                    <img src="https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=300&q=80" alt="Momo Plate 2" class="app-plate-img" style="bottom: 10px; right: 10%;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     8. CUSTOMER FEEDBACKS
     ========================================== -->
<section class="feedbacks-section" id="feedbacks">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-chat-quote"></i> Testimonials</span>
            <h2 class="section-title">Our Customer Feedbacks</h2>
            <p class="section-subtitle">Real experiences shared by street-food foodies.</p>
        </div>

        <div class="swiper reviewSwiper" data-aos="fade-up">
            <div class="swiper-wrapper">
                @if(isset($reviews) && $reviews->count() > 0)
                    @foreach($reviews as $rev)
                    <div class="swiper-slide">
                        <div class="feedback-card">
                            <div class="feedback-user-avatar d-flex align-items-center justify-content-center fw-bold text-white fs-3" style="background-color: #FF7A00;">
                                {{ strtoupper(substr($rev->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-warning text-center mb-2" style="font-size: 14px;">
                                    @for($r = 1; $r <= 5; $r++)
                                        <i class="bi bi-star-fill {{ $r <= $rev->rating ? 'text-warning' : 'text-muted opacity-25' }}"></i>
                                    @endfor
                                </div>
                                <div class="feedback-quote-icon">“</div>
                                <p class="feedback-text">"{{ Str::limit($rev->comment, 140) }}"</p>
                                @if($rev->image_url)
                                    <div class="text-center mt-3 mb-2">
                                        <img src="{{ $rev->image_url }}" alt="Review photo" class="rounded border" style="max-height: 60px; max-width: 60px; object-fit: cover; cursor: pointer; border-color: rgba(255,255,255,0.15) !important;" onclick="openReviewModal('{{ $rev->image_url }}')">
                                    </div>
                                @endif
                            </div>
                            <div class="text-center mt-3">
                                <h5 class="fw-bold mb-0 text-white" style="font-family: var(--font-outfit);">{{ $rev->user->name }}</h5>
                                <span class="small text-warning d-block mt-1">for <a href="{{ route('menu.show', $rev->product->slug) }}" class="text-warning text-decoration-none fw-bold">{{ $rev->product->name }}</a></span>
                                <span class="small text-white-50" style="font-size: 11px;">{{ $rev->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    @forelse($testimonials as $test)
                    <div class="swiper-slide">
                        <div class="feedback-card">
                            @if($test->avatar)
                                <img src="{{ Str::startsWith($test->avatar, ['http://', 'https://']) ? $test->avatar : asset($test->avatar) }}" alt="{{ $test->name }}" class="feedback-user-avatar" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80';">
                            @else
                                <div class="feedback-user-avatar d-flex align-items-center justify-content-center fw-bold text-white fs-3 bg-primary-color" style="background-color: #FF7A00;">
                                    {{ strtoupper(substr($test->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="feedback-quote-icon">“</div>
                                <p class="feedback-text">"{{ $test->content }}"</p>
                            </div>
                            <div class="text-center mt-3">
                                <h5 class="fw-bold mb-0 text-white" style="font-family: var(--font-outfit);">{{ $test->name }}</h5>
                                <span class="small text-white-50">{{ $test->designation ?? 'Customer' }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="swiper-slide">
                        <div class="feedback-card">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" alt="Customer avatar" class="feedback-user-avatar">
                            <div>
                                <div class="feedback-quote-icon">“</div>
                                <p class="feedback-text">"The taste of chicken kurkure momos is absolutely out of this world! They maintain incredible hygiene standards which is super rare for street food."</p>
                            </div>
                            <div class="text-center mt-3">
                                <h5 class="fw-bold mb-0 text-white" style="font-family: var(--font-outfit);">Rohan Gupta</h5>
                                <span class="small text-white-50">Local Guide Lucknow</span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="feedback-card">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" alt="Customer avatar" class="feedback-user-avatar">
                            <div>
                                <div class="feedback-quote-icon">“</div>
                                <p class="feedback-text">"Outstanding service! Ordering online is super fast, and the packaging keeps the momos crisp. Signature veg steam is highly recommended!"</p>
                            </div>
                            <div class="text-center mt-3">
                                <h5 class="fw-bold mb-0 text-white" style="font-family: var(--font-outfit);">Sneha Verma</h5>
                                <span class="small text-white-50">Noida Tech Professional</span>
                            </div>
                        </div>
                    </div>
                    @endforelse
                @endif
            </div>
            <div class="swiper-pagination"></div>
            <!-- Swiper Navigation Arrows -->
            <div class="swiper-button-next d-none d-md-flex" style="color: #FF7A00;"></div>
            <div class="swiper-button-prev d-none d-md-flex" style="color: #FF7A00;"></div>
        </div>
    </div>
</section>

<!-- ==========================================
     9. COUNTERS SECTION
     ========================================== -->
<section class="counters-section" id="stats">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="0">
                <div class="counter-item">
                    <div class="counter-circle">1700+</div>
                    <div class="counter-label">Happy Customers</div>
                </div>
            </div>

            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="100">
                <div class="counter-item">
                    <div class="counter-circle">20+</div>
                    <div class="counter-label">Active Outlets</div>
                </div>
            </div>

            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="counter-item">
                    <div class="counter-circle">15000+</div>
                    <div class="counter-label">Orders Completed</div>
                </div>
            </div>

            <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="300">
                <div class="counter-item">
                    <div class="counter-circle">5+</div>
                    <div class="counter-label">National Awards</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     10. LATEST FOOD BLOGS
     ========================================== -->
<section class="blogs-section" id="blogs">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <span class="section-badge"><i class="bi bi-newspaper"></i> News & Blogs</span>
            <h2 class="section-title">Our Latest Foods Blog</h2>
            <p class="section-subtitle">Catch up on food tech reviews, kitchen tips, and new recipes.</p>
        </div>

        <div class="row g-4">
            @forelse($blogs as $blog)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="blog-card">
                    <div class="blog-img-wrap">
                        <img src="{{ $blog->image_url ?? 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=600&q=80' }}" alt="{{ $blog->title }}" class="blog-img">
                        @if($blog->category)
                        <span class="blog-badge">{{ $blog->category->name }}</span>
                        @endif
                    </div>
                    <div class="blog-body">
                        <div class="blog-meta">
                            <span><i class="bi bi-calendar3 text-primary-color me-1"></i> {{ $blog->published_at ? $blog->published_at->format('M d, Y') : $blog->created_at->format('M d, Y') }}</span>
                            <span><i class="bi bi-person text-primary-color me-1"></i> {{ $blog->author->name ?? 'Admin' }}</span>
                        </div>
                        <h4 class="blog-title">{{ $blog->title }}</h4>
                        <p class="blog-excerpt">{{ Str::limit(strip_tags($blog->excerpt ?? $blog->content), 120) }}</p>
                        <a href="{{ route('blog.show', $blog->slug) }}" class="blog-link">Read More <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted">
                <p>No food blogs published yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Review Image Modal --}}
<div class="modal fade" id="reviewImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body p-0 text-center position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <img id="modalReviewImage" src="" class="img-fluid rounded-4 shadow-lg" style="max-height: 80vh; object-fit: contain;">
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // JS Filtering function for dynamic catalog
    function filterMenu(categorySlug) {
        // Toggle active class on tabs
        const tabs = document.querySelectorAll('.filter-tab');
        tabs.forEach(tab => {
            tab.classList.remove('active');
            if (tab.innerText.toLowerCase() === categorySlug.replace('-', ' ').toLowerCase() || 
                (categorySlug === 'all' && tab.innerText.toLowerCase() === 'all')) {
                tab.classList.add('active');
            }
        });

        // Filter items
        const items = document.querySelectorAll('.menu-item');
        items.forEach(item => {
            if (categorySlug === 'all') {
                item.style.display = 'block';
            } else {
                if (item.getAttribute('data-category') === categorySlug) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            }
        });
    }

    function openReviewModal(url) {
        $('#modalReviewImage').attr('src', url);
        new bootstrap.Modal(document.getElementById('reviewImageModal')).show();
    }

    $(document).ready(function() {
        // Initialize Testimonials Swiper
        const testimonialSwiper = new Swiper('.reviewSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30
                }
            }
        });

        // AJAX Add to Cart listener
        $(document).on('click', '.add-to-cart-btn', function(e) {
            e.preventDefault();
            const btn = $(this);
            const productId = btn.data('product-id');
            const productName = btn.data('product-name') || 'Item';

            $.ajax({
                url: "{{ route('cart.add') }}",
                method: "POST",
                data: {
                    product_id: productId,
                    quantity: 1
                },
                success: function(response) {
                    if (response.success) {
                        updateGlobalCartCounts();
                        
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: `${productName} added to cart!`,
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to add item',
                            text: response.message || 'Please try again.'
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = "{{ route('login') }}";
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please check your network connection.'
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
