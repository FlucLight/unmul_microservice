<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fakultas Teknik UNMUL — Learning Management System</title>
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

  <!-- HEADER BAR -->
  <header class="header-bar" id="headerBar">
    <a href="{{ route('home') }}" class="header-logo-container">
      <img src="{{ asset('logo.png') }}" alt="Logo" class="header-logo-img">
      <div class="header-brand-text">
        <span class="brand-line-1">FAKULTAS TEKNIK</span>
        <span class="brand-line-2">UNIVERSITAS MULAWARMAN</span>
      </div>
    </a>

    <div class="header-actions">
      <!-- Tombol ke Halaman Tugas -->
      @auth
        <a href="{{ route('tugas.index') }}" class="btn-hidebar" style="text-decoration: none; color: inherit;">
          <span> Tugas Kuliah</span>
        </a>
      @else
        <button type="button" class="btn-hidebar btn-open-login-modal" style="text-decoration: none; color: inherit;">
          <span> Tugas Kuliah</span>
        </button>
      @endauth

      <!-- Tombol Hidebar -->
      <button type="button" class="btn-hidebar" id="btnHidebarToggle" aria-label="Buka Menu Hidebar">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <span>Jurusan</span>
      </button>

      @auth
        <!-- User Badge if Logged In -->
        <a href="{{ route('tugas.index') }}" class="user-logged-in-badge flex items-center gap-2" style="display: flex; text-decoration: none; color: inherit;">
          <div style="width:28px; height:28px; border-radius:50%; background:#B4832A; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:12px;">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
          </div>
          <span>{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
        </a>
      @else
        <!-- Tombol Login -->
        <button type="button" class="btn-login-header btn-open-login-modal" id="btnLoginHeader">
          <span>Log In</span>
        </button>
      @endauth
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

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
          @csrf

          <div>
            <label for="inputEmailLogin" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email</label>
            <input type="email" id="inputEmailLogin" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukkan email terdaftar" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
          </div>

          <div>
            <label for="inputPasswordLogin" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Password</label>
            <input type="password" id="inputPasswordLogin" name="password" required autocomplete="current-password" placeholder="Masukkan password" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
          </div>

          <div class="flex items-center justify-between text-xs pt-1">
            <label class="flex items-center gap-2 cursor-pointer select-none">
              <input type="checkbox" name="remember" class="rounded border-slate-300 text-amber-600 focus:ring-amber-500">
              <span class="text-slate-600 font-medium">Ingat Saya</span>
            </label>
            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="text-amber-700 font-semibold hover:underline">Lupa password?</a>
            @endif
          </div>

          <button type="submit" class="w-full py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold rounded-xl shadow-lg shadow-amber-500/25 text-sm transition transform active:scale-[0.99] mt-2">
            Log In Sekarang
          </button>
        </form>

        <p class="auth-footer-text">Belum punya akun? <a href="#" id="linkToRegister">Daftar Akun di sini</a></p>
      </div>

      <!-- FORM REGISTER VIEW -->
      <div class="modal-view hidden" id="registerView">
        <div class="auth-logo">
          <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL">
          <div class="auth-logo-text">
            <span class="l1">FAKULTAS TEKNIK</span>
            <span class="l2">UNIVERSITAS MULAWARMAN</span>
          </div>
        </div>
        <h2 class="auth-title">Daftar Akun LMS</h2>
        <p class="auth-subtitle">Pilih role Anda sebagai Dosen atau Mahasiswa</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-3.5">
          @csrf

          <div>
            <label for="regName" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nama Lengkap</label>
            <input type="text" id="regName" name="name" value="{{ old('name') }}" required placeholder="Contoh: Dr. Budi, S.T. / Ahmad Fulan" class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
          </div>

          <div>
            <label for="regRole" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Daftar Sebagai (Role)</label>
            <select id="regRole" name="role" required class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 bg-white transition">
              <option value="mahasiswa">👨‍🎓 Mahasiswa</option>
              <option value="dosen">👨‍🏫 Dosen</option>
            </select>
          </div>

          <div>
            <label for="regNomerInduk" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nomor Induk (NIM / NIP)</label>
            <input type="text" id="regNomerInduk" name="nomer_induk" value="{{ old('nomer_induk') }}" required placeholder="NIM untuk Mahasiswa, NIP/NIDN untuk Dosen" class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
          </div>

          <div>
            <label for="regEmail" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Email Aktif</label>
            <input type="email" id="regEmail" name="email" value="{{ old('email') }}" required placeholder="email@unmul.ac.id" class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
              <label for="regPassword" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Password</label>
              <input type="password" id="regPassword" name="password" required placeholder="Min. 8 karakter" class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
            </div>

            <div>
              <label for="regPasswordConfirm" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Konfirmasi Password</label>
              <input type="password" id="regPasswordConfirm" name="password_confirmation" required placeholder="Ulangi password" class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
            </div>
          </div>

          <button type="submit" class="w-full py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold rounded-xl shadow-lg shadow-amber-500/25 text-sm transition transform active:scale-[0.99] mt-2">
            Daftar Akun Sekarang
          </button>
        </form>

        <p class="auth-footer-text">Sudah punya akun? <a href="#" id="linkToLogin">Log in di sini</a></p>
      </div>
    </div>
  </div>

  <main class="main-polos">
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
            <li><a href="{{ route('tugas.index') }}">Tugas Kuliah</a></li>
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