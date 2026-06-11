<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'GOS MOMO — The Taste India Will Queue For')</title>
    
    <!-- Meta tags for SEO & PWA -->
    <meta name="description" content="@yield('meta_description', 'GOS MOMO serves premium, hygienic and crispy street-style momos in Lucknow & Noida. Explore franchise, events, and online ordering.')">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0F5132">

    <!-- Fonts: Poppins, Outfit, Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/style.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Let's load the correct Bootstrap 5 css file link from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Swiper.js & AOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom Premium Design System CSS -->
    <style>
        :root {
            --primary-color: #0F5132;
            --secondary-color: #D4A017;
            --accent-color: #E63946;
            --bg-color: #FFF8F0;
            --surface-color: #FFFFFF;
            --text-color: #1A1A2E;
            --text-muted: #6C757D;
            --font-poppins: 'Poppins', sans-serif;
            --font-outfit: 'Outfit', sans-serif;
            --font-inter: 'Inter', sans-serif;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-soft: 0 8px 30px rgba(15, 81, 50, 0.05);
            --shadow-glass: 0 8px 32px 0 rgba(15, 81, 50, 0.08);
            --border-glass: 1px solid rgba(255, 255, 255, 0.4);
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
            box-shadow: 0 12px 40px 0 rgba(15, 81, 50, 0.12);
        }

        /* Premium Buttons */
        .btn-premium {
            background: linear-gradient(135deg, var(--primary-color) 0%, #157347 100%);
            color: white;
            border: none;
            border-radius: 30px;
            padding: 10px 24px;
            font-family: var(--font-outfit);
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(15, 81, 50, 0.2);
            transition: var(--transition-smooth);
        }

        .btn-premium:hover {
            background: linear-gradient(135deg, #157347 0%, var(--primary-color) 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(15, 81, 50, 0.3);
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #B38613 100%);
            color: white;
            border: none;
            border-radius: 30px;
            padding: 10px 24px;
            font-family: var(--font-outfit);
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(212, 160, 23, 0.2);
            transition: var(--transition-smooth);
        }

        .btn-gold:hover {
            background: linear-gradient(135deg, #B38613 0%, var(--secondary-color) 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 160, 23, 0.3);
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
            color: var(--primary-color);
            letter-spacing: 1px;
        }

        .navbar-brand-text span {
            color: var(--secondary-color);
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
            background-color: rgba(15, 81, 50, 0.08);
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
            border-top: 1px solid rgba(15, 81, 50, 0.1);
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
            background-color: var(--accent-color);
            color: white;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            box-shadow: 0 4px 15px rgba(230, 57, 70, 0.4);
            z-index: 998;
            transition: var(--transition-smooth);
            text-decoration: none;
        }

        .btn-floating-cart:hover {
            color: white;
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(230, 57, 70, 0.6);
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
            background-color: #072a1a;
            color: #d1e7dd;
            padding: 60px 0 30px;
            font-family: var(--font-inter);
        }

        .footer-logo {
            font-family: var(--font-outfit);
            font-weight: 800;
            color: var(--surface-color);
            letter-spacing: 1px;
        }

        .footer-logo span {
            color: var(--secondary-color);
        }

        .footer-link {
            color: #a3cfbb;
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        .footer-link:hover {
            color: var(--secondary-color);
            padding-left: 5px;
        }

        /* Custom utilities */
        .text-primary-color { color: var(--primary-color) !important; }
        .text-secondary-color { color: var(--secondary-color) !important; }
        .text-accent-color { color: var(--accent-color) !important; }

        .bg-primary-color { background-color: var(--primary-color) !important; }
        .bg-secondary-color { background-color: var(--secondary-color) !important; }
        .bg-accent-color { background-color: var(--accent-color) !important; }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Header Navbar (Desktop) -->
    <nav class="navbar navbar-expand-lg navbar-gos sticky-top py-3 d-none d-lg-block">
        <div class="container">
            <a class="navbar-brand navbar-brand-text" href="{{ route('home') }}">
                GOS <span>MOMO</span>
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
                        <a href="{{ Auth::user()->hasRole('customer') ? route('customer.dashboard') : route('admin.dashboard') }}" class="btn btn-premium d-flex align-items-center gap-2">
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
    <header class="d-lg-none py-3 px-3 bg-white border-bottom sticky-top shadow-sm z-3">
        <div class="d-flex justify-content-between align-items-center">
            <a class="navbar-brand-text fs-3 text-decoration-none" href="{{ route('home') }}">
                GOS <span>MOMO</span>
            </a>
            
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('cart.index') }}" class="position-relative text-dark fs-4 p-2 text-decoration-none">
                    <i class="bi bi-cart3"></i>
                    <span class="cart-badge d-none" id="mobile-cart-badge">0</span>
                </a>
                @auth
                    <a href="{{ Auth::user()->hasRole('customer') ? route('customer.dashboard') : route('admin.dashboard') }}" class="text-dark fs-4 p-2">
                        <i class="bi bi-person-circle"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-premium btn-sm py-1 px-3">Login</a>
                @endauth
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
                    <h3 class="footer-logo mb-3">GOS <span>MOMO</span></h3>
                    <p class="mb-4">Crafting the crunchiest, most delicious, and hygienic street-style momos in India. A proud brand of Mahoksh Core.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 38px; height: 38px;"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 38px; height: 38px;"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle p-2" style="width: 38px; height: 38px;"><i class="bi bi-twitter-x"></i></a>
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
                    <h5 class="text-white mb-3">Business</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2">
                        <li><a href="{{ route('franchise.index') }}" class="footer-link">Why Franchise</a></li>
                        <li><a href="{{ route('franchise.index') }}#models" class="footer-link">Cart Model</a></li>
                        <li><a href="{{ route('franchise.index') }}#apply" class="footer-link">Apply Now</a></li>
                        <li><a href="{{ route('blog.index') }}" class="footer-link">Blogs</a></li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h5 class="text-white mb-3">Head Office</h5>
                    <p class="mb-2"><i class="bi bi-geo-alt-fill text-secondary-color me-2"></i> Noida, Uttar Pradesh, India</p>
                    <p class="mb-2"><i class="bi bi-telephone-fill text-secondary-color me-2"></i> +91 88888 77777</p>
                    <p class="mb-2"><i class="bi bi-envelope-fill text-secondary-color me-2"></i> info@gosmomo.com</p>
                    <p class="mb-0"><i class="bi bi-clock-fill text-secondary-color me-2"></i> Lucknow Cart: 12 PM - 11 PM</p>
                </div>
            </div>
            
            <hr class="border-light opacity-10 my-4">
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <p class="mb-0 small text-center">&copy; {{ date('Y') }} GOS MOMO. All Rights Reserved. Owned by <strong>Mahoksh Core</strong>.</p>
                <div class="d-flex gap-3 small">
                    <a href="#" class="text-decoration-none footer-link">Privacy Policy</a>
                    <span class="text-muted">|</span>
                    <a href="#" class="text-decoration-none footer-link">Terms of Service</a>
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
            <a href="{{ Auth::user()->hasRole('customer') ? route('customer.dashboard') : route('admin.dashboard') }}" class="bottom-nav-item {{ Route::currentRouteName() == 'customer.dashboard' ? 'active' : '' }}">
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
    <a href="https://wa.me/918888877777" target="_blank" class="btn-floating-whatsapp" title="Chat on WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>
    
    <a href="{{ route('cart.index') }}" class="btn-floating-cart d-none d-lg-flex" id="floating-cart-btn" title="View Cart">
        <i class="bi bi-cart3"></i>
        <span class="cart-badge d-none" id="floating-cart-badge">0</span>
    </a>

    <!-- Core Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        // Initialize AOS animations
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

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
