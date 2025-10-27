<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Sekolah;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $sekolahList = Sekolah::all();
        
        if ($sekolahList->isEmpty()) {
            $this->command->error('❌ Tidak ada data sekolah! Jalankan SekolahSeeder terlebih dahulu.');
            return;
        }
        
        $counter = 0;
        $nispCounter = 1000000000; // Starting NISN (10 digits)
        $tahunSekarang = date('Y');
        
        // Nama-nama Indonesia yang umum
        $namaDepanLakiLaki = ['Ahmad', 'Budi', 'Dimas', 'Eko', 'Fajar', 'Hadi', 'Indra', 'Joko', 'Rudi', 'Yudi'];
        $namaDepanPerempuan = ['Ani', 'Dewi', 'Fitri', 'Ika', 'Lina', 'Maya', 'Novi', 'Rina', 'Sari', 'Tari'];
        $namaBelakang = ['Pratama', 'Wijaya', 'Santoso', 'Permana', 'Kusuma', 'Saputra', 'Saputri', 'Nugroho', 'Wati', 'Rahayu'];
        
        foreach ($sekolahList as $sekolah) {
            $this->command->info("📚 Membuat siswa untuk: {$sekolah->nama_sekolah}");
            
            // Buat 30 siswa per sekolah
            for ($i = 0; $i < 30; $i++) {
                // Random gender
                $gender = $faker->randomElement(['Laki-laki', 'Perempuan']);
                
                // Generate nama based on gender
                if ($gender === 'Laki-laki') {
                    $firstName = $faker->randomElement($namaDepanLakiLaki);
                } else {
                    $firstName = $faker->randomElement($namaDepanPerempuan);
                }
                
                $lastName = $faker->randomElement($namaBelakang);
                $fullName = $firstName . ' ' . $lastName;
                
                // Generate tanggal lahir (umur 6-18 tahun untuk siswa sekolah)
                $umur = rand(6, 18);
                $tanggalLahir = Carbon::now()
                    ->subYears($umur)
                    ->subDays(rand(1, 365))
                    ->format('Y-m-d');
                
                // Generate tempat lahir
                $tempatLahir = $faker->randomElement([
                    'Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang',
                    'Makassar', 'Palembang', 'Depok', 'Tangerang', 'Bekasi',
                    'Bogor', 'Yogyakarta', 'Malang', 'Solo', 'Denpasar'
                ]);
                
                // Generate NISN (10 digit unique)
                $nisn = (string)$nispCounter++;
                
                // Generate email
                $email = $this->generateEmail($firstName, $lastName, $nisn);
                
                // Generate no telepon Indonesia
                $noTelp = $this->generatePhoneNumber();
                
                // Generate alamat
                $alamat = $faker->streetAddress . ', ' . 
                         $faker->randomElement(['Kec. ', 'Kecamatan ']) . 
                         $faker->city . ', ' . 
                         $faker->state;
                
                // Status (95% aktif, 5% non-aktif)
                $status = $faker->randomElement([
                    'aktif', 'aktif', 'aktif', 'aktif', 'aktif',
                    'aktif', 'aktif', 'aktif', 'aktif', 'aktif',
                    'aktif', 'aktif', 'aktif', 'aktif', 'aktif',
                    'aktif', 'aktif', 'aktif', 'aktif', 'non-aktif'
                ]);
                
                // Foto (30% punya foto, 70% null)
                $foto = $faker->optional(0.3)->randomElement([
                    'siswa_' . Str::random(10) . '.jpg',
                    'photo_' . Str::random(10) . '.png',
                ]);
                
                try {
                    Siswa::create([
                        'id_sekolah' => $sekolah->id_sekolah,
                        'nisn' => $nisn,
                        'nama_siswa' => $fullName,
                        'jenis_kelamin' => $gender,
                        'tanggal_lahir' => $tanggalLahir,
                        'tempat_lahir' => $tempatLahir,
                        'email' => $email,
                        'no_telp' => $noTelp,
                        'alamat' => $alamat,
                        'foto' => $foto,
                        'status' => $status,
                        'created_at' => now()->subDays(rand(1, 365)),
                        'updated_at' => now()->subDays(rand(0, 30)),
                    ]);
                    
                    $counter++;
                } catch (\Exception $e) {
                    $this->command->warn("⚠️ Gagal membuat siswa: {$fullName} - " . $e->getMessage());
                }
            }
        }
        
        $this->command->info("✅ {$counter} Siswa berhasil dibuat!");
        
        // Statistik
        $laki = Siswa::where('jenis_kelamin', 'Laki-laki')->count();
        $perempuan = Siswa::where('jenis_kelamin', 'Perempuan')->count();
        $aktif = Siswa::where('status', 'aktif')->count();
        
        $this->command->table(
            ['Kategori', 'Jumlah'],
            [
                ['Total Siswa', $counter],
                ['Laki-laki', $laki],
                ['Perempuan', $perempuan],
                ['Status Aktif', $aktif],
            ]
        );
    }
    
    /**
     * Generate email unik untuk siswa
     */
    private function generateEmail(string $firstName, string $lastName, string $nisn): string
    {
        $firstName = Str::slug($firstName, '');
        $lastName = Str::slug($lastName, '');
        $unique = substr($nisn, -4); // Last 4 digits of NISN
        
        return strtolower($firstName . '.' . $lastName . $unique) . '@student.sch.id';
    }
    
    /**
     * Generate nomor telepon Indonesia yang realistis
     */
    private function generatePhoneNumber(): string
    {
        $prefix = ['0811', '0812', '0813', '0821', '0822', '0823', '0851', '0852', '0853'];
        $randomPrefix = $prefix[array_rand($prefix)];
        $randomNumber = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        
        return $randomPrefix . '-' . substr($randomNumber, 0, 4) . '-' . substr($randomNumber, 4);
    }
}