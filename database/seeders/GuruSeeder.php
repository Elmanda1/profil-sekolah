<?php
// database/seeders/GuruSeeder.php
namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run()
    {
        $guru_data = [
            [
                'id_sekolah' => 1,
                'nama_guru' => 'Dr. Ahmad Wijaya, S.Pd., M.Pd.',
                'jenis_kelamin' => 'L',
                'email' => 'ahmad.wijaya@sma1jakarta.sch.id',
                'no_telp' => '08123456789',
                'alamat' => 'Jl. Guru No. 1, Jakarta',
            ],
            [
                'id_sekolah' => 1,
                'nama_guru' => 'Siti Nurhaliza, S.Pd., M.Si.',
                'jenis_kelamin' => 'P',
                'email' => 'siti.nurhaliza@sma1jakarta.sch.id',
                'no_telp' => '08123456790',
                'alamat' => 'Jl. Guru No. 2, Jakarta',
            ],
            [
                'id_sekolah' => 1,
                'nama_guru' => 'Budi Santoso, S.Pd.',
                'jenis_kelamin' => 'L',
                'email' => 'budi.santoso@sma1jakarta.sch.id',
                'no_telp' => '08123456791',
                'alamat' => 'Jl. Guru No. 3, Jakarta',
            ],
            [
                'id_sekolah' => 1,
                'nama_guru' => 'Maya Sari, S.Pd., M.Pd.',
                'jenis_kelamin' => 'P',
                'email' => 'maya.sari@sma1jakarta.sch.id',
                'no_telp' => '08123456792',
                'alamat' => 'Jl. Guru No. 4, Jakarta',
            ],
            [
                'id_sekolah' => 1,
                'nama_guru' => 'Drs. Hendro Prasetyo',
                'jenis_kelamin' => 'L',
                'email' => 'hendro.prasetyo@sma1jakarta.sch.id',
                'no_telp' => '08123456793',
                'alamat' => 'Jl. Guru No. 5, Jakarta',
            ]
        ];

        foreach ($guru_data as $guru) {
            Guru::create($guru);
        }
    }
}