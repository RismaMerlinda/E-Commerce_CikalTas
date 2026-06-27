<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'CikalTas — Premium Bags for Modern Lifestyle' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('gambar/Logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --espresso:    #4A2C17;
            --brown-dark:  #6B3F22;
            --brown:       #8B5A2B;
            --brown-mid:   #A8784A;
            --caramel:     #C4956A;
            --cream:       #FFF8F2;
            --sand:        #F5EDE3;
            --sidebar-w:   260px;
            --sidebar-bg1: #7A4F2E;
            --sidebar-bg2: #5C3820;
            --sidebar-bg3: #4A2C17;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--cream);
            color: #1a1a1a;
            min-height: 100vh;
            display: flex;
        }

        /* ══════════════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: linear-gradient(180deg, #8C5A35 0%, #6B3F22 55%, #5A3118 100%);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            box-shadow: 4px 0 30px rgba(90,49,24,0.3);
            overflow: hidden;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: -80px; right: -60px;
            width: 220px; height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,210,170,0.18) 0%, transparent 70%);
            pointer-events: none;
        }
        .sidebar::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -40px;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,200,140,0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,210,170,0.22);
            margin-bottom: 8px;
        }

        .sidebar-brand img {
            width: 36px; height: 36px;
            object-fit: contain;
            filter: brightness(1.1);
        }

        .sidebar-brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.5px;
        }
        .sidebar-brand-sub {
            font-size: 9px;
            color: rgba(196,149,106,0.7);
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 500;
        }

        .sidebar-nav {
            flex: 1;
            padding: 8px 12px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .sidebar-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,220,180,0.65);
            padding: 12px 12px 6px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 12px;
            text-decoration: none;
            color: rgba(255,240,220,0.78);
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 12px;
            background: rgba(255,200,140,0.12);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255,200,140,0.18);
        }
        .nav-link:hover::before { opacity: 1; }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(255,220,170,0.3), rgba(255,200,140,0.18));
            color: #fff;
            border: 1px solid rgba(255,220,170,0.35);
            box-shadow: 0 4px 16px rgba(255,180,100,0.2), inset 0 1px 0 rgba(255,255,255,0.12);
        }
        .nav-link.active .nav-icon { color: #ffd49e; }

        .nav-link.active::after {
            content: '';
            position: absolute;
            left: 0; top: 25%; height: 50%;
            width: 3px;
            border-radius: 0 3px 3px 0;
            background: #ffd49e;
        }

        .nav-icon {
            width: 18px; height: 18px;
            flex-shrink: 0;
            transition: color 0.2s;
        }

        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid rgba(255,210,170,0.2);
        }

        .sidebar-logout {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 12px;
            color: rgba(255,220,200,0.6);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
        }
        .sidebar-logout:hover {
            color: #ffaaaa;
            background: rgba(255,100,100,0.12);
        }

        /* ══════════════════════════════════════════════
           MAIN AREA
        ══════════════════════════════════════════════ */
        .main-area {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ══════════════════════════════════════════════
           HEADER
        ══════════════════════════════════════════════ */
        .main-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255,248,242,0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(196,149,106,0.15);
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            box-shadow: 0 1px 20px rgba(0,0,0,0.04);
        }

        .header-search {
            flex: 1;
            max-width: 380px;
            position: relative;
        }

        .header-search input {
            width: 100%;
            padding: 9px 16px 9px 40px;
            border: 1.5px solid rgba(196,149,106,0.2);
            border-radius: 12px;
            background: rgba(255,255,255,0.8);
            font-family: 'Inter', sans-serif;
            font-size: 13.5px;
            color: #1a1a1a;
            outline: none;
            transition: all 0.2s;
        }
        .header-search input::placeholder { color: #b0a090; }
        .header-search input:focus {
            border-color: var(--caramel);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(196,149,106,0.12);
        }
        .header-search-icon {
            position: absolute;
            left: 12px; top: 50%;
            transform: translateY(-50%);
            width: 16px; height: 16px;
            color: #b0a090;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* User Dropdown */
        .user-dropdown-wrap {
            position: relative;
        }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px 6px 6px;
            border-radius: 50px;
            background: rgba(255,255,255,0.8);
            border: 1.5px solid rgba(196,149,106,0.2);
            cursor: pointer;
            transition: all 0.2s;
        }
        .user-btn:hover {
            border-color: var(--caramel);
            background: #fff;
            box-shadow: 0 4px 16px rgba(196,149,106,0.15);
        }

        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(196,149,106,0.4);
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: #2a1a0e;
        }
        .user-role {
            font-size: 10.5px;
            color: var(--caramel);
            font-weight: 500;
        }

        .chevron-icon {
            width: 14px; height: 14px;
            color: #b0a090;
            transition: transform 0.2s;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0; top: calc(100% + 10px);
            min-width: 240px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06);
            overflow: hidden;
            border: 1px solid rgba(196,149,106,0.12);
            z-index: 200;
        }

        .dropdown-menu.show { display: block; animation: ddFadeIn 0.18s ease; }

        @keyframes ddFadeIn {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .dd-header {
            padding: 16px;
            background: linear-gradient(135deg, var(--espresso), var(--brown-dark));
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .dd-header img {
            width: 44px; height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(196,149,106,0.4);
        }
        .dd-header-name { font-size: 13px; font-weight: 700; color: #fff; }
        .dd-header-role { font-size: 11px; color: var(--caramel); font-weight: 500; }

        .dd-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #444;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: background 0.15s;
        }
        .dd-item svg { width: 18px; height: 18px; color: #a0806a; }
        .dd-item:hover { background: var(--sand); color: var(--brown); }
        .dd-item:hover svg { color: var(--brown); }

        .dd-divider { height: 1px; background: #f0ebe4; margin: 4px 0; }

        .dd-logout { color: #d94f4f; }
        .dd-logout svg { color: #d94f4f; }
        .dd-logout:hover { background: #fff5f5; color: #b83232; }

        /* ══════════════════════════════════════════════
           PAGE CONTENT
        ══════════════════════════════════════════════ */
        .page-content {
            flex: 1;
            padding: 32px;
        }

        /* ══════════════════════════════════════════════
           FOOTER
        ══════════════════════════════════════════════ */
        .main-footer {
            padding: 16px 32px;
            border-top: 1px solid rgba(196,149,106,0.12);
            background: rgba(255,248,242,0.6);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }
        .main-footer p { font-size: 12.5px; color: #a0806a; }
        .main-footer span { font-size: 12.5px; color: #a0806a; }
        .main-footer strong { color: var(--brown); }

        /* ══════════════════════════════════════════════
           CHATBOT WIDGET
        ══════════════════════════════════════════════ */
        .chatbot-scroll::-webkit-scrollbar { width: 4px; }
        .chatbot-scroll::-webkit-scrollbar-track { background: transparent; }
        .chatbot-scroll::-webkit-scrollbar-thumb { background: rgba(196,149,106,0.3); border-radius: 10px; }

        .message-row { display: flex; width: 100%; margin-bottom: 10px; }
        .message-row.user { justify-content: flex-end; }
        .message-row.ai   { justify-content: flex-start; }

        .bubble {
            display: inline-block;
            padding: 9px 14px;
            border-radius: 16px;
            font-size: 13.5px;
            line-height: 1.5;
            word-break: break-word;
            overflow-wrap: anywhere;
            max-width: 100%;
        }

        .user-bubble {
            background: linear-gradient(135deg, #C4956A, #A8784A);
            color: #fff;
            border-bottom-right-radius: 4px;
            box-shadow: 0 2px 8px rgba(196,149,106,0.35);
        }
        .ai-bubble {
            background: #fff;
            color: #2a1a0e;
            border-bottom-left-radius: 4px;
            border: 1px solid rgba(196,149,106,0.15);
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .message-time {
            font-size: 10px;
            margin-top: 3px;
            opacity: 0.55;
            color: #6b4226;
        }

        @keyframes heartbeat {
            0%   { transform: scale(1); box-shadow: 0 4px 15px rgba(196,149,106,0.35); }
            15%  { transform: scale(1.12); box-shadow: 0 6px 25px rgba(196,149,106,0.55); }
            30%  { transform: scale(1); box-shadow: 0 4px 15px rgba(196,149,106,0.35); }
            45%  { transform: scale(1.08); box-shadow: 0 5px 20px rgba(196,149,106,0.45); }
            60%  { transform: scale(1); box-shadow: 0 4px 15px rgba(196,149,106,0.35); }
            100% { transform: scale(1); box-shadow: 0 4px 15px rgba(196,149,106,0.35); }
        }

        .chatbot-toggle-glow {
            animation: heartbeat 2.5s ease-in-out infinite;
            background: linear-gradient(135deg, #C4956A 0%, #A8784A 100%);
        }
        .chatbot-toggle-glow:hover {
            animation-play-state: paused;
            transform: scale(1.15) !important;
        }

        .chatbot-notif-badge {
            position: absolute; top: -3px; left: -3px;
            min-width: 18px; height: 18px;
            background: #EF4444; color: #fff;
            font-size: 9px; font-weight: 700;
            border-radius: 999px;
            display: none;
            align-items: center; justify-content: center;
            padding: 0 4px;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(239,68,68,0.5);
        }
        .chatbot-notif-badge.show { display: flex; }

        .chatbot-online-dot {
            position: absolute; top: -1px; right: -1px;
            width: 13px; height: 13px;
            background: #22C55E; border-radius: 999px;
            border: 2px solid #fff;
            box-shadow: 0 0 8px rgba(34,197,94,0.6);
        }

        @keyframes typingBounce {
            0%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-5px); }
        }
        .typing-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #C4956A;
            display: inline-block;
            animation: typingBounce 1.2s infinite;
        }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }

        /* ══════════════════════════════════════════════
           RESPONSIVE — TABLET (≤ 1024px)
        ══════════════════════════════════════════════ */
        @media (max-width: 1024px) {
            :root { --sidebar-w: 72px; }

            .sidebar-brand-name,
            .sidebar-brand-sub,
            .sidebar-label,
            .nav-link span,
            .sidebar-logout span { display: none; }

            .sidebar-brand {
                justify-content: center;
                padding: 20px 0;
            }
            .sidebar-brand img { width: 40px; height: 40px; }

            .nav-link {
                justify-content: center;
                padding: 13px;
                border-radius: 14px;
            }
            .nav-icon { width: 22px; height: 22px; }

            .sidebar-footer { padding: 10px 8px; }
            .sidebar-logout {
                justify-content: center;
                padding: 10px;
            }
            .sidebar-logout svg { width: 20px; height: 20px; }

            .main-header { padding: 0 16px; }
            .page-content { padding: 20px 16px; }
            .main-footer { padding: 12px 16px; }

            /* Chatbot shrinks slightly */
            #chatbot-widget { width: 320px !important; }
        }

        /* ══════════════════════════════════════════════
           RESPONSIVE — MOBILE (≤ 768px)
        ══════════════════════════════════════════════ */
        @media (max-width: 768px) {
            :root { --sidebar-w: 0px; }

            /* Hide desktop sidebar */
            .sidebar { transform: translateX(-100%); width: 260px !important; transition: transform 0.3s ease; z-index: 200; }
            .sidebar.mobile-open { transform: translateX(0); }

            /* Sidebar overlay */
            .sidebar-overlay {
                display: none;
                position: fixed; inset: 0;
                background: rgba(0,0,0,0.45);
                z-index: 199;
                backdrop-filter: blur(2px);
            }
            .sidebar-overlay.show { display: block; }

            /* Restore sidebar brand/labels on mobile drawer */
            .sidebar-brand-name,
            .sidebar-brand-sub,
            .sidebar-label,
            .nav-link span,
            .sidebar-logout span { display: block; }
            .sidebar-brand { justify-content: flex-start; padding: 24px 20px 20px; }
            .nav-link { justify-content: flex-start; padding: 11px 14px; border-radius: 12px; }
            .sidebar-logout { justify-content: flex-start; padding: 10px 14px; }

            /* Main area full width */
            .main-area { margin-left: 0; }

            /* Mobile top header */
            .main-header {
                padding: 0 16px;
                position: sticky;
                top: 0;
                z-index: 100;
            }

            /* Hamburger button in header */
            .mobile-menu-btn {
                display: flex !important;
                align-items: center;
                justify-content: center;
                width: 38px; height: 38px;
                border-radius: 10px;
                background: rgba(255,255,255,0.8);
                border: 1.5px solid rgba(196,149,106,0.2);
                cursor: pointer;
                flex-shrink: 0;
                margin-right: 8px;
            }
            .mobile-menu-btn svg { width: 20px; height: 20px; color: #6B4226; }

            /* Shrink header search */
            .header-search { max-width: 100%; flex: 1; }

            /* Page content */
            .page-content { padding: 16px 12px 96px; } /* 96px bottom padding for bottom nav */
            .main-footer { display: none; } /* hide footer on mobile, replaced by bottom nav */

            /* ── BOTTOM NAVIGATION ── */
            .bottom-nav {
                display: flex !important;
                position: fixed;
                bottom: 0; left: 0; right: 0;
                height: 68px;
                background: rgba(255,255,255,0.97);
                border-top: 1px solid rgba(196,149,106,0.15);
                backdrop-filter: blur(20px);
                z-index: 150;
                padding: 0 4px;
                box-shadow: 0 -4px 24px rgba(0,0,0,0.08);
            }
            .bottom-nav-item {
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 3px;
                text-decoration: none;
                color: #a0806a;
                font-size: 10px;
                font-weight: 500;
                padding: 8px 4px;
                border-radius: 12px;
                transition: all 0.2s;
                position: relative;
            }
            .bottom-nav-item svg { width: 22px; height: 22px; }
            .bottom-nav-item span { font-size: 10px; line-height: 1; }
            .bottom-nav-item.active { color: #6B4226; }
            .bottom-nav-item.active svg { color: #8C5A35; }
            .bottom-nav-item.active::before {
                content: '';
                position: absolute;
                top: 6px;
                width: 32px; height: 3px;
                background: linear-gradient(90deg, #8C5A35, #C4956A);
                border-radius: 0 0 4px 4px;
                top: 0;
            }

            /* Chatbot repositioned above bottom nav */
            #chatbot-widget {
                bottom: 80px !important;
                right: 12px !important;
                width: calc(100vw - 24px) !important;
                max-width: 360px !important;
                height: 420px !important;
            }
            #chatbot-toggle {
                bottom: 80px !important;
                right: 16px !important;
            }
        }

        /* ══════════════════════════════════════════════
           RESPONSIVE — SMALL MOBILE (≤ 480px)
        ══════════════════════════════════════════════ */
        @media (max-width: 480px) {
            .main-header { height: 56px; }
            .user-name { display: none; }
            .user-role { display: none; }
            .user-btn { padding: 4px; gap: 0; }
            .chevron-icon { display: none; }
            .header-search input { font-size: 13px; padding: 8px 14px 8px 36px; }

            #chatbot-widget {
                width: calc(100vw - 16px) !important;
                right: 8px !important;
            }
        }

        /* ── Always hidden on desktop ── */
        .bottom-nav { display: none; }
        .sidebar-overlay { display: none; }
        .mobile-menu-btn { display: none; }

    </style>
</head>

<body>
    <!-- ══ SIDEBAR ══ -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('gambar/Logo.png') }}" alt="CikalTas Logo">
            <div>
                <div class="sidebar-brand-name">CikalTas</div>
                <div class="sidebar-brand-sub">Premium Bags</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-label">Menu Utama</div>

            <a href="{{ route('beranda') }}" class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>

            <a href="{{ route('keranjang') }}" class="nav-link {{ request()->routeIs('keranjang') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span>Keranjang</span>
            </a>

            <a href="{{ route('pesanan') }}" class="nav-link {{ request()->routeIs('pesanan') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span>Pesanan Saya</span>
            </a>

            <a href="{{ route('pembayaran') }}" class="nav-link {{ request()->routeIs('pembayaran') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                <span>Pembayaran</span>
            </a>

            <div class="sidebar-label" style="margin-top:8px;">Akun</div>

            <a href="{{ route('profil') }}" class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span>Profil Saya</span>
            </a>

            <a href="{{ route('support.index') }}" class="nav-link {{ request()->routeIs('support.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <span>Customer Support</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <svg style="width:17px;height:17px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Sidebar Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleMobileSidebar(event)"></div>

    <!-- ══ MAIN AREA ══ -->
    <div class="main-area">
        <!-- Header -->
        <header class="main-header">
            <!-- Mobile Menu Toggle Button -->
            <button type="button" class="mobile-menu-btn" onclick="toggleMobileSidebar(event)">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div class="header-search">
                <form action="{{ route('beranda') }}" method="GET" style="display:flex;align-items:center;width:100%;gap:0;">
                    <svg class="header-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q" id="search-input" placeholder="Cari produk, kategori..." value="{{ request('q') }}" autocomplete="off" style="flex:1;background:none;border:none;outline:none;">
                    @if(request('q'))
                        <a href="{{ route('beranda') }}" style="color:#a08060;padding:0 6px;text-decoration:none;font-size:18px;line-height:1;" title="Hapus pencarian">✕</a>
                    @endif
                </form>
            </div>


            <div class="header-actions">
                <!-- User Dropdown -->
                <div class="user-dropdown-wrap">
                    <div class="user-btn" id="userToggle" onclick="toggleUserMenu()">
                        <img class="user-avatar"
                             src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->nama_lengkap ?? 'User') . '&background=6B4226&color=fff&bold=true' }}"
                             alt="Avatar">
                        <div>
                            <div class="user-name">{{ Auth::user()->nama_lengkap ?? 'User' }}</div>
                            <div class="user-role">{{ Auth::user()->role === 'admin' ? 'Admin' : 'Member' }}</div>
                        </div>
                        <svg class="chevron-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>

                    <div id="userDropdownMenu" class="dropdown-menu">
                        <div class="dd-header">
                            <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->nama_lengkap ?? 'User') . '&background=6B4226&color=fff&bold=true&size=80' }}" alt="Avatar">
                            <div>
                                <div class="dd-header-name">{{ Auth::user()->nama_lengkap ?? 'User' }}</div>
                                <div class="dd-header-role">{{ Auth::user()->role === 'admin' ? 'Administrator' : 'Member' }}</div>
                            </div>
                        </div>

                        <a href="{{ route('profil') }}" class="dd-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Ubah Profil
                        </a>

                        <a href="{{ route('pesanan') }}" class="dd-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Histori Pesanan
                        </a>

                        <div class="dd-divider"></div>

                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" class="dd-item dd-logout" style="width:100%;background:none;border:none;cursor:pointer;text-align:left;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="page-content">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="main-footer">
            <p>© {{ date('Y') }} CikalTas. All rights reserved.</p>
            <span><strong>CikalTas</strong> &nbsp;·&nbsp; Premium Bags Collection</span>
        </footer>
    </div>

    <!-- ══ BOTTOM NAVIGATION (MOBILE ONLY) ══ -->
    <div class="bottom-nav">
        <a href="{{ route('beranda') }}" class="bottom-nav-item {{ request()->routeIs('beranda') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span>Beranda</span>
        </a>
        <a href="{{ route('keranjang') }}" class="bottom-nav-item {{ request()->routeIs('keranjang') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <span>Keranjang</span>
        </a>
        <a href="{{ route('pesanan') }}" class="bottom-nav-item {{ request()->routeIs('pesanan') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <span>Pesanan</span>
        </a>
        <a href="{{ route('profil') }}" class="bottom-nav-item {{ request()->routeIs('profil') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span>Profil</span>
        </a>
        <a href="{{ route('support.index') }}" class="bottom-nav-item {{ request()->routeIs('support.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            <span>Chat</span>
        </a>
    </div>


    <!-- ══════════════════ CHATBOT WIDGET ══════════════════ -->
    <div id="chatbot-widget" style="display:none; z-index:9999; position:fixed; bottom:24px; right:24px; width:348px; height:440px; border-radius:20px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,0.2), 0 4px 20px rgba(196,149,106,0.2); border:1px solid rgba(196,149,106,0.2);" class="flex flex-col bg-white">
        <!-- Header -->
        <div style="background:linear-gradient(135deg, #C4956A 0%, #A8784A 50%, #6B4226 100%); padding:12px 14px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,0.2);border:2px solid rgba(255,255,255,0.4);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <img src="{{ asset('gambar/Logo.png') }}" alt="Cikal" style="width:24px;height:24px;object-fit:contain;filter:brightness(1.2);">
                </div>
                <div>
                    <div style="font-size:13px;font-weight:700;color:#fff;line-height:1.2;">Cikal Assistant</div>
                    <div style="display:flex;align-items:center;gap:5px;margin-top:2px;">
                        <span style="width:7px;height:7px;background:#4ade80;border-radius:50%;display:inline-block;animation:pulse 2s infinite;"></span>
                        <span style="font-size:10px;color:rgba(255,255,255,0.85);">Online</span>
                    </div>
                </div>
            </div>
            <button type="button" onclick="closeChatbot()" style="background:rgba(255,255,255,0.15);border:none;border-radius:50%;width:28px;height:28px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                <svg style="width:14px;height:14px;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Messages -->
        <div id="chatbot-messages" class="chatbot-scroll flex-1 flex flex-col" style="overflow-y:auto; padding:14px; background:linear-gradient(180deg,#fdf8f4 0%,#f5ede3 100%); gap:0;">
            <div class="message-row ai">
                <div style="display:flex;flex-direction:column;align-items:flex-start;max-width:78%;">
                    <div class="bubble ai-bubble">Halo! Saya Cikal Assistant 🎒 Ada yang bisa saya bantu terkait produk CikalTas?</div>
                    <span class="message-time" style="margin-left:4px;">Baru saja</span>
                </div>
            </div>
        </div>

        <!-- Input -->
        <div style="padding:10px 12px; background:#fff; border-top:1px solid rgba(196,149,106,0.12); flex-shrink:0;">
            <a href="{{ route('support.index') }}" style="display:block;text-align:center;font-size:11px;color:var(--caramel);text-decoration:none;font-weight:600;margin-bottom:8px;opacity:0.8;">
                💬 Butuh bantuan? Chat langsung dengan Admin
            </a>
            <form id="chatbot-form" style="display:flex;align-items:center;gap:8px;" onsubmit="sendMessage(event)">
                <input type="text" id="chatbot-input"
                    style="flex:1;border:1.5px solid rgba(196,149,106,0.2);background:#faf8f5;border-radius:50px;padding:9px 16px;font-size:13px;font-family:'Inter',sans-serif;outline:none;transition:all 0.2s;color:#2a1a0e;"
                    placeholder="Ketik pesan..." required
                    onfocus="this.style.borderColor='#C4956A';this.style.boxShadow='0 0 0 3px rgba(196,149,106,0.1)'"
                    onblur="this.style.borderColor='rgba(196,149,106,0.2)';this.style.boxShadow='none'">
                <button type="submit" style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#C4956A,#6B4226);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(196,149,106,0.4);transition:transform 0.15s,box-shadow 0.15s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
                    <svg style="width:16px;height:16px;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Chatbot Toggle Button -->
    <button id="chatbot-toggle" onclick="openChatbot()" class="chatbot-toggle-glow"
        style="z-index:9998;position:fixed;bottom:24px;right:24px;width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:none;outline:none;cursor:pointer;transition:transform 0.3s;">
        <svg style="width:28px;height:28px;" viewBox="0 0 32 32" fill="none">
            <path d="M22 6H12C9.79 6 8 7.79 8 10V16C8 18.21 9.79 20 12 20H13L15 23L17 20H22C24.21 20 26 18.21 26 16V10C26 7.79 24.21 6 22 6Z" fill="rgba(255,255,255,0.3)"/>
            <path d="M20 10H10C7.79 10 6 11.79 6 14V20C6 22.21 7.79 24 10 24H11L13 27L15 24H20C22.21 24 24 22.21 24 20V14C24 11.79 22.21 10 20 10Z" fill="white"/>
            <circle cx="11.5" cy="17" r="1.2" fill="#C4956A"/>
            <circle cx="15"   cy="17" r="1.2" fill="#C4956A"/>
            <circle cx="18.5" cy="17" r="1.2" fill="#C4956A"/>
        </svg>
        <span class="chatbot-online-dot"></span>
        <span id="chatbot-notif" class="chatbot-notif-badge">0</span>
    </button>

    <script>
        // ── Mobile Sidebar Toggle ──
        function toggleMobileSidebar(e) {
            if(e) e.stopPropagation();
            const sb = document.querySelector('.sidebar');
            const ov = document.getElementById('sidebarOverlay');
            if (sb && ov) {
                sb.classList.toggle('mobile-open');
                ov.classList.toggle('show');
            }
        }

        // ── User Dropdown ──
        function toggleUserMenu() {
            document.getElementById('userDropdownMenu').classList.toggle('show');
        }
        window.addEventListener('click', function(e) {
            const menu = document.getElementById('userDropdownMenu');
            const btn  = document.getElementById('userToggle');
            if (menu && btn && !btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('show');
            }
        });

        // ── Chatbot ──
        const safeLS = {
            get(k) { try { return localStorage.getItem(k); } catch(e){ return null; } },
            set(k,v){ try { localStorage.setItem(k,v); } catch(e){} }
        };

        let unreadCount = 0, displayedIds = new Set(), totalAdminReplies = 0;

        function fmt(iso) {
            if (!iso) return 'Baru saja';
            try {
                const d = new Date(iso);
                return d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', timeZone: 'Asia/Jakarta' });
            }

            catch(e){ return 'Baru saja'; }
        }

        function clearNotif() {
            unreadCount = 0;
            const b = document.getElementById('chatbot-notif');
            if (b) { b.textContent = '0'; b.classList.remove('show'); }
        }

        function openChatbot() {
            document.getElementById('chatbot-widget').style.display = 'flex';
            document.getElementById('chatbot-toggle').style.display = 'none';
            clearNotif();
            const seen = parseInt(safeLS.get('seen_admin_replies') || '0', 10);
            if (totalAdminReplies > seen) safeLS.set('seen_admin_replies', totalAdminReplies);
            loadHistory();
        }

        function closeChatbot() {
            document.getElementById('chatbot-widget').style.display = 'none';
            document.getElementById('chatbot-toggle').style.display = 'flex';
        }

        async function loadHistory() {
            const c = document.getElementById('chatbot-messages');
            if (!c) return;
            c.innerHTML = `<div class="message-row ai"><div style="display:flex;flex-direction:column;align-items:flex-start;max-width:78%;"><div class="bubble ai-bubble">Halo! Saya Cikal Assistant 🎒 Ada yang bisa saya bantu terkait produk CikalTas?</div><span class="message-time" style="margin-left:4px;">Baru saja</span></div></div>`;
            displayedIds.clear();
            try {
                const r = await fetch('{{ route('chatbot.history') }}');
                if (!r.ok) return;
                const msgs = await r.json();
                let adminCnt = 0;
                msgs.forEach(m => {
                    displayedIds.add(m.id);
                    if (m.sender_type === 'user') appendMsg('user', m.message, fmt(m.created_at));
                    else if (m.sender_type === 'admin') { appendMsg('ai', `🧑‍💼 **Admin:** ${m.message}`, fmt(m.created_at)); adminCnt++; }
                    else appendMsg('ai', m.message, fmt(m.created_at));
                });
                totalAdminReplies = adminCnt;
                safeLS.set('seen_admin_replies', totalAdminReplies);
            } catch(err) { console.error(err); }
        }

        async function checkNew() {
            try {
                const widget = document.getElementById('chatbot-widget');
                if (!widget) return;
                const r = await fetch('{{ route('chatbot.history') }}');
                if (!r.ok) return;
                const msgs = await r.json();
                const open = widget.style.display === 'flex';
                let adminCnt = 0, newFound = false;
                msgs.forEach(m => {
                    if (m.sender_type === 'admin') adminCnt++;
                    if (open && !displayedIds.has(m.id)) {
                        displayedIds.add(m.id);
                        if (m.sender_type === 'user') appendMsg('user', m.message, fmt(m.created_at));
                        else if (m.sender_type === 'admin') { appendMsg('ai', `🧑‍💼 **Admin:** ${m.message}`, fmt(m.created_at)); }
                        else appendMsg('ai', m.message, fmt(m.created_at));
                        newFound = true;
                    }
                });
                totalAdminReplies = adminCnt;
                const seen = parseInt(safeLS.get('seen_admin_replies') || '0', 10);
                if (open) {
                    safeLS.set('seen_admin_replies', totalAdminReplies);
                    if (newFound) { const c = document.getElementById('chatbot-messages'); if(c) c.scrollTop = c.scrollHeight; }
                } else if (totalAdminReplies > seen) {
                    unreadCount = totalAdminReplies - seen;
                    const b = document.getElementById('chatbot-notif');
                    if (b) { b.textContent = unreadCount > 99 ? '99+' : unreadCount; b.classList.add('show'); }
                }
            } catch(err){ console.error(err); }
        }

        async function sendMessage(e) {
            e.preventDefault();
            const input = document.getElementById('chatbot-input');
            const msg = input.value.trim();
            if (!msg) return;
            appendMsg('user', msg);
            input.value = '';
            const tid = 'typing-' + Date.now();
            appendTyping(tid);
            try {
                const r = await fetch('{{ route('chatbot') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ message: msg })
                });
                const data = await r.json();
                removeTyping(tid);
                appendMsg('ai', data.reply || data.answer || 'Maaf, tidak ada jawaban.');
                checkNew();
            } catch(err) { removeTyping(tid); appendMsg('ai', 'Maaf, terjadi kesalahan koneksi.'); }
        }

        function esc(t) {
            return t.replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));
        }

        function appendMsg(role, text, timeStr) {
            const c = document.getElementById('chatbot-messages');
            const row = document.createElement('div');
            row.className = `message-row ${role}`;
            row.style.marginBottom = '10px';
            if (!timeStr) { const n = new Date(); timeStr = String(n.getHours()).padStart(2,'0') + ':' + String(n.getMinutes()).padStart(2,'0'); }
            let t = esc(text).replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>').replace(/(https?:\/\/[^\s]+)/g, u => `<a href="${u}" target="_blank" style="text-decoration:underline;font-weight:600;color:inherit;">${u}</a>`);
            const align = role === 'user' ? 'flex-end' : 'flex-start';
            const ml = role === 'user' ? 'margin-right:4px;' : 'margin-left:4px;';
            row.innerHTML = `<div style="display:flex;flex-direction:column;align-items:${align};max-width:78%;"><div class="bubble ${role}-bubble">${t}</div><span class="message-time" style="${ml}">${timeStr}</span></div>`;
            c.appendChild(row);
            c.scrollTop = c.scrollHeight;
        }

        function appendTyping(id) {
            const c = document.getElementById('chatbot-messages');
            const row = document.createElement('div');
            row.id = id; row.className = 'message-row ai'; row.style.marginBottom = '10px';
            row.innerHTML = `<div style="display:flex;flex-direction:column;align-items:flex-start;max-width:78%;"><div class="bubble ai-bubble" style="padding:10px 14px;"><span class="typing-dot"></span><span class="typing-dot" style="margin:0 3px;"></span><span class="typing-dot"></span></div></div>`;
            c.appendChild(row); c.scrollTop = c.scrollHeight;
        }

        function removeTyping(id) { const el = document.getElementById(id); if(el) el.remove(); }

        setInterval(checkNew, 10000);
        window.addEventListener('DOMContentLoaded', checkNew);
        if (document.readyState === 'complete' || document.readyState === 'interactive') checkNew();
    </script>

    <!-- SweetAlert2 for User Side (e.g. Logout & Notifications) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert2 custom styling to match user side theme
            const swalOptions = {
                confirmButtonColor: '#8C5A35',
                cancelButtonColor: '#a08060',
                background: '#FFF8F2',
                color: '#4A2C17'
            };

            // Logout Confirmation
            const logoutForms = document.querySelectorAll('form[action="{{ route('logout') }}"]');
            logoutForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin ingin keluar?',
                        text: "Sesi Anda akan diakhiri.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Keluar!',
                        cancelButtonText: 'Batal',
                        ...swalOptions
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    })
                });
            });

            // General Confirm Form (Delete/Update)
            const confirmForms = document.querySelectorAll('.form-confirm');
            confirmForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const title = this.dataset.title || 'Apakah Anda yakin?';
                    const text = this.dataset.text || 'Tindakan ini tidak dapat dibatalkan.';
                    
                    Swal.fire({
                        title: title,
                        text: text,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Lanjutkan!',
                        cancelButtonText: 'Batal',
                        ...swalOptions
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    })
                });
            });
        });
    </script>
</body>
</html>
