<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            SekolahSeeder::class,
            JenisKelasSeeder::class,
            JurusanSeeder::class,
            GuruSeeder::class,
            SiswaSeeder::class,
            ArtikelSeeder::class,
            PrestasiSeeder::class,
        ]);
    }
}