<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CikalTas') }}</title>

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
            max-width: 80%;
            padding: 10px 14px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.4;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
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
            font-size: 10px;
            margin-top: 4px;
            opacity: 0.7;
            display: block;
            text-align: right;
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
            max-width: 80%;
            padding: 10px 14px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.4;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
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
            font-size: 10px;
            margin-top: 4px;
            opacity: 0.7;
            display: block;
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
            top: -4px;
            left: -4px;
            min-width: 20px;
            height: 20px;
            background: #EF4444;
            color: white;
            font-size: 11px;
            font-weight: 700;
            border-radius: 999px;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
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
            top: -2px;
            right: -2px;
            width: 16px;
            height: 16px;
            background: #22C55E;
            border-radius: 999px;
            border: 3px solid white;
            box-shadow: 0 0 8px rgba(34,197,94,0.6);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <div class="flex flex-1">
            <!-- Sidebar -->
            <aside class="w-64 bg-white border-r border-gray-200 shadow-[6px_0_16px_rgba(0,0,0,0.06)]">
                <div class="p-6">
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
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const toggle = document.querySelector('.dropdown-toggle');

            if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Prevent closing when clicking inside dropdown
        document.getElementById('userDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
        });
</script>
    <!-- Voiceflow Chatbot Integration -->
    <script type="text/javascript">
      (function(d, t) {
          var v = d.createElement(t), s = d.getElementsByTagName(t)[0];
          v.onload = function() {
            window.voiceflow.chat.load({
              verify: { projectID: '6a1a8811bd2a8f7a1f74ec04' },
              url: 'https://general-runtime.voiceflow.com',
              voice: {
                url: "https://runtime-api.voiceflow.com"
              },
              theme: {
                name: 'Cikaltas Assistant',
                description: 'Online',
                color: '#B8865C',
                avatar: '/gambar/Logo.png',
                logo: '/gambar/Logo.png'
              }
            });
          }
          v.src = "https://cdn.voiceflow.com/widget-next/bundle.mjs"; v.type = "text/javascript"; s.parentNode.insertBefore(v, s);
      })(document, 'script');
    </script>
</body>

</html>
