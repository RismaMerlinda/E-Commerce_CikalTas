@extends('admin.layout')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Produk</h1>
        <p class="page-subtitle">Tambahkan produk baru ke dalam katalog toko</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@if ($errors->any())
    <div class="alert-danger" style="margin-bottom: 20px;">
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin-top: 8px; margin-bottom: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card" style="max-width: 800px;">
    <form id="productCreateForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" novalidate style="display:flex; flex-direction:column; gap:20px;">
        @csrf

        <div class="form-group">
            <label for="name" style="font-weight:600; color:var(--espresso); margin-bottom:8px; display:block;">Nama Produk *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   placeholder="Contoh: Tas Selempang Cowok Kekinian"
                   style="width:100%; padding:12px 16px; border:2px solid var(--sand); border-radius:10px; outline:none; transition:border-color 0.3s; font-family:'Nunito Sans',sans-serif;">
        </div>

        <div class="form-group">
            <label for="category" style="font-weight:600; color:var(--espresso); margin-bottom:8px; display:block;">Kategori *</label>
            <select id="category" name="category" required style="width:100%; padding:12px 16px; border:2px solid var(--sand); border-radius:10px; outline:none; transition:border-color 0.3s; font-family:'Nunito Sans',sans-serif; background:var(--white);">
                <option value="">Pilih Kategori</option>
                <option value="Tas Selempang" {{ old('category') == 'Tas Selempang' ? 'selected' : '' }}>Tas Selempang</option>
                <option value="Tas Tangan" {{ old('category') == 'Tas Tangan' ? 'selected' : '' }}>Tas Tangan</option>
                <option value="Tas Ransel" {{ old('category') == 'Tas Ransel' ? 'selected' : '' }}>Tas Ransel</option>
                <option value="Tas Koper" {{ old('category') == 'Tas Koper' ? 'selected' : '' }}>Tas Koper</option>
                <option value="Dompet" {{ old('category') == 'Dompet' ? 'selected' : '' }}>Dompet</option>
                <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>

        <div class="form-group">
            <label for="color" style="font-weight:600; color:var(--espresso); margin-bottom:8px; display:block;">Warna (pisahkan dengan koma) *</label>
            <input type="text" id="color" name="color" value="{{ old('color') }}"
                   placeholder="Contoh: hitam, coklat, biru" required
                   style="width:100%; padding:12px 16px; border:2px solid var(--sand); border-radius:10px; outline:none; transition:border-color 0.3s; font-family:'Nunito Sans',sans-serif;">
            <small style="color:var(--gray-soft); margin-top:6px; display:block;">Contoh: hitam, coklat, biru tua, merah muda</small>
        </div>

        <div class="form-group">
            <label for="description" style="font-weight:600; color:var(--espresso); margin-bottom:8px; display:block;">Deskripsi *</label>
            <textarea id="description" name="description" required placeholder="Deskripsikan produk Anda..."
                      style="width:100%; padding:12px 16px; border:2px solid var(--sand); border-radius:10px; outline:none; transition:border-color 0.3s; font-family:'Nunito Sans',sans-serif; min-height:120px; resize:vertical;">{{ old('description') }}</textarea>
        </div>

        <div style="display:flex; gap:20px; flex-wrap:wrap;">
            <div class="form-group" style="flex:1;">
                <label for="price" style="font-weight:600; color:var(--espresso); margin-bottom:8px; display:block;">Harga (Rp) *</label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" min="0"
                       required placeholder="Contoh: 99000"
                       style="width:100%; padding:12px 16px; border:2px solid var(--sand); border-radius:10px; outline:none; transition:border-color 0.3s; font-family:'Nunito Sans',sans-serif;">
            </div>
            <div class="form-group" style="flex:1;">
                <label for="stock" style="font-weight:600; color:var(--espresso); margin-bottom:8px; display:block;">Stok *</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock') }}" min="0"
                       required placeholder="Contoh: 50"
                       style="width:100%; padding:12px 16px; border:2px solid var(--sand); border-radius:10px; outline:none; transition:border-color 0.3s; font-family:'Nunito Sans',sans-serif;">
            </div>
        </div>

        <div class="form-group">
            <label for="image" style="font-weight:600; color:var(--espresso); margin-bottom:8px; display:block;">Gambar Produk *</label>
            <div style="border: 2px dashed var(--sand); padding: 20px; border-radius: 10px; text-align: center; background: var(--cream);">
                <input type="file" id="image" name="image" accept="image/*" required style="width:100%; font-family:'Nunito Sans',sans-serif;">
            </div>
            <small style="color:var(--gray-soft); margin-top:6px; display:block;">Format: JPG, JPEG, PNG, GIF. Max: 2MB</small>
        </div>

        <div class="form-actions" style="margin-top:20px; display:flex; justify-content:flex-end; gap:12px; padding-top:20px; border-top:1px solid var(--sand);">
            <a href="{{ route('admin.products.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">Simpan Produk</button>
        </div>
    </form>

    <div id="clientErrorBox" class="alert-danger" style="display:none; margin-top:20px;"></div>
</div>

@push('scripts')
<script>
    const productCreateForm = document.getElementById('productCreateForm');
    const clientErrorBox = document.getElementById('clientErrorBox');

    // Add focus effects
    document.querySelectorAll('input, select, textarea').forEach(el => {
        el.addEventListener('focus', () => el.style.borderColor = 'var(--brown)');
        el.addEventListener('blur', () => el.style.borderColor = 'var(--sand)');
    });

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
        if (price === '' || isNaN(price) || Number(price) < 0) errors.push('Harga harus berupa angka valid dan minimal 0.');
        if (stock === '' || isNaN(stock) || Number(stock) < 0) errors.push('Stok harus berupa angka valid dan minimal 0.');
        
        if (imageInput.files.length === 0) {
            errors.push('Gambar produk wajib diunggah.');
        } else {
            const file = imageInput.files[0];
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                errors.push('Format gambar harus JPG, JPEG, PNG, atau GIF.');
            }
            if (file.size > 2 * 1024 * 1024) {
                errors.push('Ukuran gambar maksimal 2MB.');
            }
        }

        if (errors.length > 0) {
            clientErrorBox.innerHTML = `<strong>Periksa kembali form Anda:</strong><ul style="margin-top: 8px; margin-bottom: 0; padding-left: 20px;">${errors.map(err => `<li>${err}</li>`).join('')}</ul>`;
            clientErrorBox.style.display = 'block';
            
            // Scroll to error
            clientErrorBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            clientErrorBox.style.display = 'none';
            // Disable button to prevent double submit
            const submitBtn = productCreateForm.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.7';
            
            productCreateForm.submit();
        }
    });
</script>
@endpush
@endsection
