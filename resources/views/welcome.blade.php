<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LMS Fakultas Teknik Universitas Mulawarman</title>
  <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
  <meta name="description" content="Portal Akademik Terpadu & Learning Management System Fakultas Teknik Universitas Mulawarman">
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
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: { sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
          colors: {
            forest: { 900: '#14532D', 800: '#166534', 700: '#15803d' },
            amberui: { 500: '#F59E0B', 600: '#D97706', 700: '#B45309' }
          }
        }
      }
    }
  </script>
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .hero-bg {
      background-color: #F8FAFC;
      background-image:
        linear-gradient(to right, rgba(20,83,45,0.06) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(20,83,45,0.06) 1px, transparent 1px);
      background-size: 32px 32px;
    }
    .dark .hero-bg {
      background-color: #0B0F19;
      background-image:
        linear-gradient(to right, rgba(148,163,184,0.07) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(148,163,184,0.07) 1px, transparent 1px);
    }
    .modal-overlay { display:none; }
    .modal-overlay.active { display:flex; }
    .modal-view.hidden { display:none; }
    .hidebar-overlay { opacity:0; pointer-events:none; transition: opacity .2s ease; }
    .hidebar-overlay.active { opacity:1; pointer-events:auto; }
  </style>
</head>
<body class="min-h-screen bg-[#F8FAFC] text-slate-800 dark:bg-[#0B0F19] dark:text-slate-100 antialiased">

  <!-- Institutional Top Bar -->
  <div class="bg-forest-900 text-emerald-50 text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
      <div class="flex items-start sm:items-center gap-2">
        <svg class="w-4 h-4 mt-0.5 sm:mt-0 text-amber-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <span>Kampus Gunung Kelua, Jl. Sambaliung No. 9, Samarinda, Kalimantan Timur</span>
      </div>
      <div class="flex flex-wrap items-center gap-x-4 gap-y-1 font-medium">
        <a href="https://unmul.ac.id" target="_blank" rel="noopener noreferrer" class="hover:text-amber-300 underline-offset-2 hover:underline">Portal Utama UNMUL</a>
        <span class="text-emerald-300/50 hidden sm:inline">|</span>
        <a href="https://ft.unmul.ac.id" target="_blank" rel="noopener noreferrer" class="hover:text-amber-300 underline-offset-2 hover:underline">FT UNMUL</a>
      </div>
    </div>
  </div>

  <!-- Main Navbar -->
  <header id="headerBar" class="sticky top-0 z-40 bg-white/95 dark:bg-slate-950/90 backdrop-blur border-b border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-3">
      <a href="{{ route('home') }}" class="flex items-center gap-3 min-w-0">
        <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL" class="w-10 h-10 object-contain">
        <div class="leading-tight min-w-0">
          <div class="text-[11px] sm:text-xs font-extrabold tracking-wide text-slate-900 dark:text-white uppercase">Fakultas Teknik</div>
          <div class="text-[10px] sm:text-[11px] font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wide">Universitas Mulawarman</div>
        </div>
      </a>

      <nav class="hidden lg:flex items-center gap-1 text-sm font-semibold" aria-label="Navigasi utama">
        <a href="#tentang" class="px-3 py-2 rounded-md text-slate-700 dark:text-slate-200 hover:text-forest-900 dark:hover:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800">Tentang LMS</a>
        <a href="#layanan" class="px-3 py-2 rounded-md text-slate-700 dark:text-slate-200 hover:text-forest-900 dark:hover:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800">Layanan Akademik</a>
        <a href="#prodi" class="px-3 py-2 rounded-md text-slate-700 dark:text-slate-200 hover:text-forest-900 dark:hover:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800">Program Studi</a>
        <a href="#bantuan" class="px-3 py-2 rounded-md text-slate-700 dark:text-slate-200 hover:text-forest-900 dark:hover:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800">Bantuan Akun</a>
      </nav>

      <div class="flex items-center gap-2 shrink-0">
        <button type="button" data-theme-toggle onclick="(function(){try{var k='pkl_theme';var m=localStorage.getItem(k)||'light';var next=(document.documentElement.classList.contains('dark')?'light':'dark');localStorage.setItem(k,next);if(next==='dark')document.documentElement.classList.add('dark');else document.documentElement.classList.remove('dark');}catch(e){}})()" class="inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800" aria-label="Ganti tema" title="Ganti tema terang/gelap">
          <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
          <svg class="w-4 h-4 hidden dark:block" fill="currentColor" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
        </button>

        @guest
          <button type="button" id="btnLoginHeader" class="btn-open-login-modal inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-forest-900 hover:bg-forest-800 text-white text-sm font-bold shadow-sm transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
            Masuk LMS
          </button>
        @else
          <a href="{{ route('tugas.index') }}" id="userLoggedBadge" class="user-logged-in-badge inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800">
            <span class="user-avatar-initial inline-flex items-center justify-center w-7 h-7 rounded-full bg-amber-600 text-white text-xs font-extrabold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <span id="userNameDisplay" class="text-sm font-semibold text-slate-800 dark:text-slate-100 max-w-[140px] truncate">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
          </a>
        @endguest

        <button type="button" class="js-open-hidebar lg:hidden inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800" aria-label="Menu">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>
  </header>

  <!-- Mobile/Utility Drawer (kept for existing JS hooks) -->
  <div class="hidebar-overlay fixed inset-0 bg-black/40 z-40 opacity-0 pointer-events-none" id="hidebarOverlay"></div>
  <aside class="hidebar-panel fixed top-0 right-0 h-full w-[320px] max-w-[88vw] bg-white dark:bg-slate-950 border-l border-slate-200 dark:border-slate-800 z-50 translate-x-full transition-transform duration-200" id="hidebarPanel" aria-label="Menu">
    <div class="h-16 px-4 flex items-center justify-between border-b border-slate-200 dark:border-slate-800">
      <span class="font-bold text-slate-900 dark:text-white">Menu & Informasi</span>
      <button type="button" class="btn-close-hidebar w-8 h-8 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800" id="btnCloseHidebar" aria-label="Tutup">✕</button>
    </div>
    <div class="p-4 space-y-5 overflow-y-auto h-[calc(100%-4rem)] text-sm">
      <div class="space-y-1">
        <a href="#tentang" class="hidebar-link block px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">Tentang LMS</a>
        <a href="#layanan" class="hidebar-link block px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">Layanan Akademik</a>
        <a href="#prodi" class="hidebar-link block px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">Program Studi</a>
        <a href="#bantuan" class="hidebar-link block px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">Bantuan Akun</a>
        @auth
          <a href="{{ route('tugas.index') }}" class="hidebar-link block px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">Tugas Kuliah</a>
          <a href="{{ route('modul.index') }}" class="hidebar-link block px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">Modul Kuliah</a>
        @endauth
      </div>
      <div>
        <div class="text-xs font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Program Studi FT UNMUL</div>
        <ul class="space-y-1">
          <li><a href="https://ts.ft.unmul.ac.id/" target="_blank" class="hidebar-link flex items-center justify-between px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800"><span class="hidebar-link-text">Teknik Sipil</span><span class="hidebar-arrow text-slate-400">›</span></a></li>
          <li><a href="https://s1tambang.ft.unmul.ac.id/" target="_blank" class="hidebar-link flex items-center justify-between px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800"><span class="hidebar-link-text">Teknik Pertambangan</span><span class="hidebar-arrow text-slate-400">›</span></a></li>
          <li><a href="https://informatika.ft.unmul.ac.id/" target="_blank" class="hidebar-link flex items-center justify-between px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800"><span class="hidebar-link-text">Informatika</span><span class="hidebar-arrow text-slate-400">›</span></a></li>
          <li><a href="https://tekling.ft.unmul.ac.id/" target="_blank" class="hidebar-link flex items-center justify-between px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800"><span class="hidebar-link-text">Teknik Lingkungan</span><span class="hidebar-arrow text-slate-400">›</span></a></li>
          <li><a href="https://ie.ft.unmul.ac.id/" target="_blank" class="hidebar-link flex items-center justify-between px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800"><span class="hidebar-link-text">Teknik Industri</span><span class="hidebar-arrow text-slate-400">›</span></a></li>
          <li><a href="https://che.ft.unmul.ac.id/" target="_blank" class="hidebar-link flex items-center justify-between px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800"><span class="hidebar-link-text">Teknik Kimia</span><span class="hidebar-arrow text-slate-400">›</span></a></li>
          <li><a href="https://geologi.ft.unmul.ac.id/" target="_blank" class="hidebar-link flex items-center justify-between px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800"><span class="hidebar-link-text">Teknik Geologi</span><span class="hidebar-arrow text-slate-400">›</span></a></li>
          <li><a href="https://si.ft.unmul.ac.id/" target="_blank" class="hidebar-link flex items-center justify-between px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800"><span class="hidebar-link-text">Sistem Informasi</span><span class="hidebar-arrow text-slate-400">›</span></a></li>
          <li><a href="https://ft.unmul.ac.id/academic/prodi-s1-arsitektur-mi" target="_blank" class="hidebar-link flex items-center justify-between px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800"><span class="hidebar-link-text">Arsitektur</span><span class="hidebar-arrow text-slate-400">›</span></a></li>
          <li><a href="https://ft.unmul.ac.id/academic/prodi-s1-perencanaan-wilayah-dan-kota" target="_blank" class="hidebar-link flex items-center justify-between px-3 py-2 rounded-md hover:bg-slate-100 dark:hover:bg-slate-800"><span class="hidebar-link-text">Perencanaan Wilayah & Kota</span><span class="hidebar-arrow text-slate-400">›</span></a></li>
        </ul>
      </div>
    </div>
  </aside>
  <script>
    window.__hidebarInlineInit = true;
    (function(){
      var p=document.getElementById('hidebarPanel'), o=document.getElementById('hidebarOverlay'), b=document.getElementById('btnCloseHidebar');
      function open(){
        if(p){ p.classList.add('active'); p.classList.remove('translate-x-full'); p.style.transform='translateX(0)'; }
        if(o){ o.classList.add('active'); o.classList.remove('opacity-0','pointer-events-none'); }
        document.body.style.overflow='hidden';
      }
      function close(){
        if(p){ p.classList.remove('active'); p.classList.add('translate-x-full'); p.style.transform=''; }
        if(o){ o.classList.remove('active'); o.classList.add('opacity-0','pointer-events-none'); }
        document.body.style.overflow='';
      }
      document.querySelectorAll('.js-open-hidebar').forEach(function(el){ el.addEventListener('click', function(e){ e.preventDefault(); open(); }); });
      if(b) b.addEventListener('click', close);
      if(o) o.addEventListener('click', close);
      if(p) p.querySelectorAll('a.hidebar-link').forEach(function(a){ a.addEventListener('click', function(){ if(a.getAttribute('href') && a.getAttribute('href').startsWith('#')) close(); }); });
      document.addEventListener('keydown', function(e){ if(e.key === 'Escape') close(); });
    })();
  </script>

  <!-- LOGIN / FORGOT PASSWORD MODAL (IDs & flows preserved for loginpage.js and routes) -->
  <div class="modal-overlay fixed inset-0 z-50 items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" id="loginModalOverlay">
    <div class="modal-card relative w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 p-6 sm:p-7 max-h-[92vh] overflow-y-auto">
      <button type="button" class="btn-close-modal absolute top-3 right-3 w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-white hover:bg-rose-500 flex items-center justify-center" id="btnCloseModal" aria-label="Tutup">✕</button>

      <!-- LOGIN VIEW -->
      <div class="modal-view" id="loginView">
        <div class="flex items-center gap-3 mb-5">
          <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL" class="w-11 h-11 object-contain">
          <div class="leading-tight">
            <div class="text-xs font-extrabold tracking-wide text-slate-900 dark:text-white uppercase">Fakultas Teknik</div>
            <div class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 uppercase">Universitas Mulawarman</div>
          </div>
        </div>
        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Masuk LMS</h2>
        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 mb-4">Masukkan Nomor Induk (NIM/NIP) dan kata sandi akun Anda.</p>

        @if (session('status'))
          <div class="mb-4 text-xs font-semibold text-emerald-700 bg-emerald-50 dark:bg-emerald-500/10 dark:text-emerald-300 p-3 rounded-xl border border-emerald-200 dark:border-emerald-500/30">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
          <div class="mb-4 p-3 bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/30 text-rose-700 dark:text-rose-300 text-xs rounded-xl">
            <ul class="space-y-1">@foreach ($errors->all() as $error)<li>• {{ $error }}</li>@endforeach</ul>
          </div>
        @endif
        <div id="loginAlertBox" class="hidden mb-4 p-3 bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/30 text-rose-700 dark:text-rose-300 text-xs rounded-xl font-semibold"></div>

        <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-4">
          @csrf
          <div>
            <label for="inputNomerIndukLogin" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Nomor Induk (NIM / NIP)</label>
            <input type="text" id="inputNomerIndukLogin" name="nomer_induk" value="{{ old('nomer_induk') }}" required autofocus autocomplete="username" placeholder="Masukkan NIM / NIP Anda" class="w-full px-3.5 py-2.5 border border-slate-300 dark:border-slate-600 rounded-xl text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-forest-900/20 dark:focus:ring-emerald-500/30 focus:border-forest-900 dark:focus:border-emerald-500 transition">
          </div>
          <div>
            <label for="inputPasswordLogin" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Kata Sandi</label>
            <div class="relative">
              <input type="password" id="inputPasswordLogin" name="password" required minlength="8" autocomplete="current-password" placeholder="Masukkan kata sandi (min. 8 karakter)" class="w-full pl-3.5 pr-11 py-2.5 border border-slate-300 dark:border-slate-600 rounded-xl text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-forest-900/20 dark:focus:ring-emerald-500/30 focus:border-forest-900 dark:focus:border-emerald-500 transition">
              <button type="button" onclick="togglePasswordVisibility('inputPasswordLogin', this)" class="absolute right-0 top-0 h-full px-3.5 flex items-center text-slate-400 hover:text-forest-900 dark:hover:text-emerald-400 transition focus:outline-none" title="Tampilkan Password" aria-label="Tampilkan Password">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              </button>
            </div>
          </div>
          <div class="flex items-center justify-between text-xs pt-1">
            <label class="flex items-center gap-2 cursor-pointer select-none text-slate-600 dark:text-slate-300 font-medium">
              <input type="checkbox" name="remember" class="rounded border-slate-300 text-forest-900 focus:ring-forest-900"> Ingat Saya
            </label>
            <a href="#" id="linkToForgotPassword" class="text-amber-700 dark:text-amber-400 font-semibold hover:underline">Lupa kata sandi?</a>
          </div>
          <button type="submit" id="btnLoginSubmit" class="w-full py-3 bg-forest-900 hover:bg-forest-800 text-white font-bold rounded-xl shadow-sm text-sm transition">Masuk ke LMS</button>
        </form>

        <p class="text-center mt-5 text-xs text-slate-600 dark:text-slate-400">Akun LMS dibuat oleh <strong>Operator Fakultas</strong>.<br>
          <a href="https://wa.me/6287721685155?text=Halo%20Admin%2FOperator%2C%20saya%20ingin%20mengajukan%20pembuatan%20akun%20LMS.%20Berikut%20data%20diri%20saya%3A%0A%0ANama%20Lengkap%3A%20%0AStatus%20Registrasi%20(Mahasiswa%2FDosen)%3A%20%0ANomor%20Induk%20(NIM%2FNIP)%3A%20%0AEmail%20Aktif%3A%20%0APassword%20yang%20diinginkan%3A%20%0A%0AMohon%20bantuannya%20untuk%20dibuatkan%20akun.%20Terima%20kasih" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 mt-2 px-4 py-2 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-300 dark:border-emerald-500/30 text-emerald-800 dark:text-emerald-300 hover:bg-emerald-600 hover:text-white transition font-bold">Hubungi Operator Fakultas via WhatsApp</a>
        </p>
      </div>

      <!-- FORGOT PASSWORD STEP 1 (preserved IDs/structure) -->
      <div class="modal-view hidden" id="forgotPasswordView">
        <div class="flex items-center gap-3 mb-5">
          <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL" class="w-11 h-11 object-contain">
          <div class="leading-tight">
            <div class="text-xs font-extrabold tracking-wide text-slate-900 dark:text-white uppercase">Fakultas Teknik</div>
            <div class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 uppercase">Universitas Mulawarman</div>
          </div>
        </div>
        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Lupa Kata Sandi?</h2>
        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 mb-3">Verifikasi akun dengan NIM/NIP & email untuk mereset kata sandi.</p>
        <div id="forgotAlertBox" class="hidden mb-3 p-3 rounded-xl text-xs font-semibold"></div>

        <form id="forgotPasswordForm" class="space-y-3">
          @csrf
          <div>
            <label for="forgotNomerInduk" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1">Nomor Induk (NIM / NIP)</label>
            <input type="text" id="forgotNomerInduk" name="nomer_induk" required placeholder="Contoh: 2109106001 / 19850101..." class="w-full px-3.5 py-2 border border-slate-300 dark:border-slate-600 rounded-xl text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:border-forest-900 focus:ring-1 focus:ring-forest-900 transition">
          </div>
          <div>
            <label for="forgotEmail" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1">Email Terdaftar</label>
            <div class="flex gap-2">
              <input type="email" id="forgotEmail" name="email" required placeholder="nama@unmul.ac.id" class="flex-1 px-3.5 py-2 border border-slate-300 dark:border-slate-600 rounded-xl text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:border-forest-900 focus:ring-1 focus:ring-forest-900 transition">
              <button type="button" id="btnForgotSendCode" class="shrink-0 px-3 py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl text-xs whitespace-nowrap transition flex items-center justify-center gap-1.5">
                <span id="btnForgotSendCodeText">Kirim Verifikasi</span>
              </button>
            </div>
          </div>
          <div>
            <label for="forgotCode" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1">Kode Verifikasi (6 Digit)</label>
            <input type="text" id="forgotCode" name="code" required maxlength="6" inputmode="numeric" placeholder="Masukkan 6 digit kode dari email" class="w-full px-3.5 py-2 border border-slate-300 dark:border-slate-600 rounded-xl text-sm tracking-widest font-mono font-bold bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:border-forest-900 focus:ring-1 focus:ring-forest-900 transition">
            <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 block">Klik "Kirim Verifikasi" untuk mendapatkan kode.</span>
          </div>
          <button type="submit" id="btnForgotVerify" class="w-full py-2.5 bg-forest-900 hover:bg-forest-800 text-white font-bold rounded-xl text-sm transition">Verifikasi Kode</button>
        </form>
        <p class="text-center mt-4 text-xs text-slate-600 dark:text-slate-400">Sudah ingat kata sandi? <a href="#" id="linkForgotToLogin" class="text-amber-700 dark:text-amber-400 font-semibold hover:underline">Masuk di sini</a></p>
      </div>

      <!-- FORGOT PASSWORD STEP 2 (preserved IDs/structure) -->
      <div class="modal-view hidden" id="forgotResetView">
        <div class="flex items-center gap-3 mb-5">
          <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL" class="w-11 h-11 object-contain">
          <div class="leading-tight">
            <div class="text-xs font-extrabold tracking-wide text-slate-900 dark:text-white uppercase">Fakultas Teknik</div>
            <div class="text-[11px] font-semibold text-slate-600 dark:text-slate-400 uppercase">Universitas Mulawarman</div>
          </div>
        </div>
        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Verifikasi Berhasil</h2>
        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 mb-3">Silakan buat kata sandi baru untuk akun Anda.</p>

        <form id="forgotResetForm" class="space-y-3">
          @csrf
          <div>
            <label for="forgotPassword" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1">Kata Sandi Baru</label>
            <div class="relative">
              <input type="password" id="forgotPassword" name="password" required minlength="8" placeholder="Min. 8 karakter" class="w-full px-3.5 py-2 pr-10 border border-slate-300 dark:border-slate-600 rounded-xl text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:border-forest-900 focus:ring-1 focus:ring-forest-900 transition">
              <button type="button" onclick="togglePasswordVisibility('forgotPassword', this)" class="absolute right-0 top-0 h-full px-3 flex items-center text-slate-400 hover:text-forest-900 dark:hover:text-emerald-400" aria-label="Tampilkan Password">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              </button>
            </div>
          </div>
          <div>
            <label for="forgotPasswordConfirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1">Konfirmasi Kata Sandi Baru</label>
            <div class="relative">
              <input type="password" id="forgotPasswordConfirmation" name="password_confirmation" required minlength="8" placeholder="Ulangi kata sandi baru" class="w-full px-3.5 py-2 pr-10 border border-slate-300 dark:border-slate-600 rounded-xl text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:outline-none focus:border-forest-900 focus:ring-1 focus:ring-forest-900 transition">
              <button type="button" onclick="togglePasswordVisibility('forgotPasswordConfirmation', this)" class="absolute right-0 top-0 h-full px-3 flex items-center text-slate-400 hover:text-forest-900 dark:hover:text-emerald-400" aria-label="Tampilkan Password">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              </button>
            </div>
          </div>
          <button type="submit" id="btnForgotSubmit" class="w-full py-2.5 bg-forest-900 hover:bg-forest-800 text-white font-bold rounded-xl text-sm transition">Simpan Kata Sandi Baru</button>
        </form>
        <p class="text-center mt-4 text-xs text-slate-600 dark:text-slate-400">Sudah ingat kata sandi? <a href="#" id="linkResetToLogin" class="text-amber-700 dark:text-amber-400 font-semibold hover:underline">Masuk di sini</a></p>
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
      btn.innerHTML = isPassword
        ? '<svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>'
        : '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>';
    }
  </script>

  <main>
    <!-- Hero -->
    <section id="tentang" class="hero-bg border-b border-slate-200 dark:border-slate-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-14 items-start">
          <div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-extrabold tracking-wider uppercase bg-emerald-100 text-forest-900 dark:bg-emerald-500/15 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30">Portal Akademik Terpadu</span>
            <h1 class="mt-4 text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-tight text-slate-900 dark:text-white">
              Sistem Manajemen Pembelajaran<br class="hidden sm:block"> Fakultas Teknik
            </h1>
            <p class="mt-4 text-base sm:text-lg text-slate-700 dark:text-slate-300 max-w-2xl">
              Platform resmi layanan pembelajaran digital bagi mahasiswa dan dosen Fakultas Teknik Universitas Mulawarman. Sistem ini mendukung pengelolaan modul perkuliahan, pengumpulan tugas, serta pencatatan evaluasi dan penilaian secara terintegrasi.
            </p>
            <p class="mt-3 text-sm sm:text-base text-slate-600 dark:text-slate-400 max-w-2xl">
              Akses akun menggunakan Nomor Induk (NIM/NIP) yang terdaftar dan dikelola oleh Operator Fakultas untuk menjamin keabsahan data akademik.
            </p>
            <div class="mt-6 flex flex-wrap items-center gap-3">
              @guest
                <button type="button" class="btn-open-login-modal inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-forest-900 hover:bg-forest-800 text-white font-bold shadow-sm">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                  Masuk ke LMS
                </button>
              @else
                <a href="{{ route('tugas.index') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-forest-900 hover:bg-forest-800 text-white font-bold shadow-sm">Buka Dashboard LMS</a>
              @endguest
              <a href="#layanan" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border border-slate-300 dark:border-slate-700 bg-white/70 dark:bg-slate-900/60 text-slate-800 dark:text-slate-100 font-semibold hover:border-forest-900 dark:hover:border-emerald-500">Lihat Layanan Akademik</a>
            </div>
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-3 max-w-2xl">
              <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/60 p-4">
                <div class="text-xs uppercase tracking-wider font-bold text-slate-500 dark:text-slate-400">Pengguna</div>
                <div class="mt-1 font-semibold text-slate-900 dark:text-white">Mahasiswa & Dosen</div>
              </div>
              <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/60 p-4">
                <div class="text-xs uppercase tracking-wider font-bold text-slate-500 dark:text-slate-400">Akses</div>
                <div class="mt-1 font-semibold text-slate-900 dark:text-white">Berbasis NIM/NIP</div>
              </div>
              <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/60 p-4">
                <div class="text-xs uppercase tracking-wider font-bold text-slate-500 dark:text-slate-400">Cakupan</div>
                <div class="mt-1 font-semibold text-slate-900 dark:text-white">10 Program Studi FT</div>
              </div>
            </div>
          </div>

          <!-- Right: Login / Access Card -->
          <div class="lg:sticky lg:top-24">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-6 sm:p-7">
              <div class="flex items-center gap-3 mb-4">
                <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL" class="w-12 h-12 object-contain">
                <div>
                  <div class="text-xs font-extrabold uppercase tracking-wide text-slate-900 dark:text-white">Fakultas Teknik UNMUL</div>
                  <div class="text-sm font-semibold text-slate-600 dark:text-slate-400">Akses Sistem LMS</div>
                </div>
              </div>

              @guest
                <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Masuk ke LMS</h2>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 mb-5">Gunakan Nomor Induk (NIM/NIP) dan kata sandi yang telah terdaftar.</p>
                <ul class="space-y-2 text-sm text-slate-700 dark:text-slate-300 mb-5">
                  <li class="flex gap-2"><span class="text-emerald-700 dark:text-emerald-400">•</span><span>Autentikasi menggunakan NIM/NIP dan kata sandi akun.</span></li>
                  <li class="flex gap-2"><span class="text-emerald-700 dark:text-emerald-400">•</span><span>Akun dibuat dan dikelola oleh Operator Fakultas.</span></li>
                  <li class="flex gap-2"><span class="text-emerald-700 dark:text-emerald-400">•</span><span>Pemulihan kata sandi tersedia melalui verifikasi terdaftar.</span></li>
                </ul>
                <button type="button" class="btn-open-login-modal w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-forest-900 hover:bg-forest-800 text-white font-bold shadow-sm">
                  Buka Formulir Masuk
                </button>
                <div class="mt-4 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                  Belum memiliki akun atau mengalami kendala akses?
                  <a href="https://wa.me/6287721685155?text=Halo%20Admin%2FOperator%2C%20saya%20ingin%20mengajukan%20pembuatan%20akun%20LMS.%20Berikut%20data%20diri%20saya%3A%0A%0ANama%20Lengkap%3A%20%0AStatus%20Registrasi%20(Mahasiswa%2FDosen)%3A%20%0ANomor%20Induk%20(NIM%2FNIP)%3A%20%0AEmail%20Aktif%3A%20%0APassword%20yang%20diinginkan%3A%20%0A%0AMohon%20bantuannya%20untuk%20dibuatkan%20akun.%20Terima%20kasih" target="_blank" rel="noopener noreferrer" class="text-emerald-800 dark:text-emerald-400 font-semibold hover:underline">Hubungi Operator Fakultas via WhatsApp</a>.
                </div>
              @else
                <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Akses Aktif</h2>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 mb-5">Anda telah masuk sebagai <strong>{{ auth()->user()->name }}</strong> ({{ ucfirst(auth()->user()->role) }}).</p>
                <div class="space-y-2">
                  <a href="{{ route('tugas.index') }}" class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl bg-forest-900 hover:bg-forest-800 text-white font-bold">Buka Tugas Kuliah</a>
                  <a href="{{ route('modul.index') }}" class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-100 font-semibold hover:bg-slate-50 dark:hover:bg-slate-800">Buka Modul Kuliah</a>
                </div>
              @endguest
            </div>
            <p class="mt-3 text-[11px] text-slate-500 dark:text-slate-400 text-center">Gunakan perangkat dan koneksi tepercaya saat mengakses layanan akademik.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Layanan Akademik -->
    <section id="layanan" class="py-14 lg:py-16 bg-white dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mb-8">
          <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Layanan Akademik LMS</h2>
          <p class="mt-2 text-slate-600 dark:text-slate-400">Fitur inti sistem yang mendukung kegiatan perkuliahan di lingkungan Fakultas Teknik Universitas Mulawarman.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-5">
          <article class="rounded-2xl border border-slate-200 dark:border-slate-800 p-6 bg-slate-50/70 dark:bg-slate-900/50">
            <div class="w-11 h-11 rounded-xl bg-emerald-100 dark:bg-emerald-500/15 text-forest-900 dark:text-emerald-300 flex items-center justify-center mb-4">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Modul Perkuliahan Digital</h3>
            <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">Repository materi ajar dan referensi perkuliahan yang dikelola langsung oleh dosen pengampu, dapat diakses sesuai hak pengguna.</p>
          </article>
          <article class="rounded-2xl border border-slate-200 dark:border-slate-800 p-6 bg-slate-50/70 dark:bg-slate-900/50">
            <div class="w-11 h-11 rounded-xl bg-amber-100 dark:bg-amber-500/15 text-amber-800 dark:text-amber-300 flex items-center justify-center mb-4">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Manajemen & Pengumpulan Tugas</h3>
            <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">Sistem penugasan terstruktur dengan informasi tenggat waktu serta mekanisme pengumpulan tautan/file tugas oleh mahasiswa.</p>
          </article>
          <article class="rounded-2xl border border-slate-200 dark:border-slate-800 p-6 bg-slate-50/70 dark:bg-slate-900/50">
            <div class="w-11 h-11 rounded-xl bg-slate-200 dark:bg-slate-700/50 text-slate-800 dark:text-slate-200 flex items-center justify-center mb-4">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Evaluasi & Penilaian Terintegrasi</h3>
            <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">Pencatatan hasil evaluasi dan penilaian tugas mahasiswa secara terintegrasi berbasis akun valid (NIM/NIP) untuk mendukung transparansi akademik.</p>
          </article>
        </div>
      </div>
    </section>

    <!-- Program Studi -->
    <section id="prodi" class="py-14 lg:py-16 bg-[#F8FAFC] dark:bg-[#0B0F19] border-b border-slate-200 dark:border-slate-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 mb-8">
          <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Program Studi Fakultas Teknik</h2>
            <p class="mt-2 text-slate-600 dark:text-slate-400">Tautan resmi ke laman 10 program studi di bawah Fakultas Teknik Universitas Mulawarman.</p>
          </div>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-3">
          @php
            $prodi = [
              ['Teknik Sipil', 'https://ts.ft.unmul.ac.id/'],
              ['Teknik Pertambangan', 'https://s1tambang.ft.unmul.ac.id/'],
              ['Informatika', 'https://informatika.ft.unmul.ac.id/'],
              ['Teknik Lingkungan', 'https://tekling.ft.unmul.ac.id/'],
              ['Teknik Industri', 'https://ie.ft.unmul.ac.id/'],
              ['Teknik Kimia', 'https://che.ft.unmul.ac.id/'],
              ['Teknik Geologi', 'https://geologi.ft.unmul.ac.id/'],
              ['Sistem Informasi', 'https://si.ft.unmul.ac.id/'],
              ['Arsitektur', 'https://ft.unmul.ac.id/academic/prodi-s1-arsitektur-mi'],
              ['Perencanaan Wilayah & Kota', 'https://ft.unmul.ac.id/academic/prodi-s1-perencanaan-wilayah-dan-kota'],
            ];
          @endphp
          @foreach($prodi as $p)
            <a href="{{ $p[1] }}" target="_blank" rel="noopener noreferrer" class="group rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3.5 hover:border-forest-900 dark:hover:border-emerald-500 hover:shadow-sm transition flex items-center justify-between gap-3">
              <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 group-hover:text-forest-900 dark:group-hover:text-emerald-300">{{ $p[0] }}</span>
              <svg class="w-4 h-4 text-slate-400 group-hover:text-forest-900 dark:group-hover:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
          @endforeach
        </div>
      </div>
    </section>

    <!-- Bantuan Akun -->
    <section id="bantuan" class="py-14 lg:py-16 bg-white dark:bg-slate-950">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-6">
          <div class="rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-7 bg-slate-50/70 dark:bg-slate-900/50">
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white">Panduan & Bantuan Akun</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-700 dark:text-slate-300 leading-relaxed">
              <li><strong>Aktivasi akun:</strong> Akun LMS dibuat oleh Operator/Admin Fakultas. Mahasiswa dan dosen mengajukan pembuatan akun dengan data identitas yang valid (NIM/NIP, nama, email).</li>
              <li><strong>Login:</strong> Masuk menggunakan Nomor Induk (NIM/NIP) dan kata sandi. Untuk mahasiswa, NIM harus terdaftar pada basis data kemahasiswaan yang digunakan sistem.</li>
              <li><strong>Lupa kata sandi:</strong> Gunakan fitur "Lupa kata sandi" pada formulir masuk (verifikasi NIM/NIP, email, dan kode) atau hubungi Operator Fakultas.</li>
              <li><strong>Kendala akses:</strong> Pastikan data akun benar dan layanan sistem aktif. Jika masalah berlanjut, hubungi kontak resmi fakultas/operator.</li>
            </ul>
          </div>
          <div class="rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-7">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Kontak & Informasi Resmi</h3>
            <div class="mt-4 space-y-3 text-sm text-slate-700 dark:text-slate-300">
              <p><span class="font-semibold text-slate-900 dark:text-white">Fakultas Teknik Universitas Mulawarman</span><br>Kampus Gunung Kelua, Jl. Sambaliung No. 9, Samarinda, Kalimantan Timur 75119</p>
              <p>Telp. (0541) 736834 &nbsp;|&nbsp; Fax. (0541) 749315</p>
              <div class="flex flex-wrap gap-2 pt-1">
                <a href="https://ft.unmul.ac.id" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 hover:border-forest-900 dark:hover:border-emerald-500 font-semibold text-slate-800 dark:text-slate-100">Laman FT UNMUL</a>
                <a href="https://unmul.ac.id" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 hover:border-forest-900 dark:hover:border-emerald-500 font-semibold text-slate-800 dark:text-slate-100">Portal UNMUL</a>
                <a href="https://wa.me/6287721685155?text=Halo%20Admin%2FOperator%2C%20saya%20membutuhkan%20bantuan%20terkait%20akun%20LMS%20FT%20UNMUL." target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-3 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold">Hubungi Operator (WhatsApp)</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-slate-100 dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <div class="grid md:grid-cols-3 gap-8">
        <div>
          <div class="flex items-center gap-3 mb-3">
            <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL" class="w-10 h-10 object-contain">
            <div class="leading-tight">
              <div class="font-extrabold text-slate-900 dark:text-white">Fakultas Teknik</div>
              <div class="text-xs font-semibold text-slate-600 dark:text-slate-400">Universitas Mulawarman</div>
            </div>
          </div>
          <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">Kampus Gunung Kelua, Jl. Sambaliung No. 9, Samarinda, Kalimantan Timur 75119<br>Telp. (0541) 736834 · Fax. (0541) 749315</p>
        </div>
        <div>
          <h4 class="font-bold text-slate-900 dark:text-white mb-3">Navigasi</h4>
          <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
            <li><a href="#tentang" class="hover:text-forest-900 dark:hover:text-emerald-400">Tentang LMS</a></li>
            <li><a href="#layanan" class="hover:text-forest-900 dark:hover:text-emerald-400">Layanan Akademik</a></li>
            <li><a href="#prodi" class="hover:text-forest-900 dark:hover:text-emerald-400">Program Studi</a></li>
            <li><a href="#bantuan" class="hover:text-forest-900 dark:hover:text-emerald-400">Bantuan Akun</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-bold text-slate-900 dark:text-white mb-3">Tautan Resmi</h4>
          <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
            <li><a href="https://unmul.ac.id" target="_blank" rel="noopener noreferrer" class="hover:text-forest-900 dark:hover:text-emerald-400">Portal Utama UNMUL</a></li>
            <li><a href="https://ft.unmul.ac.id" target="_blank" rel="noopener noreferrer" class="hover:text-forest-900 dark:hover:text-emerald-400">Fakultas Teknik UNMUL</a></li>
            @auth
              <li><a href="{{ route('tugas.index') }}" class="hover:text-forest-900 dark:hover:text-emerald-400">Tugas Kuliah</a></li>
              <li><a href="{{ route('modul.index') }}" class="hover:text-forest-900 dark:hover:text-emerald-400">Modul Kuliah</a></li>
            @endauth
          </ul>
        </div>
      </div>
      <div class="mt-8 pt-5 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-500 dark:text-slate-400">
        <span>&copy; {{ date('Y') }} Fakultas Teknik Universitas Mulawarman. Seluruh hak cipta dilindungi.</span>
        <span>Dikembangkan oleh Tim PKL SMK Negeri 1 Tenggarong.</span>
      </div>
    </div>
  </footer>

  <div class="toast-container fixed bottom-4 right-4 z-[60] space-y-2" id="toastContainer"></div>

  @vite(['resources/js/loginpage.js'])
</body>
</html>