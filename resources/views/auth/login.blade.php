<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — Fakultas Teknik UNMUL</title>
  <meta name="description" content="Halaman login Fakultas Teknik Universitas Mulawarman">
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
    .auth-wrapper { width: 100%; max-width: 420px; }
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
      <h1 class="auth-title">Log In LMS</h1>
      <p class="auth-subtitle">Masukkan email dan password akun Anda</p>

      @if (session('status'))
        <div class="mb-4 text-xs font-semibold text-emerald-600 bg-emerald-50 p-2.5 rounded border border-emerald-200">
            {{ session('status') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-xs rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
          <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukkan email terdaftar" class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-amber-600">
        </div>

        <div>
          <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Password</label>
          <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="Masukkan password" class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:border-amber-600">
        </div>

        <div class="flex items-center justify-between text-xs pt-1">
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="remember" class="rounded border-slate-300 text-amber-600 focus:ring-amber-500">
            <span class="text-slate-600 font-medium">Ingat Saya</span>
          </label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-amber-700 font-semibold hover:underline">Lupa password?</a>
          @endif
        </div>

        <button type="submit" class="w-full py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-lg shadow text-sm transition mt-2">
          Log In Sekarang
        </button>
      </form>

      <p class="auth-footer-text">Belum punya akun? <a href="{{ route('register') }}">Daftar Akun di sini</a></p>
    </div>
  </div>
</body>
</html>
