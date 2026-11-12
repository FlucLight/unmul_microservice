<div class="bg-slate-900 border border-rose-900/40 rounded-2xl p-6 shadow-sm">
    <div class="mb-5">
        <h3 class="text-lg font-semibold text-slate-100">Hapus Akun</h3>
        <p class="text-slate-400 text-sm mt-1">Hapus akun Anda secara permanen.</p>
    </div>

    <div class="space-y-4">
        <p class="text-sm text-slate-400 max-w-2xl">Setelah akun dihapus, seluruh data dan sumber daya terkait akan dihapus secara permanen. Pastikan Anda telah menyimpan data penting sebelum melanjutkan.</p>

        <div>
            <button type="button" wire:click="confirmUserDeletion" wire:loading.attr="disabled" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-medium transition shadow-sm">
                Hapus Akun
            </button>
        </div>

        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">Hapus Akun</x-slot>
            <x-slot name="content">
                <span class="text-slate-300">Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan. Masukkan kata sandi untuk konfirmasi.</span>
                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <input type="password" class="mt-1 block w-full sm:w-3/4 bg-slate-950 border border-slate-700/70 text-slate-100 placeholder-slate-500 rounded-xl px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition" autocomplete="current-password" placeholder="Kata sandi" x-ref="password" wire:model="password" wire:keydown.enter="deleteUser" />
                    <x-input-error for="password" class="mt-2 text-rose-400 text-sm" />
                </div>
            </x-slot>
            <x-slot name="footer">
                <button type="button" wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-700 bg-slate-800/70 text-slate-200 hover:bg-slate-800 font-medium transition">Batal</button>
                <button type="button" class="ms-3 inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-medium transition shadow-sm" wire:click="deleteUser" wire:loading.attr="disabled">Hapus Akun</button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>
