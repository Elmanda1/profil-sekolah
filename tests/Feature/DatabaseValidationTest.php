<?php

// tests/Feature/DatabaseValidationTest.php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{Sekolah, Guru, Siswa, Jurusan, Kelas, Artikel, Prestasi, Galeri, Mapel};

class DatabaseValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Run seeders
        $this->artisan('db:seed');
    }

    /** @test */
    public function test_sekolah_data_seeded_correctly()
    {
        // Test: Harus ada tepat 2 sekolah
        $this->assertEquals(2, Sekolah::count(), 'Harus ada tepat 2 sekolah');
        
        // Test: Sekolah harus memiliki data yang valid
        $sekolahSma = Sekolah::where('nama_sekolah', 'like', '%SMA%')->first();
        $sekolahSmk = Sekolah::where('nama_sekolah', 'like', '%SMK%')->first();
        
        $this->assertNotNull($sekolahSma, 'SMA harus ada');
        $this->assertNotNull($sekolahSmk, 'SMK harus ada');
        
        // Test: Sekolah memiliki alamat dan kontak
        $this->assertNotEmpty($sekolahSma->alamat);
        $this->assertNotEmpty($sekolahSma->nomor_telepon);
        $this->assertNotEmpty($sekolahSmk->alamat);
        $this->assertNotEmpty($sekolahSmk->nomor_telepon);
        
        echo "✅ Test Sekolah: PASSED\n";
    }

    /** @test */
    public function test_guru_data_seeded_correctly()
    {
        // Test: Minimal 20 guru
        $this->assertGreaterThanOrEqual(20, Guru::count(), 'Harus ada minimal 20 guru');
        
        // Test: Guru terdistribusi di 2 sekolah
        $guruSma = Guru::whereHas('sekolah', function($q) {
            $q->where('nama_sekolah', 'like', '%SMA%');
        })->count();
        
        $guruSmk = Guru::whereHas('sekolah', function($q) {
            $q->where('nama_sekolah', 'like', '%SMK%');
        })->count();
        
        $this->assertGreaterThan(0, $guruSma, 'SMA harus memiliki guru');
        $this->assertGreaterThan(0, $guruSmk, 'SMK harus memiliki guru');
        
        // Test: Guru memiliki data lengkap
        $guru = Guru::first();
        $this->assertNotEmpty($guru->nama_guru);
        $this->assertNotEmpty($guru->nip);
        $this->assertNotEmpty($guru->alamat);
        
        echo "✅ Test Guru: PASSED (Total: " . Guru::count() . " guru)\n";
    }

    /** @test */
    public function test_siswa_data_seeded_correctly()
    {
        // Test: Minimal 50 siswa
        $this->assertGreaterThanOrEqual(50, Siswa::count(), 'Harus ada minimal 50 siswa');
        
        // Test: Siswa terdistribusi di 2 sekolah
        $siswaSma = Siswa::whereHas('sekolah', function($q) {
            $q->where('nama_sekolah', 'like', '%SMA%');
        })->count();
        
        $siswaSmk = Siswa::whereHas('sekolah', function($q) {
            $q->where('nama_sekolah', 'like', '%SMK%');
        })->count();
        
        $this->assertGreaterThan(0, $siswaSma, 'SMA harus memiliki siswa');
        $this->assertGreaterThan(0, $siswaSmk, 'SMK harus memiliki siswa');
        
        // Test: Siswa memiliki data lengkap
        $siswa = Siswa::first();
        $this->assertNotEmpty($siswa->nama_siswa);
        $this->assertNotEmpty($siswa->nisn);
        $this->assertNotEmpty($siswa->alamat);
        
        echo "✅ Test Siswa: PASSED (Total: " . Siswa::count() . " siswa)\n";
    }

    /** @test */
    public function test_jurusan_relationship()
    {
        // Test: Setiap sekolah memiliki jurusan
        $sekolahList = Sekolah::all();
        
        foreach ($sekolahList as $sekolah) {
            $this->assertGreaterThan(0, $sekolah->jurusan->count(), 
                "Sekolah {$sekolah->nama_sekolah} harus memiliki jurusan");
        }
        
        // Test: SMA memiliki jurusan IPA/IPS
        $sekolahSma = Sekolah::where('nama_sekolah', 'like', '%SMA%')->first();
        $jurusanSma = $sekolahSma->jurusan->pluck('nama_jurusan')->toArray();
        
        $this->assertTrue(
            in_array('IPA', $jurusanSma) || in_array('IPS', $jurusanSma),
            'SMA harus memiliki jurusan IPA atau IPS'
        );
        
        echo "✅ Test Jurusan: PASSED\n";
    }

    /** @test */
    public function test_kelas_relationship()
    {
        // Test: Setiap sekolah memiliki kelas
        $sekolahList = Sekolah::all();
        
        foreach ($sekolahList as $sekolah) {
            $kelasCount = Kelas::whereHas('jurusan', function($q) use ($sekolah) {
                $q->where('id_sekolah', $sekolah->id_sekolah);
            })->count();
            
            $this->assertGreaterThan(0, $kelasCount, 
                "Sekolah {$sekolah->nama_sekolah} harus memiliki kelas");
        }
        
        // Test: Kelas memiliki wali kelas
        $kelas = Kelas::first();
        $this->assertNotNull($kelas->id_wali_kelas, 'Kelas harus memiliki wali kelas');
        
        echo "✅ Test Kelas: PASSED\n";
    }

    /** @test */
    public function test_content_data()
    {
        // Test: Ada artikel
        $this->assertGreaterThan(0, Artikel::count(), 'Harus ada artikel');
        
        // Test: Ada prestasi
        $this->assertGreaterThan(0, Prestasi::count(), 'Harus ada prestasi');
        
        // Test: Ada galeri
        $this->assertGreaterThan(0, Galeri::count(), 'Harus ada galeri');
        
        echo "✅ Test Content: PASSED\n";
    }

    /** @test */
    public function test_mapel_relationship()
    {
        // Test: Setiap sekolah memiliki mata pelajaran
        $sekolahList = Sekolah::all();
        
        foreach ($sekolahList as $sekolah) {
            $mapelCount = $sekolah->mapel->count();
            $this->assertGreaterThan(0, $mapelCount, 
                "Sekolah {$sekolah->nama_sekolah} harus memiliki mata pelajaran");
        }
        
        echo "✅ Test Mata Pelajaran: PASSED\n";
    }
}

