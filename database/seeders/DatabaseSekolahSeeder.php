<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Models\Guru;  

class DatabaseSekolahSeeder extends Seeder
{
    public function run()
    {

        // Disable foreign key checks untuk MySQL
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Truncate tables first to avoid duplicate entries
        Siswa::truncate();
        Guru::truncate();

        // Seed data siswa dari DML yang diberikan
        $dataSiswa = [
            ['nis' => '2025001', 'nama_siswa' => 'Ahmad Fauzi', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-01-15', 'alamat' => 'Jl. Merpati No. 1'],
            ['nis' => '2025002', 'nama_siswa' => 'Budi Santoso', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-02-20', 'alamat' => 'Jl. Kenanga No. 2'],
            ['nis' => '2025003', 'nama_siswa' => 'Citra Dewi', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-03-05', 'alamat' => 'Jl. Melati No. 3'],
            ['nis' => '2025004', 'nama_siswa' => 'Dian Pratama', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-04-12', 'alamat' => 'Jl. Mawar No. 4'],
            ['nis' => '2025005', 'nama_siswa' => 'Eka Wulandari', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-05-18', 'alamat' => 'Jl. Dahlia No. 5'],
            ['nis' => '2025006', 'nama_siswa' => 'Fajar Hidayat', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-06-25', 'alamat' => 'Jl. Anggrek No. 6'],
            ['nis' => '2025007', 'nama_siswa' => 'Gita Putri', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-07-30', 'alamat' => 'Jl. Teratai No. 7'],
            ['nis' => '2025008', 'nama_siswa' => 'Hadi Saputra', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-08-10', 'alamat' => 'Jl. Flamboyan No. 8'],
            ['nis' => '2025009', 'nama_siswa' => 'Indah Lestari', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-09-14', 'alamat' => 'Jl. Cempaka No. 9'],
            ['nis' => '2025010', 'nama_siswa' => 'Joko Prabowo', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-10-22', 'alamat' => 'Jl. Kamboja No. 10'],
            ['nis' => '2025011', 'nama_siswa' => 'Kartika Sari', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-11-01', 'alamat' => 'Jl. Sakura No. 11'],
            ['nis' => '2025012', 'nama_siswa' => 'Lukman Hakim', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-12-12', 'alamat' => 'Jl. Tulip No. 12'],
            ['nis' => '2025013', 'nama_siswa' => 'Mega Ayu', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-01-25', 'alamat' => 'Jl. Melur No. 13'],
            ['nis' => '2025014', 'nama_siswa' => 'Naufal Rizky', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-02-16', 'alamat' => 'Jl. Anyelir No. 14'],
            ['nis' => '2025015', 'nama_siswa' => 'Olivia Salsabila', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-03-28', 'alamat' => 'Jl. Bougenville No. 15'],
            ['nis' => '2025016', 'nama_siswa' => 'Prasetyo Adi', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-04-04', 'alamat' => 'Jl. Asoka No. 16'],
            ['nis' => '2025017', 'nama_siswa' => 'Qory Rahma', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-05-15', 'alamat' => 'Jl. Kenari No. 17'],
            ['nis' => '2025018', 'nama_siswa' => 'Rizky Ramadhan', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-06-09', 'alamat' => 'Jl. Cemara No. 18'],
            ['nis' => '2025019', 'nama_siswa' => 'Siti Aminah', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-07-23', 'alamat' => 'Jl. Pinus No. 19'],
            ['nis' => '2025020', 'nama_siswa' => 'Teguh Wibowo', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-08-14', 'alamat' => 'Jl. Jati No. 20'],
            ['nis' => '2025021', 'nama_siswa' => 'Ulfah Hidayah', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-09-19', 'alamat' => 'Jl. Beringin No. 21'],
            ['nis' => '2025022', 'nama_siswa' => 'Vino Pratama', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-10-03', 'alamat' => 'Jl. Randu No. 22'],
            ['nis' => '2025023', 'nama_siswa' => 'Winda Aprilia', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-11-25', 'alamat' => 'Jl. Mangga No. 23'],
            ['nis' => '2025024', 'nama_siswa' => 'Xaverius Dwi', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-12-30', 'alamat' => 'Jl. Duku No. 24'],
            ['nis' => '2025025', 'nama_siswa' => 'Yuniarti', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-01-11', 'alamat' => 'Jl. Nangka No. 25'],
            ['nis' => '2025026', 'nama_siswa' => 'Zaky Firmansyah', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-02-22', 'alamat' => 'Jl. Manggis No. 26'],
            ['nis' => '2025027', 'nama_siswa' => 'Aulia Fitri', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-03-14', 'alamat' => 'Jl. Sawo No. 27'],
            ['nis' => '2025028', 'nama_siswa' => 'Bagus Saputra', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-04-27', 'alamat' => 'Jl. Jeruk No. 28'],
            ['nis' => '2025029', 'nama_siswa' => 'Cahya Lestari', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-05-05', 'alamat' => 'Jl. Pepaya No. 29'],
            ['nis' => '2025030', 'nama_siswa' => 'Dwi Hartono', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-06-18', 'alamat' => 'Jl. Kedondong No. 30'],
            ['nis' => '2025031', 'nama_siswa' => 'Evi Rahmawati', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-07-29', 'alamat' => 'Jl. Jambu No. 31'],
            ['nis' => '2025032', 'nama_siswa' => 'Fahmi Prasetya', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-08-21', 'alamat' => 'Jl. Durian No. 32'],
            ['nis' => '2025033', 'nama_siswa' => 'Gina Amalia', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-09-16', 'alamat' => 'Jl. Nanas No. 33'],
            ['nis' => '2025034', 'nama_siswa' => 'Hendra Wijaya', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-10-28', 'alamat' => 'Jl. Sirsak No. 34'],
            ['nis' => '2025035', 'nama_siswa' => 'Intan Puspita', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-11-07', 'alamat' => 'Jl. Kedondong No. 35'],
            ['nis' => '2025036', 'nama_siswa' => 'Junaidi Akbar', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-12-13', 'alamat' => 'Jl. Pisang No. 36'],
            ['nis' => '2025037', 'nama_siswa' => 'Kurnia Sari', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-01-20', 'alamat' => 'Jl. Belimbing No. 37'],
            ['nis' => '2025038', 'nama_siswa' => 'Laila Andini', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-02-08', 'alamat' => 'Jl. Delima No. 38'],
            ['nis' => '2025039', 'nama_siswa' => 'Miko Saputra', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-03-19', 'alamat' => 'Jl. Markisa No. 39'],
            ['nis' => '2025040', 'nama_siswa' => 'Nadya Ayuningtyas', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-04-09', 'alamat' => 'Jl. Melon No. 40'],
            ['nis' => '2025041', 'nama_siswa' => 'Oki Pratama', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-05-13', 'alamat' => 'Jl. Rambutan No. 41'],
            ['nis' => '2025042', 'nama_siswa' => 'Putri Cahaya', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-06-24', 'alamat' => 'Jl. Lengkeng No. 42'],
            ['nis' => '2025043', 'nama_siswa' => 'Qori Maulana', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-07-15', 'alamat' => 'Jl. Kersen No. 43'],
            ['nis' => '2025044', 'nama_siswa' => 'Rina Marlina', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-08-17', 'alamat' => 'Jl. Sukun No. 44'],
            ['nis' => '2025045', 'nama_siswa' => 'Samsul Arifin', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-09-08', 'alamat' => 'Jl. Kelengkeng No. 45'],
            ['nis' => '2025046', 'nama_siswa' => 'Tasya Nuraini', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-10-19', 'alamat' => 'Jl. Jamblang No. 46'],
            ['nis' => '2025047', 'nama_siswa' => 'Umar Zain', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-11-21', 'alamat' => 'Jl. Menteng No. 47'],
            ['nis' => '2025048', 'nama_siswa' => 'Vera Damayanti', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-12-02', 'alamat' => 'Jl. Damar No. 48'],
            ['nis' => '2025049', 'nama_siswa' => 'Wildan Hidayat', 'jenis_kelamin' => 'L', 'tanggal_lahir' => '2007-01-17', 'alamat' => 'Jl. Angsana No. 49'],
            ['nis' => '2025050', 'nama_siswa' => 'Yasmin Zahra', 'jenis_kelamin' => 'P', 'tanggal_lahir' => '2007-02-25', 'alamat' => 'Jl. Bunga No. 50']
        ];

        foreach ($dataSiswa as $siswa) {
            Siswa::create($siswa);
        }

        // Seed data guru dari DML yang diberikan
        $dataGuru = [
            ['nip' => '198001012005011001', 'nama_guru' => 'Budi Hartono', 'jenis_kelamin' => 'L', 'mata_pelajaran' => 'Matematika', 'alamat' => 'Jl. Merpati No. 5, Jakarta'],
            ['nip' => '197902142004031002', 'nama_guru' => 'Siti Marlina', 'jenis_kelamin' => 'P', 'mata_pelajaran' => 'Bahasa Indonesia', 'alamat' => 'Jl. Kenanga No. 8, Jakarta'],
            ['nip' => '198510202006011003', 'nama_guru' => 'Agus Prasetyo', 'jenis_kelamin' => 'L', 'mata_pelajaran' => 'Fisika', 'alamat' => 'Jl. Melati No. 10, Jakarta'],
            ['nip' => '198306182005071004', 'nama_guru' => 'Rina Andayani', 'jenis_kelamin' => 'P', 'mata_pelajaran' => 'Kimia', 'alamat' => 'Jl. Mawar No. 2, Jakarta'],
            ['nip' => '197811112004041005', 'nama_guru' => 'Dedi Saputra', 'jenis_kelamin' => 'L', 'mata_pelajaran' => 'Biologi', 'alamat' => 'Jl. Dahlia No. 12, Jakarta'],
            ['nip' => '198907252010011006', 'nama_guru' => 'Novi Wulandari', 'jenis_kelamin' => 'P', 'mata_pelajaran' => 'Bahasa Inggris', 'alamat' => 'Jl. Anggrek No. 7, Jakarta'],
            ['nip' => '198405302007081007', 'nama_guru' => 'Hendra Wijaya', 'jenis_kelamin' => 'L', 'mata_pelajaran' => 'Sejarah', 'alamat' => 'Jl. Teratai No. 4, Jakarta'],
            ['nip' => '198202092005031008', 'nama_guru' => 'Kartika Puspita', 'jenis_kelamin' => 'P', 'mata_pelajaran' => 'Geografi', 'alamat' => 'Jl. Flamboyan No. 9, Jakarta'],
            ['nip' => '197701192003011009', 'nama_guru' => 'Ahmad Zulkarnain', 'jenis_kelamin' => 'L', 'mata_pelajaran' => 'Ekonomi', 'alamat' => 'Jl. Cempaka No. 6, Jakarta'],
            ['nip' => '198604142009021010', 'nama_guru' => 'Dewi Anggraini', 'jenis_kelamin' => 'P', 'mata_pelajaran' => 'Sosiologi', 'alamat' => 'Jl. Kamboja No. 3, Jakarta']
        ];

        foreach ($dataGuru as $guru) {
            Guru::create($guru);
        }

        $this->command->info('Data lengkap berhasil di-seed!');
        $this->command->info('- 50 data siswa telah ditambahkan');
        $this->command->info('- 10 data guru telah ditambahkan');
    }
}
