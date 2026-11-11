<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function update(User $user, array $input): void
    {
        $current = (string) ($input['current_password'] ?? '');
        $currentValid = false;

        // Cocokkan dengan password di tabel users
        if ($current !== '' && Hash::check($current, $user->password)) {
            $currentValid = true;
        }

        // Jika tidak cocok, coba cocokkan dengan sumber cek_nim (mahasiswa)
        if (!$currentValid && $current !== '' && $user->nomer_induk) {
            try {
                $nim = is_numeric($user->nomer_induk) ? (int) $user->nomer_induk : $user->nomer_induk;
                $cek = DB::connection('cek_nim')->table('modul')->where('nim', $nim)->first();
                $cekPassword = $cek && isset($cek->password) ? trim((string) $cek->password) : null;
                if ($cekPassword !== null && hash_equals($cekPassword, $current)) {
                    $currentValid = true;
                }
            } catch (\Throwable $e) {
                // abaikan, akan gagal validasi di bawah jika tetap tidak valid
            }
        }

        if (!$currentValid) {
            throw ValidationException::withMessages([
                'current_password' => [__('Password saat ini tidak sesuai.')],
            ])->errorBag('updatePassword');
        }

        Validator::make($input, [
            'password' => $this->passwordRules(),
        ])->validateWithBag('updatePassword');

        $newPassword = (string) $input['password'];

        $user->forceFill([
            'password' => Hash::make($newPassword),
        ])->save();

        // Sinkronkan ke database cek_nim jika NIM terdaftar di sana (agar login via cek_nim tetap konsisten)
        if ($user->nomer_induk) {
            try {
                $nim = is_numeric($user->nomer_induk) ? (int) $user->nomer_induk : $user->nomer_induk;
                DB::connection('cek_nim')->table('modul')->where('nim', $nim)->update([
                    'password' => $newPassword,
                ]);
            } catch (\Throwable $e) {
                // abaikan jika koneksi/tabel tidak tersedia
            }
        }
    }
}