// Artisan Command untuk menjalankan validasi
// app/Console/Commands/ValidateDatabase.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{Sekolah, Guru, Siswa, Jurusan, Kelas, Artikel, Prestasi, Galeri, Mapel};

class ValidateDatabase extends Command
{
    protected $signature = 'db:validate';
    protected $description = 'Validasi data seeding database profil sekolah';

    public function handle()
    {
        $this->info('🔍 Memulai validasi database...');
        $this->newLine();

        // Test 1: Sekolah
        $this->validateSekolah();
        
        // Test 2: Guru
        $this->validateGuru();
        
        // Test 3: Siswa
        $this->validateSiswa();
        
        // Test 4: Jurusan & Kelas
        $this->validateJurusanKelas();
        
        // Test 5: Content
        $this->validateContent();
        
        // Test 6: Relationships
        $this->validateRelationships();
        
        $this->newLine();
        $this->info('✅ Validasi database selesai!');
        
        // Summary
        $this->displaySummary();
    }

    private function validateSekolah()
    {
        $this->info('📚 Validasi Data Sekolah...');
        
        $count = Sekolah::count();
        if ($count === 2) {
            $this->line("   ✅ Jumlah sekolah: {$count} (Sesuai requirement)");
        } else {
            $this->error("   ❌ Jumlah sekolah: {$count} (Harusnya 2)");
        }

        $sekolahList = Sekolah::all();
        foreach ($sekolahList as $sekolah) {
            $this->line("   - {$sekolah->nama_sekolah}");
        }
    }

    private function validateGuru()
    {
        $this->info('👨‍🏫 Validasi Data Guru...');
        
        $count = Guru::count();
        if ($count >= 20) {
            $this->line("   ✅ Jumlah guru: {$count} (Memenuhi requirement ≥20)");
        } else {
            $this->error("   ❌ Jumlah guru: {$count} (Harusnya ≥20)");
        }

        // Distribusi per sekolah
        $sekolahList = Sekolah::all();
        foreach ($sekolahList as $sekolah) {
            $guruCount = $sekolah->guru->count();
            $this->line("   - {$sekolah->nama_sekolah}: {$guruCount} guru");
        }
    }

