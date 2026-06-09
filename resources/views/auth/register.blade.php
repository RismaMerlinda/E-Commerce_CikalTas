<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Daftar Akun - CikalTas</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

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

.brand-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 36px;
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
    font-size: 32px;
    font-weight: 700;
    line-height: 1.3;
    margin-bottom: 14px;
    text-shadow: 0 2px 12px rgba(0,0,0,0.2);
}

.left-content p {
    font-size: 14px;
    color: rgba(255,255,255,0.8);
    line-height: 1.7;
    max-width: 300px;
    margin: 0 auto 32px;
}

.left-bag-img {
    width: 200px;
    height: 220px;
    object-fit: cover;
    border-radius: 16px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    border: 3px solid rgba(255,255,255,0.15);
    transform: rotate(-3deg);
    transition: transform 0.4s ease;
}
.left-bag-img:hover { transform: rotate(0deg) scale(1.02); }

/* Steps indicator */
.steps {
    display: flex;
    gap: 8px;
    justify-content: center;
    margin-top: 30px;
}
.step {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: rgba(255,255,255,0.7);
}
.step-dot {
    width: 24px; height: 24px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    border: 1.5px solid rgba(255,255,255,0.4);
    display: flex; align-items: center; justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: #fff;
}
.step.active .step-dot {
    background: #fff;
    color: #8b6340;
}
.step-line {
    width: 20px;
    height: 1.5px;
    background: rgba(255,255,255,0.3);
}

/* Right Panel */
.right-panel {
    width: 100%;
    max-width: 520px;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: 40px 32px;
    background: #fff;
    box-shadow: -10px 0 40px rgba(0,0,0,0.04);
    overflow-y: auto;
}
@media (min-width: 900px) { .right-panel { min-height: 100vh; align-items: center; } }

.form-container {
    width: 100%;
    max-width: 400px;
    padding: 20px 0;
}

.mobile-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    justify-content: center;
    margin-bottom: 28px;
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

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #888;
    text-decoration: none;
    margin-bottom: 24px;
    transition: color 0.2s;
}
.back-link:hover { color: #8b6340; }
.back-link svg { width: 14px; height: 14px; }

.form-header {
    margin-bottom: 28px;
}
.form-step-label {
    font-size: 11px;
    font-weight: 600;
    color: #8b6340;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    margin-bottom: 8px;
}
.form-title {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 700;
    color: #2d2d2d;
    margin-bottom: 6px;
}
.form-subtitle { font-size: 14px; color: #888; line-height: 1.5; }

/* Error box */
.error-box {
    background: #fff5f5;
    border: 1px solid #fecaca;
    color: #c62828;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 20px;
}
.error-box ul { margin: 4px 0 0 16px; }

.form-group { margin-bottom: 18px; }

.form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #3e2a1c;
    margin-bottom: 7px;
    letter-spacing: 0.2px;
}

.input-wrapper { position: relative; }

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
    padding: 12px 14px 12px 42px;
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
    margin-top: 5px;
    display: none;
}
.error-text.show { display: block; }

