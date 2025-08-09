<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/admin/data-siswa', function () {
    return view('admin.data-siswa');
})->name('admin.data-siswa');

Route::get('/admin/data-guru', function () {
    return view('admin.data-guru');
})->name('admin.data-guru');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
});

