<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PKL_2026 - Modul Kuliah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        paper:   '#EEF0E9',
                        ink:     '#1B241E',
                        forest:  '#17513A',
                        forestd: '#0E3628',
                        gold:    '#B4832A',
                        golddk:  '#8F6620',
                        clay:    '#A94A2E',
                        line:    '#D6D6C6',
                    },
                    fontFamily: {
                        display: ['"Fraunces"', 'serif'],
                        sans: ['"Inter"', 'sans-serif'],
                        mono: ['"Space Mono"', 'monospace'],
                    },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #E4E6DC; }
        .font-display { font-family: 'Fraunces', serif; font-feature-settings: "ss02" 1; }
        .tabular { font-family: 'Space Mono', monospace; font-variant-numeric: tabular-nums; }
        .folder-tab { clip-path: polygon(10px 0, 100% 0, 100% 100%, 0 100%, 0 10px); }
        ::selection { background: #B4832A; color: #fff; }
        :focus-visible { outline: 2px solid #B4832A; outline-offset: 2px; }
    </style>
</head>
<body class="min-h-screen text-ink">

    <!-- Container Utama -->
    <div class="w-full bg-paper">

        <!-- Letterhead + Navigasi Page Switcher (Tugas vs Modul) -->
        <div class="bg-paper border-b border-line px-6 sm:px-10 pt-5">
          <div class="max-w-[1400px] mx-auto flex flex-wrap items-end justify-between gap-3">

            <!-- Identitas Fakultas -->
            <div class="flex items-center gap-3 pb-4">
                <a href="{{ route('home') }}" class="w-11 h-11 rounded-full bg-forest text-paper font-display font-semibold flex items-center justify-center text-[11px] shadow-sm ring-2 ring-forest/20 shrink-0 hover:opacity-90 transition">
                    UNMUL
                </a>
                <div class="leading-tight">
                    <span class="font-display font-semibold text-[15px] text-forestd block tracking-tight">Fakultas Teknik</span>
                    <span class="font-medium text-[11px] text-ink/50 uppercase tracking-[0.14em] block">Universitas Mulawarman</span>
                </div>
            </div>

            <!-- Page Switcher Tabs: Tugas Kuliah vs Modul Kuliah -->
            <div class="flex items-end gap-2 text-xs font-semibold pb-px">
                <a href="{{ route('tugas.index') }}"
                    class="folder-tab px-5 py-2.5 bg-line/60 text-ink/60 hover:bg-line hover:text-ink transition flex items-center gap-1.5 no-underline">
                    <span>📋</span> Tugas Kuliah
                </a>
                <a href="{{ route('modul.index') }}"
                    class="folder-tab px-5 py-2.5 bg-forest text-paper font-semibold transition shadow-sm flex items-center gap-1.5 no-underline">
                    <span>📖</span> Modul Kuliah
                </a>
            </div>
          </div>
        </div>

        <!-- Alert Notification Messages -->
        @if(session('success') || session('error') || $errorMessage)
        <div class="px-6 sm:px-10 pt-4 bg-paper">
          <div class="max-w-[1400px] mx-auto space-y-2">
            @if(session('success'))
                <div class="flex items-center gap-2.5 pl-4 pr-4 py-3 bg-forest/[0.06] border-l-4 border-forest text-forestd rounded-r-lg text-sm font-medium">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="shrink-0"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error') || $errorMessage)
                <div class="flex items-center gap-2.5 pl-4 pr-4 py-3 bg-clay/[0.07] border-l-4 border-clay text-clay rounded-r-lg text-sm font-medium">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="shrink-0"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 8v5M12 16h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    {{ session('error') ?? $errorMessage }}
                </div>
            @endif
          </div>
        </div>
        @endif

        <!-- Area Konten Utama -->
        <div class="bg-forest px-6 sm:px-10 py-8 min-h-[calc(100vh-88px)] relative">
            <div class="absolute inset-0 opacity-[0.04] pointer-events-none" style="background-image:radial-gradient(circle at 1px 1px, #fff 1px, transparent 0); background-size: 18px 18px;"></div>

            <!-- Top Controls & Dual/Triple Service Status Checkers -->
            <div class="relative max-w-[1400px] mx-auto flex flex-wrap items-center justify-between mb-7 gap-3">
                <div class="flex flex-wrap items-center gap-2.5">
                    <!-- Status FastAPI 1 -->
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-paper uppercase tracking-wide bg-black/15 px-3 py-1.5 rounded-full border border-paper/15" title="FastAPI 1 (Port 8000)">
                        @if($apiConnected)
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_0_3px_rgba(52,211,153,0.25)]"></span> API Tugas (8000)
                        @else
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> API Tugas (Off)
                        @endif
                    </span>

                    <!-- Status FastAPI 2 -->
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-paper uppercase tracking-wide bg-black/15 px-3 py-1.5 rounded-full border border-paper/15" title="FastAPI 2 (Port 8001)">
                        @if($api2Connected)
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_0_3px_rgba(52,211,153,0.25)]"></span> API Pengumpulan (8001)
                        @else
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> API Pengumpulan (Off)
                        @endif
                    </span>

                    <!-- Status FastAPI 3 Modul -->
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-paper uppercase tracking-wide bg-black/15 px-3 py-1.5 rounded-full border border-paper/15" title="FastAPI 3 Modul (Port 8002)">
                        @if($api3Connected)
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_0_3px_rgba(52,211,153,0.25)]"></span> API Modul (Port 8002)
                        @else
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> API Modul (Offline)
                        @endif
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                        <button onclick="openAddModulModal()" class="px-4 py-2.5 bg-gold text-forestd font-bold text-sm rounded-lg shadow-md hover:bg-[#c4923a] active:scale-[0.98] transition flex items-center gap-2">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                            Tambah Modul Baru
                        </button>
                    @endif

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3.5 py-2 bg-black/20 hover:bg-rose-500/20 text-paper/80 hover:text-rose-300 border border-paper/20 rounded-lg text-xs font-semibold transition flex items-center gap-1.5">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            <div class="relative max-w-[1400px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- LEFT COLUMN: Identitas + Ledger Modul -->
                <div class="lg:col-span-7 space-y-4">

                    <!-- Profile Pill Auth User -->
                    <div class="bg-forestd/60 border border-paper/15 rounded-full pl-2 pr-5 py-2 flex items-center justify-between gap-3 w-full sm:w-auto sm:inline-flex">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-gold text-forestd border-2 border-paper/40 flex items-center justify-center font-display font-semibold text-sm shrink-0 uppercase">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="leading-tight">
                                <span class="block text-[10px] text-paper/50 uppercase tracking-wide font-medium">
                                    Login sebagai: {{ auth()->user()->name }}
                                </span>
                                <div class="flex items-center gap-2">
                                    <span class="block text-paper font-semibold text-sm">
                                        {{ auth()->user()->nomer_induk ?? '-' }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                        @if(auth()->user()->isDosen()) bg-purple-500/20 text-purple-200 border border-purple-400/30
                                        @elseif(auth()->user()->isAdmin()) bg-rose-500/20 text-rose-200 border border-rose-400/30
                                        @else bg-emerald-500/20 text-emerald-200 border border-emerald-400/30 @endif">
                                        {{ auth()->user()->role }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ledger Modul -->
                    <div class="rounded-xl overflow-hidden bg-forestd/40 border border-paper/15 shadow-xl">

                        <div class="grid grid-cols-[1fr_auto] gap-4 border-b border-paper/15 bg-black/10 text-paper/60 font-semibold text-[11px] uppercase tracking-wider px-4 py-3 items-center">
                            <div id="modul-table-title" class="font-bold text-gold flex items-center gap-2">
                                <span>📖 Modul & Materi Kuliah</span>
                                <span id="filter-badge" class="hidden bg-gold/20 text-gold px-2 py-0.5 rounded text-[10px] lowercase font-mono">filter aktif</span>
                            </div>
                            <div>Tanggal Unggah</div>
                        </div>

                        <div id="modul-list-container" class="divide-y divide-paper/10">
                            @forelse($modulList as $modul)
                                @php
                                    $idModul = $modul['id_modul'] ?? $modul['id'] ?? null;
                                    $tglUpload = isset($modul['tanggal_diupload']) ? \Carbon\Carbon::parse($modul['tanggal_diupload'])->translatedFormat('j M Y, H:i') : '-';
                                    $fileUrl = $modul['file_modul'] ?? null;
                                @endphp
                                <div class="modul-row p-4 hover:bg-black/10 transition group space-y-2" data-dosen="{{ strtolower($modul['nama_dosen'] ?? '') }}">
                                    <div class="grid grid-cols-[1fr_auto] gap-4 items-center">

                                        <div class="min-w-0">
                                            <p class="font-display font-semibold text-paper text-[15px] truncate" title="{{ $modul['nama_modul'] }}">
                                                {{ $modul['nama_modul'] }}
                                            </p>
                                            <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-1">
                                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-300 bg-emerald-500/20 border border-emerald-400/30 px-2.5 py-0.5 rounded-full">
                                                    📄 Modul #{{ $idModul }}
                                                </span>

                                                <span class="text-[11px] text-paper/50 font-medium">
                                                    • Dosen: {{ $modul['nama_dosen'] }}
                                                </span>

                                                <!-- Action Buttons for Modul -->
                                                <div class="flex items-center gap-1.5 transition ml-auto">
                                                    <!-- Link Buka File Modul -->
                                                    @if(!empty($fileUrl))
                                                        <a href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer" class="text-xs bg-gold/20 hover:bg-gold/30 text-gold border border-gold/30 px-2.5 py-1 rounded font-semibold transition flex items-center gap-1" title="Buka File / Google Drive Modul">
                                                            🔗 Buka Modul
                                                        </a>
                                                    @endif

                                                    <!-- Edit & Hapus Modul (Dosen & Admin) -->
                                                    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                                                        <button onclick='openEditModulModal({{ json_encode($modul) }})' class="text-paper/60 hover:text-gold p-1 rounded transition" title="Ubah modul">
                                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M12 20h9M16.5 3.5a2.12 2.12 0 013 3L7 19l-4 1 1-4L16.5 3.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                        </button>
                                                        <form action="{{ route('modul.destroy', $idModul) }}" method="POST" class="inline" onsubmit="return confirm('Hapus modul ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-paper/60 hover:text-rose-300 p-1 rounded transition" title="Hapus modul">
                                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tabular text-[12px] text-paper/70 text-right shrink-0">
                                            {{ $tglUpload }}
                                        </div>

                                    </div>
                                </div>
                            @empty
                                <div class="py-10 px-4 text-center">
                                    <p class="text-paper/70 text-sm font-medium">Belum ada modul kuliah diunggah.</p>
                                    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                                        <p class="text-paper/40 text-xs mt-1">Klik &ldquo;Tambah Modul Baru&rdquo; untuk mulai membagikan materi.</p>
                                    @endif
                                </div>
                            @endforelse
                        </div>

                    </div>

                </div>

                <!-- RIGHT COLUMN: Dosen Pengampu Filter -->
                <div class="lg:col-span-5 space-y-4">

                    <div class="pl-1 flex items-center justify-between">
                        <div>
                            <span class="block text-[10px] text-gold uppercase tracking-[0.14em] font-semibold mb-0.5">Filter Dosen</span>
                            <h2 class="font-display font-semibold text-2xl text-paper tracking-tight">Dosen Penyusun</h2>
                        </div>
                        
                        <button onclick="filterByDosen(null)" id="reset-filter-btn" class="hidden text-xs bg-gold/20 hover:bg-gold/30 text-gold font-semibold px-2.5 py-1 rounded-lg transition">
                            Tampilkan Semua
                        </button>
                    </div>

                    @php
                        $groupedDosen = collect($modulList)->groupBy('nama_dosen');
                    @endphp

                    <div class="space-y-3">
                        <div onclick="filterByDosen(null)" id="dosen-card-all" class="dosen-card cursor-pointer bg-gold text-forestd border-2 border-gold rounded-xl p-3.5 flex items-center justify-between transition shadow-md">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-forestd/20 flex items-center justify-center font-display font-bold text-sm">
                                    👥
                                </div>
                                <div>
                                    <p class="font-bold text-sm">Semua Dosen</p>
                                    <p class="text-[11px] opacity-80 font-medium">Tampilkan seluruh modul ({{ count($modulList) }})</p>
                                </div>
                            </div>
                            <span id="badge-all-dosen" class="text-xs font-bold bg-forestd text-paper px-2.5 py-1 rounded-full">Aktif</span>
                        </div>

                        @forelse($groupedDosen as $dosenName => $items)
                            <div onclick="filterByDosen('{{ addslashes($dosenName) }}')" 
                                 data-dosen-name="{{ strtolower($dosenName) }}"
                                 class="dosen-card cursor-pointer bg-forestd/40 border border-paper/15 rounded-xl p-3.5 flex items-center justify-between hover:border-gold/60 hover:bg-forestd/70 transition">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <div class="w-11 h-11 rounded-full bg-paper flex-shrink-0 flex items-center justify-center text-forestd font-display font-semibold text-base">
                                        {{ strtoupper(substr($dosenName ?? '?', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-[13.5px] text-paper truncate">
                                            {{ $dosenName }}
                                        </p>
                                        <p class="text-[12px] text-paper/55 truncate mt-0.5">
                                            {{ count($items) }} Modul Diunggah
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <span class="text-xs text-gold/80 font-mono font-bold bg-black/20 px-2 py-1 rounded-md">
                                        {{ count($items) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="bg-forestd/40 border border-dashed border-paper/20 rounded-xl p-4 text-center">
                                <p class="text-paper/50 text-xs">Belum ada dosen pengunggah modul.</p>
                            </div>
                        @endforelse
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- MODAL TAMBAH MODUL (DOSEN & ADMIN) -->
    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
    <div id="addModulModal" class="fixed inset-0 z-50 hidden bg-ink/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-paper rounded-2xl max-w-md w-full p-6 shadow-2xl border border-line">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-display font-semibold text-lg text-forestd">Tambah Modul Kuliah Baru</h3>
                <button onclick="closeAddModulModal()" class="text-ink/30 hover:text-ink/70 text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form action="{{ route('modul.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1.5">Nama / Judul Modul</label>
                    <input type="text" name="nama_modul" required placeholder="Contoh: Modul 1 - Pemrograman Web Laravel" class="w-full bg-white border border-line rounded-lg px-3 py-2.5 text-sm text-ink focus:outline-none focus:border-forest focus:ring-2 focus:ring-forest/15 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1.5">Nama Dosen Pengampu</label>
                    <input type="text" name="nama_dosen" value="{{ auth()->user()->name }}" required class="w-full bg-white border border-line rounded-lg px-3 py-2.5 text-sm text-ink focus:outline-none focus:border-forest focus:ring-2 focus:ring-forest/15 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1.5">Link File / Google Drive Modul <span class="text-rose-500">*</span></label>
                    <input type="url" name="file_modul" required placeholder="https://drive.google.com/file/d/..." class="w-full bg-white border border-line rounded-lg px-3 py-2.5 text-sm text-ink focus:outline-none focus:border-forest focus:ring-2 focus:ring-forest/15 transition">
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeAddModulModal()" class="px-4 py-2.5 bg-line/60 text-ink/70 rounded-lg text-xs font-bold hover:bg-line transition">Batal</button>
                    <button type="submit" class="px-4 py-2.5 bg-forest text-paper rounded-lg text-xs font-bold shadow hover:bg-forestd transition">Simpan Modul</button>
                </div>
            </form>
        </div>
    </div>


    <!-- MODAL EDIT MODUL (DOSEN & ADMIN) -->
    <div id="editModulModal" class="fixed inset-0 z-50 hidden bg-ink/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-paper rounded-2xl max-w-md w-full p-6 shadow-2xl border border-line">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-display font-semibold text-lg text-forestd">Ubah Modul Kuliah</h3>
                <button onclick="closeEditModulModal()" class="text-ink/30 hover:text-ink/70 text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form id="editModulForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1.5">Nama / Judul Modul</label>
                    <input type="text" id="edit_nama_modul" name="nama_modul" required class="w-full bg-white border border-line rounded-lg px-3 py-2.5 text-sm text-ink focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/15 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1.5">Nama Dosen Pengampu</label>
                    <input type="text" id="edit_nama_dosen" name="nama_dosen" required class="w-full bg-white border border-line rounded-lg px-3 py-2.5 text-sm text-ink focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/15 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1.5">Link File / Google Drive Modul</label>
                    <input type="url" id="edit_file_modul" name="file_modul" required class="w-full bg-white border border-line rounded-lg px-3 py-2.5 text-sm text-ink focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/15 transition">
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeEditModulModal()" class="px-4 py-2.5 bg-line/60 text-ink/70 rounded-lg text-xs font-bold hover:bg-line transition">Batal</button>
                    <button type="submit" class="px-4 py-2.5 bg-gold text-forestd rounded-lg text-xs font-bold shadow hover:bg-[#c4923a] transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endif


    <script>
        let currentSelectedDosen = null;

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
                allCard.className = "dosen-card cursor-pointer bg-gold text-forestd border-2 border-gold rounded-xl p-3.5 flex items-center justify-between transition shadow-md";
                document.getElementById('badge-all-dosen').className = "text-xs font-bold bg-forestd text-paper px-2.5 py-1 rounded-full";

                dosenCards.forEach(c => {
                    if (c.id !== 'dosen-card-all') {
                        c.className = "dosen-card cursor-pointer bg-forestd/40 border border-paper/15 rounded-xl p-3.5 flex items-center justify-between hover:border-gold/60 hover:bg-forestd/70 transition";
                    }
                });

                resetBtn.classList.add('hidden');
                badgeEl.classList.add('hidden');
                titleEl.innerHTML = `<span>📖 Modul & Materi Kuliah</span>`;
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

                allCard.className = "dosen-card cursor-pointer bg-forestd/40 border border-paper/15 rounded-xl p-3.5 flex items-center justify-between hover:border-gold/60 hover:bg-forestd/70 transition text-paper";
                document.getElementById('badge-all-dosen').className = "hidden";

                dosenCards.forEach(c => {
                    if (c.id !== 'dosen-card-all') {
                        const targetDosen = c.getAttribute('data-dosen-name');
                        if (targetDosen === searchDosen) {
                            c.className = "dosen-card cursor-pointer bg-[#B4832A]/20 border-2 border-[#B4832A] rounded-xl p-3.5 flex items-center justify-between transition shadow-lg text-paper font-semibold";
                        } else {
                            c.className = "dosen-card cursor-pointer bg-forestd/40 border border-paper/15 rounded-xl p-3.5 flex items-center justify-between hover:border-gold/60 hover:bg-forestd/70 transition opacity-60";
                        }
                    }
                });

                resetBtn.classList.remove('hidden');
                badgeEl.classList.remove('hidden');
                titleEl.innerHTML = `<span>Modul dari: <strong class="text-paper">${dosenName}</strong> (${visibleCount})</span>`;
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

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAddModulModal();
                closeEditModulModal();
            }
        });
    </script>
</body>
</html>
