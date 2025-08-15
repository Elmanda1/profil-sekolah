<?php
// database/seeders/ArtikelSeeder.php
namespace Database\Seeders;

use App\Models\Artikel;
use Illuminate\Database\Seeder;

class ArtikelSeeder extends Seeder
{
    public function run()
    {
        $artikel_data = [
            [
                'id_sekolah' => 1,
                'judul' => 'Peringatan Hari Kemerdekaan Indonesia ke-79',
                'isi' => 'SMA Negeri 1 Jakarta mengadakan upacara peringatan Hari Kemerdekaan Indonesia ke-79 dengan khidmat. Seluruh siswa dan guru mengikuti upacara dengan penuh semangat nasionalisme.',
                'tanggal' => '2024-08-17',
                'gambar' => 'upacara_kemerdekaan.jpeg'
            ],
            [
                'id_sekolah' => 1,
                'judul' => 'Sosialisasi SNPMB 2025',
                'isi' => 'Kegiatan sosialisasi Seleksi Nasional Penerimaan Mahasiswa Baru (SNPMB) 2025 diselenggarakan untuk memberikan informasi kepada siswa kelas XII tentang jalur masuk perguruan tinggi negeri.',
                'tanggal' => '2024-08-10',
                'gambar' => 'sosialisasi_snpmb.jpeg'
            ],
            [
                'id_sekolah' => 1,
                'judul' => 'Seminar Parenting untuk Orang Tua Siswa',
                'isi' => 'SMA Negeri 1 Jakarta mengadakan seminar parenting dengan tema "Mendampingi Anak di Era Digital" yang dihadiri oleh orang tua siswa dan guru.',
                'tanggal' => '2024-08-05',
                'gambar' => 'seminar_parenting.jpeg'
            ]
        ];

        foreach ($artikel_data as $artikel) {
            Artikel::create($artikel);
        }
    }
}