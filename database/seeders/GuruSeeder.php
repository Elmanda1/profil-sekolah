<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\Sekolah;
use Faker\Factory as Faker;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $sekolahList = Sekolah::all();
        
        $counter = 0;
        
        foreach ($sekolahList as $sekolah) {
            // Setiap sekolah minimal 12 guru
            for ($i = 0; $i < 12; $i++) {
                $counter++;
                
                // Generate nama random dengan faker
                $isPria = $faker->boolean(50);
                $gelar = $faker->randomElement(['Drs.', 'Dr.', 'Dra.']);
                $pendidikan = $faker->randomElement(['M.Pd', 'S.Pd', 'M.Si']);
                $nama = ($isPria ? $faker->firstNameMale : $faker->firstNameFemale) . ' ' . $faker->lastName;
                $namaGuru = $gelar . ' ' . $nama . ', ' . $pendidikan;
                
                Guru::create([
                    'id_sekolah' => $sekolah->id_sekolah,
                    'nama_guru' => $namaGuru,
                    'email' => 'guru' . $counter . '@school.edu', // Email unik dengan counter
                    'no_telp' => $faker->phoneNumber,
                    'alamat' => $faker->address,
                    'foto' => $faker->randomElement(['hero.jpg', 'icon.png', null]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info("✅ {$counter} Guru berhasil dibuat!");
    }
}