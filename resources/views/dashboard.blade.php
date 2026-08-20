<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Fakultas Teknik UNMUL</title>
  <meta name="description" content="Dashboard pengguna Fakultas Teknik Universitas Mulawarman">
  <link rel="stylesheet" href="{{ asset('css/loginpage.css') }}">
  <!-- Google Identity Services -->
  <script src="https://accounts.google.com/gsi/client" async defer></script>
  <style>
    *, *::before, *::after {
      scrollbar-width: none;
      -ms-overflow-style: none;
    }
    *::-webkit-scrollbar {
      display: none;
      width: 0;
      height: 0;
    }
    body {
      background: #f1f5f9;
      font-family: 'Plus Jakarta Sans', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      scrollbar-width: none;
      -ms-overflow-style: none;
    }

    /* ── NAVBAR DASHBOARD ── */
    .dash-navbar {
      position: sticky;
      top: 0;
      z-index: 100;
      height: 60px;
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(226,232,240,0.8);
      box-shadow: 0 4px 20px -2px rgba(15,23,42,0.08);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 24px;
    }

    .dash-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }
    .dash-logo img { height: 38px; width: auto; object-fit: contain; }
    .dash-logo-text { display: flex; flex-direction: column; line-height: 1.15; }
    .dash-logo-text .l1 { font-size: 0.8rem; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.03em; }
    .dash-logo-text .l2 { font-size: 0.7rem; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.02em; }

    .dash-nav-right {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .dash-user-info {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 4px 14px 4px 6px;
      border-radius: 9999px;
      background: #f1f5f9;
      border: 1px solid #e2e8f0;
    }

    .dash-user-info img {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      object-fit: cover;
    }

    #dashUserName {
      font-weight: 700;
      font-size: 0.85rem;
      color: #0f172a;
    }

    .btn-logout {
      height: 36px;
      padding: 0 14px;
      border-radius: 8px;
      border: 1px solid #e2e8f0;
      background: #ffffff;
      color: #ef4444;
      font-family: inherit;
      font-weight: 700;
      font-size: 0.84rem;
      cursor: pointer;
      transition: all 0.15s ease;
    }
    .btn-logout:hover { background: #ef4444; color: #ffffff; border-color: #ef4444; }

    /* ── MAIN CONTENT ── */
    .dash-main {
      flex: 1;
      max-width: 1100px;
      margin: 32px auto;
      width: 100%;
      padding: 0 24px;
    }

    .dash-welcome {
      background: linear-gradient(135deg, #FF7A00 0%, #FF9225 100%);
      border-radius: 20px;
      padding: 32px 36px;
      color: #ffffff;
      margin-bottom: 28px;
      position: relative;
      overflow: hidden;
    }

    .dash-welcome::after {
      content: '';
      position: absolute;
      right: -30px;
      top: -30px;
      width: 200px;
      height: 200px;
      background: rgba(255,255,255,0.08);
      border-radius: 50%;
    }

    .dash-welcome-greeting {
      font-size: 0.85rem;
      font-weight: 700;
      opacity: 0.85;
      margin-bottom: 6px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .dash-welcome-name {
      font-size: 1.8rem;
      font-weight: 800;
      margin-bottom: 8px;
    }

    .dash-welcome-sub {
      font-size: 0.9rem;
      opacity: 0.85;
    }

    /* ── STATS GRID ── */
    .dash-stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 16px;
      margin-bottom: 28px;
    }

    .stat-card {
      background: #ffffff;
      border-radius: 16px;
      padding: 22px 24px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 1px 3px rgba(0,0,0,0.06);
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .stat-icon {
      font-size: 1.6rem;
    }

    .stat-label {
      font-size: 0.8rem;
      font-weight: 700;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .stat-value {
      font-size: 1.6rem;
      font-weight: 800;
      color: #0f172a;
    }

    /* ── MENU JURUSAN CARDS ── */
    .dash-section-title {
      font-size: 1.05rem;
      font-weight: 800;
      color: #0f172a;
      margin-bottom: 14px;
    }

    .dash-jurusan-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 14px;
      margin-bottom: 28px;
    }

    .jurusan-card {
      background: #ffffff;
      border-radius: 14px;
      padding: 20px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 1px 3px rgba(0,0,0,0.06);
      text-decoration: none;
      color: #0f172a;
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: all 0.2s ease;
      cursor: pointer;
    }

    .jurusan-card:hover {
      border-color: #FF7A00;
      box-shadow: 0 4px 12px rgba(255,122,0,0.15);
      transform: translateY(-2px);
    }

    .jurusan-card-name {
      font-weight: 800;
      font-size: 0.88rem;
    }

    .jurusan-card-arrow {
      font-size: 1.2rem;
      color: #FF7A00;
    }

    /* ── FOOTER ── */
    .dash-footer {
      background: #ffffff;
      border-top: 1px solid #e2e8f0;
      padding: 16px 24px;
      text-align: center;
      font-size: 0.8rem;
      color: #64748b;
    }
  </style>
</head>

<body>
  <!-- NAVBAR -->
  <nav class="dash-navbar">
    <a href="index.html" class="dash-logo">
      <img src="logo.png" alt="Logo">
      <div class="dash-logo-text">
        <span class="l1">FAKULTAS TEKNIK</span>
        <span class="l2">UNIVERSITAS MULAWARMAN</span>
      </div>
    </a>

    <div class="dash-nav-right">
      <div class="dash-user-info">
        <img id="dashUserAvatar" src="https://ui-avatars.com/api/?name=User&background=FF7A00&color=fff&bold=true&size=100" alt="Avatar">
        <span id="dashUserName">Pengguna</span>
      </div>
      <button class="btn-logout" id="btnLogout">Logout</button>
    </div>
  </nav>

  <!-- MAIN CONTENT -->
  <main class="dash-main">
    <!-- Welcome Banner -->
    <div class="dash-welcome">
      <div class="dash-welcome-greeting">Selamat datang kembali </div>
      <div class="dash-welcome-name" id="dashWelcomeName">Pengguna</div>
      <div class="dash-welcome-sub">Ini adalah dashboard Fakultas Teknik UNMUL. Pilih jurusan untuk mulai mengeksplorasi.</div>
    </div>

    <!-- Stats -->
    <div class="dash-stats">
      <div class="stat-card">
        <div class="stat-icon"></div>
        <div class="stat-label">Total Jurusan</div>
        <div class="stat-value">10</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon"></div>
        <div class="stat-label">Program Studi</div>
        <div class="stat-value">S1</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon"></div>
        <div class="stat-label">Lokasi</div>
        <div class="stat-value" style="font-size:1rem;">Samarinda</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon"></div>
        <div class="stat-label">Status</div>
        <div class="stat-value" style="font-size:1rem;color:#22c55e;">Aktif</div>
      </div>
    </div>

    <!-- Jurusan -->
    <div class="dash-section-title">Jurusan di Fakultas Teknik</div>
    <div class="dash-jurusan-grid">
      <a href="https://ts.ft.unmul.ac.id/" target="_blank" class="jurusan-card">
        <span class="jurusan-card-name">TEKNIK SIPIL</span>
        <span class="jurusan-card-arrow">›</span>
      </a>
      <a href="https://s1tambang.ft.unmul.ac.id/" target="_blank" class="jurusan-card">
        <span class="jurusan-card-name">TEKNIK PERTAMBANGAN</span>
        <span class="jurusan-card-arrow">›</span>
      </a>
      <a href="https://informatika.ft.unmul.ac.id/" target="_blank" class="jurusan-card">
        <span class="jurusan-card-name">INFORMATIKA</span>
        <span class="jurusan-card-arrow">›</span>
      </a>
      <a href="https://tekling.ft.unmul.ac.id/" target="_blank" class="jurusan-card">
        <span class="jurusan-card-name">TEKNIK LINGKUNGAN</span>
        <span class="jurusan-card-arrow">›</span>
      </a>
      <a href="https://ie.ft.unmul.ac.id/" target="_blank" class="jurusan-card">
        <span class="jurusan-card-name">TEKNIK INDUSTRI</span>
        <span class="jurusan-card-arrow">›</span>
      </a>
      <a href="https://che.ft.unmul.ac.id/" target="_blank" class="jurusan-card">
        <span class="jurusan-card-name">TEKNIK KIMIA</span>
        <span class="jurusan-card-arrow">›</span>
      </a>
      <a href="https://geologi.ft.unmul.ac.id/" target="_blank" class="jurusan-card">
        <span class="jurusan-card-name">TEKNIK GEOLOGI</span>
        <span class="jurusan-card-arrow">›</span>
      </a>
      <a href="https://si.ft.unmul.ac.id/" target="_blank" class="jurusan-card">
        <span class="jurusan-card-name">SISTEM INFORMASI</span>
        <span class="jurusan-card-arrow">›</span>
      </a>
      <a href="https://ft.unmul.ac.id/academic/prodi-s1-arsitektur-mi" target="_blank" class="jurusan-card">
        <span class="jurusan-card-name">ARSITEKTUR</span>
        <span class="jurusan-card-arrow">›</span>
      </a>
      <a href="https://ft.unmul.ac.id/academic/prodi-s1-perencanaan-wilayah-dan-kota" target="_blank" class="jurusan-card">
        <span class="jurusan-card-name">TEK. PERENCANAAN WILAYAH & KOTA</span>
        <span class="jurusan-card-arrow">›</span>
      </a>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="dash-footer">
    &copy; 2026 Fakultas Teknik Universitas Mulawarman. Hak Cipta Dilindungi.
  </footer>

  <!-- Toast -->
  <div class="toast-container" id="toastContainer"></div>

  <script>
    // Cek sesi login
    const savedUser = sessionStorage.getItem('loggedInUser');
    if (!savedUser) {
      // Belum login, redirect ke login
      window.location.href = 'login.html';
    } else {
      const user = JSON.parse(savedUser);
      document.getElementById('dashUserName').innerText = user.name;
      document.getElementById('dashWelcomeName').innerText = user.name;

      const avatar = document.getElementById('dashUserAvatar');
      if (user.picture) {
        avatar.src = user.picture;
      } else {
        avatar.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=FF7A00&color=fff&bold=true&size=100`;
      }
    }

    // Logout
    document.getElementById('btnLogout').addEventListener('click', () => {
      if (confirm('Logout dari akun?')) {
        if (typeof google !== 'undefined' && google.accounts) {
          google.accounts.id.disableAutoSelect();
        }
        sessionStorage.removeItem('loggedInUser');
        showToast('Berhasil logout', '');
        setTimeout(() => window.location.href = 'index.html', 1000);
      }
    });

    function showToast(msg, icon = '') {
      const c = document.getElementById('toastContainer');
      const t = document.createElement('div');
      t.className = 'toast';
      t.innerText = (icon ? icon + ' ' : '') + msg;
      c.appendChild(t);
      setTimeout(() => t.classList.add('show'), 10);
      setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 300); }, 3000);
    }
  </script>
</body>
</html>
