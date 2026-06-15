<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', setting('seo_meta_title', 'GOS MOMO — The Taste India Will Queue For'))</title>
    
    <!-- Meta tags for SEO & PWA -->
    <meta name="description" content="@yield('meta_description', setting('seo_meta_description', 'GOS MOMO serves premium, hygienic and crispy street-style momos. Explore franchise, events, and online ordering.'))">
    <meta name="keywords" content="@yield('meta_keywords', setting('seo_meta_keywords', 'gos momo, street momos, franchise, lucknow momo, noida momo'))">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#FF7A00">

    @if(setting('favicon'))
        <link rel="icon" type="image/x-icon" href="{{ asset(setting('favicon')) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif
    
    @if(setting('og_image'))
        <meta property="og:image" content="{{ asset(setting('og_image')) }}">
    @endif

    <!-- Fonts: Poppins, Outfit, Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Swiper.js & AOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom Premium Design System CSS (Aligned to attached layout theme) -->
    <style>
        :root {
            --primary-color: #FF7A00; /* Vibrant Orange */
            --secondary-color: #0E101A; /* Deep Navy Blue */
            --accent-color: #FF7A00;
            --bg-color: #FAF9F6; /* Cream/Soft Beige background */
            --surface-color: #FFFFFF;
            --text-color: #0E101A;
            --text-muted: #6C757D;
            --font-poppins: 'Poppins', sans-serif;
            --font-outfit: 'Outfit', sans-serif;
            --font-inter: 'Inter', sans-serif;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-soft: 0 8px 30px rgba(255, 122, 0, 0.05);
            --shadow-glass: 0 8px 32px 0 rgba(255, 122, 0, 0.08);
            --border-glass: 1px solid rgba(255, 255, 255, 0.4);
        }

        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: var(--font-poppins);
            overflow-x: hidden;
            padding-bottom: 70px; /* Space for bottom nav on mobile */
        }

        @media (min-width: 992px) {
            body {
                padding-bottom: 0;
            }
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-outfit);
            font-weight: 700;
        }

        /* Glassmorphism Class */
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: var(--border-glass);
            border-radius: 16px;
            box-shadow: var(--shadow-glass);
            transition: var(--transition-smooth);
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px 0 rgba(255, 122, 0, 0.12);
        }

        /* Premium Buttons */
        .btn-premium {
            background: linear-gradient(135deg, var(--primary-color) 0%, #E26C00 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            font-family: var(--font-outfit);
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(255, 122, 0, 0.2);
            transition: var(--transition-smooth);
        }

        .btn-premium:hover {
            background: linear-gradient(135deg, #E26C00 0%, var(--primary-color) 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 122, 0, 0.3);
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--primary-color) 0%, #D86800 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            font-family: var(--font-outfit);
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(255, 122, 0, 0.2);
            transition: var(--transition-smooth);
        }

        .btn-gold:hover {
            background: linear-gradient(135deg, #D86800 0%, var(--primary-color) 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 122, 0, 0.3);
        }

        /* Global button border-radius overrides */
        .btn, .btn.rounded-pill, .btn-premium, .btn-gold, .btn-add, .btn-large-cart, .filter-chip, .filter-tab, .app-btn {
            border-radius: 8px !important;
        }

        /* Navbar Styling */
        .navbar-gos {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: var(--border-glass);
            box-shadow: var(--shadow-soft);
            z-index: 1000;
            transition: var(--transition-smooth);
        }

        .navbar-brand-text {
            font-family: var(--font-outfit);
            font-weight: 800;
            color: var(--secondary-color);
            letter-spacing: 1px;
        }

        .navbar-brand-text span {
            color: var(--primary-color);
        }

        .nav-link-gos {
            color: var(--text-color);
            font-family: var(--font-inter);
            font-weight: 500;
            padding: 8px 16px !important;
            border-radius: 20px;
            transition: var(--transition-smooth);
        }

        .nav-link-gos:hover, .nav-link-gos.active {
            color: var(--primary-color) !important;
            background-color: rgba(255, 122, 0, 0.08);
        }

        /* Floating Bottom Nav for Mobile */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-top: 1px solid rgba(255, 122, 0, 0.1);
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            z-index: 999;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
        }

        .bottom-nav-item {
            text-align: center;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 11px;
            font-weight: 500;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: var(--transition-smooth);
        }

        .bottom-nav-item i {
            font-size: 20px;
            margin-bottom: 2px;
        }

        .bottom-nav-item.active {
            color: var(--primary-color);
            font-weight: 700;
        }

        /* Floating buttons */
        .btn-floating-whatsapp {
            position: fixed;
            bottom: 80px;
            right: 20px;
            background-color: #25D366;
            color: white;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
            z-index: 998;
            transition: var(--transition-smooth);
        }

        .btn-floating-whatsapp:hover {
            color: white;
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
        }

        /* Sticky Float Cart */
        .btn-floating-cart {
            position: fixed;
            bottom: 80px;
            left: 20px;
            background-color: var(--primary-color);
            color: white;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            box-shadow: 0 4px 15px rgba(255, 122, 0, 0.4);
            z-index: 998;
            transition: var(--transition-smooth);
            text-decoration: none;
        }

        .btn-floating-cart:hover {
            color: white;
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(255, 122, 0, 0.6);
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--secondary-color);
            color: white;
            border-radius: 50%;
            padding: 3px 7px;
            font-size: 10px;
            font-weight: bold;
        }

        /* Footer styling */
        .footer-gos {
            background-color: var(--secondary-color);
            color: #d1e7dd;
            padding: 60px 0 30px;
            font-family: var(--font-inter);
            border-top: 5px solid var(--primary-color);
        }

        .footer-logo {
            font-family: var(--font-outfit);
            font-weight: 800;
            color: var(--surface-color);
            letter-spacing: 1px;
        }

        .footer-logo span {
            color: var(--primary-color);
        }

        .footer-link {
            color: #a5b4fc;
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        .footer-link:hover {
            color: var(--primary-color);
            padding-left: 5px;
        }

        /* Custom utilities */
        .text-primary-color { color: var(--primary-color) !important; }
        .text-secondary-color { color: var(--secondary-color) !important; }
        
        .bg-primary-color { background-color: var(--primary-color) !important; }
        .bg-secondary-color { background-color: var(--secondary-color) !important; }

        /* Global Mobile Responsiveness & Text Scaling Overrides */
        @media (max-width: 575.98px) {
            h1, .hero-heading {
                font-size: 2.2rem !important;
                line-height: 1.25 !important;
            }
            h2, .section-title {
                font-size: 1.8rem !important;
            }
            h3 {
                font-size: 1.5rem !important;
            }
            .section-subtitle {
                font-size: 0.9rem !important;
                margin-bottom: 25px !important;
            }
            .theme-hero {
                padding: 60px 0 !important;
            }
            .hero-desc {
                font-size: 0.95rem !important;
                margin-bottom: 24px !important;
            }
            .reserve-card {
                padding: 24px !important;
            }
            .reserve-title {
                font-size: 22px !important;
                margin-bottom: 16px !important;
            }
            .feedback-card {
                padding: 50px 20px 30px !important;
            }
            .feedback-text {
                font-size: 13.5px !important;
            }
        }

        /* Unified Breadcrumb/Hero Styling with Background Image */
        .page-hero {
            position: relative;
            background-size: cover;
            background-position: center;
            background-attachment: scroll;
            padding: 100px 0 80px;
            color: white;
            text-align: center;
            overflow: hidden;
            z-index: 1;
        }
        
        /* Mobile background */
        @media (max-width: 575.98px) {
            .page-hero {
                background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/breadcrumb-mobile.jpg') }}');
                background-size: cover;
                background-position: center;
            }
        }
        
        /* Tablet background */
        @media (min-width: 576px) and (max-width: 991.98px) {
            .page-hero {
                background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/breadcrumb-tablet.png') }}');
                background-size: cover;
                background-position: center;
            }
        }
        
        /* Laptop background */
        @media (min-width: 992px) and (max-width: 1199.98px) {
            .page-hero {
                background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/breadcrumb-laptop.png') }}');
                background-size: cover;
                background-position: center;
            }
        }
        
        /* Desktop background */
        @media (min-width: 1200px) {
            .page-hero {
                background: linear-gradient(180deg, rgba(14, 16, 26, 0.82) 0%, rgba(255, 122, 0, 0.65) 100%), url('{{ asset('images/breadcrumb-desktop.jpg') }}');
                background-size: cover;
                background-position: center;
            }
        }
        .page-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M54 48c-2 0-3 1-4 2v4c0 1 1 2 2 2h4c1 0 2-1 2-2v-4c-1-1-2-2-4-2zM6 48c-2 0-3 1-4 2v4c0 1 1 2 2 2h4c1 0 2-1 2-2v-4c-1-1-2-2-4-2z' fill='%23ffffff' fill-opacity='0.02' fill-rule='evenodd'/%3E%3C/svg%3E");
            z-index: -1;
        }
        .page-hero .breadcrumb {
            justify-content: center;
            font-size: 14px;
        }
        .page-hero .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.6) !important;
        }
        .page-hero .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.2s;
        }
        .page-hero .breadcrumb-item a:hover {
            color: var(--primary-color);
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Top Bar (Desktop) -->
    <div class="py-2 text-white d-none d-lg-block" style="background-color: var(--secondary-color); border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 13px; font-family: var(--font-inter); position: relative; overflow: hidden;">
        <!-- skewed decorative orange bar -->
        <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 45%; background-color: var(--primary-color); transform: skewX(-25deg); transform-origin: top left; z-index: 1;"></div>
        
        <div class="container d-flex justify-content-between align-items-center" style="position: relative; z-index: 2;">
            <div class="d-flex align-items-center gap-4">
                <span class="text-white"><i class="bi bi-telephone-fill me-2"></i>{{ setting('contact_phone', '+91 88888 77777') }}</span>
                <span class="text-white-50">|</span>
                <span class="text-white"><i class="bi bi-envelope-fill me-2"></i>{{ setting('contact_email', 'info@gosmomo.com') }}</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                @if(setting('facebook_url'))
                    <a href="{{ setting('facebook_url') }}" target="_blank" class="text-white text-decoration-none" title="Facebook"><i class="bi bi-facebook"></i></a>
                @endif
                @if(setting('instagram_url'))
                    <a href="{{ setting('instagram_url') }}" target="_blank" class="text-white text-decoration-none" title="Instagram"><i class="bi bi-instagram"></i></a>
                @endif
                @if(setting('twitter_url'))
                    <a href="{{ setting('twitter_url') }}" target="_blank" class="text-white text-decoration-none" title="Twitter/X"><i class="bi bi-twitter-x"></i></a>
                @endif
                @if(setting('youtube_url'))
                    <a href="{{ setting('youtube_url') }}" target="_blank" class="text-white text-decoration-none" title="YouTube"><i class="bi bi-youtube"></i></a>
                @endif
                @if(setting('linkedin_url'))
                    <a href="{{ setting('linkedin_url') }}" target="_blank" class="text-white text-decoration-none" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                @endif
            </div>
        </div>
    </div>

    <!-- Header Navbar (Desktop) -->
    <nav class="navbar navbar-expand-lg navbar-gos sticky-top py-3 d-none d-lg-block">
        <div class="container">
            <a class="navbar-brand navbar-brand-text d-flex align-items-center gap-2" href="{{ route('home') }}">
                @if(setting('logo'))
                    <img src="{{ asset(setting('logo')) }}" alt="{{ setting('site_name', 'GOS MOMO') }}" style="max-height: 80px; height: 80px; width: auto; object-fit: contain; image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;">
                @else
                    GOS <span>MOMO</span>
                @endif
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-2">
                    <li class="nav-item">
                        <a class="nav-link nav-link-gos {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-gos {{ Route::currentRouteName() == 'menu.index' ? 'active' : '' }}" href="{{ route('menu.index') }}">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-gos {{ Route::currentRouteName() == 'our-story' ? 'active' : '' }}" href="{{ route('our-story') }}">Our Story</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-gos {{ Route::currentRouteName() == 'franchise.index' ? 'active' : '' }}" href="{{ route('franchise.index') }}">Franchise</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-gos {{ Route::currentRouteName() == 'locations' ? 'active' : '' }}" href="{{ route('locations') }}">Locations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-gos {{ Route::currentRouteName() == 'catering' ? 'active' : '' }}" href="{{ route('catering') }}">Catering</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('cart.index') }}" class="position-relative text-dark fs-4 nav-link-gos p-2">
                        <i class="bi bi-cart3"></i>
                        <span class="cart-badge d-none" id="desktop-cart-count">0</span>
                    </a>
                    
                    @auth
                        <a href="{{ Auth::user()->hasRole('customer') ? route('customer.dashboard') : (Auth::user()->hasRole('delivery_partner') ? route('delivery.dashboard') : (Auth::user()->hasRole('franchise_partner') ? route('franchise.dashboard') : route('admin.dashboard'))) }}" class="btn btn-premium d-flex align-items-center gap-2">
                            <i class="bi bi-person-circle"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-premium d-flex align-items-center gap-2">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Header -->
    <header class="d-lg-none py-2 px-3 bg-white border-bottom sticky-top shadow-sm z-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-link text-dark p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavbarContent" aria-controls="mobileNavbarContent" aria-expanded="false" aria-label="Toggle navigation" style="box-shadow: none;">
                    <i class="bi bi-list fs-2"></i>
                </button>
                <a class="navbar-brand-text fs-3 text-decoration-none" href="{{ route('home') }}">
                    @if(setting('logo'))
                        <img src="{{ asset(setting('logo')) }}" alt="{{ setting('site_name', 'GOS MOMO') }}" style="max-height: 50px; height: 50px; width: auto; object-fit: contain; image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;">
                    @else
                        GOS <span>MOMO</span>
                    @endif
                </a>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('cart.index') }}" class="position-relative text-dark fs-4 p-2 text-decoration-none">
                    <i class="bi bi-cart3"></i>
                    <span class="cart-badge d-none" id="mobile-cart-badge">0</span>
                </a>
                @auth
                    <a href="{{ Auth::user()->hasRole('customer') ? route('customer.dashboard') : (Auth::user()->hasRole('delivery_partner') ? route('delivery.dashboard') : (Auth::user()->hasRole('franchise_partner') ? route('franchise.dashboard') : route('admin.dashboard'))) }}" class="text-dark fs-4 p-2">
                        <i class="bi bi-person-circle"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-premium btn-sm py-1 px-3">Login</a>
                @endauth
            </div>
        </div>

        <!-- Collapsible Content for Mobile -->
        <div class="collapse" id="mobileNavbarContent">
            <div class="pt-2 pb-2 border-top mt-2">
                <ul class="navbar-nav gap-2">
                    <li class="nav-item">
                        <a class="nav-link nav-link-gos py-2 px-3 {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-gos py-2 px-3 {{ Route::currentRouteName() == 'menu.index' ? 'active' : '' }}" href="{{ route('menu.index') }}">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-gos py-2 px-3 {{ Route::currentRouteName() == 'our-story' ? 'active' : '' }}" href="{{ route('our-story') }}">Our Story</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-gos py-2 px-3 {{ Route::currentRouteName() == 'franchise.index' ? 'active' : '' }}" href="{{ route('franchise.index') }}">Franchise</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-gos py-2 px-3 {{ Route::currentRouteName() == 'locations' ? 'active' : '' }}" href="{{ route('locations') }}">Locations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-gos py-2 px-3 {{ Route::currentRouteName() == 'catering' ? 'active' : '' }}" href="{{ route('catering') }}">Catering</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-gos">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <h3 class="footer-logo mb-3">
                        @if(setting('logo_dark'))
                            <img src="{{ asset(setting('logo_dark')) }}" alt="{{ setting('site_name', 'GOS MOMO') }}" style="max-height: 100px; height: 100px; width: auto; object-fit: contain; image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;">
                        @elseif(setting('logo'))
                            <img src="{{ asset(setting('logo')) }}" alt="{{ setting('site_name', 'GOS MOMO') }}" style="max-height: 100px; height: 100px; width: auto; object-fit: contain; image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;">
                        @else
                            {{ setting('site_name', 'GOS MOMO') }}
                        @endif
                    </h3>
                    <p class="mb-4">{{ setting('tagline', 'The Taste India Will Queue For') }}. Crafting the crunchiest, most delicious, and hygienic street-style momos in India.</p>
                    <div class="d-flex gap-3">
                        @if(setting('facebook_url'))
                            <a href="{{ setting('facebook_url') }}" target="_blank" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-facebook"></i></a>
                        @endif
                        @if(setting('instagram_url'))
                            <a href="{{ setting('instagram_url') }}" target="_blank" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-instagram"></i></a>
                        @endif
                        @if(setting('twitter_url'))
                            <a href="{{ setting('twitter_url') }}" target="_blank" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-twitter-x"></i></a>
                        @endif
                        @if(setting('youtube_url'))
                            <a href="{{ setting('youtube_url') }}" target="_blank" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-youtube"></i></a>
                        @endif
                        @if(setting('linkedin_url'))
                            <a href="{{ setting('linkedin_url') }}" target="_blank" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-linkedin"></i></a>
                        @endif
                    </div>
                </div>
                
                <div class="col-md-2 col-6">
                    <h5 class="text-white mb-3">Quick Links</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="{{ route('menu.index') }}" class="footer-link">Our Menu</a></li>
                        <li><a href="{{ route('our-story') }}" class="footer-link">Our Story</a></li>
                        <li><a href="{{ route('locations') }}" class="footer-link">Locations</a></li>
                        <li><a href="{{ route('catering') }}" class="footer-link">Catering</a></li>
                    </ul>
                </div>

                <div class="col-md-2 col-6">
                    <h5 class="text-white mb-3">Legal & CMS</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="/pages/about-us" class="footer-link">About Us</a></li>
                        <li><a href="/pages/privacy-policy" class="footer-link">Privacy Policy</a></li>
                        <li><a href="/pages/terms-and-conditions" class="footer-link">Terms & Conditions</a></li>
                        <li><a href="/pages/refund-policy" class="footer-link">Refund Policy</a></li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h5 class="text-white mb-3">Head Office</h5>
                    <p class="mb-2"><i class="bi bi-geo-alt-fill text-primary-color me-2"></i> {{ setting('head_office_address', 'Noida, Uttar Pradesh, India') }}</p>
                    <p class="mb-2"><i class="bi bi-telephone-fill text-primary-color me-2"></i> {{ setting('contact_phone', '+91 88888 77777') }}</p>
                    <p class="mb-2"><i class="bi bi-envelope-fill text-primary-color me-2"></i> {{ setting('contact_email', 'info@gosmomo.com') }}</p>
                    <p class="mb-0"><i class="bi bi-clock-fill text-primary-color me-2"></i> Lucknow Cart: 12 PM - 11 PM</p>
                </div>
            </div>
            
            <hr class="border-light opacity-10 my-4">
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="d-flex flex-column flex-md-row align-items-center gap-2 text-center text-md-start">
                    <p class="mb-0 small">&copy; {{ date('Y') }} {{ setting('site_name', 'GOS MOMO') }}. All Rights Reserved. Owned by <strong>{{ setting('brand_owner') == 'Mahoksh Core' ? 'Mahoksh' : setting('brand_owner', 'Mahoksh') }}</strong>.</p>
                    <span class="d-none d-md-inline text-muted opacity-50">|</span>
                    <p class="mb-0 small d-flex align-items-center gap-1 justify-content-center">
                        Created by 
                        <a href="https://mirashka.digital" target="_blank" class="d-inline-flex align-items-center" title="Mirashka">
                            <img src="{{ asset('images/mirashka-logo.png') }}" alt="Mirashka" style="height: 14px; width: auto; vertical-align: middle; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.15)'" onmouseout="this.style.transform='scale(1)'">
                        </a>
                    </p>
                </div>
                <div class="d-flex gap-3 small">
                    <a href="/pages/privacy-policy" class="text-decoration-none footer-link">Privacy Policy</a>
                    <span class="text-muted">|</span>
                    <a href="/pages/terms-and-conditions" class="text-decoration-none footer-link">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Bottom Navigation -->
    <div class="bottom-nav d-lg-none">
        <a href="{{ route('home') }}" class="bottom-nav-item {{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
            <i class="bi bi-house-door"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('menu.index') }}" class="bottom-nav-item {{ Route::currentRouteName() == 'menu.index' ? 'active' : '' }}">
            <i class="bi bi-card-checklist"></i>
            <span>Menu</span>
        </a>
        <a href="{{ route('cart.index') }}" class="bottom-nav-item {{ Route::currentRouteName() == 'cart.index' ? 'active' : '' }}">
            <div class="position-relative">
                <i class="bi bi-cart3"></i>
                <span class="cart-badge d-none" id="mobile-bottom-cart-badge">0</span>
            </div>
            <span>Cart</span>
        </a>
        <a href="{{ route('franchise.index') }}" class="bottom-nav-item {{ Route::currentRouteName() == 'franchise.index' ? 'active' : '' }}">
            <i class="bi bi-briefcase"></i>
            <span>Franchise</span>
        </a>
        @auth
            <a href="{{ Auth::user()->hasRole('customer') ? route('customer.dashboard') : (Auth::user()->hasRole('delivery_partner') ? route('delivery.dashboard') : (Auth::user()->hasRole('franchise_partner') ? route('franchise.dashboard') : route('admin.dashboard'))) }}" class="bottom-nav-item {{ in_array(Route::currentRouteName(), ['customer.dashboard', 'delivery.dashboard', 'admin.dashboard']) ? 'active' : '' }}">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="bottom-nav-item {{ Route::currentRouteName() == 'login' ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Login</span>
            </a>
        @endauth
    </div>

    <!-- Floating Buttons -->
    <a href="https://wa.me/{{ setting('whatsapp_number', '918888877777') }}" target="_blank" class="btn-floating-whatsapp" title="Chat on WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>
    
    <a href="{{ route('cart.index') }}" class="btn-floating-cart d-none d-lg-flex" id="floating-cart-btn" title="View Cart">
        <i class="bi bi-cart3"></i>
        <span class="cart-badge d-none" id="floating-cart-badge">0</span>
    </a>

    <!-- Core Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        // Setup default CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize AOS animations
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Global SweetAlert Toast Setup
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Flash Toast notifications if present in session
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        @if($errors->any())
            Toast.fire({
                icon: 'error',
                title: '{{ $errors->first() }}'
            });
        @endif

        // AJAX Cart Count Auto Updater
        function updateGlobalCartCounts() {
            $.ajax({
                url: "{{ route('cart.data') }}",
                method: "GET",
                success: function(response) {
                    if (response.success && response.total_items > 0) {
                        // Desktop & Mobile Badges
                        $('#desktop-cart-count, #mobile-cart-badge, #mobile-bottom-cart-badge, #floating-cart-badge')
                            .text(response.total_items)
                            .removeClass('d-none');
                    } else {
                        $('#desktop-cart-count, #mobile-cart-badge, #mobile-bottom-cart-badge, #floating-cart-badge')
                            .addClass('d-none');
                    }
                }
            });
        }

        $(document).ready(function() {
            updateGlobalCartCounts();
            
            // Show floating cart on scroll down on desktop
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    $('#floating-cart-btn').removeClass('d-none').addClass('d-flex');
                } else {
                    $('#floating-cart-btn').addClass('d-none').removeClass('d-flex');
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
