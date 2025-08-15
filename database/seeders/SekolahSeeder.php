<?php
// database/seeders/SekolahSeeder.php
namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    public function run()
    {
        Sekolah::create([
            'nama_sekolah' => 'SMA Negeri 100 Jakarta',
            'alamat' => 'Jl. Pendidikan No. 123, Jakarta',
            'no_telp' => '021-12345678',
            'email' => 'info@sma100jakarta.sch.id',
            'website' => 'https://sma100jakarta.sch.id'
        ]);
    }
}