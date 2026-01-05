<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - CikalTas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #cdb59b;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background: #ffffff;
            width: 100%;
            max-width: 430px;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            width: 85px;
        }

        .title {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            font-size: 22px;
            font-weight: 700;
            color: #3e2a1c;
            margin-bottom: 4px;
        }

        .icon-lock {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .subtitle {
            text-align: center;
            font-size: 13px;
            color: #666;
            margin-bottom: 22px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #3e2a1c;
            margin-bottom: 6px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d7d7d7;
            border-radius: 8px;
            background: #f4f5f7;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #6b4b2b;
        }

        .error-text {
            color: #c62828;
            font-size: 13px;
            margin-top: 6px;
            display: none;
        }

        .server-error {
            color: #c62828;
            font-size: 13px;
            margin-bottom: 10px;
            text-align: center;
            background: #f8d7da;
            padding: 10px;
            border-radius: 8px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #6b4b2b;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        button:hover {
            background: #5a3f25;
        }

        .text-link {
            font-size: 13px;
            text-align: center;
            margin-top: 15px;
        }

        .text-link a {
            color: #6b4b2b;
            font-weight: 600;
            text-decoration: none;
        }

        .text-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('gambar/Logo.png') }}" alt="Logo">
        </div>

        <h2 class="title">
            <img src="/gambar/login.jpeg" alt="lock" class="icon-lock">
            Reset Password
        </h2>

        <p class="subtitle">
            Masukkan password baru Anda
        </p>

        @if($errors->any())
            <div class="server-error">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form id="resetForm" method="POST" action="{{ route('password.update.custom') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email_display" value="{{ $email }}" disabled style="background: #e9ecef; cursor: not-allowed;">
            </div>

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" placeholder="Minimal 6 karakter">
                <p class="error-text" id="passwordError"></p>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                <p class="error-text" id="password2Error"></p>
            </div>

            <button type="submit">Reset Password</button>
        </form>

        <p class="text-link">
            Ingat password Anda?
            <a href="{{ route('login') }}">Login di sini</a>
        </p>
    </div>

    <script>
        const resetForm = document.getElementById("resetForm");

        resetForm.addEventListener("submit", function(e) {
            const pass = document.getElementById("password").value.trim();
            const pass2 = document.getElementById("password_confirmation").value.trim();

            const passErr = document.getElementById("passwordError");
            const pass2Err = document.getElementById("password2Error");

            passErr.style.display = "none";
            pass2Err.style.display = "none";

            let errorDetected = false;

            if (pass.length < 6) {
                e.preventDefault();
                passErr.innerHTML = "Password minimal 6 karakter.";
                passErr.style.display = "block";
                errorDetected = true;
            }

            if (pass2 === "") {
                e.preventDefault();
                pass2Err.innerHTML = "Konfirmasi password wajib diisi.";
                pass2Err.style.display = "block";
                errorDetected = true;
            } else if (pass !== pass2) {
                e.preventDefault();
                pass2Err.innerHTML = "Konfirmasi password tidak sama.";
                pass2Err.style.display = "block";
                errorDetected = true;
            }
        });
    </script>
</body>
</html>