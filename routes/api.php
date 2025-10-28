<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\ArtikelController;

// Pastikan semua API route di sini TIDAK pakai prefix 'admin' lagi
Route::prefix('v1')->group(function () {
    // Students API
    Route::get('/students', [SiswaController::class, 'index'])->name('api.v1.students.index');
    Route::post('/students', [SiswaController::class, 'store'])->name('api.v1.students.store');
    Route::get('/students/{siswa}', [SiswaController::class, 'show'])->name('api.v1.students.show');
    Route::put('/students/{siswa}', [SiswaController::class, 'update'])->name('api.v1.students.update');
    Route::delete('/students/{siswa}', [SiswaController::class, 'destroy'])->name('api.v1.students.destroy');

    // Gurus API
    Route::get('/gurus', [GuruController::class, 'index'])->name('api.v1.gurus.index');

    // Kelas API
    Route::get('/kelas', [KelasController::class, 'index'])->name('api.v1.kelas.index');
    Route::get('/kelas/{kelas}/siswa', [KelasController::class, 'getSiswa'])->name('api.v1.kelas.siswa');

    // Jurusan API
    Route::get('/jurusan', [JurusanController::class, 'index'])->name('api.v1.jurusan.index');

    // Artikel API
    Route::get('/berita', [ArtikelController::class, 'getBeritaJson'])->name('api.v1.berita.index');
});
