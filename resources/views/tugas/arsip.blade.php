<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Tugas — Fakultas Teknik UNMUL</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
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
    </style>
</head>
<body class="min-h-screen bg-slate-100 dark:bg-[#0f172a] text-slate-800 dark:text-slate-100 antialiased flex flex-col">

    <!-- Background Ambient -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute -top-40 left-1/4 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -right-40 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image:radial-gradient(circle at 1px 1px, currentColor 1px, transparent 0); background-size: 24px 24px;"></div>
    </div>

    <!-- HEADER -->
    <header class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 sticky top-0 z-40 shadow-sm dark:shadow-lg dark:shadow-black/20 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">
                <div class="flex items-center gap-3 sm:gap-6 min-w-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 shrink-0 group no-underline text-inherit">
                        <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL" class="w-9 h-9 sm:w-10 sm:h-10 object-contain drop-shadow-md group-hover:scale-105 transition-transform">
                        <div class="hidden sm:block leading-tight">
                            <span class="font-extrabold text-sm text-slate-900 dark:text-white block tracking-tight group-hover:text-orange-500 transition-colors">FAKULTAS TEKNIK</span>
                            <span class="font-semibold text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-widest block">UNIVERSITAS MULAWARMAN</span>
                        </div>
                    </a>

                    <div class="flex items-center gap-1 bg-slate-100 dark:bg-slate-800/90 p-1 rounded-xl border border-slate-200 dark:border-slate-700/80 text-xs font-semibold shadow-inner">
                        <a href="{{ route('tugas.index') }}"
                           class="page-switch-link px-3 sm:px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 no-underline transition-all text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200/70 dark:hover:bg-slate-700/60">
                            <svg class="w-3.5 h-3.5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            <span class="hidden md:inline">Tugas Kuliah</span><span class="md:hidden">Tugas</span>
                        </a>
                        <span class="page-switch-link px-3 sm:px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white font-bold shadow-md shadow-orange-500/20 active-tab">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                            <span class="hidden md:inline">Arsip Tugas</span><span class="md:hidden">Arsip</span>
                        </span>
                    </div>
                </div>

                <button type="button" onclick="toggleTheme()" class="relative hidden md:inline-flex items-center w-14 h-7 p-0.5 rounded-full cursor-pointer transition-colors duration-300 bg-slate-200 dark:bg-slate-700/90 border border-slate-300 dark:border-slate-600 focus:outline-none theme-slider-btn" aria-label="Ganti Mode Tema">
                    <span class="absolute left-1.5 flex items-center justify-center pointer-events-none opacity-80 dark:opacity-30 transition-opacity">
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
            </div>
        </div>
    </header>

    <div id="pageMainContent" class="page-transition-wrapper flex-1 relative z-10">

        @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="p-3.5 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-300 dark:border-emerald-500/40 text-emerald-800 dark:text-emerald-200 rounded-xl text-xs font-semibold shadow-sm">{{ session('success') }}</div>
        </div>
        @endif
        @if(session('error') || $errorMessage)
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="p-3.5 bg-rose-50 dark:bg-rose-950/60 border border-rose-300 dark:border-rose-500/40 text-rose-800 dark:text-rose-200 rounded-xl text-xs font-semibold shadow-sm">{{ session('error') ?? $errorMessage }}</div>
        </div>
        @endif

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

            <!-- Judul Halaman -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2.5">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                        Arsip Tugas
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Seluruh tugas yang sudah melewati tenggat waktu — data tetap tersimpan di database.</p>
                </div>
                <label class="flex items-center gap-2 text-[11px] font-semibold text-slate-500 dark:text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4 4m0 0l4-4m-4 4V7"/></svg>
                    Urutkan Berdasarkan
                    <select id="sort-select" onchange="sortTasks(this.value)" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-2.5 py-1.5 text-[11px] font-semibold text-slate-700 dark:text-slate-200 focus:outline-none focus:border-orange-500 cursor-pointer">
                        <option value="deadline_desc" selected>Terlama &rarr; Terbaru</option>
                        <option value="deadline_asc">Terbaru &rarr; Terlama</option>
                        <option value="nama_asc">Abjad A &rarr; Z</option>
                        <option value="nama_desc">Abjad Z &rarr; A</option>
                    </select>
                </label>
            </div>

            <!-- Daftar Arsip -->
            <div class="bg-white dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm dark:shadow-xl dark:shadow-black/20 overflow-hidden backdrop-blur-sm transition-colors duration-300">
                <div id="arsip-container" class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @php
                        /*
                         | CATATAN HAK AKSES (ROLE) — HALAMAN ARSIP:
                         | - Admin: akses penuh, melihat semua tugas & seluruh data pengumpulan (tanpa validasi khusus dosen).
                         | - Dosen: hanya melihat arsip tugas miliknya + jumlah pengumpulannya.
                         | - Mahasiswa: hanya melihat ringkasan pengumpulan miliknya sendiri.
                         */
                        $isDosenOnly = auth()->user()->isDosen() && !auth()->user()->isAdmin();
                        $canManage = auth()->user()->isDosen() || auth()->user()->isAdmin();
                        // [PERUBAHAN] Admin juga dapat melihat ringkasan pengumpulan pribadinya (akses penuh seperti mahasiswa)
                        $canSubmit = auth()->user()->isMahasiswa() || auth()->user()->isAdmin();
                    @endphp
                    @forelse($tugasList as $tugas)
                        @php
                            $id = $tugas['id_tugas'] ?? $tugas['id'] ?? null;
                            $deadline = isset($tugas['deadline_tugas']) ? \Carbon\Carbon::parse($tugas['deadline_tugas']) : null;
                            $submissions = collect($kumpulList)->where('id_tugas', $id);
                            $mySubmission = $submissions->firstWhere('nama_mahasiswa', auth()->user()->name);
                            $getNilai = function ($sub) {
                                if (isset($sub['nilai']) && $sub['nilai'] !== null && $sub['nilai'] !== '') return (int) $sub['nilai'];
                                if (isset($sub['nilai_mahasiswa']) && $sub['nilai_mahasiswa'] !== null && $sub['nilai_mahasiswa'] !== '' && (float) $sub['nilai_mahasiswa'] > 0) return (int) $sub['nilai_mahasiswa'];
                                return null;
                            };
                        @endphp
                        <div class="task-row p-5 hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition duration-150"
                             data-deadline="{{ $deadline ? $deadline->timestamp : 0 }}"
                             data-nama="{{ mb_strtolower($tugas['nama_tugas'] ?? '') }}">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                        <span class="inline-block px-2 py-0.5 text-[10px] font-bold border rounded-md bg-slate-200 dark:bg-slate-700/60 text-slate-600 dark:text-slate-300 border-slate-300 dark:border-slate-600">
                                            Diarsipkan
                                        </span>
                                        <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">• Dosen: <strong class="text-slate-800 dark:text-slate-300">{{ $tugas['nama_dosen'] }}</strong></span>
                                    </div>
                                    <h3 class="font-bold text-base text-slate-900 dark:text-white truncate" title="{{ $tugas['nama_tugas'] }}">
                                        {{ $tugas['nama_tugas'] }}
                                    </h3>
                                </div>

                                <div class="flex flex-col items-start sm:items-end gap-2 shrink-0">
                                    <span class="inline-flex items-center gap-1.5 text-[11px] font-mono font-medium text-rose-600 dark:text-rose-300 bg-rose-500/10 px-2.5 py-1 rounded-lg border border-rose-500/20" title="Tenggat Waktu">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        Deadline: {{ $deadline?->translatedFormat('l, j F Y \• H:i') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Ringkasan pengumpulan --}}
                            <div class="mt-3 bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800/80 rounded-xl p-3.5 text-xs">
                                @if($canManage)
                                    <span class="text-slate-700 dark:text-slate-300 font-semibold flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                                        Total Pengumpulan Tersimpan:
                                        <strong class="text-orange-600 dark:text-orange-400">{{ count($submissions) }} Mahasiswa</strong>
                                        <span class="text-[10px] text-slate-400 font-mono">(arsip database)</span>
                                    </span>
                                @elseif($mySubmission)
                                    @php
                                        $tglKumpul = isset($mySubmission['tanggal_kumpul']) ? \Carbon\Carbon::parse($mySubmission['tanggal_kumpul'])->translatedFormat('l, j F Y \jam H:i') : '-';
                                        $showNilaiArsip = array_key_exists('show_nilai', $tugas) ? (bool) $tugas['show_nilai'] : true;
                                        $nilaiVal = $showNilaiArsip ? $getNilai($mySubmission) : null;
                                        $gradeHuruf = $nilaiVal !== null ? \App\Support\Grade::huruf($nilaiVal) : null;
                                        $tglNilai = isset($mySubmission['dinilai_at']) && $mySubmission['dinilai_at'] ? \Carbon\Carbon::parse($mySubmission['dinilai_at'])->translatedFormat('j M Y, H:i') : null;
                                    @endphp
                                    <span class="text-slate-700 dark:text-slate-300 font-semibold flex items-center gap-2 flex-wrap">
                                        Kamu mengumpulkan tugas ini pada <strong class="font-mono text-[11px]">{{ $tglKumpul }}</strong>
                                        @if($showNilaiArsip && $nilaiVal !== null)
                                            <span class="px-2 py-0.5 bg-amber-50 dark:bg-amber-500/20 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-500/30 rounded font-extrabold text-[11px]">Nilai: {{ $nilaiVal }} / 100</span>
                                            <span class="px-2 py-0.5 border rounded font-extrabold text-[11px]
                                                {{ $gradeHuruf === 'A' ? 'bg-emerald-500/15 text-emerald-600 dark:text-emerald-300 border-emerald-500/30' :
                                                   ($gradeHuruf === 'B' ? 'bg-blue-500/15 text-blue-600 dark:text-blue-300 border-blue-500/30' :
                                                   ($gradeHuruf === 'C' ? 'bg-amber-500/15 text-amber-600 dark:text-amber-300 border-amber-500/30' :
                                                   ($gradeHuruf === 'D' ? 'bg-orange-500/15 text-orange-600 dark:text-orange-300 border-orange-500/30' :
                                                   'bg-rose-500/15 text-rose-600 dark:text-rose-300 border-rose-500/30'))) }}">Grade: {{ $gradeHuruf }}</span>
                                            @if($tglNilai)<span class="text-[10px] text-slate-500 dark:text-slate-400 font-mono">Dinilai: {{ $tglNilai }}</span>@endif
                                        @elseif(!$showNilaiArsip)
                                            <span class="text-[10px] italic text-slate-500">Nilai tidak ditampilkan oleh dosen</span>
                                        @else
                                            <span class="text-[10px] italic text-slate-500">Belum dinilai</span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-slate-500 dark:text-slate-400 italic">Tidak ada catatan pengumpulan untukmu di tugas ini.</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-14 text-center">
                            <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 mx-auto flex items-center justify-center mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                            </div>
                            <p class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Belum ada tugas yang melewati tenggat waktu.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </main>
    </div>

    <!-- Footer Info -->
    <footer class="relative z-10 py-4 text-center">
        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-widest">Arsip Tugas • Data tetap tersimpan meski deadline terlewat</p>
    </footer>

    <script>
        function setThemeMode(mode) {
            if (mode === 'dark') {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
                localStorage.setItem('pkl_theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
                localStorage.setItem('pkl_theme', 'light');
            }
        }

        function toggleTheme() {
            const isCurrentlyDark = document.documentElement.classList.contains('dark');
            setThemeMode(isCurrentlyDark ? 'light' : 'dark');
        }

        function sortTasks(mode) {
            const container = document.getElementById('arsip-container');
            if (!container) return;
            const rows = Array.from(container.querySelectorAll('.task-row'));
            rows.sort((a, b) => {
                if (mode === 'deadline_asc' || mode === 'deadline_desc') {
                    const ta = parseInt(a.dataset.deadline || 0);
                    const tb = parseInt(b.dataset.deadline || 0);
                    return mode === 'deadline_asc' ? ta - tb : tb - ta;
                }
                const na = a.dataset.nama || '';
                const nb = b.dataset.nama || '';
                return mode === 'nama_desc' ? nb.localeCompare(na, 'id') : na.localeCompare(nb, 'id');
            });
            rows.forEach(row => container.appendChild(row));
        }

        // Smooth Page Switch Interceptor
        document.querySelectorAll('.page-switch-link').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.tagName === 'A' && this.href && !this.classList.contains('active-tab')) {
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
