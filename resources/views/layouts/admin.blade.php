<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Admin Panel — GOS MOMO</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Admin Dashboard CSS -->
    <style>
        :root {
            --primary-color: #0F5132;
            --secondary-color: #D4A017;
            --accent-color: #E63946;
            --sidebar-width: 260px;
            --bg-color: #f4f6f9;
            --surface-color: #ffffff;
            --text-color: #212529;
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, var(--primary-color) 0%, #082919 100%);
            color: #d1e7dd;
            z-index: 100;
            transition: var(--transition-smooth);
            box-shadow: 4px 0 15px rgba(0,0,0,0.05);
        }

        .sidebar-brand {
            padding: 24px;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 22px;
            letter-spacing: 1px;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand span {
            color: var(--secondary-color);
        }

        .sidebar-menu {
            padding: 20px 0;
            height: calc(100vh - 80px);
            overflow-y: auto;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: #a3cfbb;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 14px;
            transition: var(--transition-smooth);
            border-left: 4px solid transparent;
        }

        .sidebar-link i {
            font-size: 18px;
            margin-right: 15px;
        }

        .sidebar-link:hover, .sidebar-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.08);
            border-left-color: var(--secondary-color);
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
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-area {
            flex: 1;
            padding: 30px;
        }

        /* Admin UI Cards */
        .admin-card {
            background-color: var(--surface-color);
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            transition: var(--transition-smooth);
        }

        .admin-card:hover {
            box-shadow: 0 6px 24px rgba(0,0,0,0.04);
            transform: translateY(-2px);
        }

        .stat-card {
            padding: 24px;
            border-left: 4px solid var(--primary-color);
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            font-family: 'Outfit', sans-serif;
        }

        .stat-title {
            font-size: 13px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            GOS <span>MOMO</span>
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
                <i class="bi bi-calendar-event"></i> Event Leads
            </a>
            <a href="{{ route('admin.reports') }}" class="sidebar-link {{ request()->is('admin/reports*') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow"></i> Reports
            </a>
            <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i> Settings
            </a>
            <a href="{{ route('logout') }}" class="sidebar-link text-danger mt-5">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <h5 class="mb-0 fw-bold font-outfit text-primary-color">Control Center</h5>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-secondary-color text-dark fw-semibold px-3 py-2">
                    {{ Auth::user()->name }} (Admin)
                </span>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3">
                    <i class="bi bi-globe me-1"></i> Visit Site
                </a>
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
    @yield('scripts')
</body>
</html>
