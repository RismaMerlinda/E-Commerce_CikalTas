@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Selamat datang kembali, {{ auth()->user()->nama_lengkap ?? 'Admin' }} 👋</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>
</div>

<!-- Stats Row -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-label">Total Pendapatan</div>
        <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="stat-sub">Dari pesanan yang lunas</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🛒</div>
        <div class="stat-label">Total Pesanan</div>
        <div class="stat-value">{{ $totalOrders }}</div>
        <div class="stat-sub">{{ $pendingOrders }} menunggu konfirmasi</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-label">Total Produk</div>
        <div class="stat-value">{{ $totalProducts }}</div>
        <div class="stat-sub">Produk aktif di toko</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">👤</div>
        <div class="stat-label">Total Pelanggan</div>
        <div class="stat-value">{{ $totalCustomers }}</div>
        <div class="stat-sub">{{ $completedOrders }} pesanan selesai</div>
    </div>
</div>

<!-- Two columns -->
<div class="two-col" style="gap:24px;">
    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header-row">
            <div class="card-title"><i class="fas fa-shopping-bag" style="color:var(--brown-light);font-size:18px;"></i> Pesanan Terbaru</div>
            <a href="{{ route('admin.orders.index') }}" class="btn-secondary" style="padding:7px 16px;font-size:12px;">Lihat Semua</a>
        </div>
        @if($recentOrders->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>
                            <div style="font-weight:600;font-size:13px;color:var(--espresso);">{{ $order->user->nama_lengkap ?? '-' }}</div>
                            <div style="font-size:11px;color:var(--gray-soft);">{{ $order->created_at->format('d M Y') }}</div>
                        </td>
                        <td style="font-weight:600;font-size:13px;">Rp {{ number_format($order->gross_amount, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $statusMap = [
                                    'pending'    => ['label' => 'Menunggu Pembayaran', 'class' => 'badge-pending', 'style' => ''],
                                    'paid'       => ['label' => 'Lunas',  'class' => '', 'style' => 'background:var(--brown);color:var(--white);'],
                                    'processing' => ['label' => 'Dikemas', 'class' => 'badge-processing', 'style' => ''],
                                    'shipped'    => ['label' => 'Dikirim', 'class' => '', 'style' => 'background:#17a2b8;color:white;'],
                                    'completed'  => ['label' => 'Selesai',  'class' => 'badge-completed', 'style' => ''],
                                    'cancelled'  => ['label' => 'Dibatalkan',  'class' => 'badge-failed', 'style' => ''],
                                ];
                                $s = $statusMap[$order->status] ?? ['label' => ucfirst($order->status), 'class' => 'badge-failed', 'style' => ''];
                            @endphp
                            <span class="badge {{ $s['class'] }}" style="{{ $s['style'] }}">{{ $s['label'] }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fas fa-shopping-bag"></i>
                <p>Belum ada pesanan</p>
            </div>
        @endif
    </div>

    <!-- Top Products -->
    <div class="card">
        <div class="card-header-row">
            <div class="card-title"><i class="fas fa-fire" style="color:var(--brown-light);font-size:18px;"></i> Produk Terlaris</div>
            <a href="{{ route('admin.products.index') }}" class="btn-secondary" style="padding:7px 16px;font-size:12px;">Lihat Semua</a>
        </div>
        @if($topProducts->count() > 0)
            <div style="display:flex;flex-direction:column;gap:12px;">
                @foreach($topProducts as $i => $item)
                <div style="display:flex;align-items:center;gap:14px;padding:10px 0;border-bottom:1px solid var(--sand);">
                    <div style="width:28px;height:28px;border-radius:50%;background:{{ $i === 0 ? 'linear-gradient(135deg,#d4a753,#c4956a)' : 'var(--sand)' }};display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:{{ $i === 0 ? 'white' : 'var(--brown)' }};flex-shrink:0;">
                        {{ $i + 1 }}
                    </div>
                    @if($item->product)
                        <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : asset('gambar/Logo.png') }}"
                             class="product-thumb" alt="{{ $item->product->name }}"
                             onerror="this.src='{{ asset('gambar/Logo.png') }}'">
                        <div style="flex:1;overflow:hidden;">
                            <div style="font-weight:600;font-size:13px;color:var(--espresso);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $item->product->name }}</div>
                            <div style="font-size:11px;color:var(--gray-soft);">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                        </div>
                        <div style="text-align:right;flex-shrink:0;">
                            <div style="font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:700;color:var(--espresso);">{{ $item->total_sold }}</div>
                            <div style="font-size:10px;color:var(--gray-soft);letter-spacing:0.5px;text-transform:uppercase;">terjual</div>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <p>Belum ada data penjualan</p>
            </div>
        @endif
    </div>
</div>


@endsection

