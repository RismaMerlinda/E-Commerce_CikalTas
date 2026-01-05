<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - CikalTas Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            max-width: 1400px;
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
            margin-right: 10px;
        }

        .btn-back:hover {
            background-color: #404040;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-small {
            padding: 8px 16px;
            font-size: 14px;
        }

        .table-container {
            background-color: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #664229;
            color: white;
        }

        th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            font-size: 16px;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #e0e0e0;
        }

        tbody tr:hover {
            background-color: #f5f5f5;
        }

        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .color-dots {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .color-dot {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 2px solid #e0e0e0;
        }

        .btn-icon {
            background-color: transparent;
            border: 1px solid #e0e0e0;
            color: #606060;
            padding: 8px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
        }

        .btn-icon:hover {
            background-color: #f5f5f5;
            border-color: #664229;
            color: #664229;
        }

        .btn-icon-delete:hover {
            background-color: #fee;
            border-color: #dc3545;
            color: #dc3545;
        }

        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .no-products {
            text-align: center;
            padding: 40px;
            color: #606060;
            font-size: 18px;
        }
    </style>
</head>

<body>
    @include('admin.partials.navbar')
    <div class="container">
        <div class="header">
            <h1>Kelola Produk</h1>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-back">Kembali</a>
                <a href="{{ route('admin.products.create') }}" class="btn">+ Tambah Produk</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            @if ($products->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Warna</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="product-img"
                                            onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect fill=%22%23ddd%22 width=%22100%22 height=%22100%22/%3E%3Ctext fill=%22%23999%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22%3ENo Image%3C/text%3E%3C/svg%3E'">
                                    @else
                                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100'%3E%3Crect fill='%23ddd' width='100' height='100'/%3E%3Ctext fill='%23999' x='50%25' y='50%25' text-anchor='middle' dy='.3em'%3ENo Image%3C/text%3E%3C/svg%3E"
                                            alt="{{ $product->name }}" class="product-img">
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category ?? 'Tas' }}</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <div class="color-dots">
                                        @if ($product->color)
                                            @php
                                                // Parse multiple colors separated by comma
                                                $colors = array_map('trim', explode(',', $product->color));
                                                $colorMap = [
                                                    'hitam' => '#000000',
                                                    'black' => '#000000',
                                                    'putih' => '#FFFFFF',
                                                    'white' => '#FFFFFF',
                                                    'abu' => '#808080',
                                                    'gray' => '#808080',
                                                    'grey' => '#808080',
                                                    'merah' => '#FF0000',
                                                    'red' => '#FF0000',
                                                    'biru' => '#0000FF',
                                                    'blue' => '#0000FF',
                                                    'hijau' => '#008000',
                                                    'green' => '#008000',
                                                    'kuning' => '#FFD700',
                                                    'yellow' => '#FFD700',
                                                    'coklat' => '#8B4513',
                                                    'brown' => '#8B4513',
                                                    'pink' => '#FFC0CB',
                                                    'merah muda' => '#FFC0CB',
                                                    'ungu' => '#800080',
                                                    'purple' => '#800080',
                                                    'orange' => '#FFA500',
                                                    'oranye' => '#FFA500',
                                                    'navy' => '#000080',
                                                    'biru tua' => '#000080',
                                                    'maroon' => '#800000',
                                                    'merah tua' => '#800000',
                                                ];
                                            @endphp
                                            @foreach ($colors as $color)
                                                @php
                                                    $colorLower = strtolower($color);
                                                    $hexColor = $colorMap[$colorLower] ?? '#cccccc';
                                                @endphp
                                                <div class="color-dot" style="background-color: {{ $hexColor }};">
                                                </div>
                                            @endforeach
                                        @else
                                            <span style="color: #999;">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn-icon"
                                            title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                            style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon btn-icon-delete" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-products">
                    Belum ada produk. Klik "Tambah Produk" untuk menambahkan produk baru.
                </div>
            @endif
        </div>
    </div>

    @include('admin.partials.footer')
</body>
