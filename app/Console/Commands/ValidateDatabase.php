<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{Sekolah, Guru, Siswa, Jurusan, Kelas, Artikel, Prestasi, Galeri, Mapel};
use Illuminate\Support\Facades\DB;

class ValidateDatabase extends Command
{
    protected $signature = 'db:validate {--detailed : Show detailed information}';
    protected $description = 'Validasi data seeding database profil sekolah';

    protected $errors = [];
    protected $warnings = [];

    public function handle()
    {
        $this->info('🔍 Memulai validasi database profil sekolah...');
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

        // Test 7: Data Integrity
        $this->validateDataIntegrity();
        
        $this->newLine();
        
        // Display results
        $this->displayResults();
        
        // Summary
        $this->displaySummary();
        
        return empty($this->errors) ? 0 : 1;
    }

    private function validateSekolah()
    {
        $this->info('📚 Validasi Data Sekolah...');
        
        $count = Sekolah::count();
        if ($count === 2) {
            $this->line("   ✅ Jumlah sekolah: {$count} (Sesuai requirement)");
        } else {
            $this->errors[] = "Jumlah sekolah: {$count} (Harusnya 2)";
            $this->error("   ❌ Jumlah sekolah: {$count} (Harusnya 2)");
        }

        // Validasi data sekolah
        $sekolahList = Sekolah::all();
        foreach ($sekolahList as $sekolah) {
            $this->line("   - {$sekolah->nama_sekolah}");
            
            // Check required fields
            if (empty($sekolah->alamat)) {
                $this->warnings[] = "Sekolah {$sekolah->nama_sekolah} tidak memiliki alamat";
            }
            if (empty($sekolah->nomor_telepon)) {
                $this->warnings[] = "Sekolah {$sekolah->nama_sekolah} tidak memiliki nomor telepon";
            }
        }

        // Check for SMA and SMK
        $hasSMA = $sekolahList->contains(function($sekolah) {
            return stripos($sekolah->nama_sekolah, 'SMA') !== false;
        });
        $hasSMK = $sekolahList->contains(function($sekolah) {
            return stripos($sekolah->nama_sekolah, 'SMK') !== false;
        });

        if (!$hasSMA) $this->warnings[] = "Tidak ada sekolah SMA";
        if (!$hasSMK) $this->warnings[] = "Tidak ada sekolah SMK";
    }

    private function validateGuru()
    {
        $this->info('👨‍🏫 Validasi Data Guru...');
        
        $count = Guru::count();
        if ($count >= 20) {
            $this->line("   ✅ Jumlah guru: {$count} (Memenuhi requirement ≥20)");
        } else {
            $this->errors[] = "Jumlah guru: {$count} (Harusnya ≥20)";
            $this->error("   ❌ Jumlah guru: {$count} (Harusnya ≥20)");
        }

        // Distribusi per sekolah
        $sekolahList = Sekolah::all();
        foreach ($sekolahList as $sekolah) {
            $guruCount = $sekolah->guru->count();
            $this->line("   - {$sekolah->nama_sekolah}: {$guruCount} guru");
            
            if ($guruCount === 0) {
                $this->errors[] = "Sekolah {$sekolah->nama_sekolah} tidak memiliki guru";
            }
        }

        // Check data integrity
        $guruTanpaSekolah = Guru::whereNull('id_sekolah')->count();
        if ($guruTanpaSekolah > 0) {
            $this->warnings[] = "{$guruTanpaSekolah} guru tidak memiliki sekolah";
        }
    }

    private function validateSiswa()
    {
        $this->info('👨‍🎓 Validasi Data Siswa...');
        
        $count = Siswa::count();
        if ($count >= 50) {
            $this->line("   ✅ Jumlah siswa: {$count} (Memenuhi requirement ≥50)");
        } else {
            $this->errors[] = "Jumlah siswa: {$count} (Harusnya ≥50)";
            $this->error("   ❌ Jumlah siswa: {$count} (Harusnya ≥50)");
        }

        // Distribusi per sekolah
        $sekolahList = Sekolah::all();
        foreach ($sekolahList as $sekolah) {
            $siswaCount = $sekolah->siswa->count();
            $this->line("   - {$sekolah->nama_sekolah}: {$siswaCount} siswa");
            
            if ($siswaCount === 0) {
                $this->errors[] = "Sekolah {$sekolah->nama_sekolah} tidak memiliki siswa";
            }
        }

        // Check unique NISN
        $totalSiswa = Siswa::count();
        $uniqueNISN = Siswa::distinct('nisn')->count();
        if ($totalSiswa !== $uniqueNISN) {
            $this->warnings[] = "Ada NISN yang duplikat ({$totalSiswa} siswa, {$uniqueNISN} NISN unik)";
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
            
            if ($jurusanSekolah === 0) {
                $this->errors[] = "Sekolah {$sekolah->nama_sekolah} tidak memiliki jurusan";
            }
        }

        // Validate kelas has wali kelas
        $kelasTanpaWali = Kelas::whereNull('id_wali_kelas')->count();
        if ($kelasTanpaWali > 0) {
            $this->warnings[] = "{$kelasTanpaWali} kelas tidak memiliki wali kelas";
        }
    }

    private function validateContent()
    {
        $this->info('📝 Validasi Content...');
        
        $artikelCount = Artikel::count();
        $prestasiCount = Prestasi::count();
        $galeriCount = Galeri::count();
        $mapelCount = Mapel::count();
        
        $this->line("   ✅ Artikel: {$artikelCount}");
        $this->line("   ✅ Prestasi: {$prestasiCount}");
        $this->line("   ✅ Galeri: {$galeriCount}");
        $this->line("   ✅ Mata Pelajaran: {$mapelCount}");

        if ($artikelCount === 0) $this->warnings[] = "Tidak ada artikel";
        if ($prestasiCount === 0) $this->warnings[] = "Tidak ada prestasi";
        if ($galeriCount === 0) $this->warnings[] = "Tidak ada galeri";
    }

