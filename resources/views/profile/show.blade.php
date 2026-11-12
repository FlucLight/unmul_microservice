<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Akun — Fakultas Teknik UNMUL</title>
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
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    document.documentElement.classList.remove('light');
                } else {
                    document.documentElement.classList.remove('dark');
                    document.documentElement.classList.add('light');
                }
            } catch (e) {}
        })();
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#FF7A00', hover: '#E06B00', light: '#FFF0E6', gradient: '#FF9225' }
                    },
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; transition: background-color .3s ease, color .3s ease; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .dark ::-webkit-scrollbar-thumb:hover { background: #475569; }
        ::selection { background: #FF7A00; color: #fff; }
        :focus-visible { outline: 2px solid #FF7A00; outline-offset: 2px; }
        .page-transition-wrapper { animation: pageFadeIn .35s cubic-bezier(0.16,1,0.3,1) forwards; }
        @keyframes pageFadeIn { from { opacity:0; transform:translateY(12px);} to { opacity:1; transform:translateY(0);} }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="min-h-screen bg-[#e5e9f0] dark:bg-[#0f172a] text-slate-800 dark:text-slate-100 antialiased flex flex-col">
@php
    $u = auth()->user();
    $roleLabel = $u->isAdmin() ? 'Admin' : ($u->isDosen() ? 'Dosen' : 'Mahasiswa');
    $roleBadgeClass = $u->isAdmin()
        ? 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-300 border-rose-200 dark:border-rose-500/30'
        : ($u->isDosen()
            ? 'bg-purple-100 text-purple-700 dark:bg-purple-500/15 dark:text-purple-300 border-purple-200 dark:border-purple-500/30'
            : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300 border-emerald-200 dark:border-emerald-500/30');
    $joined = $u->created_at ? $u->created_at->translatedFormat('F Y') : null;
    $initials = collect(preg_split('/\s+/', trim($u->name ?? 'U')))->filter()->map(fn($p)=>mb_substr($p,0,1))->take(2)->implode('');
    $initials = strtoupper($initials ?: 'U');
    $activeTab = old('_tab', session('active_tab', 'profile'));
@endphp

    @include('partials.navbar')

    <div id="pageMainContent" class="page-transition-wrapper flex-1 relative z-10">
        <!-- Flash / Toast -->
        @if(session('success') || session('error') || $errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 space-y-2" id="flash-area">
            @if(session('success'))
                <div class="flash-msg p-3.5 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-300 dark:border-emerald-500/40 text-emerald-800 dark:text-emerald-200 rounded-xl text-sm font-semibold flex items-center justify-between shadow-md">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.closest('.flash-msg').remove()" class="text-emerald-700/70 hover:text-emerald-900 dark:text-emerald-300/70 dark:hover:text-emerald-100" aria-label="Tutup">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="flash-msg p-3.5 bg-rose-50 dark:bg-rose-950/60 border border-rose-300 dark:border-rose-500/40 text-rose-800 dark:text-rose-200 rounded-xl text-sm font-semibold flex items-center justify-between shadow-md">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/><path d="M12 8v5M12 16h.01" stroke-width="2" stroke-linecap="round"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.closest('.flash-msg').remove()" class="text-rose-700/70 hover:text-rose-900 dark:text-rose-300/70 dark:hover:text-rose-100" aria-label="Tutup">&times;</button>
                </div>
            @endif
            @if($errors->any())
                <div class="flash-msg p-3.5 bg-rose-50 dark:bg-rose-950/60 border border-rose-300 dark:border-rose-500/40 text-rose-800 dark:text-rose-200 rounded-xl text-sm font-semibold shadow-md">
                    <div class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/><path d="M12 8v5M12 16h.01" stroke-width="2" stroke-linecap="round"/></svg>
                        <div>
                            <p class="font-bold">Periksa kembali isian Anda:</p>
                            <ul class="mt-1 list-disc list-inside font-medium text-xs sm:text-sm">
                                @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @endif

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Page header -->
            <div class="mb-6">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400 border border-amber-200 dark:border-amber-500/30">Akun</span>
                <h1 class="mt-2 text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Profil Saya</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola informasi profil, keamanan, dan preferensi tampilan akun Anda.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                <!-- LEFT COLUMN -->
                <aside class="lg:col-span-4 xl:col-span-3 lg:sticky lg:top-24 space-y-4">
                    <div class="bg-[#f8f9fc] dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-800 rounded-2xl shadow-md dark:shadow-xl dark:shadow-black/20 p-5 sm:p-6">
                        <!-- Avatar -->
                        <div class="flex flex-col items-center text-center">
                            <div class="relative inline-block">
                                <div class="w-40 h-40 sm:w-52 sm:h-52 lg:w-56 lg:h-56 rounded-full overflow-hidden border-4 border-white dark:border-slate-800 shadow-lg bg-slate-200 dark:bg-slate-800 flex items-center justify-center" id="avatar-preview-wrap">
                                    @if($u->avatar_url)
                                        <img id="avatar-preview-img" src="{{ $u->avatar_url }}" alt="{{ $u->name }}" class="w-full h-full object-cover">
                                        <div id="avatar-preview-initials" class="hidden w-full h-full items-center justify-center bg-gradient-to-tr from-[#FF7A00] to-[#FF9225] text-white font-extrabold text-5xl sm:text-6xl">{{ $initials }}</div>
                                    @else
                                        <img id="avatar-preview-img" src="" alt="" class="hidden w-full h-full object-cover">
                                        <div id="avatar-preview-initials" class="w-full h-full flex items-center justify-center bg-gradient-to-tr from-[#FF7A00] to-[#FF9225] text-white font-extrabold text-5xl sm:text-6xl">{{ $initials }}</div>
                                    @endif
                                </div>
                                <button type="button" onclick="document.getElementById('avatar-input').click()" class="absolute bottom-2 right-2 w-10 h-10 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md flex items-center justify-center text-slate-700 dark:text-slate-200 hover:text-amber-600 dark:hover:text-amber-400 hover:border-amber-400 transition" title="Ubah foto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </button>
                            </div>

                            <!-- Avatar forms -->
                            <form id="avatar-upload-form" action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" class="mt-3 w-full hidden">
                                @csrf
                                <input id="avatar-input" type="file" name="avatar" accept="image/jpeg,image/png,image/webp" class="hidden">
                                <div id="avatar-selected" class="hidden mt-2 p-2 rounded-lg bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/30 text-xs text-amber-800 dark:text-amber-300">
                                    <span id="avatar-filename"></span>
                                </div>
                                <div class="mt-2 flex gap-2">
                                    <button type="submit" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] text-white text-xs font-bold rounded-lg shadow hover:from-[#e06b00] hover:to-[#ff8314] transition">Simpan Foto</button>
                                    <button type="button" id="avatar-cancel" class="px-3 py-2 text-xs font-semibold rounded-lg border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Batal</button>
                                </div>
                                @error('avatar')<p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>@enderror
                            </form>
                            @if($u->avatar_url)
                            <form action="{{ route('profile.avatar.delete') }}" method="POST" class="mt-2" onsubmit="return confirm('Hapus foto profil?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-slate-500 hover:text-rose-600 dark:text-slate-400 dark:hover:text-rose-400 transition">Hapus foto</button>
                            </form>
                            @endif

                            <div class="mt-4 w-full">
                                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white leading-tight break-words">{{ $u->name }}</h2>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5 font-mono">{{ $u->nomer_induk ?? '-' }}</p>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider border {{ $roleBadgeClass }}">{{ $roleLabel }}</span>
                                </div>
                                <p class="mt-3 text-sm text-slate-600 dark:text-slate-300 leading-relaxed {{ $u->bio ? '' : 'italic text-slate-400 dark:text-slate-500' }}">{{ $u->bio ?: 'Belum ada bio.' }}</p>
                            </div>

                            <button type="button" onclick="switchTab('profile'); document.getElementById('name')?.focus();" class="mt-4 w-full inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800/60 text-slate-700 dark:text-slate-200 font-semibold text-sm hover:border-amber-400 hover:text-amber-700 dark:hover:text-amber-400 hover:bg-amber-50/50 dark:hover:bg-slate-800 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit Profil
                            </button>
                        </div>

                        <div class="mt-5 pt-5 border-t border-slate-200 dark:border-slate-800 space-y-3 text-sm">
                            <div class="flex items-start gap-3">
                                <svg class="w-4 h-4 mt-0.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/></svg>
                                <div class="min-w-0"><p class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">NIM / NIP</p><p class="font-medium text-slate-800 dark:text-slate-100 break-all">{{ $u->nomer_induk ?? '-' }}</p></div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-4 h-4 mt-0.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <div class="min-w-0"><p class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Email</p><p class="font-medium {{ $u->email ? 'text-slate-800 dark:text-slate-100' : 'text-slate-400 dark:text-slate-500 italic' }} break-all">{{ $u->email ?: 'Belum diatur' }}</p></div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-4 h-4 mt-0.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <div class="min-w-0"><p class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Telepon</p><p class="font-medium {{ $u->phone ? 'text-slate-800 dark:text-slate-100' : 'text-slate-400 dark:text-slate-500 italic' }}">{{ $u->phone ?: 'Belum diatur' }}</p></div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-4 h-4 mt-0.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <div class="min-w-0"><p class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Bergabung sejak</p><p class="font-medium {{ $joined ? 'text-slate-800 dark:text-slate-100' : 'text-slate-400 dark:text-slate-500 italic' }}">{{ $joined ?: 'Tidak diketahui' }}</p></div>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- RIGHT COLUMN -->
                <section class="lg:col-span-8 xl:col-span-9 min-w-0">
                    <div class="bg-[#f8f9fc] dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-800 rounded-2xl shadow-md dark:shadow-xl dark:shadow-black/20 overflow-hidden">
                        <!-- Tabs -->
                        <div class="border-b border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-800/40">
                            <nav class="flex overflow-x-auto no-scrollbar px-2 sm:px-4" aria-label="Tabs">
                                <button type="button" data-tab="profile" onclick="switchTab('profile')" class="tab-btn relative whitespace-nowrap px-4 py-4 text-sm font-semibold border-b-2 transition-colors {{ $activeTab==='profile' ? 'border-amber-500 text-slate-900 dark:text-white' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200' }}">Profil</button>
                                <button type="button" data-tab="security" onclick="switchTab('security')" class="tab-btn relative whitespace-nowrap px-4 py-4 text-sm font-semibold border-b-2 transition-colors {{ $activeTab==='security' ? 'border-amber-500 text-slate-900 dark:text-white' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200' }}">Keamanan</button>
                                <button type="button" data-tab="preferences" onclick="switchTab('preferences')" class="tab-btn relative whitespace-nowrap px-4 py-4 text-sm font-semibold border-b-2 transition-colors {{ $activeTab==='preferences' ? 'border-amber-500 text-slate-900 dark:text-white' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200' }}">Preferensi</button>
                            </nav>
                        </div>

                        <div class="p-5 sm:p-6 lg:p-8">
                            <!-- TAB: Profile -->
                            <div id="tab-profile" class="tab-panel {{ $activeTab==='profile' ? 'active' : '' }}">
                                <div class="mb-6">
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100">Informasi Profil</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Perbarui nama, bio, email, dan nomor telepon Anda.</p>
                                </div>
                                <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="_tab" value="profile">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div class="md:col-span-2">
                                            <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                                            <input id="name" name="name" type="text" value="{{ old('name', $u->name) }}" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition" />
                                            @error('name')<p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="md:col-span-2">
                                            <label for="bio" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Bio <span class="text-slate-400 font-normal">(opsional, maks 160)</span></label>
                                            <textarea id="bio" name="bio" rows="3" maxlength="160" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition resize-y" placeholder="Ceritakan sedikit tentang Anda...">{{ old('bio', $u->bio) }}</textarea>
                                            <div class="mt-1.5 flex items-center justify-between">
                                                <span>@error('bio')<span class="text-xs text-rose-600 dark:text-rose-400">{{ $message }}</span>@enderror</span>
                                                <span id="bio-counter" class="text-xs font-medium text-slate-500 dark:text-slate-400">0/160</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Email <span class="text-slate-400 font-normal">(opsional)</span></label>
                                            <input id="email" name="email" type="email" value="{{ old('email', $u->email) }}" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition" placeholder="nama@contoh.ac.id" />
                                            @error('email')<p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>@enderror
                                        </div>
                                        <div>
                                            <label for="phone" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Nomor Telepon <span class="text-slate-400 font-normal">(opsional)</span></label>
                                            <input id="phone" name="phone" type="text" value="{{ old('phone', $u->phone) }}" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition" placeholder="08xxxxxxxxxx" />
                                            @error('phone')<p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Nomor Induk (NIM/NIP)</label>
                                            <input type="text" value="{{ $u->nomer_induk }}" disabled class="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-slate-900/60 text-slate-500 dark:text-slate-400 px-4 py-2.5 cursor-not-allowed" />
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">Nomor induk tidak dapat diubah.</p>
                                        </div>
                                    </div>
                                    <div class="pt-2 flex items-center justify-end gap-3 border-t border-slate-200 dark:border-slate-800">
                                        <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-500/20 transition">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>

                            <!-- TAB: Security -->
                            <div id="tab-security" class="tab-panel {{ $activeTab==='security' ? 'active' : '' }}">
                                <div class="mb-6">
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100">Keamanan</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Perbarui password akun Anda secara berkala untuk menjaga keamanan.</p>
                                </div>
                                <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-5 max-w-xl">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="_tab" value="security">
                                    <div>
                                        <label for="current_password" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Password Saat Ini <span class="text-rose-500">*</span></label>
                                        <input id="current_password" name="current_password" type="password" autocomplete="current-password" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition" />
                                        @error('current_password', 'updatePassword')<p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>@enderror
                                        @if($errors->has('current_password') && !$errors->updatePassword->has('current_password'))<p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $errors->first('current_password') }}</p>@endif
                                    </div>
                                    <div>
                                        <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Password Baru <span class="text-rose-500">*</span></label>
                                        <input id="password" name="password" type="password" autocomplete="new-password" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition" />
                                        @error('password', 'updatePassword')<p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>@enderror
                                        @if($errors->has('password') && !$errors->updatePassword->has('password'))<p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400">{{ $errors->first('password') }}</p>@endif
                                    </div>
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Konfirmasi Password Baru <span class="text-rose-500">*</span></label>
                                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition" />
                                    </div>
                                    <div class="pt-2 flex items-center justify-end gap-3 border-t border-slate-200 dark:border-slate-800">
                                        <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-[#FF7A00] to-[#FF9225] hover:from-[#e06b00] hover:to-[#ff8314] text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-500/20 transition">Perbarui Password</button>
                                    </div>
                                </form>
                            </div>

                            <!-- TAB: Preferences -->
                            <div id="tab-preferences" class="tab-panel {{ $activeTab==='preferences' ? 'active' : '' }}">
                                <div class="mb-6">
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100">Preferensi</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Atur tampilan aplikasi sesuai kenyamanan Anda. Pilihan tema disimpan di perangkat ini dan tersinkron dengan tombol tema di navbar.</p>
                                </div>
                                <div class="space-y-4 max-w-2xl">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">Tema Tampilan</p>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3" id="theme-options">
                                            <button type="button" data-theme-choice="light" class="theme-choice group text-left p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 hover:border-amber-400 transition">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                                                    </span>
                                                    <span class="theme-check hidden text-amber-500"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg></span>
                                                </div>
                                                <p class="font-bold text-slate-900 dark:text-slate-100">Terang</p>
                                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Tampilan cerah untuk siang hari.</p>
                                            </button>
                                            <button type="button" data-theme-choice="dark" class="theme-choice group text-left p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 hover:border-amber-400 transition">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                                                    </span>
                                                    <span class="theme-check hidden text-amber-500"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg></span>
                                                </div>
                                                <p class="font-bold text-slate-900 dark:text-slate-100">Gelap</p>
                                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Nyaman untuk mata di malam hari.</p>
                                            </button>
                                            <button type="button" data-theme-choice="system" class="theme-choice group text-left p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-950 hover:border-amber-400 transition">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                                                    </span>
                                                    <span class="theme-check hidden text-amber-500"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg></span>
                                                </div>
                                                <p class="font-bold text-slate-900 dark:text-slate-100">Sistem</p>
                                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Ikuti pengaturan perangkat.</p>
                                            </button>
                                        </div>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-3">Pilihan saat ini: <span id="theme-current-label" class="font-semibold text-slate-700 dark:text-slate-200">-</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
    (function () {
        // ---- Tabs ----
        function setActiveTab(tab) {
            document.querySelectorAll('.tab-panel').forEach(function (p) {
                p.classList.toggle('active', p.id === 'tab-' + tab);
            });
            document.querySelectorAll('.tab-btn').forEach(function (b) {
                var active = b.getAttribute('data-tab') === tab;
                b.classList.toggle('border-amber-500', active);
                b.classList.toggle('text-slate-900', active);
                b.classList.toggle('dark:text-white', active);
                b.classList.toggle('border-transparent', !active);
                b.classList.toggle('text-slate-500', !active);
                b.classList.toggle('dark:text-slate-400', !active);
            });
            try { history.replaceState(null, '', '#'+tab); } catch(e){}
        }
        window.switchTab = function (tab) { setActiveTab(tab); };

        // initial tab (hash or server-provided)
        var serverTab = @json($activeTab);
        var hash = (location.hash || '').replace('#','');
        var allowed = ['profile','security','preferences'];
        var initTab = allowed.indexOf(hash) !== -1 ? hash : (allowed.indexOf(serverTab) !== -1 ? serverTab : 'profile');
        setActiveTab(initTab);

        // ---- Bio counter ----
        var bio = document.getElementById('bio');
        var counter = document.getElementById('bio-counter');
        function updateCounter() {
            if (!bio || !counter) return;
            var len = (bio.value || '').length;
            counter.textContent = len + '/160';
            counter.classList.toggle('text-amber-600', len > 140);
            counter.classList.toggle('dark:text-amber-400', len > 140);
        }
        if (bio) {
            bio.addEventListener('input', updateCounter);
            updateCounter();
        }

        // ---- Avatar preview ----
        var avatarInput = document.getElementById('avatar-input');
        var uploadForm = document.getElementById('avatar-upload-form');
        var cancelBtn = document.getElementById('avatar-cancel');
        var img = document.getElementById('avatar-preview-img');
        var initials = document.getElementById('avatar-preview-initials');
        var selected = document.getElementById('avatar-selected');
        var filename = document.getElementById('avatar-filename');
        var originalSrc = img ? img.getAttribute('src') : '';
        var hadImage = originalSrc && originalSrc.length > 0 && !img.classList.contains('hidden');

        if (avatarInput) {
            avatarInput.addEventListener('change', function (e) {
                var file = e.target.files && e.target.files[0];
                if (!file) return;
                if (uploadForm) uploadForm.classList.remove('hidden');
                if (selected) selected.classList.remove('hidden');
                if (filename) filename.textContent = file.name;
                var reader = new FileReader();
                reader.onload = function (ev) {
                    if (img) { img.src = ev.target.result; img.classList.remove('hidden'); }
                    if (initials) { initials.classList.add('hidden'); initials.classList.remove('flex'); }
                };
                reader.readAsDataURL(file);
            });
        }
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function () {
                if (avatarInput) avatarInput.value = '';
                if (uploadForm) uploadForm.classList.add('hidden');
                if (selected) selected.classList.add('hidden');
                if (hadImage) {
                    if (img) { img.src = originalSrc; img.classList.remove('hidden'); }
                    if (initials) { initials.classList.add('hidden'); initials.classList.remove('flex'); }
                } else {
                    if (img) { img.src = ''; img.classList.add('hidden'); }
                    if (initials) { initials.classList.remove('hidden'); initials.classList.add('flex'); }
                }
            });
        }

        // ---- Theme preferences (Light/Dark/System) synced with navbar ----
        var storageKey = 'pkl_theme';
        function systemPrefersDark() {
            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
        function resolveTheme(mode) {
            if (mode === 'system') return systemPrefersDark() ? 'dark' : 'light';
            return mode === 'light' ? 'light' : 'dark';
        }
        function applyThemeMode(mode) {
            var effective = resolveTheme(mode);
            var root = document.documentElement;
            if (effective === 'dark') { root.classList.add('dark'); root.classList.remove('light'); }
            else { root.classList.remove('dark'); root.classList.add('light'); }
        }
        function setThemeMode(mode) {
            try { localStorage.setItem(storageKey, mode); } catch(e){}
            applyThemeMode(mode);
            syncThemeUI(mode);
        }
        function getThemeMode() {
            var m = 'dark';
            try { m = localStorage.getItem(storageKey) || 'dark'; } catch(e){}
            if (['light','dark','system'].indexOf(m) === -1) m = 'dark';
            return m;
        }
        function syncThemeUI(mode) {
            var labels = { light: 'Terang', dark: 'Gelap', system: 'Sistem (ikuti perangkat)' };
            var label = document.getElementById('theme-current-label');
            if (label) label.textContent = labels[mode] || mode;
            document.querySelectorAll('.theme-choice').forEach(function (btn) {
                var active = btn.getAttribute('data-theme-choice') === mode;
                btn.classList.toggle('border-amber-500', active);
                btn.classList.toggle('ring-1', active);
                btn.classList.toggle('ring-amber-500/40', active);
                btn.classList.toggle('border-slate-200', !active);
                btn.classList.toggle('dark:border-slate-700', !active);
                var check = btn.querySelector('.theme-check');
                if (check) check.classList.toggle('hidden', !active);
            });
        }
        // override navbar toggle to cycle light/dark but respect/keep preference sensible
        window.__toggleTheme = function () {
            var current = getThemeMode();
            var next = (resolveTheme(current) === 'dark') ? 'light' : 'dark';
            setThemeMode(next);
        };
        window.toggleTheme = window.__toggleTheme;

        document.querySelectorAll('[data-theme-choice]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                setThemeMode(btn.getAttribute('data-theme-choice'));
            });
        });
        // react to system changes when in system mode
        if (window.matchMedia) {
            var mq = window.matchMedia('(prefers-color-scheme: dark)');
            var onChange = function () { if (getThemeMode() === 'system') { applyThemeMode('system'); } };
            if (mq.addEventListener) mq.addEventListener('change', onChange); else if (mq.addListener) mq.addListener(onChange);
        }
        syncThemeUI(getThemeMode());

        // flash auto-hide
        setTimeout(function () {
            document.querySelectorAll('.flash-msg').forEach(function (el) {
                el.style.transition = 'opacity .4s ease, transform .4s ease';
                el.style.opacity = '0'; el.style.transform = 'translateY(-4px)';
                setTimeout(function(){ if(el.parentNode) el.parentNode.removeChild(el); }, 450);
            });
        }, 4000);
    })();
    </script>
</body>
</html>
