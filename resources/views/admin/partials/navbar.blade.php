<style>
.admin-nav {
    background: var(--secondary);
    border-bottom: 1px solid var(--primary-light);
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    position: sticky;
    top: 0;
    z-index: 100;
}
.admin-nav-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.admin-nav-brand {
    text-decoration: none;
    color: #664229;
    font-weight: 800;
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}
.admin-nav-brand img { height: 32px; width: auto; object-fit: contain; }

.admin-nav-links {
    display: flex;
    align-items: center;
    gap: 4px;
    flex-wrap: wrap;
}
.admin-nav-link {
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    color: var(--primary);
    white-space: nowrap;
}
.admin-nav-link.active { background-color: var(--primary); color: var(--white); }
.admin-nav-link:hover:not(.active) { background-color: var(--primary-light); }

.admin-nav-right {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}
.admin-nav-user { font-size: 14px; color: #606060; white-space: nowrap; }
.admin-logout-btn {
    background: var(--primary);
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 10px;
    font-weight: 700;
    cursor: pointer;
    font-size: 13px;
    white-space: nowrap;
}
.admin-logout-btn:hover { background: #553621; }

/* Hamburger (hidden on desktop) */
.admin-hamburger {
    display: none;
    flex-direction: column;
    gap: 5px;
    cursor: pointer;
    padding: 6px;
    border: none;
    background: none;
}
.admin-hamburger span {
    display: block;
    width: 22px; height: 2px;
    background: #664229;
    border-radius: 2px;
    transition: all 0.3s;
}

/* Mobile drawer */
.admin-nav-drawer {
    display: none;
    flex-direction: column;
    padding: 12px 20px 20px;
    background: #fff;
    border-top: 1px solid #f0ebe0;
    gap: 4px;
}
.admin-nav-drawer.open { display: flex; }
.admin-nav-drawer .admin-nav-link {
    display: block;
    padding: 12px 14px;
    border-radius: 10px;
    font-size: 15px;
}
.admin-drawer-user {
    padding: 12px 14px;
    font-size: 14px;
    color: #888;
    border-top: 1px solid #f0ebe0;
    margin-top: 8px;
}

@media (max-width: 768px) {
    .admin-nav-links { display: none; }
    .admin-nav-user { display: none; }
    .admin-hamburger { display: flex; }
}
@media (max-width: 480px) {
    .admin-nav-brand { font-size: 15px; }
    .admin-nav-brand img { height: 28px; }
}
</style>

<nav class="admin-nav">
    <div class="admin-nav-inner">
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-brand">
            <img src="{{ asset('gambar/Logo.png') }}" alt="CikalTas Logo">
            CikalTas Admin
        </a>

        <div class="admin-nav-links">
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="admin-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Produk</a>
            <a href="{{ route('admin.orders.index') }}" class="admin-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">Pesanan</a>
            <a href="{{ route('admin.sales-report') }}" class="admin-nav-link {{ request()->routeIs('admin.sales-report') ? 'active' : '' }}">Laporan</a>
            <a href="{{ route('admin.messages.index') }}" class="admin-nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">💬 Support</a>
        </div>

        <div class="admin-nav-right">
            <span class="admin-nav-user">{{ auth()->user()->nama_lengkap ?? 'Admin' }}</span>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="admin-logout-btn">Logout</button>
            </form>
            <button class="admin-hamburger" onclick="toggleAdminDrawer()" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    <!-- Mobile Drawer -->
    <div class="admin-nav-drawer" id="adminNavDrawer">
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
        <a href="{{ route('admin.products.index') }}" class="admin-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">📦 Produk</a>
        <a href="{{ route('admin.orders.index') }}" class="admin-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">🛒 Pesanan</a>
        <a href="{{ route('admin.sales-report') }}" class="admin-nav-link {{ request()->routeIs('admin.sales-report') ? 'active' : '' }}">📈 Laporan</a>
        <a href="{{ route('admin.messages.index') }}" class="admin-nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">💬 Customer Support</a>
        <div class="admin-drawer-user">
            👤 {{ auth()->user()->nama_lengkap ?? 'Admin' }}
            <form method="POST" action="{{ route('logout') }}" style="margin-top:10px;">
                @csrf
                <button type="submit" class="admin-logout-btn" style="width:100%;">Logout</button>
            </form>
        </div>
    </div>
</nav>

<script>
function toggleAdminDrawer() {
    document.getElementById('adminNavDrawer').classList.toggle('open');
}
</script>
