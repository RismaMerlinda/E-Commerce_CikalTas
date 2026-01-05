<x-main-layout>
    <x-slot name="title">Beranda - CikalTas</x-slot>

    <!-- Hero Section -->
    <div class="rounded-2xl p-12 mb-8 shadow-lg" style="background: linear-gradient(135deg, #8B6F47 0%, #664229 100%);">
        <h1 class="text-4xl font-bold text-white mb-4">Selamat Datang di CikalTas!</h1>
        <p class="text-lg text-white opacity-90 max-w-2xl">
            Temukan koleksi tas pilihan dengan desain stylish, bahan premium, dan kenyamanan maksimal untuk setiap
            aktivitasmu!
        </p>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="aspect-square bg-gray-100 flex items-center justify-center p-6">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-full object-contain">
                    @else
                        <div class="w-full h-full rounded-lg flex items-center justify-center"
                            style="background: linear-gradient(135deg, #ECECEE 0%, #D8D8D8 100%);">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="p-6">
                    <h3 class="text-lg font-bold mb-2" style="color: #202224;">{{ $product->name }}</h3>
                    <p class="text-sm mb-4 line-clamp-2" style="color: #606060;">{{ $product->description }}</p>

                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xl font-bold" style="color: #202224;">Rp
                            {{ number_format($product->price, 0, ',', '.') }}</span>
                        <button onclick="showProductDetail({{ $product->id }})"
                            class="text-sm font-semibold underline hover:opacity-80 transition" style="color: #664229;">
                            Lihat Detail
                        </button>
                    </div>

                    <div class="flex gap-3">
                        <button onclick="buyNow({{ $product->id }})"
                            class="flex-1 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-200 hover:opacity-90"
                            style="background: #664229;">
                            Beli Sekarang
                        </button>
                        <button onclick="addToCart({{ $product->id }})"
                            class="flex-1 bg-white font-semibold py-2.5 px-4 rounded-lg border transition duration-200 hover:bg-gray-50"
                            style="color: #202224; border-color: #D5D5D5;">
                            + Keranjang
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <p class="text-gray-500 text-lg">Belum ada produk tersedia</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($products->hasPages())
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif

    <!-- Modal Detail Produk -->
    <div id="productModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl relative">
            <!-- Close Button -->
            <button onclick="closeModal()"
                class="absolute -top-3 -right-3 w-10 h-10 rounded-full bg-white shadow-lg hover:bg-gray-100 flex items-center justify-center transition z-10">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Content -->
            <div class="p-8">
                <!-- Product Title -->
                <h2 id="modalTitle" class="text-2xl font-bold mb-6 text-center" style="color: #202224;">Tas Tangan
                    Elegan MaiZura</h2>

                <!-- Product Image -->
                <div class="bg-gray-100 rounded-xl mb-6 overflow-hidden flex items-center justify-center"
                    style="height: 280px;">
                    <img id="modalImage" src="" alt="Product" class="max-w-full max-h-full object-contain p-6">
                </div>

                <!-- Product Description -->
                <p id="modalDescription" class="text-base text-center leading-relaxed px-4" style="color: #202224;">
                    Tas Tangan Elegan MaiZura hadir dengan desain minimalis berwarna coklat taupe yang netral, terbuat
                    dari kulit sintetis premium dengan detail gold hardware yang mewah. Ukurannya pas untuk menyimpan
                    dompet, ponsel, dan perlengkapan kecil, cocok digunakan untuk acara formal maupun kasual.
                </p>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- JavaScript -->
    <script>
        function showProductDetail(productId) {
            fetch(`/produk/${productId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const product = data.product;

                        // Update modal content
                        document.getElementById('modalTitle').textContent = product.name;
                        document.getElementById('modalDescription').textContent = product.description;

                        // Update image
                        const modalImage = document.getElementById('modalImage');
                        if (product.image) {
                            modalImage.src = `/storage/${product.image}`;
                        } else {
                            modalImage.src =
                                'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"><rect fill="%23ECECEE" width="200" height="200"/><text x="50%" y="50%" text-anchor="middle" fill="%23666" font-size="16">No Image</text></svg>';
                        }

                        // Show modal
                        document.getElementById('productModal').classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat detail produk');
                });
        }

        function closeModal() {
            document.getElementById('productModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Add to Cart Function
        function addToCart(productId) {
            fetch('/keranjang/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        alert(data.message);
                        // Optionally update cart count badge
                        updateCartCount();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menambahkan produk ke keranjang');
                });
        }

        // Buy Now Function
        function buyNow(productId) {
            // Add to cart first, then redirect to cart
            fetch('/keranjang/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redirect to cart page
                        window.location.href = '/keranjang';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menambahkan produk');
                });
        }

        // Update Cart Count Badge (optional)
        function updateCartCount() {
            fetch('/keranjang/count', {
                    headers: {
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update cart count in UI if you have a badge
                    console.log('Cart count:', data.count);
                });
        }

        // Close modal when clicking outside
        document.getElementById('productModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</x-main-layout>
