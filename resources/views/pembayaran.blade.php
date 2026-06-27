<x-main-layout>
    <x-slot name="title">Pembayaran - CikalTas</x-slot>

    <style>
        @media (max-width: 640px) {
            .bg-white.p-8 { padding: 20px !important; }
            .bg-white.p-6 { padding: 16px !important; }
            h1.text-3xl { font-size: 22px !important; margin-bottom: 16px !important; }
            h2.text-2xl { font-size: 17px !important; margin-bottom: 16px !important; }
            #paymentMethodModal > div {
                max-height: 96vh !important;
                margin: 8px;
            }
        }
    </style>

    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6" style="color: #202224;">Pembayaran</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Summary -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-md p-8 mb-6">
                    <h2 class="text-2xl font-bold mb-6" style="color: #202224;">Detail Pesanan</h2>

                    <div class="space-y-4">
                        @foreach ($cartItems as $item)
                            <div class="flex gap-4 pb-4 border-b" style="border-color: #E5E5E5;">
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                                    @if ($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}" class="w-full h-full object-contain p-1">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <h3 class="font-bold mb-1" style="color: #202224;">{{ $item->product->name }}</h3>
                                    <p class="text-sm mb-2" style="color: #606060;">Jumlah: {{ $item->quantity }} x Rp
                                        {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    <p class="font-bold" style="color: #664229;">Rp
                                        {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="bg-white rounded-2xl shadow-md p-8">
                    <h2 class="text-2xl font-bold mb-6" style="color: #202224;">Informasi Pembeli</h2>

                    <div class="space-y-3">
                        <div class="flex">
                            <span class="font-semibold w-32" style="color: #606060;">Nama:</span>
                            <span style="color: #202224;">{{ Auth::user()->nama_lengkap }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold w-32" style="color: #606060;">Email:</span>
                            <span style="color: #202224;">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold w-32" style="color: #606060;">Telepon:</span>
                            <span style="color: #202224;">{{ Auth::user()->nomor_telepon ?? '-' }}</span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold w-32" style="color: #606060;">Alamat:</span>
                            <span style="color: #202224;">{{ Auth::user()->alamat_jalan ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-md p-6 sticky top-6">
                    <h2 class="text-xl font-bold mb-6" style="color: #202224;">Ringkasan Pembayaran</h2>

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
                        <div class="flex justify-between">
                            <span style="color: #606060;">Biaya Admin</span>
                            <span class="font-semibold" style="color: #202224;">Gratis</span>
                        </div>
                        <div class="border-t pt-3" style="border-color: #E5E5E5;">
                            <div class="flex justify-between">
                                <span class="font-bold" style="color: #202224;">Total Pembayaran</span>
                                <span class="text-2xl font-bold" style="color: #664229;">Rp
                                    {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <button id="pay-button"
                        class="w-full text-white font-bold py-4 rounded-xl transition hover:opacity-90 shadow-md"
                        style="background: #664229;">
                        Bayar Sekarang
                    </button>

                    <p class="text-xs text-center mt-4" style="color: #606060;">
                        Pembayaran dilakukan melalui Midtrans yang aman dan terpercaya
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="paymentMethodModal" class="fixed inset-0 hidden items-center justify-center p-4 z-50"
        style="background: rgba(0,0,0,0.55);">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden max-h-[90vh] flex flex-col">
            <div class="flex items-center justify-between px-6 py-4 border-b" style="border-color:#E5E5E5;">
                <h3 class="text-lg font-bold" style="color:#664229;">Pilih Metode Pembayaran</h3>
                <button id="closePaymentMethodModal" type="button"
                    class="w-10 h-10 rounded-xl font-bold text-lg border border-gray-200 hover:bg-gray-50"
                    aria-label="Tutup">×</button>
            </div>

            <div class="p-6 overflow-y-auto flex-1">
                <div class="space-y-3">
                    <label class="flex items-center gap-3 p-3 rounded-xl border" style="border-color:#E5E5E5;">
                        <input type="radio" name="payment_type" value="bank_transfer" checked>
                        <span class="text-sm font-semibold" style="color:#202224;">Virtual Account (BCA/BNI/BRI/CIMB)</span>
                    </label>

                    <div class="pl-10">
                        <select id="bank" class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                            style="border-color:#e0e0e0;">
                            <option value="bca">BCA VA</option>
                            <option value="bni">BNI VA</option>
                            <option value="bri">BRI VA</option>
                            <option value="cimb">CIMB VA</option>
                        </select>
                    </div>

                    <label class="flex items-center gap-3 p-3 rounded-xl border" style="border-color:#E5E5E5;">
                        <input type="radio" name="payment_type" value="permata">
                        <span class="text-sm font-semibold" style="color:#202224;">Permata VA</span>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-xl border" style="border-color:#E5E5E5;">
                        <input type="radio" name="payment_type" value="echannel">
                        <span class="text-sm font-semibold" style="color:#202224;">Mandiri Bill (eChannel)</span>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-xl border" style="border-color:#E5E5E5;">
                        <input type="radio" name="payment_type" value="qris">
                        <span class="text-sm font-semibold" style="color:#202224;">QRIS</span>
                    </label>

                    <div class="pl-10">
                        <select id="qris_acquirer" class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                            style="border-color:#e0e0e0;">
                            <option value="gopay">QRIS (GoPay)</option>
                            <option value="airpay shopee">QRIS (Shopee)</option>
                        </select>
                    </div>

                    <label class="flex items-center gap-3 p-3 rounded-xl border" style="border-color:#E5E5E5;">
                        <input type="radio" name="payment_type" value="gopay">
                        <span class="text-sm font-semibold" style="color:#202224;">GoPay</span>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-xl border" style="border-color:#E5E5E5;">
                        <input type="radio" name="payment_type" value="shopeepay">
                        <span class="text-sm font-semibold" style="color:#202224;">ShopeePay</span>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-xl border" style="border-color:#E5E5E5;">
                        <input type="radio" name="payment_type" value="cstore">
                        <span class="text-sm font-semibold" style="color:#202224;">Minimarket (Alfamart/Indomaret)</span>
                    </label>

                    <div class="pl-10">
                        <select id="store" class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                            style="border-color:#e0e0e0;">
                            <option value="alfamart">Alfamart</option>
                            <option value="indomaret">Indomaret</option>
                        </select>
                    </div>

                    <label class="flex items-center gap-3 p-3 rounded-xl border" style="border-color:#E5E5E5;">
                        <input type="radio" name="payment_type" value="credit_card">
                        <span class="text-sm font-semibold" style="color:#202224;">Kartu Kredit / Debit Online</span>
                    </label>

                    <div id="ccFields" class="pl-10 grid grid-cols-1 gap-3">
                        <input id="cc_number" type="text" inputmode="numeric" autocomplete="cc-number" placeholder="Nomor Kartu"
                            class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                            style="border-color:#e0e0e0;">
                        <div class="grid grid-cols-3 gap-3">
                            <input id="cc_exp_month" type="text" inputmode="numeric" autocomplete="cc-exp-month" placeholder="MM"
                                class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                                style="border-color:#e0e0e0;">
                            <input id="cc_exp_year" type="text" inputmode="numeric" autocomplete="cc-exp-year" placeholder="YYYY"
                                class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                                style="border-color:#e0e0e0;">
                            <input id="cc_cvv" type="password" inputmode="numeric" autocomplete="cc-csc" placeholder="CVV"
                                class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                                style="border-color:#e0e0e0;">
                        </div>
                        <p class="text-xs" style="color:#606060;">Data kartu akan ditokenisasi oleh Midtrans, tidak disimpan di server.</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t" style="border-color:#E5E5E5;">
                <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                    <button id="confirmPayButton" type="button"
                        class="px-8 py-3 rounded-xl text-white font-semibold transition-all duration-300"
                        style="background-color: #664229;" onmouseover="this.style.backgroundColor='#553621'"
                        onmouseout="this.style.backgroundColor='#664229'">
                        Lanjut Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script id="midtrans-script" type="text/javascript" src="https://api.midtrans.com/v2/assets/js/midtrans-new-3ds.min.js"
        data-environment="{{ config('midtrans.is_production') ? 'production' : 'sandbox' }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        const payBtn = document.getElementById('pay-button');
        const paymentMethodModal = document.getElementById('paymentMethodModal');
        const closePaymentMethodModalBtn = document.getElementById('closePaymentMethodModal');
        const confirmPayButton = document.getElementById('confirmPayButton');

        function openPaymentMethodModal() {
            paymentMethodModal.classList.remove('hidden');
            paymentMethodModal.classList.add('flex');
        }

        function closePaymentMethodModal() {
            paymentMethodModal.classList.add('hidden');
            paymentMethodModal.classList.remove('flex');
            confirmPayButton.disabled = false;
            confirmPayButton.innerHTML = 'Lanjut Bayar';
        }

        closePaymentMethodModalBtn.addEventListener('click', function() {
            closePaymentMethodModal();
        });

        paymentMethodModal.addEventListener('click', function(e) {
            if (e.target === paymentMethodModal) {
                closePaymentMethodModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !paymentMethodModal.classList.contains('hidden')) {
                closePaymentMethodModal();
            }
        });

        function selectedPaymentType() {
            const checked = document.querySelector('input[name="payment_type"]:checked');
            return checked ? checked.value : 'bank_transfer';
        }

        function createPayload(tokenId) {
            const pt = selectedPaymentType();
            const payload = {
                payment_type: pt,
                bank: document.getElementById('bank').value,
                store: document.getElementById('store').value,
                qris_acquirer: document.getElementById('qris_acquirer').value,
            };

            if (pt === 'credit_card') {
                payload.token_id = tokenId || null;
            }

            return payload;
        }

        function submitPayment(payload) {
            return fetch('/pembayaran/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload)
            }).then(r => r.json());
        }

        function redirectByStatus(data) {
            if (data.status === 'paid') {
                window.location.href = '/pembayaran/success?order_id=' + data.order_id;
                return;
            }

            if (data.status === 'failed' || data.status === 'cancelled' || data.status === 'expired') {
                window.location.href = '/pembayaran/error?order_id=' + data.order_id;
                return;
            }

            window.location.href = '/pembayaran/pending?order_id=' + data.order_id;
        }

        function getCardToken() {
            const cardData = {
                card_number: document.getElementById('cc_number').value.replace(/\s+/g, ''),
                card_exp_month: document.getElementById('cc_exp_month').value,
                card_exp_year: document.getElementById('cc_exp_year').value,
                card_cvv: document.getElementById('cc_cvv').value,
            };

            return new Promise((resolve, reject) => {
                const options = {
                    onSuccess: function(response) {
                        resolve(response.token_id);
                    },
                    onFailure: function(response) {
                        reject(response);
                    }
                };

                if (!window.MidtransNew3ds) {
                    reject({ message: 'Midtrans JS belum siap' });
                    return;
                }

                MidtransNew3ds.getCardToken(cardData, options);
            });
        }

        payBtn.addEventListener('click', function() {
            openPaymentMethodModal();
        });

        confirmPayButton.addEventListener('click', async function() {
            confirmPayButton.disabled = true;
            confirmPayButton.innerHTML = 'Memproses...';
            payBtn.disabled = true;
            payBtn.innerHTML = 'Memproses...';

            try {
                const pt = selectedPaymentType();

                if (pt === 'credit_card') {
                    const tokenId = await getCardToken();
                    const data = await submitPayment(createPayload(tokenId));
                    if (!data.success) throw data;
                    redirectByStatus(data);
                    return;
                }

                const data = await submitPayment(createPayload(null));
                if (!data.success) throw data;
                redirectByStatus(data);
            } catch (err) {
                alert(err.message || 'Gagal membuat transaksi');
                confirmPayButton.disabled = false;
                confirmPayButton.innerHTML = 'Lanjut Bayar';
                payBtn.disabled = false;
                payBtn.innerHTML = 'Bayar Sekarang';
            }
        });
    </script>
</x-main-layout>
