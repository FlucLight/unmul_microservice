<div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-sm">
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-slate-100">Informasi Akun</h3>
        <p class="text-slate-400 text-sm mt-1">Perbarui informasi profil, email/telepon, dan foto profil akun Anda.</p>
    </div>

    <form wire:submit="updateProfileInformation" class="space-y-6">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="space-y-3">
                <label class="block text-sm font-medium text-slate-300">Foto Profil</label>
                <input type="file" id="photo" class="hidden"
                       wire:model.live="photo"
                       x-ref="photo"
                       x-on:change="
                           photoName = $refs.photo.files[0].name;
                           const reader = new FileReader();
                           reader.onload = (e) => { photoPreview = e.target.result; };
                           reader.readAsDataURL($refs.photo.files[0]);
                       " />

                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="shrink-0">
                        <div class="mt-0" x-show="! photoPreview">
                            <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="w-20 h-20 rounded-full object-cover border-2 border-slate-700">
                        </div>
                        <div class="mt-0" x-show="photoPreview" style="display: none;">
                            <span class="block w-20 h-20 rounded-full bg-cover bg-no-repeat bg-center border-2 border-amber-500/70"
                                  x-bind:style="'background-image: url(\'' + photoPreview + '\');'"></span>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" x-on:click.prevent="$refs.photo.click()" class="inline-flex items-center justify-center bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-medium rounded-xl px-5 py-2.5 transition shadow-md shadow-orange-950/30 text-sm">
                            Pilih Foto Baru
                        </button>
                        @if ($this->user->profile_photo_path)
                            <button type="button" wire:click="deleteProfilePhoto" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-700 bg-slate-800/70 text-slate-200 hover:bg-slate-800 hover:border-slate-600 font-medium transition text-sm">
                                Hapus Foto
                            </button>
                        @endif
                    </div>
                </div>
                <x-input-error for="photo" class="mt-1 text-rose-400 text-sm" />
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label for="nomer_induk" class="block text-sm font-medium text-slate-300 mb-1.5">Nomor Induk (NIM/NIP)</label>
                <input id="nomer_induk" type="text" value="{{ $this->user->nomer_induk }}" disabled class="w-full bg-slate-950/70 border border-slate-700/70 text-slate-400 rounded-xl px-4 py-2.5 cursor-not-allowed" />
                <p class="text-xs text-slate-500 mt-1.5">Nomor induk digunakan untuk login dan tidak dapat diubah di sini.</p>
            </div>

            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-medium text-slate-300 mb-1.5">Nama Lengkap</label>
                <input id="name" type="text" wire:model="state.name" required autocomplete="name" class="w-full bg-slate-950 border border-slate-700/70 text-slate-100 placeholder-slate-500 rounded-xl px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition" />
                <x-input-error for="name" class="mt-1.5 text-rose-400 text-sm" />
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-300 mb-1.5">Email <span class="text-slate-500 font-normal">(opsional)</span></label>
                <input id="email" type="email" wire:model="state.email" autocomplete="email" placeholder="contoh@unmul.ac.id" class="w-full bg-slate-950 border border-slate-700/70 text-slate-100 placeholder-slate-500 rounded-xl px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition" />
                <x-input-error for="email" class="mt-1.5 text-rose-400 text-sm" />

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && $this->user->email && ! $this->user->hasVerifiedEmail())
                    <p class="text-sm mt-2 text-slate-300">
                        Alamat email Anda belum terverifikasi.
                        <button type="button" class="underline text-amber-400 hover:text-amber-300" wire:click.prevent="sendEmailVerification">Kirim ulang email verifikasi.</button>
                    </p>
                    @if ($this->verificationLinkSent)
                        <p class="mt-2 font-medium text-sm text-emerald-400">Tautan verifikasi baru telah dikirim ke email Anda.</p>
                    @endif
                @endif
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-slate-300 mb-1.5">Nomor Telepon <span class="text-slate-500 font-normal">(opsional)</span></label>
                <input id="phone" type="text" wire:model="state.phone" autocomplete="tel" placeholder="08xxxxxxxxxx" class="w-full bg-slate-950 border border-slate-700/70 text-slate-100 placeholder-slate-500 rounded-xl px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition" />
                <x-input-error for="phone" class="mt-1.5 text-rose-400 text-sm" />
            </div>
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 pt-2 border-t border-slate-800">
            <x-action-message class="text-sm text-emerald-400" on="saved">Tersimpan.</x-action-message>
            <button type="submit" wire:loading.attr="disabled" wire:target="photo" class="inline-flex items-center justify-center bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-medium rounded-xl px-5 py-2.5 transition shadow-md shadow-orange-950/30 disabled:opacity-60">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
