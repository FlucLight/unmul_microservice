<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;

use App\Http\Controllers\KumpulTugasController;

// Halaman Utama - Welcome Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Halaman Manajemen Tugas (Akses via /tugas)
Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index');
Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.store');
Route::put('/tugas/{id}', [TugasController::class, 'update'])->name('tugas.update');
Route::delete('/tugas/{id}', [TugasController::class, 'destroy'])->name('tugas.destroy');

// Pengumpulan Tugas & Penilaian (FastAPI 2)
Route::post('/kumpul-tugas', [KumpulTugasController::class, 'store'])->name('kumpul.store');
Route::patch('/kumpul-tugas/{id}/nilai', [KumpulTugasController::class, 'updateNilai'])->name('kumpul.nilai');
Route::delete('/kumpul-tugas/{id}', [KumpulTugasController::class, 'destroy'])->name('kumpul.destroy');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

