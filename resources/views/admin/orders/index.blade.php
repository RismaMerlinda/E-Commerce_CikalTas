@extends('admin.layout')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Daftar Pesanan</h1>
        <p class="page-subtitle">Kelola dan pantau semua transaksi pemesanan pelanggan</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="orders-container" style="display:grid;gap:20px;">
    @if ($orders->count() > 0)
        @foreach ($orders as $index => $order)
            <div class="card" style="padding:24px;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:16px;">
                    <div style="flex: 1; min-width: 250px;">
                        <div style="font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:700;color:var(--espresso);margin-bottom:6px;">
                            Pesanan #{{ $index + 1 }}
                        </div>
                        <div style="font-size:13px;color:var(--gray-soft);margin-bottom:16px;">
                            Dibuat pada: {{ $order->created_at->format('d M Y, H:i') }}
                        </div>

                        <div style="margin:16px 0;padding:12px;background:var(--cream);border-radius:10px;">
                            <div style="font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:var(--brown);margin-bottom:8px;">
                                Items:
                            </div>
                            @foreach ($order->orderItems as $item)
                                <div style="font-size:14px;color:var(--charcoal);padding:4px 0;display:flex;justify-content:space-between;">
                                    <span>• {{ $item->product->name ?? 'Produk Tidak Ditemukan' }}</span>
                                    <span style="font-weight:600;">{{ $item->quantity }}x</span>
                                </div>
                            @endforeach
                        </div>

                        <div style="font-size:16px;color:var(--espresso);font-weight:600;margin-top:12px;">
                            Total: <span style="font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:700;color:var(--brown-dark);">Rp {{ number_format($order->gross_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div style="text-align: right; min-width: 150px; display:flex; flex-direction:column; align-items:flex-end; gap:12px;">
                        @if ($order->status == 'pending')
                            <span class="badge badge-pending">Menunggu Pembayaran</span>
                        @elseif($order->status == 'paid')
                            <span class="badge" style="background:var(--brown);color:var(--white);">Lunas</span>
                        @elseif($order->status == 'processing')
                            <span class="badge badge-processing">Sedang Dikemas</span>
                        @elseif($order->status == 'shipped')
                            <span class="badge" style="background:#17a2b8;color:white;">Dikirim</span>
                        @elseif($order->status == 'completed')
                            <span class="badge badge-completed">Selesai</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge badge-failed">Dibatalkan</span>
                        @else
                            <span class="badge badge-failed">{{ ucfirst($order->status) }}</span>
                        @endif

                        <div class="action-buttons" style="margin-top: 8px; width:100%;">
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" style="display:flex; gap:8px; justify-content:flex-end;">
                                @csrf
                                <select name="status" style="padding:6px 12px; border:1px solid var(--sand); border-radius:6px; font-family:'Nunito Sans',sans-serif; font-size:13px; outline:none;">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                    <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Lunas</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Dikemas</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                <button type="submit" class="btn-primary" style="padding:6px 12px; font-size:12px; min-width:unset;">
                                    Update
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state card">
            <i class="fas fa-shopping-bag"></i>
            <p>Belum ada pesanan masuk.</p>
        </div>
    @endif
</div>
@endsection
