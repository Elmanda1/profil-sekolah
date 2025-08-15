<?php
// database/seeders/PrestasiSeeder.php
namespace Database\Seeders;

use App\Models\Prestasi;
use Illuminate\Database\Seeder;

class PrestasiSeeder extends Seeder
{
    public function run()
    {
        $prestasi_data = [
            [
                'id_sekolah' => 1,
                'judul' => 'Juara 1 Olimpiade Matematika Tingkat DKI Jakarta',
                'deskripsi' => 'Siswa SMA Negeri 1 Jakarta berhasil meraih juara 1 dalam Olimpiade Matematika tingkat DKI Jakarta yang diselenggarakan oleh Dinas Pendidikan DKI Jakarta.',
                'tanggal' => '2024-07-15',
                'gambar' => 'lomba_matematika.jpg'
            ],
            [
                'id_sekolah' => 1,
                'judul' => 'Juara 2 Kompetisi Futsal Antar SMA',
                'deskripsi' => 'Tim futsal SMA Negeri 1 Jakarta berhasil meraih juara 2 dalam kompetisi futsal antar SMA se-Jakarta Pusat.',
                'tanggal' => '2024-07-20',
                'gambar' => 'lomba_futsal.jpeg'
            ],
            [
                'id_sekolah' => 1,
                'judul' => 'Juara 3 Lomba Mancing Tingkat Nasional',
                'deskripsi' => 'Ekstrakurikuler Pancing SMA Negeri 1 Jakarta meraih juara 3 dalam lomba mancing tingkat nasional yang diselenggarakan di Ancol.',
                'tanggal' => '2024-06-25',
                'gambar' => 'lomba_mancing.jpg'
            ]
        ];

        foreach ($prestasi_data as $prestasi) {
            Prestasi::create($prestasi);
        }
    }
}