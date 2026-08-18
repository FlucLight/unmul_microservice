<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PKL_2026 - Manajemen Tugas Kuliah</title>
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

    <!-- Container Utama: full-bleed, tanpa bingkai kartu -->
    <div class="w-full bg-paper">

        <!-- Letterhead + Navigasi Tab Jurusan -->
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

            <!-- Tabs Jurusan: metafora map folder -->
            <div class="flex items-end gap-1.5 overflow-x-auto text-xs font-semibold pb-px" role="tablist" aria-label="Pilih jurusan">
                <button onclick="setTab('Jurusan 1')" id="tab-Jurusan-1" role="tab" aria-selected="true"
                    class="folder-tab px-5 py-2.5 bg-forest text-paper font-semibold transition shadow-sm">
                    Jurusan 1
                </button>
                <button onclick="setTab('Jurusan 2')" id="tab-Jurusan-2" role="tab" aria-selected="false"
                    class="folder-tab px-5 py-2.5 bg-line/60 text-ink/55 hover:bg-line hover:text-ink/80 transition">
                    Jurusan 2
                </button>
                <button onclick="setTab('Jurusan 3')" id="tab-Jurusan-3" role="tab" aria-selected="false"
                    class="folder-tab px-5 py-2.5 bg-line/60 text-ink/55 hover:bg-line hover:text-ink/80 transition">
                    Jurusan 3
                </button>
                <button onclick="setTab('Jurusan 4')" id="tab-Jurusan-4" role="tab" aria-selected="false"
                    class="folder-tab px-5 py-2.5 bg-line/60 text-ink/55 hover:bg-line hover:text-ink/80 transition">
                    Jurusan 4
                </button>
                <button onclick="setTab('Jurusan 5')" id="tab-Jurusan-5" role="tab" aria-selected="false"
                    class="folder-tab px-5 py-2.5 bg-line/60 text-ink/55 hover:bg-line hover:text-ink/80 transition">
                    Jurusan 5
                </button>
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

            <!-- Top Controls & Status Service FastAPI 1 + FastAPI 2 -->
            <div class="relative max-w-[1400px] mx-auto flex flex-wrap items-center justify-between mb-7 gap-3">
                <div class="flex flex-wrap items-center gap-2.5">
                    <!-- Status FastAPI 1 -->
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-paper uppercase tracking-wide bg-black/15 px-3 py-1.5 rounded-full border border-paper/15" title="Server FastAPI 1 (Port 8000)">
                        @if($apiConnected)
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_0_3px_rgba(52,211,153,0.25)]"></span> FastAPI 1 (Port 8000)
                        @else
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> FastAPI 1 (Offline)
                        @endif
                    </span>

                    <!-- Status FastAPI 2 -->
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-paper uppercase tracking-wide bg-black/15 px-3 py-1.5 rounded-full border border-paper/15" title="Server FastAPI 2 (Port 8001)">
                        @if($api2Connected)
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_0_3px_rgba(52,211,153,0.25)]"></span> FastAPI 2 (Port 8001)
                        @else
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> FastAPI 2 (Offline)
                        @endif
                    </span>

                    <span id="active-tab-label" class="text-[11px] font-semibold text-gold bg-paper/10 px-3 py-1.5 rounded-full uppercase tracking-wide">
                        Jurusan 1
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                        <button onclick="openAddModal()" class="px-4 py-2.5 bg-gold text-forestd font-bold text-sm rounded-lg shadow-md hover:bg-[#c4923a] active:scale-[0.98] transition flex items-center gap-2">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                            Tambah Tugas Baru
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

                <!-- LEFT COLUMN: Identitas + Ledger Tugas -->
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

                    <!-- Ledger Tugas -->
                    <div class="rounded-xl overflow-hidden bg-forestd/40 border border-paper/15 shadow-xl">

                        <div class="grid grid-cols-[1fr_auto] gap-4 border-b border-paper/15 bg-black/10 text-paper/60 font-semibold text-[11px] uppercase tracking-wider px-4 py-3 items-center">
                            <div id="task-table-title" class="font-bold text-gold flex items-center gap-2">
                                <span>Tugas Kuliah</span>
                                <span id="filter-badge" class="hidden bg-gold/20 text-gold px-2 py-0.5 rounded text-[10px] lowercase font-mono">filter aktif</span>
                            </div>
                            <div>Tenggat</div>
                        </div>

                        <div id="task-list-container" class="divide-y divide-paper/10">
                            @forelse($tugasList as $index => $tugas)
                                @php
                                    $id = $tugas['id_tugas'] ?? $tugas['id'] ?? null;
                                    $deadline = isset($tugas['deadline_tugas']) ? \Carbon\Carbon::parse($tugas['deadline_tugas']) : null;

                                    // Filter data pengumpulan tugas dari FastAPI2 untuk id_tugas ini
                                    $submissions = collect($kumpulList)->where('id_tugas', $id);

                                    // Cek apakah mahasiswa yang sedang login sudah mengumpulkan tugas ini
                                    $userSubmission = $submissions->firstWhere('nama_mahasiswa', auth()->user()->name);
                                    $isSubmitted = !is_null($userSubmission);
                                @endphp
                                <div class="task-row p-4 hover:bg-black/10 transition group space-y-2" data-dosen="{{ strtolower($tugas['nama_dosen'] ?? '') }}">
                                    <div class="grid grid-cols-[1fr_auto] gap-4 items-center">

                                        <div class="min-w-0">
                                            <p class="font-display font-semibold text-paper text-[15px] truncate" title="{{ $tugas['nama_tugas'] }}">
                                                {{ $tugas['nama_tugas'] }}
                                            </p>
                                            <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-1">

                                                <!-- STATUS TAMPILAN KHUSUS MAHASISWA vs DOSEN -->
                                                @if(auth()->user()->isMahasiswa())
                                                    @if($isSubmitted)
                                                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-emerald-300 bg-emerald-500/20 border border-emerald-400/30 px-2.5 py-0.5 rounded-full">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Selesai
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-amber-300 bg-amber-500/20 border border-amber-400/30 px-2.5 py-0.5 rounded-full">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Belum Selesai
                                                        </span>
                                                    @endif
                                                @else
                                                    <!-- DOSEN VIEW: Tampilan Ringkas & Profesional -->
                                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-gold bg-gold/15 border border-gold/30 px-2.5 py-0.5 rounded-full">
                                                        📋 Tugas #{{ $id }}
                                                    </span>
                                                @endif

                                                <span class="text-[11px] text-paper/50 font-medium">
                                                    • Dosen: {{ $tugas['nama_dosen'] }}
                                                </span>

                                                <!-- Action Buttons for Task -->
                                                <div class="flex items-center gap-1 transition ml-auto">
                                                    <!-- Button Kumpulkan Tugas (Khusus Mahasiswa & Admin) -->
                                                    @if(auth()->user()->isMahasiswa() || auth()->user()->isAdmin())
                                                        <button onclick='openKumpulModal({{ $id }}, "{{ addslashes($tugas['nama_tugas']) }}")' class="text-xs bg-gold/20 hover:bg-gold/30 text-gold px-2.5 py-1 rounded font-semibold transition flex items-center gap-1" title="Kumpulkan Tugas">
                                                            <span>📤</span> {{ $isSubmitted ? 'Kumpul Ulang' : 'Kumpulkan' }}
                                                        </button>
                                                    @endif

                                                    <!-- Button Edit & Hapus Tugas (Khusus Dosen & Admin) -->
                                                    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                                                        <button onclick='openEditModal({{ json_encode($tugas) }})' class="text-paper/60 hover:text-gold p-1 rounded transition" title="Ubah tugas">
                                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M12 20h9M16.5 3.5a2.12 2.12 0 013 3L7 19l-4 1 1-4L16.5 3.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                        </button>
                                                        <form action="{{ route('tugas.destroy', $id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tugas ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-paper/60 hover:text-rose-300 p-1 rounded transition" title="Hapus tugas">
                                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tabular text-[13px] text-paper/70 text-right shrink-0">
                                            @if($deadline)
                                                {{ $deadline->translatedFormat('j M Y') }}
                                            @else
                                                &mdash;
                                            @endif
                                        </div>

                                    </div>

                                    <!-- SECTION PENGUMPULAN MAHASISWA -->
                                    <div class="bg-black/20 rounded-lg p-2.5 text-xs text-paper/80 mt-2 space-y-1.5">
                                        <div class="flex items-center justify-between font-semibold">
                                            <span class="text-gold flex items-center gap-1">
                                                <span>👨‍🎓</span> Dikumpulkan: {{ count($submissions) }} Mahasiswa
                                            </span>
                                            @if(count($submissions) > 0)
                                                <button onclick="toggleSubmissionList({{ $id }})" class="text-[10px] text-paper/60 underline hover:text-gold">
                                                    Lihat Detail Pengumpulan &raquo;
                                                </button>
                                            @endif
                                        </div>

                                        @if(count($submissions) > 0)
                                            <div id="sub-list-{{ $id }}" class="hidden pt-1.5 space-y-1.5 border-t border-paper/10">
                                                @foreach($submissions as $sub)
                                                    @php
                                                        $subId = $sub['id_kumpul'] ?? $sub['id'] ?? null;
                                                        $tglKumpul = isset($sub['tanggal_kumpul']) ? \Carbon\Carbon::parse($sub['tanggal_kumpul'])->translatedFormat('j M Y, H:i') : '-';
                                                        
                                                        // Evaluasi Nilai dari nilai / nilai_mahasiswa
                                                        $nilaiVal = null;
                                                        if (array_key_exists('nilai', $sub) && $sub['nilai'] !== null && $sub['nilai'] !== '') {
                                                            $nilaiVal = (int) $sub['nilai'];
                                                        } elseif (array_key_exists('nilai_mahasiswa', $sub) && $sub['nilai_mahasiswa'] !== null && $sub['nilai_mahasiswa'] !== '' && (float)$sub['nilai_mahasiswa'] > 0) {
                                                            $nilaiVal = (int) $sub['nilai_mahasiswa'];
                                                        }
                                                        
                                                        $fileUrl = $sub['file_mahasiswa'] ?? null;
                                                    @endphp
                                                    <div class="flex flex-wrap items-center justify-between bg-forestd/40 px-2.5 py-1.5 rounded gap-2">
                                                        <div class="flex items-center gap-2 flex-wrap">
                                                            <span class="font-bold text-paper">{{ $sub['nama_mahasiswa'] }}</span>
                                                            <span class="text-[10px] text-paper/50">({{ $tglKumpul }})</span>

                                                            <!-- Badge Link File / Drive -->
                                                            @if(!empty($fileUrl))
                                                                <a href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer" class="px-2 py-0.5 bg-blue-500/20 text-blue-300 border border-blue-500/30 rounded font-semibold text-[10px] hover:underline flex items-center gap-1" title="Buka Google Drive">
                                                                    🔗 Link Drive
                                                                </a>
                                                            @endif

                                                            <!-- Badge Nilai -->
                                                            @if($nilaiVal !== null)
                                                                <span class="px-2.5 py-0.5 bg-gold/20 text-gold border border-gold/40 rounded-full font-bold text-[11px] flex items-center gap-1 shadow-sm">
                                                                    ⭐ Nilai: {{ $nilaiVal }} / 100
                                                                </span>
                                                            @else
                                                                <span class="px-2 py-0.5 bg-paper/10 text-paper/50 rounded text-[10px] italic">
                                                                    Belum dinilai
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="flex items-center gap-1.5">
                                                            <!-- Button Beri / Edit Nilai (Khusus Dosen & Admin) -->
                                                            @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                                                                <button onclick='openNilaiModal({{ $subId }}, "{{ addslashes($sub['nama_mahasiswa']) }}", {{ $nilaiVal ?? "null" }})' class="text-xs bg-gold/20 hover:bg-gold/30 text-gold border border-gold/30 px-2.5 py-1 rounded font-semibold transition flex items-center gap-1">
                                                                    📝 {{ $nilaiVal !== null ? 'Edit Nilai' : 'Beri Nilai' }}
                                                                </button>

                                                                <form action="{{ route('kumpul.destroy', $subId) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data pengumpulan ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-rose-400 hover:text-rose-200 text-[10px] px-1" title="Hapus pengumpulan">&times; Hapus</button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="py-10 px-4 text-center">
                                    <p class="text-paper/70 text-sm font-medium">Belum ada tugas tercatat.</p>
                                    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                                        <p class="text-paper/40 text-xs mt-1">Klik &ldquo;Tambah Tugas Baru&rdquo; untuk mulai membuat tugas.</p>
                                    @endif
                                </div>
                            @endforelse
                            
                            <!-- State ketika filter dosen tidak menemukan tugas -->
                            <div id="no-task-filtered" class="hidden py-10 px-4 text-center">
                                <p class="text-paper/70 text-sm font-medium">Tidak ada tugas untuk dosen ini.</p>
                                @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                                    <button onclick="openAddModalWithDosen()" class="mt-2 text-xs text-gold underline hover:text-paper font-semibold">
                                        + Tambah tugas untuk dosen ini
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>

                </div>

                <!-- RIGHT COLUMN: Dosen Pengampu (Interactive Filter) -->
                <div class="lg:col-span-5 space-y-4">

                    <div class="pl-1 flex items-center justify-between">
                        <div>
                            <span class="block text-[10px] text-gold uppercase tracking-[0.14em] font-semibold mb-0.5">Filter Dosen</span>
                            <h2 class="font-display font-semibold text-2xl text-paper tracking-tight">Dosen Pengampu</h2>
                        </div>
                        
                        <!-- Reset Filter Button -->
                        <button onclick="filterByDosen(null)" id="reset-filter-btn" class="hidden text-xs bg-gold/20 hover:bg-gold/30 text-gold font-semibold px-2.5 py-1 rounded-lg transition">
                            Tampilkan Semua
                        </button>
                    </div>

                    @php
                        // Kelompokkan tugas berdasarkan nama dosen
                        $groupedDosen = collect($tugasList)->groupBy('nama_dosen');
                    @endphp

                    <div class="space-y-3">
                        <!-- Card "Semua Dosen" -->
                        <div onclick="filterByDosen(null)" id="dosen-card-all" class="dosen-card cursor-pointer bg-gold text-forestd border-2 border-gold rounded-xl p-3.5 flex items-center justify-between transition shadow-md">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-forestd/20 flex items-center justify-center font-display font-bold text-sm">
                                    👥
                                </div>
                                <div>
                                    <p class="font-bold text-sm">Semua Dosen</p>
                                    <p class="text-[11px] opacity-80 font-medium">Tampilkan seluruh tugas ({{ count($tugasList) }})</p>
                                </div>
                            </div>
                            <span id="badge-all-dosen" class="text-xs font-bold bg-forestd text-paper px-2.5 py-1 rounded-full">Aktif</span>
                        </div>

                        <!-- Card Per Dosen -->
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
                                            {{ count($items) }} Tugas Ditugaskan
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
                                <p class="text-paper/50 text-xs">Belum ada dosen tercatat.</p>
                            </div>
                        @endforelse
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- MODAL BERI / EDIT NILAI TUGAS (FASTAPI 2) - KHUSUS DOSEN & ADMIN -->
    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
    <div id="nilaiModal" class="fixed inset-0 z-50 hidden bg-ink/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-paper rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-line">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display font-semibold text-lg text-forestd flex items-center gap-2">
                    <span>⭐</span> Beri Nilai Tugas (0 - 100)
                </h3>
                <button onclick="closeNilaiModal()" class="text-ink/30 hover:text-ink/70 text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form id="nilaiForm" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1">Nama Mahasiswa</label>
                    <input type="text" id="nilai_nama_mahasiswa" readonly class="w-full bg-line/30 border border-line rounded-lg px-3 py-2 text-sm text-ink/70 font-semibold focus:outline-none">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1">Nilai (Minimal 0 - Maksimal 100)</label>
                    <input type="number" id="nilai_input" name="nilai" min="0" max="100" required placeholder="Contoh: 85" class="w-full bg-white border border-line rounded-lg px-3 py-2.5 text-sm text-ink focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/15 transition">
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeNilaiModal()" class="px-4 py-2.5 bg-line/60 text-ink/70 rounded-lg text-xs font-bold hover:bg-line transition">Batal</button>
                    <button type="submit" class="px-4 py-2.5 bg-gold text-forestd rounded-lg text-xs font-bold shadow hover:bg-[#c4923a] transition">Simpan Nilai</button>
                </div>
            </form>
        </div>
    </div>
    @endif


    <!-- MODAL KUMPULKAN TUGAS (FASTAPI 2) - KHUSUS MAHASISWA & ADMIN -->
    @if(auth()->user()->isMahasiswa() || auth()->user()->isAdmin())
    <div id="kumpulModal" class="fixed inset-0 z-50 hidden bg-ink/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-paper rounded-2xl max-w-md w-full p-6 shadow-2xl border border-line">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-display font-semibold text-lg text-forestd flex items-center gap-2">
                    <span>📤</span> Kumpulkan Tugas (Google Drive)
                </h3>
                <button onclick="closeKumpulModal()" class="text-ink/30 hover:text-ink/70 text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form action="{{ route('kumpul.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" id="kumpul_id_tugas" name="id_tugas">

                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1">Judul Tugas</label>
                    <input type="text" id="kumpul_nama_tugas" readonly class="w-full bg-line/30 border border-line rounded-lg px-3 py-2 text-sm text-ink/70 font-semibold focus:outline-none">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1">Nama Mahasiswa</label>
                    <input type="text" name="nama_mahasiswa" value="{{ auth()->user()->name }}" readonly class="w-full bg-line/30 border border-line rounded-lg px-3 py-2.5 text-sm text-ink/80 font-semibold focus:outline-none">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1">Link Google Drive Tugas <span class="text-rose-500">*</span></label>
                    <input type="url" name="file_mahasiswa" required placeholder="https://drive.google.com/file/d/..." class="w-full bg-white border border-line rounded-lg px-3 py-2.5 text-sm text-ink focus:outline-none focus:border-forest focus:ring-2 focus:ring-forest/15 transition">
                    <p class="text-[10px] text-ink/50 mt-1">Pastikan link Google Drive sudah di-setting <strong>"Anyone with the link can view"</strong> (Publik).</p>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeKumpulModal()" class="px-4 py-2.5 bg-line/60 text-ink/70 rounded-lg text-xs font-bold hover:bg-line transition">Batal</button>
                    <button type="submit" class="px-4 py-2.5 bg-gold text-forestd rounded-lg text-xs font-bold shadow hover:bg-[#c4923a] transition">Kumpulkan Tugas</button>
                </div>
            </form>
        </div>
    </div>
    @endif


    <!-- MODAL TAMBAH TUGAS (KHUSUS DOSEN & ADMIN) -->
    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
    <div id="addModal" class="fixed inset-0 z-50 hidden bg-ink/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-paper rounded-2xl max-w-md w-full p-6 shadow-2xl border border-line">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-display font-semibold text-lg text-forestd">Tambah Tugas Kuliah Baru</h3>
                <button onclick="closeAddModal()" class="text-ink/30 hover:text-ink/70 text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form action="{{ route('tugas.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1.5">Nama Tugas</label>
                    <input type="text" name="nama_tugas" required placeholder="Contoh: Laporan Praktikum Bab 3" class="w-full bg-white border border-line rounded-lg px-3 py-2.5 text-sm text-ink focus:outline-none focus:border-forest focus:ring-2 focus:ring-forest/15 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1.5">Nama Dosen Pengampu</label>
                    <input type="text" id="add_nama_dosen" name="nama_dosen" value="{{ auth()->user()->name }}" required class="w-full bg-white border border-line rounded-lg px-3 py-2.5 text-sm text-ink focus:outline-none focus:border-forest focus:ring-2 focus:ring-forest/15 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1.5">Tenggat Waktu (Deadline)</label>
                    <input type="datetime-local" name="deadline_tugas" required class="w-full bg-white border border-line rounded-lg px-3 py-2.5 text-sm text-ink focus:outline-none focus:border-forest focus:ring-2 focus:ring-forest/15 transition">
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeAddModal()" class="px-4 py-2.5 bg-line/60 text-ink/70 rounded-lg text-xs font-bold hover:bg-line transition">Batal</button>
                    <button type="submit" class="px-4 py-2.5 bg-forest text-paper rounded-lg text-xs font-bold shadow hover:bg-forestd transition">Simpan Tugas</button>
                </div>
            </form>
        </div>
    </div>


    <!-- MODAL EDIT TUGAS (KHUSUS DOSEN & ADMIN) -->
    <div id="editModal" class="fixed inset-0 z-50 hidden bg-ink/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-paper rounded-2xl max-w-md w-full p-6 shadow-2xl border border-line">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-display font-semibold text-lg text-forestd">Ubah Tugas Kuliah</h3>
                <button onclick="closeEditModal()" class="text-ink/30 hover:text-ink/70 text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1.5">Nama Tugas</label>
                    <input type="text" id="edit_nama_tugas" name="nama_tugas" required class="w-full bg-white border border-line rounded-lg px-3 py-2.5 text-sm text-ink focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/15 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1.5">Nama Dosen Pengampu</label>
                    <input type="text" id="edit_nama_dosen" name="nama_dosen" required class="w-full bg-white border border-line rounded-lg px-3 py-2.5 text-sm text-ink focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/15 transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-ink/60 uppercase tracking-wide mb-1.5">Tenggat Waktu (Deadline)</label>
                    <input type="datetime-local" id="edit_deadline_tugas" name="deadline_tugas" required class="w-full bg-white border border-line rounded-lg px-3 py-2.5 text-sm text-ink focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/15 transition">
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2.5 bg-line/60 text-ink/70 rounded-lg text-xs font-bold hover:bg-line transition">Batal</button>
                    <button type="submit" class="px-4 py-2.5 bg-gold text-forestd rounded-lg text-xs font-bold shadow hover:bg-[#c4923a] transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endif


    <script>
        let currentSelectedDosen = null;

        function toggleSubmissionList(id) {
            const el = document.getElementById(`sub-list-${id}`);
            if (el) el.classList.toggle('hidden');
        }

        function openNilaiModal(subId, namaMhs, currentNilai) {
            const form = document.getElementById('nilaiForm');
            if (form) {
                form.action = `/kumpul-tugas/${subId}/nilai`;
                document.getElementById('nilai_nama_mahasiswa').value = namaMhs;
                document.getElementById('nilai_input').value = (currentNilai !== null && currentNilai !== undefined && currentNilai !== 'null' && currentNilai !== '') ? currentNilai : '';
                document.getElementById('nilaiModal').classList.remove('hidden');
            }
        }

        function closeNilaiModal() {
            const modal = document.getElementById('nilaiModal');
            if (modal) modal.classList.add('hidden');
        }

        function openKumpulModal(idTugas, namaTugas) {
            const modal = document.getElementById('kumpulModal');
            if (modal) {
                document.getElementById('kumpul_id_tugas').value = idTugas;
                document.getElementById('kumpul_nama_tugas').value = namaTugas;
                modal.classList.remove('hidden');
            }
        }

        function closeKumpulModal() {
            const modal = document.getElementById('kumpulModal');
            if (modal) modal.classList.add('hidden');
        }

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
                allCard.className = "dosen-card cursor-pointer bg-gold text-forestd border-2 border-gold rounded-xl p-3.5 flex items-center justify-between transition shadow-md";
                document.getElementById('badge-all-dosen').className = "text-xs font-bold bg-forestd text-paper px-2.5 py-1 rounded-full";

                dosenCards.forEach(c => {
                    if (c.id !== 'dosen-card-all') {
                        c.className = "dosen-card cursor-pointer bg-forestd/40 border border-paper/15 rounded-xl p-3.5 flex items-center justify-between hover:border-gold/60 hover:bg-forestd/70 transition";
                    }
                });

                resetBtn.classList.add('hidden');
                badgeEl.classList.add('hidden');
                titleEl.innerHTML = `<span>Tugas Kuliah</span>`;
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
                titleEl.innerHTML = `<span>Tugas dari: <strong class="text-paper">${dosenName}</strong> (${visibleCount})</span>`;

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
                document.getElementById('add_nama_dosen').value = currentSelectedDosen;
            }
        }

        function setTab(name) {
            document.querySelectorAll('[id^="tab-Jurusan-"]').forEach(el => {
                el.className = "folder-tab px-5 py-2.5 bg-line/60 text-ink/55 hover:bg-line hover:text-ink/80 transition";
                el.setAttribute('aria-selected', 'false');
            });
            const active = document.getElementById(`tab-${name.replace(' ', '-')}`);
            if (active) {
                active.className = "folder-tab px-5 py-2.5 bg-forest text-paper font-semibold transition shadow-sm";
                active.setAttribute('aria-selected', 'true');
            }
            document.getElementById('active-tab-label').innerText = name;
        }

        function openAddModal() {
            const modal = document.getElementById('addModal');
            if (modal) {
                if (currentSelectedDosen) {
                    document.getElementById('add_nama_dosen').value = currentSelectedDosen;
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

                modal.classList.remove('hidden');
            }
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            if (modal) modal.classList.add('hidden');
        }

        // Tutup modal dengan tombol Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAddModal();
                closeEditModal();
                closeKumpulModal();
                closeNilaiModal();
            }
        });
    </script>
</body>
</html>