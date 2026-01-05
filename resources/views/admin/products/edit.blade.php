<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - CikalTas Admin</title>
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
            max-width: 800px;
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
            margin-bottom: 20px;
        }

        .btn-back:hover {
            background-color: #404040;
        }

        .form-container {
            background-color: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #202224;
            font-size: 16px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            font-family: 'Nunito Sans', sans-serif;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #664229;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-group small {
            display: block;
            margin-top: 6px;
            color: #606060;
            font-size: 14px;
        }

        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert ul {
            margin-left: 20px;
        }

        .current-image {
            margin-top: 10px;
            border-radius: 8px;
            overflow: hidden;
            max-width: 300px;
        }

        .current-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn-cancel {
            background-color: #e0e0e0;
            color: #202224;
        }

        .btn-cancel:hover {
            background-color: #d0d0d0;
        }
    </style>
</head>

<body>
    @include('admin.partials.navbar')
    <div class="container">
        <a href="{{ route('admin.products.index') }}" class="btn btn-back">← Kembali</a>

        <div class="header">
            <h1>Edit Produk</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-container">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nama Produk *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="category">Kategori *</label>
                    <select id="category" name="category" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Tas Selempang"
                            {{ old('category', $product->category) == 'Tas Selempang' ? 'selected' : '' }}>Tas
                            Selempang</option>
                        <option value="Tas Tangan"
                            {{ old('category', $product->category) == 'Tas Tangan' ? 'selected' : '' }}>Tas
                            Tangan</option>
                        <option value="Tas Ransel"
                            {{ old('category', $product->category) == 'Tas Ransel' ? 'selected' : '' }}>Tas
                            Ransel</option>
                        <option value="Tas Koper"
                            {{ old('category', $product->category) == 'Tas Koper' ? 'selected' : '' }}>Tas
                            Koper</option>
                        <option value="Dompet" {{ old('category', $product->category) == 'Dompet' ? 'selected' : '' }}>
                            Dompet
                        </option>
                        <option value="Lainnya"
                            {{ old('category', $product->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="color">Warna (pisahkan dengan koma untuk multiple warna) *</label>
                    <input type="text" id="color" name="color" value="{{ old('color', $product->color) }}"
                        placeholder="Contoh: hitam, coklat, biru">
                    <small>Contoh: hitam, coklat, biru tua, merah</small>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi *</label>
                    <textarea id="description" name="description" required>{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="price">Harga (Rp) *</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}"
                        min="0" required>
                </div>

                <div class="form-group">
                    <label for="stock">Stok *</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}"
                        min="0" required>
                </div>

                <div class="form-group">
                    <label for="image">Gambar Produk</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <small>Kosongkan jika tidak ingin mengubah gambar. Format: JPG, JPEG, PNG, GIF. Max: 2MB</small>

                    @if ($product->image)
                        <div class="current-image">
                            <p style="margin: 10px 0; font-weight: 600; color: #606060;">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22300%22 height=%22300%22%3E%3Crect fill=%22%23ddd%22 width=%22300%22 height=%22300%22/%3E%3Ctext fill=%22%23999%22 x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 font-size=%2224%22%3ENo Image%3C/text%3E%3C/svg%3E'">
                        </div>
                    @endif
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.partials.footer')
</body>

</html>
