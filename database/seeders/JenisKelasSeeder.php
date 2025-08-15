<?php
// database/seeders/JenisKelasSeeder.php
namespace Database\Seeders;

use App\Models\JenisKelas;
use Illuminate\Database\Seeder;

class JenisKelasSeeder extends Seeder
{
    public function run()
    {
        $jenis_kelas = [
            ['nama_jenis_kelas' => 'Kelas X'],
            ['nama_jenis_kelas' => 'Kelas XI'],
            ['nama_jenis_kelas' => 'Kelas XII'],
        ];

        foreach ($jenis_kelas as $jenis) {
            JenisKelas::create($jenis);
        }
    }
}