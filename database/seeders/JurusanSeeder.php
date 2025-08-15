<?php
// database/seeders/JurusanSeeder.php
namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    public function run()
    {
        $jurusan = [
            [
                'id_sekolah' => 1,
                'nama_jurusan' => 'IPA (Ilmu Pengetahuan Alam)'
            ],
            [
                'id_sekolah' => 1,
                'nama_jurusan' => 'IPS (Ilmu Pengetahuan Sosial)'
            ],
            [
                'id_sekolah' => 1,
                'nama_jurusan' => 'Bahasa'
            ]
        ];

        foreach ($jurusan as $data) {
            Jurusan::create($data);
        }
    }
}