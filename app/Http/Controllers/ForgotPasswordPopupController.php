<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordPopupController extends Controller
{
    /**
     * Kirim kode verifikasi reset password ke email setelah validasi Email dan NIM/NIP.
     */
    public function sendCode(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'nomer_induk' => ['required', 'string'],
        ], [
            'email.required' => 'Kolom email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'nomer_induk.required' => 'Nomor Induk (NIM / NIP) wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Alamat email tidak terdaftar dalam sistem.',
            ], 404);
        }

        // Cek kecocokan nomor induk (NIM / NIP)
        if (trim($user->nomer_induk) !== trim($request->nomer_induk)) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor Induk (NIM/NIP) tidak cocok dengan akun email ini.',
            ], 422);
        }

        // Buat 6-digit kode verifikasi acak
        $code = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan ke tabel password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($code),
                'created_at' => Carbon::now(),
            ]
        );

        // Catat ke log sistem untuk backup / keperluan testing
        Log::info("Kode verifikasi reset password untuk {$user->email} ({$user->nomer_induk}): {$code}");

        // Coba kirimkan email jika mail driver aktif
        try {
            if (config('mail.default') && config('mail.default') !== 'null') {
                Mail::raw("Halo {$user->name},\n\nBerikut adalah Kode Verifikasi Reset Password akun LMS Fakultas Teknik UNMUL Anda:\n\nKODE VERIFIKASI: {$code}\n\nKode ini berlaku selama 60 menit. Jangan berikan kode ini kepada siapapun.\n\nSalam,\nLMS Fakultas Teknik UNMUL", function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Kode Verifikasi Reset Password — LMS FT UNMUL');
                });
            }
        } catch (\Throwable $e) {
            Log::warning("Gagal mengirim email verifikasi ke {$user->email}: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => "Kode verifikasi 6-digit telah dikirim ke {$user->email}. Silakan cek kotak masuk/spam Anda.",
            'code' => app()->environment('local') ? $code : null, // Memudahkan pengujian saat di localhost
        ]);
    }

    /**
     * Verifikasi kode saja (langkah 2), sebelum menampilkan form password baru.
     */
    public function verifyCode(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'nomer_induk' => ['required', 'string'],
            'code' => ['required', 'string', 'size:6'],
        ], [
            'code.required' => 'Kode verifikasi 6-digit wajib dimasukkan.',
            'code.size' => 'Kode verifikasi harus berjumlah 6 digit.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || trim($user->nomer_induk) !== trim($request->nomer_induk)) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengguna tidak valid atau tidak cocok.',
            ], 422);
        }

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan verifikasi tidak ditemukan. Silakan klik "Kirim Verifikasi" terlebih dahulu.',
            ], 422);
        }

        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Kode verifikasi telah kadaluarsa. Silakan minta kode baru.',
            ], 422);
        }

        if (!Hash::check($request->code, $record->token) && $request->code !== $record->token) {
            return response()->json([
                'success' => false,
                'message' => 'Kode verifikasi yang Anda masukkan salah. Periksa kembali email Anda.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kode verifikasi benar! Silakan buat password baru Anda.',
        ]);
    }

    /**
     * Verifikasi kode dan atur ulang password baru.
     */
    public function resetWithCode(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'nomer_induk' => ['required', 'string'],
            'code' => ['required', 'string', 'size:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'Kolom email wajib diisi.',
            'nomer_induk.required' => 'Nomor Induk wajib diisi.',
            'code.required' => 'Kode verifikasi 6-digit wajib dimasukkan.',
            'code.size' => 'Kode verifikasi harus berjumlah 6 digit.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok dengan password baru.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || trim($user->nomer_induk) !== trim($request->nomer_induk)) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengguna tidak valid atau tidak cocok.',
            ], 422);
        }

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Permintaan verifikasi tidak ditemukan. Silakan klik "Kirim Verifikasi" terlebih dahulu.',
            ], 422);
        }

        // Cek kadaluarsa (60 menit)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Kode verifikasi telah kadaluarsa. Silakan minta kode baru.',
            ], 422);
        }

        // Cek kesesuaian kode token
        if (!Hash::check($request->code, $record->token) && $request->code !== $record->token) {
            return response()->json([
                'success' => false,
                'message' => 'Kode verifikasi yang Anda masukkan salah. Periksa kembali email Anda.',
            ], 422);
        }

        // Update password pengguna
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        // Hapus token yang sudah terpakai
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password baru Anda berhasil disimpan! Silakan masuk dengan password baru.',
        ]);
    }
}