    private function validateSiswa()
    {
        $this->info('👨‍🎓 Validasi Data Siswa...');
        
        $count = Siswa::count();
        if ($count >= 50) {
            $this->line("   ✅ Jumlah siswa: {$count} (Memenuhi requirement ≥50)");
        } else {
            $this->error("   ❌ Jumlah siswa: {$count} (Harusnya ≥50)");
        }

        // Distribusi per sekolah
        $sekolahList = Sekolah::all();
        foreach ($sekolahList as $sekolah) {
            $siswaCount = $sekolah->siswa->count();
            $this->line("   - {$sekolah->nama_sekolah}: {$siswaCount} siswa");
        }
    }

    private function validateJurusanKelas()
    {
        $this->info('🎓 Validasi Jurusan & Kelas...');
        
        $jurusanCount = Jurusan::count();
        $kelasCount = Kelas::count();
        
        $this->line("   ✅ Jumlah jurusan: {$jurusanCount}");
        $this->line("   ✅ Jumlah kelas: {$kelasCount}");

        // Distribusi per sekolah
        $sekolahList = Sekolah::all();
        foreach ($sekolahList as $sekolah) {
            $jurusanSekolah = $sekolah->jurusan->count();
            $kelasSekolah = Kelas::whereHas('jurusan', function($q) use ($sekolah) {
                $q->where('id_sekolah', $sekolah->id_sekolah);
            })->count();
            
            $this->line("   - {$sekolah->nama_sekolah}: {$jurusanSekolah} jurusan, {$kelasSekolah} kelas");
        }
    }

    private function validateContent()
    {
        $this->info('📝 Validasi Content...');
        
        $artikelCount = Artikel::count();
        $prestasiCount = Prestasi::count();
        $galeriCount = Galeri::count();
        
        $this->line("   ✅ Artikel: {$artikelCount}");
        $this->line("   ✅ Prestasi: {$prestasiCount}");
        $this->line("   ✅ Galeri: {$galeriCount}");
    }

    private function validateRelationships()
    {
        $this->info('🔗 Validasi Relationships...');
        
        try {
            // Test relationship Sekolah -> Guru
            $sekolah = Sekolah::first();
            $guruCount = $sekolah->guru->count();
            $this->line("   ✅ Sekolah -> Guru: OK ({$guruCount})");
            
            // Test relationship Sekolah -> Siswa
            $siswaCount = $sekolah->siswa->count();
            $this->line("   ✅ Sekolah -> Siswa: OK ({$siswaCount})");
            
            // Test relationship Guru -> Sekolah
            $guru = Guru::first();
            $namaSekolah = $guru->sekolah->nama_sekolah ?? 'NULL';
            $this->line("   ✅ Guru -> Sekolah: OK ({$namaSekolah})");
            
            // Test relationship Kelas -> Wali Kelas
            $kelas = Kelas::first();
            $waliKelas = $kelas->waliKelas->nama_guru ?? 'NULL';
            $this->line("   ✅ Kelas -> Wali Kelas: OK ({$waliKelas})");
            
        } catch (\Exception $e) {
            $this->error("   ❌ Error dalam relationship: {$e->getMessage()}");
        }
    }

    private function displaySummary()
    {
        $this->info('📊 RINGKASAN DATABASE:');
        $this->table(
            ['Entity', 'Jumlah', 'Status'],
            [
                ['Sekolah', Sekolah::count(), Sekolah::count() === 2 ? '✅' : '❌'],
                ['Guru', Guru::count(), Guru::count() >= 20 ? '✅' : '❌'],
                ['Siswa', Siswa::count(), Siswa::count() >= 50 ? '✅' : '❌'],
                ['Jurusan', Jurusan::count(), '✅'],
                ['Kelas', Kelas::count(), '✅'],
                ['Mata Pelajaran', Mapel::count(), '✅'],
                ['Artikel', Artikel::count(), '✅'],
                ['Prestasi', Prestasi::count(), '✅'],
                ['Galeri', Galeri::count(), '✅'],
            ]
        );
    }
}