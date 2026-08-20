<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register — Fakultas Teknik UNMUL</title>
  <meta name="description" content="Halaman registrasi akun Fakultas Teknik Universitas Mulawarman">
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
    }
    .video-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      z-index: 1;
      background: radial-gradient(circle at center, rgba(15, 23, 42, 0.45) 0%, rgba(15, 23, 42, 0.8) 100%);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
    }
    .auth-wrapper {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 480px;
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
    </div>

    <div class="auth-card">
      <div class="auth-logo">
        <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL">
        <div class="auth-logo-text">
          <span class="l1">FAKULTAS TEKNIK</span>
          <span class="l2">UNIVERSITAS MULAWARMAN</span>
        </div>
      </div>
      <h1 class="auth-title">Daftar Akun LMS</h1>
      <p class="auth-subtitle">Pilih role Anda sebagai Dosen atau Mahasiswa</p>

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

      <form method="POST" action="{{ route('register') }}" class="space-y-3.5">
        @csrf

        <!-- Nama Lengkap -->
        <div>
          <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nama Lengkap</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Contoh: Dr. Budi, S.T. / Ahmad Fulan" class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
        </div>

        <!-- Role: Dosen / Mahasiswa -->
        <div>
          <label for="role" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Daftar Sebagai (Role)</label>
          <select id="role" name="role" required class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 bg-white transition">
            <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
            <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
          </select>
        </div>

        <!-- Nomor Induk (NIP / NIM) -->
        <div>
          <label for="nomer_induk" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nomor Induk (NIM / NIP)</label>
          <input type="text" id="nomer_induk" name="nomer_induk" value="{{ old('nomer_induk') }}" required placeholder="NIM untuk Mahasiswa, NIP/NIDN untuk Dosen" class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Email Aktif</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="email@unmul.ac.id" class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
        </div>

        <!-- Password Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <div>
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Password</label>
            <div class="relative">
              <input type="password" id="password" name="password" required placeholder="Min. 8 karakter" class="w-full pl-3.5 pr-10 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
              <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-0 top-0 h-full px-3 flex items-center text-slate-400 hover:text-amber-600 transition focus:outline-none" title="Tampilkan Password" aria-label="Tampilkan Password">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
            </div>
          </div>

          <div>
            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Konfirmasi Password</label>
            <div class="relative">
              <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password" class="w-full pl-3.5 pr-10 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-600 transition">
              <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute right-0 top-0 h-full px-3 flex items-center text-slate-400 hover:text-amber-600 transition focus:outline-none" title="Tampilkan Password" aria-label="Tampilkan Password">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <button type="submit" class="w-full py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-bold rounded-xl shadow-lg shadow-amber-500/25 text-sm transition transform active:scale-[0.99] mt-2">
          Daftar Akun Sekarang
        </button>
      </form>

      <p class="auth-footer-text">Sudah punya akun? <a href="{{ route('login') }}">Log in di sini</a></p>
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
</body>
</html>
