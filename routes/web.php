<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\KumpulTugasController;

// Halaman Utama - Welcome Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Group Route yang membutuhkan Login Auth
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('tugas.index');
    })->name('dashboard');

    // Halaman Manajemen & Lihat Tugas (Dosen, Mahasiswa, Admin)
    Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index');

    // Khusus DOSEN & ADMIN: Tambah, Edit, Hapus Tugas, Beri Nilai
    Route::middleware(['role:dosen,admin'])->group(function () {
        Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');
        Route::put('/tugas/{id}', [TugasController::class, 'update'])->name('tugas.update');
        Route::delete('/tugas/{id}', [TugasController::class, 'destroy'])->name('tugas.destroy');
        Route::patch('/kumpul-tugas/{id}/nilai', [KumpulTugasController::class, 'updateNilai'])->name('kumpul.nilai');
        Route::delete('/kumpul-tugas/{id}', [KumpulTugasController::class, 'destroy'])->name('kumpul.destroy');
    });

    // Khusus MAHASISWA & ADMIN: Kumpulkan Tugas (Link Drive)
    Route::middleware(['role:mahasiswa,admin'])->group(function () {
        Route::post('/kumpul-tugas', [KumpulTugasController::class, 'store'])->name('kumpul.store');
    });

});
