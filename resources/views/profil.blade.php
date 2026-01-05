<x-main-layout>
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8" style="color: #664229;">Profil Saya</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data"
            class="bg-white rounded-2xl shadow-md p-8">
            @csrf
            @method('PATCH')

            <!-- Foto Profil -->
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-6" style="color: #664229;">Foto Profil</h2>

                <div class="flex items-center gap-6">
                    <div class="relative">
                        <img id="profilePreview"
                            src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->nama_lengkap ?? 'User') . '&background=664229&color=fff&size=200' }}"
                            alt="Profile Photo" class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                    </div>

                    <div class="flex-1">
                        <label for="profile_photo" class="block text-sm font-semibold mb-2" style="color: #202224;">
                            Upload Foto Profil
                        </label>
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                            onchange="previewImage(event)"
                            class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                            style="border-color: #e0e0e0;">
                        <p class="text-xs mt-2" style="color: #606060;">
                            Format: JPG, PNG, JPEG. Maksimal 2MB.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Informasi Akun -->
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-6" style="color: #664229;">Informasi Akun</h2>

                <div class="space-y-6">
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-semibold mb-2" style="color: #202224;">Nama
                            Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap"
                            value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                            class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                            style="border-color: #e0e0e0;" required>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold mb-2"
                            style="color: #202224;">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                            style="border-color: #e0e0e0;" required>
                    </div>

                    <div>
                        <label for="nomor_telepon" class="block text-sm font-semibold mb-2"
                            style="color: #202224;">Nomor Telepon</label>
                        <input type="text" id="nomor_telepon" name="nomor_telepon"
                            value="{{ old('nomor_telepon', $user->nomor_telepon) }}"
                            class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                            style="border-color: #e0e0e0;">
                    </div>
                </div>
            </div>

            <!-- Alamat Pengiriman -->
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-6" style="color: #664229;">Alamat Pengiriman</h2>

                <div class="space-y-6">
                    <div>
                        <label for="provinsi_kota" class="block text-sm font-semibold mb-2"
                            style="color: #202224;">Provinsi/Kota</label>
                        <input type="text" id="provinsi_kota" name="provinsi_kota"
                            value="{{ old('provinsi_kota', $user->provinsi_kota) }}"
                            class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                            style="border-color: #e0e0e0;">
                    </div>

                    <div>
                        <label for="alamat_jalan" class="block text-sm font-semibold mb-2"
                            style="color: #202224;">Alamat Jalan</label>
                        <textarea id="alamat_jalan" name="alamat_jalan" rows="3"
                            class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                            style="border-color: #e0e0e0;">{{ old('alamat_jalan', $user->alamat_jalan) }}</textarea>
                    </div>

                    <div>
                        <label for="detail_lainnya" class="block text-sm font-semibold mb-2"
                            style="color: #202224;">Detail Lainnya (Patokan, RT/RW, dll)</label>
                        <textarea id="detail_lainnya" name="detail_lainnya" rows="2"
                            class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                            style="border-color: #e0e0e0;">{{ old('detail_lainnya', $user->detail_lainnya) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Ubah Password (Opsional) -->
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-6" style="color: #664229;">Ubah Password</h2>
                <p class="text-sm mb-4" style="color: #606060;">Kosongkan jika tidak ingin mengubah password</p>

                <div class="space-y-6">
                    <div>
                        <label for="current_password" class="block text-sm font-semibold mb-2"
                            style="color: #202224;">Password Saat Ini</label>
                        <input type="password" id="current_password" name="current_password"
                            class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                            style="border-color: #e0e0e0;">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold mb-2"
                            style="color: #202224;">Password
                            Baru</label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                            style="border-color: #e0e0e0;">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold mb-2"
                            style="color: #202224;">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-[#664229]"
                            style="border-color: #e0e0e0;">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="px-8 py-3 rounded-xl text-white font-semibold text-lg transition-all duration-300"
                    style="background-color: #664229;" onmouseover="this.style.backgroundColor='#553621'"
                    onmouseout="this.style.backgroundColor='#664229'">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <div class="bg-white rounded-2xl shadow-md p-8 mt-8">
            <h2 class="text-xl font-bold mb-2" style="color: #664229;">Help Desk</h2>
            <p class="text-sm mb-6" style="color: #606060;">
                Butuh bantuan? Hubungi kami melalui WhatsApp atau lihat pertanyaan umum di bawah.
            </p>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <p class="text-sm font-semibold" style="color: #202224;">WhatsApp</p>
                    <p class="text-sm" style="color: #606060;">085175397197</p>
                </div>

                <a href="https://wa.me/6285175397197" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center justify-center px-6 py-3 rounded-xl text-white font-semibold transition-all duration-300"
                    style="background-color: #664229;" onmouseover="this.style.backgroundColor='#553621'"
                    onmouseout="this.style.backgroundColor='#664229'">
                    Chat via WhatsApp
                </a>
            </div>

            <h3 class="text-lg font-bold mb-4" style="color: #664229;">Pertanyaan Umum</h3>
            <div class="space-y-3">
                <details class="group border border-gray-200 rounded-xl px-4 py-3">
                    <summary class="cursor-pointer font-semibold" style="color: #202224;">Bagaimana cara memesan produk?</summary>
                    <div class="mt-2 text-sm" style="color: #606060;">
                        Pilih produk di Beranda, klik "Beli Sekarang" atau tambah ke Keranjang, lalu lanjutkan ke Pembayaran.
                    </div>
                </details>

                <details class="group border border-gray-200 rounded-xl px-4 py-3">
                    <summary class="cursor-pointer font-semibold" style="color: #202224;">Bagaimana cara melihat status pesanan?</summary>
                    <div class="mt-2 text-sm" style="color: #606060;">
                        Buka menu "Pesanan" untuk melihat daftar pesanan dan status pembayarannya.
                    </div>
                </details>

                <details class="group border border-gray-200 rounded-xl px-4 py-3">
                    <summary class="cursor-pointer font-semibold" style="color: #202224;">Saya gagal bayar / pembayaran pending, harus bagaimana?</summary>
                    <div class="mt-2 text-sm" style="color: #606060;">
                        Coba ulangi pembayaran dari menu "Pembayaran". Jika masih bermasalah, hubungi Help Desk via WhatsApp.
                    </div>
                </details>

                <details class="group border border-gray-200 rounded-xl px-4 py-3">
                    <summary class="cursor-pointer font-semibold" style="color: #202224;">Bagaimana cara mengubah data profil?</summary>
                    <div class="mt-2 text-sm" style="color: #606060;">
                        Ubah data pada form profil, lalu klik "Simpan Perubahan".
                    </div>
                </details>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('profilePreview');

            if (file) {
                // Check file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 2MB.');
                    event.target.value = '';
                    return;
                }

                // Check file type
                if (!file.type.match('image.*')) {
                    alert('File harus berupa gambar!');
                    event.target.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-main-layout>
