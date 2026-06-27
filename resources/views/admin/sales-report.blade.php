@extends('admin.layout')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Laporan Penjualan</h1>
        <p class="page-subtitle">Rangkuman transaksi penjualan dan pendapatan toko</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Stats Row -->
<div class="stats-row">
    <div class="stat-card" style="grid-column: span 2;">
        <div class="stat-icon">💰</div>
        <div class="stat-label">Total Pemasukan</div>
        <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="stat-sub">Semua pemasukan dari transaksi yang sukses lunas</div>
    </div>
    <div class="stat-card" style="grid-column: span 2;">
        <div class="stat-icon">📈</div>
        <div class="stat-label">Total Transaksi</div>
        <div class="stat-value">{{ $totalTransactions }}</div>
        <div class="stat-sub">Jumlah pesanan yang sudah dibayar/selesai</div>
    </div>
</div>

<!-- Detailed Orders Section -->
<div class="card">
    <div class="card-header-row">
        <div class="card-title">
            <i class="fas fa-list-alt" style="color:var(--brown-light);font-size:18px;"></i> Rincian Transaksi
        </div>
    </div>

    @if ($orders->count() > 0)
        <div style="display:grid;gap:20px;">
            @foreach ($orders as $index => $order)
                <div style="padding:20px;background:var(--cream);border-radius:16px;border:1px solid rgba(196,149,106,0.12);">
                    <div style="display:flex;justify-content:space-between;align-items:center;padding-bottom:12px;border-bottom:1px solid var(--sand);flex-wrap:wrap;gap:10px;">
                        <div>
                            <div style="font-weight:700;color:var(--espresso);font-size:15px;">Pesanan #{{ $index + 1 }}</div>
                            <div style="font-size:12px;color:var(--gray-soft);">Pelanggan: <span style="font-weight:600;color:var(--espresso);">{{ $order->user->nama_lengkap }}</span></div>
                        </div>
                        @if ($order->status == 'paid')
                            <span class="badge badge-paid">Sudah Dibayar</span>
                        @elseif($order->status == 'processing')
                            <span class="badge badge-processing">Sedang Diproses</span>
                        @elseif($order->status == 'completed')
                            <span class="badge badge-completed">Selesai</span>
                        @endif
                    </div>

                    <div style="margin:12px 0;">
                        @foreach ($order->orderItems as $item)
                            <div style="display:flex;justify-content:space-between;font-size:13px;padding:6px 0;color:var(--charcoal);">
                                <span>• {{ $item->product->name ?? 'Produk dihapus' }} ({{ $item->quantity }}x)</span>
                                <span style="font-weight:600;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div style="display:flex;justify-content:space-between;padding-top:12px;border-top:1.5px solid var(--sand);font-weight:700;color:var(--espresso);font-size:15px;">
                        <span>Total Nilai Transaksi</span>
                        <span style="font-family:'Cormorant Garamond',serif;font-size:18px;color:var(--brown-dark);">Rp {{ number_format($order->gross_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-file-invoice-dollar"></i>
            <p>Belum ada transaksi lunas/sukses.</p>
        </div>
    @endif
</div>
@endsection

