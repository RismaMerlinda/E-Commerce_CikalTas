@extends('admin.layout')

@section('title', 'Kelola Produk')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Kelola Produk</h1>
        <p class="page-subtitle">Daftar semua produk yang tersedia di toko</p>
    </div>
    <div style="display:flex;gap:10px;">
        <a href="{{ route('admin.dashboard') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('admin.products.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="card" style="overflow:hidden;">
    @if ($products->count() > 0)
        <div style="overflow-x:auto;">
            <table class="admin-table">
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
                                <img src="{{ asset($product->image) }}"
                                     alt="{{ $product->name }}" class="product-thumb"
                                     onerror="this.src='{{ asset('gambar/Logo.png') }}'">
                            @else
                                <img src="{{ asset('gambar/Logo.png') }}" alt="No Image" class="product-thumb">
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:600;color:var(--espresso);">{{ $product->name }}</div>
                        </td>
                        <td style="color:var(--gray-soft);font-size:13px;">{{ $product->category ?? 'Tas' }}</td>
                        <td style="font-weight:600;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            <span style="background:var(--sand);padding:4px 10px;border-radius:100px;font-size:12px;font-weight:600;color:var(--espresso);">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            <div class="color-dots">
                                @if ($product->color)
                                    @php
                                        $colors = array_map('trim', explode(',', $product->color));
                                        $colorMap = [
                                            'hitam'=>'#000','black'=>'#000','putih'=>'#FFF','white'=>'#FFF',
                                            'abu'=>'#808080','gray'=>'#808080','grey'=>'#808080',
                                            'merah'=>'#e74c3c','red'=>'#e74c3c','biru'=>'#3498db','blue'=>'#3498db',
                                            'hijau'=>'#27ae60','green'=>'#27ae60','kuning'=>'#f1c40f','yellow'=>'#f1c40f',
                                            'coklat'=>'#8B4513','brown'=>'#8B4513','pink'=>'#FFC0CB',
                                            'ungu'=>'#9b59b6','purple'=>'#9b59b6','orange'=>'#FFA500',
                                            'navy'=>'#000080','maroon'=>'#800000',
                                        ];
                                    @endphp
                                    @foreach ($colors as $c)
                                        @php $hex = $colorMap[strtolower($c)] ?? '#CCCCCC'; @endphp
                                        <div class="color-dot" style="background-color:{{ $hex }};" title="{{ $c }}"></div>
                                    @endforeach
                                @else
                                    <span style="color:var(--gray-soft);font-size:12px;">-</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn-icon" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                      class="form-confirm" data-title="Hapus Produk?" data-text="Anda yakin ingin menghapus produk '{{ $product->name }}'? Data tidak dapat dikembalikan." style="display:inline;">
                                    @csrf @method('DELETE')
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
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <p>Belum ada produk. Klik "Tambah Produk" untuk menambahkan.</p>
        </div>
    @endif
</div>
@endsection
</body>
