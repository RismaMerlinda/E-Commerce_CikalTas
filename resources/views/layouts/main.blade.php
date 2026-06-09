<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'CikalTas — Premium Bags for Modern Lifestyle' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('gambar/Logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 8px;
            background-color: white;
            min-width: 240px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            z-index: 1000;
            overflow: hidden;
        }

        .dropdown-content.show {
            display: block;
            animation: fadeIn 0.2s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-header {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }

        .dropdown-header img {
            border: 2px solid #664229;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #374151;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
        }

        .dropdown-item svg {
            width: 20px;
            height: 20px;
            color: #6b7280;
        }

                .dropdown-toggle {
            cursor: pointer;
        }

        /* Chatbot Custom Styles */
        .chatbot-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .chatbot-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .chatbot-scroll::-webkit-scrollbar-thumb {
            background: #d1d1d1;
            border-radius: 10px;
        }
        .message-row {
            display: flex;
            width: 100%;
            margin-bottom: 12px;
        }
        .message-row.user {
            justify-content: flex-end;
        }
        .message-row.ai {
            justify-content: flex-start;
        }
        .bubble {
            display: inline-block;
            padding: 9px 13px;
            border-radius: 15px;
            font-size: 14px;
            line-height: 1.4;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            white-space: normal;
            width: auto;
            max-width: 100%;
            word-break: break-word;
            overflow-wrap: anywhere;
        }
        .user-bubble {
            background: linear-gradient(135deg, #D4A574, #C49A6C);
            color: white;
            border-bottom-right-radius: 4px;
        }
        .ai-bubble {
            background-color: #f0f0f0;
            color: #333;
            border-bottom-left-radius: 4px;
        }
        .message-time {
            font-size: 10.5px;
            margin-top: 3px;
            opacity: 0.6;
            color: #6b7280;
            display: inline-block;
        }

        /* Chatbot toggle heartbeat animation */
        @keyframes heartbeat {
            0% { transform: scale(1); box-shadow: 0 4px 15px rgba(212,165,116,0.3); }
            15% { transform: scale(1.12); box-shadow: 0 6px 25px rgba(212,165,116,0.5); }
            30% { transform: scale(1); box-shadow: 0 4px 15px rgba(212,165,116,0.3); }
            45% { transform: scale(1.08); box-shadow: 0 5px 20px rgba(212,165,116,0.45); }
            60% { transform: scale(1); box-shadow: 0 4px 15px rgba(212,165,116,0.3); }
            100% { transform: scale(1); box-shadow: 0 4px 15px rgba(212,165,116,0.3); }
        }
        .chatbot-toggle-glow {
            animation: heartbeat 2s ease-in-out infinite;
            background: linear-gradient(135deg, #D4A574 0%, #C49A6C 50%, #B8865C 100%);
        }
        .chatbot-toggle-glow:hover {
            animation-play-state: paused;
            transform: scale(1.15) !important;
        }
        /* Notification badge */
        .chatbot-notif-badge {
            position: absolute;
            top: -3px;
            left: -3px;
            min-width: 16px;
            height: 16px;
            background: #EF4444;
            color: white;
            font-size: 9px;
            font-weight: 700;
            border-radius: 999px;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            border: 2px solid white;
            box-shadow: 0 2px 6px rgba(239,68,68,0.4);
            line-height: 1;
        }
        .chatbot-notif-badge.show {
            display: flex;
        }
        /* Green online dot */
        .chatbot-online-dot {
            position: absolute;
            top: -1px;
            right: -1px;
            width: 12px;
            height: 12px;
            background: #22C55E;
            border-radius: 999px;
            border: 2px solid white;
            box-shadow: 0 0 6px rgba(34,197,94,0.6);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <div class="flex flex-1">
            <!-- Sidebar -->
            <aside class="w-64 bg-white border-r border-gray-200 shadow-[6px_0_16px_rgba(0,0,0,0.06)]">
                <div class="p-6 flex items-center gap-3">
                    <img src="{{ asset('gambar/Logo.png') }}" alt="CikalTas Logo" class="w-8 h-8 object-contain">
                    <h1 class="text-2xl font-bold text-gray-800">CikalTas</h1>
                </div>

                <nav class="px-4 pb-4">
                    <a href="{{ route('beranda') }}"
                        class="flex items-center gap-3 px-4 py-3 mb-2 {{ request()->routeIs('beranda') ? 'bg-amber-800 text-white' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="font-medium">Beranda</span>
                    </a>

                    <a href="{{ route('keranjang') }}"
                        class="flex items-center gap-3 px-4 py-3 mb-2 {{ request()->routeIs('keranjang') ? 'bg-amber-800 text-white' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="font-medium">Keranjang</span>
                    </a>

                    <a href="{{ route('pesanan') }}"
                        class="flex items-center gap-3 px-4 py-3 mb-2 {{ request()->routeIs('pesanan') ? 'bg-amber-800 text-white' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="font-medium">Pesanan</span>
                    </a>

                    <a href="{{ route('pembayaran') }}"
                        class="flex items-center gap-3 px-4 py-3 mb-2 {{ request()->routeIs('pembayaran') ? 'bg-amber-800 text-white' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <span class="font-medium">Pembayaran</span>
                    </a>

                    <a href="{{ route('profil') }}"
                        class="flex items-center gap-3 px-4 py-3 mb-2 {{ request()->routeIs('profil') ? 'bg-amber-800 text-white' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="font-medium">Profil</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="font-medium">Keluar</span>
                        </button>
                    </form>
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col">
                <!-- Header -->
                <header class="bg-white shadow-sm">
                    <div class="flex items-center justify-between px-8 py-4">
                        <div class="flex-1 max-w-xl">
                            <div class="relative">
                                <input type="text" placeholder="Search..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- User Dropdown -->
                        <div class="dropdown ml-6">
                            <div class="dropdown-toggle flex items-center gap-3" onclick="toggleDropdown()">
                                <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->nama_lengkap ?? 'User') . '&background=664229&color=fff' }}"
                                    alt="User" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ Auth::user()->nama_lengkap ?? 'User' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ Auth::user()->role === 'admin' ? 'Admin' : 'User' }}
                                    </p>
                                </div>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>

                            <div id="userDropdown" class="dropdown-content">
                                <div class="dropdown-header">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->nama_lengkap ?? 'User') . '&background=664229&color=fff&size=80' }}"
                                            alt="User" class="w-12 h-12 rounded-full object-cover">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">
                                                {{ Auth::user()->nama_lengkap ?? 'User' }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ Auth::user()->role === 'admin' ? 'Admin' : 'User' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('profil') }}" class="dropdown-item">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="font-medium">Ubah Profil</span>
                                </a>

                                <a href="{{ route('pesanan') }}" class="dropdown-item">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium">Histori</span>
                                </a>

                                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="dropdown-item w-full text-left">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span class="font-medium">Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <footer class="bg-white border-t border-gray-200">
            <div class="px-8 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                <p class="text-sm text-gray-500">© {{ date('Y') }} CikalTas. All rights reserved.</p>
                <div class="text-sm text-gray-500">
                    <span class="font-semibold" style="color:#664229;">CikalTas</span>
                    <span class="mx-2 text-gray-300">|</span>
                    <span>Premium Bags Collection</span>
                </div>
            </div>
        </footer>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown) dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const toggle = document.querySelector('.dropdown-toggle');

            if (dropdown && toggle && !toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Prevent closing when clicking inside dropdown
        document.getElementById('userDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
        });
    </script>
    
    <!-- Chatbot Widget Start -->
    <div id="chatbot-widget" class="fixed flex flex-col bg-white border border-gray-200 shadow-2xl overflow-hidden transition-all duration-300 ease-in-out" style="z-index: 9999; display: none; bottom: 20px; right: 20px; width: 340px; height: 420px; border-radius: 18px;">
        <!-- Header -->
        <div class="flex items-center justify-between text-white p-2.5 shadow-md" style="background: linear-gradient(135deg, #D4A574 0%, #C49A6C 50%, #B8865C 100%);">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 flex items-center justify-center">
                    <img src="{{ asset('gambar/Logo.png') }}" alt="CikalTas Logo" class="w-7 h-7 object-contain" />
                </div>
                <div>
                    <h3 class="font-bold text-[13px] leading-tight">Cikal Assistant</h3>
                    <div class="flex items-center gap-1 mt-0.5">
                        <span class="w-2 h-2 bg-green-300 rounded-full animate-pulse"></span>
                        <span class="text-[9px] text-green-100">Online</span>
                    </div>
                </div>
            </div>
            <button type="button" onclick="closeChatbot()" class="p-0.5 hover:bg-white/20 rounded-full transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Messages Area -->
        <div id="chatbot-messages" class="flex-1 p-2.5 overflow-y-auto bg-[#f8f9fa] chatbot-scroll flex flex-col gap-2">
            <div class="message-row ai">
                <div class="flex flex-col items-start max-w-[70%]">
                    <div class="bubble ai-bubble shadow-sm">Halo! Saya Cikal Assistant. Ada yang bisa saya bantu terkait produk CikalTas?</div>
                    <span class="message-time ml-1">Baru saja</span>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-2.5 bg-white border-t border-gray-100 flex flex-col">
            <a href="{{ route('support.index') }}" class="text-[11px] text-center text-[#D4A574] hover:underline mb-2 font-medium">
                Butuh bantuan manusia? Hubungi Admin
            </a>
            <form id="chatbot-form" class="flex items-center gap-2" onsubmit="sendMessage(event)">
                <input type="text" id="chatbot-input" 
                    class="flex-1 border-none bg-gray-100 rounded-full px-3 py-1.5 text-[13px] focus:ring-1 focus:ring-[#D4A574] focus:outline-none" 
                    placeholder="Ketik pesan..." required />
                <button type="submit" class="text-white p-2 rounded-full hover:scale-105 active:scale-95 transition-all shadow-md flex items-center justify-center" style="background: linear-gradient(135deg, #D4A574, #C49A6C);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Toggle Button -->
    <button id="chatbot-toggle" onclick="openChatbot()" class="chatbot-toggle-glow" style="z-index: 9998; position: fixed; bottom: 20px; right: 20px; width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: none; outline: none; cursor: pointer; transition: transform 0.3s;">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white drop-shadow-md" viewBox="0 0 32 32" fill="none">
            <path d="M22 6H12C9.79 6 8 7.79 8 10V16C8 18.21 9.79 20 12 20H13L15 23L17 20H22C24.21 20 26 18.21 26 16V10C26 7.79 24.21 6 22 6Z" fill="rgba(255,255,255,0.35)"/>
            <path d="M20 10H10C7.79 10 6 11.79 6 14V20C6 22.21 7.79 24 10 24H11L13 27L15 24H20C22.21 24 24 22.21 24 20V14C24 11.79 22.21 10 20 10Z" fill="white"/>
            <circle cx="11.5" cy="17" r="1.2" fill="#B8865C"/>
            <circle cx="15" cy="17" r="1.2" fill="#B8865C"/>
            <circle cx="18.5" cy="17" r="1.2" fill="#B8865C"/>
        </svg>
        <span class="chatbot-online-dot"></span>
        <span id="chatbot-notif" class="chatbot-notif-badge">0</span>
    </button>
    <!-- Chatbot Widget End -->



    <script>
        // Safe LocalStorage wrapper
        const safeLocalStorage = {
            getItem(key) {
                try {
                    return localStorage.getItem(key);
                } catch (e) {
                    return null;
                }
            },
            setItem(key, value) {
                try {
                    localStorage.setItem(key, value);
                } catch (e) {}
            }
        };

        // Chatbot Widget State
        let unreadCount = 0;
        let displayedMessageIds = new Set();
        let totalAdminReplies = 0;

        function formatTime(isoString) {
            if (!isoString) return 'Baru saja';
            try {
                const date = new Date(isoString);
                return date.getHours().toString().padStart(2, '0') + ':' + date.getMinutes().toString().padStart(2, '0');
            } catch (e) {
                return 'Baru saja';
            }
        }

        function clearNotif() {
            unreadCount = 0;
            const badge = document.getElementById('chatbot-notif');
            if (badge) {
                badge.textContent = '0';
                badge.style.display = 'none';
            }
        }

        function openChatbot() {
            const widget = document.getElementById('chatbot-widget');
            const toggle = document.getElementById('chatbot-toggle');
            if (widget) widget.style.display = 'flex';
            if (toggle) toggle.style.display = 'none';
            clearNotif();

            const seenCount = safeLocalStorage.getItem('seen_admin_replies_count') || 0;
            if (totalAdminReplies > seenCount) {
                safeLocalStorage.setItem('seen_admin_replies_count', totalAdminReplies);
            }

            loadHistory();
        }

        function closeChatbot() {
            const widget = document.getElementById('chatbot-widget');
            const toggle = document.getElementById('chatbot-toggle');
            if (widget) widget.style.display = 'none';
            if (toggle) toggle.style.display = 'flex';
        }

        async function loadHistory() {
            const container = document.getElementById('chatbot-messages');
            if (!container) return;

            container.innerHTML = `
                <div class="message-row ai">
                    <div class="flex flex-col items-start max-w-[70%]">
                        <div class="bubble ai-bubble shadow-sm">Halo! Saya Cikal Assistant. Ada yang bisa saya bantu terkait produk CikalTas?</div>
                        <span class="message-time ml-1">Baru saja</span>
                    </div>
                </div>
            `;

            displayedMessageIds.clear();

            try {
                const response = await fetch('{{ route('chatbot.history') }}');
                if (response.ok) {
                    const messages = await response.json();
                    let adminRepliesCount = 0;

                    messages.forEach(msg => {
                        displayedMessageIds.add(msg.id);
                        if (msg.sender_type === 'user') {
                            appendMessage('user', msg.message, formatTime(msg.created_at));
                        } else if (msg.sender_type === 'admin') {
                            appendMessage('ai', `🧑‍💼 **Admin:** ${msg.message}`, formatTime(msg.created_at));
                            adminRepliesCount++;
                        } else {
                            appendMessage('ai', msg.message, formatTime(msg.created_at));
                        }
                    });

                    totalAdminReplies = adminRepliesCount;
                    safeLocalStorage.setItem('seen_admin_replies_count', totalAdminReplies);
                }
            } catch (err) {
                console.error("Error loading chatbot history:", err);
            }
        }

        async function checkNewMessages() {
            try {
                const chatbotWidget = document.getElementById('chatbot-widget');
                if (!chatbotWidget) return;

                const response = await fetch('{{ route('chatbot.history') }}');
                if (!response.ok) return;

                const messages = await response.json();
                const isWidgetOpen = chatbotWidget.style.display === 'flex';

                let adminRepliesCount = 0;
                let newRepliesFound = false;

                messages.forEach(msg => {
                    if (msg.sender_type === 'admin') {
                        adminRepliesCount++;
                    }

                    if (isWidgetOpen) {
                        if (!displayedMessageIds.has(msg.id)) {
                            displayedMessageIds.add(msg.id);
                            if (msg.sender_type === 'user') {
                                appendMessage('user', msg.message, formatTime(msg.created_at));
                            } else if (msg.sender_type === 'admin') {
                                appendMessage('ai', `🧑‍💼 **Admin:** ${msg.message}`, formatTime(msg.created_at));
                            } else {
                                appendMessage('ai', msg.message, formatTime(msg.created_at));
                            }
                            newRepliesFound = true;
                        }
                    }
                });

                totalAdminReplies = adminRepliesCount;
                const seenCount = parseInt(safeLocalStorage.getItem('seen_admin_replies_count') || '0', 10);

                if (isWidgetOpen) {
                    safeLocalStorage.setItem('seen_admin_replies_count', totalAdminReplies);
                    if (newRepliesFound) {
                        const container = document.getElementById('chatbot-messages');
                        if (container) container.scrollTop = container.scrollHeight;
                    }
                } else {
                    if (totalAdminReplies > seenCount) {
                        unreadCount = totalAdminReplies - seenCount;
                        const badge = document.getElementById('chatbot-notif');
                        if (badge) {
                            badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
                            badge.style.display = 'flex';
                        }
                    }
                }
            } catch (err) {
                console.error("Error checking new messages:", err);
            }
        }

        async function sendMessage(e) {
            e.preventDefault();
            const input = document.getElementById('chatbot-input');
            const message = input.value.trim();
            if (!message) return;

            appendMessage('user', message);
            input.value = '';
            const typingId = 'typing-' + Date.now();
            appendTypingIndicator(typingId);

            try {
                const response = await fetch('{{ route('chatbot') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message })
                });
                const data = await response.json();
                removeTypingIndicator(typingId);
                appendMessage('ai', data.reply || data.answer || 'Maaf, tidak ada jawaban.');
                checkNewMessages();
            } catch (err) {
                removeTypingIndicator(typingId);
                appendMessage('ai', 'Maaf, terjadi kesalahan koneksi.');
            }
        }

        function escapeHtml(text) {
            const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        function appendMessage(role, text, timeStr) {
            const container = document.getElementById('chatbot-messages');
            const row = document.createElement('div');
            row.className = `message-row ${role}`;
            if (!timeStr) {
                const now = new Date();
                timeStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
            }
            let formattedText = escapeHtml(text);
            formattedText = formattedText.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            const urlRegex = /(https?:\/\/[^\s]+)/g;
            formattedText = formattedText.replace(urlRegex, function(url) {
                return `<a href="${url}" target="_blank" class="underline font-semibold hover:opacity-85 text-amber-800" style="color: inherit;">${url}</a>`;
            });
            const alignClass = role === 'user' ? 'items-end' : 'items-start';
            const marginClass = role === 'user' ? 'mr-1' : 'ml-1';
            row.innerHTML = `
                <div class="flex flex-col ${alignClass} max-w-[70%]">
                    <div class="bubble ${role}-bubble shadow-sm">${formattedText}</div>
                    <span class="message-time ${marginClass}">${timeStr}</span>
                </div>
            `;
            container.appendChild(row);
            container.scrollTop = container.scrollHeight;
        }

        function appendTypingIndicator(id) {
            const container = document.getElementById('chatbot-messages');
            const row = document.createElement('div');
            row.id = id;
            row.className = 'message-row ai';
            row.innerHTML = `
                <div class="flex flex-col items-start max-w-[70%]">
                    <div class="bubble ai-bubble flex gap-1 items-center py-2 px-3">
                        <span class="w-1.2 h-1.2 bg-gray-400 rounded-full animate-bounce"></span>
                        <span class="w-1.2 h-1.2 bg-gray-400 rounded-full animate-bounce [animation-delay:0.2s]"></span>
                        <span class="w-1.2 h-1.2 bg-gray-400 rounded-full animate-bounce [animation-delay:0.4s]"></span>
                    </div>
                </div>
            `;
            container.appendChild(row);
            container.scrollTop = container.scrollHeight;
        }

        function removeTypingIndicator(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }

        setInterval(checkNewMessages, 10000);
        window.addEventListener('DOMContentLoaded', checkNewMessages);
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            checkNewMessages();
        }
    </script>
</body>

</html>
