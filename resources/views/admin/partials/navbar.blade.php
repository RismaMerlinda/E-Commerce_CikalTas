<nav style="background:#ffffff; border-bottom:1px solid #e5e7eb; box-shadow:0 1px 2px rgba(0,0,0,0.05);">
    <div style="max-width:1200px; margin:0 auto; padding:14px 20px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
        <div style="display:flex; align-items:center; gap:14px; flex-wrap:wrap;">
            <a href="{{ route('admin.dashboard') }}" style="text-decoration:none; color:#664229; font-weight:800; font-size:18px; letter-spacing:0.2px;">
                CikalTas Admin
            </a>

            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                <a href="{{ route('admin.dashboard') }}"
                    style="text-decoration:none; padding:8px 12px; border-radius:10px; font-weight:600; {{ request()->routeIs('admin.dashboard') ? 'background-color:#664229;color:#ffffff;' : 'background-color:transparent;color:#664229;' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}"
                    style="text-decoration:none; padding:8px 12px; border-radius:10px; font-weight:600; {{ request()->routeIs('admin.products.*') ? 'background-color:#664229;color:#ffffff;' : 'background-color:transparent;color:#664229;' }}">
                    Produk
                </a>
                <a href="{{ route('admin.orders.index') }}"
                    style="text-decoration:none; padding:8px 12px; border-radius:10px; font-weight:600; {{ request()->routeIs('admin.orders.*') ? 'background-color:#664229;color:#ffffff;' : 'background-color:transparent;color:#664229;' }}">
                    Pesanan
                </a>
                <a href="{{ route('admin.sales-report') }}"
                    style="text-decoration:none; padding:8px 12px; border-radius:10px; font-weight:600; {{ request()->routeIs('admin.sales-report') ? 'background-color:#664229;color:#ffffff;' : 'background-color:transparent;color:#664229;' }}">
                    Laporan
                </a>
                <a href="{{ route('admin.messages.index') }}"
                    style="text-decoration:none; padding:8px 12px; border-radius:10px; font-weight:600; {{ request()->routeIs('admin.messages.*') ? 'background-color:#664229;color:#ffffff;' : 'background-color:transparent;color:#664229;' }}">
                    💬 Customer Support
                </a>
            </div>
        </div>

        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
            <div style="font-size:14px; color:#606060;">
                {{ auth()->user()->nama_lengkap ?? 'Admin' }}
            </div>

            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit"
                    style="background:#664229; color:#ffffff; border:none; padding:10px 14px; border-radius:10px; font-weight:700; cursor:pointer;">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>
