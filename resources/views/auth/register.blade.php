<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register — Fakultas Teknik UNMUL</title>
  <meta name="description" content="Halaman registrasi akun Fakultas Teknik Universitas Mulawarman">
  <link rel="stylesheet" href="{{ asset('css/loginpage.css') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: #0f172a;
      padding: 20px;
    }
    .auth-wrapper { width: 100%; max-width: 440px; }
    .auth-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 36px 32px 32px;
      box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
    }
    .auth-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 24px;
    }
    .auth-logo img { height: 38px; width: auto; object-fit: contain; }
    .auth-logo-text { display: flex; flex-direction: column; line-height: 1.15; }
    .auth-logo-text .l1 { font-size: 0.8rem; font-weight: 800; color: #0f172a; letter-spacing: 0.03em; text-transform: uppercase; }
    .auth-logo-text .l2 { font-size: 0.7rem; font-weight: 800; color: #334155; letter-spacing: 0.02em; text-transform: uppercase; }
    .auth-title { font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .auth-subtitle { font-size: 0.85rem; color: #475569; margin-bottom: 24px; }
    .auth-footer-text { text-align: center; margin-top: 20px; font-size: 0.84rem; color: #64748b; }
    .auth-footer-text a { color: #B4832A; font-weight: 700; text-decoration: none; }
    .auth-footer-text a:hover { text-decoration: underline; }
  </style>
</head>

<body>
  <div class="video-bg-container">
    <video class="bg-video" autoplay loop muted playsinline
      poster="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=1920&q=80">
      <source src="{{ asset('fakultas-teknik-universitas-mulawarmanmp4_Al7wZnbtmn.mp4') }}" type="video/mp4">
    </video>
    <div class="video-overlay"></div>
  </div>

  <div class="auth-wrapper relative z-10">
    <a href="{{ route('home') }}" class="text-white/80 hover:text-gold text-xs font-bold mb-4 inline-flex items-center gap-1">
      &larr; Kembali ke Beranda
    </a>

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
        <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-xs rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Nama Lengkap -->
        <div>
          <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nama Lengkap</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Contoh: Dr. Budi, S.T. / Ahmad Fulan" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-amber-600">
        </div>

        <!-- Role: Dosen / Mahasiswa -->
        <div>
          <label for="role" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Daftar Sebagai (Role)</label>
          <select id="role" name="role" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-amber-600 bg-white">
            <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>👨‍🎓 Mahasiswa</option>
            <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>👨‍🏫 Dosen</option>
          </select>
        </div>

        <!-- Nomor Induk (NIP / NIM) -->
        <div>
          <label for="nomer_induk" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Nomor Induk (NIM / NIP)</label>
          <input type="text" id="nomer_induk" name="nomer_induk" value="{{ old('nomer_induk') }}" required placeholder="NIM untuk Mahasiswa, NIP/NIDN untuk Dosen" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-amber-600">
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Email Active</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="email@unmul.ac.id" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-amber-600">
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Password</label>
          <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-amber-600">
        </div>

        <!-- Konfirmasi Password -->
        <div>
          <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Konfirmasi Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-amber-600">
        </div>

        <button type="submit" class="w-full py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-lg shadow text-sm transition mt-2">
          Daftar Akun Sekarang
        </button>
      </form>

      <p class="auth-footer-text">Sudah punya akun? <a href="{{ route('login') }}">Log in di sini</a></p>
    </div>
  </div>
</body>
</html>
