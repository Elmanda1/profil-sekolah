<?php
// database/seeders/SiswaSeeder.php
namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        $siswa_data = [
            [
                'id_sekolah' => 1,
                'nisn' => '2024001001',
                'nama_siswa' => 'Andi Pratama',
                'jenis_kelamin' => 'L',
                'email' => 'andi.pratama@student.sma1jakarta.sch.id',
                'no_telp' => '08567890123',
                'alamat' => 'Jl. Siswa No. 1, Jakarta',
            ],
            [
                'id_sekolah' => 1,
                'nisn' => '2024001002',
                'nama_siswa' => 'Sari Indah',
                'jenis_kelamin' => 'P',
                'email' => 'sari.indah@student.sma1jakarta.sch.id',
                'no_telp' => '08567890124',
                'alamat' => 'Jl. Siswa No. 2, Jakarta',
            ],
            [
                'id_sekolah' => 1,
                'nisn' => '2024001003',
                'nama_siswa' => 'Rizki Fadilah',
                'jenis_kelamin' => 'L',
                'email' => 'rizki.fadilah@student.sma1jakarta.sch.id',
                'no_telp' => '08567890125',
                'alamat' => 'Jl. Siswa No. 3, Jakarta',
            ],
            [
                'id_sekolah' => 1,
                'nisn' => '2024001004',
                'nama_siswa' => 'Dewi Lestari',
                'jenis_kelamin' => 'P',
                'email' => 'dewi.lestari@student.sma1jakarta.sch.id',
                'no_telp' => '08567890126',
                'alamat' => 'Jl. Siswa No. 4, Jakarta',
            ],
            [
                'id_sekolah' => 1,
                'nisn' => '2024001005',
                'nama_siswa' => 'Muhammad Fauzi',
                'jenis_kelamin' => 'L',
                'email' => 'muhammad.fauzi@student.sma1jakarta.sch.id',
                'no_telp' => '08567890127',
                'alamat' => 'Jl. Siswa No. 5, Jakarta',
            ],
            [
                'id_sekolah' => 1,
                'nisn' => '2024001006',
                'nama_siswa' => 'Ayu Permatasari',
                'jenis_kelamin' => 'P',
                'email' => 'ayu.permatasari@student.sma1jakarta.sch.id',
                'no_telp' => '08567890128',
                'alamat' => 'Jl. Siswa No. 6, Jakarta',
            ],
            [
                'id_sekolah' => 1,
                'nisn' => '2024001007',
                'nama_siswa' => 'Bayu Nugroho',
                'jenis_kelamin' => 'L',
                'email' => 'bayu.nugroho@student.sma1jakarta.sch.id',
                'no_telp' => '08567890129',
                'alamat' => 'Jl. Siswa No. 7, Jakarta',
            ],
            [
                'id_sekolah' => 1,
                'nisn' => '2024001008',
                'nama_siswa' => 'Citra Dewi',
                'jenis_kelamin' => 'P',
                'email' => 'citra.dewi@student.sma1jakarta.sch.id',
                'no_telp' => '08567890130',
                'alamat' => 'Jl. Siswa No. 8, Jakarta',
            ]
        ];

        foreach ($siswa_data as $siswa) {
            Siswa::create($siswa);
        }
    }
}