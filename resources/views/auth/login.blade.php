<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — Fakultas Teknik UNMUL</title>
  <meta name="description" content="Halaman login Fakultas Teknik Universitas Mulawarman">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      scrollbar-width: none;
      -ms-overflow-style: none;
    }
    *::-webkit-scrollbar {
      display: none;
      width: 0;
      height: 0;
    }
    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: #0f172a;
      padding: 24px 16px;
      position: relative;
      overflow-x: hidden;
      scrollbar-width: none;
      -ms-overflow-style: none;
    }
    .video-bg-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      z-index: 0;
      overflow: hidden;
      pointer-events: none;
    }
    .bg-video {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: blur(5px);
      transform: scale(1.06);
    }
    .video-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      z-index: 1;
      background: radial-gradient(circle at center, rgba(15, 23, 42, 0.72) 0%, rgba(15, 23, 42, 0.93) 100%);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
    }
    .auth-wrapper {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 440px;
      margin: auto;
    }
    .auth-card {
      background: #ffffff;
      border-radius: 24px;
      padding: 36px 32px 32px;
      box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.2);
    }
    .auth-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 22px;
    }
    .auth-logo img { height: 42px; width: auto; object-fit: contain; }
    .auth-logo-text { display: flex; flex-direction: column; line-height: 1.2; }
    .auth-logo-text .l1 { font-size: 0.82rem; font-weight: 800; color: #0f172a; letter-spacing: 0.03em; text-transform: uppercase; }
    .auth-logo-text .l2 { font-size: 0.72rem; font-weight: 800; color: #475569; letter-spacing: 0.02em; text-transform: uppercase; }
    .auth-title { font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .auth-subtitle { font-size: 0.85rem; color: #64748b; margin-bottom: 22px; }
    .auth-footer-text { text-align: center; margin-top: 22px; font-size: 0.85rem; color: #64748b; }
    .auth-footer-text a { color: #d97706; font-weight: 700; text-decoration: none; }
    .auth-footer-text a:hover { text-decoration: underline; }
  </style>
</head>

<body>
  <!-- Fixed Video Background -->
  <div class="video-bg-container">
    <video class="bg-video" autoplay loop muted playsinline
      poster="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=1920&q=80">
      <source src="{{ asset('fakultas-teknik-universitas-mulawarmanmp4_Al7wZnbtmn.mp4') }}" type="video/mp4">
    </video>
    <div class="video-overlay"></div>
  </div>

  <div class="auth-wrapper">
    <div class="mb-3">
      <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-white/90 hover:text-white bg-slate-900/60 hover:bg-slate-900/90 backdrop-blur-md px-3.5 py-2 rounded-xl border border-white/15 transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        <span>Kembali ke Beranda</span>
      </a>
    </div>    <!-- LOGIN CARD -->
    <div class="auth-card" id="loginCard">
      <div class="auth-logo">
        <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL">
        <div class="auth-logo-text">
          <span class="l1">FAKULTAS TEKNIK</span>
          <span class="l2">UNIVERSITAS MULAWARMAN</span>
        </div>
      </div>
      <h1 class="auth-title">Log In LMS</h1>
      <p class="auth-subtitle">Masukkan email dan password akun Anda</p>

      @if (session('status'))
        <div class="mb-4 text-xs font-semibold text-emerald-700 bg-emerald-50 p-3 rounded-xl border border-emerald-200 flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span>{{ session('status') }}</span>
        </div>
      @endif

      @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="flex items-center gap-1.5">
                      <span class="text-red-500 font-bold">•</span>
                      <span>{{ $error }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
          <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukkan email terdaftar" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
        </div>

        <div>
          <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Password</label>
          <div class="relative">
            <input type="password" id="password" name="password" required minlength="8" autocomplete="current-password" placeholder="Masukkan password (min. 8 karakter)" class="w-full pl-3.5 pr-11 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
            <button type="button" id="togglePassword" onclick="togglePasswordVisibility('password', this)" class="absolute right-0 top-0 h-full px-3.5 flex items-center text-slate-400 hover:text-amber-600 transition focus:outline-none" title="Tampilkan Password" aria-label="Tampilkan Password">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>
        </div>

        <div class="flex items-center justify-between text-xs pt-1">
          <label class="flex items-center gap-2 cursor-pointer select-none">
            <input type="checkbox" name="remember" class="rounded border-slate-300 text-amber-600 focus:ring-amber-500">
            <span class="text-slate-600 font-medium">Ingat Saya</span>
          </label>
          <button type="button" id="btnSwitchToForgot" class="text-amber-700 font-semibold hover:underline bg-transparent border-0 cursor-pointer p-0 text-xs">Lupa password?</button>
        </div>

        <button type="submit" class="w-full py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold rounded-xl shadow-lg shadow-amber-500/25 text-sm transition transform active:scale-[0.99] mt-2 cursor-pointer">
          Log In Sekarang
        </button>
      </form>

      <p class="auth-footer-text">Akun LMS hanya dapat dibuat oleh <strong>Operator Fakultas</strong>. Hubungi operator jika belum memiliki akun.</p>
    </div>

    <!-- FORGOT PASSWORD CARD (IN-PLACE POPUP/VIEW) -->
    <div class="auth-card hidden" id="forgotCard">
      <div class="auth-logo">
        <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL">
        <div class="auth-logo-text">
          <span class="l1">FAKULTAS TEKNIK</span>
          <span class="l2">UNIVERSITAS MULAWARMAN</span>
        </div>
      </div>

      <div class="flex items-center gap-2 mb-1">
        <div class="w-7 h-7 rounded-lg bg-amber-500/10 text-amber-600 flex items-center justify-center font-bold">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
          </svg>
        </div>
        <h2 class="auth-title mb-0 text-xl font-extrabold">Lupa Password?</h2>
      </div>
      <p class="auth-subtitle mb-3 text-xs text-slate-500">Verifikasi akun dengan NIM/NIP & email untuk mereset kata sandi.</p>

      <div id="loginForgotAlert" class="hidden mb-3 p-3 rounded-xl text-xs font-semibold"></div>

      <form id="loginForgotForm" class="space-y-3">
        @csrf

        <!-- Nomor Induk -->
        <div>
          <label for="fgNomerInduk" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nomor Induk (NIM / NIP)</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
              </svg>
            </div>
            <input type="text" id="fgNomerInduk" name="nomer_induk" required placeholder="Contoh: 2109106001 / 19850101..." class="w-full pl-9 pr-3.5 py-2 border border-slate-300 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
          </div>
        </div>

        <!-- Email + Kirim Verifikasi -->
        <div>
          <label for="fgEmail" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Email Terdaftar</label>
          <div class="flex gap-2">
            <div class="relative flex-1">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                </svg>
              </div>
              <input type="email" id="fgEmail" name="email" required placeholder="nama@unmul.ac.id" class="w-full pl-9 pr-2 py-2 border border-slate-300 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
            </div>
            <button type="button" id="btnFgSendCode" class="shrink-0 px-3 py-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold rounded-xl shadow-md shadow-amber-500/20 text-xs whitespace-nowrap transition transform active:scale-[0.98] flex items-center justify-center gap-1.5 cursor-pointer">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
              </svg>
              <span id="btnFgSendCodeText">Kirim Verifikasi</span>
            </button>
          </div>
        </div>

        <!-- Kode Verifikasi (6 Digit) -->
        <div>
          <label for="fgCode" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Kode Verifikasi (6 Digit)</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
            </div>
            <input type="text" id="fgCode" name="code" required maxlength="6" placeholder="Masukkan 6 digit kode dari email" class="w-full pl-9 pr-3.5 py-2 border border-slate-300 rounded-xl text-xs sm:text-sm tracking-widest font-mono font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
          </div>
          <span class="text-[10px] text-slate-400 mt-0.5 block">Klik "Kirim Verifikasi" di atas untuk mendapatkan kode</span>
        </div>

        <!-- Password Baru Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
          <div>
            <label for="fgPassword" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Password Baru</label>
            <div class="relative">
              <input type="password" id="fgPassword" name="password" required minlength="8" placeholder="Min. 8 karakter" class="w-full pl-3 pr-9 py-2 border border-slate-300 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
              <button type="button" onclick="togglePasswordVisibility('fgPassword', this)" class="absolute right-0 top-0 h-full px-2.5 flex items-center text-slate-400 hover:text-amber-600 transition focus:outline-none" title="Tampilkan Password" aria-label="Tampilkan Password">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
            </div>
          </div>

          <div>
            <label for="fgPasswordConfirm" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Konfirmasi Password</label>
            <div class="relative">
              <input type="password" id="fgPasswordConfirm" name="password_confirmation" required minlength="8" placeholder="Ulangi password" class="w-full pl-3 pr-9 py-2 border border-slate-300 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
              <button type="button" onclick="togglePasswordVisibility('fgPasswordConfirm', this)" class="absolute right-0 top-0 h-full px-2.5 flex items-center text-slate-400 hover:text-amber-600 transition focus:outline-none" title="Tampilkan Password" aria-label="Tampilkan Password">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <button type="submit" id="btnFgSubmit" class="w-full py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold rounded-xl shadow-lg shadow-amber-500/25 text-xs sm:text-sm transition transform active:scale-[0.99] mt-1 cursor-pointer">
          Simpan Password Baru
        </button>
      </form>

      <p class="auth-footer-text mt-3">Sudah ingat password? <button type="button" id="btnSwitchToLogin" class="text-amber-700 font-semibold hover:underline bg-transparent border-0 cursor-pointer p-0 text-xs">Masuk di sini</button></p>
    </div>
  </div>

  <script>
    function togglePasswordVisibility(inputId, btn) {
      const input = document.getElementById(inputId);
      if (!input) return;
      const isPassword = input.type === 'password';
      input.type = isPassword ? 'text' : 'password';
      btn.setAttribute('title', isPassword ? 'Sembunyikan Password' : 'Tampilkan Password');
      btn.setAttribute('aria-label', isPassword ? 'Sembunyikan Password' : 'Tampilkan Password');
      btn.innerHTML = isPassword ? `
        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        </svg>
      ` : `
        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
      `;
    }

    // Toggle view antara Login dan Lupa Password
    const loginCard = document.getElementById('loginCard');
    const forgotCard = document.getElementById('forgotCard');
    const btnSwitchToForgot = document.getElementById('btnSwitchToForgot');
    const btnSwitchToLogin = document.getElementById('btnSwitchToLogin');
    const loginForgotAlert = document.getElementById('loginForgotAlert');

    function showLoginAlert(type, msg) {
      if (!loginForgotAlert) return;
      loginForgotAlert.classList.remove('hidden', 'bg-red-50', 'text-red-700', 'border', 'border-red-200', 'bg-emerald-50', 'text-emerald-800', 'border-emerald-200');
      if (type === 'error') {
        loginForgotAlert.classList.add('bg-red-50', 'text-red-700', 'border', 'border-red-200');
      } else {
        loginForgotAlert.classList.add('bg-emerald-50', 'text-emerald-800', 'border', 'border-emerald-200');
      }
      loginForgotAlert.innerHTML = `<span>${msg}</span>`;
    }

    if (btnSwitchToForgot) {
      btnSwitchToForgot.addEventListener('click', () => {
        loginCard.classList.add('hidden');
        forgotCard.classList.remove('hidden');
      });
    }

    if (btnSwitchToLogin) {
      btnSwitchToLogin.addEventListener('click', () => {
        forgotCard.classList.add('hidden');
        loginCard.classList.remove('hidden');
      });
    }

    // AJAX Kirim Kode di Login Page
    const btnFgSendCode = document.getElementById('btnFgSendCode');
    const btnFgSendCodeText = document.getElementById('btnFgSendCodeText');
    const fgNomerInduk = document.getElementById('fgNomerInduk');
    const fgEmail = document.getElementById('fgEmail');
    const fgCode = document.getElementById('fgCode');

    if (btnFgSendCode) {
      btnFgSendCode.addEventListener('click', async () => {
        const nomerInduk = fgNomerInduk ? fgNomerInduk.value.trim() : '';
        const email = fgEmail ? fgEmail.value.trim() : '';

        if (!nomerInduk) {
          showLoginAlert('error', 'Masukkan Nomor Induk (NIM / NIP) terlebih dahulu.');
          if (fgNomerInduk) fgNomerInduk.focus();
          return;
        }
        if (!email) {
          showLoginAlert('error', 'Masukkan Email akun Anda terlebih dahulu.');
          if (fgEmail) fgEmail.focus();
          return;
        }

        btnFgSendCode.disabled = true;
        const orig = btnFgSendCodeText ? btnFgSendCodeText.innerText : 'Kirim Verifikasi';
        if (btnFgSendCodeText) btnFgSendCodeText.innerText = 'Mengirim...';

        try {
          const csrf = document.querySelector('input[name="_token"]')?.value || '';
          const res = await fetch('/forgot-password/send-code', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ email, nomer_induk: nomerInduk }),
          });
          const data = await res.json();
          if (res.ok && data.success) {
            showLoginAlert('success', '✓ ' + data.message);
            if (fgCode) {
              fgCode.focus();
              if (data.code) fgCode.value = data.code;
            }
          } else {
            showLoginAlert('error', data.message || 'Gagal mengirim kode.');
          }
        } catch (e) {
          showLoginAlert('error', 'Terjadi gangguan jaringan.');
        } finally {
          btnFgSendCode.disabled = false;
          if (btnFgSendCodeText) btnFgSendCodeText.innerText = orig;
        }
      });
    }

    // AJAX Reset Password di Login Page
    const loginForgotForm = document.getElementById('loginForgotForm');
    const btnFgSubmit = document.getElementById('btnFgSubmit');
    const fgPassword = document.getElementById('fgPassword');
    const fgPasswordConfirm = document.getElementById('fgPasswordConfirm');

    if (loginForgotForm) {
      loginForgotForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const nomerInduk = fgNomerInduk ? fgNomerInduk.value.trim() : '';
        const email = fgEmail ? fgEmail.value.trim() : '';
        const code = fgCode ? fgCode.value.trim() : '';
        const p1 = fgPassword ? fgPassword.value : '';
        const p2 = fgPasswordConfirm ? fgPasswordConfirm.value : '';

        if (!nomerInduk || !email || !code || !p1 || !p2) {
          showLoginAlert('error', 'Semua kolom formulir wajib diisi.');
          return;
        }
        if (p1.length < 8) {
          showLoginAlert('error', 'Password baru minimal harus 8 karakter.');
          return;
        }
        if (p1 !== p2) {
          showLoginAlert('error', 'Konfirmasi password tidak cocok.');
          return;
        }

        btnFgSubmit.disabled = true;
        btnFgSubmit.innerText = 'Menyimpan...';

        try {
          const csrf = document.querySelector('input[name="_token"]')?.value || '';
          const res = await fetch('/forgot-password/reset-with-code', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ email, nomer_induk: nomerInduk, code, password: p1, password_confirmation: p2 }),
          });
          const data = await res.json();
          if (res.ok && data.success) {
            showLoginAlert('success', data.message);
            setTimeout(() => {
              loginForgotForm.reset();
              forgotCard.classList.add('hidden');
              loginCard.classList.remove('hidden');
              const emailInput = document.getElementById('email');
              if (emailInput) emailInput.value = email;
            }, 1800);
          } else {
            showLoginAlert('error', data.message || 'Gagal mengatur ulang password.');
          }
        } catch (e) {
          showLoginAlert('error', 'Terjadi kesalahan sistem.');
        } finally {
          btnFgSubmit.disabled = false;
          btnFgSubmit.innerText = 'Simpan Password Baru';
        }
      });
    }
  </script>
</body>
</html>
