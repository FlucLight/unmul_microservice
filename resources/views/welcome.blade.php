<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fakultas Teknik UNMUL — Learning Management System</title>
  <meta name="description"
    content="Portal Learning Management System (LMS) Fakultas Teknik Universitas Mulawarman">

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
      <a href="{{ route('tugas.index') }}" class="btn-hidebar" style="text-decoration: none; color: inherit;">
        <span>📋 Tugas Kuliah</span>
      </a>

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
        <a href="{{ route('login') }}" class="btn-login-header" id="btnLoginHeader">
          <span>Log In</span>
        </a>
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

  <!-- POP-UP LOGIN MODAL CUSTOM -->
  <div class="modal-overlay" id="loginModalOverlay">
    <div class="modal-card">
      <button type="button" class="btn-close-modal" id="btnCloseModal" aria-label="Tutup Popup Modal">✕</button>

      <!-- FORM LOGIN -->
      <div class="modal-view" id="loginView">
        <div class="modal-header">
          <h2 class="modal-title">Log In LMS</h2>
          <p class="modal-subtitle">Masukkan email dan password Anda</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-group">
            <label for="inputEmailLogin" class="form-label">Email</label>
            <input type="email" name="email" id="inputEmailLogin" class="input-textbox" placeholder="email@unmul.ac.id" required autocomplete="email">
          </div>

          <div class="form-group">
            <label for="inputPasswordLogin" class="form-label">Password</label>
            <input type="password" name="password" id="inputPasswordLogin" class="input-textbox" placeholder="Masukkan password" required autocomplete="current-password">
          </div>

          <button type="submit" class="btn-submit-login">Log-In</button>

          <div class="login-bottom-right-container">
            <button type="button" class="link-register-toggle" id="linkToRegister">
              Belum punya akun? Register di sini
            </button>
          </div>
        </form>
      </div>

      <!-- FORM REGISTER CUSTOM -->
      <div class="modal-view hidden" id="registerView">
        <div class="modal-header">
          <h2 class="modal-title">Register Akun LMS</h2>
          <p class="modal-subtitle">Daftar sebagai Dosen atau Mahasiswa</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
          @csrf
          <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="input-textbox" placeholder="Nama lengkap Anda" required>
          </div>

          <div class="form-group">
            <label class="form-label">Role (Dosen / Mahasiswa)</label>
            <select name="role" class="input-textbox" style="background:#fff;" required>
              <option value="mahasiswa">👨‍🎓 Mahasiswa</option>
              <option value="dosen">👨‍🏫 Dosen</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Nomor Induk (NIM / NIP)</label>
            <input type="text" name="nomer_induk" class="input-textbox" placeholder="NIM / NIP" required>
          </div>

          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="input-textbox" placeholder="email@unmul.ac.id" required>
          </div>

          <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="input-textbox" placeholder="Minimal 8 karakter" required>
          </div>

          <div class="form-group">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="input-textbox" placeholder="Ulangi password" required>
          </div>

          <button type="submit" class="btn-submit-login">Daftar Sekarang</button>

          <div class="login-bottom-right-container">
            <button type="button" class="link-register-toggle" id="linkToLogin">
              Sudah punya akun? Log in
            </button>
          </div>
        </form>
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
  <script src="{{ asset('js/loginpage.js') }}"></script>
</body>
</html>