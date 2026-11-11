@php
    $user = auth()->user();
    $isDosen = $user && $user->isDosen();
    $isAdmin = $user && $user->isAdmin();
    $isMahasiswa = $user && $user->isMahasiswa();

    $navItems = [
        [
            'label' => 'Tugas Kuliah',
            'route' => 'tugas.index',
            'active' => request()->routeIs('tugas.index'),
            'show' => true,
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>',
        ],
        [
            'label' => 'Modul Kuliah',
            'route' => 'modul.index',
            'active' => request()->routeIs('modul.*'),
            'show' => true,
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
        ],
        [
            'label' => 'Arsip',
            'route' => 'tugas.arsip',
            'active' => request()->routeIs('tugas.arsip'),
            'show' => $isDosen || $isAdmin,
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>',
        ],
        [
            'label' => 'Manajemen Akun',
            'route' => 'admin.pengguna',
            'active' => request()->routeIs('admin.pengguna*'),
            'show' => $isAdmin,
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>',
        ],
    ];
@endphp

<header class="w-full sticky top-0 z-40 bg-[#f6f8fa]/95 dark:bg-[#0d1117]/95 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-700/80">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-3">
            <!-- Left: Brand + Nav -->
            <div class="flex items-center min-w-0 flex-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0 mr-4 sm:mr-6 group">
                    <img src="{{ asset('logo.png') }}" alt="Logo FT UNMUL" class="w-8 h-8 sm:w-9 sm:h-9 object-contain">
                    <div class="leading-tight min-w-0">
                        <span class="block font-extrabold text-[11px] sm:text-xs text-slate-900 dark:text-slate-100 tracking-tight truncate max-w-[180px] sm:max-w-none">FAKULTAS TEKNIK</span>
                        <span class="block font-semibold text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-widest truncate">UNIVERSITAS MULAWARMAN</span>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center h-16 gap-1" aria-label="Primary">
                    @foreach($navItems as $item)
                        @if($item['show'])
                            <a href="{{ route($item['route']) }}"
                               class="relative inline-flex items-center h-16 px-3 text-sm font-medium border-b-2 transition-colors duration-150
                                      {{ $item['active']
                                          ? 'border-amber-500 text-slate-900 dark:text-white'
                                          : 'border-transparent text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-600' }}">
                                <svg class="w-4 h-4 mr-1.5 {{ $item['active'] ? 'text-amber-500' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </nav>
            </div>

            <!-- Right: Controls -->
            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                <!-- Dark mode toggle -->
                <button type="button" data-theme-toggle onclick="window.__toggleTheme && window.__toggleTheme()" class="inline-flex items-center justify-center w-9 h-9 rounded-md text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-[#0d1117]" aria-label="Ganti tema" title="Ganti tema">
                    <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                    <svg class="w-4 h-4 hidden dark:block" fill="currentColor" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                </button>

                @auth
                <!-- User Profile Dropdown (restored structure) -->
                <div class="relative" data-user-menu>
                    <button type="button" data-user-menu-btn class="inline-flex items-center gap-2 rounded-full p-0.5 pr-2 hover:bg-slate-100 dark:hover:bg-slate-800 border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-[#0d1117]" aria-haspopup="menu" aria-expanded="false">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <img class="w-8 h-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                        @else
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#FF7A00] to-[#FF9225] text-white font-extrabold text-xs flex items-center justify-center">
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                        <span class="hidden sm:block text-sm font-semibold text-slate-700 dark:text-slate-200 max-w-[120px] truncate">{{ $user->name }}</span>
                        <svg class="hidden sm:block w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div data-user-menu-panel class="hidden absolute right-0 mt-2 w-64 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-[#161b22] shadow-xl overflow-hidden z-50">
                        <div class="px-4 py-3 bg-slate-50/80 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-700/80">
                            <div class="flex items-center gap-3">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <img class="w-10 h-10 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#FF7A00] to-[#FF9225] text-white font-extrabold text-sm flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-semibold text-slate-900 dark:text-slate-100 truncate">{{ $user->name }}</p>
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400">{{ $user->role }}</span>
                                    </div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('profile.show') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Profil
                            </a>
                        </div>
                        <div class="border-t border-slate-100 dark:border-slate-700/80"></div>
                        <form method="POST" action="{{ route('logout') }}" class="py-1">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
                @endauth

                <!-- Mobile hamburger -->
                <button type="button" data-mobile-menu-btn class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded-md text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white dark:focus-visible:ring-offset-[#0d1117]" aria-controls="mobile-nav" aria-expanded="false">
                    <span class="sr-only">Menu</span>
                    <svg data-icon-open class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg data-icon-close class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-nav" data-mobile-menu-panel class="hidden md:hidden border-t border-slate-200 dark:border-slate-700/80 bg-[#f6f8fa] dark:bg-[#0d1117]">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 py-2 space-y-0.5">
            @foreach($navItems as $item)
                @if($item['show'])
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-2 px-3 py-2.5 rounded-md text-sm font-medium transition
                              {{ $item['active']
                                  ? 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400 border-l-2 border-amber-500'
                                  : 'text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 border-l-2 border-transparent' }}">
                        <svg class="w-4 h-4 {{ $item['active'] ? 'text-amber-500' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach
        </nav>
        @auth
        <div class="border-t border-slate-200 dark:border-slate-700/80 px-4 sm:px-6 py-3">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-[#FF7A00] to-[#FF9225] text-white font-bold text-xs flex items-center justify-center">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-900 dark:text-slate-100 truncate">{{ $user->name }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $user->email }}</p>
                </div>
            </div>
            <a href="{{ route('profile.show') }}" class="block px-3 py-2 rounded-md text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800">Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10">Keluar</button>
            </form>
        </div>
        @endauth
    </div>
</header>

<script>
(function () {
    // Theme: support both pkl_theme (standalone pages) and generic 'theme'
    var storageKey = 'pkl_theme';
    function applyTheme(mode) {
        var root = document.documentElement;
        if (mode === 'dark') {
            root.classList.add('dark');
            root.classList.remove('light');
        } else {
            root.classList.remove('dark');
            root.classList.add('light');
        }
    }
    window.__toggleTheme = function () {
        var isDark = document.documentElement.classList.contains('dark');
        var next = isDark ? 'light' : 'dark';
        try { localStorage.setItem(storageKey, next); } catch (e) {}
        applyTheme(next);
        if (typeof window.toggleTheme === 'function' && window.toggleTheme !== window.__toggleTheme) {
            // keep legacy hooks in sync
        }
    };
    // Expose as toggleTheme for existing inline handlers compatibility
    if (typeof window.toggleTheme !== 'function') {
        window.toggleTheme = window.__toggleTheme;
    }

    function initNavbar(root) {
        root = root || document;
        var btn = root.querySelector('[data-mobile-menu-btn]');
        var panel = root.querySelector('[data-mobile-menu-panel]');
        if (btn && panel && !btn.__navInit) {
            btn.__navInit = true;
            btn.addEventListener('click', function () {
                var open = !panel.classList.contains('hidden');
                panel.classList.toggle('hidden', open);
                btn.setAttribute('aria-expanded', String(!open));
                var io = btn.querySelector('[data-icon-open]');
                var ic = btn.querySelector('[data-icon-close]');
                if (io) io.classList.toggle('hidden', !open);
                if (ic) ic.classList.toggle('hidden', open);
            });
        }
        root.querySelectorAll('[data-user-menu]').forEach(function (menu) {
            if (menu.__navInit) return;
            menu.__navInit = true;
            var b = menu.querySelector('[data-user-menu-btn]');
            var p = menu.querySelector('[data-user-menu-panel]');
            if (!b || !p) return;
            b.addEventListener('click', function (e) {
                e.stopPropagation();
                var open = !p.classList.contains('hidden');
                // close others
                document.querySelectorAll('[data-user-menu-panel]').forEach(function (el) { if (el !== p) el.classList.add('hidden'); });
                p.classList.toggle('hidden', open);
                b.setAttribute('aria-expanded', String(!open));
            });
        });
    }

    if (!window.__navbarDocInit) {
        window.__navbarDocInit = true;
        document.addEventListener('click', function (e) {
            document.querySelectorAll('[data-user-menu]').forEach(function (menu) {
                if (!menu.contains(e.target)) {
                    var p = menu.querySelector('[data-user-menu-panel]');
                    var b = menu.querySelector('[data-user-menu-btn]');
                    if (p) p.classList.add('hidden');
                    if (b) b.setAttribute('aria-expanded', 'false');
                }
            });
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('[data-user-menu-panel]').forEach(function (p) { p.classList.add('hidden'); });
                var mp = document.querySelector('[data-mobile-menu-panel]');
                var mb = document.querySelector('[data-mobile-menu-btn]');
                if (mp && !mp.classList.contains('hidden')) {
                    mp.classList.add('hidden');
                    if (mb) { mb.setAttribute('aria-expanded', 'false'); var io = mb.querySelector('[data-icon-open]'); var ic = mb.querySelector('[data-icon-close]'); if(io) io.classList.remove('hidden'); if(ic) ic.classList.add('hidden'); }
                }
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { initNavbar(document); });
    } else {
        initNavbar(document);
    }
})();
</script>