/* Password strength */
.password-strength {
    margin-top: 8px;
    display: none;
}
.strength-bar {
    height: 4px;
    border-radius: 4px;
    background: #e8e2da;
    overflow: hidden;
    margin-bottom: 4px;
}
.strength-fill {
    height: 100%;
    border-radius: 4px;
    transition: width 0.3s, background 0.3s;
    width: 0%;
}
.strength-text { font-size: 11px; color: #888; }

/* Submit */
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
    box-shadow: 0 4px 15px rgba(107, 75, 43, 0.3);
    margin-top: 8px;
}
.btn-submit:hover {
    background: linear-gradient(135deg, #5a3f25 0%, #7a5535 100%);
    box-shadow: 0 6px 20px rgba(107, 75, 43, 0.4);
    transform: translateY(-1px);
}
.btn-submit:active { transform: translateY(0); }

.divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 22px 0;
}
.divider-line { flex: 1; height: 1px; background: #e8e2da; }
.divider-text { font-size: 12px; color: #aaa; white-space: nowrap; }

.login-link {
    text-align: center;
    font-size: 14px;
    color: #666;
}
.login-link a { color: #8b6340; font-weight: 700; text-decoration: none; }
.login-link a:hover { text-decoration: underline; }
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

        <h1>Mulai Perjalanan<br>Gaya Anda Bersama<br>CikalTas</h1>
        <p>Bergabunglah dengan ribuan pelanggan yang telah menemukan tas impian mereka di CikalTas.</p>

        <img src="{{ asset('gambar/hero_bag.png') }}" 
             alt="Tote Bag" class="left-bag-img">

        <div class="steps">
            <div class="step active">
                <div class="step-dot">1</div>
                <span>Akun</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-dot">2</div>
                <span>Alamat</span>
            </div>
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

        <a href="/" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke beranda
        </a>

        <div class="form-header">
            <p class="form-step-label">Step 1 of 2</p>
            <h2 class="form-title">Buat Akun Baru</h2>
            <p class="form-subtitle">Isi data di bawah ini untuk membuat akun CikalTas Anda.</p>
        </div>

        @if (session('error'))
            <div class="error-box">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="registerForm" action="{{ route('register.step1') }}" method="POST">
            @csrf

            <!-- Nama Lengkap -->
            <div class="form-group">
                <label class="form-label" for="nama">Nama Lengkap</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <input type="text" id="nama" name="nama_lengkap" class="form-input" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" autofocus>
                </div>
                <p class="error-text" id="namaError"></p>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <input type="text" id="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="nama@email.com">
                </div>
                <p class="error-text" id="emailError"></p>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label class="form-label" for="password">Kata Sandi</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Min. 6 karakter" oninput="checkStrength(this.value)">
                    <button type="button" class="password-toggle" onclick="togglePwd('password', this)">
                        <svg class="eye-closed" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        <svg class="eye-open" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                </div>
                <div class="password-strength" id="strengthContainer">
                    <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                    <p class="strength-text" id="strengthText"></p>
                </div>
                <p class="error-text" id="passwordError"></p>
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group">
                <label class="form-label" for="password2">Konfirmasi Kata Sandi</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <input type="password" id="password2" name="password_confirmation" class="form-input" placeholder="Ulangi kata sandi">
                    <button type="button" class="password-toggle" onclick="togglePwd('password2', this)">
                        <svg class="eye-closed" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        <svg class="eye-open" style="display:none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                </div>
                <p class="error-text" id="password2Error"></p>
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">
                Lanjut ke Langkah Berikutnya →
            </button>
        </form>

        <div class="divider">
            <div class="divider-line"></div>
            <span class="divider-text">Sudah punya akun?</span>
            <div class="divider-line"></div>
        </div>

        <p class="login-link">
            <a href="{{ route('login') }}">Masuk ke akun Anda</a>
        </p>
    </div>
</div>

<script>
function togglePwd(id, btn) {
    const input = document.getElementById(id);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    
    const eyeClosed = btn.querySelector('.eye-closed');
    const eyeOpen = btn.querySelector('.eye-open');
    if (eyeClosed && eyeOpen) {
        eyeClosed.style.display = isHidden ? 'none' : 'block';
        eyeOpen.style.display = isHidden ? 'block' : 'none';
    }
}

function checkStrength(val) {
    const container = document.getElementById('strengthContainer');
    const fill = document.getElementById('strengthFill');
    const text = document.getElementById('strengthText');
    
    if (!val) { container.style.display = 'none'; return; }
    container.style.display = 'block';
    
    let score = 0;
    if (val.length >= 6) score++;
    if (val.length >= 10) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = [
        { pct: '20%', color: '#ef4444', label: 'Sangat Lemah' },
        { pct: '40%', color: '#f97316', label: 'Lemah' },
        { pct: '60%', color: '#eab308', label: 'Cukup' },
        { pct: '80%', color: '#22c55e', label: 'Kuat' },
        { pct: '100%', color: '#16a34a', label: 'Sangat Kuat' },
    ];
    const level = levels[Math.min(score - 1, 4)] || levels[0];
    fill.style.width = level.pct;
    fill.style.background = level.color;
    text.textContent = `Kekuatan: ${level.label}`;
    text.style.color = level.color;
}

document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const nama = document.getElementById('nama').value.trim();
    const email = document.getElementById('email').value.trim();
    const pass = document.getElementById('password').value.trim();
    const pass2 = document.getElementById('password2').value.trim();

    const errors = {
        namaError: '', emailError: '', passwordError: '', password2Error: ''
    };

    if (!nama) errors.namaError = 'Nama lengkap harus diisi.';
    if (!email) errors.emailError = 'Email harus diisi.';
    else if (!email.includes('@') || !email.includes('.')) errors.emailError = 'Format email tidak valid.';
    if (pass.length < 6) errors.passwordError = 'Kata sandi minimal 6 karakter.';
    if (!pass2) errors.password2Error = 'Konfirmasi kata sandi harus diisi.';
    else if (pass !== pass2) errors.password2Error = 'Kata sandi tidak sama.';

    let hasError = false;
    Object.entries(errors).forEach(([id, msg]) => {
        const el = document.getElementById(id);
        if (msg) { el.textContent = msg; el.classList.add('show'); hasError = true; }
        else { el.classList.remove('show'); }
    });

    if (!hasError) {
        const btn = document.getElementById('submitBtn');
        btn.textContent = 'Memproses...';
        btn.disabled = true;
        this.submit();
    }
});

window.addEventListener('pageshow', e => { if (e.persisted) window.location.reload(); });
</script>
</body>
</html>
