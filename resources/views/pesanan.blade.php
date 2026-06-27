<x-main-layout>
    <x-slot name="title">Pesanan Saya - CikalTas</x-slot>

    <style>
        .page-title-row {
            display: flex; align-items: center; gap: 14px; margin-bottom: 28px;
        }
        .page-title-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #6B4226, #C4956A);
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
        }
        .page-title-icon svg { width: 22px; height: 22px; color: #fff; }
        .page-title { font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 700; color: #2E1B0E; }
        .page-subtitle { font-size: 13px; color: #a08060; }

        /* Order Card */
        .order-card {
            background: #fff;
            border-radius: 20px;
            margin-bottom: 20px;
            border: 1px solid rgba(196,149,106,0.1);
            box-shadow: 0 2px 14px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .order-card:hover { box-shadow: 0 10px 32px rgba(107,66,38,0.1); transform: translateY(-2px); }
        .order-card:last-child { margin-bottom: 0; }

        .order-card-header {
            padding: 18px 24px;
            background: linear-gradient(135deg, #2E1B0E, #4a2a15);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .order-num {
            display: flex; align-items: center; gap: 10px;
        }
        .order-num-badge {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            border: 1.5px solid rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: #fff;
        }
        .order-num-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 17px; font-weight: 700; color: #fff;
        }
        .order-date { font-size: 11.5px; color: rgba(255,255,255,0.6); margin-top: 2px; }

        /* Status Badges */
        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 12px; font-weight: 700;
        }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-paid, .status-processing { background: #dbeafe; color: #1d4ed8; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        .status-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
        .dot-completed { background: #059669; }
        .dot-paid, .dot-processing { background: #2563eb; }
        .dot-pending { background: #d97706; animation: pulse 1.5s infinite; }
        .dot-cancelled { background: #dc2626; }

        @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:0.5;} }

        /* Order Body */
        .order-card-body { padding: 20px 24px; }

        .order-items-list { margin-bottom: 16px; }

        .order-item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(196,149,106,0.08);
        }
        .order-item-row:last-child { border-bottom: none; }
        .order-item-name { font-size: 13.5px; color: #1a1a1a; font-weight: 500; }
        .order-item-price { font-size: 13.5px; color: #6B4226; font-weight: 600; }

        .order-total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 20px;
            background: linear-gradient(135deg, #fdf5ec, #f5ede3);
            border-radius: 12px;
            border: 1px solid rgba(196,149,106,0.15);
        }
        .order-total-label { font-size: 14px; font-weight: 700; color: #2E1B0E; }
        .order-total-price {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px; font-weight: 700;
            color: #6B4226;
        }

        /* Pay Button */
        .btn-pay {
            display: block; width: 100%;
            margin-top: 14px; padding: 13px;
            text-align: center;
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: #fff;
            border-radius: 12px;
            font-weight: 700; font-size: 14px;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 14px rgba(217,119,6,0.3);
            transition: all 0.2s;
        }
        .btn-pay:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(217,119,6,0.4); }

        /* Empty State */
        .empty-orders {
            background: #fff; border-radius: 20px;
            padding: 80px 32px; text-align: center;
            border: 1.5px dashed rgba(196,149,106,0.25);
        }
        .empty-orders svg { color: #d4b89a; margin: 0 auto 16px; }
        .empty-orders h2 { font-family: 'Cormorant Garamond', serif; font-size: 26px; font-weight: 700; color: #6B4226; margin-bottom: 8px; }
        .empty-orders p { color: #a08060; font-size: 14.5px; }
        /* ══════════════════════════════════════════════
           RESPONSIVE STYLE
        ══════════════════════════════════════════════ */
        @media (max-width: 600px) {
            .page-title-row { margin-bottom: 20px; }
            .page-title { font-size: 22px; }
            
            .order-card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                padding: 14px 16px;
            }
            .order-card-body {
                padding: 16px;
            }
            .order-item-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
                padding: 8px 0;
            }
            .order-total-row {
                padding: 10px 14px;
            }
            .order-total-price {
                font-size: 18px;
            }
        }
    </style>

    <!-- Page Title -->
    <div class="page-title-row">
        <div class="page-title-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <div>
            <div class="page-title">Pesanan Saya</div>
            <div class="page-subtitle">Riwayat semua transaksi Anda</div>
        </div>
    </div>

    @if($orders->count() > 0)
        @foreach($orders as $index => $order)
            <div class="order-card">
                <!-- Header -->
                <div class="order-card-header">
                    <div class="order-num">
                        <div class="order-num-badge">{{ $index + 1 }}</div>
                        <div>
                            <div class="order-num-text">Pesanan #{{ $index + 1 }}</div>
                            <div class="order-date">📅 {{ $order->created_at->format('d F Y, H:i') }} WIB</div>
                        </div>
                    </div>

                    @if($order->status == 'completed')
                        <span class="status-badge status-completed">
                            <span class="status-dot dot-completed"></span> Selesai
                        </span>
                    @elseif($order->status == 'shipped')
                        <span class="status-badge" style="background:#e0f2fe; color:#0369a1;">
                            <span class="status-dot" style="background:#0284c7;"></span> Dikirim
                        </span>
                    @elseif($order->status == 'paid' || $order->status == 'processing')
                        <span class="status-badge status-paid">
                            <span class="status-dot dot-paid"></span> Sedang Dikemas
                        </span>
                    @elseif($order->status == 'pending')
                        <span class="status-badge status-pending">
                            <span class="status-dot dot-pending"></span> Menunggu Bayar
                        </span>
                    @elseif($order->status == 'cancelled')
                        <span class="status-badge status-cancelled">
                            <span class="status-dot dot-cancelled"></span> Dibatalkan
                        </span>
                    @else
                        <span class="status-badge status-cancelled">
                            <span class="status-dot dot-cancelled"></span> {{ ucfirst($order->status) }}
                        </span>
                    @endif
                </div>

                <!-- Body -->
                <div class="order-card-body">
                    <div class="order-items-list">
                        @foreach($order->orderItems as $item)
                            <div class="order-item-row">
                                <span class="order-item-name">📦 {{ $item->product->name }}</span>
                                <span class="order-item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="order-total-row">
                        <span class="order-total-label">Total Pembayaran</span>
                        <span class="order-total-price">Rp {{ number_format($order->gross_amount, 0, ',', '.') }}</span>
                    </div>

                    @if($order->status == 'pending')
                        <a href="{{ route('pembayaran.pending', ['order_id' => $order->order_id]) }}" class="btn-pay">
                            ⚡ Bayar Sekarang — Lihat Instruksi Pembayaran
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-orders">
            <svg style="width:80px;height:80px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h2>Belum Ada Pesanan</h2>
            <p>Yuk mulai belanja dan temukan tas favoritmu!</p>
        </div>
    @endif
</x-main-layout>
