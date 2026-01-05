<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun • CikalTas</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

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
            text-align: center;
        }

        .logo img {
            width: 95px;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .subtitle {
            font-size: 13px;
            color: #5d5d5d;
            margin-bottom: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }

        .form-group {
            width: 100%;
            margin-bottom: 16px;
            text-align: left;
        }

        .label {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
            display: block;
            color: #333;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #d1d3e2;
            background-color: #f8f9fc;
            /* warna biru muda seperti contoh */
            font-size: 14px;
            color: #333;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #A67C52;
            background-color: #ffffff;
        }

        .error-text {
            color: #c62828;
            font-size: 13px;
            margin-top: 6px;
            display: none;
        }

        .btn-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .btn {
            background: #A67C52;
            color: #fff;
            padding: 12px 22px;
            border-radius: 12px;
            font-size: 15px;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #8a6644;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">

            <div class="logo">
                <img src="{{ asset('gambar/Logo.png') }}" alt="Logo">
            </div>

            <h2>Daftar Akun</h2>

            <p class="subtitle">
                👜 Daftar sekarang, pilih tas impianmu!
            </p>

            <form id="registerForm" action="{{ route('register.step1') }}" method="POST">
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

                <!-- NAMA -->
                <div class="form-group">
                    <label for="nama" class="label">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama_lengkap">
                    <p class="error-text" id="namaError"></p>
                </div>

                <!-- EMAIL -->
                <div class="form-group">
                    <label for="email" class="label">Email</label>
                    <input type="text" id="email" name="email">
                    <p class="error-text" id="emailError"></p>
                </div>

                <!-- PASSWORD -->
                <div class="form-group">
                    <label for="password" class="label">Kata Sandi (min. 6 karakter)</label>
                    <input type="password" id="password" name="password">
                    <p class="error-text" id="passwordError"></p>
                </div>

                <!-- KONFIRMASI PASSWORD -->
                <div class="form-group">
                    <label for="password2" class="label">Konfirmasi Kata Sandi</label>
                    <input type="password" id="password2" name="password_confirmation">
                    <p class="error-text" id="password2Error"></p>
                </div>

                <div class="btn-container">
                    <button class="btn" type="submit">Selanjutnya</button>
                </div>

                <p style="margin-top: 18px; font-size: 14px;">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" style="color:#A67C52; font-weight:600;">
                        Masuk di sini
                    </a>
                </p>


            </form>

        </div>
    </div>

    <!-- VALIDASI JS -->
    <script>
        const form = document.getElementById("registerForm");

        form.addEventListener("submit", function(e) {
            e.preventDefault();

            const nama = document.getElementById("nama").value.trim();
            const email = document.getElementById("email").value.trim();
            const pass = document.getElementById("password").value.trim();
            const pass2 = document.getElementById("password2").value.trim();

            const namaErr = document.getElementById("namaError");
            const emailErr = document.getElementById("emailError");
            const passErr = document.getElementById("passwordError");
            const pass2Err = document.getElementById("password2Error");

            namaErr.style.display = "none";
            emailErr.style.display = "none";
            passErr.style.display = "none";
            pass2Err.style.display = "none";

            let errorDetected = false;

            // VALIDASI NAMA
            if (nama === "") {
                namaErr.innerHTML = "Nama lengkap harus diisi.";
                namaErr.style.display = "block";
                errorDetected = true;
            }

            // VALIDASI EMAIL
            if (email === "") {
                emailErr.innerHTML = "Email harus diisi.";
                emailErr.style.display = "block";
                errorDetected = true;

            } else if (!email.includes("@") || !email.includes(".")) {
                emailErr.innerHTML = "Format email belum benar.";
                emailErr.style.display = "block";
                errorDetected = true;
            }

            // VALIDASI PASSWORD
            if (pass.length < 6) {
                passErr.innerHTML = "Kata sandi minimal 6 karakter.";
                passErr.style.display = "block";
                errorDetected = true;
            }

            // VALIDASI KONFIRMASI
            if (pass2 === "") {
                pass2Err.innerHTML = "Konfirmasi kata sandi harus diisi.";
                pass2Err.style.display = "block";
                errorDetected = true;

            } else if (pass !== pass2) {
                pass2Err.innerHTML = "Konfirmasi kata sandi tidak sama.";
                pass2Err.style.display = "block";
                errorDetected = true;
            }

            if (!errorDetected) {
                // Submit form secara normal (bukan via AJAX)
                form.submit();
            }
        });

        // Handle CSRF token expiration
        window.addEventListener('pageshow', function(event) {
            // Refresh page jika user kembali dari halaman lain (untuk refresh CSRF token)
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>

</body>

</html>

</html>
