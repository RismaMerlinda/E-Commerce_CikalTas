<x-main-layout>
    <x-slot name="title">Keranjang - CikalTas</x-slot>

    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6" style="color: #202224;">Keranjang Belanja</h1>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg" style="background: #d4edda; color: #155724;">
                {{ session('success') }}
            </div>
        @endif

        @if ($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach ($cartItems as $item)
                        <div class="bg-white rounded-2xl shadow-md p-6 flex gap-6">
                            <!-- Product Image -->
                            <div class="w-32 h-32 bg-gray-100 rounded-xl flex-shrink-0 overflow-hidden">
                                @if ($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}" class="w-full h-full object-contain p-2">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1">
                                <h3 class="text-lg font-bold mb-2" style="color: #202224;">{{ $item->product->name }}
                                </h3>
                                <p class="text-xl font-bold mb-4" style="color: #664229;">Rp
                                    {{ number_format($item->product->price, 0, ',', '.') }}</p>

                                <!-- Quantity Controls -->
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-semibold" style="color: #606060;">Jumlah:</span>
                                    <div class="flex items-center gap-2">
                                        <button onclick="updateQuantity({{ $item->id }}, -1)"
                                            class="w-8 h-8 rounded-lg border flex items-center justify-center hover:bg-gray-50 transition"
                                            style="border-color: #D5D5D5;">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <input type="number" value="{{ $item->quantity }}"
                                            id="quantity-{{ $item->id }}" min="1"
                                            class="w-16 text-center border rounded-lg py-1 font-semibold"
                                            style="border-color: #D5D5D5; color: #202224;" readonly>
                                        <button onclick="updateQuantity({{ $item->id }}, 1)"
                                            class="w-8 h-8 rounded-lg border flex items-center justify-center hover:bg-gray-50 transition"
                                            style="border-color: #D5D5D5;">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Remove Button -->
                            <button onclick="removeFromCart({{ $item->id }})"
                                class="self-start p-2 rounded-lg hover:bg-red-50 transition">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-md p-6 sticky top-6">
                        <h2 class="text-xl font-bold mb-6" style="color: #202224;">Ringkasan Pesanan</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span style="color: #606060;">Subtotal</span>
                                <span class="font-semibold" style="color: #202224;">Rp
                                    {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span style="color: #606060;">Ongkos Kirim</span>
                                <span class="font-semibold" style="color: #202224;">Gratis</span>
                            </div>
                            <div class="border-t pt-3" style="border-color: #E5E5E5;">
                                <div class="flex justify-between">
                                    <span class="font-bold" style="color: #202224;">Total</span>
                                    <span class="text-xl font-bold" style="color: #664229;">Rp
                                        {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('pembayaran') }}"
                            class="block w-full text-center text-white font-bold py-3.5 rounded-xl transition hover:opacity-90 shadow-md"
                            style="background: #664229;">
                            Lanjut ke Pembayaran
                        </a>

                        <button
                            onclick="if(confirm('Yakin ingin mengosongkan keranjang?')) window.location.href='{{ route('keranjang.clear') }}'"
                            class="block w-full text-center mt-3 font-semibold py-3 rounded-xl border transition hover:bg-gray-50"
                            style="color: #202224; border-color: #D5D5D5;">
                            Kosongkan Keranjang
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h2 class="text-2xl font-bold mb-2" style="color: #202224;">Keranjang Anda Kosong</h2>
                <p class="text-lg mb-6" style="color: #606060;">Yuk mulai belanja sekarang!</p>
                <a href="{{ route('beranda') }}"
                    class="inline-block px-8 py-3 text-white font-bold rounded-xl transition hover:opacity-90"
                    style="background: #664229;">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>

    <!-- JavaScript -->
    <script>
        function updateQuantity(cartId, change) {
            const input = document.getElementById(`quantity-${cartId}`);
            let newQuantity = parseInt(input.value) + change;

            if (newQuantity < 1) return;

            fetch(`/keranjang/${cartId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        quantity: newQuantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal mengupdate keranjang');
                });
        }

        function removeFromCart(cartId) {
            if (!confirm('Yakin ingin menghapus produk ini dari keranjang?')) return;

            fetch(`/keranjang/${cartId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menghapus produk');
                });
        }
    </script>
</x-main-layout>
