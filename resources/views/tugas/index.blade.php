<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Tugas - Universitas Mulawarman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        unmul: {
                            green: '#006837',
                            dark: '#004d28',
                            lightgreen: '#e6f2ed',
                            yellow: '#FFC20E',
                            gold: '#D4A017',
                        },
                        neutral: {
                            bg: '#F8F9FA',
                            card: '#FFFFFF',
                            border: '#E5E7EB',
                            text: '#1F2937',
                            muted: '#6B7280',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    borderRadius: {
                        DEFAULT: '6px',
                        'lg': '8px',
                        'xl': '12px',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F9FA; color: #1F2937; }
        *, *::before, *::after { scrollbar-width: none; -ms-overflow-style: none; }
        *::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="min-h-screen bg-neutral-bg text-neutral-text antialiased">

    <!-- Header Navigation Bar -->
    <header class="bg-white border-b border-neutral-border sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">
                
                <!-- Identitas Kampus & Fakultas -->
                <div class="flex items-center gap-3">
    <img src="{{ asset('logo.png') }}" alt="Logo Fakultas Teknik UNMUL" class="w-10 h-10 object-contain shrink-0">
    
    <div>
        <h1 class="font-bold text-base text-unmul-dark leading-tight">Fakultas Teknik</h1>
        <p class="text-[11px] font-medium text-neutral-muted uppercase tracking-wider">Universitas Mulawarman</p>
    </div>
</div>

                <!-- Status API Services & Logged-in User Profile -->
                <div class="flex items-center gap-3">
                    @auth
                    <div class="flex items-center gap-2.5 pl-3 border-l border-neutral-border">
                        <div class="w-8 h-8 rounded-full bg-unmul-lightgreen text-unmul-dark font-extrabold text-xs flex items-center justify-center border border-unmul-green/30 shrink-0">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="hidden sm:block text-left leading-tight">
                            <span class="block text-xs font-bold text-neutral-text">{{ auth()->user()->name }}</span>
                            <span class="inline-block px-1.5 py-0.2 text-[9px] font-bold uppercase tracking-wider rounded bg-unmul-green/10 text-unmul-green">
                                {{ auth()->user()->role ?? 'User' }}
                            </span>
                        </div>
                    </div>

                    <!-- Tombol Kembali ke Welcome -->
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-3 py-1.5 border border-neutral-border rounded-lg text-xs font-semibold text-neutral-text bg-neutral-bg hover:bg-neutral-border transition duration-150 shadow-sm" title="Kembali ke Halaman Welcome">
                        <svg class="w-3.5 h-3.5 mr-1 text-neutral-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali
                    </a>

                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 border border-red-200 rounded-lg text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 transition duration-150 cursor-pointer" title="Keluar dari Akun">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Keluar
                        </button>
                    </form>
                    @endauth
                </div>

            </div>
        </div>

        <!-- Sub-header Navigation Tabs Jurusan -->
        <div class="bg-unmul-dark text-white border-t border-unmul-green/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex space-x-1 overflow-x-auto py-2 text-xs font-medium" aria-label="Jurusan">
                    <button onclick="setTab('Jurusan 1')" id="tab-Jurusan-1" class="px-4 py-2 rounded-md bg-unmul-green text-white font-semibold transition shadow-sm">
                        Jurusan 1
                    </button>
                    <button onclick="setTab('Jurusan 2')" id="tab-Jurusan-2" class="px-4 py-2 rounded-md text-white/70 hover:bg-white/10 hover:text-white transition">
                        Jurusan 2
                    </button>
                    <button onclick="setTab('Jurusan 3')" id="tab-Jurusan-3" class="px-4 py-2 rounded-md text-white/70 hover:bg-white/10 hover:text-white transition">
                        Jurusan 3
                    </button>
                    <button onclick="setTab('Jurusan 4')" id="tab-Jurusan-4" class="px-4 py-2 rounded-md text-white/70 hover:bg-white/10 hover:text-white transition">
                        Jurusan 4
                    </button>
                    <button onclick="setTab('Jurusan 5')" id="tab-Jurusan-5" class="px-4 py-2 rounded-md text-white/70 hover:bg-white/10 hover:text-white transition">
                        Jurusan 5
                    </button>
                </nav>
            </div>
        </div>
    </header>

    <!-- Notification Messages -->
    @if(session('success') || session('error') || $errorMessage)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
        @if(session('success'))
            <div class="p-3.5 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg text-xs font-semibold flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if(session('error') || $errorMessage)
            <div class="p-3.5 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-lg text-xs font-semibold flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 8v5M12 16h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
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
                <span id="active-tab-label" class="inline-block text-[11px] font-bold text-unmul-green uppercase tracking-wider bg-unmul-lightgreen px-2.5 py-1 rounded mb-1 border border-unmul-green/20">
                    Jurusan 1
                </span>
                <h2 class="text-xl font-extrabold text-neutral-text">Daftar Tugas Kuliah</h2>
                <p class="text-xs text-neutral-muted">Kelola dan kumpulkan seluruh penugasan semester ini secara tepat waktu.</p>
            </div>

            <!-- Tombol Tambah Tugas Baru - KHUSUS DOSEN & ADMIN -->
            @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                <button onclick="openAddModal()" class="inline-flex items-center justify-center px-4 py-2.5 bg-unmul-green hover:bg-unmul-dark text-white text-xs font-bold rounded-lg shadow-sm transition duration-150 gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Tugas Baru
                </button>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- LEFT COLUMN: Ledger / Daftar Tugas -->
            <div class="lg:col-span-8 space-y-4">
                <div class="bg-white border border-neutral-border rounded-xl shadow-sm overflow-hidden">
                    
                    <div class="bg-neutral-bg border-b border-neutral-border px-5 py-3.5 flex items-center justify-between">
                        <div id="task-table-title" class="text-xs font-bold text-neutral-text flex items-center gap-2">
                            <span>Semua Tugas</span>
                            <span id="filter-badge" class="hidden bg-unmul-lightgreen text-unmul-green px-2 py-0.5 rounded text-[10px] font-mono">Filter Aktif</span>
                        </div>
                        <span class="text-[11px] font-semibold text-neutral-muted uppercase tracking-wider">Tenggat Waktu</span>
                    </div>

                    <div id="task-list-container" class="divide-y divide-neutral-border">
                        @forelse($tugasList as $index => $tugas)
                            @php
                                $id = $tugas['id_tugas'] ?? $tugas['id'] ?? null;
                                $deadline = isset($tugas['deadline_tugas']) ? \Carbon\Carbon::parse($tugas['deadline_tugas']) : null;
                                $isPast = $deadline ? $deadline->isPast() : false;
                                
                                // Data pengumpulan dari FastAPI 2
                                $submissions = collect($kumpulList)->where('id_tugas', $id);
                                
                                // Cek apakah mahasiswa ini sudah mengumpulkan tugas ini
                                $mySubmission = $submissions->firstWhere('nama_mahasiswa', auth()->user()->name);

                                if ($isPast) {
                                    $statusBadge = 'bg-red-50 text-red-700 border-red-200';
                                    $statusText = 'Lewat Tenggat';
                                } elseif ($index % 3 == 0) {
                                    $statusBadge = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                    $statusText = 'Selesai';
                                } else {
                                    $statusBadge = 'bg-amber-50 text-amber-700 border-amber-200';
                                    $statusText = 'Sedang Berjalan';
                                }
                            @endphp

                            <div class="task-row p-5 hover:bg-neutral-bg/60 transition duration-150 space-y-3" data-dosen="{{ strtolower($tugas['nama_dosen'] ?? '') }}">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="inline-block px-2 py-0.5 text-[10px] font-semibold border rounded {{ $statusBadge }}">
                                                {{ $statusText }}
                                            </span>
                                            <span class="text-xs text-neutral-muted font-medium">• Dosen: {{ $tugas['nama_dosen'] }}</span>
                                        </div>
                                        <h3 class="font-bold text-base text-neutral-text truncate" title="{{ $tugas['nama_tugas'] }}">
                                            {{ $tugas['nama_tugas'] }}
                                        </h3>
                                    </div>

                                    <div class="flex items-center sm:flex-col sm:items-end justify-between gap-2 shrink-0">
                                        <span class="text-xs font-semibold text-neutral-text bg-neutral-bg px-2.5 py-1 rounded border border-neutral-border">
                                            {{ $deadline ? $deadline->translatedFormat('j M Y, H:i') : 'Tanpa Tenggat' }}
                                        </span>

                                        <div class="flex items-center gap-1.5">
                                            <!-- FITUR MAHASISWA / ADMIN: Kumpulkan Tugas & Status Pengumpulan -->
                                            @if(auth()->user()->isMahasiswa() || auth()->user()->isAdmin())
                                                @if($mySubmission)
                                                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 border border-emerald-300 text-xs font-bold rounded inline-flex items-center gap-1">
                                                        ✅ Sudah Dikumpulkan
                                                    </span>
                                                    <button onclick='openKumpulModal({{ $id }}, "{{ addslashes($tugas['nama_tugas']) }}")' class="px-2 py-1 bg-neutral-bg hover:bg-neutral-border text-neutral-text text-[11px] font-semibold rounded border transition" title="Kirim Ulang / Perbarui Link">
                                                        🔄 Kirim Ulang
                                                    </button>
                                                @else
                                                    <button onclick='openKumpulModal({{ $id }}, "{{ addslashes($tugas['nama_tugas']) }}")' class="px-3 py-1 bg-unmul-lightgreen hover:bg-unmul-green hover:text-white text-unmul-dark text-xs font-bold rounded transition duration-150 flex items-center gap-1 border border-unmul-green/30">
                                                        <span>📤</span> Kumpulkan
                                                    </button>
                                                @endif
                                            @endif

                                            <!-- FITUR DOSEN / ADMIN: Edit & Hapus Tugas -->
                                            @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                                                <button onclick='openEditModal({{ json_encode($tugas) }})' class="p-1 text-neutral-muted hover:text-unmul-green transition" title="Ubah Tugas">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <form action="{{ route('tugas.destroy', $id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tugas ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1 text-neutral-muted hover:text-red-600 transition" title="Hapus Tugas">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- SECTION PENGUMPULAN MAHASISWA (FASTAPI 2 DATA + NILAI) -->
                                <div class="bg-neutral-bg border border-neutral-border rounded-lg p-3 text-xs space-y-2">
                                    <div class="flex items-center justify-between font-medium">
                                        <span class="text-neutral-text font-bold flex items-center gap-1.5">
                                            <span>👨‍🎓</span> Total Pengumpulan: {{ count($submissions) }} Mahasiswa
                                        </span>
                                        @if(count($submissions) > 0)
                                            <button onclick="toggleSubmissionList({{ $id }})" class="text-unmul-green hover:underline text-[11px] font-semibold">
                                                Tampilkan Detail &raquo;
                                            </button>
                                        @endif
                                    </div>

                                    @if(count($submissions) > 0)
                                        <div id="sub-list-{{ $id }}" class="hidden pt-2 border-t border-neutral-border space-y-2">
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
                                                <div class="flex items-center justify-between bg-white p-2.5 rounded border border-neutral-border flex-wrap gap-2">
                                                    <div class="flex items-center gap-2 flex-wrap">
                                                        <span class="font-bold text-neutral-text">{{ $sub['nama_mahasiswa'] }}</span>
                                                        <span class="text-[10px] text-neutral-muted">({{ $tglKumpul }})</span>

                                                        <!-- Link Google Drive jika tersedia -->
                                                        @if(!empty($fileUrl))
                                                            <a href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer" class="px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-200 rounded font-semibold text-[10px] hover:underline flex items-center gap-1" title="Buka Link Google Drive">
                                                                🔗 Link Drive
                                                            </a>
                                                        @endif

                                                        <!-- Badge Status Nilai -->
                                                        @if($nilaiVal !== null)
                                                            <span class="px-2 py-0.5 bg-amber-50 text-amber-800 border border-amber-200 rounded font-extrabold text-[11px]">
                                                                ⭐ Nilai: {{ $nilaiVal }} / 100
                                                            </span>
                                                        @else
                                                            <span class="px-1.5 py-0.5 bg-neutral-bg text-neutral-muted rounded text-[10px] italic border">
                                                                Belum Dinilai
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <!-- KHUSUS DOSEN & ADMIN: Beri Nilai & Hapus Pengumpulan -->
                                                    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                                                        <div class="flex items-center gap-1.5">
                                                            <button onclick='openNilaiModal({{ $subId }}, "{{ addslashes($sub['nama_mahasiswa']) }}", {{ $nilaiVal ?? "null" }})' class="px-2 py-1 bg-amber-100 hover:bg-amber-200 text-amber-900 rounded font-bold text-[11px] transition">
                                                                {{ $nilaiVal !== null ? 'Ubah Nilai' : 'Beri Nilai' }}
                                                            </button>
                                                            <form action="{{ route('kumpul.destroy', $subId) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengumpulan ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-500 hover:text-red-700 px-1 text-xs font-semibold" title="Hapus Pengumpulan">&times;</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                            </div>
                        @empty
                            <div class="py-12 text-center">
                                <p class="text-neutral-muted text-sm font-medium">Belum ada tugas tercatat untuk jurusan ini.</p>
                                @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                                    <button onclick="openAddModal()" class="mt-2 text-xs font-bold text-unmul-green hover:underline">+ Buat Tugas Pertama</button>
                                @endif
                            </div>
                        @endforelse

                        <div id="no-task-filtered" class="hidden py-10 text-center">
                            <p class="text-neutral-muted text-sm font-medium">Tidak ada tugas terdaftar untuk dosen ini.</p>
                            @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
                                <button onclick="openAddModalWithDosen()" class="mt-2 text-xs font-bold text-unmul-green hover:underline">
                                    + Buat Tugas Untuk Dosen Ini
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <!-- RIGHT COLUMN: Dosen Pengampu Filter -->
            <div class="lg:col-span-4 space-y-4">
                <div class="bg-white border border-neutral-border rounded-xl p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-4 pb-2 border-b border-neutral-border">
                        <div>
                            <h3 class="font-bold text-sm text-neutral-text">Dosen Pengampu</h3>
                            <p class="text-[11px] text-neutral-muted">Filter tugas berdasarkan dosen</p>
                        </div>
                        <button onclick="filterByDosen(null)" id="reset-filter-btn" class="hidden text-[11px] bg-neutral-bg hover:bg-neutral-border text-neutral-text font-semibold px-2 py-1 rounded transition">
                            Reset Filter
                        </button>
                    </div>

                    @php
                        $groupedDosen = collect($tugasList)->groupBy('nama_dosen');
                    @endphp

                    <div class="space-y-2">
                        <div onclick="filterByDosen(null)" id="dosen-card-all" class="dosen-card cursor-pointer bg-unmul-lightgreen border border-unmul-green/40 rounded-lg p-3 flex items-center justify-between transition hover:border-unmul-green">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-md bg-unmul-green text-white font-bold flex items-center justify-center text-xs">
                                    ALL
                                </div>
                                <div>
                                    <p class="font-bold text-xs text-unmul-dark">Semua Dosen</p>
                                    <p class="text-[10px] text-neutral-muted">Tampilkan seluruh tugas ({{ count($tugasList) }})</p>
                                </div>
                            </div>
                            <span id="badge-all-dosen" class="text-[10px] font-bold bg-unmul-green text-white px-2 py-0.5 rounded">Aktif</span>
                        </div>

                        @forelse($groupedDosen as $dosenName => $items)
                            <div onclick="filterByDosen('{{ addslashes($dosenName) }}')" 
                                 data-dosen-name="{{ strtolower($dosenName) }}"
                                 class="dosen-card cursor-pointer bg-neutral-bg border border-neutral-border rounded-lg p-3 flex items-center justify-between hover:border-unmul-green hover:bg-white transition">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-8 h-8 rounded-md bg-neutral-border text-neutral-text font-bold flex items-center justify-center text-xs shrink-0">
                                        {{ strtoupper(substr($dosenName ?? '?', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-xs text-neutral-text truncate">{{ $dosenName }}</p>
                                        <p class="text-[10px] text-neutral-muted truncate">{{ count($items) }} Tugas Ditugaskan</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <span class="text-xs text-unmul-dark font-mono font-bold bg-unmul-lightgreen px-2 py-0.5 rounded border border-unmul-green/20">
                                        {{ count($items) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="bg-neutral-bg border border-dashed border-neutral-border rounded-lg p-4 text-center">
                                <p class="text-neutral-muted text-xs">Belum ada dosen tercatat.</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>

    </main>


    <!-- MODAL BERI / EDIT NILAI TUGAS (FASTAPI 2) - KHUSUS DOSEN & ADMIN -->
    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
    <div id="nilaiModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-sm w-full p-6 shadow-2xl border border-neutral-border">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-base text-neutral-text flex items-center gap-2">
                    <span>⭐</span> Beri Nilai Tugas (0 - 100)
                </h3>
                <button onclick="closeNilaiModal()" class="text-neutral-muted hover:text-neutral-text text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form id="nilaiForm" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-[11px] font-semibold text-neutral-muted uppercase mb-1">Nama Mahasiswa</label>
                    <input type="text" id="nilai_nama_mahasiswa" readonly class="w-full bg-neutral-bg border border-neutral-border rounded-lg px-3 py-2 text-xs font-semibold text-neutral-text focus:outline-none">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-neutral-muted uppercase mb-1">Nilai (0 - 100)</label>
                    <input type="number" id="nilai_input" name="nilai" min="0" max="100" required placeholder="Contoh: 85" class="w-full bg-white border border-neutral-border rounded-lg px-3 py-2 text-xs text-neutral-text focus:outline-none focus:border-unmul-green transition">
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeNilaiModal()" class="px-3 py-2 bg-neutral-bg text-neutral-text rounded-lg text-xs font-semibold hover:bg-neutral-border transition">Batal</button>
                    <button type="submit" class="px-3 py-2 bg-unmul-green text-white rounded-lg text-xs font-bold hover:bg-unmul-dark transition shadow-sm">Simpan Nilai</button>
                </div>
            </form>
        </div>
    </div>
    @endif


    <!-- MODAL KUMPULKAN TUGAS (FASTAPI 2) - KHUSUS MAHASISWA & ADMIN -->
    @if(auth()->user()->isMahasiswa() || auth()->user()->isAdmin())
    <div id="kumpulModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-2xl border border-neutral-border">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-base text-neutral-text flex items-center gap-2">
                    <span>📤</span> Kumpulkan Tugas (Google Drive)
                </h3>
                <button onclick="closeKumpulModal()" class="text-neutral-muted hover:text-neutral-text text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form action="{{ route('kumpul.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" id="kumpul_id_tugas" name="id_tugas">

                <div>
                    <label class="block text-[11px] font-semibold text-neutral-muted uppercase mb-1">Judul Tugas</label>
                    <input type="text" id="kumpul_nama_tugas" readonly class="w-full bg-neutral-bg border border-neutral-border rounded-lg px-3 py-2 text-xs font-semibold text-neutral-text focus:outline-none">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-neutral-muted uppercase mb-1">Nama Mahasiswa</label>
                    <input type="text" name="nama_mahasiswa" value="{{ auth()->user()->name }}" readonly class="w-full bg-neutral-bg border border-neutral-border rounded-lg px-3 py-2 text-xs font-semibold text-neutral-text focus:outline-none">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-neutral-muted uppercase mb-1">Link Google Drive Tugas <span class="text-red-500">*</span></label>
                    <input type="url" name="file_mahasiswa" required placeholder="https://drive.google.com/file/d/..." class="w-full bg-white border border-neutral-border rounded-lg px-3 py-2 text-xs text-neutral-text focus:outline-none focus:border-unmul-green transition">
                    <p class="text-[10px] text-neutral-muted mt-1">Pastikan link Google Drive sudah di-setting <strong>"Anyone with the link can view"</strong> (Publik).</p>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeKumpulModal()" class="px-3 py-2 bg-neutral-bg text-neutral-text rounded-lg text-xs font-semibold hover:bg-neutral-border transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-unmul-green text-white rounded-lg text-xs font-bold hover:bg-unmul-dark transition shadow-sm">Kumpulkan Tugas</button>
                </div>
            </form>
        </div>
    </div>
    @endif


    <!-- MODAL TAMBAH TUGAS (KHUSUS DOSEN & ADMIN) -->
    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
    <div id="addModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-2xl border border-neutral-border">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-base text-neutral-text">Tambah Tugas Kuliah Baru</h3>
                <button onclick="closeAddModal()" class="text-neutral-muted hover:text-neutral-text text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form action="{{ route('tugas.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-semibold text-neutral-muted uppercase mb-1">Nama Tugas</label>
                    <input type="text" name="nama_tugas" required placeholder="Contoh: Laporan Praktikum Bab 3" class="w-full bg-white border border-neutral-border rounded-lg px-3 py-2 text-xs text-neutral-text focus:outline-none focus:border-unmul-green transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-neutral-muted uppercase mb-1">Dosen Pengampu</label>
                    <input type="text" id="add_nama_dosen" name="nama_dosen" value="{{ auth()->user()->name }}" required class="w-full bg-white border border-neutral-border rounded-lg px-3 py-2 text-xs text-neutral-text focus:outline-none focus:border-unmul-green transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-neutral-muted uppercase mb-1">Batas Waktu (Deadline)</label>
                    <input type="datetime-local" name="deadline_tugas" required class="w-full bg-white border border-neutral-border rounded-lg px-3 py-2 text-xs text-neutral-text focus:outline-none focus:border-unmul-green transition">
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeAddModal()" class="px-3 py-2 bg-neutral-bg text-neutral-text rounded-lg text-xs font-semibold hover:bg-neutral-border transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-unmul-green text-white rounded-lg text-xs font-bold hover:bg-unmul-dark transition shadow-sm">Simpan Tugas</button>
                </div>
            </form>
        </div>
    </div>
    @endif


    <!-- MODAL EDIT TUGAS (KHUSUS DOSEN & ADMIN) -->
    @if(auth()->user()->isDosen() || auth()->user()->isAdmin())
    <div id="editModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-2xl border border-neutral-border">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-base text-neutral-text">Ubah Tugas Kuliah</h3>
                <button onclick="closeEditModal()" class="text-neutral-muted hover:text-neutral-text text-xl leading-none transition" aria-label="Tutup">&times;</button>
            </div>

            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[11px] font-semibold text-neutral-muted uppercase mb-1">Nama Tugas</label>
                    <input type="text" id="edit_nama_tugas" name="nama_tugas" required class="w-full bg-white border border-neutral-border rounded-lg px-3 py-2 text-xs text-neutral-text focus:outline-none focus:border-unmul-green transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-neutral-muted uppercase mb-1">Dosen Pengampu</label>
                    <input type="text" id="edit_nama_dosen" name="nama_dosen" required class="w-full bg-white border border-neutral-border rounded-lg px-3 py-2 text-xs text-neutral-text focus:outline-none focus:border-unmul-green transition">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-neutral-muted uppercase mb-1">Batas Waktu (Tenggat)</label>
                    <input type="datetime-local" id="edit_deadline_tugas" name="deadline_tugas" required class="w-full bg-white border border-neutral-border rounded-lg px-3 py-2 text-xs text-neutral-text focus:outline-none focus:border-unmul-green transition">
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeEditModal()" class="px-3 py-2 bg-neutral-bg text-neutral-text rounded-lg text-xs font-semibold hover:bg-neutral-border transition">Batal</button>
                    <button type="submit" class="px-3 py-2 bg-unmul-green text-white rounded-lg text-xs font-bold hover:bg-unmul-dark transition shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endif


    <!-- Javascript Interaktivitas -->
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
                document.getElementById('nilai_input').value = currentNilai !== null ? currentNilai : '';
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
                
                allCard.className = "dosen-card cursor-pointer bg-unmul-lightgreen border border-unmul-green/40 rounded-lg p-3 flex items-center justify-between transition hover:border-unmul-green";
                const allBadge = document.getElementById('badge-all-dosen');
                if (allBadge) allBadge.className = "text-[10px] font-bold bg-unmul-green text-white px-2 py-0.5 rounded";

                dosenCards.forEach(c => {
                    if (c.id !== 'dosen-card-all') {
                        c.className = "dosen-card cursor-pointer bg-neutral-bg border border-neutral-border rounded-lg p-3 flex items-center justify-between hover:border-unmul-green hover:bg-white transition";
                    }
                });

                if (resetBtn) resetBtn.classList.add('hidden');
                if (badgeEl) badgeEl.classList.add('hidden');
                if (titleEl) titleEl.innerHTML = `<span>Semua Tugas</span>`;
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

                allCard.className = "dosen-card cursor-pointer bg-neutral-bg border border-neutral-border rounded-lg p-3 flex items-center justify-between hover:border-unmul-green hover:bg-white transition";
                const allBadge = document.getElementById('badge-all-dosen');
                if (allBadge) allBadge.className = "hidden";

                dosenCards.forEach(c => {
                    if (c.id !== 'dosen-card-all') {
                        const targetDosen = c.getAttribute('data-dosen-name');
                        if (targetDosen === searchDosen) {
                            c.className = "dosen-card cursor-pointer bg-unmul-lightgreen border-2 border-unmul-green rounded-lg p-3 flex items-center justify-between transition shadow-sm font-semibold";
                        } else {
                            c.className = "dosen-card cursor-pointer bg-neutral-bg border border-neutral-border rounded-lg p-3 flex items-center justify-between hover:border-unmul-green hover:bg-white transition opacity-60";
                        }
                    }
                });

                if (resetBtn) resetBtn.classList.remove('hidden');
                if (badgeEl) badgeEl.classList.remove('hidden');
                if (titleEl) titleEl.innerHTML = `<span>Tugas Dosen: <strong class="text-unmul-green">${dosenName}</strong> (${visibleCount})</span>`;

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
                el.className = "px-4 py-2 rounded-md text-white/70 hover:bg-white/10 hover:text-white transition";
            });
            const active = document.getElementById(`tab-${name.replace(' ', '-')}`);
            if (active) {
                active.className = "px-4 py-2 rounded-md bg-unmul-green text-white font-semibold transition shadow-sm";
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

                modal.classList.remove('hidden');
            }
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            if (modal) modal.classList.add('hidden');
        }

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