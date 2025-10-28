    <?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\SiswaController;
    use App\Http\Controllers\GuruController;
    use App\Http\Controllers\ArtikelController;
    use App\Http\Controllers\PrestasiController;
    use App\Http\Controllers\KelasController; 
    use App\Http\Controllers\JurusanController; 

    // Frontend Routes
    Route::get('/', [PrestasiController::class, 'home'])->name('frontend.home');

    Route::get('/profil-pengajar', [GuruController::class, 'profilPengajar'])
        ->name('frontend.profil-pengajar');

    Route::get('/profil-siswa', [SiswaController::class, 'profilSiswa'])
        ->name('frontend.profil-siswa');

    // Frontend Berita/Artikel Routes
    Route::get('/berita', [ArtikelController::class, 'berita'])->name('frontend.berita');
    Route::get('/berita/{id}', [ArtikelController::class, 'detail'])->name('frontend.berita.detail');

    // Frontend Prestasi Routes
    Route::get('/prestasi', [PrestasiController::class, 'prestasi'])->name('frontend.prestasi');
    Route::get('/prestasi/tahun/{year}', [PrestasiController::class, 'byYear'])->name('frontend.prestasi.byYear');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard
        Route::get('/', function () {
            $totalSiswa = \App\Models\Siswa::count();
            $totalGuru = \App\Models\Guru::count();
            $totalKelas = \App\Models\Kelas::count();
            $totalJurusan = \App\Models\Jurusan::count();
            $totalBerita = \App\Models\Artikel::count();
            $totalPrestasi = \App\Models\Prestasi::count();
            
            $siswaRecent = \App\Models\Siswa::with('kelas', 'sekolah')
                ->orderBy('id_siswa', 'desc')
                ->take(5)
                ->get();
            
            $guruRecent = \App\Models\Guru::with('sekolah')
                ->orderBy('id_guru', 'desc')
                ->take(5)
                ->get();
            
            $beritaRecent = \App\Models\Artikel::with('sekolah')
                ->orderBy('id_artikel', 'desc')
                ->take(5)
                ->get();
            
            $prestasiRecent = \App\Models\Prestasi::with('sekolah')
                ->orderBy('id_prestasi', 'desc')
                ->take(5)
                ->get();

            $siswaGender = \App\Models\Siswa::selectRaw('jenis_kelamin, count(*) as total')
                ->groupBy('jenis_kelamin')
                ->pluck('total', 'jenis_kelamin')
                ->all();

            $prestasiPerYear = \App\Models\Prestasi::selectRaw('YEAR(tanggal) as year, count(*) as total')
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->pluck('total', 'year')
                ->all();

            $guruPerSekolah = \App\Models\Guru::selectRaw('tb_sekolah.nama_sekolah, count(tb_guru.id_guru) as total')
                ->join('tb_sekolah', 'tb_guru.id_sekolah', '=', 'tb_sekolah.id_sekolah')
                ->groupBy('tb_sekolah.nama_sekolah')
                ->pluck('total', 'nama_sekolah')
                ->all();
            
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
                'prestasiRecent',
                'siswaGender',
                'prestasiPerYear',
                'guruPerSekolah'
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

        // Routes Kelas
        Route::resource('kelas', KelasController::class)->parameters([
            'kelas' => 'kelas:id_kelas'
        ]);
        Route::post('/kelas/{kelas}/assign-siswa', [KelasController::class, 'assignSiswa'])
            ->name('kelas.assign-siswa');

        // Routes Jurusan
        Route::resource('jurusan', JurusanController::class)->parameters([
            'jurusan' => 'jurusan:id_jurusan'
        ]);

        // Routes Berita/Artikel
        Route::resource('berita', ArtikelController::class);

        // Routes Prestasi
        Route::resource('prestasi', PrestasiController::class)->parameters([
            'prestasi' => 'prestasi:id_prestasi'
        ]);
        
        // Data Export Routes
        Route::prefix('export')->name('export.')->group(function () {
            Route::get('/siswa', [SiswaController::class, 'export'])->name('siswa');
            Route::get('/guru', [GuruController::class, 'export'])->name('guru');
            Route::get('/prestasi', [PrestasiController::class, 'export'])->name('prestasi');
        });
        
        // Bulk Actions
        Route::prefix('bulk')->name('bulk.')->group(function () {
            Route::delete('/siswa', [SiswaController::class, 'bulkDelete'])->name('siswa.delete');
            Route::delete('/guru', [GuruController::class, 'bulkDelete'])->name('guru.delete');
            Route::delete('/prestasi', [PrestasiController::class, 'bulkDelete'])->name('prestasi.delete');
        });
    });

    // External API Routes (Sanctum Protected)
    Route::prefix('api')->name('api.')->group(function () {
        Route::prefix('v1')->name('v1.')->middleware('auth:sanctum')->group(function () {
            // Akun API routes
            Route::get('/akun', [App\Http\Controllers\AkunApiController::class, 'getAkunDetails'])->name('akun');
            Route::post('/gantipw', [App\Http\Controllers\AkunApiController::class, 'changePassword'])->name('gantipw');

            // Tabungan API routes
            Route::get('/tabungan/history', [App\Http\Controllers\TabunganController::class, 'history'])->name('tabungan.history');
            Route::get('/tabungan/history/latest', [App\Http\Controllers\TabunganController::class, 'latestHistory'])->name('tabungan.history.latest');

            // Transactions API routes
            Route::get('/transactions', [App\Http\Controllers\TabunganController::class, 'history'])->name('transactions.index');
        });
    });

    // Flutter API Routes
    Route::prefix('flutterapi')->group(function () {
        // Public routes
        Route::post('/auth/login', [App\Http\Controllers\Flutter\AuthController::class, 'login']);
        Route::get('/test', function () {
            return response()->json([
                'success' => true,
                'message' => 'Flutter API is working',
                'timestamp' => now()->toDateTimeString()
            ]);
        });

        // Protected routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/auth/logout', [App\Http\Controllers\Flutter\AuthController::class, 'logout']);
            Route::get('/akun', [App\Http\Controllers\Flutter\AkunController::class, 'getAkun']);
            Route::get('/profile', [App\Http\Controllers\Flutter\AuthController::class, 'profile']);
            Route::post('/gantipw', [App\Http\Controllers\Flutter\AkunController::class, 'changePassword']);
            
            Route::prefix('tabungan')->group(function () {
                Route::get('/history', [App\Http\Controllers\Flutter\TabunganController::class, 'history']);
                Route::get('/history/latest', [App\Http\Controllers\Flutter\TabunganController::class, 'latestHistory']);
                Route::get('/saldo', [App\Http\Controllers\Flutter\TabunganController::class, 'getSaldo']);
                Route::get('/income-expenses', [App\Http\Controllers\Flutter\TabunganController::class, 'getIncomeExpenses']);
            });
        });
    });

    Route::fallback(function () {
        return response()->view('errors.404', [], 404);
    });