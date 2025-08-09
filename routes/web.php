<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PrestasiController;

// Frontend Routes
Route::get('/', function () {
    return view('frontend.home');
});

// Update route profil-pengajar untuk menggunakan controller
Route::get('/profil-pengajar', [GuruController::class, 'frontend'])->name('guru.profiles');

Route::get('/profil-siswa', [SiswaController::class, 'frontend'])->name('siswa.profiles');

// Frontend Berita Routes
Route::get('/berita', [BeritaController::class, 'frontend'])->name('frontend.berita');
Route::get('/berita/{id}', [BeritaController::class, 'detail'])->name('frontend.berita.detail');

// Frontend Prestasi Routes
Route::get('/prestasi', [PrestasiController::class, 'frontend'])->name('frontend.prestasi');
Route::get('/prestasi/tahun/{year}', [PrestasiController::class, 'byYear'])->name('frontend.prestasi.byYear');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    
// Dashboard
Route::get('/', function () {
    // Hitung total data untuk dashboard
    $totalSiswa = \App\Models\Siswa::count();
    $totalGuru = \App\Models\Guru::count();
    $totalBerita = \App\Models\Berita::count();
    $totalPrestasi = \App\Models\Prestasi::count();
    
    // Ambil data terbaru berdasarkan ID (bukan created_at)
    $siswaRecent = \App\Models\Siswa::orderBy('id_siswa', 'desc')->take(5)->get();
    $beritaRecent = \App\Models\Berita::orderBy('id_berita', 'desc')->take(5)->get();
    $prestasiRecent = \App\Models\Prestasi::orderBy('id_prestasi', 'desc')->take(5)->get();
    
    return view('admin.dashboard', compact(
        'totalSiswa',
        'totalGuru', 
        'totalBerita',
        'totalPrestasi',
        'siswaRecent',
        'beritaRecent',
        'prestasiRecent'
    ));
})->name('dashboard');

// Routes Siswa
Route::resource('siswa', SiswaController::class)->parameters([
    'siswa' => 'siswa:id_siswa'
]);

// Routes Guru
Route::resource('guru', GuruController::class)->parameters([
    'guru' => 'guru:id_guru'
]);

// Routes Berita
Route::resource('berita', BeritaController::class)->parameters([
    'berita' => 'berita:id_berita'
]);

// Routes Prestasi
Route::resource('prestasi', PrestasiController::class)->parameters([
    'prestasi' => 'prestasi:id_prestasi'
]);
});