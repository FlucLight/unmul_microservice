<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna — Fakultas Teknik UNMUL</title>
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
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .page-exit {
            opacity: 0 !important;
            transform: translateY(-6px) !important;
            transition: opacity 0.2s cubic-bezier(0.4, 0, 0.2, 1), transform 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        /* Sidebar Drawer Animation */
        .profile-drawer {
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .profile-drawer.open {
            transform: translateX(0);
        }
        .theme-slider-btn { box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.12); }
    </style>
</head>
<body class="min-h-screen bg-slate-100 dark:bg-[#0f172a] text-slate-800 dark:text-slate-100 antialiased flex flex-col">

    <!-- Ambient Subtle Background Elements -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute -top-40 left-1/4 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -right-40 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.03]" style="background-image:radial-gradient(circle at 1px 1px, currentColor 1px, transparent 0); background-size: 24px 24px;"></div>
    </div>

    <!-- MAIN HEADER BAR -->
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

                    <!-- Page Navigation Switcher Tabs -->
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

                <!-- Right: Theme Slider & Mini Profile Trigger -->
                <div class="flex items-center gap-3 shrink-0">
<button type="button" onclick="toggleTheme()" class="theme-slider-btn relative hidden md:inline-flex items-center w-14 h-7 p-0.5 rounded-full cursor-pointer transition-colors duration-300 bg-slate-200 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 focus:outline-none" aria-label="Ganti Mode Tema" title="Ganti Tema (Kiri: Terang, Kanan: Gelap)">                        <span class="absolute left-1.5 flex items-center justify-center pointer-events-none opacity-80 dark:opacity-30 transition-opacity">
                            <svg class="w-3.5 h-3.5 text-amber-500 dark:text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                        </span>
                        <span class="absolute right-1.5 flex items-center justify-center pointer-events-none opacity-30 dark:opacity-80 transition-opacity">
                            <svg class="w-3.5 h-3.5 text-slate-400 dark:text-indigo-300" fill="currentColor" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                        </span>
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-white dark:bg-slate-900 shadow-md transform transition-transform duration-300 translate-x-0 dark:translate-x-7 border border-slate-200 dark:border-slate-700 z-10 pointer-events-none">
                            <svg class="w-3.5 h-3.5 text-amber-500 inline dark:hidden" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                            <svg class="w-3.5 h-3.5 text-indigo-400 hidden dark:inline" fill="currentColor" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                        </span>
                    </button>

                    <!-- Mini Profile Trigger -->
                    <button type="button" onclick="openProfileDrawer()" class="flex items-center gap-2 p-1.5 sm:pl-2.5 sm:pr-3 rounded-full bg-slate-100 dark:bg-slate-800/90 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 shadow-sm transition group" title="Buka Profil & Menu">
                        <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-[#FF7A00] to-[#FF9225] text-white font-extrabold text-xs flex items-center justify-center shadow-sm shrink-0">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <span class="hidden sm:block text-xs font-bold text-slate-800 dark:text-slate-200 max-w-[100px] truncate">
                            {{ auth()->user()->name }}
                        </span>
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- CONTENT WRAPPER -->
    <div id="pageMainContent" class="page-transition-wrapper flex-1 relative z-10">

        <!-- Notification Messages -->
        @if(session('success') || session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 space-y-2">
            @if(session('success'))
                <div class="p-3.5 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-300 dark:border-emerald-500/40 text-emerald-800 dark:text-emerald-200 rounded-xl text-xs font-semibold flex items-center gap-2.5 shadow-sm">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="p-3.5 bg-rose-50 dark:bg-rose-950/60 border border-rose-300 dark:border-rose-500/40 text-rose-800 dark:text-rose-200 rounded-xl text-xs font-semibold flex items-center gap-2.5 shadow-sm">
                    <svg class="w-4 h-4 text-rose-600 dark:text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 8v5M12 16h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
        </div>
        @endif

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            <!-- Top Title & Action Button -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Manajemen Akun Pengguna</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Daftarkan mahasiswa & dosen baru melalui Nomor Induk (NIM / NIP).</p>
                </div>

                <button onclick="openAddModal()" class="inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white text-xs font-bold rounded-xl shadow-lg shadow-orange-500/25 active:scale-[0.98] transition duration-150 gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Daftarkan Akun Baru
                </button>
            </div>

            <!-- Statistik Ringkas -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 shadow-sm dark:shadow-xl dark:shadow-black/20 transition-colors duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Akun</p>
                            <p class="text-2xl font-extrabold text-slate-900 dark:text-white mt-1">{{ $users->count() }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-xl bg-orange-500/15 text-[#FF7A00] flex items-center justify-center">
                            <svg class="w-4.5 h-4.5 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 shadow-sm dark:shadow-xl dark:shadow-black/20 transition-colors duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Mahasiswa</p>
                            <p class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-1">{{ $users->where('role', 'mahasiswa')->count() }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-xl bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 shadow-sm dark:shadow-xl dark:shadow-black/20 transition-colors duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Dosen</p>
                            <p class="text-2xl font-extrabold text-purple-600 dark:text-purple-400 mt-1">{{ $users->where('role', 'dosen')->count() }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-xl bg-purple-500/15 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 shadow-sm dark:shadow-xl dark:shadow-black/20 transition-colors duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Admin</p>
                            <p class="text-2xl font-extrabold text-rose-600 dark:text-rose-400 mt-1">{{ $users->where('role', 'admin')->count() }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-xl bg-rose-500/15 text-rose-600 dark:text-rose-400 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Pengguna -->
            <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm dark:shadow-xl dark:shadow-black/20 overflow-hidden backdrop-blur-sm transition-colors duration-300">
                
                <!-- Toolbar: Pencarian & Filter Role -->
                <div class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 px-5 py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="relative w-full sm:max-w-xs">
                        <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" id="searchUser" onkeyup="filterUsers()" placeholder="Cari nama / NIM / NIP / email..." class="w-full pl-9 pr-3 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                    </div>
                    <div id="roleFilterGroup" class="flex items-center gap-1.5 text-[11px] font-bold overflow-x-auto">
                        <button onclick="setRoleFilter(null, this)" class="rf-btn px-3 py-1.5 rounded-lg bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white border border-transparent shadow-sm transition whitespace-nowrap">Semua</button>
                        <button onclick="setRoleFilter('mahasiswa', this)" class="rf-btn px-3 py-1.5 rounded-lg bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-orange-500/50 transition whitespace-nowrap">Mahasiswa</button>
                        <button onclick="setRoleFilter('dosen', this)" class="rf-btn px-3 py-1.5 rounded-lg bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-orange-500/50 transition whitespace-nowrap">Dosen</button>
                        <button onclick="setRoleFilter('admin', this)" class="rf-btn px-3 py-1.5 rounded-lg bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-orange-500/50 transition whitespace-nowrap">Admin</button>
                    </div>
                </div>

                <!-- List User -->
                <div id="user-list-container" class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse($users as $user)
                        <div class="user-row p-5 hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition duration-150 flex flex-col sm:flex-row sm:items-center justify-between gap-3"
                             data-role="{{ $user->role }}"
                             data-search="{{ strtolower($user->name . ' ' . $user->nomer_induk . ' ' . $user->email) }}">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#FF7A00] to-[#FF9225] text-white font-extrabold text-sm flex items-center justify-center shadow-md shadow-orange-500/20 shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="font-bold text-sm text-slate-900 dark:text-white truncate">{{ $user->name }}</h3>
                                        @if($user->id === auth()->id())
                                            <span class="px-1.5 py-0.5 text-[9px] font-extrabold uppercase tracking-wider bg-blue-500/15 text-blue-600 dark:text-blue-300 border border-blue-500/30 rounded">Anda</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2 mt-0.5 flex-wrap text-[11px] text-slate-500 dark:text-slate-400">
                                        <span class="font-mono">{{ $user->nomer_induk }}</span>
                                        <span>•</span>
                                        <span class="truncate max-w-[180px]">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 shrink-0 flex-wrap">
                                <!-- Badge Role -->
                                @if($user->isAdmin())
                                    <span class="px-2.5 py-1 bg-rose-500/15 text-rose-600 dark:text-rose-300 border border-rose-500/30 text-[10px] font-extrabold uppercase tracking-wider rounded-lg inline-flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        Admin
                                    </span>
                                @elseif($user->isDosen())
                                    <span class="px-2.5 py-1 bg-purple-500/15 text-purple-600 dark:text-purple-300 border border-purple-500/30 text-[10px] font-extrabold uppercase tracking-wider rounded-lg inline-flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Dosen
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-emerald-500/15 text-emerald-600 dark:text-emerald-300 border border-emerald-500/30 text-[10px] font-extrabold uppercase tracking-wider rounded-lg inline-flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                        Mahasiswa
                                    </span>
                                @endif

                                <span class="hidden lg:inline-block text-[10px] text-slate-400 font-mono bg-slate-100 dark:bg-slate-800/90 px-2 py-1 rounded-lg border border-slate-200 dark:border-slate-700/60">
                                    {{ $user->created_at ? $user->created_at->translatedFormat('j M Y') : '-' }}
                                </span>

                                <!-- Aksi Edit & Hapus -->
                                <button onclick='openEditModal({{ json_encode(["id" => $user->id, "name" => $user->name, "email" => $user->email, "nomer_induk" => $user->nomer_induk, "role" => $user->role]) }})' class="p-1.5 text-slate-500 dark:text-slate-400 hover:text-orange-500 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700/60 rounded-lg transition" title="Ubah Data Akun">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                @if($user->id !== auth()->id())
                                    <button type="button" onclick="confirmDelete('{{ route('admin.pengguna.destroy', $user->id) }}', 'akun: {{ addslashes($user->name) }}')" class="p-1.5 text-slate-500 dark:text-slate-400 hover:text-rose-500 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700/60 rounded-lg transition" title="Hapus Akun">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-14 text-center">
                            <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 mx-auto flex items-center justify-center mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                            <p class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Belum ada akun pengguna terdaftar.</p>
                        </div>
                    @endforelse

                    <div id="no-user-filtered" class="hidden py-10 text-center">
                        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Tidak ada akun yang cocok dengan pencarian/filter.</p>
                    </div>
                </div>

            </div>

        </main>

    </div>

    <!-- SIDEBAR DRAWER PROFIL -->
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
                <div class="inline-block px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider rounded-full bg-rose-500/15 text-rose-600 dark:text-rose-300 border border-rose-400/30">
                    {{ auth()->user()->role ?? 'User' }}
                </div>
            </div>

            <!-- Theme Toggle -->
            <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/70 rounded-2xl p-4 flex items-center justify-between">
                <div>
                    <span class="block text-xs font-bold text-slate-900 dark:text-white">Pilihan Tema</span>
                    <span class="block text-[11px] text-slate-500 dark:text-slate-400" id="themeStatusLabel">Mode Gelap Aktif</span>
                </div>
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
                <span class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Menu Navigasi</span>
                <a href="{{ route('home') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 hover:bg-orange-500/10 hover:text-orange-500 border border-slate-200 dark:border-slate-700/60 text-xs font-semibold text-slate-700 dark:text-slate-300 transition no-underline">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Halaman Beranda
                </a>
                <a href="{{ route('tugas.index') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 hover:bg-orange-500/10 hover:text-orange-500 border border-slate-200 dark:border-slate-700/60 text-xs font-semibold text-slate-700 dark:text-slate-300 transition no-underline">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Tugas Kuliah
                </a>
                <a href="{{ route('modul.index') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 hover:bg-orange-500/10 hover:text-orange-500 border border-slate-200 dark:border-slate-700/60 text-xs font-semibold text-slate-700 dark:text-slate-300 transition no-underline">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Modul Kuliah
                </a>
                <a href="{{ route('admin.pengguna') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white border border-transparent text-xs font-bold shadow-md shadow-orange-500/20 transition no-underline">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Manajemen Akun
                </a>
            </div>

        </div>

        <!-- Drawer Footer (Logout) -->
        <div class="p-5 border-t border-slate-200 dark:border-slate-800">
            <button type="button" onclick="openLogoutModal()" class="w-full py-2.5 px-4 bg-rose-500/10 hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 border border-rose-500/30 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar dari Akun
            </button>
        </div>

    </aside>


    <!-- MODAL DAFTARKAN AKUN BARU -->
    <div id="addModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700/80 max-h-[92vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Daftarkan Akun Baru
                </h3>
                <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form action="{{ route('admin.pengguna.store') }}" method="POST" class="space-y-4">
                @csrf
                @if ($errors->any())
                    <div class="p-3 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-500/30 text-rose-700 dark:text-rose-300 text-[11px] rounded-xl space-y-1">
                        @foreach ($errors->all() as $error)
                            <p class="flex items-start gap-1.5"><span class="font-bold">•</span> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Ahmad Fulan" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Daftarkan Sebagai (Role)</label>
                    <select name="role" required onchange="updateIndukLabel(this.value, 'add_label_induk', 'add_placeholder_induk')" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                        <option value="mahasiswa" selected>Mahasiswa</option>
                        <option value="dosen">Dosen</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5" id="add_label_induk">Nomor Induk (NIM)</label>
                    <input type="text" name="nomer_induk" value="{{ old('nomer_induk') }}" required placeholder="Masukkan NIM mahasiswa" id="add_placeholder_induk" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Email Aktif</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@unmul.ac.id" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Password</label>
                        <input type="password" name="password" required minlength="8" placeholder="Min. 8 karakter" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required minlength="8" placeholder="Ulangi password" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                    </div>
                </div>

                <div class="flex justify-end gap-2.5 pt-2">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition">Batal</button>
                    <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white rounded-xl text-xs font-bold shadow-md shadow-orange-500/20 transition">Daftarkan Akun</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT AKUN -->
    <div id="editModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700/80 max-h-[92vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Ubah Data Akun
                </h3>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                    <input type="text" id="edit_name" name="name" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Role</label>
                    <select id="edit_role" name="role" required onchange="updateIndukLabel(this.value, 'edit_label_induk', null)" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="dosen">Dosen</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5" id="edit_label_induk">Nomor Induk (NIM)</label>
                    <input type="text" id="edit_nomer_induk" name="nomer_induk" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Email Aktif</label>
                    <input type="email" id="edit_email" name="email" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Reset Password (Opsional)</label>
                    <input type="password" id="edit_password" name="password" minlength="8" placeholder="Kosongkan jika tidak diubah" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>

                <div class="flex justify-end gap-2.5 pt-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition">Batal</button>
                    <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white rounded-xl text-xs font-bold shadow-md shadow-orange-500/20 transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL KONFIRMASI HAPUS -->
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
                    <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-md shadow-rose-500/20 transition">Ya, Hapus Akun</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL KONFIRMASI LOGOUT -->
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

    <!-- Javascript Interaktivitas -->
    <script>
        let currentRoleFilter = null;

        // ===== Theme Switcher =====
        function updateThemeStatusText(isDark) {
            const label = document.getElementById('themeStatusLabel');
            if (label) label.innerText = isDark ? 'Mode Gelap Aktif' : 'Mode Terang Aktif';
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

        document.addEventListener('DOMContentLoaded', () => {
            updateThemeStatusText(document.documentElement.classList.contains('dark'));
        });

        // ===== Profile Drawer =====
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
            if (overlay) setTimeout(() => overlay.classList.add('hidden'), 250);
        }

        // ===== Filter & Search =====
        function setRoleFilter(role, btn) {
            currentRoleFilter = role;
            document.querySelectorAll('.rf-btn').forEach(b => {
                b.className = "rf-btn px-3 py-1.5 rounded-lg bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-orange-500/50 transition whitespace-nowrap";
            });
            btn.className = "rf-btn px-3 py-1.5 rounded-lg bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white border border-transparent shadow-sm transition whitespace-nowrap";
            applyFilters();
        }

        function applyFilters() {
            const query = (document.getElementById('searchUser')?.value || '').toLowerCase().trim();
            const rows = document.querySelectorAll('.user-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const matchRole = !currentRoleFilter || row.getAttribute('data-role') === currentRoleFilter;
                const matchQuery = !query || row.getAttribute('data-search').includes(query);
                const show = matchRole && matchQuery;
                row.classList.toggle('hidden', !show);
                if (show) visibleCount++;
            });

            const emptyEl = document.getElementById('no-user-filtered');
            if (emptyEl) emptyEl.classList.toggle('hidden', visibleCount > 0);
        }

        function filterUsers() {
            applyFilters();
        }

        // ===== Label Nomor Induk sesuai Role =====
        function updateIndukLabel(role, labelId, inputId) {
            const label = document.getElementById(labelId);
            const input = inputId ? document.getElementById(inputId) : null;
            const isNip = role === 'dosen';
            if (label) label.innerText = isNip ? 'Nomor Induk (NIP)' : 'Nomor Induk (NIM)';
            if (input && input.tagName === 'INPUT') {
                input.placeholder = isNip ? 'Masukkan NIP/NIDN dosen' : 'Masukkan NIM mahasiswa';
            }
        }

        // ===== Modal Tambah =====
        function openAddModal() {
            const modal = document.getElementById('addModal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeAddModal() {
            const modal = document.getElementById('addModal');
            if (modal) modal.classList.add('hidden');
        }

        // ===== Modal Edit =====
        function openEditModal(user) {
            const modal = document.getElementById('editModal');
            if (!modal) return;
            document.getElementById('editForm').action = `/admin/pengguna/${user.id}`;
            document.getElementById('edit_name').value = user.name || '';
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_nomer_induk').value = user.nomer_induk || '';
            document.getElementById('edit_role').value = user.role || 'mahasiswa';
            document.getElementById('edit_password').value = '';
            updateIndukLabel(user.role, 'edit_label_induk', null);
            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            if (modal) modal.classList.add('hidden');
        }

        // ===== Modal Hapus =====
        function confirmDelete(actionUrl, targetTitle) {
            const modal = document.getElementById('deleteConfirmModal');
            const form = document.getElementById('deleteConfirmForm');
            const titleEl = document.getElementById('deleteTargetTitle');
            if (modal && form) {
                form.action = actionUrl;
                if (titleEl) titleEl.innerText = `Apakah Anda yakin ingin menghapus ${targetTitle}? Tindakan ini tidak dapat dibatalkan.`;
                modal.classList.remove('hidden');
            }
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteConfirmModal');
            if (modal) modal.classList.add('hidden');
        }

        // ===== Modal Logout =====
        function openLogoutModal() {
            const modal = document.getElementById('logoutConfirmModal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutConfirmModal');
            if (modal) modal.classList.add('hidden');
        }

        // Escape key closes everything
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeProfileDrawer();
                closeAddModal();
                closeEditModal();
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
                    if (content) content.classList.add('page-exit');
                    setTimeout(() => { window.location.href = targetUrl; }, 180);
                }
            });
        });
    </script>
</body>
</html>
