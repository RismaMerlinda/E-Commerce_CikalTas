<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alamat Pengguna</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #D7BFA6;
            margin: 0;
        }

        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: #fff;
            width: 420px;
            padding: 40px 32px;
            border-radius: 20px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 2px;
            text-align: center;
        }

        .subtitle {
            font-size: 13px;
            color: #5d5d5d;
            margin-bottom: 22px;
            text-align: center;
        }

        .form-group {
            width: 100%;
            margin-bottom: 18px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            font-size: 14px;
            color: #333;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 14px;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        textarea {
            resize: vertical;
            min-height: 70px;
        }

        .error-text {
            color: #c62828;
            font-size: 13px;
            margin-top: 6px;
            display: none;
        }

        .btn-info {
            text-align: left;
            margin-bottom: 10px;
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        .btn-info a {
            color: #A67C52;
            text-decoration: none;
            margin-left: 6px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-info a:hover {
            text-decoration: underline;
        }

        .btn-container {
            margin-top: 5px;
        }

        .btn {
            background: #A67C52;
            color: #fff;
            padding: 12px 0;
            border-radius: 10px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            width: 100%;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background: #8f6844;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <h2>Alamat Pengguna</h2>
            <p class="subtitle">Lengkapi alamatmu sebelum melanjutkan.</p>

            <form id="alamatForm" action="{{ route('register.step2.post') }}" method="POST" novalidate>
                @csrf

                @if (session('error'))
                    <div
                        style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div
                        style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Nomor Telepon -->
                <div class="form-group">
                    <label for="nomor_telepon">Nomor Telepon</label>
                    <input type="text" id="nomor_telepon" name="nomor_telepon" placeholder="Contoh: 081234567890"
                        maxlength="15" />
                    <p class="error-text" id="teleponError"></p>
                </div>

                <!-- Provinsi -->
                <div class="form-group">
                    <label for="provinsi">Provinsi</label>
                    <select id="provinsi" name="provinsi_kota">
                        <option value="">-- Pilih Provinsi --</option>
                        <option value="Aceh">Aceh</option>
                        <option value="Sumatera Utara">Sumatera Utara</option>
                        <option value="Sumatera Barat">Sumatera Barat</option>
                        <option value="Riau">Riau</option>
                        <option value="Kepulauan Riau">Kepulauan Riau</option>
                        <option value="Jambi">Jambi</option>
                        <option value="Sumatera Selatan">Sumatera Selatan</option>
                        <option value="Bangka Belitung">Bangka Belitung</option>
                        <option value="Bengkulu">Bengkulu</option>
                        <option value="Lampung">Lampung</option>
                        <option value="DKI Jakarta">DKI Jakarta</option>
                        <option value="Jawa Barat">Jawa Barat</option>
                        <option value="Jawa Tengah">Jawa Tengah</option>
                        <option value="DI Yogyakarta">DI Yogyakarta</option>
                        <option value="Jawa Timur">Jawa Timur</option>
                        <option value="Banten">Banten</option>
                        <option value="Bali">Bali</option>
                        <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                        <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                        <option value="Kalimantan Barat">Kalimantan Barat</option>
                        <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                        <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                        <option value="Kalimantan Timur">Kalimantan Timur</option>
                        <option value="Kalimantan Utara">Kalimantan Utara</option>
                        <option value="Sulawesi Utara">Sulawesi Utara</option>
                        <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                        <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                        <option value="Sulawesi Barat">Sulawesi Barat</option>
                        <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                        <option value="Gorontalo">Gorontalo</option>
                        <option value="Maluku">Maluku</option>
                        <option value="Maluku Utara">Maluku Utara</option>
                        <option value="Papua">Papua</option>
                        <option value="Papua Barat">Papua Barat</option>
                        <option value="Papua Tengah">Papua Tengah</option>
                        <option value="Papua Pegunungan">Papua Pegunungan</option>
                        <option value="Papua Selatan">Papua Selatan</option>
                        <option value="Papua Barat Daya">Papua Barat Daya</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    <p class="error-text" id="provinsiError"></p>
                </div>

                <!-- Alamat Jalan -->
                <div class="form-group">
                    <label for="alamat_jalan">Alamat Jalan</label>
                    <input type="text" id="alamat_jalan" name="alamat_jalan"
                        placeholder="Contoh: Jl. Merdeka No.10" />
                    <p class="error-text" id="alamatError"></p>
                </div>

                <!-- Detail tambahan -->
                <div class="form-group">
                    <label for="detail_lainnya">Detail tambahan (opsional)</label>
                    <textarea id="detail_lainnya" name="detail_lainnya" placeholder="Misal: Kompleks, Blok, No Rumah"></textarea>
                </div>

                <!-- Sudah punya akun? -->
                <div class="btn-info">
                    Sudah punya akun? <a href="/login">Masuk</a>
                </div>

                <div class="btn-container">
                    <button class="btn" type="submit">Daftar Sekarang</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById("alamatForm");

        form.addEventListener("submit", function(e) {
            e.preventDefault();

            const telepon = document.getElementById("nomor_telepon").value.trim();
            const provinsi = document.getElementById("provinsi").value.trim();
            const alamat = document.getElementById("alamat_jalan").value.trim();

            const teleponErr = document.getElementById("teleponError");
            const provinsiErr = document.getElementById("provinsiError");
            const alamatErr = document.getElementById("alamatError");

            // Reset error
            teleponErr.style.display = "none";
            provinsiErr.style.display = "none";
            alamatErr.style.display = "none";

            let errorDetected = false;

            // Validasi nomor telepon
            if (!/^\d{8,15}$/.test(telepon)) {
                teleponErr.textContent = "Nomor telepon harus berupa angka dan panjang 8–15 digit.";
                teleponErr.style.display = "block";
                errorDetected = true;
            }

            // Validasi provinsi
            if (provinsi === "") {
                provinsiErr.textContent = "Provinsi harus dipilih.";
                provinsiErr.style.display = "block";
                errorDetected = true;
            }

            // Validasi alamat
            if (alamat === "") {
                alamatErr.textContent = "Alamat jalan harus diisi.";
                alamatErr.style.display = "block";
                errorDetected = true;
            }

            if (!errorDetected) {
                form.submit();
            }
        });
    </script>

</body>

</html>
