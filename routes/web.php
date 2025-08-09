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

Route::get('/profil-pengajar', function () {
    return view('frontend.profilPengajar');
});

Route::get('/profil-siswa', function () {
    return view('frontend.profilSiswa');
});

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
    return view('admin.dashboard');
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