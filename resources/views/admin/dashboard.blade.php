<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - CikalTas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: 'Nunito Sans', sans-serif;
            background-color: #D2BBA2;
            color: #202224;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            padding: 40px 20px;
            flex: 1;
        }

        .header {
            text-align: center;
            margin-bottom: 60px;
        }

        .header h1 {
            font-size: 42px;
            font-weight: 700;
            color: #664229;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 18px;
            color: #606060;
        }

        .logout-btn {
            position: absolute;
            top: 30px;
            right: 40px;
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

        .logout-btn:hover {
            background-color: #553621;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
            margin-top: 40px;
        }

        @media (min-width: 768px) {
            .menu-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .menu-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        .menu-card {
            background-color: white;
            border-radius: 16px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }

        .menu-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background-color: #664229;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: white;
        }

        .menu-card h3 {
            font-size: 24px;
            font-weight: 700;
            color: #664229;
            margin-bottom: 10px;
        }

        .menu-card p {
            font-size: 16px;
            color: #606060;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    @include('admin.partials.navbar')

    <div class="container">
        <div class="header">
            <h1>Dashboard Admin</h1>
            <p>Selamat datang, {{ auth()->user()->nama_lengkap }}</p>
        </div>

        <div class="menu-grid">
            <a href="{{ route('admin.products.index') }}" class="menu-card">
                <div class="menu-icon">📦</div>
                <h3>Kelola Produk</h3>
                <p>Tambah, edit, dan hapus produk yang tersedia di toko</p>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="menu-card">
                <div class="menu-icon">🛒</div>
                <h3>Kelola Pemesanan</h3>
                <p>Lihat dan kelola pesanan dari pelanggan</p>
            </a>

            <a href="{{ route('admin.sales-report') }}" class="menu-card">
                <div class="menu-icon">📊</div>
                <h3>Laporan Penjualan</h3>
                <p>Lihat statistik dan laporan penjualan toko</p>
            </a>
        </div>
    </div>

    @include('admin.partials.footer')
</body>

</html>
