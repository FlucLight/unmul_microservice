<div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-sm">
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-slate-100">Ubah Kata Sandi</h3>
        <p class="text-slate-400 text-sm mt-1">Pastikan akun Anda menggunakan kata sandi yang kuat dan unik untuk menjaga keamanan.</p>
    </div>

    <form wire:submit="updatePassword" class="space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label for="current_password" class="block text-sm font-medium text-slate-300 mb-1.5">Kata Sandi Saat Ini</label>
                <input id="current_password" type="password" wire:model="state.current_password" autocomplete="current-password" class="w-full bg-slate-950 border border-slate-700/70 text-slate-100 placeholder-slate-500 rounded-xl px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition" placeholder="Masukkan kata sandi saat ini" />
                <x-input-error for="current_password" class="mt-1.5 text-rose-400 text-sm" />
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-slate-300 mb-1.5">Kata Sandi Baru</label>
                <input id="password" type="password" wire:model="state.password" autocomplete="new-password" class="w-full bg-slate-950 border border-slate-700/70 text-slate-100 placeholder-slate-500 rounded-xl px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition" placeholder="Kata sandi baru" />
                <x-input-error for="password" class="mt-1.5 text-rose-400 text-sm" />
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-1.5">Konfirmasi Kata Sandi</label>
                <input id="password_confirmation" type="password" wire:model="state.password_confirmation" autocomplete="new-password" class="w-full bg-slate-950 border border-slate-700/70 text-slate-100 placeholder-slate-500 rounded-xl px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition" placeholder="Ulangi kata sandi baru" />
                <x-input-error for="password_confirmation" class="mt-1.5 text-rose-400 text-sm" />
            </div>
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 pt-2 border-t border-slate-800">
            <x-action-message class="text-sm text-emerald-400" on="saved">Tersimpan.</x-action-message>
            <button type="submit" class="inline-flex items-center justify-center bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-medium rounded-xl px-5 py-2.5 transition shadow-md shadow-orange-950/30">
                Simpan Kata Sandi
            </button>
        </div>
    </form>
</div>
