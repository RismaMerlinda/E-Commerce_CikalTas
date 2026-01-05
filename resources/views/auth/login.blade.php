<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Masuk - CikalTas</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />

<style>
*,
*::before,
*::after {
    box-sizing: border-box;
}

/* ===== BODY ===== */
body {
    margin: 0;
    padding: 0;
    background: #cdb59b;
    font-family: 'Poppins', sans-serif;
}

/* ===== CONTAINER ===== */
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    padding: 20px;
}

/* ===== CARD ===== */
.card {
    background: #ffffff;
    width: 430px;
    padding: 35px;
    border-radius: 18px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

/* ===== LOGO ===== */
.logo {
    text-align: center;
    margin-bottom: 10px;
}

.logo img {
    width: 85px;
}

/* ===== TITLE WITH ICON ===== */
.title-login {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px; /* jarak icon & text */
    font-size: 22px;
    font-weight: 700;
    color: #3e2a1c;
    margin-bottom: 4px;
}

.icon-lock {
    width: 50px;   /* ukurannya diperbesar */
    height: 50px;
    object-fit: contain;
}


/* ===== SUBTITLE ===== */
.subtitle {
    text-align: center;
    font-size: 13px;
    color: #666;
    margin-bottom: 22px;
}

/* ===== FORM ===== */
form {
    width: 100%;
}

.form-group {
    width: 100%;
    margin-bottom: 18px;
}

label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #3e2a1c;
    margin-bottom: 6px;
}

/* ===== INPUT ===== */
input[type="email"],
input[type="password"] {
    display: block;
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #d7d7d7;
    border-radius: 8px;
    background: #f4f5f7;
    font-size: 14px;
    margin: 0;
}

/* ===== REMEMBER & FORGOT ===== */
.remember-forgot {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    font-size: 14px;
    color: #3e2a1c;
}

.remember-forgot label {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.remember-forgot input[type="checkbox"] {
    margin-right: 6px;
}

.forgot-link {
    color: #6b4b2b;
    text-decoration: none;
    font-weight: 600;
}

.forgot-link:hover {
    text-decoration: underline;
}

/* ===== ERROR ===== */
.error-text {
    color: #c62828;
    font-size: 13px;
    margin-top: 6px;
    text-align: left;
}

.client-error {
    display: none;
}

/* ===== SUCCESS ===== */
.success-text {
    color: green;
    font-size: 13px;
    margin-bottom: 10px;
    text-align: center;
}

/* ===== BUTTON ===== */
.button-wrapper {
    margin-top: 10px;
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
}

button:hover {
    background: #5a3f25;
}

/* ===== LINK ===== */
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
    <div class="card">

        <!-- TITLE DENGAN ICON -->
        <h2 class="title-login">
            <img src="/gambar/login.jpeg" alt="lock" class="icon-lock">
            Login ke CikalTas
        </h2>

        <p class="subtitle">Silakan login untuk melanjutkan</p>

        @if(session('status'))
            <div class="error-text" style="text-align:center; margin-bottom:10px;">
                {{ session('status') }}
            </div>
        @endif

        @if(session('success'))
            <div class="success-text">
                {{ session('success') }}
            </div>
        @endif

        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" autofocus />
                <p class="error-text client-error" id="emailError"></p>
                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" />
                <p class="error-text client-error" id="passwordError"></p>
                @error('password')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-forgot">
                <label>
                    <input type="checkbox" name="remember" />
                    Ingat saya
                </label>
                <a href="{{ route('password.request.custom') }}" class="forgot-link">Lupa kata sandi?</a>
            </div>

            <div class="button-wrapper">
                <button type="submit">Masuk</button>
            </div>
        </form>

        <p class="text-link">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar di sini</a>
        </p>
    </div>
</div>

<script>
    const loginForm = document.getElementById("loginForm");

    loginForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const email = document.getElementById("email").value.trim();
        const pass = document.getElementById("password").value.trim();

        const emailErr = document.getElementById("emailError");
        const passErr = document.getElementById("passwordError");

        emailErr.style.display = "none";
        passErr.style.display = "none";

        let errorDetected = false;

        if (email === "") {
            emailErr.innerHTML = "Email wajib diisi.";
            emailErr.style.display = "block";
            errorDetected = true;
        } else if (!email.includes("@") || !email.includes(".")) {
            emailErr.innerHTML = "Format email belum benar.";
            emailErr.style.display = "block";
            errorDetected = true;
        }

        if (pass === "") {
            passErr.innerHTML = "Kata sandi wajib diisi.";
            passErr.style.display = "block";
            errorDetected = true;
        }

        if (!errorDetected) {
            loginForm.submit();
        }
    });
</script>

</body>
</html>