    private function validateRelationships()
    {
        $this->info('🔗 Validasi Relationships...');
        
        try {
            // Test relationship Sekolah -> Guru
            $sekolah = Sekolah::first();
            if ($sekolah) {
                $guruCount = $sekolah->guru->count();
                $this->line("   ✅ Sekolah -> Guru: OK ({$guruCount})");
            }
            
            // Test relationship Sekolah -> Siswa
            if ($sekolah) {
                $siswaCount = $sekolah->siswa->count();
                $this->line("   ✅ Sekolah -> Siswa: OK ({$siswaCount})");
            }
            
            // Test relationship Guru -> Sekolah
            $guru = Guru::first();
            if ($guru && $guru->sekolah) {
                $namaSekolah = $guru->sekolah->nama_sekolah;
                $this->line("   ✅ Guru -> Sekolah: OK ({$namaSekolah})");
            }
            
            // Test relationship Kelas -> Wali Kelas
            $kelas = Kelas::first();
            if ($kelas && $kelas->waliKelas) {
                $waliKelas = $kelas->waliKelas->nama_guru;
                $this->line("   ✅ Kelas -> Wali Kelas: OK ({$waliKelas})");
            } else {
                $this->warnings[] = "Tidak ada relasi Kelas -> Wali Kelas yang valid";
            }
            
        } catch (\Exception $e) {
            $this->errors[] = "Error dalam relationship: {$e->getMessage()}";
            $this->error("   ❌ Error dalam relationship: {$e->getMessage()}");
        }
    }

    private function validateDataIntegrity()
    {
        $this->info('🔍 Validasi Data Integrity...');
        
        try {
            // Check foreign key constraints
            $invalidGuru = Guru::whereNotIn('id_sekolah', Sekolah::pluck('id_sekolah'))->count();
            if ($invalidGuru > 0) {
                $this->errors[] = "{$invalidGuru} guru memiliki id_sekolah yang tidak valid";
            }

            $invalidSiswa = Siswa::whereNotIn('id_sekolah', Sekolah::pluck('id_sekolah'))->count();
            if ($invalidSiswa > 0) {
                $this->errors[] = "{$invalidSiswa} siswa memiliki id_sekolah yang tidak valid";
            }

            $invalidKelas = Kelas::whereNotIn('id_wali_kelas', Guru::pluck('id_guru'))->whereNotNull('id_wali_kelas')->count();
            if ($invalidKelas > 0) {
                $this->errors[] = "{$invalidKelas} kelas memiliki wali kelas yang tidak valid";
            }

            if ($invalidGuru === 0 && $invalidSiswa === 0 && $invalidKelas === 0) {
                $this->line("   ✅ Data integrity: OK");
            }

        } catch (\Exception $e) {
            $this->warnings[] = "Tidak bisa validasi integrity: {$e->getMessage()}";
        }
    }

    private function displayResults()
    {
        if (!empty($this->errors)) {
            $this->error('❌ ERRORS DITEMUKAN:');
            foreach ($this->errors as $error) {
                $this->error("   - {$error}");
            }
            $this->newLine();
        }

        if (!empty($this->warnings)) {
            $this->warn('⚠️ WARNINGS:');
            foreach ($this->warnings as $warning) {
                $this->warn("   - {$warning}");
            }
            $this->newLine();
        }

        if (empty($this->errors) && empty($this->warnings)) {
            $this->info('🎉 Semua validasi berhasil! Database dalam kondisi optimal.');
        }
    }

    private function displaySummary()
    {
        $this->info('📊 RINGKASAN DATABASE:');
        
        $data = [
            ['Sekolah', Sekolah::count(), Sekolah::count() === 2 ? '✅' : '❌'],
            ['Guru', Guru::count(), Guru::count() >= 20 ? '✅' : '❌'],
            ['Siswa', Siswa::count(), Siswa::count() >= 50 ? '✅' : '❌'],
            ['Jurusan', Jurusan::count(), '✅'],
            ['Kelas', Kelas::count(), '✅'],
            ['Mata Pelajaran', Mapel::count(), '✅'],
            ['Artikel', Artikel::count(), Artikel::count() > 0 ? '✅' : '⚠️'],
            ['Prestasi', Prestasi::count(), Prestasi::count() > 0 ? '✅' : '⚠️'],
            ['Galeri', Galeri::count(), Galeri::count() > 0 ? '✅' : '⚠️'],
        ];

        $this->table(['Entity', 'Jumlah', 'Status'], $data);

        // Performance info
        if ($this->option('detailed')) {
            $this->newLine();
            $this->info('⚡ PERFORMANCE INFO:');
            
            $start = microtime(true);
            Sekolah::with(['guru', 'siswa', 'jurusan.kelas'])->get();
            $queryTime = round((microtime(true) - $start) * 1000, 2);
            
            $this->line("   Query kompleks: {$queryTime}ms");
            if ($queryTime > 1000) {
                $this->warn("   ⚠️ Query lambat, pertimbangkan optimisasi");
            }
        }

        // Final status
        $this->newLine();
        if (empty($this->errors)) {
            $this->info('🎯 STATUS: DATABASE SIAP DIGUNAKAN!');
        } else {
            $this->error('🚨 STATUS: ADA MASALAH YANG PERLU DIPERBAIKI!');
        }
    }
}