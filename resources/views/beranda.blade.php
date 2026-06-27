<x-main-layout>
    <x-slot name="title">Beranda - CikalTas</x-slot>

    <style>
        /* ── Page Header ── */
        .page-hero {
            background: linear-gradient(135deg, #2E1B0E 0%, #6B4226 60%, #C4956A 100%);
            border-radius: 20px;
            padding: 36px 40px;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .page-hero::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
        }
        .page-hero::after {
            content: '';
            position: absolute;
            bottom: -60px; left: 30%;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.04) 0%, transparent 70%);
        }
        .page-hero-content { position: relative; z-index: 1; }
        .page-hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50px;
            padding: 4px 12px;
            font-size: 11px;
            color: rgba(255,255,255,0.85);
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }
        .page-hero h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 38px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 10px;
        }
        .page-hero p {
            font-size: 14.5px;
            color: rgba(255,255,255,0.75);
            line-height: 1.65;
            max-width: 480px;
        }
        .hero-stats {
            display: flex;
            gap: 24px;
            position: relative;
            z-index: 1;
        }
        .hero-stat {
            text-align: center;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 14px;
            padding: 14px 20px;
            backdrop-filter: blur(10px);
        }
        .hero-stat-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            line-height: 1;
        }
        .hero-stat-label {
            font-size: 10.5px;
            color: rgba(255,255,255,0.65);
            font-weight: 500;
            margin-top: 4px;
        }

        /* ── Section Header ── */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 26px;
            font-weight: 700;
            color: #2E1B0E;
        }
        .section-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, rgba(196,149,106,0.4), transparent);
            margin: 0 20px;
        }

        /* ── Product Grid ── */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 24px;
        }

        .product-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
            border: 1px solid rgba(196,149,106,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 48px rgba(107,66,38,0.14);
        }

        .product-img-wrap {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #fdf5ec, #f5ede3);
            aspect-ratio: 1/1;
        }

        .product-img-wrap img {
            width: 100%; height: 100%;
            object-fit: contain;
            padding: 20px;
            transition: transform 0.4s ease;
        }
        .product-card:hover .product-img-wrap img {
            transform: scale(1.06);
        }

        .product-badge {
            position: absolute;
            top: 12px; left: 12px;
            background: linear-gradient(135deg, #6B4226, #C4956A);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 50px;
            letter-spacing: 0.5px;
        }

        .product-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(46,27,14,0.5), transparent 50%);
            opacity: 0;
            transition: opacity 0.3s;
            display: flex;
            align-items: flex-end;
            padding: 16px;
        }
        .product-card:hover .product-overlay { opacity: 1; }

        .btn-detail {
            width: 100%;
            padding: 10px;
            background: rgba(255,255,255,0.95);
            color: #6B4226;
            border: none;
            border-radius: 10px;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .btn-detail:hover { background: #fff; }

        .product-info {
            padding: 18px;
        }

        .product-name {
            font-size: 15px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 6px;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-desc {
            font-size: 12.5px;
            color: #888;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 14px;
        }

        .product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .product-price {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 700;
            color: #6B4226;
        }

        .btn-detail-link {
            font-size: 12px;
            font-weight: 600;
            color: #C4956A;
            background: none;
            border: none;
            cursor: pointer;
            text-decoration: underline;
            font-family: 'Inter', sans-serif;
            transition: color 0.2s;
        }
        .btn-detail-link:hover { color: #6B4226; }

        .product-actions {
            display: flex;
            gap: 8px;
        }

        .btn-buy {
            flex: 1;
            padding: 10px;
            background: linear-gradient(135deg, #6B4226, #C4956A);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(107,66,38,0.25);
        }
        .btn-buy:hover {
            background: linear-gradient(135deg, #5a3820, #a87e55);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(107,66,38,0.35);
        }

        .btn-cart {
            flex: 1;
            padding: 10px;
            background: #fff;
            color: #6B4226;
            border: 1.5px solid rgba(107,66,38,0.2);
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }
        .btn-cart:hover {
            background: #fdf5ec;
            border-color: #C4956A;
        }

        /* ── Empty State ── */
        .empty-state {
            text-align: center;
            padding: 80px 32px;
            background: #fff;
            border-radius: 20px;
            border: 1.5px dashed rgba(196,149,106,0.3);
        }
        .empty-state svg { color: #d4b89a; margin: 0 auto 16px; }
        .empty-state h3 { font-size: 18px; font-weight: 700; color: #6B4226; margin-bottom: 8px; }
        .empty-state p { color: #a08060; font-size: 14px; }

        /* ── Product Modal ── */
        .modal-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.55);
            backdrop-filter: blur(6px);
            z-index: 9000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal-overlay.open { display: flex; animation: fadeIn 0.2s ease; }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .modal-card {
            background: #fff;
            border-radius: 24px;
            max-width: 480px;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 40px 100px rgba(0,0,0,0.3);
            animation: slideUp 0.25s ease;
        }
        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to   { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            background: linear-gradient(135deg, #2E1B0E, #6B4226);
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-header h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
        }
        .modal-close {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.2s;
        }
        .modal-close:hover { background: rgba(255,255,255,0.25); }
        .modal-close svg { width: 16px; height: 16px; color: #fff; }

        .modal-img-area {
            background: linear-gradient(135deg, #fdf5ec, #f5ede3);
            height: 260px;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .modal-img-area img {
            max-width: 100%; max-height: 100%;
            object-fit: contain;
            padding: 20px;
        }

        .modal-body { padding: 24px; }
        .modal-body p {
            font-size: 14.5px;
            color: #555;
            line-height: 1.7;
            text-align: center;
        }

        /* ── Toast ── */
        .toast {
            position: fixed;
            bottom: 90px; right: 24px;
            background: linear-gradient(135deg, #2E1B0E, #6B4226);
            color: #fff;
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            z-index: 9999;
            display: none;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            animation: toastSlide 0.3s ease;
        }
        .toast.show { display: flex; }
        /* ══════════════════════════════════════════════
           RESPONSIVE STYLE
        ══════════════════════════════════════════════ */
        @media (max-width: 900px) {
            .page-hero {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
                gap: 24px;
                padding: 28px 24px;
            }
            .page-hero p { margin: 0 auto; }
            .hero-stats { justify-content: center; }
        }

        @media (max-width: 600px) {
            .page-hero h1 { font-size: 28px; }
            .page-hero p { font-size: 13px; }
            .hero-stats { gap: 12px; }
            .hero-stat { padding: 10px 14px; }
            .hero-stat-num { font-size: 20px; }

            .section-header { flex-direction: column; align-items: flex-start; gap: 8px; }
            .section-line { display: none; }

            /* Premium 2-column layout on mobile */
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
            .product-info { padding: 10px; }
            .product-name { font-size: 13px; margin-bottom: 4px; }
            .product-desc { display: none; } /* Hide descriptions on mobile to save space */
            .product-price { font-size: 16px; }
            .btn-detail-link { font-size: 11px; }
            .product-footer { margin-bottom: 8px; flex-direction: column; align-items: flex-start; gap: 4px; }
            .product-actions { width: 100%; gap: 6px; }
            .btn-buy, .btn-cart { padding: 8px 4px; font-size: 11px; }

            .modal-card {
                border-radius: 16px;
                max-width: 95%;
            }
            .modal-img-area { height: 180px; }
            .modal-body { padding: 16px; }
            .modal-body p { font-size: 13px; }
        }
    </style>

    <!-- Hero Banner -->
    <div class="page-hero">
        <div class="page-hero-content">
            <div class="page-hero-tag">
                <span>✨</span> Koleksi Terbaru
            </div>
            <h1>Selamat Datang<br>di CikalTas!</h1>
            <p>Temukan koleksi tas premium dengan desain stylish, bahan terbaik, dan kenyamanan maksimal untuk setiap aktivitasmu.</p>
        </div>
        <div class="hero-stats">
            <div class="hero-stat">
                <div class="hero-stat-num">{{ $products->total() ?? $products->count() }}+</div>
                <div class="hero-stat-label">Produk</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-num">100%</div>
                <div class="hero-stat-label">Original</div>
            </div>
        </div>
    </div>

    <!-- Section Header -->
    <div class="section-header">
        <h2 class="section-title">Produk Pilihan</h2>
        <div class="section-line"></div>
    </div>

    <!-- Products Grid -->
    <div class="product-grid">
        @forelse($products as $product)
            <div class="product-card">
                <div class="product-img-wrap">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                            <svg style="width:64px;height:64px;color:#d4b89a;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="product-badge">CikalTas</div>
                    <div class="product-overlay">
                        <button class="btn-detail" onclick="showProductDetail({{ $product->id }})">Lihat Detail</button>
                    </div>
                </div>
                <div class="product-info">
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-desc">{{ $product->description }}</div>
                    <div class="product-footer">
                        <span class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <button class="btn-detail-link" onclick="showProductDetail({{ $product->id }})">Detail →</button>
                    </div>
                    <div class="product-actions">
                        <button class="btn-buy" onclick="buyNow({{ $product->id }})">Beli Sekarang</button>
                        <button class="btn-cart" onclick="addToCart({{ $product->id }})">+ Keranjang</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state" style="grid-column:1/-1;">
                <svg style="width:72px;height:72px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h3>Belum Ada Produk</h3>
                <p>Produk akan segera tersedia. Pantau terus!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div style="margin-top:32px;">{{ $products->links() }}</div>
    @endif

    <!-- Product Modal -->
    <div id="productModal" class="modal-overlay" onclick="if(event.target===this) closeModal()">
        <div class="modal-card">
            <div class="modal-header">
                <h2 id="modalTitle">Detail Produk</h2>
                <button class="modal-close" onclick="closeModal()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="modal-img-area">
                <img id="modalImage" src="" alt="Produk">
            </div>
            <div class="modal-body">
                <p id="modalDescription"></p>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast">
        <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg>
        <span id="toastMsg">Berhasil!</span>
    </div>

    <script>
        function showToast(msg) {
            const t = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 3000);
        }

        function showProductDetail(id) {
            fetch(`/produk/${id}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }})
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const p = data.product;
                        document.getElementById('modalTitle').textContent = p.name;
                        document.getElementById('modalDescription').textContent = p.description;
                        const img = document.getElementById('modalImage');
                        img.src = p.image ? `/storage/${p.image}` : '';
                        document.getElementById('productModal').classList.add('open');
                        document.body.style.overflow = 'hidden';
                    }
                })
                .catch(() => alert('Gagal memuat detail produk'));
        }

        function closeModal() {
            document.getElementById('productModal').classList.remove('open');
            document.body.style.overflow = '';
        }

        function addToCart(id) {
            fetch('/keranjang/add', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                body: JSON.stringify({ product_id: id, quantity: 1 })
            }).then(r => r.json()).then(data => {
                if (data.success) showToast(data.message || 'Produk ditambahkan ke keranjang!');
                else alert(data.message || 'Gagal menambahkan');
            }).catch(() => alert('Gagal menambahkan produk ke keranjang'));
        }

        function buyNow(id) {
            fetch('/keranjang/add', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                body: JSON.stringify({ product_id: id, quantity: 1 })
            }).then(r => r.json()).then(data => { if (data.success) window.location.href = '/keranjang'; })
              .catch(() => alert('Gagal memproses'));
        }

        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
    </script>
</x-main-layout>
