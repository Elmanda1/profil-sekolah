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
    return view('admin.dashboard', ['title' => 'Dashboard']);
});

