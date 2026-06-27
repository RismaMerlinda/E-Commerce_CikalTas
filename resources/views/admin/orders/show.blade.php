<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $order->order_id }} - CikalTas Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito Sans', sans-serif;
            background-color: #D2BBA2;
            color: #202224;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header {
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 36px;
            font-weight: 700;
            color: #664229;
            margin-bottom: 10px;
        }

        .btn {
            background-color: #664229;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Nunito Sans', sans-serif;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #553621;
        }

        .btn-back {
            background-color: #606060;
            margin-bottom: 20px;
        }

        .btn-back:hover {
            background-color: #404040;
        }

        .card {
            background-color: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card h2 {
            font-size: 24px;
            font-weight: 700;
            color: #664229;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 14px;
            color: #606060;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #202224;
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-paid {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .status-completed {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .status-failed {
            background-color: #f8d7da;
            color: #842029;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #842029;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .items-table th {
            background-color: #f5f5f5;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #664229;
            border-bottom: 2px solid #e0e0e0;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .total-row {
            background-color: #f5f5f5;
            font-weight: 700;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            .container { padding: 16px 14px; }
            .header h1 { font-size: 22px; }
            .action-buttons { flex-direction: column; }
            .action-buttons .btn { text-align: center; }
            .card { padding: 16px; }
            /* Make table scrollable on mobile */
            .items-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
            .items-table { min-width: 480px; }
        }
    </style>
</head>

<body>
    @include('admin.partials.navbar')
    <div class="container">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-back">← Kembali ke Daftar Pesanan</a>

        <div class="header">
            <h1>Detail Pesanan #{{ $order->order_id }}</h1>
        </div>

        <!-- Order Information -->
        <div class="card">
            <h2>Informasi Pesanan</h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Order ID</span>
                    <span class="info-value">{{ $order->order_id }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $order->status }}">
                            @if ($order->status == 'pending')
                                Menunggu Pembayaran
                            @elseif($order->status == 'paid')
                                Dibayar
                            @elseif($order->status == 'completed')
                                Selesai
                            @elseif($order->status == 'failed')
                                Gagal
                            @else
                                Dibatalkan
                            @endif
                        </span>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Pesanan</span>
                    <span class="info-value">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Total Pembayaran</span>
                    <span class="info-value" style="color: #664229;">Rp
                        {{ number_format($order->gross_amount, 0, ',', '.') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Metode Pembayaran</span>
                    <span class="info-value">{{ $order->payment_type ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Transaction ID</span>
                    <span class="info-value">{{ $order->transaction_id ?? '-' }}</span>
                </div>
                @if ($order->paid_at)
                    <div class="info-item">
                        <span class="info-label">Tanggal Dibayar</span>
                        <span class="info-value">{{ $order->paid_at->format('d M Y, H:i') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Customer Information -->
        <div class="card">
            <h2>Informasi Pelanggan</h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama</span>
                    <span class="info-value">{{ $order->user->nama_lengkap }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $order->user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nomor Telepon</span>
                    <span class="info-value">{{ $order->user->nomor_telepon ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Alamat</span>
                    <span class="info-value">
                        {{ $order->user->alamat_jalan ?? '-' }}<br>
                        {{ $order->user->provinsi_kota ?? '-' }}<br>
                        {{ $order->user->detail_lainnya ?? '' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card">
            <h2>Item Pesanan</h2>
            <div class="items-table-wrap">
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th style="text-align: center;">Jumlah</th>
                        <th style="text-align: right;">Harga Satuan</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td style="text-align: center;">{{ $item->quantity }}</td>
                            <td style="text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td style="text-align: right;">Rp
                                {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right; color: #664229;">Total</td>
                        <td style="text-align: right; color: #664229;">Rp
                            {{ number_format($order->gross_amount, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
            </div>{{-- .items-table-wrap --}}
        </div>

        <!-- Action Buttons -->
        @if ($order->status == 'pending')
            <div class="card">
                <h2>Tindakan</h2>
                <div class="action-buttons">
                    <form action="{{ route('admin.orders.mark-paid', $order) }}" method="POST"
                        onsubmit="return confirm('Tandai pesanan ini sebagai sudah dibayar?')">
                        @csrf
                        <button type="submit" class="btn">Tandai Lunas</button>
                    </form>
                </div>
            </div>
        @elseif($order->status == 'paid')
            <div class="card">
                <h2>Tindakan</h2>
                <div class="action-buttons">
                    <form action="{{ route('admin.orders.mark-completed', $order) }}" method="POST"
                        onsubmit="return confirm('Tandai pesanan ini sebagai selesai?')">
                        @csrf
                        <button type="submit" class="btn">Tandai Selesai</button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    @include('admin.partials.footer')
</body>

</html>
