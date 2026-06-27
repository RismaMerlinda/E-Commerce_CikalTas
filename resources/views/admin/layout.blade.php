<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') – CikalTas Admin</title>
    <meta name="description" content="CikalTas Admin Panel">
    <link rel="icon" type="image/png" href="{{ asset('gambar/Logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --cream:        #faf7f2;
            --sand:         #f0ebe0;
            --warm:         #e8dfd0;
            --brown-light:  #c4956a;
            --brown:        #9c6e43;
            --brown-dark:   #6b4226;
            --espresso:     #3d2314;
            --charcoal:     #1a1a1a;
            --white:        #ffffff;
            --gray-soft:    #888880;
            --sidebar-w:    270px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--cream);
            color: var(--charcoal);
            overflow-x: hidden;
            min-height: 100vh;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--cream); }
        ::-webkit-scrollbar-thumb { background: var(--brown-light); border-radius: 10px; }

        .admin-shell { display: flex; min-height: 100vh; }

        /* ── SIDEBAR ── */
        .admin-sidebar {
            width: var(--sidebar-w);
            background: var(--espresso);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 200;
            transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-header {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            flex-shrink: 0;
        }
        .sidebar-logo {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none;
        }
        .sidebar-logo img { height: 40px; width: auto; border-radius: 8px; }
        .sidebar-logo-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px; font-weight: 700;
            color: var(--white); letter-spacing: 0.5px; line-height: 1.2;
        }
        .sidebar-logo-sub {
            font-size: 10px; font-weight: 500; letter-spacing: 2px;
            text-transform: uppercase; color: rgba(255,255,255,0.4);
        }

        .sidebar-nav {
            flex: 1; padding: 20px 16px;
            display: flex; flex-direction: column; gap: 4px;
        }
        .sidebar-section-label {
            font-size: 10px; font-weight: 600; letter-spacing: 2px;
            text-transform: uppercase; color: rgba(255,255,255,0.3);
            padding: 14px 12px 6px; margin-top: 6px;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 14px;
            padding: 12px 14px; border-radius: 12px;
            text-decoration: none; color: rgba(255,255,255,0.6);
            font-size: 14px; font-weight: 500;
            transition: all 0.2s; position: relative;
        }
        .sidebar-link i { width: 20px; text-align: center; font-size: 15px; flex-shrink: 0; }
        .sidebar-link:hover { background: rgba(255,255,255,0.08); color: var(--white); }
        .sidebar-link.active {
            background: rgba(196,149,106,0.22);
            color: var(--white);
            border-left: 3px solid var(--brown-light);
        }
        .sidebar-link.active i { color: var(--brown-light); }

        .sidebar-footer {
            padding: 16px; border-top: 1px solid rgba(255,255,255,0.08); flex-shrink: 0;
        }
        .sidebar-user {
            display: flex; align-items: center; gap: 12px;
            padding: 12px; border-radius: 12px;
            background: rgba(255,255,255,0.06); margin-bottom: 10px;
        }
        .sidebar-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: linear-gradient(135deg, var(--brown-light), var(--brown));
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; font-weight: 700; color: white; flex-shrink: 0;
        }
        .sidebar-user-name { font-size: 13px; font-weight: 600; color: var(--white); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .sidebar-user-role { font-size: 11px; color: rgba(255,255,255,0.38); }
        .sidebar-logout {
            display: flex; align-items: center; gap: 10px;
            width: 100%; padding: 10px 14px; border-radius: 10px;
            background: transparent; border: 1px solid rgba(255,255,255,0.12);
            color: rgba(255,255,255,0.55); font-size: 13px; font-weight: 500;
            cursor: pointer; transition: all 0.2s;
        }
        .sidebar-logout:hover {
            background: rgba(220,53,69,0.15);
            border-color: rgba(220,53,69,0.4);
            color: #ff6b6b;
        }

        /* ── MOBILE TOPBAR ── */
        .admin-topbar {
            display: none; position: fixed;
            top: 0; left: 0; right: 0; height: 64px;
            background: var(--espresso);
            align-items: center; justify-content: space-between;
            padding: 0 20px; z-index: 150;
            box-shadow: 0 2px 20px rgba(0,0,0,0.2);
        }
        .topbar-logo {
            display: flex; align-items: center; gap: 10px; text-decoration: none;
        }
        .topbar-logo img { height: 34px; }
        .topbar-logo-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 18px; font-weight: 700; color: white;
        }
        .topbar-hamburger {
            background: none; border: none; cursor: pointer;
            padding: 8px; color: white; font-size: 20px;
        }

        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); z-index: 190;
        }

        /* ── MAIN ── */
        .admin-main {
            margin-left: var(--sidebar-w);
            flex: 1; min-height: 100vh;
            display: flex; flex-direction: column;
            background: var(--cream);
        }
        .admin-content {
            flex: 1; padding: 36px 40px;
            max-width: 1300px; width: 100%; margin: 0 auto;
        }

        /* ── SHARED COMPONENTS ── */
        .page-header {
            display: flex; align-items: flex-start;
            justify-content: space-between; margin-bottom: 28px;
            flex-wrap: wrap; gap: 16px;
        }
        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px; font-weight: 700; color: var(--espresso); margin-bottom: 4px;
        }
        .page-subtitle { font-size: 14px; color: var(--gray-soft); }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px; margin-bottom: 32px;
        }
        .stat-card {
            background: var(--white); border-radius: 20px; padding: 24px;
            box-shadow: 0 2px 16px rgba(61,35,20,0.06);
            transition: transform 0.25s, box-shadow 0.25s;
            border: 1px solid rgba(196,149,106,0.1);
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 32px rgba(61,35,20,0.1); }
        .stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: linear-gradient(135deg, var(--brown-light), var(--brown));
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; margin-bottom: 16px;
        }
        .stat-label {
            font-size: 11px; font-weight: 600; letter-spacing: 1px;
            text-transform: uppercase; color: var(--gray-soft); margin-bottom: 6px;
        }
        .stat-value {
            font-family: 'Cormorant Garamond', serif;
            font-size: 28px; font-weight: 700; color: var(--espresso); line-height: 1;
        }
        .stat-sub { font-size: 12px; color: var(--gray-soft); margin-top: 6px; }

        .card {
            background: var(--white); border-radius: 20px; padding: 28px;
            box-shadow: 0 2px 16px rgba(61,35,20,0.06);
            border: 1px solid rgba(196,149,106,0.08);
        }
        .card-header-row {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 20px;
        }
        .card-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px; font-weight: 700; color: var(--espresso);
            display: flex; align-items: center; gap: 8px;
        }

        .badge {
            display: inline-block; padding: 4px 12px; border-radius: 100px;
            font-size: 11px; font-weight: 600; letter-spacing: 0.3px;
        }
        .badge-pending    { background: #fff3cd; color: #856404; }
        .badge-paid       { background: #cfe2ff; color: #084298; }
        .badge-processing { background: #e2d9f3; color: #5a189a; }
        .badge-completed  { background: #d1e7dd; color: #0f5132; }
        .badge-failed     { background: #f8d7da; color: #842029; }

        .admin-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .admin-table thead th {
            font-size: 11px; font-weight: 600; letter-spacing: 1px;
            text-transform: uppercase; color: var(--gray-soft);
            padding: 12px 16px; border-bottom: 2px solid var(--sand); text-align: left;
        }
        .admin-table tbody td {
            padding: 14px 16px; border-bottom: 1px solid var(--sand);
            color: var(--charcoal); vertical-align: middle;
        }
        .admin-table tbody tr:last-child td { border-bottom: none; }
        .admin-table tbody tr:hover td { background: var(--cream); }

        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 22px; background: var(--espresso); color: white;
            border-radius: 100px; font-size: 13px; font-weight: 500;
            text-decoration: none; border: none; cursor: pointer;
            transition: all 0.25s; box-shadow: 0 4px 16px rgba(61,35,20,0.2);
        }
        .btn-primary:hover {
            background: var(--brown-dark); transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(61,35,20,0.3); color: white;
        }
        .btn-secondary {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 22px; background: transparent; color: var(--espresso);
            border-radius: 100px; font-size: 13px; font-weight: 500;
            border: 1.5px solid rgba(61,35,20,0.2); text-decoration: none;
            cursor: pointer; transition: all 0.25s;
        }
        .btn-secondary:hover { border-color: var(--brown); color: var(--brown); background: var(--sand); }
        .btn-icon {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--sand); border: none; cursor: pointer;
            display: inline-flex; align-items: center; justify-content: center;
            color: var(--espresso); font-size: 13px; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-icon:hover { background: var(--brown-dark); color: white; }
        .btn-icon-delete:hover { background: #dc3545; color: white; }

        .alert-success {
            background: #d1e7dd; color: #0f5132; border: 1px solid #badbcc;
            border-radius: 12px; padding: 14px 18px; font-size: 14px; margin-bottom: 24px;
        }

        .product-thumb { width: 52px; height: 52px; border-radius: 10px; object-fit: cover; }
        .color-dots { display: flex; gap: 6px; }
        .color-dot { width: 18px; height: 18px; border-radius: 50%; border: 2px solid rgba(0,0,0,0.08); }
        .actions { display: flex; gap: 6px; align-items: center; }

        .empty-state { text-align: center; padding: 60px 20px; color: var(--gray-soft); }
        .empty-state i { font-size: 48px; margin-bottom: 16px; display: block; opacity: 0.4; }
        .empty-state p { font-size: 16px; }

        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }

        /* Responsive */
        @media (max-width: 1024px) {
            .stats-row { grid-template-columns: repeat(2, 1fr); }
            .two-col { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }
            .admin-topbar { display: flex; }
            .admin-main { margin-left: 0; padding-top: 64px; }
            .admin-content { padding: 20px 16px; }
            .stats-row { grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 20px; }
            .page-header { flex-direction: column; }
            .admin-table thead th, .admin-table tbody td { padding: 10px 12px; }
            .card { padding: 20px; }
        }
        @media (max-width: 480px) {
            .stats-row { grid-template-columns: 1fr 1fr; gap: 10px; }
            .stat-card { padding: 16px; }
            .stat-value { font-size: 22px; }
            .admin-content { padding: 14px 12px; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-topbar">
        <a href="{{ route('admin.dashboard') }}" class="topbar-logo">
            <img src="{{ asset('gambar/Logo.png') }}" alt="CikalTas">
            <span class="topbar-logo-text">CikalTas</span>
        </a>
        <button class="topbar-hamburger" onclick="toggleSidebar()" aria-label="Menu">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="admin-shell">
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <img src="{{ asset('gambar/Logo.png') }}" alt="CikalTas">
                    <div>
                        <div class="sidebar-logo-text">CikalTas</div>
                        <div class="sidebar-logo-sub">Admin Panel</div>
                    </div>
                </a>
            </div>

            <nav class="sidebar-nav">
                <div class="sidebar-section-label">Menu Utama</div>

                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    Produk
                </a>
                <a href="{{ route('admin.orders.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-bag"></i>
                    Pesanan
                </a>
                <a href="{{ route('admin.sales-report') }}"
                   class="sidebar-link {{ request()->routeIs('admin.sales-report') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    Laporan Penjualan
                </a>

                <div class="sidebar-section-label">Lainnya</div>

                <a href="{{ route('admin.messages.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <i class="fas fa-comments"></i>
                    Customer Support
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <div class="sidebar-avatar">
                        {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'A', 0, 1)) }}
                    </div>
                    <div style="overflow:hidden;">
                        <div class="sidebar-user-name">{{ auth()->user()->nama_lengkap ?? 'Admin' }}</div>
                        <div class="sidebar-user-role">Administrator</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <main class="admin-main">
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }
    </script>
    @stack('scripts')
</body>
</html>
