<x-main-layout>
    <x-slot name="title">Keranjang Belanja - CikalTas</x-slot>

    <style>
        .page-title-row {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
        }
        .page-title-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #6B4226, #C4956A);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
        }
        .page-title-icon svg { width: 22px; height: 22px; color: #fff; }
        .page-title { font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 700; color: #2E1B0E; }
        .page-subtitle { font-size: 13px; color: #a08060; }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            border: 1px solid #6ee7b7;
            color: #065f46;
            padding: 14px 20px;
            border-radius: 14px;
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Cart Layout */
        .cart-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            align-items: start;
        }
        @media (max-width: 900px) { .cart-layout { grid-template-columns: 1fr; } }

        /* Cart Item Card */
        .cart-item {
            background: #fff;
            border-radius: 18px;
            padding: 20px;
            display: flex;
            gap: 18px;
            align-items: center;
            border: 1px solid rgba(196,149,106,0.1);
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            transition: box-shadow 0.2s, transform 0.2s;
            margin-bottom: 16px;
        }
        .cart-item:last-child { margin-bottom: 0; }
        .cart-item:hover { box-shadow: 0 8px 28px rgba(107,66,38,0.1); transform: translateY(-2px); }

        .cart-item-img {
            width: 100px; height: 100px;
            border-radius: 14px;
            background: linear-gradient(135deg, #fdf5ec, #f5ede3);
            flex-shrink: 0;
            overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            border: 1px solid rgba(196,149,106,0.12);
        }
        .cart-item-img img { width: 100%; height: 100%; object-fit: contain; padding: 10px; }

        .cart-item-info { flex: 1; }
        .cart-item-name {
            font-size: 15px; font-weight: 700; color: #1a1a1a;
            margin-bottom: 4px;
        }
        .cart-item-price {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px; font-weight: 700;
            color: #6B4226;
            margin-bottom: 12px;
        }

        /* Qty Stepper */
        .qty-stepper {
            display: flex; align-items: center; gap: 0;
            background: #faf5ef;
            border: 1.5px solid rgba(196,149,106,0.2);
            border-radius: 10px;
            overflow: hidden;
            width: fit-content;
        }
        .qty-btn {
            width: 36px; height: 36px;
            background: none; border: none;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: #6B4226;
            transition: background 0.15s;
        }
        .qty-btn:hover { background: rgba(196,149,106,0.15); }
        .qty-btn svg { width: 16px; height: 16px; }
        .qty-val {
            min-width: 44px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700;
            color: #2E1B0E;
            border-left: 1px solid rgba(196,149,106,0.15);
            border-right: 1px solid rgba(196,149,106,0.15);
        }

        /* Delete btn */
        .btn-remove {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: #fff5f5;
            border: 1.5px solid #fecaca;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .btn-remove:hover { background: #fee2e2; border-color: #fca5a5; }
        .btn-remove svg { width: 18px; height: 18px; color: #ef4444; }

        /* Order Summary Card */
        .summary-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid rgba(196,149,106,0.12);
            box-shadow: 0 2px 16px rgba(0,0,0,0.05);
            overflow: hidden;
            position: sticky;
            top: 80px;
        }

        .summary-header {
            padding: 20px 24px 16px;
            border-bottom: 1px solid rgba(196,149,106,0.1);
        }
        .summary-header h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px; font-weight: 700;
            color: #2E1B0E;
        }

        .summary-body { padding: 20px 24px; }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }
        .summary-row span:first-child { font-size: 13.5px; color: #888; }
        .summary-row span:last-child { font-size: 13.5px; font-weight: 600; color: #1a1a1a; }

        .summary-divider { height: 1px; background: linear-gradient(90deg, rgba(196,149,106,0.2), transparent); margin: 16px 0; }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .summary-total span:first-child { font-size: 15px; font-weight: 700; color: #2E1B0E; }
        .summary-total-price {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px; font-weight: 700;
            color: #6B4226;
        }

        .btn-checkout {
            display: block;
            width: 100%;
            padding: 14px;
            text-align: center;
            background: linear-gradient(135deg, #6B4226, #C4956A);
            color: #fff;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.25s;
            box-shadow: 0 6px 20px rgba(107,66,38,0.3);
            font-family: 'Inter', sans-serif;
        }
        .btn-checkout:hover {
            background: linear-gradient(135deg, #5a3820, #a87e55);
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(107,66,38,0.4);
        }

        .btn-clear {
            display: block;
            width: 100%;
            margin-top: 10px;
            padding: 12px;
            text-align: center;
            background: #fafafa;
            color: #888;
            border: 1.5px solid #e5e5e5;
            border-radius: 14px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }
        .btn-clear:hover { background: #fff5f5; color: #d94f4f; border-color: #fecaca; }

        /* Free shipping badge */
        .free-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            font-weight: 600;
            color: #059669;
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            padding: 4px 10px;
            border-radius: 50px;
        }

        /* Empty Cart */
        .empty-cart {
            background: #fff;
            border-radius: 20px;
            padding: 80px 32px;
            text-align: center;
            border: 1.5px dashed rgba(196,149,106,0.25);
        }
        .empty-cart svg { color: #d4b89a; margin: 0 auto 16px; }
        .empty-cart h2 { font-family: 'Cormorant Garamond', serif; font-size: 26px; font-weight: 700; color: #6B4226; margin-bottom: 8px; }
        .empty-cart p { color: #a08060; font-size: 14.5px; margin-bottom: 24px; }
        .btn-start-shop {
            display: inline-block;
            padding: 13px 28px;
            background: linear-gradient(135deg, #6B4226, #C4956A);
            color: #fff;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            font-size: 14px;
            box-shadow: 0 6px 20px rgba(107,66,38,0.25);
            transition: all 0.2s;
        }
        .btn-start-shop:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(107,66,38,0.35); }
        /* ══════════════════════════════════════════════
           RESPONSIVE STYLE
        ══════════════════════════════════════════════ */
        @media (max-width: 600px) {
            .page-title-row { margin-bottom: 20px; }
            .page-title { font-size: 22px; }
            .cart-item {
                position: relative;
                padding: 16px;
                padding-bottom: 64px; /* Space for stepper at bottom */
                gap: 14px;
                align-items: flex-start;
            }
            .cart-item-img {
                width: 72px; height: 72px;
            }
            .cart-item-name {
                font-size: 13.5px;
                padding-right: 32px; /* Avoid overlapping with close button */
            }
            .cart-item-price { font-size: 17px; margin-bottom: 0; }
            
            .qty-stepper {
                position: absolute;
                bottom: 16px;
                left: 102px; /* Align under text */
            }
            .btn-remove {
                position: absolute;
                top: 16px;
                right: 16px;
                width: 32px; height: 32px;
            }
            .btn-remove svg { width: 16px; height: 16px; }

            .summary-card {
                position: static;
                margin-top: 16px;
            }
        }
    </style>

    <!-- Page Title -->
    <div class="page-title-row">
        <div class="page-title-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
        </div>
        <div>
            <div class="page-title">Keranjang Belanja</div>
            <div class="page-subtitle">{{ $cartItems->count() }} item dalam keranjang Anda</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($cartItems->count() > 0)
        <div class="cart-layout">
            <!-- Cart Items -->
            <div>
                @foreach($cartItems as $item)
                    <div class="cart-item" id="cart-row-{{ $item->id }}">
                        <div class="cart-item-img">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                            @else
                                <svg style="width:40px;height:40px;color:#d4b89a;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            @endif
                        </div>

                        <div class="cart-item-info">
                            <div class="cart-item-name">{{ $item->product->name }}</div>
                            <div class="cart-item-price">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>

                            <div class="qty-stepper">
                                <button class="qty-btn" onclick="updateQuantity({{ $item->id }}, -1)">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/></svg>
                                </button>
                                <div class="qty-val" id="qty-{{ $item->id }}">{{ $item->quantity }}</div>
                                <button class="qty-btn" onclick="updateQuantity({{ $item->id }}, 1)">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                </button>
                            </div>
                        </div>

                        <button class="btn-remove" onclick="removeFromCart({{ $item->id }})">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="summary-card">
                <div class="summary-header">
                    <h2>Ringkasan Pesanan</h2>
                </div>
                <div class="summary-body">
                    <div class="summary-row">
                        <span>Subtotal ({{ $cartItems->count() }} item)</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkos Kirim</span>
                        <span class="free-badge">
                            <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Gratis
                        </span>
                    </div>
                    <div class="summary-divider"></div>
                    <div class="summary-total">
                        <span>Total Pembayaran</span>
                        <span class="summary-total-price">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('pembayaran') }}" class="btn-checkout">
                        Lanjut ke Pembayaran →
                    </a>
                    <button class="btn-clear"
                        onclick="if(confirm('Yakin ingin mengosongkan keranjang?')) window.location.href='{{ route('keranjang.clear') }}'">
                        Kosongkan Keranjang
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="empty-cart">
            <svg style="width:80px;height:80px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h2>Keranjang Kosong</h2>
            <p>Yuk, temukan tas impianmu di koleksi CikalTas!</p>
            <a href="{{ route('beranda') }}" class="btn-start-shop">Mulai Belanja →</a>
        </div>
    @endif

    <script>
        function updateQuantity(id, change) {
            const el = document.getElementById(`qty-${id}`);
            let newQty = parseInt(el.textContent) + change;
            if (newQty < 1) return;
            el.textContent = newQty;

            fetch(`/keranjang/${id}`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                body: JSON.stringify({ quantity: newQty })
            }).then(r => r.json()).then(data => { if (data.success) location.reload(); })
              .catch(() => alert('Gagal mengupdate keranjang'));
        }

        function removeFromCart(id) {
            if (!confirm('Yakin ingin menghapus produk ini?')) return;
            fetch(`/keranjang/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
            }).then(r => r.json()).then(data => { if (data.success) location.reload(); })
              .catch(() => alert('Gagal menghapus produk'));
        }
    </script>
</x-main-layout>
