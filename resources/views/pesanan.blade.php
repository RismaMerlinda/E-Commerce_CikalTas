<x-main-layout>
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6" style="color: #664229;">History Pesanan</h1>

        @if ($orders->count() > 0)
            <div class="space-y-6">
                @foreach ($orders as $index => $order)
                    <div class="bg-white rounded-2xl shadow-md p-6">
                        <!-- Order Header -->
                        <div class="flex justify-between items-start mb-4 pb-4 border-b border-gray-200">
                            <div>
                                <h2 class="text-xl font-bold mb-1" style="color: #664229;">Pesanan {{ $index + 1 }}
                                </h2>
                                <p class="text-sm" style="color: #606060;">
                                    Dipesan pada: {{ $order->created_at->format('d M Y') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2 px-4 py-2 rounded-full"
                                style="background-color: 
                                    {{ $order->status == 'completed'
                                        ? '#d1e7dd'
                                        : ($order->status == 'paid' || $order->status == 'processing'
                                            ? '#cfe2ff'
                                            : ($order->status == 'pending'
                                                ? '#fff3cd'
                                                : '#f8d7da')) }};">
                                <span class="text-sm font-semibold"
                                    style="color: 
                                        {{ $order->status == 'completed'
                                            ? '#0f5132'
                                            : ($order->status == 'paid' || $order->status == 'processing'
                                                ? '#084298'
                                                : ($order->status == 'pending'
                                                    ? '#856404'
                                                    : '#842029')) }};">
                                    @if ($order->status == 'completed')
                                        ✓ Pesanan Selesai
                                    @elseif($order->status == 'paid' || $order->status == 'processing')
                                        📦 Sedang Dikemas
                                    @elseif($order->status == 'pending')
                                        ⏱ Menunggu Pembayaran
                                    @else
                                        ✗ Dibatalkan
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="space-y-3">
                            @foreach ($order->orderItems as $item)
                                <div class="flex justify-between items-center py-2">
                                    <span style="color: #202224;">{{ $item->product->name }}</span>
                                    <span style="color: #606060;">Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Total -->
                        <div class="flex justify-between items-center mt-4 pt-4 border-t-2 border-gray-200">
                            <span class="text-lg font-bold" style="color: #202224;">Total</span>
                            <span class="text-lg font-bold" style="color: #664229;">
                                Rp {{ number_format($order->gross_amount, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Payment Button for Pending Orders -->
                        @if ($order->status == 'pending')
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <a href="{{ route('pembayaran.pending', ['order_id' => $order->order_id]) }}"
                                    class="block w-full text-center px-6 py-3 rounded-xl text-white font-semibold transition-all duration-300"
                                    style="background-color: #664229;"
                                    onmouseover="this.style.backgroundColor='#553621'"
                                    onmouseout="this.style.backgroundColor='#664229'">
                                    Lihat Instruksi Pembayaran
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-md p-8">
                <p class="text-center py-12" style="color: #606060;">Belum ada pesanan</p>
            </div>
        @endif
    </div>

</x-main-layout>
