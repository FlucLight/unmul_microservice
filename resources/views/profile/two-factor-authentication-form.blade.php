<div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-sm">
    <div class="mb-5">
        <h3 class="text-lg font-semibold text-slate-100">Autentikasi Dua Faktor</h3>
        <p class="text-slate-400 text-sm mt-1">Tambahkan lapisan keamanan ekstra pada akun Anda menggunakan autentikasi dua faktor.</p>
    </div>

    <div class="space-y-4">
        <h4 class="text-base font-medium text-slate-200">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    Selesaikan pengaktifan autentikasi dua faktor.
                @else
                    Autentikasi dua faktor telah aktif.
                @endif
            @else
                Autentikasi dua faktor belum diaktifkan.
            @endif
        </h4>

        <p class="text-sm text-slate-400 max-w-2xl">Saat diaktifkan, Anda akan diminta memasukkan token acak yang aman saat login. Token dapat diperoleh dari aplikasi autentikator di ponsel Anda.</p>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="text-sm text-slate-300 max-w-2xl">
                    <p class="font-medium">
                        @if ($showingConfirmation)
                            Pindai kode QR berikut dengan aplikasi autentikator atau masukkan kunci pengaturan, lalu masukkan kode OTP yang dihasilkan.
                        @else
                            Autentikasi dua faktor aktif. Pindai kode QR berikut atau masukkan kunci pengaturan.
                        @endif
                    </p>
                </div>
                <div class="mt-2 p-3 inline-block bg-white rounded-xl">{!! $this->user->twoFactorQrCodeSvg() !!}</div>
                <div class="text-sm text-slate-300">
                    <p class="font-medium">Kunci Pengaturan: <span class="font-mono text-slate-100">{{ decrypt($this->user->two_factor_secret) }}</span></p>
                </div>
                @if ($showingConfirmation)
                    <div class="mt-2 max-w-sm">
                        <label for="code" class="block text-sm font-medium text-slate-300 mb-1.5">Kode</label>
                        <input id="code" type="text" name="code" inputmode="numeric" autofocus autocomplete="one-time-code" wire:model="code" wire:keydown.enter="confirmTwoFactorAuthentication" class="w-full bg-slate-950 border border-slate-700/70 text-slate-100 placeholder-slate-500 rounded-xl px-4 py-2.5 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none transition" />
                        <x-input-error for="code" class="mt-1.5 text-rose-400 text-sm" />
                    </div>
                @endif
            @endif

            @if ($showingRecoveryCodes)
                <div class="text-sm text-slate-300 max-w-2xl">
                    <p class="font-medium">Simpan kode pemulihan ini di tempat aman. Kode dapat digunakan untuk mengakses akun jika perangkat autentikator hilang.</p>
                </div>
                <div class="grid gap-1 max-w-xl mt-2 px-4 py-4 font-mono text-sm bg-slate-950 border border-slate-800 text-slate-100 rounded-xl">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="flex flex-wrap items-center gap-3 pt-2">
            @if (! $this->enabled)
                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <button type="button" wire:loading.attr="disabled" class="inline-flex items-center justify-center bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-medium rounded-xl px-5 py-2.5 transition shadow-md shadow-orange-950/30">Aktifkan</button>
                </x-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <button type="button" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-700 bg-slate-800/70 text-slate-200 hover:bg-slate-800 font-medium transition">Buat Ulang Kode Pemulihan</button>
                    </x-confirms-password>
                @elseif ($showingConfirmation)
                    <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                        <button type="button" wire:loading.attr="disabled" class="inline-flex items-center justify-center bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-medium rounded-xl px-5 py-2.5 transition shadow-md shadow-orange-950/30">Konfirmasi</button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showRecoveryCodes">
                        <button type="button" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-700 bg-slate-800/70 text-slate-200 hover:bg-slate-800 font-medium transition">Tampilkan Kode Pemulihan</button>
                    </x-confirms-password>
                @endif

                @if ($showingConfirmation)
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <button type="button" wire:loading.attr="disabled" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl border border-slate-700 bg-slate-800/70 text-slate-200 hover:bg-slate-800 font-medium transition">Batal</button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <button type="button" wire:loading.attr="disabled" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-medium transition shadow-sm">Nonaktifkan</button>
                    </x-confirms-password>
                @endif
            @endif
        </div>
    </div>
</div>
