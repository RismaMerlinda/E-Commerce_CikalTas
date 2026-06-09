<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Masuk - CikalTas</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet" />

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Inter', sans-serif;
    min-height: 100vh;
    display: flex;
    background: #f8f6f2;
}

/* Left Panel */
.left-panel {
    flex: 1;
    display: none;
    background: linear-gradient(135deg, #5c3d2e 0%, #8b6340 50%, #c4956a 100%);
    position: relative;
    overflow: hidden;
}
@media (min-width: 900px) { .left-panel { display: flex; align-items: center; justify-content: center; flex-direction: column; } }

.left-panel::before {
    content: '';
    position: absolute;
    top: -80px; left: -80px;
    width: 350px; height: 350px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
}
.left-panel::after {
    content: '';
    position: absolute;
    bottom: -100px; right: -80px;
    width: 420px; height: 420px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}

.left-content {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 40px;
    color: #fff;
}

.left-content .brand-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 48px;
}

.brand-icon {
    width: 40px; height: 40px;
    background: rgba(255,255,255,0.2);
    border: 2px solid rgba(255,255,255,0.5);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    transform: rotate(45deg);
}

.brand-icon-inner {
    width: 18px; height: 18px;
    border: 2px solid #fff;
    border-radius: 2px;
    transform: rotate(-45deg);
}

.left-content h1 {
    font-family: 'Playfair Display', serif;
    font-size: 36px;
    font-weight: 700;
    line-height: 1.25;
    margin-bottom: 16px;
    text-shadow: 0 2px 12px rgba(0,0,0,0.2);
}

.left-content p {
    font-size: 15px;
    color: rgba(255,255,255,0.8);
    line-height: 1.7;
    max-width: 320px;
    margin: 0 auto 40px;
}

.left-bag-img {
    width: 240px;
    height: 260px;
    object-fit: cover;
    border-radius: 20px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.3);
    border: 3px solid rgba(255,255,255,0.15);
    transform: rotate(-3deg);
    transition: transform 0.4s ease;
}
.left-bag-img:hover { transform: rotate(0deg) scale(1.02); }

.left-badges {
    display: flex;
    gap: 12px;
    justify-content: center;
    margin-top: 36px;
    flex-wrap: wrap;
}
.badge {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    backdrop-filter: blur(8px);
    padding: 8px 16px;
    border-radius: 30px;
    font-size: 12px;
    color: #fff;
    font-weight: 500;
}

/* Right Panel */
.right-panel {
    width: 100%;
    max-width: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 32px;
    background: #fff;
    box-shadow: -10px 0 40px rgba(0,0,0,0.04);
}
@media (min-width: 900px) { .right-panel { min-height: 100vh; } }

.form-container {
    width: 100%;
    max-width: 380px;
}

.mobile-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    justify-content: center;
    margin-bottom: 32px;
}
@media (min-width: 900px) { .mobile-brand { display: none; } }

.mobile-brand-icon {
    width: 36px; height: 36px;
    background: #8b6340;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    transform: rotate(45deg);
}
.mobile-brand-icon-inner {
    width: 16px; height: 16px;
    border: 2px solid #fff;
    border-radius: 2px;
    transform: rotate(-45deg);
}

.form-header {
    margin-bottom: 32px;
}

.welcome-back {
    font-size: 12px;
    font-weight: 600;
    color: #8b6340;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.form-title {
    font-family: 'Playfair Display', serif;
    font-size: 30px;
    font-weight: 700;
    color: #2d2d2d;
    margin-bottom: 8px;
}

.form-subtitle {
    font-size: 14px;
    color: #888;
    line-height: 1.5;
}

/* Back to landing */
.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #888;
    text-decoration: none;
    margin-bottom: 28px;
    transition: color 0.2s;
}
.back-link:hover { color: #8b6340; }
.back-link svg { width: 14px; height: 14px; }

/* Form Styles */
.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #3e2a1c;
    margin-bottom: 8px;
    letter-spacing: 0.3px;
}

.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px; height: 18px;
    color: #aaa;
    pointer-events: none;
}

