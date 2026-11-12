<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk LMS — Fakultas Teknik UNMUL</title>
  <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
  <meta name="description" content="Halaman masuk Learning Management System Fakultas Teknik Universitas Mulawarman">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    (function () {
      try {
        var mode = localStorage.getItem('pkl_theme') || 'light';
        var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        var isDark = mode === 'dark' || (mode === 'system' && prefersDark);
        if (isDark) document.documentElement.classList.add('dark'); else document.documentElement.classList.remove('dark');
      } catch (e) {}
    })();
    tailwind.config = { darkMode: 'class', theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] } } } }
  </script>
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .page-bg {
      background-color: #F8FAFC;
      background-image:
        linear-gradient(to right, rgba(20,83,45,0.06) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(20,83,45,0.06) 1px, transparent 1px);
      background-size: 32px 32px;
    }
    .dark .page-bg {
      background-color: #0B0F19;
      background-image:
        linear-gradient(to right, rgba(148,163,184,0.07) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(148,163,184,0.07) 1px, transparent 1px);
    }
  </style>
</head>
<body class="min-h-screen page-bg text-slate-800 dark:text-slate-100 antialiased">
  <div class="min-h-screen flex flex-col">
    <header class="border-b border-slate-200/80 dark:border-slate-800 bg-white/80 dark:bg-slate-950/70 backdrop-blur">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-3">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
          <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL" class="w-10 h-10 object-contain">
          <div class="leading-tight">
            <div class="text-[11px] font-extrabold tracking-wide uppercase text-slate-900 dark:text-white">Fakultas Teknik</div>
            <div class="text-[10px] font-semibold tracking-wide uppercase text-slate-600 dark:text-slate-400">Universitas Mulawarman</div>
          </div>
        </a>
        <button type="button" onclick="(function(){try{var k='pkl_theme';var next=(document.documentElement.classList.contains('dark')?'light':'dark');localStorage.setItem(k,next);if(next==='dark')document.documentElement.classList.add('dark');else document.documentElement.classList.remove('dark');}catch(e){}})()" class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800" aria-label="Ganti tema" title="Ganti tema">
          <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
          <svg class="w-4 h-4 hidden dark:block" fill="currentColor" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
        </button>
      </div>
    </header>

    <main class="flex-1 flex items-center justify-center px-4 py-10">
      <div class="w-full max-w-md">
        <div class="mb-4">
          <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:text-forest-900 dark:hover:text-emerald-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Beranda
          </a>
        </div>

        <!-- LOGIN CARD -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-6 sm:p-7" id="loginCard">
          <div class="flex items-center gap-3 mb-5">
            <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL" class="w-11 h-11 object-contain">
            <div class="leading-tight">
              <div class="text-xs font-extrabold tracking-wide text-slate-900 dark:text-white uppercase">Fakultas Teknik</div>
              <div class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 uppercase">Universitas Mulawarman</div>
            </div>
          </div>
          <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-emerald-100 text-[#14532D] dark:bg-emerald-500/15 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30 mb-3">Portal Akademik Terpadu</span>
          <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">Masuk LMS</h1>
          <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 mb-5">Masukkan Nomor Induk (NIM/NIP) dan kata sandi akun Anda.</p>

          @if (session('status'))
            <div class="mb-4 text-xs font-semibold text-emerald-700 bg-emerald-50 dark:bg-emerald-500/10 dark:text-emerald-300 p-3 rounded-xl border border-emerald-200 dark:border-emerald-500/30 flex items-center gap-2">
              <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
              <span>{{ session('status') }}</span>
            </div>
          @endif

          @if ($errors->any())
            <div class="mb-4 p-3 bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/30 text-rose-700 dark:text-rose-300 text-xs rounded-xl">
              <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                  <li class="flex items-center gap-1.5"><span class="text-rose-500 font-bold">•</span><span>{{ $error }}</span></li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
              <label for="nomer_induk" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Nomor Induk (NIM / NIP)</label>
              <input type="text" id="nomer_induk" name="nomer_induk" value="{{ old('nomer_induk') }}" required autofocus autocomplete="username" placeholder="Masukkan NIM / NIP Anda" class="w-full px-3.5 py-2.5 border border-slate-300 dark:border-slate-600 rounded-xl text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#14532D]/20 dark:focus:ring-emerald-500/30 focus:border-[#14532D] dark:focus:border-emerald-500 transition">
            </div>
            <div>
              <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Kata Sandi</label>
              <div class="relative">
                <input type="password" id="password" name="password" required minlength="8" autocomplete="current-password" placeholder="Masukkan kata sandi (min. 8 karakter)" class="w-full pl-3.5 pr-11 py-2.5 border border-slate-300 dark:border-slate-600 rounded-xl text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#14532D]/20 dark:focus:ring-emerald-500/30 focus:border-[#14532D] dark:focus:border-emerald-500 transition">
                <button type="button" id="togglePassword" onclick="togglePasswordVisibility('password', this)" class="absolute right-0 top-0 h-full px-3.5 flex items-center text-slate-400 hover:text-[#14532D] dark:hover:text-emerald-400 transition focus:outline-none" title="Tampilkan Password" aria-label="Tampilkan Password">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                </button>
              </div>
            </div>
            <div class="flex items-center justify-between text-xs pt-1">
              <label class="flex items-center gap-2 cursor-pointer select-none">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-[#14532D] focus:ring-[#14532D]">
                <span class="text-slate-600 dark:text-slate-300 font-medium">Ingat Saya</span>
              </label>
              <button type="button" id="btnSwitchToForgot" class="text-amber-700 dark:text-amber-400 font-semibold hover:underline bg-transparent border-0 cursor-pointer p-0 text-xs">Lupa kata sandi?</button>
            </div>
            <button type="submit" class="w-full py-3 bg-[#14532D] hover:bg-[#166534] text-white font-bold rounded-xl shadow-sm text-sm transition mt-2 cursor-pointer">Masuk ke LMS</button>
          </form>

          <p class="text-center mt-5 text-xs text-slate-600 dark:text-slate-400">Akun LMS dibuat oleh <strong>Operator Fakultas</strong>.<br>
            <a href="https://wa.me/6287721685155?text=Halo%20Admin%2FOperator%2C%20saya%20ingin%20mengajukan%20pembuatan%20akun%20LMS.%20Berikut%20data%20diri%20saya%3A%0A%0ANama%20Lengkap%3A%20%0ARole%20(Mahasiswa%2FDosen)%3A%20%0ANomor%20Induk%20(NIM%2FNIP)%3A%20%0AEmail%20Aktif%3A%20%0APassword%20yang%20diinginkan%3A%20%0A%0AMohon%20bantuannya%20untuk%20dibuatkan%20akun.%20Terima%20kasih" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 mt-2 px-4 py-2 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-300 dark:border-emerald-500/30 text-emerald-800 dark:text-emerald-300 hover:bg-emerald-600 hover:text-white transition font-bold">
              Hubungi Operator Fakultas via WhatsApp
            </a>
          </p>
        </div>

        <!-- FORGOT PASSWORD CARD (IN-PLACE, IDs & script preserved) -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-6 sm:p-7 hidden" id="forgotCard">
          <div class="flex items-center gap-3 mb-5">
            <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL" class="w-11 h-11 object-contain">
            <div class="leading-tight">
              <div class="text-xs font-extrabold tracking-wide text-slate-900 dark:text-white uppercase">Fakultas Teknik</div>
              <div class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 uppercase">Universitas Mulawarman</div>
            </div>
          </div>

          <h2 class="text-xl font-extrabold text-slate-900 dark:text-white mb-1">Lupa Kata Sandi?</h2>
          <p class="text-sm text-slate-600 dark:text-slate-400 mb-3">Verifikasi akun dengan NIM/NIP & email untuk mereset kata sandi.</p>

          <div id="loginForgotAlert" class="hidden mb-3 p-3 rounded-xl text-xs font-semibold"></div>

          <form id="loginForgotForm" class="space-y-3">
            @csrf
            <div>
              <label for="fgNomerInduk" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1">Nomor Induk (NIM / NIP)</label>
              <input type="text" id="fgNomerInduk" name="nomer_induk" placeholder="Contoh: 2109106001 / 19850101..." class="w-full px-3.5 py-2 border border-slate-300 dark:border-slate-600 rounded-xl text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#14532D]/20 dark:focus:ring-emerald-500/30 focus:border-[#14532D] dark:focus:border-emerald-500 transition">
            </div>
            <div>
              <label for="fgEmail" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1">Email Terdaftar</label>
              <div class="flex gap-2">
                <input type="email" id="fgEmail" name="email" placeholder="nama@unmul.ac.id" class="flex-1 px-3.5 py-2 border border-slate-300 dark:border-slate-600 rounded-xl text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#14532D]/20 dark:focus:ring-emerald-500/30 focus:border-[#14532D] dark:focus:border-emerald-500 transition">
                <button type="button" id="btnFgSendCode" class="shrink-0 px-3 py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl text-xs whitespace-nowrap transition flex items-center justify-center gap-1.5 cursor-pointer">
                  <span id="btnFgSendCodeText">Kirim Verifikasi</span>
                </button>
              </div>
            </div>
            <div>
              <label for="fgCode" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1">Kode Verifikasi (6 Digit)</label>
              <input type="text" id="fgCode" name="code" maxlength="6" placeholder="Masukkan 6 digit kode dari email" class="w-full px-3.5 py-2 border border-slate-300 dark:border-slate-600 rounded-xl text-sm tracking-widest font-mono font-bold bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#14532D]/20 dark:focus:ring-emerald-500/30 focus:border-[#14532D] dark:focus:border-emerald-500 transition">
              <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 block">Klik "Kirim Verifikasi" untuk mendapatkan kode.</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
              <div>
                <label for="fgPassword" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1">Kata Sandi Baru</label>
                <div class="relative">
                  <input type="password" id="fgPassword" name="password" minlength="8" placeholder="Min. 8 karakter" class="w-full pl-3 pr-9 py-2 border border-slate-300 dark:border-slate-600 rounded-xl text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#14532D]/20 dark:focus:ring-emerald-500/30 focus:border-[#14532D] dark:focus:border-emerald-500 transition">
                  <button type="button" onclick="togglePasswordVisibility('fgPassword', this)" class="absolute right-0 top-0 h-full px-2.5 flex items-center text-slate-400 hover:text-[#14532D] dark:hover:text-emerald-400 transition focus:outline-none" title="Tampilkan Password" aria-label="Tampilkan Password">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                  </button>
                </div>
              </div>
              <div>
                <label for="fgPasswordConfirm" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1">Konfirmasi Kata Sandi</label>
                <div class="relative">
                  <input type="password" id="fgPasswordConfirm" name="password_confirmation" minlength="8" placeholder="Ulangi kata sandi" class="w-full pl-3 pr-9 py-2 border border-slate-300 dark:border-slate-600 rounded-xl text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#14532D]/20 dark:focus:ring-emerald-500/30 focus:border-[#14532D] dark:focus:border-emerald-500 transition">
                  <button type="button" onclick="togglePasswordVisibility('fgPasswordConfirm', this)" class="absolute right-0 top-0 h-full px-2.5 flex items-center text-slate-400 hover:text-[#14532D] dark:hover:text-emerald-400 transition focus:outline-none" title="Tampilkan Password" aria-label="Tampilkan Password">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                  </button>
                </div>
              </div>
            </div>
            <button type="submit" id="btnFgSubmit" class="w-full py-2.5 bg-[#14532D] hover:bg-[#166534] text-white font-bold rounded-xl text-sm transition mt-1 cursor-pointer">Simpan Kata Sandi Baru</button>
          </form>

          <p class="text-center mt-4 text-xs text-slate-600 dark:text-slate-400">Sudah ingat kata sandi? <button type="button" id="btnSwitchToLogin" class="text-amber-700 dark:text-amber-400 font-semibold hover:underline bg-transparent border-0 cursor-pointer p-0 text-xs">Masuk di sini</button></p>
        </div>

        <p class="mt-6 text-center text-[11px] text-slate-500 dark:text-slate-400">&copy; {{ date('Y') }} Fakultas Teknik Universitas Mulawarman · Dikembangkan oleh Tim PKL SMK Negeri 1 Tenggarong</p>
      </div>
    </main>
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
        <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
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
      loginForgotAlert.classList.remove('hidden', 'bg-red-50', 'text-red-700', 'border', 'border-red-200', 'bg-emerald-50', 'text-emerald-800', 'border-emerald-200', 'dark:bg-emerald-500/10', 'dark:text-emerald-300', 'dark:border-emerald-500/30', 'dark:bg-rose-500/10', 'dark:text-rose-300', 'dark:border-rose-500/30');
      if (type === 'error') {
        loginForgotAlert.classList.add('bg-red-50', 'text-red-700', 'border', 'border-red-200', 'dark:bg-rose-500/10', 'dark:text-rose-300', 'dark:border-rose-500/30');
      } else {
        loginForgotAlert.classList.add('bg-emerald-50', 'text-emerald-800', 'border', 'border-emerald-200', 'dark:bg-emerald-500/10', 'dark:text-emerald-300', 'dark:border-emerald-500/30');
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
              const nomerIndukInput = document.getElementById('nomer_induk');
              if (nomerIndukInput) nomerIndukInput.value = nomerInduk;
            }, 1800);
          } else {
            showLoginAlert('error', data.message || 'Gagal mengatur ulang password.');
          }
        } catch (e) {
          showLoginAlert('error', 'Terjadi kesalahan sistem.');
        } finally {
          btnFgSubmit.disabled = false;
          btnFgSubmit.innerText = 'Simpan Kata Sandi Baru';
        }
      });
    }
  </script>
</body>
</html>