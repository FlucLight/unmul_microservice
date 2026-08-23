<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modul Kuliah — Fakultas Teknik UNMUL</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        // Check theme immediately to prevent flashing
        if (localStorage.getItem('pkl_theme') === 'light') {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
        } else {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        }

        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#FF7A00',
                            hover: '#E06B00',
                            light: '#FFF0E6',
                            gradient: '#FF9225',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        *, *::before, *::after { 
            scrollbar-width: none; 
            -ms-overflow-style: none; 
        }
        *::-webkit-scrollbar { 
            display: none; 
            width: 0; 
            height: 0; 
        }
        ::selection { background: #FF7A00; color: #fff; }
        :focus-visible { outline: 2px solid #FF7A00; outline-offset: 2px; }

        /* Page Smooth Transition */
        .page-transition-wrapper {
            animation: pageFadeIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes pageFadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .page-exit {
            opacity: 0 !important;
            transform: translateY(-6px) !important;
            transition: opacity 0.2s cubic-bezier(0.4, 0, 0.2, 1), transform 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        /* Hidebar Drawer Animation */
        .profile-drawer {
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .profile-drawer.open {
            transform: translateX(0);
        }

        /* Neumorphic / Smooth Slider styling */
        .theme-slider-btn {
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.12);
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 dark:bg-[#0f172a] text-slate-800 dark:text-slate-100 antialiased flex flex-col">

    <!-- Ambient Subtle Background Elements -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute -top-40 left-1/4 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -right-40 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.03]" style="background-image:radial-gradient(circle at 1px 1px, currentColor 1px, transparent 0); background-size: 24px 24px;"></div>
    </div>

    <!-- MAIN HEADER BAR (COMPACT & UNIFIED) -->
    <header class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 sticky top-0 z-40 shadow-sm dark:shadow-lg dark:shadow-black/20 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">
                
                <!-- Left: Logo Kampus & Switcher Tabs -->
                <div class="flex items-center gap-3 sm:gap-6 min-w-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 shrink-0 group no-underline text-inherit">
                        <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL" class="w-9 h-9 sm:w-10 sm:h-10 object-contain drop-shadow-md group-hover:scale-105 transition-transform">
                        <div class="hidden sm:block leading-tight">
                            <span class="font-extrabold text-sm text-slate-900 dark:text-white block tracking-tight group-hover:text-orange-500 transition-colors">FAKULTAS TEKNIK</span>
                            <span class="font-semibold text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-widest block">UNIVERSITAS MULAWARMAN</span>
                        </div>
                    </a>

                    <!-- Page Navigation Switcher Tabs (Consistent Location) -->
                    <div class="flex items-center gap-1 bg-slate-100 dark:bg-slate-800/90 p-1 rounded-xl border border-slate-200 dark:border-slate-700/80 text-xs font-semibold shadow-inner">
                        <a href="{{ route('tugas.index') }}"
                           class="page-switch-link px-3 sm:px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 no-underline transition-all
                                  {{ request()->routeIs('tugas.*') ? 'bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white font-bold shadow-md shadow-orange-500/20 active-tab' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200/70 dark:hover:bg-slate-700/60' }}">
                            <svg class="w-3.5 h-3.5 {{ request()->routeIs('tugas.*') ? 'text-white' : 'text-slate-500 dark:text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            <span class="hidden md:inline">Tugas Kuliah</span><span class="md:hidden">Tugas</span>
                        </a>

                        <a href="{{ route('modul.index') }}"
                           class="page-switch-link px-3 sm:px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 no-underline transition-all
                                  {{ request()->routeIs('modul.*') ? 'bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white font-bold shadow-md shadow-orange-500/20 active-tab' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200/70 dark:hover:bg-slate-700/60' }}">
                            <svg class="w-3.5 h-3.5 {{ request()->routeIs('modul.*') ? 'text-white' : 'text-slate-500 dark:text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span class="hidden md:inline">Modul Kuliah</span><span class="md:hidden">Modul</span>
                        </a>

                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.pengguna') }}"
                           class="page-switch-link px-3 sm:px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 no-underline transition-all
                                  {{ request()->routeIs('admin.pengguna') ? 'bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white font-bold shadow-md shadow-orange-500/20 active-tab' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200/70 dark:hover:bg-slate-700/60' }}">
                            <svg class="w-3.5 h-3.5 {{ request()->routeIs('admin.pengguna') ? 'text-white' : 'text-slate-500 dark:text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span class="hidden md:inline">Manajemen Akun</span><span class="md:hidden">Akun</span>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Right: Slider Theme Switcher & Mini Profile Trigger Button -->
                <div class="flex items-center gap-3 shrink-0">
                    
                    <!-- THEME SLIDER SWITCH (Slider Pill) -->
<button type="button" onclick="toggleTheme()" class="theme-slider-btn relative hidden md:inline-flex items-center w-14 h-7 p-0.5 rounded-full cursor-pointer transition-colors duration-300 bg-slate-200 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 focus:outline-none" aria-label="Ganti Mode Tema" title="Ganti Tema (Kiri: Terang, Kanan: Gelap)">                        <!-- Left background track icon (Sun) -->
                        <span class="absolute left-1.5 flex items-center justify-center pointer-events-none opacity-80 dark:opacity-30 transition-opacity">
                            <svg class="w-3.5 h-3.5 text-amber-500 dark:text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                        </span>
                        <!-- Right background track icon (Moon) -->
                        <span class="absolute right-1.5 flex items-center justify-center pointer-events-none opacity-30 dark:opacity-80 transition-opacity">
                            <svg class="w-3.5 h-3.5 text-slate-400 dark:text-indigo-300" fill="currentColor" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                        </span>

                        <!-- Sliding Thumb -->
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-white dark:bg-slate-900 shadow-md transform transition-transform duration-300 translate-x-0 dark:translate-x-7 border border-slate-200 dark:border-slate-700 z-10 pointer-events-none">
                            <svg class="w-3.5 h-3.5 text-amber-500 inline dark:hidden" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                            <svg class="w-3.5 h-3.5 text-indigo-400 hidden dark:inline" fill="currentColor" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                        </span>
                    </button>

                    @auth
                    <!-- Mini Profile Hidebar Trigger Button (Space-Saving) -->
                    <button type="button" onclick="openProfileDrawer()" class="flex items-center gap-2 p-1.5 sm:pl-2.5 sm:pr-3 rounded-full bg-slate-100 dark:bg-slate-800/90 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 shadow-sm transition group" title="Buka Profil & Menu">
                        <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-[#FF7A00] to-[#FF9225] text-white font-extrabold text-xs flex items-center justify-center shadow-sm shrink-0">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <span class="hidden sm:block text-xs font-bold text-slate-800 dark:text-slate-200 max-w-[100px] truncate">
                            {{ auth()->user()->name }}
                        </span>
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    @endauth

                </div>
            </div>
        </div>
    </header>

    <!-- CONTENT WRAPPER WITH SMOOTH TRANSITION -->
    <div id="pageMainContent" class="page-transition-wrapper flex-1 relative z-10">

        <!-- Alert Notification Messages -->
        @if(session('success') || session('error') || $errorMessage)
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            @if(session('success'))
                <div class="p-3.5 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-300 dark:border-emerald-500/40 text-emerald-800 dark:text-emerald-200 rounded-xl text-xs font-semibold flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if(session('error') || $errorMessage)
                <div class="p-3.5 bg-rose-50 dark:bg-rose-950/60 border border-rose-300 dark:border-rose-500/40 text-rose-800 dark:text-rose-200 rounded-xl text-xs font-semibold flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-rose-600 dark:text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 8v5M12 16h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        <span>{{ session('error') ?? $errorMessage }}</span>
                    </div>
                </div>
            @endif
        </div>
        @endif

        <!-- Area Konten Utama -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            <!-- Top Title & Action Button -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider bg-orange-500/10 px-2.5 py-1 rounded-lg mb-1 border border-orange-500/20">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Modul & Materi Pembelajaran
                    </span>
                    <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Daftar Modul Kuliah</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Akses modul perkuliahan, slide presentasi, dan materi ajar Fakultas Teknik UNMUL.</p>
                </div>

                <!-- Tombol Tambah Modul Baru (Dosen & Admin) -->
                @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                    <button onclick="openAddModulModal()" class="inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white text-xs font-bold rounded-xl shadow-lg shadow-orange-500/25 active:scale-[0.98] transition duration-150 gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Tambah Modul Baru
                    </button>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- LEFT COLUMN: Ledger / Daftar Modul -->
                <div class="lg:col-span-8 space-y-4">
                    <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm dark:shadow-xl dark:shadow-black/20 overflow-hidden backdrop-blur-sm transition-colors duration-300">
                        
                        <div class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 px-5 py-3.5 flex items-center justify-between">
                            <div id="modul-table-title" class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <span>Semua Modul Kuliah</span>
                                <span id="filter-badge" class="hidden bg-orange-500/20 text-orange-600 dark:text-orange-400 border border-orange-500/30 px-2 py-0.5 rounded text-[10px] font-mono">Filter Aktif</span>
                            </div>
                            <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tanggal Unggah</span>
                        </div>

                        <div id="modul-list-container" class="divide-y divide-slate-100 dark:divide-slate-800/80">
                            @forelse($modulList as $modul)
                                @php
                                    $idModul = $modul['id_modul'] ?? $modul['id'] ?? null;
                                    $tglUpload = isset($modul['tanggal_diupload']) ? \Carbon\Carbon::parse($modul['tanggal_diupload'])->translatedFormat('j M Y, H:i') : '-';
                                    $fileUrl = $modul['file_modul'] ?? null;
                                @endphp
                                <div class="modul-row p-5 hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition duration-150 space-y-3" data-dosen="{{ strtolower($modul['nama_dosen'] ?? '') }}">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-orange-600 dark:text-orange-400 bg-orange-500/10 border border-orange-500/20 px-2 py-0.5 rounded-md">
                                                    Modul #{{ $idModul }}
                                                </span>
                                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                                                    • Dosen: <strong class="text-slate-800 dark:text-slate-300">{{ $modul['nama_dosen'] }}</strong>
                                                </span>
                                            </div>
                                            <h3 class="font-bold text-base text-slate-900 dark:text-white hover:text-orange-500 transition-colors truncate" title="{{ $modul['nama_modul'] }}">
                                                {{ $modul['nama_modul'] }}
                                            </h3>
                                        </div>

                                        <div class="flex items-center sm:flex-col sm:items-end justify-between gap-2 shrink-0">
                                            <span class="text-xs font-mono font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800/90 px-2.5 py-1 rounded-lg border border-slate-200 dark:border-slate-700/60">
                                                {{ $tglUpload }}
                                            </span>

                                            <div class="flex items-center gap-2">
                                                <!-- Link Buka File Modul -->
                                                @if(!empty($fileUrl))
                                                    <a href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white text-xs font-bold rounded-lg shadow-md shadow-orange-500/20 transition flex items-center gap-1.5 no-underline" title="Buka File / Google Drive Modul">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                        Buka Modul
                                                    </a>
                                                @endif

                                                <!-- Edit & Hapus Modul (Dosen & Admin) -->
                                                @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                                                    <button onclick='openEditModulModal({{ json_encode($modul) }})' class="p-1.5 text-slate-500 dark:text-slate-400 hover:text-orange-500 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700/60 rounded-lg transition" title="Ubah Modul">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                    </button>
                                                    <button type="button" onclick="confirmDelete('{{ route('modul.destroy', $idModul) }}', 'Modul: {{ addslashes($modul['nama_modul']) }}')" class="p-1.5 text-slate-500 dark:text-slate-400 hover:text-rose-500 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700/60 rounded-lg transition cursor-pointer" title="Hapus Modul">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-14 px-4 text-center">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 mx-auto flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                    <p class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Belum ada modul kuliah diunggah.</p>
                                    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                                        <p class="text-slate-400 dark:text-slate-500 text-xs mt-1">Klik &ldquo;Tambah Modul Baru&rdquo; untuk mulai membagikan materi.</p>
                                    @endif
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>

                <!-- RIGHT COLUMN: Dosen Pengampu Filter -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 sm:p-5 shadow-sm dark:shadow-xl dark:shadow-black/20 backdrop-blur-sm transition-colors duration-300">
                        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200 dark:border-slate-800">
                            <div>
                                <h3 class="font-bold text-sm text-slate-900 dark:text-white">Dosen Pengampu</h3>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">Filter modul berdasarkan pengajar</p>
                            </div>
                            <button onclick="filterByDosen(null)" id="reset-filter-btn" class="hidden text-[11px] bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-orange-600 dark:text-orange-400 font-semibold px-2.5 py-1 rounded-lg border border-slate-200 dark:border-slate-700 transition">
                                Tampilkan Semua
                            </button>
                        </div>

                        @php
                            $groupedDosen = collect($modulList)->groupBy('nama_dosen');
                        @endphp

                        <div class="space-y-2">
                            <div onclick="filterByDosen(null)" id="dosen-card-all" class="dosen-card cursor-pointer bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white border border-orange-400/50 rounded-xl p-3 flex items-center justify-between transition shadow-md shadow-orange-500/20">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-black/20 text-white font-bold flex items-center justify-center text-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-xs">Semua Dosen</p>
                                        <p class="text-[10px] text-white/80">Tampilkan seluruh modul ({{ count($modulList) }})</p>
                                    </div>
                                </div>
                                <span id="badge-all-dosen" class="text-[10px] font-bold bg-black/20 text-white px-2 py-0.5 rounded-md">Aktif</span>
                            </div>

                            @forelse($groupedDosen as $dosenName => $items)
                                <div onclick="filterByDosen('{{ addslashes($dosenName) }}')" 
                                     data-dosen-name="{{ strtolower($dosenName) }}"
                                     class="dosen-card cursor-pointer bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/60 rounded-xl p-3 flex items-center justify-between hover:border-orange-500/50 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-8 h-8 rounded-lg bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold flex items-center justify-center text-xs shrink-0">
                                            {{ strtoupper(substr($dosenName ?? '?', 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-xs text-slate-800 dark:text-slate-200 truncate">{{ $dosenName }}</p>
                                            <p class="text-[10px] text-slate-500 dark:text-slate-400 truncate">{{ count($items) }} Modul Diunggah</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <span class="text-xs text-orange-600 dark:text-orange-400 font-mono font-bold bg-orange-500/10 px-2 py-0.5 rounded-md border border-orange-500/20">
                                            {{ count($items) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-slate-50 dark:bg-slate-800/30 border border-dashed border-slate-200 dark:border-slate-800 rounded-xl p-4 text-center">
                                    <p class="text-slate-400 dark:text-slate-500 text-xs">Belum ada dosen pengunggah modul.</p>
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>

            </div>

        </main>

    </div>


    <!-- HIDEBAR (MINI PROFILE & DRAWER MENU) -->
    @auth
    <div id="profileDrawerOverlay" onclick="closeProfileDrawer()" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden transition-opacity"></div>
    <aside id="profileDrawer" class="profile-drawer fixed top-0 right-0 bottom-0 w-80 sm:w-96 bg-white dark:bg-slate-900 border-l border-slate-200 dark:border-slate-800 shadow-2xl z-50 flex flex-col justify-between overflow-y-auto">
        
        <!-- Drawer Header -->
        <div class="p-5 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-700 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <h3 class="font-bold text-sm text-slate-900 dark:text-white">Profil Pengguna</h3>
            </div>
            <button type="button" onclick="closeProfileDrawer()" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-500 dark:text-slate-400 flex items-center justify-center transition" aria-label="Tutup Menu">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="p-5 space-y-5 flex-1">
            
            <!-- User Info Card -->
            <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/70 rounded-2xl p-4 text-center space-y-3">
                <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-[#FF7A00] to-[#FF9225] text-white font-extrabold text-2xl mx-auto flex items-center justify-center shadow-lg shadow-orange-500/20">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <h4 class="font-bold text-sm text-slate-900 dark:text-white">{{ auth()->user()->name }}</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-mono mt-0.5">{{ auth()->user()->nomer_induk ?? auth()->user()->email }}</p>
                </div>
                <div class="inline-block px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider rounded-full
                    @if(auth()->user()->isDosen()) bg-purple-500/15 text-purple-600 dark:text-purple-300 border border-purple-400/30
                    @elseif(auth()->user()->isAdmin()) bg-rose-500/15 text-rose-600 dark:text-rose-300 border border-rose-400/30
                    @else bg-emerald-500/15 text-emerald-600 dark:text-emerald-300 border border-emerald-400/30 @endif">
                    {{ auth()->user()->role ?? 'User' }}
                </div>
            </div>

            <!-- Theme Toggle Section with Slider -->
            <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/70 rounded-2xl p-4 flex items-center justify-between">
                <div>
                    <span class="block text-xs font-bold text-slate-900 dark:text-white">Pilihan Tema</span>
                    <span class="block text-[11px] text-slate-500 dark:text-slate-400" id="themeStatusLabel">Mode Gelap Aktif</span>
                </div>
                
                <!-- Slider Component -->
                <button type="button" onclick="toggleTheme()" class="theme-slider-btn relative inline-flex items-center w-14 h-7 p-0.5 rounded-full cursor-pointer transition-colors duration-300 bg-slate-200 dark:bg-slate-700 border border-slate-300 dark:border-slate-600 focus:outline-none" aria-label="Ganti Mode Tema">
                    <span class="absolute left-1.5 flex items-center justify-center opacity-80 dark:opacity-30">
                        <svg class="w-3.5 h-3.5 text-amber-500 dark:text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                    </span>
                    <span class="absolute right-1.5 flex items-center justify-center opacity-30 dark:opacity-80">
                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-indigo-300" fill="currentColor" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                    </span>
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-white dark:bg-slate-900 shadow-md transform transition-transform duration-300 translate-x-0 dark:translate-x-7 border border-slate-200 dark:border-slate-700 z-10">
                        <svg class="w-3.5 h-3.5 text-amber-500 inline dark:hidden" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                        <svg class="w-3.5 h-3.5 text-indigo-400 hidden dark:inline" fill="currentColor" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                    </span>
                </button>
            </div>

            <!-- Quick Navigation Menu -->
            <div class="space-y-1.5">
                <span class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">
                    Menu Navigasi
                </span>
                <a href="{{ route('home') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 hover:bg-orange-500/10 hover:text-orange-500 border border-slate-200 dark:border-slate-700/60 text-xs font-semibold text-slate-700 dark:text-slate-300 transition no-underline">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Halaman Beranda
                </a>
                <a href="{{ route('tugas.index') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 hover:bg-orange-500/10 hover:text-orange-500 border border-slate-200 dark:border-slate-700/60 text-xs font-semibold text-slate-700 dark:text-slate-300 transition no-underline">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Tugas Kuliah
                </a>
                <a href="{{ route('modul.index') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white border border-transparent text-xs font-bold shadow-md shadow-orange-500/20 transition no-underline">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Modul Kuliah
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.pengguna') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 hover:bg-orange-500/10 hover:text-orange-500 border border-slate-200 dark:border-slate-700/60 text-xs font-semibold text-slate-700 dark:text-slate-300 transition no-underline">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Manajemen Akun
                </a>
                @endif
            </div>

            <!-- API Services Status In Drawer -->
            <div class="p-3.5 bg-slate-50 dark:bg-slate-800/40 rounded-xl border border-slate-200 dark:border-slate-700/60 space-y-2">
                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status Microservices</span>
                <div class="space-y-1.5 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 dark:text-slate-400 text-[11px]">API Tugas (8000)</span>
                        @if($apiConnected)
                            <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Online</span>
                        @else
                            <span class="text-[10px] font-bold text-rose-500 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Offline</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 dark:text-slate-400 text-[11px]">API Kumpul (8001)</span>
                        @if($api2Connected)
                            <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Online</span>
                        @else
                            <span class="text-[10px] font-bold text-rose-500 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Offline</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 dark:text-slate-400 text-[11px]">API Modul (8002)</span>
                        @if($api3Connected)
                            <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Online</span>
                        @else
                            <span class="text-[10px] font-bold text-rose-500 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Offline</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Drawer Footer (Logout Button) -->
        <div class="p-5 border-t border-slate-200 dark:border-slate-800">
            <button type="button" onclick="openLogoutModal()" class="w-full py-2.5 px-4 bg-rose-500/10 hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 border border-rose-500/30 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar dari Akun
            </button>
        </div>

    </aside>
    @endauth


    <!-- MODAL TAMBAH MODUL (DOSEN & ADMIN) -->
    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
    <div id="addModulModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700/80">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Tambah Modul Kuliah Baru
                </h3>
                <button onclick="closeAddModulModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form action="{{ route('modul.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama / Judul Modul</label>
                    <input type="text" name="nama_modul" required placeholder="Contoh: Modul 1 - Pemrograman Web Laravel" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Dosen Pengampu</label>
                    <input type="text" name="nama_dosen" value="{{ auth()->user()->name }}" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Link File / Google Drive Modul <span class="text-rose-500">*</span></label>
                    <input type="url" name="file_modul" required placeholder="https://drive.google.com/file/d/..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">Pastikan link Google Drive sudah diatur agar dapat diakses oleh mahasiswa.</p>
                </div>

                <div class="flex justify-end gap-2.5 pt-2">
                    <button type="button" onclick="closeAddModulModal()" class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition">Batal</button>
                    <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white rounded-xl text-xs font-bold shadow-md shadow-orange-500/20 transition">Simpan Modul</button>
                </div>
            </form>
        </div>
    </div>


    <!-- MODAL EDIT MODUL (DOSEN & ADMIN) -->
    <div id="editModulModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700/80">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Ubah Modul Kuliah
                </h3>
                <button onclick="closeEditModulModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form id="editModulForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama / Judul Modul</label>
                    <input type="text" id="edit_nama_modul" name="nama_modul" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Dosen Pengampu</label>
                    <input type="text" id="edit_nama_dosen" name="nama_dosen" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Link File / Google Drive Modul</label>
                    <input type="url" id="edit_file_modul" name="file_modul" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>

                <div class="flex justify-end gap-2.5 pt-2">
                    <button type="button" onclick="closeEditModulModal()" class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition">Batal</button>
                    <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white rounded-xl text-xs font-bold shadow-md shadow-orange-500/20 transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endif


    <!-- MODAL CUSTOM POPUP DELETE (Poin 3) -->
    <div id="deleteConfirmModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700/80 space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-rose-500/15 text-rose-600 dark:text-rose-400 flex items-center justify-center font-bold text-lg shrink-0">!</div>
                <div>
                    <h3 class="font-bold text-base text-slate-900 dark:text-white">Konfirmasi Hapus</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5" id="deleteTargetTitle">Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
            </div>

            <form id="deleteConfirmForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2 pt-2 border-t border-slate-200 dark:border-slate-800">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-md shadow-rose-500/20 transition">Ya, Hapus Data</button>
                </div>
            </form>
        </div>
    </div>


    <!-- MODAL CUSTOM POPUP LOGOUT (Poin 4) -->
    <div id="logoutConfirmModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700/80 space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-rose-500/15 text-rose-600 dark:text-rose-400 flex items-center justify-center font-bold text-lg shrink-0">!</div>
                <div>
                    <h3 class="font-bold text-base text-slate-900 dark:text-white">Konfirmasi Keluar</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Apakah Anda yakin ingin keluar dari akun Anda?</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <div class="flex justify-end gap-2 pt-2 border-t border-slate-200 dark:border-slate-800">
                    <button type="button" onclick="closeLogoutModal()" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-md shadow-rose-500/20 transition">Ya, Keluar</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        let currentSelectedDosen = null;

        // Theme Switcher Functions
        function updateThemeStatusText(isDark) {
            const label = document.getElementById('themeStatusLabel');
            if (label) {
                label.innerText = isDark ? 'Mode Gelap Aktif' : 'Mode Terang Aktif';
            }
        }

        function setThemeMode(mode) {
            if (mode === 'dark') {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
                localStorage.setItem('pkl_theme', 'dark');
                updateThemeStatusText(true);
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
                localStorage.setItem('pkl_theme', 'light');
                updateThemeStatusText(false);
            }
        }

        function toggleTheme() {
            const isCurrentlyDark = document.documentElement.classList.contains('dark');
            setThemeMode(isCurrentlyDark ? 'light' : 'dark');
        }

        // Initialize Theme on DOM loaded
        document.addEventListener('DOMContentLoaded', () => {
            const isDark = document.documentElement.classList.contains('dark');
            updateThemeStatusText(isDark);
        });

        // Profile Drawer Functions
        function openProfileDrawer() {
            const overlay = document.getElementById('profileDrawerOverlay');
            const drawer = document.getElementById('profileDrawer');
            if (overlay && drawer) {
                overlay.classList.remove('hidden');
                setTimeout(() => drawer.classList.add('open'), 10);
            }
        }

        function closeProfileDrawer() {
            const overlay = document.getElementById('profileDrawerOverlay');
            const drawer = document.getElementById('profileDrawer');
            if (drawer) drawer.classList.remove('open');
            if (overlay) {
                setTimeout(() => overlay.classList.add('hidden'), 250);
            }
        }

        function filterByDosen(dosenName) {
            currentSelectedDosen = dosenName;
            const rows = document.querySelectorAll('.modul-row');
            const dosenCards = document.querySelectorAll('.dosen-card');
            const allCard = document.getElementById('dosen-card-all');
            const resetBtn = document.getElementById('reset-filter-btn');
            const titleEl = document.getElementById('modul-table-title');
            const badgeEl = document.getElementById('filter-badge');

            if (!dosenName) {
                rows.forEach(row => row.classList.remove('hidden'));
                allCard.className = "dosen-card cursor-pointer bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white border border-orange-400/50 rounded-xl p-3 flex items-center justify-between transition shadow-md shadow-orange-500/20";
                const badgeAll = document.getElementById('badge-all-dosen');
                if (badgeAll) badgeAll.className = "text-[10px] font-bold bg-black/20 text-white px-2 py-0.5 rounded-md";

                dosenCards.forEach(c => {
                    if (c.id !== 'dosen-card-all') {
                        c.className = "dosen-card cursor-pointer bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/60 rounded-xl p-3 flex items-center justify-between hover:border-orange-500/50 hover:bg-slate-100 dark:hover:bg-slate-800 transition";
                    }
                });

                if (resetBtn) resetBtn.classList.add('hidden');
                if (badgeEl) badgeEl.classList.add('hidden');
                if (titleEl) titleEl.innerHTML = `<span>Semua Modul Kuliah</span>`;
            } else {
                let visibleCount = 0;
                const searchDosen = dosenName.toLowerCase();

                rows.forEach(row => {
                    const rowDosen = row.getAttribute('data-dosen');
                    if (rowDosen === searchDosen) {
                        row.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        row.classList.add('hidden');
                    }
                });

                allCard.className = "dosen-card cursor-pointer bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/60 rounded-xl p-3 flex items-center justify-between hover:border-orange-500/50 hover:bg-slate-100 dark:hover:bg-slate-800 transition text-slate-700 dark:text-slate-300";
                const badgeAll = document.getElementById('badge-all-dosen');
                if (badgeAll) badgeAll.className = "hidden";

                dosenCards.forEach(c => {
                    if (c.id !== 'dosen-card-all') {
                        const targetDosen = c.getAttribute('data-dosen-name');
                        if (targetDosen === searchDosen) {
                            c.className = "dosen-card cursor-pointer bg-orange-500/15 border-2 border-orange-500 rounded-xl p-3 flex items-center justify-between transition shadow-lg text-slate-900 dark:text-white font-semibold";
                        } else {
                            c.className = "dosen-card cursor-pointer bg-slate-50/50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-800 rounded-xl p-3 flex items-center justify-between hover:border-orange-500/50 hover:bg-slate-100 dark:hover:bg-slate-800/60 transition opacity-60";
                        }
                    }
                });

                if (resetBtn) resetBtn.classList.remove('hidden');
                if (badgeEl) badgeEl.classList.remove('hidden');
                if (titleEl) titleEl.innerHTML = `<span>Modul dari: <strong class="text-orange-600 dark:text-orange-400">${dosenName}</strong> (${visibleCount})</span>`;
            }
        }

        function openAddModulModal() {
            const modal = document.getElementById('addModulModal');
            if (modal) modal.classList.remove('hidden');
        }
        
        function closeAddModulModal() {
            const modal = document.getElementById('addModulModal');
            if (modal) modal.classList.add('hidden');
        }

        function openEditModulModal(modul) {
            const modal = document.getElementById('editModulModal');
            if (modal) {
                const id = modul.id_modul || modul.id;
                document.getElementById('editModulForm').action = `/modul/${id}`;
                document.getElementById('edit_nama_modul').value = modul.nama_modul || '';
                document.getElementById('edit_nama_dosen').value = modul.nama_dosen || '';
                document.getElementById('edit_file_modul').value = modul.file_modul || '';
                modal.classList.remove('hidden');
            }
        }

        function closeEditModulModal() {
            const modal = document.getElementById('editModulModal');
            if (modal) modal.classList.add('hidden');
        }

        // POPUP CONFIRM DELETE (Poin 3)
        function confirmDelete(actionUrl, targetTitle) {
            const modal = document.getElementById('deleteConfirmModal');
            const form = document.getElementById('deleteConfirmForm');
            const titleEl = document.getElementById('deleteTargetTitle');
            if (modal && form) {
                form.action = actionUrl;
                if (titleEl) titleEl.innerText = `Apakah Anda yakin ingin menghapus ${targetTitle}?`;
                modal.classList.remove('hidden');
            }
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteConfirmModal');
            if (modal) modal.classList.add('hidden');
        }

        // POPUP CONFIRM LOGOUT (Poin 4)
        function openLogoutModal() {
            const modal = document.getElementById('logoutConfirmModal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutConfirmModal');
            if (modal) modal.classList.add('hidden');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeProfileDrawer();
                closeAddModulModal();
                closeEditModulModal();
                closeDeleteModal();
                closeLogoutModal();
            }
        });

        // Smooth Page Switch Interceptor
        document.querySelectorAll('.page-switch-link').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.href && !this.classList.contains('active-tab')) {
                    e.preventDefault();
                    const targetUrl = this.href;
                    const content = document.getElementById('pageMainContent');
                    if (content) {
                        content.classList.add('page-exit');
                    }
                    setTimeout(() => {
                        window.location.href = targetUrl;
                    }, 180);
                }
            });
        });
    </script>
</body>
</html>

