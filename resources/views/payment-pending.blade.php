<x-main-layout>
    <div class="max-w-2xl mx-auto text-center py-12">
        <!-- Pending Icon -->
        <div class="mb-8">
            <div class="w-24 h-24 mx-auto rounded-full flex items-center justify-center"
                style="background-color: #fff3cd;">
                <svg class="w-12 h-12" style="color: #856404;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-4xl font-bold mb-4" style="color: #664229;">Menunggu Pembayaran</h1>

        <!-- Message -->
        <p class="text-lg mb-8" style="color: #606060;">
            Pesanan Anda telah dibuat. Silakan selesaikan pembayaran untuk melanjutkan.
        </p>

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
                    <span style="color: #606060;">Status:</span>
                    <span class="font-semibold" style="color: #856404;">Menunggu Pembayaran</span>
                </div>
            </div>

            <div class="mt-6 p-4 rounded-xl" style="background-color: #fff3cd;">
                <p class="text-sm" style="color: #856404;">
                    <strong>Petunjuk:</strong> Selesaikan pembayaran sesuai instruksi di bawah. Status pesanan akan
                    ter-update otomatis setelah pembayaran berhasil.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-8 mb-8 text-left">
            <h2 class="text-xl font-bold mb-4" style="color: #664229;">Instruksi Pembayaran</h2>

            @php
                $resp = $order->midtrans_response ?? [];
                $pt = $order->payment_type ?? ($resp['payment_type'] ?? null);
            @endphp

            @if ($pt === 'bank_transfer')
                @php $va = $resp['va_numbers'][0] ?? null; @endphp
                @if ($va)
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span style="color:#606060;">Bank</span>
                            <span class="font-semibold" style="color:#202224;">{{ strtoupper($va['bank'] ?? '') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span style="color:#606060;">Nomor VA</span>
                            <span class="font-semibold" style="color:#664229;">{{ $va['va_number'] ?? '-' }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-sm" style="color:#606060;">Instruksi VA belum tersedia.</p>
                @endif

            @elseif ($pt === 'permata')
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span style="color:#606060;">Bank</span>
                        <span class="font-semibold" style="color:#202224;">PERMATA</span>
                    </div>
                    <div class="flex justify-between">
                        <span style="color:#606060;">Nomor VA</span>
                        <span class="font-semibold" style="color:#664229;">{{ $resp['permata_va_number'] ?? '-' }}</span>
                    </div>
                </div>

            @elseif ($pt === 'echannel')
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span style="color:#606060;">Biller Code</span>
                        <span class="font-semibold" style="color:#664229;">{{ $resp['biller_code'] ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span style="color:#606060;">Bill Key</span>
                        <span class="font-semibold" style="color:#664229;">{{ $resp['bill_key'] ?? '-' }}</span>
                    </div>
                </div>

            @elseif ($pt === 'cstore')
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span style="color:#606060;">Toko</span>
                        <span class="font-semibold" style="color:#202224;">{{ strtoupper($resp['store'] ?? '-') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span style="color:#606060;">Kode Pembayaran</span>
                        <span class="font-semibold" style="color:#664229;">{{ $resp['payment_code'] ?? '-' }}</span>
                    </div>
                </div>

            @elseif ($pt === 'qris')
                <div class="flex flex-col items-center gap-4">
                    <img src="{{ route('pembayaran.qr', ['order_id' => $order->order_id]) }}" alt="QRIS"
                        class="w-64 h-64 object-contain">
                    <p class="text-sm text-center" style="color:#606060;">Scan QRIS untuk menyelesaikan pembayaran.</p>
                </div>

            @elseif ($pt === 'gopay')
                <div class="flex flex-col items-center gap-4">
                    <img src="{{ route('pembayaran.qr', ['order_id' => $order->order_id]) }}" alt="GoPay QR"
                        class="w-64 h-64 object-contain">
                    <p class="text-sm text-center" style="color:#606060;">Scan QR atau buka GoPay untuk menyelesaikan
                        pembayaran.</p>
                </div>

                @php
                    $deeplink = $resp['actions'][0]['url'] ?? null;
                @endphp
                @if (is_string($deeplink) && $deeplink)
                    <div class="mt-6 text-center">
                        <a href="{{ $deeplink }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center px-8 py-3 rounded-xl text-white font-semibold transition-all duration-300"
                            style="background-color: #664229;" onmouseover="this.style.backgroundColor='#553621'"
                            onmouseout="this.style.backgroundColor='#664229'">
                            Buka GoPay
                        </a>
                    </div>
                @endif

            @elseif ($pt === 'shopeepay')
                @if (!empty($resp['redirect_url']))
                    <div class="text-center">
                        <a href="{{ $resp['redirect_url'] }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center px-8 py-3 rounded-xl text-white font-semibold transition-all duration-300"
                            style="background-color: #664229;" onmouseover="this.style.backgroundColor='#553621'"
                            onmouseout="this.style.backgroundColor='#664229'">
                            Buka ShopeePay
                        </a>
                        <p class="text-sm mt-3" style="color:#606060;">Kamu akan diarahkan ke aplikasi Shopee untuk membayar.
                        </p>
                    </div>
                @else
                    <p class="text-sm" style="color:#606060;">Link ShopeePay belum tersedia.</p>
                @endif

            @elseif ($pt === 'credit_card')
                @if (!empty($resp['redirect_url']))
                    <div class="text-center">
                        <a href="{{ $resp['redirect_url'] }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center px-8 py-3 rounded-xl text-white font-semibold transition-all duration-300"
                            style="background-color: #664229;" onmouseover="this.style.backgroundColor='#553621'"
                            onmouseout="this.style.backgroundColor='#664229'">
                            Verifikasi 3DS
                        </a>
                        <p class="text-sm mt-3" style="color:#606060;">Selesaikan verifikasi 3DS untuk menyelesaikan pembayaran
                            kartu.</p>
                    </div>
                @else
                    <p class="text-sm" style="color:#606060;">Pembayaran kartu sedang diproses. Jika status tidak berubah, coba
                        beberapa saat lagi.</p>
                @endif
            @else
                <p class="text-sm" style="color:#606060;">Instruksi pembayaran tidak tersedia.</p>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('pesanan') }}" class="px-8 py-3 rounded-xl font-semibold transition-all duration-300"
                style="background-color: white; color: #664229; border: 2px solid #664229;"
                onmouseover="this.style.backgroundColor='#f5f5f5'" onmouseout="this.style.backgroundColor='white'">
                Lihat Pesanan Saya
            </a>
        </div>
    </div>

    <script>
        // Auto-poll Midtrans for transaction status and redirect when changed
        const orderId = '{{ $order->order_id }}';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

        async function checkPaymentOnce() {
            try {
                const resp = await fetch('/api/check-payment-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ order_id: orderId })
                });

                if (!resp.ok) return null;
                const data = await resp.json();
                return data;
            } catch (e) {
                return null;
            }
        }

        (function startPolling() {
            const intervalMs = 5000; // 5 seconds
            const maxAttempts = 120; // ~10 minutes
            let attempts = 0;

            // Immediate check
            (async () => {
                const data = await checkPaymentOnce();
                if (data && data.success && data.status !== 'pending') {
                    if (data.status === 'paid') {
                        window.location.href = '/pembayaran/success?order_id=' + orderId;
                    } else if (data.status === 'failed' || data.status === 'cancelled' || data.status === 'expired') {
                        window.location.href = '/pembayaran/error?order_id=' + orderId;
                    }
                }
            })();

            const timer = setInterval(async () => {
                attempts++;
                if (attempts > maxAttempts) {
                    clearInterval(timer);
                    return;
                }

                const data = await checkPaymentOnce();
                if (!data) return;

                if (data.success) {
                    if (data.status === 'paid') {
                        clearInterval(timer);
                        window.location.href = '/pembayaran/success?order_id=' + orderId;
                    } else if (data.status === 'failed' || data.status === 'cancelled' || data.status === 'expired') {
                        clearInterval(timer);
                        window.location.href = '/pembayaran/error?order_id=' + orderId;
                    }
                }
            }, intervalMs);
        })();
    </script>
</x-main-layout>