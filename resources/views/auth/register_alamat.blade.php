<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Alamat - CikalTas</title>

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

.form-input, .form-select, .form-textarea {
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
.form-select {
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 14px center;
    background-size: 16px;
    padding-right: 40px;
}
.form-textarea {
    resize: vertical;
    min-height: 80px;
    padding-left: 14px; /* no icon for textarea */
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: #8b6340;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(139, 99, 64, 0.1);
}
.form-input::placeholder, .form-textarea::placeholder { color: #bbb; }

.error-text {
    color: #c62828;
    font-size: 12px;
    margin-top: 5px;
    display: none;
}
.error-text.show { display: block; }

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
            <div class="step">
                <div class="step-dot" style="background:#fff;color:#8b6340;">✓</div>
                <span>Akun</span>
            </div>
            <div class="step-line" style="background:#fff;"></div>
            <div class="step active">
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

        <div class="form-header">
            <p class="form-step-label">Step 2 of 2</p>
            <h2 class="form-title">Alamat Pengiriman</h2>
            <p class="form-subtitle">Lengkapi detail alamat Anda untuk pengiriman tas eksklusif CikalTas.</p>
        </div>

        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="alamatForm" action="{{ route('register.step2') }}" method="POST">
            @csrf

            <!-- No Telp -->
            <div class="form-group">
                <label class="form-label" for="nomor_telepon">Nomor Telepon</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <input type="text" id="nomor_telepon" name="nomor_telepon" class="form-input" value="{{ old('nomor_telepon') }}" placeholder="Contoh: 081234567890">
                </div>
                <p class="error-text" id="notelpError"></p>
            </div>

            <!-- Provinsi -->
            <div class="form-group">
                <label class="form-label" for="provinsi">Provinsi</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <select id="provinsi" class="form-select">
                        <option value="">Pilih Provinsi</option>
                    </select>
                </div>
                <p class="error-text" id="provinsiError"></p>
            </div>

            <!-- Kota -->
            <div class="form-group">
                <label class="form-label" for="kota">Kabupaten/Kota</label>
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <select id="kota" class="form-select" disabled>
                        <option value="">Pilih Kota/Kabupaten</option>
                    </select>
                </div>
                <p class="error-text" id="kotaError"></p>
            </div>

            <!-- Alamat Lengkap -->
            <div class="form-group">
                <label class="form-label" for="alamat_jalan">Alamat Lengkap</label>
                <textarea id="alamat_jalan" name="alamat_jalan" class="form-textarea" placeholder="Detail alamat Anda (contoh: Patokan, No. Rumah)">{{ old('alamat_jalan') }}</textarea>
                <p class="error-text" id="alamatError"></p>
            </div>
            
            <input type="hidden" name="provinsi_kota" id="provinsi_kota">

            <button type="submit" class="btn-submit" id="submitBtn">
                Daftar Sekarang
            </button>
        </form>

    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Load provinces
    fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', {
        headers: { 'Accept': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        const provinsiSelect = document.getElementById('provinsi');
        data.forEach(prov => {
            const option = document.createElement('option');
            option.value = prov.id;
            option.textContent = prov.name;
            provinsiSelect.appendChild(option);
        });
    })
    .catch(error => console.error('Error fetching provinsi:', error));

    // Load cities when province changes
    document.getElementById('provinsi').addEventListener('change', function() {
        const provId = this.value;
        const kotaSelect = document.getElementById('kota');
        
        kotaSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
        kotaSelect.disabled = true;

        if (provId) {
            fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                data.forEach(kota => {
                    const option = document.createElement('option');
                    option.value = kota.id;
                    option.textContent = kota.name;
                    kotaSelect.appendChild(option);
                });
                kotaSelect.disabled = false;
            })
            .catch(error => console.error('Error fetching kota:', error));
        }
    });

    document.getElementById('alamatForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const notelp = document.getElementById('nomor_telepon').value.trim();
        const prov = document.getElementById('provinsi').value;
        const kota = document.getElementById('kota').value;
        
        const errors = { notelpError: '', provinsiError: '', kotaError: '' };

        if (!notelp) errors.notelpError = 'Nomor telepon harus diisi.';
        else if (notelp.length < 10) errors.notelpError = 'Nomor telepon minimal 10 digit.';
        
        if (!prov) errors.provinsiError = 'Provinsi harus dipilih.';
        if (!kota) errors.kotaError = 'Kota/Kabupaten harus dipilih.';

        let hasError = false;
        Object.entries(errors).forEach(([id, msg]) => {
            const el = document.getElementById(id);
            if (msg) { el.textContent = msg; el.classList.add('show'); hasError = true; }
            else { el.classList.remove('show'); }
        });

        if (!hasError) {
            // Set hidden field provinsi_kota
            const provName = document.getElementById('provinsi').options[document.getElementById('provinsi').selectedIndex].text;
            const kotaName = document.getElementById('kota').options[document.getElementById('kota').selectedIndex].text;
            document.getElementById('provinsi_kota').value = kotaName + ', ' + provName;

            const btn = document.getElementById('submitBtn');
            btn.textContent = 'Memproses...';
            btn.disabled = true;
            this.submit();
        }
    });
</script>
</body>
</html>
