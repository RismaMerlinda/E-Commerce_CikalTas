<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - CikalTas Admin</title>
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 36px;
            font-weight: 700;
            color: #664229;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-icon {
            width: 40px;
            height: 40px;
            background-color: #664229;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .btn {
            background-color: #664229;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
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
        }

        .btn-back:hover {
            background-color: #404040;
        }

        .stats-container {
            background-color: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 18px;
            color: #606060;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .stat-card p {
            font-size: 36px;
            font-weight: 700;
            color: #664229;
        }

        .orders-section {
            margin-top: 40px;
        }

        .orders-section h2 {
            font-size: 24px;
            font-weight: 700;
            color: #664229;
            margin-bottom: 20px;
        }

        .order-card {
            background-color: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e0e0e0;
        }

        .order-title {
            font-size: 18px;
            font-weight: 700;
            color: #664229;
        }

        .order-customer {
            font-size: 14px;
            color: #606060;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 16px;
            font-weight: 600;
            font-size: 14px;
        }

        .status-paid {
            background-color: #cfe2ff;
            color: #084298;
        }

        .status-processing {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .order-items {
            margin-top: 16px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-name {
            color: #202224;
            font-weight: 500;
        }

        .item-price {
            color: #606060;
        }

        .order-total {
            display: flex;
            justify-content: space-between;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 2px solid #e0e0e0;
            font-weight: 700;
            font-size: 18px;
            color: #664229;
        }

        .no-orders {
            text-align: center;
            padding: 60px 20px;
            background-color: white;
            border-radius: 12px;
            color: #606060;
            font-size: 18px;
        }
    </style>
</head>

<body>
    @include('admin.partials.navbar')
    <div class="container">
        <div class="header">
            <h1>
                <div class="header-icon">📊</div>
                Laporan Penjualan
            </h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-back">Kembali</a>
        </div>

        <div class="stats-container">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Pemasukan</h3>
                    <p>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="stat-card">
                    <h3>Total Transaksi</h3>
                    <p>{{ $totalTransactions }}</p>
                </div>
            </div>
        </div>

        <div class="orders-section">
            @if ($orders->count() > 0)
                @foreach ($orders as $index => $order)
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <div class="order-title">Pesanan {{ $index + 1 }}</div>
                                <div class="order-customer">Pelanggan: {{ $order->user->nama_lengkap }}</div>
                            </div>
                            @if ($order->status == 'paid')
                                <span class="status-badge status-paid">Sudah Dibayar</span>
                            @elseif($order->status == 'processing')
                                <span class="status-badge status-processing">Sedang Diproses</span>
                            @elseif($order->status == 'completed')
                                <span class="status-badge status-completed">Selesai</span>
                            @endif
                        </div>

                        <div class="order-items">
                            @foreach ($order->orderItems as $item)
                                <div class="order-item">
                                    <span class="item-name">{{ $item->product->name }}</span>
                                    <span class="item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="order-total">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->gross_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no-orders">
                    Belum ada transaksi yang selesai.
                </div>
            @endif
        </div>
    </div>

    @include('admin.partials.footer')
</body>

</html>
