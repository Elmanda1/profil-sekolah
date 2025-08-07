<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/profil-pengajar', function () {
    return view('profilPengajar');
});

Route::get('/profil-siswa', function () {
    return view('profilSiswa');
});

Route::get('/berita', function () {
    return view('berita');
});

Route::get('/prestasi', function () {
    return view('prestasi');
});
