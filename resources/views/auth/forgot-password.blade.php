<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password - CikalTas</title>
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
            line-height: 1.5;
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

        input[type="email"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d7d7d7;
            border-radius: 8px;
            background: #f4f5f7;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
        }

        input[type="email"]:focus {
            outline: none;
            border-color: #6b4b2b;
        }

        .error-text {
            color: #c62828;
            font-size: 13px;
            margin-top: 6px;
            display: none;
        }

        .success-text {
            color: green;
            font-size: 13px;
            margin-bottom: 10px;
            text-align: center;
            background: #d4edda;
            padding: 10px;
            border-radius: 8px;
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
            Lupa Password
        </h2>

        <p class="subtitle">
            Masukkan email yang terdaftar, dan kami akan mengirimkan link untuk reset password Anda.
        </p>

        @if(session('status'))
            <div class="success-text">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="server-error">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form id="forgotForm" method="POST" action="{{ route('password.email.custom') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email Anda">
                <p class="error-text" id="emailError"></p>
            </div>

            <button type="submit">Kirim Email Reset Password</button>
        </form>

        <p class="text-link">
            Ingat password Anda?
            <a href="{{ route('login') }}">Login di sini</a>
        </p>
    </div>

    <script>
        const forgotForm = document.getElementById("forgotForm");

        forgotForm.addEventListener("submit", function(e) {
            const email = document.getElementById("email").value.trim();
            const emailErr = document.getElementById("emailError");

            emailErr.style.display = "none";

            let errorDetected = false;

            if (email === "") {
                e.preventDefault();
                emailErr.innerHTML = "Email wajib diisi.";
                emailErr.style.display = "block";
                errorDetected = true;
            } else if (!email.includes("@") || !email.includes(".")) {
                e.preventDefault();
                emailErr.innerHTML = "Format email belum benar.";
                emailErr.style.display = "block";
                errorDetected = true;
            }
        });
    </script>
</body>
</html>