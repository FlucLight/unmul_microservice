<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\KumpulTugasController;
use App\Http\Controllers\ModulController;

use App\Http\Controllers\ForgotPasswordPopupController;
use App\Http\Controllers\Admin\UserManagementController;

// Halaman Utama - Welcome Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route Khusus Pop-Up Lupa Password (AJAX)
Route::post('/forgot-password/send-code', [ForgotPasswordPopupController::class, 'sendCode'])->name('password.popup.send_code');
Route::post('/forgot-password/verify-code', [ForgotPasswordPopupController::class, 'verifyCode'])->name('password.popup.verify_code');
Route::post('/forgot-password/reset-with-code', [ForgotPasswordPopupController::class, 'resetWithCode'])->name('password.popup.reset_with_code');


// Group Route yang membutuhkan Login Auth
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('tugas.index');
    })->name('dashboard');

    // Halaman Lihat Tugas & Modul Kuliah (Dosen, Mahasiswa, Admin)
    Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index');
    Route::get('/modul', [ModulController::class, 'index'])->name('modul.index');

    // Khusus DOSEN & ADMIN: CRUD Tugas, Beri Nilai, & CRUD Modul Kuliah
    Route::middleware(['role:dosen,admin'])->group(function () {
        // Tugas
        Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');
        Route::put('/tugas/{id}', [TugasController::class, 'update'])->name('tugas.update');
        Route::delete('/tugas/{id}', [TugasController::class, 'destroy'])->name('tugas.destroy');
        Route::patch('/kumpul-tugas/{id}/nilai', [KumpulTugasController::class, 'updateNilai'])->name('kumpul.nilai');
        Route::delete('/kumpul-tugas/{id}', [KumpulTugasController::class, 'destroy'])->name('kumpul.destroy');

        // Modul Kuliah (FastAPI 3 - Port 8002)
        Route::post('/modul', [ModulController::class, 'store'])->name('modul.store');
        Route::put('/modul/{id}', [ModulController::class, 'update'])->name('modul.update');
        Route::delete('/modul/{id}', [ModulController::class, 'destroy'])->name('modul.destroy');
    });

    // Khusus MAHASISWA & ADMIN: Kumpulkan Tugas (Link Drive)
    Route::middleware(['role:mahasiswa,admin'])->group(function () {
        Route::post('/kumpul-tugas', [KumpulTugasController::class, 'store'])->name('kumpul.store');
    });

    // Khusus ADMIN: Manajemen Pengguna (Daftarkan Mahasiswa/Dosen via NIM/NIP)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/pengguna', [UserManagementController::class, 'index'])->name('admin.pengguna');
        Route::post('/admin/pengguna', [UserManagementController::class, 'store'])->name('admin.pengguna.store');
        Route::put('/admin/pengguna/{id}', [UserManagementController::class, 'update'])->name('admin.pengguna.update');
        Route::delete('/admin/pengguna/{id}', [UserManagementController::class, 'destroy'])->name('admin.pengguna.destroy');
    });

});
