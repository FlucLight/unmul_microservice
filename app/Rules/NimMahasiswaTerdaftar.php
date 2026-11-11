<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Memastikan NIM terdaftar pada database mahasiswa (API Cek NIM - Port 8003)
 * sebelum akun Mahasiswa dapat dibuat. Diterapkan saat Admin mendaftarkan
 * akun Mahasiswa melalui menu Manajemen Akun, serta pada action registrasi
 * mandiri jika suatu saat fitur tersebut diaktifkan kembali.
 */
class NimMahasiswaTerdaftar implements Rule
{
    /**
     * Pesan kesalahan yang dapat berubah tergantung penyebab kegagalan.
     *
     * @var string|null
     */
    protected $dynamicMessage;

    /**
     * Menentukan apakah aturan validasi lulus.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $response = Http::timeout(3)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . config('services.cek_nim.key'),
                    'Accept' => 'application/json',
                ])
                ->get(config('services.cek_nim.url') . '/cek-nim/' . urlencode((string) $value));

            if ($response->successful()) {
                return (bool) ($response->json('valid') ?? false);
            }

            // 422: NIM bukan angka valid, sehingga pasti tidak terdaftar.
            if ($response->status() === 422) {
                return false;
            }

            Log::error('API Cek NIM merespons dengan status: ' . $response->status());
        } catch (\Exception $e) {
            Log::error('Koneksi ke API Cek NIM gagal: ' . $e->getMessage());
        }

        // Gagal-ditutup (fail closed): tanpa konfirmasi dari API, registrasi ditolak.
        $this->dynamicMessage = 'Sistem tidak dapat memverifikasi NIM Anda saat ini. Coba beberapa saat lagi atau hubungi Admin/Operator Fakultas.';

        return false;
    }

    /**
     * Pesan kesalahan validasi.
     *
     * @return string
     */
    public function message()
    {
        return $this->dynamicMessage
            ?? 'NIM tidak terdaftar pada database mahasiswa. Registrasi hanya untuk mahasiswa aktif.';
    }
}
