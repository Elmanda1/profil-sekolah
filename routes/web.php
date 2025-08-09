<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;


Route::get('/', function () {
    return view('frontend.home');
});

Route::get('/profil-pengajar', function () {
    return view('frontend.profilPengajar');
});

Route::get('/profil-siswa', function () {
    return view('frontend.profilSiswa');
});

Route::get('/berita', function () {
    return view('frontend.berita');
});

Route::get('/prestasi', function () {
    return view('frontend.prestasi');
});

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

});
