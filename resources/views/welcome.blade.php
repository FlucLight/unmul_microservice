<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fakultas Teknik UNMUL — Learning Management System</title>
  <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
  <meta name="description"
    content="Portal Learning Management System (LMS) Fakultas Teknik Universitas Mulawarman">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Google Identity Services -->
  <script src="https://accounts.google.com/gsi/client" async defer></script>
  @vite(['resources/css/loginpage.css', 'resources/js/loginpage.js'])
</head>

<body>

  <!-- BACKGROUND VIDEO LOOPING -->
  <div class="video-bg-container">
    <video class="bg-video" autoplay loop muted playsinline
      poster="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=1920&q=80">
      <source src="{{ asset('fakultas-teknik-universitas-mulawarmanmp4_Al7wZnbtmn.mp4') }}" type="video/mp4">
    </video>
    <div class="video-overlay"></div>
  </div>

  <!-- NAVBAR -->
  <header class="header-bar" id="headerBar">
    <div class="header-inner">
      <a href="{{ route('home') }}" class="header-logo-container" aria-label="Beranda LMS FT UNMUL">
        <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL" class="header-logo-img">
        <div class="header-brand-text">
          <span class="brand-line-1">FAKULTAS TEKNIK</span>
          <span class="brand-line-2">UNIVERSITAS MULAWARMAN</span>
        </div>
      </a>

      <!-- Menu Desktop -->
      <nav class="main-nav" aria-label="Navigasi utama">
        <a href="{{ route('home') }}" class="main-nav-link active">Beranda</a>
        @auth
          <a href="{{ route('tugas.index') }}" class="main-nav-link">Tugas Kuliah</a>
          <a href="{{ route('modul.index') }}" class="main-nav-link">Modul Kuliah</a>
        @endauth
        <button type="button" class="main-nav-link js-open-hidebar">Jurusan</button>
      </nav>

      <div class="header-actions">
        @guest
          <button type="button" class="btn-login-header btn-open-login-modal" id="btnLoginHeader">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
            <span>Log In</span>
          </button>
        @else
          <a href="{{ route('tugas.index') }}" class="user-logged-in-badge" aria-label="Ke halaman tugas">
            <div class="user-avatar-initial">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <span>{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
          </a>
        @endguest

        <!-- Hamburger Mobile -->
        <button type="button" class="btn-mobile-menu js-open-hidebar" aria-label="Buka menu">
          <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>
  </header>

  <!-- HIDEBAR (DRAWER JURUSAN) -->
  <div class="hidebar-overlay" id="hidebarOverlay"></div>
  <aside class="hidebar-panel" id="hidebarPanel" aria-label="Menu Hidebar">
    <div class="hidebar-header">
      <span class="hidebar-title">Daftar Jurusan FT UNMUL</span>
      <button type="button" class="btn-close-hidebar" id="btnCloseHidebar" aria-label="Tutup Hidebar">✕</button>
    </div>

    <div class="hidebar-body">
      <!-- Quick Nav (hanya tampil di mobile) -->
      <div class="hidebar-quicknav">
        <span class="hidebar-quicknav-title">Menu</span>
        <a href="{{ route('home') }}" class="hidebar-quicknav-link">
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10" /></svg>
          Beranda
        </a>
        @auth
          <a href="{{ route('tugas.index') }}" class="hidebar-quicknav-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
            Tugas Kuliah
          </a>
          <a href="{{ route('modul.index') }}" class="hidebar-quicknav-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
            Modul Kuliah
          </a>
        @endauth
      </div>

      <span class="hidebar-section-label">Daftar Jurusan FT UNMUL</span>
      <ul class="hidebar-menu-list">
        <li><a href="https://ts.ft.unmul.ac.id/" class="hidebar-link" target="_blank"><span class="hidebar-link-text">TEKNIK SIPIL</span><span class="hidebar-arrow">&rsaquo;</span></a></li>
        <li><a href="https://s1tambang.ft.unmul.ac.id/" class="hidebar-link" target="_blank"><span class="hidebar-link-text">TEKNIK PERTAMBANGAN</span><span class="hidebar-arrow">&rsaquo;</span></a></li>
        <li><a href="https://informatika.ft.unmul.ac.id/" class="hidebar-link" target="_blank"><span class="hidebar-link-text">INFORMATIKA</span><span class="hidebar-arrow">&rsaquo;</span></a></li>
        <li><a href="https://tekling.ft.unmul.ac.id/" class="hidebar-link" target="_blank"><span class="hidebar-link-text">TEKNIK LINGKUNGAN</span><span class="hidebar-arrow">&rsaquo;</span></a></li>
        <li><a href="https://ie.ft.unmul.ac.id/" class="hidebar-link" target="_blank"><span class="hidebar-link-text">TEKNIK INDUSTRI</span><span class="hidebar-arrow">&rsaquo;</span></a></li>
        <li><a href="https://che.ft.unmul.ac.id/" class="hidebar-link" target="_blank"><span class="hidebar-link-text">TEKNIK KIMIA</span><span class="hidebar-arrow">&rsaquo;</span></a></li>
        <li><a href="https://geologi.ft.unmul.ac.id/" class="hidebar-link" target="_blank"><span class="hidebar-link-text">TEKNIK GEOLOGI</span><span class="hidebar-arrow">&rsaquo;</span></a></li>
        <li><a href="https://si.ft.unmul.ac.id/" class="hidebar-link" target="_blank"><span class="hidebar-link-text">SISTEM INFORMASI</span><span class="hidebar-arrow">&rsaquo;</span></a></li>
        <li><a href="https://ft.unmul.ac.id/academic/prodi-s1-arsitektur-mi" class="hidebar-link" target="_blank"><span class="hidebar-link-text">ARSITEKTUR</span><span class="hidebar-arrow">&rsaquo;</span></a></li>
        <li><a href="https://ft.unmul.ac.id/academic/prodi-s1-perencanaan-wilayah-dan-kota" class="hidebar-link" target="_blank"><span class="hidebar-link-text">TEKNIK PERENCANAAN WILAYAH & KOTA</span><span class="hidebar-arrow">&rsaquo;</span></a></li>
      </ul>
    </div>
  </aside>

  <!-- POP-UP LOGIN / REGISTER MODAL (TAMPILAN PERSIS LOGIN.BLADE.PHP) -->
  <div class="modal-overlay" id="loginModalOverlay">
    <div class="modal-card">
      <button type="button" class="btn-close-modal" id="btnCloseModal" aria-label="Tutup Popup Modal">✕</button>

      <!-- FORM LOGIN VIEW -->
      <div class="modal-view" id="loginView">
        <div class="auth-logo">
          <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL">
          <div class="auth-logo-text">
            <span class="l1">FAKULTAS TEKNIK</span>
            <span class="l2">UNIVERSITAS MULAWARMAN</span>
          </div>
        </div>
        <h2 class="auth-title">Log In LMS</h2>
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

        <!-- Dynamic Alert Container untuk status AJAX Login (Poin 7) -->
        <div id="loginAlertBox" class="hidden mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl font-semibold"></div>

        <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-4">
          @csrf

          <div>
            <label for="inputEmailLogin" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email</label>
            <input type="email" id="inputEmailLogin" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukkan email terdaftar" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
          </div>

          <div>
            <label for="inputPasswordLogin" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Password</label>
            <div class="relative">
              <input type="password" id="inputPasswordLogin" name="password" required minlength="8" autocomplete="current-password" placeholder="Masukkan password (min. 8 karakter)" class="w-full pl-3.5 pr-11 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
              <button type="button" onclick="togglePasswordVisibility('inputPasswordLogin', this)" class="absolute right-0 top-0 h-full px-3.5 flex items-center text-slate-400 hover:text-amber-600 transition focus:outline-none" title="Tampilkan Password" aria-label="Tampilkan Password">
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
            <a href="#" id="linkToForgotPassword" class="text-amber-700 font-semibold hover:underline">Lupa password?</a>
          </div>

          <button type="submit" id="btnLoginSubmit" class="w-full py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold rounded-xl shadow-lg shadow-amber-500/25 text-sm transition transform active:scale-[0.99] mt-2">
            Log In Sekarang
          </button>
        </form>

        <p class="auth-footer-text">Akun LMS hanya dapat dibuat oleh <strong>Operator Fakultas</strong>. Hubungi operator jika belum memiliki akun.</p>
      </div>

      <!-- FORM REGISTER DIHAPUS (Poin 8): Registrasi akun hanya dilakukan oleh Operator -->

      <!-- FORM LUPA PASSWORD VIEW - LANGKAH 1: NIM + EMAIL + KODE VERIFIKASI (Poin 6) -->
      <div class="modal-view hidden" id="forgotPasswordView">
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

        <!-- Dynamic Alert Container for AJAX status -->
        <div id="forgotAlertBox" class="hidden mb-3 p-3 rounded-xl text-xs font-semibold"></div>

        <form id="forgotPasswordForm" class="space-y-3">
          @csrf

          <!-- Nomor Induk (NIM / NIP) -->
          <div>
            <label for="forgotNomerInduk" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nomor Induk (NIM / NIP)</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                </svg>
              </div>
              <input type="text" id="forgotNomerInduk" name="nomer_induk" required placeholder="Contoh: 2109106001 / 19850101..." class="w-full pl-9 pr-3.5 py-2 border border-slate-300 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
            </div>
          </div>

          <!-- Email Terdaftar + Tombol Kirim Verifikasi di sebelahnya -->
          <div>
            <label for="forgotEmail" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Email Terdaftar</label>
            <div class="flex gap-2">
              <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                  </svg>
                </div>
                <input type="email" id="forgotEmail" name="email" required placeholder="nama@unmul.ac.id" class="w-full pl-9 pr-2 py-2 border border-slate-300 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
              </div>
              <button type="button" id="btnForgotSendCode" class="shrink-0 px-3 py-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold rounded-xl shadow-md shadow-amber-500/20 text-xs whitespace-nowrap transition transform active:scale-[0.98] flex items-center justify-center gap-1.5 cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                <span id="btnForgotSendCodeText">Kirim Verifikasi</span>
              </button>
            </div>
          </div>

          <!-- Kode Verifikasi (6 Digit) -->
          <div>
            <label for="forgotCode" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Kode Verifikasi (6 Digit)</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
              </div>
              <input type="text" id="forgotCode" name="code" required maxlength="6" inputmode="numeric" placeholder="Masukkan 6 digit kode dari email" class="w-full pl-9 pr-3.5 py-2 border border-slate-300 rounded-xl text-xs sm:text-sm tracking-widest font-mono font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
            </div>
            <span class="text-[10px] text-slate-400 mt-0.5 block">Klik "Kirim Verifikasi" di atas untuk mendapatkan kode</span>
          </div>

          <button type="submit" id="btnForgotVerify" class="w-full py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold rounded-xl shadow-lg shadow-amber-500/25 text-xs sm:text-sm transition transform active:scale-[0.99] mt-1 cursor-pointer">
            Verifikasi Kode
          </button>
        </form>

        <p class="auth-footer-text mt-3">Sudah ingat password? <a href="#" id="linkForgotToLogin">Log in di sini</a></p>
      </div>

      <!-- FORM LUPA PASSWORD VIEW - LANGKAH 2: PASSWORD BARU (Poin 6) -->
      <div class="modal-view hidden" id="forgotResetView">
        <div class="auth-logo">
          <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL">
          <div class="auth-logo-text">
            <span class="l1">FAKULTAS TEKNIK</span>
            <span class="l2">UNIVERSITAS MULAWARMAN</span>
          </div>
        </div>
        <div class="flex items-center gap-2 mb-1">
          <div class="w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-bold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h2 class="auth-title mb-0 text-xl font-extrabold">Verifikasi Berhasil!</h2>
        </div>
        <p class="auth-subtitle mb-3 text-xs text-slate-500">Akun Anda terverifikasi. Sekarang buat password baru untuk akun Anda.</p>

        <form id="forgotResetForm" class="space-y-3">
          @csrf

          <!-- Password Baru Grid -->
          <div class="space-y-2.5">
            <div>
              <label for="forgotPassword" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Password Baru</label>
              <div class="relative">
                <input type="password" id="forgotPassword" name="password" required minlength="8" placeholder="Min. 8 karakter" class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
                <button type="button" onclick="togglePasswordVisibility('forgotPassword', this)" class="absolute right-0 top-0 h-full px-2.5 flex items-center text-slate-400 hover:text-amber-600 transition focus:outline-none" title="Tampilkan Password" aria-label="Tampilkan Password">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </button>
              </div>
            </div>

            <div>
              <label for="forgotPasswordConfirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Konfirmasi Password Baru</label>
              <div class="relative">
                <input type="password" id="forgotPasswordConfirmation" name="password_confirmation" required minlength="8" placeholder="Ulangi password baru" class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
                <button type="button" onclick="togglePasswordVisibility('forgotPasswordConfirmation', this)" class="absolute right-0 top-0 h-full px-2.5 flex items-center text-slate-400 hover:text-amber-600 transition focus:outline-none" title="Tampilkan Password" aria-label="Tampilkan Password">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <button type="submit" id="btnForgotSubmit" class="w-full py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold rounded-xl shadow-lg shadow-amber-500/25 text-xs sm:text-sm transition transform active:scale-[0.99] mt-1 cursor-pointer">
            Simpan Password Baru
          </button>
        </form>

        <p class="auth-footer-text mt-3">Sudah ingat password? <a href="#" id="linkResetToLogin">Log in di sini</a></p>
      </div>
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
        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        </svg>
      ` : `
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
      `;
    }
  </script>

  <main class="main-polos">
    <!-- HERO SECTION -->
    <section class="hero">
      <span class="hero-badge">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        Learning Management System
      </span>

      <h1 class="hero-title">
        Portal Pembelajaran<br>
        <span class="hero-title-accent">Fakultas Teknik</span> Universitas Mulawarman
      </h1>

      <p class="hero-desc">
        Kelola tugas kuliah, akses modul pembelajaran, dan pantau penilaian dalam satu platform
        terpadu untuk mahasiswa, dosen, dan admin Fakultas Teknik.
      </p>

      <div class="hero-actions">
        @guest
          <button type="button" class="hero-btn primary btn-open-login-modal">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
            Masuk ke LMS
          </button>
        @else
          <a href="{{ route('tugas.index') }}" class="hero-btn primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
            Lihat Tugas Kuliah
          </a>
        @endguest
        <button type="button" class="hero-btn ghost js-open-hidebar">
          Jelajahi Jurusan
          <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>

      <div class="hero-stats">
        <div class="hero-stat">
          <b>10</b>
          <span>Program Studi</span>
        </div>
        <div class="hero-stat">
          <b>100%</b>
          <span>Daring &amp; Terpadu</span>
        </div>
        <div class="hero-stat">
          <b>24/7</b>
          <span>Akses Kapan Saja</span>
        </div>
      </div>
    </section>

    <!-- FITUR UNGGULAN -->
    <section class="features" aria-label="Fitur unggulan">
      <article class="feature-card">
        <div class="feature-icon">
          <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
        </div>
        <h3>Manajemen Tugas</h3>
        <p>Dosen membagikan tugas beserta deadline, mahasiswa mengumpulkan lewat link Drive, dan penilaian tercatat rapi.</p>
      </article>

      <article class="feature-card">
        <div class="feature-icon">
          <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
        </div>
        <h3>Modul Kuliah Digital</h3>
        <p>Materi dan modul setiap mata kuliah tersedia terpusat, mudah diakses kapan pun dibutuhkan.</p>
      </article>

      <article class="feature-card">
        <div class="feature-icon">
          <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
        </div>
        <h3>Penilaian Transparan</h3>
        <p>Nilai dari dosen tersimpan aman dan dapat dipantau langsung oleh mahasiswa tanpa proses berbelit.</p>
      </article>
    </section>

    <div class="scroll-indicator" id="scrollIndicator">
      <span>Scroll Ke Bawah</span>
      <span>&darr;</span>
    </div>
  </main>

  <footer class="footer-standard">
    <div class="footer-container">
      <div class="footer-brand">
        <div class="footer-logo">FAKULTAS TEKNIK</div>
        <p class="footer-desc">
          Kampus Gunung Kalua, Jalan Sambaliung No.9 Samarinda, Kalimantan Timur 75119 | Telp. (0514) 736834 | Fax. (0541) 749315
        </p>
      </div>

      <div class="footer-links-group">
        <div>
          <div class="footer-col-title">Navigasi</div>
          <ul class="footer-nav">
            <li><a href="{{ route('home') }}">Beranda</a></li>
            @auth
              <li><a href="{{ route('tugas.index') }}">Tugas Kuliah</a></li>
              <li><a href="{{ route('modul.index') }}">Modul Kuliah</a></li>
            @endauth
          </ul>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <span>&copy; 2026 Web Interaktif. Hak Cipta Dilindungi.</span>
      <span>Didesain Dan Dikembangan Oleh Siswa SMK Negeri 1 Tenggarong.</span>
    </div>
  </footer>

  <div class="toast-container" id="toastContainer"></div>
</body>
</html>
