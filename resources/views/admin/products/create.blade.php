<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - CikalTas Admin</title>
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
            font-family: 'Nunito Sans', sans-serif;
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
            <h1>Tambah Produk Baru</h1>
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
            <form id="productCreateForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="form-group">
                    <label for="name">Nama Produk *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        placeholder="Contoh: Tas Selempang Cowok Kekinian">
                </div>

                <div class="form-group">
                    <label for="category">Kategori *</label>
                    <select id="category" name="category" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Tas Selempang" {{ old('category') == 'Tas Selempang' ? 'selected' : '' }}>Tas
                            Selempang</option>
                        <option value="Tas Tangan" {{ old('category') == 'Tas Tangan' ? 'selected' : '' }}>Tas Tangan
                        </option>
                        <option value="Tas Ransel" {{ old('category') == 'Tas Ransel' ? 'selected' : '' }}>Tas Ransel
                        </option>
                        <option value="Tas Koper" {{ old('category') == 'Tas Koper' ? 'selected' : '' }}>Tas Koper
                        </option>
                        <option value="Dompet" {{ old('category') == 'Dompet' ? 'selected' : '' }}>Dompet</option>
                        <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="color">Warna (pisahkan dengan koma untuk multiple warna) *</label>
                    <input type="text" id="color" name="color" value="{{ old('color') }}"
                        placeholder="Contoh: hitam, coklat, biru" required>
                    <small>Contoh: hitam, coklat, biru tua, merah muda</small>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi *</label>
                    <textarea id="description" name="description" required placeholder="Deskripsikan produk Anda...">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="price">Harga (Rp) *</label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" min="0"
                        required placeholder="Contoh: 99000">
                </div>

                <div class="form-group">
                    <label for="stock">Stok *</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock') }}" min="0"
                        required placeholder="Contoh: 50">
                </div>

                <div class="form-group">
                    <label for="image">Gambar Produk *</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                    <small>Format: JPG, JPEG, PNG, GIF. Max: 2MB</small>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn">Simpan Produk</button>
                </div>
            </form>

            <div id="clientErrorBox" class="alert alert-danger" style="display:none; margin-top:20px;"></div>
        </div>
    </div>

    <script>
        const productCreateForm = document.getElementById('productCreateForm');
        const clientErrorBox = document.getElementById('clientErrorBox');

        productCreateForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const errors = [];

            const name = document.getElementById('name').value.trim();
            const category = document.getElementById('category').value.trim();
            const color = document.getElementById('color').value.trim();
            const description = document.getElementById('description').value.trim();
            const price = document.getElementById('price').value.trim();
            const stock = document.getElementById('stock').value.trim();
            const imageInput = document.getElementById('image');

            if (name === '') errors.push('Nama Produk wajib diisi.');
            if (category === '') errors.push('Kategori wajib dipilih.');
            if (color === '') errors.push('Warna wajib diisi.');
            if (description === '') errors.push('Deskripsi wajib diisi.');
            if (price === '') errors.push('Harga wajib diisi.');
            if (stock === '') errors.push('Stok wajib diisi.');
            if (!imageInput.files || imageInput.files.length === 0) errors.push('Gambar Produk wajib diunggah.');

            if (errors.length > 0) {
                clientErrorBox.innerHTML = '<strong>Terjadi kesalahan:</strong><ul>' + errors.map(err => '<li>' + err + '</li>').join('') + '</ul>';
                clientErrorBox.style.display = 'block';
                clientErrorBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                return;
            }

            clientErrorBox.style.display = 'none';
            productCreateForm.submit();
        });
    </script>

    @include('admin.partials.footer')
</body>

</html>
