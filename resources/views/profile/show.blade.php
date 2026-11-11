<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-extrabold text-xl sm:text-2xl text-slate-900 dark:text-white leading-tight tracking-tight">
                    Profil Akun
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">Kelola informasi profil, keamanan, dan preferensi akun Anda.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 bg-slate-100 dark:bg-[#0b1220] min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Hero Profil -->
            @php $role = Auth::user()->role; @endphp
            <div class="relative bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-sm overflow-hidden">
                <div class="absolute top-5 right-5">
                    @if($role === 'admin')
                        <span class="px-3 py-1.5 bg-rose-500/15 text-rose-300 border border-rose-500/30 text-[10px] font-extrabold uppercase tracking-wider rounded-full">Admin</span>
                    @elseif($role === 'dosen')
                        <span class="px-3 py-1.5 bg-purple-500/15 text-purple-300 border border-purple-500/30 text-[10px] font-extrabold uppercase tracking-wider rounded-full">Dosen</span>
                    @else
                        <span class="px-3 py-1.5 bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 text-[10px] font-extrabold uppercase tracking-wider rounded-full">Mahasiswa</span>
                    @endif
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-5 pr-0 sm:pr-28">
                    <div class="shrink-0">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos() && Auth::user()->profile_photo_path)
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-20 h-20 sm:w-24 sm:h-24 rounded-full object-cover border-2 border-amber-500/80 shadow-lg">
                        @else
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-tr from-[#ff7700] to-amber-500 text-white font-extrabold text-2xl sm:text-3xl flex items-center justify-center border-2 border-amber-500/80 shadow-lg">
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-xl font-semibold text-slate-100 truncate">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-slate-400 mt-1">NIM/NIP: <span class="font-mono text-slate-300">{{ Auth::user()->nomer_induk }}</span></p>
                        <p class="text-sm text-slate-400 truncate">{{ Auth::user()->email ?? 'Email belum diatur' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                    <div class="bg-slate-950/60 border border-slate-800/80 rounded-xl p-4 flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">NIM / NIP</p>
                            <p class="text-sm font-medium text-slate-100 mt-0.5 break-all">{{ Auth::user()->nomer_induk }}</p>
                        </div>
                    </div>
                    <div class="bg-slate-950/60 border border-slate-800/80 rounded-xl p-4 flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Email</p>
                            <p class="text-sm font-medium text-slate-100 mt-0.5 truncate">{{ Auth::user()->email ?? 'Belum diatur' }}</p>
                        </div>
                    </div>
                    <div class="bg-slate-950/60 border border-slate-800/80 rounded-xl p-4 flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Telepon</p>
                            <p class="text-sm font-medium text-slate-100 mt-0.5 truncate">{{ Auth::user()->phone ?? 'Belum diatur' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <div class="profile-section">
                    @livewire('profile.update-profile-information-form')
                </div>
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="profile-section">
                    @livewire('profile.update-password-form')
                </div>
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="profile-section">
                    @livewire('profile.two-factor-authentication-form')
                </div>
            @endif

            <div class="profile-section">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="profile-section">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
