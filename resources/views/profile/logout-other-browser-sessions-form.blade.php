<div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-sm">
    <div class="mb-5">
        <h3 class="text-lg font-semibold text-slate-100">Sesi Perangkat</h3>
        <p class="text-slate-400 text-sm mt-1">Kelola dan keluar dari sesi aktif Anda di browser atau perangkat lain.</p>
    </div>

    <div class="space-y-4">
        <p class="text-sm text-slate-400 max-w-2xl">Jika perlu, Anda dapat keluar dari semua sesi browser lain di seluruh perangkat. Jika merasa akun Anda telah disusupi, segera perbarui kata sandi.</p>

        @if (count($this->sessions) > 0)
            <div class="mt-2 space-y-4">
                @foreach ($this->sessions as $session)
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-950/60 border border-slate-800/80">
                        <div class="text-slate-500">
                            @if ($session->agent->isDesktop())
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>
                            @endif
                        </div>
                        <div>
                            <div class="text-sm text-slate-200 font-medium">{{ $session->agent->platform() ? $session->agent->platform() : 'Tidak diketahui' }} — {{ $session->agent->browser() ? $session->agent->browser() : 'Tidak diketahui' }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">
                                {{ $session->ip_address }},
                                @if ($session->is_current_device)
                                    <span class="text-emerald-400 font-semibold">Perangkat ini</span>
                                @else
                                    Terakhir aktif {{ $session->last_active }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex flex-wrap items-center gap-3 pt-2">
            <button type="button" wire:click="confirmLogout" wire:loading.attr="disabled" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-700 bg-slate-800/70 text-slate-200 hover:bg-slate-800 font-medium transition">
                Keluar dari Sesi Browser Lain
            </button>
            <x-action-message class="text-sm text-emerald-400" on="loggedOut">Selesai.</x-action-message>
        </div>

        <x-dialog-modal wire:model.live="confirmingLogout">
            <x-slot name="title">Keluar dari Sesi Browser Lain</x-slot>
            <x-slot name="content">
                <span class="text-slate-300">Masukkan kata sandi Anda untuk mengonfirmasi keluar dari semua sesi browser lain di perangkat Anda.</span>
                <div class="mt-4" x-data="{}" x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                    <input type="password" class="mt-1 block w-full sm:w-3/4 bg-slate-950 border border-slate-700/70 text-slate-100 placeholder-slate-500 rounded-xl px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition" autocomplete="current-password" placeholder="Kata sandi" x-ref="password" wire:model="password" wire:keydown.enter="logoutOtherBrowserSessions" />
                    <x-input-error for="password" class="mt-2 text-rose-400 text-sm" />
                </div>
            </x-slot>
            <x-slot name="footer">
                <button type="button" wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-700 bg-slate-800/70 text-slate-200 hover:bg-slate-800 font-medium transition">Batal</button>
                <button type="button" class="ms-3 inline-flex items-center justify-center bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-medium rounded-xl px-5 py-2.5 transition shadow-md shadow-orange-950/30" wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled">Keluar Sesi Lain</button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>
