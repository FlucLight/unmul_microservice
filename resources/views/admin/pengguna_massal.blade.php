<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Massal NIM — Fakultas Teknik UNMUL</title>
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
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
                <div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-500/30">Admin</span>
                    <h1 class="mt-2 text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Kelola Massal NIM</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola data NIM & password mahasiswa (satuan, import massal, edit/hapus, dan aksi massal). Terhubung ke layanan Cek NIM secara aman dari server.</p>
                </div>
                <div class="flex items-center gap-2 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white/70 dark:bg-slate-900/60">
                    @php $dot = $status === 'online' ? 'bg-emerald-500' : ($status === 'offline' ? 'bg-rose-500' : 'bg-amber-500'); @endphp
                    <span class="w-2.5 h-2.5 rounded-full {{ $dot }}"></span>
                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-300">
                        @if($status === 'online') Terhubung ke layanan NIM @elseif($status === 'offline') Layanan NIM tidak terhubung @else Status layanan bermasalah @endif
                    </span>
                </div>
            </div>

            @if(!empty($apiError))
                <div class="p-3.5 bg-amber-50 dark:bg-amber-950/40 border border-amber-300 dark:border-amber-500/30 text-amber-800 dark:text-amber-200 rounded-xl text-sm">
                    <span class="font-bold">Info koneksi:</span> {{ $apiError }}
                </div>
            @endif

            <!-- Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Tambah Satu -->
                <section class="bg-[#f8f9fc] dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-800 rounded-2xl shadow-md dark:shadow-xl dark:shadow-black/20 overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-800/40">
                        <h2 class="text-base font-bold text-slate-900 dark:text-white">Tambah Satu NIM</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Tambahkan satu data NIM mahasiswa.</p>
                    </div>
                    <form action="{{ route('admin.pengguna.massal.store') }}" method="POST" class="p-5 space-y-3">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">NIM <span class="text-rose-500">*</span></label>
                            <input type="text" name="nim" value="{{ old('nim') }}" required inputmode="numeric" pattern="[0-9]+" placeholder="Contoh: 2109106051" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Password</label>
                            <input type="text" name="password" value="{{ old('password') }}" placeholder="Kosongkan = mhs123" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Default password: <span class="font-mono font-semibold">mhs123</span></p>
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-500/20 transition gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah NIM
                        </button>
                    </form>
                </section>

                <!-- Import Massal -->
                <section class="bg-[#f8f9fc] dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-800 rounded-2xl shadow-md dark:shadow-xl dark:shadow-black/20 overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-800/40">
                        <h2 class="text-base font-bold text-slate-900 dark:text-white">Import Massal</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Tempel banyak NIM sekaligus, 1 per baris / koma / spasi.</p>
                    </div>
                    <form action="{{ route('admin.pengguna.massal.import') }}" method="POST" class="p-5 space-y-3">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Daftar NIM <span class="text-rose-500">*</span></label>
                            <textarea name="nims" rows="5" required placeholder="Contoh:&#10;2109106051&#10;2109106052&#10;2109106053" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-sm font-mono text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">{{ old('nims') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Password untuk semua</label>
                            <input type="text" name="password" value="{{ old('password') }}" placeholder="Kosongkan = mhs123" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-sm transition gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Import Massal
                        </button>
                    </form>
                </section>

                <!-- Aksi Massal Terpilih -->
                <section class="bg-[#f8f9fc] dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-800 rounded-2xl shadow-md dark:shadow-xl dark:shadow-black/20 overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-800/40">
                        <h2 class="text-base font-bold text-slate-900 dark:text-white">Aksi Massal (Terpilih)</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Centang baris pada tabel, lalu ubah password atau hapus.</p>
                    </div>
                    <div class="p-5 space-y-3">
                        <form id="bulk-update-form" action="{{ route('admin.pengguna.massal.bulk-update') }}" method="POST" class="space-y-2" onsubmit="return submitBulkUpdate(event);">
                            @csrf
                            <div id="bulk-update-nims"></div>
                            <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Password baru (edit massal)</label>
                            <input type="text" name="password" id="bulk-password" placeholder="Password baru untuk NIM terpilih" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Ubah Password Terpilih
                            </button>
                        </form>
                        <form id="bulk-delete-form" action="{{ route('admin.pengguna.massal.bulk-delete') }}" method="POST" onsubmit="return submitBulkDelete(event);">
                            @csrf
                            <div id="bulk-delete-nims"></div>
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold rounded-xl transition gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus Terpilih
                            </button>
                        </form>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Pilih NIM dari tabel di bawah terlebih dahulu.</p>
                    </div>
                </section>
            </div>

            <!-- Data Table -->
            <section class="bg-[#f8f9fc] dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-800 rounded-2xl shadow-md dark:shadow-xl dark:shadow-black/20 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-800/40">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <h2 class="text-base font-bold text-slate-900 dark:text-white">Data NIM Terdaftar</h2>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300 font-bold">{{ $total }} data</span>
                        </div>
                        <form method="GET" action="{{ route('admin.pengguna.massal') }}" class="flex flex-col sm:flex-row gap-2 sm:items-center w-full lg:w-auto">
                            <div class="relative w-full sm:w-72">
                                <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <input type="text" name="q" value="{{ $q }}" placeholder="Cari NIM..." class="w-full pl-9 pr-3 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition">
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="px-3.5 py-2 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-xs font-bold hover:opacity-90 transition">Cari</button>
                                <a href="{{ route('admin.pengguna.massal') }}" class="px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-xs font-semibold hover:border-amber-400 transition">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="px-5 sm:px-6 py-3 bg-amber-50/60 dark:bg-amber-500/5 border-b border-amber-200/60 dark:border-amber-500/20 flex items-center justify-between gap-2">
                    <p class="text-xs font-semibold text-amber-800 dark:text-amber-300"><span id="selected-count">0</span> NIM dipilih</p>
                    <button type="button" onclick="clearSelection()" class="text-xs font-semibold text-amber-700 dark:text-amber-300 hover:underline">Batal pilih</button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-100/80 dark:bg-slate-800/70 text-slate-600 dark:text-slate-300">
                            <tr>
                                <th class="px-4 py-3 text-left w-10"><input type="checkbox" id="select-all" class="rounded border-slate-300 text-amber-500 focus:ring-amber-500"></th>
                                <th class="px-4 py-3 text-left font-bold">ID</th>
                                <th class="px-4 py-3 text-left font-bold">NIM</th>
                                <th class="px-4 py-3 text-left font-bold">Password</th>
                                <th class="px-4 py-3 text-left font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($rows as $r)
                                @php $nim = $r['nim'] ?? ''; $pass = $r['password'] ?? ''; $rid = $r['id_mahasiswa'] ?? '-'; @endphp
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                                    <td class="px-4 py-3 align-top">
                                        <input type="checkbox" class="row-check rounded border-slate-300 text-amber-500 focus:ring-amber-500" value="{{ $nim }}">
                                    </td>
                                    <td class="px-4 py-3 text-slate-500 dark:text-slate-400 font-mono text-xs">{{ $rid }}</td>
                                    <td class="px-4 py-3 font-semibold text-slate-900 dark:text-slate-100 font-mono">{{ $nim }}</td>
                                    <td class="px-4 py-3 text-slate-700 dark:text-slate-200 font-mono text-xs">{{ $pass }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <button type="button"
                                                data-nim="{{ $nim }}"
                                                data-password="{{ $pass }}"
                                                onclick="openEdit(this.dataset.nim, this.dataset.password)"
                                                class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 dark:bg-blue-500/10 dark:text-blue-300 dark:hover:bg-blue-500/20 text-xs font-semibold transition">Edit</button>
                                            <form action="{{ route('admin.pengguna.massal.destroy', ['nim' => $nim]) }}" method="POST" onsubmit="return confirm('Hapus NIM {{ $nim }}?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 dark:bg-rose-500/10 dark:text-rose-300 dark:hover:bg-rose-500/20 text-xs font-semibold transition">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-14 text-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 mx-auto flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 13V7a2 2 0 00-2-2h-3M4 7v10a2 2 0 002 2h8m6-6l-4 4m0 0l-4-4m4 4V4M9 5H6a2 2 0 00-2 2"/></svg>
                                        </div>
                                        <p class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Belum ada data NIM</p>
                                        <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">Tambahkan NIM satuan atau gunakan import massal. Pastikan layanan Cek NIM aktif.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- Modal Edit -->
    <div id="edit-modal" class="hidden fixed inset-0 z-50 items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40" onclick="closeEdit()"></div>
        <div class="relative bg-[#f8f9fc] dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl w-full max-w-md p-5">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">Edit Data NIM</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">Ubah NIM dan/atau password. Kosongkan password jika tidak ingin mengubah.</p>
            <form id="edit-form" method="POST" action="#">
                @csrf
                @method('PUT')
                <div class="space-y-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">NIM</label>
                        <input id="edit-nim" name="nim" type="text" inputmode="numeric" pattern="[0-9]+" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-sm font-mono text-slate-900 dark:text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-1.5">Password</label>
                        <input id="edit-password" name="password" type="text" placeholder="Biarkan kosong jika tidak diubah" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3.5 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition">
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-5">
                    <button type="button" onclick="closeEdit()" class="px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-sm font-semibold hover:bg-slate-100 dark:hover:bg-slate-800 transition">Batal</button>
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white text-sm font-bold shadow-lg shadow-orange-500/20 transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    (function(){
        var selectAll = document.getElementById('select-all');
        var countEl = document.getElementById('selected-count');
        function getChecks(){ return Array.prototype.slice.call(document.querySelectorAll('.row-check')); }
        function refresh(){
            var checks = getChecks();
            var selected = checks.filter(function(c){ return c.checked; }).length;
            if (countEl) countEl.textContent = selected;
            if (selectAll) {
                var total = checks.length;
                selectAll.checked = total > 0 && selected === total;
                selectAll.indeterminate = selected > 0 && selected < total;
            }
        }
        if (selectAll) {
            selectAll.addEventListener('change', function(){
                getChecks().forEach(function(c){ c.checked = selectAll.checked; });
                refresh();
            });
        }
        getChecks().forEach(function(c){ c.addEventListener('change', refresh); });
        window.clearSelection = function(){ getChecks().forEach(function(c){ c.checked = false; }); if(selectAll){ selectAll.checked=false; selectAll.indeterminate=false; } refresh(); };

        function selectedValues(){
            return getChecks().filter(function(c){ return c.checked; }).map(function(c){ return c.value; }).filter(Boolean);
        }
        function fillHidden(containerId, nims){
            var box = document.getElementById(containerId);
            if(!box) return;
            box.innerHTML = '';
            nims.forEach(function(n){
                var i = document.createElement('input');
                i.type = 'hidden'; i.name = 'nims[]'; i.value = n;
                box.appendChild(i);
            });
        }

        window.submitBulkUpdate = function(e){
            var nims = selectedValues();
            if(!nims.length){ alert('Pilih minimal satu NIM.'); e.preventDefault(); return false; }
            var pass = document.getElementById('bulk-password').value;
            if(!pass || !pass.trim()){ alert('Isi password baru untuk edit massal.'); e.preventDefault(); return false; }
            if(!confirm('Ubah password ' + nims.length + ' NIM terpilih?')){ e.preventDefault(); return false; }
            fillHidden('bulk-update-nims', nims);
            return true;
        };
        window.submitBulkDelete = function(e){
            var nims = selectedValues();
            if(!nims.length){ alert('Pilih minimal satu NIM.'); e.preventDefault(); return false; }
            if(!confirm('Hapus ' + nims.length + ' NIM terpilih? Tindakan ini tidak dapat dibatalkan.')){ e.preventDefault(); return false; }
            fillHidden('bulk-delete-nims', nims);
            return true;
        };

        // edit modal
        var updateUrlTemplate = @json(route('admin.pengguna.massal.update', ['nim' => '__NIM__']));
        window.openEdit = function(nim, password){
            var form = document.getElementById('edit-form');
            form.action = updateUrlTemplate.replace('__NIM__', encodeURIComponent(nim));
            document.getElementById('edit-nim').value = nim || '';
            document.getElementById('edit-password').value = password || '';
            var m = document.getElementById('edit-modal');
            m.classList.remove('hidden'); m.classList.add('flex');
        };
        window.closeEdit = function(){
            var m = document.getElementById('edit-modal');
            m.classList.add('hidden'); m.classList.remove('flex');
        };
        document.addEventListener('keydown', function(e){ if(e.key === 'Escape') closeEdit(); });

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