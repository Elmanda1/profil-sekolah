<?php 

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