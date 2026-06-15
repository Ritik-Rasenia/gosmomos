<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Panel — GOS MOMO')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ setting('favicon') ? asset(setting('favicon')) : asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Admin Dashboard CSS (Orange & Deep Navy Theme) -->
    <style>
        :root {
            --primary-color: #FF7A00; /* Vibrant Orange */
            --secondary-color: #0E101A; /* Dark Navy */
            --accent-color: #FF7A00;
            --sidebar-width: 260px;
            --bg-color: #FAF9F6; /* Cream/Soft Beige background */
            --surface-color: #ffffff;
            --text-color: #0E101A;
            --text-muted: #6c757d;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            overflow-x: hidden;
            font-size: 13px; /* Clean, smaller typography */
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, var(--secondary-color) 0%, #06070B 100%);
            color: #d1e7dd;
            z-index: 100;
            transition: var(--transition-smooth);
            box-shadow: 4px 0 15px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 20px;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 20px;
            letter-spacing: 1px;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            text-align: center;
        }

        .sidebar-brand span {
            color: var(--primary-color);
        }

        .sidebar-menu {
            padding: 10px 0;
            overflow-y: auto;
            flex-grow: 1;
        }

        /* Custom scrollbar for sidebar menu Aligned to theme */
        .sidebar-menu::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-menu::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.15);
        }
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 122, 0, 0.25);
            border-radius: 10px;
        }
        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 122, 0, 0.55);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 9px 20px;
            color: #a5b4fc;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 13px;
            transition: var(--transition-smooth);
            border-left: 4px solid transparent;
        }

        .sidebar-link i {
            font-size: 16px;
            margin-right: 12px;
        }

        .sidebar-link:hover, .sidebar-link.active {
            color: white;
            background-color: rgba(255, 122, 0, 0.1);
            border-left-color: var(--primary-color);
        }

        /* Main Content Styling */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: var(--transition-smooth);
        }

        .top-navbar {
            background-color: var(--surface-color);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-area {
            flex: 1;
            padding: 24px;
        }

        /* Admin UI Cards */
        .admin-card {
            background-color: var(--surface-color);
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            transition: var(--transition-smooth);
            border: 1px solid rgba(0,0,0,0.03);
        }

        .admin-card:hover {
            box-shadow: 0 6px 18px rgba(0,0,0,0.04);
            transform: translateY(-1px);
        }

        .stat-card {
            padding: 20px;
            border-left: 4px solid var(--primary-color);
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--secondary-color);
            font-family: 'Outfit', sans-serif;
        }

        .stat-title {
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        
        .bg-orange-subtle {
            background-color: rgba(255, 122, 0, 0.08) !important;
        }
        
        .text-orange {
            color: #FF7A00 !important;
        }
        
        .btn-orange {
            background-color: #FF7A00;
            color: white;
            border: none;
            transition: var(--transition-smooth);
        }
        .btn-orange:hover {
            background-color: #E26C00;
            color: white;
        }

        /* Consistent standard formatting variables */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
            color: var(--secondary-color);
        }
        h4 { font-size: 18px !important; }
        .text-muted { font-size: 12px; }

        /* Tighter, more modern tables */
        .table {
            font-size: 12.5px;
        }
        .table thead th {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            padding: 10px 12px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            white-space: nowrap;
        }
        .table tbody td {
            padding: 10px 12px;
            color: #333;
        }

        /* Styled inputs */
        .form-control, .form-select, .form-check-input {
            font-size: 13px;
            padding: 7px 12px;
            border-radius: 8px;
            border-color: rgba(0,0,0,0.1);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.15rem rgba(255, 122, 0, 0.12);
        }
        .form-label {
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        /* Badges */
        .badge {
            font-size: 10.5px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 6px;
        }

        /* Tighter buttons */
        .btn {
            font-size: 12.5px;
            padding: 6px 16px;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-sm {
            font-size: 11px;
            padding: 4px 10px;
        }

        /* Consistent button border-radius overrides */
        .btn, .btn.rounded-pill, .btn-orange, .btn-premium {
            border-radius: 8px !important;
        }

        /* Sidebar Toggle classes for Mobile responsiveness */
        @media (max-width: 991.98px) {
            .sidebar {
                left: -260px;
            }
            .sidebar.show {
                left: 0;
            }
            .main-wrapper {
                margin-left: 0 !important;
            }
            .top-navbar {
                padding: 12px 20px;
            }
            .content-area {
                padding: 20px 15px;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0,0,0,0.5);
                z-index: 99;
            }
            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand position-relative d-flex align-items-center justify-content-center" style="min-height: 95px; padding: 15px 15px;">
            @if(setting('logo_dark'))
                <img src="{{ asset(setting('logo_dark')) }}" alt="Logo" style="max-height: 65px; height: 65px; max-width: 100%; object-fit: contain;">
            @elseif(setting('logo'))
                <img src="{{ asset(setting('logo')) }}" alt="Logo" style="max-height: 65px; height: 65px; max-width: 100%; object-fit: contain;">
            @else
                GOS <span>MOMO</span>
            @endif
            <button class="btn btn-link text-white position-absolute top-50 end-0 translate-middle-y d-lg-none" id="sidebar-close" style="right: 15px !important; box-shadow: none;">
                <i class="bi bi-x-lg fs-5"></i>
            </button>
        </div>
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Products
            </a>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Categories
            </a>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="bi bi-cart-check"></i> Orders
            </a>
            <a href="{{ route('admin.franchise-leads.index') }}" class="sidebar-link {{ request()->is('admin/franchise-leads*') ? 'active' : '' }}">
                <i class="bi bi-briefcase"></i> Franchise Leads
            </a>
            <a href="{{ route('admin.event-leads.index') }}" class="sidebar-link {{ request()->is('admin/event-leads*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i> Event & Table Bookings
            </a>
            <a href="{{ route('admin.blogs.index') }}" class="sidebar-link {{ request()->is('admin/blogs*') ? 'active' : '' }}">
                <i class="bi bi-journal-richtext"></i> Blog Posts
            </a>
            <a href="{{ route('admin.product-reviews.index') }}" class="sidebar-link {{ request()->is('admin/product-reviews*') ? 'active' : '' }}">
                <i class="bi bi-chat-left-text"></i> Product Reviews
            </a>
            <a href="{{ route('admin.blog-reviews.index') }}" class="sidebar-link {{ request()->is('admin/blog-reviews*') ? 'active' : '' }}">
                <i class="bi bi-chat-right-text"></i> Blog Reviews
            </a>
            <a href="{{ route('admin.chefs.index') }}" class="sidebar-link {{ request()->is('admin/chefs*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Our Chefs
            </a>
            <a href="{{ route('admin.notifications.index') }}" class="sidebar-link {{ request()->is('admin/notifications*') ? 'active' : '' }}">
                <i class="bi bi-bell"></i> Notifications
            </a>
            <a href="{{ route('admin.pages.index') }}" class="sidebar-link {{ request()->is('admin/pages*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-richtext"></i> CMS Pages
            </a>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> User Management
            </a>
            <a href="{{ route('admin.activity-logs.index') }}" class="sidebar-link {{ request()->is('admin/activity-logs*') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i> Activity Logs
            </a>
            <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i> Settings & Tools
            </a>
            <a href="{{ route('admin.system.tokens.index') }}" class="sidebar-link {{ request()->is('admin/system/tokens*') ? 'active' : '' }}">
                <i class="bi bi-key"></i> API Tokens
            </a>
            <a href="{{ route('admin.reports') }}" class="sidebar-link {{ request()->is('admin/reports*') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow"></i> Reports
            </a>
            <a href="#" class="sidebar-link text-danger mt-4" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </aside>

    <!-- Sidebar Overlay for mobile -->
    <div class="sidebar-overlay"></div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-link text-orange p-0 me-3 d-lg-none" id="sidebar-toggle" style="box-shadow: none;">
                    <i class="bi bi-list fs-3"></i>
                </button>
                <h5 class="mb-0 fw-bold font-outfit text-orange d-none d-md-inline-block"><i class="bi bi-shield-check me-2"></i>Gosmomos Control Center</h5>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                    <i class="bi bi-globe me-1"></i> Visit Site
                </a>
            </div>
            <div class="d-flex align-items-center gap-3">
                @if(app()->isDownForMaintenance())
                    <span class="badge bg-danger px-3 py-2">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Maintenance Active
                    </span>
                @endif

                <!-- Notifications Dropdown -->
                @php
                    $unreadNotifications = \App\Models\Notification::where('user_id', Auth::id())->unread()->latest()->take(5)->get();
                    $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->unread()->count();
                @endphp
                <div class="dropdown" id="notificationDropdownContainer">
                    <button class="btn btn-link text-decoration-none d-flex align-items-center p-0 border-0 position-relative me-2" type="button" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="box-shadow: none;">
                        <i class="bi bi-bell text-dark fs-4"></i>
                        @if($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 8px; padding: 2px 4px; line-height: 1;">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3 mt-2 py-0" aria-labelledby="notifDropdown" style="width: 340px; font-size: 12px; z-index: 1050;">
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light rounded-top-3">
                            <span class="fw-bold text-dark">Notifications</span>
                            <div class="d-flex gap-2">
                                @if($unreadCount > 0)
                                    <button onclick="markAllNotificationsAsRead()" class="btn btn-link text-orange p-0 text-decoration-none small fw-semibold" style="font-size: 11px; box-shadow: none;">Mark all read</button>
                                @endif
                                <a href="{{ route('admin.notifications.index') }}" class="btn btn-link text-muted p-0 text-decoration-none small" style="font-size: 11px; box-shadow: none;">View all</a>
                            </div>
                        </div>
                        <div style="max-height: 320px; overflow-y: auto;">
                            @forelse($unreadNotifications as $notif)
                            @php
                                $dropIcons = ['order'=>['bi-bag-check-fill','#0d6efd'],'franchise'=>['bi-briefcase-fill','#fd7e14'],'catering'=>['bi-calendar-event-fill','#6f42c1'],'system'=>['bi-gear-fill','#6c757d'],'alert'=>['bi-exclamation-triangle-fill','#dc3545'],'booking'=>['bi-table','#20c997'],'blog'=>['bi-journal-richtext','#0dcaf0']];
                                $dm = $dropIcons[$notif->type] ?? ['bi-info-circle-fill','#FF7A00'];
                            @endphp
                            <div class="p-3 border-bottom d-flex align-items-start gap-2 notif-drop-item" id="dn-{{ $notif->id }}" style="transition:all 0.2s;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width:30px;height:30px;min-width:30px;background:{{ $dm[1] }}20;">
                                    <i class="bi {{ $dm[0] }}" style="font-size:13px;color:{{ $dm[1] }};"></i>
                                </div>
                                <div class="flex-grow-1 min-w-0">
                                    <div class="fw-bold text-dark" style="font-size: 12px;">{{ $notif->title }}</div>
                                    <p class="text-muted mb-0 mt-1" style="line-height: 1.3; font-size: 11px;">{{ Str::limit($notif->message, 70) }}</p>
                                    <span class="text-muted" style="font-size: 9px;">{{ $notif->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="d-flex gap-1 flex-shrink-0">
                                    <button onclick="dropMarkRead({{ $notif->id }})" title="Mark as read"
                                            class="btn btn-sm p-0 border-0 text-success" style="width:24px;height:24px;">
                                        <i class="bi bi-check-lg" style="font-size:13px;"></i>
                                    </button>
                                    <button onclick="dropDelete({{ $notif->id }})" title="Delete"
                                            class="btn btn-sm p-0 border-0 text-danger" style="width:24px;height:24px;">
                                        <i class="bi bi-trash" style="font-size:12px;"></i>
                                    </button>
                                </div>
                            </div>
                            @empty
                                <div class="text-center py-4 text-muted small">
                                    <i class="bi bi-bell-slash fs-4 d-block mb-2 text-muted" style="opacity: 0.5;"></i>
                                    No new notifications
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center gap-2 p-0 border-0" type="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="box-shadow: none;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; overflow: hidden; background: #FF7A00; display:flex; align-items:center; justify-content:center; color: white; font-weight: bold;">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            @endif
                        </div>
                        <span class="text-dark fw-semibold small d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3 mt-2" aria-labelledby="adminDropdown" style="font-size: 13px;">
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('admin.profile.edit') }}">
                                <i class="bi bi-person me-2"></i> My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('admin.notifications.index') }}">
                                <i class="bi bi-bell me-2"></i> Notifications
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('delivery.dashboard') }}">
                                <i class="bi bi-bicycle me-2"></i> Delivery Portal
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('admin.settings') }}">
                                <i class="bi bi-gear me-2"></i> Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger border-0 bg-transparent w-100 text-start" style="outline: none;">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="content-area">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Setup default CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Global SweetAlert Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
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

        // Sidebar responsive toggler
        $(document).ready(function() {
            $('#sidebar-toggle').on('click', function() {
                $('.sidebar').addClass('show');
                $('.sidebar-overlay').addClass('show');
            });

            $('#sidebar-close, .sidebar-overlay').on('click', function() {
                $('.sidebar').removeClass('show');
                $('.sidebar-overlay').removeClass('show');
            });
        });

        function markAllNotificationsAsRead() {
            $.post("{{ route('admin.notifications.mark-all-read') }}", {_token: "{{ csrf_token() }}"}, function(res) {
                if (res.success) {
                    Toast.fire({ icon: 'success', title: 'All notifications marked as read.' });
                    setTimeout(() => location.reload(), 800);
                }
            });
        }

        function dropMarkRead(id) {
            $.post("{{ url('admin/notifications') }}/" + id + "/mark-read", {_token: "{{ csrf_token() }}"}, function(res) {
                if (res.success) {
                    const el = document.getElementById('dn-' + id);
                    if (el) el.style.opacity = '0.4';
                    Toast.fire({ icon: 'success', title: 'Marked as read' });
                    setTimeout(() => location.reload(), 600);
                }
            });
        }

        function dropDelete(id) {
            Swal.fire({
                title: 'Delete Notification?',
                text: 'Are you sure you want to delete this notification?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FF7A00',
                cancelButtonColor: '#0E101A',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("{{ url('admin/notifications') }}/" + id + "/delete", {_token: "{{ csrf_token() }}"}, function(res) {
                        if (res.success) {
                            const el = document.getElementById('dn-' + id);
                            if (el) { el.style.opacity = '0'; el.style.height = '0'; el.style.overflow = 'hidden'; }
                            Toast.fire({ icon: 'success', title: 'Notification deleted' });
                            setTimeout(() => location.reload(), 600);
                        }
                    });
                }
            });
        }

        function confirmDelete(form, title = 'Are you sure?', text = "You won't be able to revert this!") {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FF7A00',
                cancelButtonColor: '#0E101A',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }
    </script>
    @yield('scripts')
</body>
</html>
