<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSekolahSeeder extends Seeder
{
    public function run()
    {
        // Insert data ke tb_siswa
        DB::table('tb_siswa')->insert([
            [
                'nis' => '2025001',
                'nama_siswa' => 'Andi Setiawan',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2008-05-12',
                'alamat' => 'Jl. Merdeka No. 10'
            ],
            [
                'nis' => '2025002',
                'nama_siswa' => 'Budi Santoso',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2009-07-21',
                'alamat' => 'Jl. Mawar No. 5'
            ],
        ]);

        // Insert data ke tb_guru
        DB::table('tb_guru')->insert([
            [
                'nip' => '198501011',
                'nama_guru' => 'Siti Nuraini',
                'jenis_kelamin' => 'P',
                'mata_pelajaran' => 'Matematika',
                'alamat' => 'Jl. Kenanga No. 3'
            ],
            [
                'nip' => '198408222',
                'nama_guru' => 'Joko Prabowo',
                'jenis_kelamin' => 'L',
                'mata_pelajaran' => 'Bahasa Indonesia',
                'alamat' => 'Jl. Melati No. 7'
            ],
        ]);

        // Insert data ke tb_berita
        DB::table('tb_berita')->insert([
            [
                'judul' => 'Lomba Olimpiade Sains',
                'isi' => 'Sekolah akan mengadakan olimpiade sains tingkat kabupaten.',
                'tanggal_berita' => now(),
                'penulis' => 'Admin'
            ]
        ]);

        // Insert data ke tb_prestasi
        DB::table('tb_prestasi')->insert([
            [
                'id_siswa' => 1,
                'nama_prestasi' => 'Juara 1 Olimpiade Matematika',
                'tahun' => 2024
            ]
        ]);

        // Insert data ke tb_tabungan
        DB::table('tb_tabungan')->insert([
            [
                'id_siswa' => 1,
                'id_guru' => 1,
                'tanggal' => now(),
                'jumlah_tabungan' => 50000.00
            ]
        ]);
    }
}
