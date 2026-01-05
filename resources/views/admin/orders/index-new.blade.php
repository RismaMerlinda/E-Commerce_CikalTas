<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan - CikalTas Admin</title>
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

        .btn-small {
            padding: 10px 20px;
            font-size: 14px;
        }

        .orders-container {
            display: grid;
            gap: 20px;
        }

        .order-card {
            background-color: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .order-title {
            font-size: 20px;
            font-weight: 700;
            color: #664229;
            margin-bottom: 8px;
        }

        .order-date {
            font-size: 14px;
            color: #606060;
            margin-bottom: 16px;
        }

        .order-items {
            margin: 16px 0;
        }

        .order-item {
            color: #202224;
            padding: 8px 0;
        }

        .order-total {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 2px solid #e0e0e0;
            font-weight: 700;
            font-size: 16px;
            color: #664229;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .status-processing {
            background-color: #cfe2ff;
            color: #084298;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-failed {
            background-color: #f8d7da;
            color: #842029;
        }

        .no-orders {
            text-align: center;
            padding: 60px 20px;
            background-color: white;
            border-radius: 12px;
            color: #606060;
            font-size: 18px;
        }

        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }
    </style>
</head>

<body>
    @include('admin.partials.navbar')
    <div class="container">
        <div class="header">
            <h1>
                Daftar Pesanan
            </h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-back">Kembali</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="orders-container">
            @if ($orders->count() > 0)
                @foreach ($orders as $index => $order)
                    <div class="order-card">
                        <div class="order-header">
                            <div style="flex: 1;">
                                <div class="order-title">Pesanan #{{ $index + 1 }}</div>
                                <div class="order-date">Dibuat pada: {{ $order->created_at->format('d M Y, H:i') }}
                                </div>

                                <div class="order-items">
                                    @foreach ($order->orderItems as $item)
                                        <div class="order-item">{{ $item->product->name }}</div>
                                    @endforeach
                                </div>

                                <div class="order-total">
                                    <strong>Total:</strong> Rp {{ number_format($order->gross_amount, 0, ',', '.') }}
                                </div>
                            </div>

                            <div style="text-align: right;">
                                @if ($order->status == 'pending')
                                    <span class="status-badge status-pending">Menunggu Pembayaran</span>
                                @elseif($order->status == 'paid' || $order->status == 'processing')
                                    <span class="status-badge status-processing">Sedang Dikemas</span>
                                    <br><br>
                                    <form action="{{ route('admin.orders.complete', $order) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-small"
                                            onclick="return confirm('Tandai pesanan ini sebagai selesai?')">Tandai
                                            Selesai</button>
                                    </form>
                                @else
                                    <span class="status-badge status-failed">Gagal</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no-orders">
                    Belum ada pesanan.
                </div>
            @endif
        </div>
    </div>

    @include('admin.partials.footer')
</body>

</html>
