<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Massal — Fakultas Teknik UNMUL</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        (function () {
            try {
                var mode = localStorage.getItem('pkl_theme') || 'dark';
                var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                var isDark = mode === 'dark' || (mode === 'system' && prefersDark);
                if (isDark) { document.documentElement.classList.add('dark'); document.documentElement.classList.remove('light'); }
                else { document.documentElement.classList.remove('dark'); document.documentElement.classList.add('light'); }
            } catch (e) {}
        })();
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { primary: { DEFAULT: '#FF7A00', hover: '#E06B00', light: '#FFF0E6', gradient: '#FF9225' } }, fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] } } }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; transition: background-color .3s ease, color .3s ease; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }
        ::selection { background: #FF7A00; color: #fff; }
        :focus-visible { outline: 2px solid #FF7A00; outline-offset: 2px; }
        .page-transition-wrapper { animation: pageFadeIn .35s cubic-bezier(0.16,1,0.3,1) forwards; }
        @keyframes pageFadeIn { from { opacity:0; transform:translateY(12px);} to { opacity:1; transform:translateY(0);} }
        .dropzone.dragover { border-color: #FF7A00; background: rgba(255,122,0,0.06); }
    </style>
</head>
<body class="min-h-screen bg-[#e5e9f0] dark:bg-[#0f172a] text-slate-800 dark:text-slate-100 antialiased flex flex-col">
    @include('partials.navbar')

    <div class="page-transition-wrapper flex-1 relative z-10">
        @if(session('success') || session('error') || $errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 space-y-2">
            @if(session('success'))
                <div class="flash-msg p-3.5 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-300 dark:border-emerald-500/40 text-emerald-800 dark:text-emerald-200 rounded-xl text-sm font-semibold flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2.5"><svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span>{{ session('success') }}</span></div>
                    <button type="button" onclick="this.closest('.flash-msg').remove()" class="opacity-70 hover:opacity-100">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="flash-msg p-3.5 bg-rose-50 dark:bg-rose-950/60 border border-rose-300 dark:border-rose-500/40 text-rose-800 dark:text-rose-200 rounded-xl text-sm font-semibold flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2.5"><svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/><path d="M12 8v5M12 16h.01" stroke-width="2" stroke-linecap="round"/></svg><span>{{ session('error') }}</span></div>
                    <button type="button" onclick="this.closest('.flash-msg').remove()" class="opacity-70 hover:opacity-100">&times;</button>
                </div>
            @endif
            @if($errors->any())
                <div class="flash-msg p-3.5 bg-rose-50 dark:bg-rose-950/60 border border-rose-300 dark:border-rose-500/40 text-rose-800 dark:text-rose-200 rounded-xl text-sm shadow-sm">
                    <p class="font-bold mb-1">Periksa kembali:</p>
                    <ul class="list-disc list-inside text-xs sm:text-sm space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
        </div>
        @endif

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">
            <!-- Header -->
            <div>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-500/30">Admin</span>
                <h1 class="mt-2 text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Kelola Massal</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Impor dan kelola data mahasiswa/NIM & pengguna secara massal dengan pratinjau sebelum disimpan.</p>
            </div>

            <!-- Import / Upload Card -->
            <section class="bg-[#f8f9fc] dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-800 rounded-2xl shadow-md dark:shadow-xl dark:shadow-black/20 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-800/40 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white">Impor Data Pengguna</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Unggah file, pratinjau hasil validasi, lalu konfirmasi untuk menyimpan baris yang valid.</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 mr-1">Format:</span>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200">.json</span>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200">.csv</span>
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200">.xlsx</span>
                    </div>
                </div>
                <div class="p-5 sm:p-6 space-y-5">
                    <form action="{{ route('admin.pengguna.massal.preview') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div id="dropzone" class="dropzone relative border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-2xl bg-white/60 dark:bg-slate-950/30 p-6 sm:p-8 text-center transition">
                            <input id="file-input" type="file" name="file" accept=".json,.csv,.txt,.xlsx,.xls" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                            <div class="pointer-events-none">
                                <div class="w-12 h-12 mx-auto rounded-xl bg-amber-100 dark:bg-amber-500/15 text-amber-600 dark:text-amber-400 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">Seret & lepas file di sini, atau klik untuk memilih</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Mendukung .json, .csv, .xlsx (maks. 5MB)</p>
                                <p id="file-name" class="mt-3 text-xs font-bold text-amber-600 dark:text-amber-400 hidden"></p>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-semibold text-slate-600 dark:text-slate-300">Unduh template:</span>
                                <a href="{{ route('admin.pengguna.massal.template','json') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold text-slate-700 dark:text-slate-200 hover:border-amber-400 hover:text-amber-700 dark:hover:text-amber-400 transition">JSON</a>
                                <a href="{{ route('admin.pengguna.massal.template','csv') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold text-slate-700 dark:text-slate-200 hover:border-amber-400 hover:text-amber-700 dark:hover:text-amber-400 transition">CSV</a>
                                <a href="{{ route('admin.pengguna.massal.template','xlsx') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs font-bold text-slate-700 dark:text-slate-200 hover:border-amber-400 hover:text-amber-700 dark:hover:text-amber-400 transition">XLSX</a>
                            </div>
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white text-xs font-bold rounded-xl shadow-lg shadow-orange-500/20 transition gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Pratinjau Data
                            </button>
                        </div>
                    </form>

                    @if(!empty($preview))
                    @php
                        $validCount = collect($preview)->where('valid', true)->count();
                        $invalidCount = count($preview) - $validCount;
                    @endphp
                    <div class="border-t border-slate-200 dark:border-slate-800 pt-5">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
                            <div>
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Hasil Pratinjau</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Periksa baris sebelum disimpan. Hanya baris valid yang akan diimpor.</p>
                            </div>
                            <div class="flex items-center gap-2 text-xs font-bold">
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30">Valid: {{ $validCount }}</span>
                                <span class="px-2.5 py-1 rounded-lg bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-300 border border-rose-200 dark:border-rose-500/30">Tidak valid: {{ $invalidCount }}</span>
                            </div>
                        </div>
                        <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
                            <table class="min-w-full text-xs">
                                <thead class="bg-slate-100/80 dark:bg-slate-800/70 text-slate-600 dark:text-slate-300">
                                    <tr>
                                        <th class="px-3 py-2.5 text-left font-bold">Baris</th>
                                        <th class="px-3 py-2.5 text-left font-bold">Status</th>
                                        <th class="px-3 py-2.5 text-left font-bold">Aksi</th>
                                        <th class="px-3 py-2.5 text-left font-bold">Nama</th>
                                        <th class="px-3 py-2.5 text-left font-bold">Username</th>
                                        <th class="px-3 py-2.5 text-left font-bold">NIM/NIP</th>
                                        <th class="px-3 py-2.5 text-left font-bold">Email</th>
                                        <th class="px-3 py-2.5 text-left font-bold">Role</th>
                                        <th class="px-3 py-2.5 text-left font-bold">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 bg-white/60 dark:bg-slate-950/20">
                                    @foreach($preview as $item)
                                    <tr class="{{ $item['valid'] ? 'hover:bg-emerald-50/40 dark:hover:bg-emerald-500/5' : 'bg-rose-50/50 dark:bg-rose-500/5' }}">
                                        <td class="px-3 py-2.5 font-mono text-slate-500 dark:text-slate-400">{{ $item['row'] }}</td>
                                        <td class="px-3 py-2.5">
                                            @if($item['valid'])
                                                <span class="inline-flex px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30">Valid</span>
                                            @else
                                                <span class="inline-flex px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-300 border border-rose-200 dark:border-rose-500/30">Tidak valid</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2.5">
                                            @if(($item['action'] ?? '') === 'create')
                                                <span class="text-[10px] font-bold text-blue-700 dark:text-blue-300">Buat baru</span>
                                            @elseif(($item['action'] ?? '') === 'update')
                                                <span class="text-[10px] font-bold text-amber-700 dark:text-amber-300">Perbarui</span>
                                            @else
                                                <span class="text-[10px] font-bold text-slate-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2.5 font-medium text-slate-800 dark:text-slate-100">{{ $item['data']['name'] ?: '-' }}</td>
                                        <td class="px-3 py-2.5 text-slate-600 dark:text-slate-300 font-mono">{{ $item['data']['username'] ?: '-' }}</td>
                                        <td class="px-3 py-2.5 text-slate-700 dark:text-slate-200 font-mono">{{ $item['data']['nomer_induk'] ?: '-' }}</td>
                                        <td class="px-3 py-2.5 text-slate-600 dark:text-slate-300">{{ $item['data']['email'] ?: '-' }}</td>
                                        <td class="px-3 py-2.5"><span class="uppercase text-[10px] font-bold text-slate-600 dark:text-slate-300">{{ $item['data']['role'] ?: '-' }}</span></td>
                                        <td class="px-3 py-2.5 min-w-[220px]">
                                            @if(!empty($item['errors']))
                                                <ul class="text-[11px] text-rose-700 dark:text-rose-300 space-y-0.5 list-disc list-inside">
                                                    @foreach($item['errors'] as $err)<li>{{ $err }}</li>@endforeach
                                                </ul>
                                            @else
                                                <span class="text-[11px] text-emerald-700 dark:text-emerald-300 font-semibold">Siap diimpor</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-2">
                            <form action="{{ route('admin.pengguna.massal') }}" method="GET">
                                <button type="submit" class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-xs font-semibold hover:bg-slate-100 dark:hover:bg-slate-800 transition">Batalkan Pratinjau</button>
                            </form>
                            <form action="{{ route('admin.pengguna.massal.import') }}" method="POST">
                                @csrf
                                <input type="hidden" name="preview_token" value="{{ $previewToken }}">
                                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white text-xs font-bold rounded-xl shadow-lg shadow-orange-500/20 transition gap-2" {{ $validCount === 0 ? 'disabled' : '' }}>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Konfirmasi Impor ({{ $validCount }} baris valid)
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </section>

            <!-- Data Table Card -->
            <section class="bg-[#f8f9fc] dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-800 rounded-2xl shadow-md dark:shadow-xl dark:shadow-black/20 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-800/40">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                        <div>
                            <h2 class="text-base font-bold text-slate-900 dark:text-white">Data Pengguna</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kelola data pengguna terdaftar (tampilan massal).</p>
                        </div>
                        <form method="GET" action="{{ route('admin.pengguna.massal') }}" class="flex flex-col sm:flex-row gap-2 sm:items-center w-full lg:w-auto">
                            <div class="relative w-full sm:w-64">
                                <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama / NIM / NIP / email / username..." class="w-full pl-9 pr-3 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                            </div>
                            <select name="role" class="w-full sm:w-40 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                                <option value="">Semua Role</option>
                                <option value="mahasiswa" {{ $role==='mahasiswa'?'selected':'' }}>Mahasiswa</option>
                                <option value="dosen" {{ $role==='dosen'?'selected':'' }}>Dosen</option>
                                <option value="admin" {{ $role==='admin'?'selected':'' }}>Admin</option>
                            </select>
                            <div class="flex gap-2">
                                <button type="submit" class="px-3.5 py-2 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-xs font-bold hover:opacity-90 transition">Terapkan</button>
                                <a href="{{ route('admin.pengguna.massal') }}" class="px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-xs font-semibold hover:border-amber-400 transition">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>

                <form id="bulk-delete-form" action="{{ route('admin.pengguna.massal.bulk-delete') }}" method="POST" onsubmit="return confirmBulkDelete();">
                    @csrf
                    <div id="bulk-bar" class="hidden px-5 sm:px-6 py-3 bg-amber-50 dark:bg-amber-500/10 border-b border-amber-200 dark:border-amber-500/20 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <p class="text-xs font-semibold text-amber-800 dark:text-amber-300"><span id="selected-count">0</span> baris dipilih</p>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="clearSelection()" class="px-3 py-1.5 rounded-lg border border-amber-300 dark:border-amber-500/40 text-amber-800 dark:text-amber-300 text-xs font-semibold hover:bg-amber-100/60 dark:hover:bg-amber-500/10 transition">Batal Pilih</button>
                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition">Hapus Terpilih</button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-xs">
                            <thead class="bg-slate-100/80 dark:bg-slate-800/70 text-slate-600 dark:text-slate-300">
                                <tr>
                                    <th class="px-4 py-3 text-left w-10"><input type="checkbox" id="select-all" class="rounded border-slate-300 text-amber-500 focus:ring-amber-500"></th>
                                    <th class="px-4 py-3 text-left font-bold">Nama</th>
                                    <th class="px-4 py-3 text-left font-bold">Username</th>
                                    <th class="px-4 py-3 text-left font-bold">NIM/NIP</th>
                                    <th class="px-4 py-3 text-left font-bold">Email</th>
                                    <th class="px-4 py-3 text-left font-bold">Role</th>
                                    <th class="px-4 py-3 text-left font-bold">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($users as $user)
                                @php
                                    $roleBadge = match($user->role) {
                                        'admin' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-300 border-rose-200 dark:border-rose-500/30',
                                        'dosen' => 'bg-purple-100 text-purple-700 dark:bg-purple-500/15 dark:text-purple-300 border-purple-200 dark:border-purple-500/30',
                                        default => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300 border-emerald-200 dark:border-emerald-500/30',
                                    };
                                @endphp
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                                    <td class="px-4 py-3 align-top">
                                        @if($user->id !== auth()->id())
                                            <input type="checkbox" name="ids[]" value="{{ $user->id }}" class="row-check rounded border-slate-300 text-amber-500 focus:ring-amber-500">
                                        @else
                                            <span class="inline-block w-4 h-4"></span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-slate-900 dark:text-slate-100 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-4 py-3 font-mono text-slate-600 dark:text-slate-300 whitespace-nowrap">{{ $user->username ?: '-' }}</td>
                                    <td class="px-4 py-3 font-mono text-slate-700 dark:text-slate-200 whitespace-nowrap">{{ $user->nomer_induk }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $user->email ?: '-' }}</td>
                                    <td class="px-4 py-3"><span class="inline-flex px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase border {{ $roleBadge }}">{{ $user->role }}</span></td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-14 text-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 mx-auto flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 13V7a2 2 0 00-2-2h-3M4 7v10a2 2 0 002 2h8m6-6l-4 4m0 0l-4-4m4 4V4M9 5H6a2 2 0 00-2 2"/></svg>
                                        </div>
                                        <p class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Belum ada data</p>
                                        <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">Unggah file melalui area impor di atas untuk menambahkan data pengguna.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>

                <div class="px-5 sm:px-6 py-4 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        @if($users->total() > 0)
                            Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} data
                        @else
                            Tidak ada data untuk ditampilkan
                        @endif
                    </p>
                    <div class="text-xs">{{ $users->links() }}</div>
                </div>
            </section>
        </main>
    </div>

    <script>
    (function(){
        // drag-drop
        var dz = document.getElementById('dropzone');
        var fi = document.getElementById('file-input');
        var fn = document.getElementById('file-name');
        if (dz && fi) {
            ['dragenter','dragover'].forEach(function(ev){ dz.addEventListener(ev, function(e){ e.preventDefault(); dz.classList.add('dragover'); }); });
            ['dragleave','drop'].forEach(function(ev){ dz.addEventListener(ev, function(e){ e.preventDefault(); dz.classList.remove('dragover'); }); });
            dz.addEventListener('drop', function(e){ if(e.dataTransfer && e.dataTransfer.files.length){ fi.files = e.dataTransfer.files; updateFileName(); } });
            fi.addEventListener('change', updateFileName);
        }
        function updateFileName(){ if(fi && fi.files && fi.files[0]){ fn.textContent = 'File dipilih: ' + fi.files[0].name; fn.classList.remove('hidden'); } }

        // bulk selection
        var selectAll = document.getElementById('select-all');
        var bar = document.getElementById('bulk-bar');
        var countEl = document.getElementById('selected-count');
        function getChecks(){ return Array.prototype.slice.call(document.querySelectorAll('.row-check')); }
        function refreshBulk(){
            var checks = getChecks();
            var selected = checks.filter(function(c){ return c.checked; }).length;
            if (countEl) countEl.textContent = selected;
            if (bar) bar.classList.toggle('hidden', selected === 0);
            if (selectAll) {
                var total = checks.length;
                selectAll.checked = total > 0 && selected === total;
                selectAll.indeterminate = selected > 0 && selected < total;
            }
        }
        if (selectAll) {
            selectAll.addEventListener('change', function(){
                getChecks().forEach(function(c){ c.checked = selectAll.checked; });
                refreshBulk();
            });
        }
        getChecks().forEach(function(c){ c.addEventListener('change', refreshBulk); });
        window.clearSelection = function(){ getChecks().forEach(function(c){ c.checked = false; }); if(selectAll) selectAll.checked=false; refreshBulk(); };
        window.confirmBulkDelete = function(){
            var n = getChecks().filter(function(c){ return c.checked; }).length;
            if (n === 0) { alert('Pilih minimal satu akun.'); return false; }
            return confirm('Hapus ' + n + ' akun terpilih? Tindakan ini tidak dapat dibatalkan.');
        };

        // auto hide flash
        setTimeout(function(){
            document.querySelectorAll('.flash-msg').forEach(function(el){
                el.style.transition='opacity .4s ease'; el.style.opacity='0';
                setTimeout(function(){ el.remove(); }, 450);
            });
        }, 4500);
    })();
    </script>
</body>
</html>
