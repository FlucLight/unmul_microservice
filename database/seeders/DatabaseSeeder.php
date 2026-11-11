<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tampung data siswa di sini (bisa hasil dari Excel/CSV)
        $dataSiswa = [
            [
                'name'        => 'Ahmad Rizky',
                'email'       => '0012345678@siswa.sekolah.sch.id',
                'nomer_induk' => '0012345678', // NISN / NIM
            ],
            [
                'name'        => 'Siti Aminah',
                'email'       => '0012345679@siswa.sekolah.sch.id',
                'nomer_induk' => '0012345679',
            ],
            // ... Masukkan data siswa lainnya di sini ...
        ];

        // 2. Pecah data per 200 baris (mencegah server overload/timeout)
        $chunks = array_chunk($dataSiswa, 200);

        foreach ($chunks as $chunk) {
            DB::transaction(function () use ($chunk) {
                foreach ($chunk as $siswa) {
                    User::create([
                        // Data Utama & Autentikasi
                        'name'                      => $siswa['name'],
                        'email'                     => $siswa['email'],
                        'email_verified_at'        => now(), // Otomatis terverifikasi saat di-seed
                        'password'                  => Hash::make($siswa['nomer_induk']), // Password = NISN/NIM
                        'nomer_induk'               => $siswa['nomer_induk'],
                        'role'                      => 'siswa',

                        // Kolom Fitur Bawaan Jetstream / Fortify (di-null kan)
                        'two_factor_secret'         => null,
                        'two_factor_recovery_codes' => null,
                        'two_factor_confirmed_at'   => null,
                        'remember_token'            => null,
                        'current_team_id'           => null,
                        'profile_photo_path'        => null,

                        // Timestamp dikelola otomatis oleh Eloquent
                    ]);
                }
            });
        }
    }
}