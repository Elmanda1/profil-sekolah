<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // panggil seeder-seeder lain di sini
        $this->call([
            DatabaseSekolahSeeder::class,
        ]);
    }
}