.form-input {
    display: block;
    width: 100%;
    padding: 13px 14px 13px 42px;
    border: 1.5px solid #e8e2da;
    border-radius: 10px;
    background: #faf9f7;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    color: #2d2d2d;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    outline: none;
}
.form-input:focus {
    border-color: #8b6340;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(139, 99, 64, 0.1);
}
.form-input::placeholder { color: #bbb; }

.password-toggle {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #aaa;
    background: none;
    border: none;
    padding: 0;
    width: 18px; height: 18px;
    display: flex; align-items: center; justify-content: center;
    transition: color 0.2s;
}
.password-toggle:hover { color: #8b6340; }
.password-toggle svg { width: 18px; height: 18px; }

.error-text {
    color: #c62828;
    font-size: 12px;
    margin-top: 6px;
    display: none;
}
.error-text.show { display: block; }
.server-error { color: #c62828; font-size: 12px; margin-top: 6px; }
.success-msg {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #16a34a;
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 13px;
    margin-bottom: 20px;
    text-align: center;
}

.remember-forgot {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 13px;
    color: #666;
    user-select: none;
}
.checkbox-label input[type="checkbox"] {
    width: 16px; height: 16px;
    accent-color: #8b6340;
    cursor: pointer;
}

.forgot-link {
    font-size: 13px;
    color: #8b6340;
    font-weight: 600;
    text-decoration: none;
}
.forgot-link:hover { text-decoration: underline; }

/* Submit Button */
.btn-submit {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #6b4b2b 0%, #8b6340 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-family: 'Inter', sans-serif;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    letter-spacing: 0.3px;
    box-shadow: 0 4px 15px rgba(107, 75, 43, 0.3);
    position: relative;
    overflow: hidden;
}
.btn-submit:hover {
    background: linear-gradient(135deg, #5a3f25 0%, #7a5535 100%);
    box-shadow: 0 6px 20px rgba(107, 75, 43, 0.4);
    transform: translateY(-1px);
}
.btn-submit:active { transform: translateY(0); }

/* Divider */
.divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 24px 0;
}
.divider-line { flex: 1; height: 1px; background: #e8e2da; }
.divider-text { font-size: 12px; color: #aaa; white-space: nowrap; }

/* Register Link */
.register-link {
    text-align: center;
    font-size: 14px;
    color: #666;
}
.register-link a {
    color: #8b6340;
    font-weight: 700;
    text-decoration: none;
}
.register-link a:hover { text-decoration: underline; }
</style>
</head>
<body>

<!-- Left Decorative Panel -->
<div class="left-panel">
    <div class="left-content">
        <div class="brand-logo">
            <div class="brand-icon"><div class="brand-icon-inner"></div></div>
            <span style="font-family:'Inter',sans-serif;font-weight:700;font-size:22px;letter-spacing:-0.5px;">CikalTas</span>
        </div>

        <h1>Premium Bags<br>for Modern Lifestyle</h1>
        <p>Discover our exclusive collection of handcrafted bags designed for elegance, quality, and functionality.</p>

        <img src="{{ asset('gambar/hero_bag.png') }}" 
             alt="Premium Handbag" class="left-bag-img">

        <div class="left-badges">
            <span class="badge">Premium Quality</span>
            <span class="badge">Free Shipping</span>
            <span class="badge">Secure Payment</span>
        </div>
    </div>
</div>

<!-- Right Form Panel -->
<div class="right-panel">
    <div class="form-container">

        <!-- Mobile Brand -->
        <div class="mobile-brand">
            <div class="mobile-brand-icon"><div class="mobile-brand-icon-inner"></div></div>
            <span style="font-weight:700;font-size:20px;color:#2d2d2d;font-family:'Inter',sans-serif;">CikalTas</span>
        </div>

        <!-- Back link -->
        <a href="/" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke beranda
        </a>

        <!-- Header -->
        <div class="form-header">
            <p class="welcome-back">Welcome Back</p>
            <h2 class="form-title">Login ke CikalTas</h2>
            <p class="form-subtitle">Masukkan akun Anda untuk melanjutkan belanja.</p>
        </div>

        @if(session('status'))
            <div class="success-msg">{{ session('status') }}</div>
        @endif
        @if(session('success'))
            <div class="success-msg">{{ session('success') }}</div>
        @endif

        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="nama@email.com" autofocus />
                </div>
                <p class="error-text" id="emailError"></p>
                @error('email')
                    <p class="server-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label" for="password">Kata Sandi</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Masukkan kata sandi" />
                    <button type="button" class="password-toggle" id="togglePassword">
                        <svg id="eyeClosed" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        <svg id="eyeOpen" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                </div>
                <p class="error-text" id="passwordError"></p>
                @error('password')
                    <p class="server-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember & Forgot -->
            <div class="remember-forgot">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember" />
                    Ingat saya
                </label>
                <a href="{{ route('password.request.custom') }}" class="forgot-link">Lupa kata sandi?</a>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-submit" id="submitBtn">Masuk ke Akun</button>
        </form>

        <div class="divider">
            <div class="divider-line"></div>
            <span class="divider-text">Belum punya akun?</span>
            <div class="divider-line"></div>
        </div>

        <p class="register-link">
            <a href="{{ route('register') }}">Daftar Sekarang — Gratis!</a>
        </p>
    </div>
</div>

<script>
    // Password toggle
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');

    togglePassword.addEventListener('click', () => {
        const isHidden = passwordInput.type === 'password';
        passwordInput.type = isHidden ? 'text' : 'password';
        eyeClosed.style.display = isHidden ? 'none' : 'block';
        eyeOpen.style.display = isHidden ? 'block' : 'none';
    });

    // Form validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('email').value.trim();
        const pass = document.getElementById('password').value.trim();
        const emailErr = document.getElementById('emailError');
        const passErr = document.getElementById('passwordError');

        emailErr.classList.remove('show');
        passErr.classList.remove('show');

        let hasError = false;

        if (!email) {
            emailErr.textContent = 'Email wajib diisi.';
            emailErr.classList.add('show');
            hasError = true;
        } else if (!email.includes('@') || !email.includes('.')) {
            emailErr.textContent = 'Format email tidak valid.';
            emailErr.classList.add('show');
            hasError = true;
        }

        if (!pass) {
            passErr.textContent = 'Kata sandi wajib diisi.';
            passErr.classList.add('show');
            hasError = true;
        }

        if (!hasError) {
            const btn = document.getElementById('submitBtn');
            btn.textContent = 'Memproses...';
            btn.disabled = true;
            this.submit();
        }
    });
</script>
</body>
</html>
