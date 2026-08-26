<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Kuliah — Fakultas Teknik UNMUL</title>
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

                        <a href="{{ route('tugas.arsip') }}"
                           class="page-switch-link px-3 sm:px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 no-underline transition-all
                                  {{ request()->routeIs('tugas.arsip') ? 'bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white font-bold shadow-md shadow-orange-500/20 active-tab' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200/70 dark:hover:bg-slate-700/60' }}">
                            <svg class="w-3.5 h-3.5 {{ request()->routeIs('tugas.arsip') ? 'text-white' : 'text-slate-500 dark:text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                            <span class="hidden md:inline">Arsip</span>
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

        <!-- Notification Messages -->
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
                    <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Daftar Tugas Kuliah</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Kelola dan kumpulkan seluruh penugasan semester ini secara tepat waktu.</p>
                </div>

                <!-- Tombol Tambah Tugas Baru - KHUSUS DOSEN & ADMIN -->
                @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                    <button onclick="openAddModal()" class="inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white text-xs font-bold rounded-xl shadow-lg shadow-orange-500/25 active:scale-[0.98] transition duration-150 gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Tambah Tugas Baru
                    </button>
                @endif
            </div>

            {{-- CATATAN: variabel role HARUS didefinisikan di sini (sebelum dipakai layout grid) --}}
            @php
                $isDosenOnly = auth()->user()->isDosen() && !auth()->user()->isAdmin();
                $canManage = auth()->user()->isDosen() || auth()->user()->isAdmin();
                $canSubmit = auth()->user()->isMahasiswa() || auth()->user()->isAdmin();
                $showMySummary = $canSubmit;
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- LEFT COLUMN: Ledger / Daftar Tugas -->
                <div class="{{ $isDosenOnly ? 'lg:col-span-12' : 'lg:col-span-8' }} space-y-4">
                    <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm dark:shadow-xl dark:shadow-black/20 overflow-hidden backdrop-blur-sm transition-colors duration-300">
                        
                        <div class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 px-5 py-3 flex items-center justify-between flex-wrap gap-2">
                            <div id="task-table-title" class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <span>Semua Tugas Kuliah</span>
                                <span id="filter-badge" class="hidden bg-orange-500/20 text-orange-600 dark:text-orange-400 border border-orange-500/30 px-2 py-0.5 rounded text-[10px] font-mono">Filter Aktif</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <label class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-500 dark:text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4 4m0 0l4-4m-4 4V7"/></svg>
                                    Urutkan
                                    <select id="sort-select" onchange="sortTasks(this.value)" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-2 py-1 text-[11px] font-semibold text-slate-700 dark:text-slate-200 focus:outline-none focus:border-orange-500 cursor-pointer">
                                        <option value="deadline_asc">Deadline Terdekat</option>
                                        <option value="deadline_desc">Terbaru &rarr; Terlama</option>
                                        <option value="nama_asc">Abjad A &rarr; Z</option>
                                        <option value="nama_desc">Abjad Z &rarr; A</option>
                                    </select>
                                </label>
                                <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tenggat Waktu</span>
                            </div>
                        </div>

                        <div id="task-list-container" class="divide-y divide-slate-100 dark:divide-slate-800/80">
                            @php
                                /*
                                 | CATATAN HAK AKSES (ROLE):
                                 | - $isDosenOnly : dosen murni -> hanya melihat tugas miliknya sendiri
                                 | - $canManage   : dosen & admin -> boleh mengelola tugas, memberi nilai, setujui/tolak kirim ulang
                                 | - $canSubmit   : mahasiswa & ADMIN -> boleh mengumpulkan / mengajukan kirim ulang tugas
                                 |                  (admin dikecualikan dari validasi "khusus dosen/mahasiswa" dan bisa akses semuanya)
                                 | Variabel ini sudah didefinisikan di atas (sebelum grid), di sini hanya helper grade.
                                 */
                                $gradeBadgeClass = function ($huruf) {
                                    return match ($huruf) {
                                        'A' => 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-300 border-emerald-500/30',
                                        'B' => 'bg-blue-500/15 text-blue-600 dark:text-blue-300 border-blue-500/30',
                                        'C' => 'bg-amber-500/15 text-amber-600 dark:text-amber-300 border-amber-500/30',
                                        'D' => 'bg-orange-500/15 text-orange-600 dark:text-orange-300 border-orange-500/30',
                                        default => 'bg-rose-500/15 text-rose-600 dark:text-rose-300 border-rose-500/30',
                                    };
                                };
                            @endphp
                            @forelse($tugasList as $index => $tugas)
                                @php
                                    $id = $tugas['id_tugas'] ?? $tugas['id'] ?? null;
                                    $deadline = isset($tugas['deadline_tugas']) ? \Carbon\Carbon::parse($tugas['deadline_tugas']) : null;
                                    $isPast = $deadline ? $deadline->isPast() : false;
                                    $showNilai = array_key_exists('show_nilai', $tugas) ? (bool) $tugas['show_nilai'] : true;

                                    // Data pengumpulan dari FastAPI 2
                                    $submissions = collect($kumpulList)->where('id_tugas', $id);

                                    // Mahasiswa hanya melihat datanya sendiri (sudah difilter di controller)
                                    $mySubmission = $submissions->firstWhere('nama_mahasiswa', auth()->user()->name);
                                    $myPending = $submissions->first(function ($s) {
                                        return strcasecmp($s['nama_mahasiswa'] ?? '', auth()->user()->name) === 0
                                            && ($s['resubmit_status'] ?? 'none') === 'pending';
                                    });

                                    $getNilai = function ($sub) {
                                        if (isset($sub['nilai']) && $sub['nilai'] !== null && $sub['nilai'] !== '') {
                                            return (int) $sub['nilai'];
                                        }
                                        if (isset($sub['nilai_mahasiswa']) && $sub['nilai_mahasiswa'] !== null && $sub['nilai_mahasiswa'] !== '' && (float) $sub['nilai_mahasiswa'] > 0) {
                                            return (int) $sub['nilai_mahasiswa'];
                                        }
                                        return null;
                                    };

                                    if ($isPast) {
                                        $statusBadge = 'bg-rose-500/15 text-rose-600 dark:text-rose-300 border-rose-500/30';
                                        $statusText = 'Lewat Tenggat';
                                    } elseif ($canSubmit && $mySubmission && ($mySubmission['resubmit_status'] ?? 'none') !== 'pending') {
                                        // [PERUBAHAN] Status "Selesai" berlaku untuk mahasiswa & admin yang sudah mengumpulkan
                                        $statusBadge = 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-300 border-emerald-500/30';
                                        $statusText = 'Selesai';
                                    } else {
                                        $statusBadge = 'bg-amber-500/15 text-amber-600 dark:text-amber-300 border-amber-500/30';
                                        $statusText = 'Sedang Berjalan';
                                    }
                                @endphp

                                <div class="task-row p-5 hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition duration-150 space-y-3"
                                     data-dosen="{{ strtolower($tugas['nama_dosen'] ?? '') }}"
                                     data-deadline="{{ $deadline ? $deadline->timestamp : 0 }}"
                                     data-nama="{{ mb_strtolower($tugas['nama_tugas'] ?? '') }}">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold border rounded-md {{ $statusBadge }}">
                                                    {{ $statusText }}
                                                </span>
                                                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">• Dosen: <strong class="text-slate-800 dark:text-slate-300">{{ $tugas['nama_dosen'] }}</strong></span>
                                            </div>
                                            <h3 class="font-bold text-base text-slate-900 dark:text-white hover:text-orange-500 transition-colors truncate" title="{{ $tugas['nama_tugas'] }}">
                                                {{ $tugas['nama_tugas'] }}
                                            </h3>
                                        </div>

                                        <div class="flex items-center sm:flex-col sm:items-end justify-between gap-2 shrink-0">
                                            <span class="text-xs font-mono font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800/90 px-2.5 py-1 rounded-lg border border-slate-200 dark:border-slate-700/60">
                                                {{ $deadline ? $deadline->translatedFormat('l, j F Y \• H:i') : 'Tanpa Tenggat' }}
                                            </span>

                                            <div class="flex items-center gap-2">
                                                {{-- [PERUBAHAN] Tombol Kumpulkan/Kirim Ulang: mahasiswa & ADMIN (admin tidak dibatasi validasi khusus mahasiswa) --}}
                                                @if($canSubmit)
                                                    @if($myPending)
                                                        <span class="px-2.5 py-1 bg-sky-500/15 text-sky-600 dark:text-sky-300 border border-sky-500/30 text-xs font-bold rounded-lg inline-flex items-center gap-1.5" title="Menunggu persetujuan dosen untuk kirim ulang">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                            Kirim Ulang: Menunggu Izin
                                                        </span>
                                                    @elseif($mySubmission)
                                                        <span class="px-2.5 py-1 bg-emerald-500/20 text-emerald-600 dark:text-emerald-300 border border-emerald-500/30 text-xs font-bold rounded-lg inline-flex items-center gap-1.5">
                                                            <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                            Sudah Dikumpulkan
                                                        </span>
                                                        <button onclick='openKumpulModal({{ $id }}, "{{ addslashes($tugas['nama_tugas']) }}", true)' class="px-2.5 py-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white text-xs font-semibold rounded-lg border border-slate-200 dark:border-slate-700 transition flex items-center gap-1" title="Kirim Ulang (Memerlukan Persetujuan Dosen)">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                            Kirim Ulang
                                                        </button>
                                                    @else
                                                        <button onclick='openKumpulModal({{ $id }}, "{{ addslashes($tugas['nama_tugas']) }}", false)' class="px-3 py-1 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white text-xs font-bold rounded-lg shadow-md shadow-orange-500/20 transition flex items-center gap-1.5">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                                            Kumpulkan
                                                        </button>
                                                    @endif
                                                @endif

                                                <!-- FITUR DOSEN / ADMIN: Edit & Hapus Tugas -->
                                                @if($canManage)
                                                    <button onclick='openEditModal({{ json_encode($tugas) }})' class="p-1.5 text-slate-500 dark:text-slate-400 hover:text-orange-500 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700/60 rounded-lg transition" title="Ubah Tugas">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                    </button>
                                                    <button type="button" onclick="confirmDelete('{{ route('tugas.destroy', $id) }}', 'Tugas: {{ addslashes($tugas['nama_tugas']) }}')" class="p-1.5 text-slate-500 dark:text-slate-400 hover:text-rose-500 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700/60 rounded-lg transition" title="Hapus Tugas">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- ====== MAHASISWA & ADMIN: RINGKASAN PENGUMPULAN MILIK SENDIRI ====== --}}
                                    @if($showMySummary)
                                        @if($myPending || $mySubmission)
                                            @php
                                                $activeSub = $myPending ?: $mySubmission;
                                                $subId = $activeSub['id_kumpul'] ?? $activeSub['id'] ?? null;
                                                $tglKumpul = isset($activeSub['tanggal_kumpul']) ? \Carbon\Carbon::parse($activeSub['tanggal_kumpul'])->translatedFormat('l, j F Y \jam H:i') : '-';
                                                $tglNilai = isset($activeSub['dinilai_at']) && $activeSub['dinilai_at'] ? \Carbon\Carbon::parse($activeSub['dinilai_at'])->translatedFormat('l, j F Y \jam H:i') : null;
                                                $nilaiVal = $showNilai ? $getNilai($activeSub) : null;
                                                $gradeHuruf = $nilaiVal !== null ? \App\Support\Grade::huruf($nilaiVal) : null;
                                                $fileUrl = $activeSub['file_mahasiswa'] ?? null;
                                                $catatanVal = ($showNilai && !empty($activeSub['catatan_dosen'])) ? $activeSub['catatan_dosen'] : null;
                                            @endphp
                                            <div class="bg-slate-50 dark:bg-slate-950/60 border {{ $myPending ? 'border-sky-500/40' : 'border-slate-200 dark:border-slate-800/80' }} rounded-xl p-3.5 text-xs space-y-2.5">
                                                @if($myPending)
                                                    <div class="flex items-center gap-2 p-2 bg-sky-500/10 border border-sky-500/30 rounded-lg text-sky-700 dark:text-sky-300 font-semibold">
                                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        Pengajuan kirim ulang kamu sedang menunggu persetujuan dosen. Pengumpulan lama tetap digunakan sampai disetujui.
                                                    </div>
                                                @endif

                                                <div class="flex items-center justify-between flex-wrap gap-2">
                                                    <div class="flex items-center gap-2 flex-wrap">
                                                        <span class="font-bold text-slate-800 dark:text-slate-200">Pengumpulanmu</span>
                                                        <span class="text-[10px] text-slate-500 dark:text-slate-400 font-mono">Dikumpulkan: {{ $tglKumpul }}</span>

                                                        @if(!empty($fileUrl))
                                                            <a href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer" class="px-2 py-0.5 bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-500/30 rounded font-semibold text-[10px] hover:underline flex items-center gap-1" title="Buka Link Google Drive">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                                Link Drive
                                                            </a>
                                                        @endif

                                                        @if($showNilai && $nilaiVal !== null)
                                                            <span class="px-2 py-0.5 bg-amber-50 dark:bg-amber-500/20 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-500/30 rounded font-extrabold text-[11px]">
                                                                Nilai: {{ $nilaiVal }} / 100
                                                            </span>
                                                            <span class="px-2 py-0.5 border rounded font-extrabold text-[11px] {{ $gradeBadgeClass($gradeHuruf) }}" title="Grade {{ $gradeHuruf }}">
                                                                Grade: {{ $gradeHuruf }}
                                                            </span>
                                                            @if($tglNilai)
                                                                <span class="text-[10px] text-slate-500 dark:text-slate-400 font-mono">Dinilai: {{ $tglNilai }}</span>
                                                            @endif
                                                        @elseif($mySubmission && !$showNilai)
                                                            <span class="px-1.5 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded text-[10px] italic border border-slate-200 dark:border-slate-700">
                                                                Nilai belum ditampilkan oleh dosen
                                                            </span>
                                                        @elseif(!$myPending)
                                                            <span class="px-1.5 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded text-[10px] italic border border-slate-200 dark:border-slate-700">
                                                                Belum Dinilai
                                                            </span>
                                                        @endif

                                                        {{-- IKON REVIEW / CATATAN DOSEN (klik untuk lihat review) --}}
                                                        @if($catatanVal)
                                                            <button onclick='openReviewModal("{{ addslashes(auth()->user()->name) }}", "{{ addslashes($catatanVal) }}", "{{ $tglNilai ?? '-' }}")' class="w-6 h-6 inline-flex items-center justify-center bg-amber-100 dark:bg-amber-500/20 hover:bg-amber-200 dark:hover:bg-amber-500/30 text-amber-600 dark:text-amber-300 border border-amber-300 dark:border-amber-500/40 rounded-full transition" title="Lihat Review / Catatan Dosen">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif

                                    {{-- ====== DOSEN / ADMIN: DAFTAR PENGUMPULAN (PAGINATION 10 / HALAMAN) ====== --}}
                                    @if($canManage)
                                        <div class="bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800/80 rounded-xl p-3.5 text-xs space-y-2.5">
                                            <div class="flex items-center justify-between font-medium flex-wrap gap-2">
                                                <span class="text-slate-700 dark:text-slate-300 font-bold flex items-center gap-1.5">
                                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                                    Total Pengumpulan: <strong class="text-orange-600 dark:text-orange-400">{{ count($submissions) }} Mahasiswa</strong>
                                                </span>
                                                @if(count($submissions) > 0)
                                                    <button onclick="toggleSubmissionList({{ $id }})" class="text-orange-600 dark:text-orange-400 hover:text-orange-500 hover:underline text-[11px] font-bold">
                                                        Tampilkan Detail &raquo;
                                                    </button>
                                                @endif
                                            </div>

                                            @if(count($submissions) > 0)
                                                <div id="sub-list-{{ $id }}" class="hidden pt-2.5 border-t border-slate-200 dark:border-slate-800 space-y-2">
                                                    <div id="sub-items-{{ $id }}" class="space-y-2">
                                                        @foreach($submissions as $sub)
                                                            @php
                                                                $subId = $sub['id_kumpul'] ?? $sub['id'] ?? null;
                                                                $tglKumpul = isset($sub['tanggal_kumpul']) ? \Carbon\Carbon::parse($sub['tanggal_kumpul'])->translatedFormat('l, j F Y \jam H:i') : '-';
                                                                $tglNilai = isset($sub['dinilai_at']) && $sub['dinilai_at'] ? \Carbon\Carbon::parse($sub['dinilai_at'])->translatedFormat('j M Y, H:i') : null;
                                                                $nilaiVal = $getNilai($sub);
                                                                $gradeHuruf = $nilaiVal !== null ? \App\Support\Grade::huruf($nilaiVal) : null;
                                                                $fileUrl = $sub['file_mahasiswa'] ?? null;
                                                                $isPendingResubmit = ($sub['resubmit_status'] ?? 'none') === 'pending';
                                                            @endphp
                                                            <div class="sub-item sub-item-{{ $id }}">
                                                                <div class="flex items-center justify-between bg-white dark:bg-slate-900/90 p-3 rounded-lg border {{ $isPendingResubmit ? 'border-sky-500/50' : 'border-slate-200 dark:border-slate-800' }} flex-wrap gap-2">
                                                                    <div class="flex items-center gap-2 flex-wrap">
                                                                        <span class="font-bold text-slate-800 dark:text-slate-200">{{ $sub['nama_mahasiswa'] }}</span>
                                                                        <span class="text-[10px] text-slate-500 dark:text-slate-400 font-mono">Dikumpulkan: {{ $tglKumpul }}</span>

                                                                        @if($isPendingResubmit)
                                                                            <span class="px-2 py-0.5 bg-sky-500/15 text-sky-600 dark:text-sky-300 border border-sky-500/30 rounded font-bold text-[10px] uppercase tracking-wide">
                                                                                Kirim Ulang: Menunggu Persetujuan
                                                                            </span>
                                                                        @endif

                                                                        <!-- Link Google Drive jika tersedia -->
                                                                        @if(!empty($fileUrl))
                                                                            <a href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer" class="px-2 py-0.5 bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-500/30 rounded font-semibold text-[10px] hover:underline flex items-center gap-1" title="Buka Link Google Drive">
                                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                                                Link Drive
                                                                            </a>
                                                                        @endif

                                                                        <!-- Badge Status Nilai + Grade -->
                                                                        @if($nilaiVal !== null)
                                                                            <span class="px-2 py-0.5 bg-amber-50 dark:bg-amber-500/20 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-500/30 rounded font-extrabold text-[11px]" title="{{ $tglNilai ? 'Dinilai pada '.$tglNilai : '' }}">
                                                                                Nilai: {{ $nilaiVal }} / 100
                                                                            </span>
                                                                            <span class="px-2 py-0.5 border rounded font-extrabold text-[11px] {{ $gradeBadgeClass($gradeHuruf) }}" title="Grade {{ $gradeHuruf }}">
                                                                                Grade: {{ $gradeHuruf }}
                                                                            </span>
                                                                            @if($tglNilai)
                                                                                <span class="text-[10px] text-slate-500 dark:text-slate-400 font-mono">Dinilai: {{ $tglNilai }}</span>
                                                                            @endif
                                                                        @else
                                                                            <span class="px-1.5 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded text-[10px] italic border border-slate-200 dark:border-slate-700">
                                                                                Belum Dinilai
                                                                            </span>
                                                                        @endif

                                                                        <!-- IKON REVIEW / CATATAN DOSEN -->
                                                                        @if(!empty($sub['catatan_dosen']))
                                                                            <button onclick='openReviewModal("{{ addslashes($sub['nama_mahasiswa']) }}", "{{ addslashes($sub['catatan_dosen']) }}", "{{ $tglNilai ?? '-' }}")' class="w-6 h-6 inline-flex items-center justify-center bg-amber-100 dark:bg-amber-500/20 hover:bg-amber-200 dark:hover:bg-amber-500/30 text-amber-600 dark:text-amber-300 border border-amber-300 dark:border-amber-500/40 rounded-full transition" title="Lihat Review / Catatan">
                                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                                                            </button>
                                                                        @endif
                                                                    </div>

                                                                    <div class="flex items-center gap-2">
                                                                        @if($isPendingResubmit)
                                                                            <form action="{{ route('kumpul.approve', $subId) }}" method="POST" onsubmit="return confirm('Setujui kirim ulang dari {{ addslashes($sub['nama_mahasiswa']) }}? Data lama akan digantikan.')">
                                                                                @csrf
                                                                                @method('PATCH')
                                                                                <button type="submit" class="px-2.5 py-1 bg-emerald-100 dark:bg-emerald-500/20 hover:bg-emerald-200 dark:hover:bg-emerald-500/30 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-500/40 rounded-lg font-bold text-[11px] transition">
                                                                                    Setujui
                                                                                </button>
                                                                            </form>
                                                                            <form action="{{ route('kumpul.reject', $subId) }}" method="POST" onsubmit="return confirm('Tolak pengajuan kirim ulang dari {{ addslashes($sub['nama_mahasiswa']) }}? Pengumpulan lama tetap digunakan.')">
                                                                                @csrf
                                                                                @method('PATCH')
                                                                                <button type="submit" class="px-2.5 py-1 bg-rose-100 dark:bg-rose-500/20 hover:bg-rose-200 dark:hover:bg-rose-500/30 text-rose-800 dark:text-rose-300 border border-rose-300 dark:border-rose-500/40 rounded-lg font-bold text-[11px] transition">
                                                                                    Tolak
                                                                                </button>
                                                                            </form>
                                                                        @endif

                                                                        <button onclick='openNilaiModal({{ $subId }}, "{{ addslashes($sub['nama_mahasiswa']) }}", {{ $nilaiVal ?? "null" }}, "{{ addslashes($sub['catatan_dosen'] ?? '') }}")' class="px-2.5 py-1 bg-amber-100 dark:bg-amber-500/20 hover:bg-amber-200 dark:hover:bg-amber-500/30 text-amber-900 dark:text-amber-300 border border-amber-300 dark:border-amber-500/40 rounded-lg font-bold text-[11px] transition">
                                                                            {{ $nilaiVal !== null ? 'Ubah Nilai' : 'Beri Nilai' }}
                                                                        </button>
                                                                        <button type="button" onclick="confirmDelete('{{ route('kumpul.destroy', $subId) }}', 'pengumpulan tugas dari {{ addslashes($sub['nama_mahasiswa']) }}')" class="text-slate-400 hover:text-rose-500 px-1 text-xs font-semibold transition cursor-pointer" title="Hapus Pengumpulan">&times;</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    {{-- PAGINATION 10 PER HALAMAN --}}
                                                    <div id="sub-controls-{{ $id }}" class="hidden flex items-center justify-between pt-1.5 px-1">
                                                        <button type="button" id="sub-prev-{{ $id }}" onclick="changeSubPage({{ $id }}, -1)" class="px-3 py-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 rounded-lg font-bold text-[11px] transition disabled:opacity-40 disabled:cursor-not-allowed">&laquo; Previous</button>
                                                        <span id="sub-pageinfo-{{ $id }}" class="text-[11px] font-semibold text-slate-500 dark:text-slate-400"></span>
                                                        <button type="button" id="sub-next-{{ $id }}" onclick="changeSubPage({{ $id }}, 1)" class="px-3 py-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 rounded-lg font-bold text-[11px] transition disabled:opacity-40 disabled:cursor-not-allowed">Next &raquo;</button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                </div>
                            @empty
                                <div class="py-14 text-center">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 mx-auto flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    </div>
                                    <p class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Belum ada tugas tercatat untuk jurusan ini.</p>
                                    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                                        <button onclick="openAddModal()" class="mt-2 text-xs font-bold text-orange-600 dark:text-orange-400 hover:underline">+ Buat Tugas Pertama</button>
                                    @endif
                                </div>
                            @endforelse

                            <div id="no-task-filtered" class="hidden py-10 text-center">
                                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Tidak ada tugas terdaftar untuk dosen ini.</p>
                                @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                                    <button onclick="openAddModalWithDosen()" class="mt-2 text-xs font-bold text-orange-600 dark:text-orange-400 hover:underline">
                                        + Buat Tugas Untuk Dosen Ini
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT COLUMN: Dosen Pengampu Filter (disembunyikan untuk dosen, karena dosen hanya melihat tugasnya sendiri) -->
                @if(!$isDosenOnly)
                <div class="lg:col-span-4 space-y-4">
                    <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 sm:p-5 shadow-sm dark:shadow-xl dark:shadow-black/20 backdrop-blur-sm transition-colors duration-300">
                        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-200 dark:border-slate-800">
                            <div>
                                <h3 class="font-bold text-sm text-slate-900 dark:text-white">Dosen Pengampu</h3>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">Filter tugas berdasarkan dosen</p>
                            </div>
                            <button onclick="filterByDosen(null)" id="reset-filter-btn" class="hidden text-[11px] bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-orange-600 dark:text-orange-400 font-semibold px-2.5 py-1 rounded-lg border border-slate-200 dark:border-slate-700 transition">
                                Reset Filter
                            </button>
                        </div>

                        @php
                            $groupedDosen = collect($tugasList)->groupBy('nama_dosen');
                        @endphp

                        <div class="space-y-2">
                            <div onclick="filterByDosen(null)" id="dosen-card-all" class="dosen-card cursor-pointer bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white border border-orange-400/50 rounded-xl p-3 flex items-center justify-between transition shadow-md shadow-orange-500/20">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-black/20 text-white font-bold flex items-center justify-center text-xs">
                                        ALL
                                    </div>
                                    <div>
                                        <p class="font-bold text-xs">Semua Dosen</p>
                                        <p class="text-[10px] text-white/80">Tampilkan seluruh tugas ({{ count($tugasList) }})</p>
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
                                            <p class="text-[10px] text-slate-500 dark:text-slate-400 truncate">{{ count($items) }} Tugas Ditugaskan</p>
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
                                    <p class="text-slate-400 dark:text-slate-500 text-xs">Belum ada dosen tercatat.</p>
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>
                @endif

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
                <a href="{{ route('tugas.index') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white border border-transparent text-xs font-bold shadow-md shadow-orange-500/20 transition no-underline">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Tugas Kuliah
                </a>
                <a href="{{ route('modul.index') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/50 hover:bg-orange-500/10 hover:text-orange-500 border border-slate-200 dark:border-slate-700/60 text-xs font-semibold text-slate-700 dark:text-slate-300 transition no-underline">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
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
                        <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Online</span>
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


    <!-- MODAL BERI / EDIT NILAI TUGAS (FASTAPI 2) - KHUSUS DOSEN & ADMIN -->
    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
    <div id="nilaiModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700/80">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    Beri Nilai Tugas (0 - 100)
                </h3>
                <button onclick="closeNilaiModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form id="nilaiForm" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Mahasiswa</label>
                    <input type="text" id="nilai_nama_mahasiswa" readonly class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-800 dark:text-slate-200 focus:outline-none">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nilai (0 - 100)</label>
                    <input type="number" id="nilai_input" name="nilai" min="0" max="100" required placeholder="Contoh: 85" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>

                <!-- CATATAN / FEEDBACK DOSEN (Poin 2) -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Catatan / Deskripsi Penilaian</label>
                    <textarea id="nilai_catatan" name="catatan_dosen" rows="3" placeholder="Masukkan feedback atau masukan untuk mahasiswa..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition"></textarea>
                </div>

                <div class="flex justify-end gap-2.5 pt-2">
                    <button type="button" onclick="closeNilaiModal()" class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition">Batal</button>
                    <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white rounded-xl text-xs font-bold shadow-md shadow-orange-500/20 transition">Simpan Nilai</button>
                </div>
            </form>
        </div>
    </div>
    @endif


    <!-- MODAL REVIEW / CATATAN DOSEN -->
    <div id="reviewModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700/80">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    Review / Catatan Dosen
                </h3>
                <button onclick="closeReviewModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <div class="space-y-3">
                <div>
                    <span class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1">Mahasiswa</span>
                    <p id="review_nama" class="text-xs font-bold text-slate-800 dark:text-slate-200 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5"></p>
                </div>
                <div>
                    <span class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1">Waktu Penilaian</span>
                    <p id="review_waktu" class="text-xs font-mono font-semibold text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5"></p>
                </div>
                <div>
                    <span class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1">Catatan Penilaian</span>
                    <p id="review_isi" class="text-xs text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-800 border-l-2 border-amber-500 border-y border-r border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 italic leading-relaxed"></p>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="button" onclick="closeReviewModal()" class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition">Tutup</button>
            </div>
        </div>
    </div>


    <!-- MODAL KUMPULKAN TUGAS (FASTAPI 2) - KHUSUS MAHASISWA & ADMIN -->
    @if(auth()->user()->isMahasiswa() || auth()->user()->isAdmin())
    <div id="kumpulModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700/80">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Kumpulkan Tugas (Google Drive)
                </h3>
                <button onclick="closeKumpulModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form action="{{ route('kumpul.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" id="kumpul_id_tugas" name="id_tugas">
                <input type="hidden" id="kumpul_kirim_ulang" name="kirim_ulang" value="0">

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Judul Tugas</label>
                    <input type="text" id="kumpul_nama_tugas" readonly class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-800 dark:text-slate-200 focus:outline-none">
                </div>

                <div id="kumpul_resubmit_notice" class="hidden p-2.5 bg-sky-500/10 border border-sky-500/30 rounded-lg text-[11px] text-sky-700 dark:text-sky-300 font-semibold">
                    Pengajuan <strong>Kirim Ulang</strong> akan dikirim ke dosen untuk persetujuan. Selama menunggu, pengumpulan lama kamu tetap digunakan.
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Mahasiswa</label>
                    <input type="text" name="nama_mahasiswa" value="{{ auth()->user()->name }}" readonly class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-slate-800 dark:text-slate-200 focus:outline-none">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Link Google Drive Tugas <span class="text-rose-500">*</span></label>
                    <input type="url" name="file_mahasiswa" required placeholder="https://drive.google.com/file/d/..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">Pastikan link Google Drive sudah diatur ke status <strong>"Siapa saja yang memiliki link dapat melihat"</strong> (Publik).</p>
                </div>

                <div class="flex justify-end gap-2.5 pt-2">
                    <button type="button" onclick="closeKumpulModal()" class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition">Batal</button>
                    <button type="submit" id="kumpul_submit_btn" class="px-4 py-2.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white rounded-xl text-xs font-bold shadow-md shadow-orange-500/20 transition">Kumpulkan Tugas</button>
                </div>
            </form>
        </div>
    </div>
    @endif


    <!-- MODAL TAMBAH TUGAS (KHUSUS DOSEN & ADMIN) -->
    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
    <div id="addModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700/80">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Tambah Tugas Kuliah Baru
                </h3>
                <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form action="{{ route('tugas.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Tugas</label>
                    <input type="text" name="nama_tugas" required placeholder="Contoh: Laporan Praktikum Bab 3" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Dosen Pengampu</label>
                    <input type="text" id="add_nama_dosen" name="nama_dosen" value="{{ auth()->user()->name }}" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Batas Waktu (Deadline)</label>
                    <input type="datetime-local" name="deadline_tugas" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>

                <label class="flex items-start gap-3 bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/70 rounded-xl p-3.5 cursor-pointer select-none hover:border-orange-400 transition">
                    <input type="checkbox" name="show_nilai" value="1" checked class="mt-0.5 w-4 h-4 accent-orange-500 cursor-pointer">
                    <span>
                        <span class="block text-xs font-bold text-slate-800 dark:text-slate-200">Tampilkan Nilai ke Mahasiswa?</span>
                        <span class="block text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">Jika tidak dicentang, mahasiswa hanya melihat status "sudah dinilai" tanpa angka nilai & catatan.</span>
                    </span>
                </label>

                <div class="flex justify-end gap-2.5 pt-2">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition">Batal</button>
                    <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white rounded-xl text-xs font-bold shadow-md shadow-orange-500/20 transition">Simpan Tugas</button>
                </div>
            </form>
        </div>
    </div>


    <!-- MODAL EDIT TUGAS (KHUSUS DOSEN & ADMIN) -->
    <div id="editModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-700/80">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-base text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Ubah Tugas Kuliah
                </h3>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-white text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Tugas</label>
                    <input type="text" id="edit_nama_tugas" name="nama_tugas" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Dosen Pengampu</label>
                    <input type="text" id="edit_nama_dosen" name="nama_dosen" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Batas Waktu (Tenggat)</label>
                    <input type="datetime-local" id="edit_deadline_tugas" name="deadline_tugas" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                </div>

                <label class="flex items-start gap-3 bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/70 rounded-xl p-3.5 cursor-pointer select-none hover:border-orange-400 transition">
                    <input type="checkbox" id="edit_show_nilai" name="show_nilai" value="1" checked class="mt-0.5 w-4 h-4 accent-orange-500 cursor-pointer">
                    <span>
                        <span class="block text-xs font-bold text-slate-800 dark:text-slate-200">Tampilkan Nilai ke Mahasiswa?</span>
                        <span class="block text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">Jika tidak dicentang, mahasiswa hanya melihat status "sudah dinilai" tanpa angka nilai & catatan.</span>
                    </span>
                </label>

                <div class="flex justify-end gap-2.5 pt-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition">Batal</button>
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


    <!-- Javascript Interaktivitas -->
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

        // Initialize Theme UI on DOM loaded
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

        function toggleSubmissionList(id) {
            const el = document.getElementById(`sub-list-${id}`);
            if (el) el.classList.toggle('hidden');
        }

        function openNilaiModal(subId, namaMhs, currentNilai, catatanDosen = '') {
            const form = document.getElementById('nilaiForm');
            if (form) {
                form.action = `/kumpul-tugas/${subId}/nilai`;
                document.getElementById('nilai_nama_mahasiswa').value = namaMhs;
                document.getElementById('nilai_input').value = (currentNilai !== null && currentNilai !== 'null') ? currentNilai : '';
                const catEl = document.getElementById('nilai_catatan');
                if (catEl) catEl.value = (catatanDosen && catatanDosen !== 'undefined') ? catatanDosen : '';
                document.getElementById('nilaiModal').classList.remove('hidden');
            }
        }

        function closeNilaiModal() {
            const modal = document.getElementById('nilaiModal');
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

        function openKumpulModal(idTugas, namaTugas, isKirimUlang = false) {
            const modal = document.getElementById('kumpulModal');
            if (modal) {
                document.getElementById('kumpul_id_tugas').value = idTugas;
                document.getElementById('kumpul_nama_tugas').value = namaTugas;
                document.getElementById('kumpul_kirim_ulang').value = isKirimUlang ? '1' : '0';
                const notice = document.getElementById('kumpul_resubmit_notice');
                if (notice) notice.classList.toggle('hidden', !isKirimUlang);
                const btn = document.getElementById('kumpul_submit_btn');
                if (btn) btn.innerText = isKirimUlang ? 'Ajukan Kirim Ulang' : 'Kumpulkan Tugas';
                modal.classList.remove('hidden');
            }
        }

        function closeKumpulModal() {
            const modal = document.getElementById('kumpulModal');
            if (modal) modal.classList.add('hidden');
        }

        // ===== MODAL REVIEW / CATATAN DOSEN =====
        function openReviewModal(namaMhs, catatan, waktuNilai) {
            const modal = document.getElementById('reviewModal');
            if (modal) {
                document.getElementById('review_nama').innerText = namaMhs || '-';
                document.getElementById('review_isi').innerText = catatan || '(Tidak ada catatan)';
                document.getElementById('review_waktu').innerText = (waktuNilai && waktuNilai !== '-') ? ('Dinilai pada: ' + waktuNilai) : 'Belum ada waktu penilaian';
                modal.classList.remove('hidden');
            }
        }

        function closeReviewModal() {
            const modal = document.getElementById('reviewModal');
            if (modal) modal.classList.add('hidden');
        }

        // ===== SORTING TUGAS (Deadline / Abjad) =====
        function sortTasks(mode) {
            const container = document.getElementById('task-list-container');
            if (!container) return;
            const rows = Array.from(container.querySelectorAll('.task-row'));
            if (rows.length === 0) return;

            rows.sort((a, b) => {
                if (mode === 'deadline_asc' || mode === 'deadline_desc') {
                    const ta = parseInt(a.dataset.deadline || 0);
                    const tb = parseInt(b.dataset.deadline || 0);
                    return mode === 'deadline_asc' ? ta - tb : tb - ta;
                }
                // Abjad
                const na = a.dataset.nama || '';
                const nb = b.dataset.nama || '';
                return mode === 'nama_desc' ? nb.localeCompare(na, 'id') : na.localeCompare(nb, 'id');
            });

            const anchor = document.getElementById('no-task-filtered');
            rows.forEach(row => container.insertBefore(row, anchor));
        }

        // ===== PAGINATION PENGUMPULAN (10 PER HALAMAN) =====
        const SUB_PAGE_SIZE = 10;
        const subPageState = {};

        function initSubPagination() {
            document.querySelectorAll('[id^="sub-items-"]').forEach(wrapper => {
                const id = wrapper.id.replace('sub-items-', '');
                subPageState[id] = 1;
                renderSubPage(id);
            });
        }

        function renderSubPage(id) {
            const wrapper = document.getElementById(`sub-items-${id}`);
            if (!wrapper) return;
            const items = Array.from(wrapper.querySelectorAll(':scope > .sub-item'));
            const total = items.length;
            const totalPages = Math.max(1, Math.ceil(total / SUB_PAGE_SIZE));
            if (subPageState[id] > totalPages) subPageState[id] = totalPages;
            const page = subPageState[id];

            items.forEach((el, i) => {
                el.classList.toggle('hidden', !(i >= (page - 1) * SUB_PAGE_SIZE && i < page * SUB_PAGE_SIZE));
            });

            const controls = document.getElementById(`sub-controls-${id}`);
            if (controls) controls.classList.toggle('hidden', total <= SUB_PAGE_SIZE);

            const info = document.getElementById(`sub-pageinfo-${id}`);
            if (info) info.innerText = `Halaman ${page} dari ${totalPages} (${total} pengumpulan)`;

            const prevBtn = document.getElementById(`sub-prev-${id}`);
            const nextBtn = document.getElementById(`sub-next-${id}`);
            if (prevBtn) prevBtn.disabled = page <= 1;
            if (nextBtn) nextBtn.disabled = page >= totalPages;
        }

        function changeSubPage(id, delta) {
            if (!subPageState[id]) subPageState[id] = 1;
            subPageState[id] += delta;
            if (subPageState[id] < 1) subPageState[id] = 1;
            renderSubPage(id);
        }

        document.addEventListener('DOMContentLoaded', initSubPagination);

        function filterByDosen(dosenName) {
            currentSelectedDosen = dosenName;
            const taskRows = document.querySelectorAll('.task-row');
            const dosenCards = document.querySelectorAll('.dosen-card');
            const allCard = document.getElementById('dosen-card-all');
            const resetBtn = document.getElementById('reset-filter-btn');
            const titleEl = document.getElementById('task-table-title');
            const badgeEl = document.getElementById('filter-badge');
            const noTaskEl = document.getElementById('no-task-filtered');

            if (!dosenName) {
                taskRows.forEach(row => row.classList.remove('hidden'));
                
                allCard.className = "dosen-card cursor-pointer bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white border border-orange-400/50 rounded-xl p-3 flex items-center justify-between transition shadow-md shadow-orange-500/20";
                const allBadge = document.getElementById('badge-all-dosen');
                if (allBadge) allBadge.className = "text-[10px] font-bold bg-black/20 text-white px-2 py-0.5 rounded-md";

                dosenCards.forEach(c => {
                    if (c.id !== 'dosen-card-all') {
                        c.className = "dosen-card cursor-pointer bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/60 rounded-xl p-3 flex items-center justify-between hover:border-orange-500/50 hover:bg-slate-100 dark:hover:bg-slate-800 transition";
                    }
                });

                if (resetBtn) resetBtn.classList.add('hidden');
                if (badgeEl) badgeEl.classList.add('hidden');
                if (titleEl) titleEl.innerHTML = `<span>Semua Tugas Kuliah</span>`;
                if (noTaskEl) noTaskEl.classList.add('hidden');
            } else {
                let visibleCount = 0;
                const searchDosen = dosenName.toLowerCase();

                taskRows.forEach(row => {
                    const rowDosen = row.getAttribute('data-dosen');
                    if (rowDosen === searchDosen) {
                        row.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        row.classList.add('hidden');
                    }
                });

                allCard.className = "dosen-card cursor-pointer bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/60 rounded-xl p-3 flex items-center justify-between hover:border-orange-500/50 hover:bg-slate-100 dark:hover:bg-slate-800 transition text-slate-700 dark:text-slate-300";
                const allBadge = document.getElementById('badge-all-dosen');
                if (allBadge) allBadge.className = "hidden";

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
                if (titleEl) titleEl.innerHTML = `<span>Tugas Dosen: <strong class="text-orange-600 dark:text-orange-400">${dosenName}</strong> (${visibleCount})</span>`;

                if (visibleCount === 0 && noTaskEl) {
                    noTaskEl.classList.remove('hidden');
                } else if (noTaskEl) {
                    noTaskEl.classList.add('hidden');
                }
            }
        }

        function openAddModalWithDosen() {
            openAddModal();
            if (currentSelectedDosen) {
                const el = document.getElementById('add_nama_dosen');
                if (el) el.value = currentSelectedDosen;
            }
        }

        function setTab(name) {
            document.querySelectorAll('[id^="tab-Jurusan-"]').forEach(el => {
                el.className = "px-4 py-1.5 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-slate-200 transition";
            });
            const active = document.getElementById(`tab-${name.replace(' ', '-')}`);
            if (active) {
                active.className = "px-4 py-1.5 rounded-lg bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white font-bold transition shadow-sm shadow-orange-500/20";
            }
            const label = document.getElementById('active-tab-label');
            if (label) label.innerText = name;
        }

        function openAddModal() {
            const modal = document.getElementById('addModal');
            if (modal) {
                const el = document.getElementById('add_nama_dosen');
                if (el && currentSelectedDosen) {
                    el.value = currentSelectedDosen;
                }
                modal.classList.remove('hidden');
            }
        }

        function closeAddModal() {
            const modal = document.getElementById('addModal');
            if (modal) modal.classList.add('hidden');
        }

        function openEditModal(tugas) {
            const modal = document.getElementById('editModal');
            if (modal) {
                const id = tugas.id_tugas || tugas.id;
                document.getElementById('editForm').action = `/tugas/${id}`;
                document.getElementById('edit_nama_tugas').value = tugas.nama_tugas || '';
                document.getElementById('edit_nama_dosen').value = tugas.nama_dosen || '';

                if (tugas.deadline_tugas) {
                    const dt = new Date(tugas.deadline_tugas);
                    const year = dt.getFullYear();
                    const month = String(dt.getMonth() + 1).padStart(2, '0');
                    const day = String(dt.getDate()).padStart(2, '0');
                    const hours = String(dt.getHours()).padStart(2, '0');
                    const minutes = String(dt.getMinutes()).padStart(2, '0');
                    document.getElementById('edit_deadline_tugas').value = `${year}-${month}-${day}T${hours}:${minutes}`;
                }

                const showNilaiCb = document.getElementById('edit_show_nilai');
                if (showNilaiCb) {
                    showNilaiCb.checked = tugas.show_nilai === undefined ? true : !!tugas.show_nilai;
                }

                modal.classList.remove('hidden');
            }
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            if (modal) modal.classList.add('hidden');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeProfileDrawer();
                closeAddModal();
                closeEditModal();
                closeKumpulModal();
                closeNilaiModal();
                closeReviewModal();
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
