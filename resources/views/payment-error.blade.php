<x-main-layout>
    <div class="max-w-2xl mx-auto text-center py-12">
        <!-- Error Icon -->
        <div class="mb-8">
            <div class="w-24 h-24 mx-auto rounded-full flex items-center justify-center"
                style="background-color: #f8d7da;">
                <svg class="w-12 h-12" style="color: #842029;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-4xl font-bold mb-4" style="color: #664229;">Pembayaran Gagal</h1>

        <!-- Message -->
        <p class="text-lg mb-8" style="color: #606060;">
            Maaf, terjadi kesalahan saat memproses pembayaran Anda.
        </p>

        <!-- Error Details Card -->
        <div class="bg-white rounded-2xl shadow-md p-8 mb-8 text-left">
            <h2 class="text-xl font-bold mb-4" style="color: #664229;">Detail</h2>

            <div class="p-4 rounded-xl mb-4" style="background-color: #f8d7da;">
                <p class="text-sm" style="color: #842029;">
                    <strong>Error:</strong> Transaksi pembayaran tidak dapat diselesaikan. Silakan coba lagi atau
                    hubungi customer service jika masalah berlanjut.
                </p>
            </div>

            @if (isset($order))
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
                        <span style="color: #606060;">Status:</span>
                        <span class="font-semibold" style="color: #842029;">Gagal</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if (isset($order))
                <a href="{{ route('pembayaran.pending', ['order_id' => $order->order_id]) }}"
                    class="px-8 py-3 rounded-xl text-white font-semibold transition-all duration-300"
                    style="background-color: #664229;" onmouseover="this.style.backgroundColor='#553621'"
                    onmouseout="this.style.backgroundColor='#664229'">
                    Lihat Instruksi / Coba Metode Lain
                </a>
            @endif

            <a href="{{ route('beranda') }}" class="px-8 py-3 rounded-xl font-semibold transition-all duration-300"
                style="background-color: white; color: #664229; border: 2px solid #664229;"
                onmouseover="this.style.backgroundColor='#f5f5f5'" onmouseout="this.style.backgroundColor='white'">
                Kembali ke Beranda
            </a>
        </div>
    </div>

</x-main-layout>
