<x-main-layout>
    <x-slot name="title">Profil Saya - CikalTas</x-slot>

    <style>
        .profile-layout { display: grid; grid-template-columns: 280px 1fr; gap: 24px; align-items: start; }
        @media (max-width:900px) { .profile-layout { grid-template-columns: 1fr; } }

        /* Profile Card (left) */
        .profile-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(196,149,106,0.1);
            box-shadow: 0 2px 16px rgba(0,0,0,0.05);
            position: sticky; top: 80px;
        }
        .profile-card-bg {
            height: 80px;
            background: linear-gradient(135deg, #2E1B0E, #6B4226, #C4956A);
        }
        .profile-card-body { padding: 0 24px 24px; text-align: center; }
        .profile-avatar-wrap {
            position: relative;
            width: 90px; height: 90px;
            margin: -45px auto 14px;
        }
        .profile-avatar {
            width: 90px; height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        }
        .profile-name { font-family: 'Cormorant Garamond', serif; font-size: 20px; font-weight: 700; color: #2E1B0E; margin-bottom: 4px; }
        .profile-email { font-size: 12.5px; color: #a08060; margin-bottom: 16px; }
        .profile-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: linear-gradient(135deg, #fdf5ec, #f5ede3);
            border: 1px solid rgba(196,149,106,0.25);
            padding: 5px 14px; border-radius: 50px;
            font-size: 11.5px; font-weight: 600; color: #6B4226;
        }
        .profile-info-list { margin-top: 16px; text-align: left; }
        .profile-info-item {
            display: flex; align-items: flex-start; gap: 10px;
            padding: 10px 0; border-bottom: 1px solid rgba(196,149,106,0.08);
            font-size: 12.5px; color: #555;
        }
        .profile-info-item:last-child { border-bottom: none; }
        .profile-info-item svg { width: 15px; height: 15px; color: #C4956A; flex-shrink: 0; margin-top: 1px; }

        /* Form Card */
        .form-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid rgba(196,149,106,0.1);
            box-shadow: 0 2px 16px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .form-card-section {
            padding: 24px;
            border-bottom: 1px solid rgba(196,149,106,0.08);
        }
        .form-card-section:last-child { border-bottom: none; }

        .section-head {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 20px;
        }
        .section-head-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #fdf5ec, #f5ede3);
            border: 1px solid rgba(196,149,106,0.2);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .section-head-icon svg { width: 18px; height: 18px; color: #6B4226; }
        .section-head h2 { font-family: 'Cormorant Garamond', serif; font-size: 18px; font-weight: 700; color: #2E1B0E; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media (max-width:700px) { .form-grid { grid-template-columns: 1fr; } }
        .form-grid-full { grid-column: 1 / -1; }

        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 12.5px; font-weight: 600; color: #4a3020; margin-bottom: 7px; letter-spacing: 0.2px; }
        .form-input {
            width: 100%; padding: 11px 14px;
            border: 1.5px solid rgba(196,149,106,0.2);
            border-radius: 12px;
            background: #faf8f5;
            font-family: 'Inter', sans-serif;
            font-size: 13.5px; color: #1a1a1a;
            transition: all 0.2s; outline: none;
        }
        .form-input:focus {
            border-color: #C4956A;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(196,149,106,0.1);
        }
        .form-input::placeholder { color: #b8a090; }
        .form-input-textarea { resize: vertical; min-height: 90px; }

        /* Photo Upload */
        .photo-upload-area {
            display: flex; align-items: center; gap: 20px;
            padding: 16px;
            background: #faf8f5;
            border: 1.5px dashed rgba(196,149,106,0.3);
            border-radius: 14px;
        }
        .photo-preview {
            width: 72px; height: 72px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(196,149,106,0.3);
            flex-shrink: 0;
        }
        .photo-upload-info { flex: 1; }
        .photo-upload-info label {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 9px 16px;
            background: linear-gradient(135deg, #6B4226, #C4956A);
            color: #fff; border-radius: 10px;
            font-size: 12.5px; font-weight: 600;
            cursor: pointer; transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(107,66,38,0.25);
            font-family: 'Inter', sans-serif;
        }
        .photo-upload-info label:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(107,66,38,0.35); }
        .photo-upload-info label svg { width: 15px; height: 15px; }
        .photo-hint { font-size: 11.5px; color: #a08060; margin-top: 6px; }

        /* Submit btn */
        .btn-save {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 28px;
            background: linear-gradient(135deg, #6B4226, #C4956A);
            color: #fff; border: none; border-radius: 14px;
            font-size: 14.5px; font-weight: 700;
            cursor: pointer; font-family: 'Inter', sans-serif;
            box-shadow: 0 6px 20px rgba(107,66,38,0.3);
            transition: all 0.25s;
        }
        .btn-save:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(107,66,38,0.4); }
        .btn-save svg { width: 18px; height: 18px; }

        /* ══════════════════════════════════════════════
           RESPONSIVE STYLE
        ══════════════════════════════════════════════ */
        @media (max-width: 600px) {
            .profile-card { position: static; margin-bottom: 24px; }
            .form-card-section { padding: 18px 16px; }
            .photo-upload-area {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 16px;
            }
            .btn-save { width: 100%; justify-content: center; }
            .helpdesk-wa-btn { width: 100%; justify-content: center; }
        }

        /* Alert */
        .alert-success { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: 14px 20px; border-radius: 14px; font-size: 13.5px; font-weight: 500; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert-error { background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 14px 20px; border-radius: 14px; font-size: 13.5px; margin-bottom: 20px; }

        /* Help Desk Card */
        .helpdesk-card {
            background: linear-gradient(135deg, #2E1B0E, #6B4226);
            border-radius: 20px; padding: 24px;
            margin-top: 24px; color: #fff;
        }
        .helpdesk-wa-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 11px 20px;
            background: #25D366; color: #fff;
            border-radius: 12px; text-decoration: none;
            font-size: 13.5px; font-weight: 700;
            transition: all 0.2s; margin-top: 12px;
            box-shadow: 0 4px 14px rgba(37,211,102,0.4);
        }
        .helpdesk-wa-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(37,211,102,0.5); }

        /* FAQ */
        .faq-item {
            border: 1px solid rgba(196,149,106,0.15);
            border-radius: 14px;
            margin-bottom: 10px;
            overflow: hidden;
        }
        .faq-item summary {
            cursor: pointer; padding: 14px 18px;
            font-size: 13.5px; font-weight: 600;
            color: #2E1B0E;
            background: #faf8f5;
            transition: background 0.2s;
            list-style: none;
            display: flex; align-items: center; justify-content: space-between;
        }
        .faq-item summary::after { content: '+'; font-size: 18px; color: #C4956A; font-weight: 400; }
        .faq-item[open] summary::after { content: '−'; }
        .faq-item summary:hover { background: #f5ede3; }
        .faq-item[open] summary { background: #f5ede3; }
        .faq-body { padding: 14px 18px; font-size: 13px; color: #666; line-height: 1.65; background: #fff; }
    </style>

    @if(session('success'))
        <div class="alert-success">
            <svg style="width:18px;height:18px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert-error">
            <ul style="list-style:disc;padding-left:18px;">
                @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="profile-layout">
        <!-- Profile Card -->
        <div>
            <div class="profile-card">
                <div class="profile-card-bg"></div>
                <div class="profile-card-body">
                    <div class="profile-avatar-wrap">
                        <img id="profilePreview" class="profile-avatar"
                            src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->nama_lengkap ?? 'User') . '&background=6B4226&color=fff&bold=true&size=200' }}"
                            alt="Foto Profil">
                    </div>
                    <div class="profile-name">{{ $user->nama_lengkap ?? 'Pengguna' }}</div>
                    <div class="profile-email">{{ $user->email }}</div>
                    <span class="profile-badge">
                        <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Member Aktif
                    </span>

                    <div class="profile-info-list">
                        @if($user->nomor_telepon)
                        <div class="profile-info-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $user->nomor_telepon }}
                        </div>
                        @endif
                        @if($user->provinsi_kota)
                        <div class="profile-info-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $user->provinsi_kota }}
                        </div>
                        @endif
                        <div class="profile-info-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Bergabung {{ $user->created_at->format('M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div>
            <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                @csrf @method('PATCH')

                <!-- Foto Profil -->
                <div class="form-card" style="margin-bottom:20px;">
                    <div class="form-card-section">
                        <div class="section-head">
                            <div class="section-head-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <h2>Foto Profil</h2>
                        </div>
                        <div class="photo-upload-area">
                            <img id="profilePreview2" class="photo-preview"
                                src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->nama_lengkap ?? 'User') . '&background=6B4226&color=fff&bold=true&size=200' }}"
                                alt="Preview">
                            <div class="photo-upload-info">
                                <label for="profile_photo">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    Unggah Foto
                                </label>
                                <input type="file" id="profile_photo" name="profile_photo" accept="image/*" onchange="previewImage(event)" style="display:none;">
                                <div class="photo-hint">JPG, PNG, JPEG · Maks. 2MB</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Akun -->
                <div class="form-card" style="margin-bottom:20px;">
                    <div class="form-card-section">
                        <div class="section-head">
                            <div class="section-head-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <h2>Informasi Akun</h2>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-input" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" placeholder="Nama lengkap Anda" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" placeholder="email@contoh.com" required>
                            </div>
                            <div class="form-group form-grid-full">
                                <label class="form-label" for="nomor_telepon">Nomor Telepon</label>
                                <input type="text" id="nomor_telepon" name="nomor_telepon" class="form-input" value="{{ old('nomor_telepon', $user->nomor_telepon) }}" placeholder="08xxxxxxxxxx">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="form-card" style="margin-bottom:20px;">
                    <div class="form-card-section">
                        <div class="section-head">
                            <div class="section-head-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <h2>Alamat Pengiriman</h2>
                        </div>
                        <div class="form-grid">
                            <div class="form-group form-grid-full">
                                <label class="form-label" for="provinsi_kota">Provinsi / Kota</label>
                                <input type="text" id="provinsi_kota" name="provinsi_kota" class="form-input" value="{{ old('provinsi_kota', $user->provinsi_kota) }}" placeholder="Contoh: DKI Jakarta">
                            </div>
                            <div class="form-group form-grid-full">
                                <label class="form-label" for="alamat_jalan">Alamat Jalan</label>
                                <textarea id="alamat_jalan" name="alamat_jalan" class="form-input form-input-textarea" placeholder="Nama jalan, nomor rumah...">{{ old('alamat_jalan', $user->alamat_jalan) }}</textarea>
                            </div>
                            <div class="form-group form-grid-full">
                                <label class="form-label" for="detail_lainnya">Detail Tambahan (RT/RW, Patokan, dll)</label>
                                <textarea id="detail_lainnya" name="detail_lainnya" class="form-input form-input-textarea" style="min-height:70px;" placeholder="Dekat masjid Al-Ikhlas, RT 03/RW 05...">{{ old('detail_lainnya', $user->detail_lainnya) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="form-card" style="margin-bottom:24px;">
                    <div class="form-card-section">
                        <div class="section-head">
                            <div class="section-head-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <h2>Ubah Password</h2>
                        </div>
                        <div style="font-size:12.5px;color:#a08060;margin-bottom:16px;">Kosongkan jika tidak ingin mengubah password</div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label" for="current_password">Password Saat Ini</label>
                                <input type="password" id="current_password" name="current_password" class="form-input" placeholder="••••••••">
                            </div>
                            <div class="form-group"></div>
                            <div class="form-group">
                                <label class="form-label" for="password">Password Baru</label>
                                <input type="password" id="password" name="password" class="form-input" placeholder="••••••••">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display:flex;justify-content:flex-end;">
                    <button type="submit" class="btn-save">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>

            <!-- FAQ -->
            <div style="background:#fff;border-radius:20px;padding:24px;margin-top:24px;border:1px solid rgba(196,149,106,0.1);box-shadow:0 2px 16px rgba(0,0,0,0.05);">
                <div class="section-head" style="margin-bottom:16px;">
                    <div class="section-head-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2>Pertanyaan Umum</h2>
                </div>

                <details class="faq-item">
                    <summary>Bagaimana cara memesan produk?</summary>
                    <div class="faq-body">Pilih produk di Beranda, klik "Beli Sekarang" atau tambah ke Keranjang, lalu lanjutkan ke Pembayaran.</div>
                </details>
                <details class="faq-item">
                    <summary>Bagaimana cara melihat status pesanan?</summary>
                    <div class="faq-body">Buka menu "Pesanan Saya" di sidebar untuk melihat seluruh riwayat dan status pesanan Anda.</div>
                </details>
                <details class="faq-item">
                    <summary>Saya gagal bayar / pembayaran pending, harus bagaimana?</summary>
                    <div class="faq-body">Coba ulangi pembayaran dari menu "Pembayaran". Jika masih bermasalah, hubungi Admin via WhatsApp.</div>
                </details>
                <details class="faq-item">
                    <summary>Bagaimana cara mengubah data profil?</summary>
                    <div class="faq-body">Ubah data pada form di halaman ini, lalu klik "Simpan Perubahan" di bagian bawah.</div>
                </details>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) { alert('Ukuran file terlalu besar! Maks. 2MB.'); event.target.value = ''; return; }
            if (!file.type.match('image.*')) { alert('File harus berupa gambar!'); event.target.value = ''; return; }
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('profilePreview').src = e.target.result;
                document.getElementById('profilePreview2').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    </script>
</x-main-layout>
