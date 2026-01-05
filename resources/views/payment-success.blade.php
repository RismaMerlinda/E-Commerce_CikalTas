<x-main-layout>
    <div class="max-w-2xl mx-auto text-center py-12">
        <!-- Success Icon -->
        <div class="mb-8">
            <div class="w-24 h-24 mx-auto rounded-full flex items-center justify-center"
                style="background-color: #d1f2eb;">
                <svg class="w-12 h-12" style="color: #0f5132;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-4xl font-bold mb-4" style="color: #664229;">Pembayaran Berhasil!</h1>

        <!-- Message -->
        <p class="text-lg mb-8" style="color: #606060;">
            Terima kasih atas pembelian Anda. Pesanan Anda sedang diproses.
        </p>

        @if (isset($order))
            <!-- Order Details Card -->
            <div class="bg-white rounded-2xl shadow-md p-8 mb-8 text-left">
                <h2 class="text-xl font-bold mb-4" style="color: #664229;">Detail Pesanan</h2>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span style="color: #606060;">Order ID:</span>
                        <span class="font-semibold" style="color: #202224;">{{ $order->order_id }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span style="color: #606060;">Total Pembayaran:</span>
                        <span class="font-semibold" style="color: #664229;">
                            Rp {{ number_format($order->gross_amount, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span style="color: #606060;">Metode Pembayaran:</span>
                        <span class="font-semibold"
                            style="color: #202224;">{{ $order->payment_type ?? 'Midtrans' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span style="color: #606060;">Status:</span>
                        <span class="font-semibold" style="color: #0f5132;">Dibayar</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('pesanan') }}"
                class="px-8 py-3 rounded-xl text-white font-semibold transition-all duration-300"
                style="background-color: #664229;" onmouseover="this.style.backgroundColor='#553621'"
                onmouseout="this.style.backgroundColor='#664229'">
                Lihat Pesanan Saya
            </a>

            <a href="{{ route('beranda') }}" class="px-8 py-3 rounded-xl font-semibold transition-all duration-300"
                style="background-color: white; color: #664229; border: 2px solid #664229;"
                onmouseover="this.style.backgroundColor='#f5f5f5'" onmouseout="this.style.backgroundColor='white'">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</x-main-layout>
