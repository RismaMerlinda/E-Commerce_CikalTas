<footer style="margin-top:60px; background:#ffffff; border-top:1px solid #e5e7eb;">
    <div style="max-width:1200px; margin:0 auto; padding:18px 20px; display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
        <div style="color:#606060; font-size:14px;">
            © {{ date('Y') }} CikalTas. All rights reserved.
        </div>

        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
            <a href="{{ route('beranda') }}" style="color:#664229; font-size:14px; font-weight:600; text-decoration:none;">
                Ke Halaman User
            </a>
            <span style="color:#d1d5db;">|</span>
            <a href="{{ route('admin.dashboard') }}" style="color:#664229; font-size:14px; font-weight:600; text-decoration:none;">
                Dashboard
            </a>
        </div>
    </div>
</footer>
