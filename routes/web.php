<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\KelasController; 
use App\Http\Controllers\JurusanController; 

// Frontend Routes
Route::get('/', function () {
    return view('frontend.home');
})->name('frontend.home');

Route::get('/profil-pengajar', function () {
    return view('frontend.profilPengajar');
})->name('frontend.profil-pengajar');

Route::get('/profil-siswa', function () {
    return view('frontend.profilSiswa');
})->name('frontend.profil-siswa');

// Frontend Berita/Artikel Routes
Route::get('/berita', [ArtikelController::class, 'frontend'])->name('frontend.berita');
Route::get('/berita/{artikel:id_berita}', [ArtikelController::class, 'detail'])->name('frontend.berita.detail');

// Frontend Prestasi Routes
Route::get('/prestasi', [PrestasiController::class, 'frontend'])->name('frontend.prestasi');
Route::get('/prestasi/tahun/{year}', [PrestasiController::class, 'byYear'])->name('frontend.prestasi.byYear');

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', function () {
        // Hitung total data untuk dashboard
        $totalSiswa = \App\Models\Siswa::count();
        $totalGuru = \App\Models\Guru::count();
        $totalKelas = \App\Models\Kelas::count();
        $totalJurusan = \App\Models\Jurusan::count();
        $totalBerita = \App\Models\Artikel::count();
        $totalPrestasi = \App\Models\Prestasi::count();
        
        // Ambil data terbaru berdasarkan ID
        $siswaRecent = \App\Models\Siswa::with('kelas', 'sekolah')
            ->orderBy('id_siswa', 'desc')
            ->take(5)
            ->get();
        
        $guruRecent = \App\Models\Guru::with('sekolah')
            ->orderBy('id_guru', 'desc')
            ->take(5)
            ->get();
        
        $beritaRecent = \App\Models\Artikel::with('sekolah')
            ->orderBy('id_berita', 'desc')
            ->take(5)
            ->get();
        
        $prestasiRecent = \App\Models\Prestasi::with('sekolah')
            ->orderBy('id_prestasi', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalJurusan',
            'totalBerita',
            'totalPrestasi',
            'siswaRecent',
            'guruRecent',
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

    // Routes Kelas (Added)
    Route::resource('kelas', KelasController::class)->parameters([
        'kelas' => 'kelas:id_kelas'
    ]);
    
    // Additional route for assigning students to class
    Route::post('/kelas/{kelas}/assign-siswa', [KelasController::class, 'assignSiswa'])
        ->name('kelas.assign-siswa');

    // Routes Jurusan (Added)
    Route::resource('jurusan', JurusanController::class)->parameters([
        'jurusan' => 'jurusan:id_jurusan'
    ]);

    // Routes Berita/Artikel (Fixed naming)
    Route::resource('berita', ArtikelController::class)->parameters([
        'berita' => 'berita:id_berita'
    ]);

    // Routes Prestasi
    Route::resource('prestasi', PrestasiController::class)->parameters([
        'prestasi' => 'prestasi:id_prestasi'
    ]);
    
    // Data Export Routes (Optional)
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/siswa', [SiswaController::class, 'export'])->name('siswa');
        Route::get('/guru', [GuruController::class, 'export'])->name('guru');
        Route::get('/prestasi', [PrestasiController::class, 'export'])->name('prestasi');
    });
    
    // Bulk Actions (Optional)
    Route::prefix('bulk')->name('bulk.')->group(function () {
        Route::delete('/siswa', [SiswaController::class, 'bulkDelete'])->name('siswa.delete');
        Route::delete('/guru', [GuruController::class, 'bulkDelete'])->name('guru.delete');
        Route::delete('/prestasi', [PrestasiController::class, 'bulkDelete'])->name('prestasi.delete');
    });

    // API-like routes for AJAX calls (Optional)
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/siswa/search', [SiswaController::class, 'search'])->name('siswa.search');
        Route::get('/guru/search', [GuruController::class, 'search'])->name('guru.search');
        Route::get('/kelas/{kelas}/siswa', [KelasController::class, 'getSiswa'])->name('kelas.siswa');
        Route::get('/jurusan/{jurusan}/kelas', [JurusanController::class, 'getKelas'])->name('jurusan.kelas');
    });
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});