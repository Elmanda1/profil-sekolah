<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Berita;
use App\Models\Prestasi;

class DatabaseSekolahSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks untuk MySQL
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Truncate tables first to avoid duplicate entries
        Siswa::truncate();
        Guru::truncate();
        Berita::truncate();
        Prestasi::truncate();

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

        // Seed data berita
        $dataBerita = [
            [
                'judul' => 'SMA Negeri 100 Jakarta Raih Juara 1 Lomba Sains Nasional',
                'isi' => 'Tim sains SMA Negeri 100 Jakarta berhasil meraih Juara 1 pada Lomba Sains Nasional tingkat SMA yang diadakan di Bandung. Kompetisi ini diikuti oleh lebih dari 200 sekolah dari seluruh Indonesia. Kepala sekolah, Drs. Budi Hartono, menyampaikan apresiasi yang tinggi kepada seluruh tim atas dedikasi dan kerja keras yang telah dilakukan. Keberhasilan ini diharapkan menjadi motivasi bagi siswa lainnya untuk terus berprestasi di bidang akademik maupun non-akademik.',
                'tanggal_berita' => '2025-02-15',
                'penulis' => 'Juen Denardy'
            ],
            [
                'judul' => 'Peringatan Hari Guru Nasional di SMA Negeri 100 Jakarta',
                'isi' => 'Dalam rangka memperingati Hari Guru Nasional, SMA Negeri 100 Jakarta menggelar upacara bendera yang diikuti oleh seluruh siswa, guru, dan staf sekolah. Pada acara tersebut, dilakukan pula pemberian penghargaan kepada guru-guru yang telah mengabdi lebih dari 20 tahun. Suasana haru dan penuh kebanggaan terasa di lapangan sekolah ketika siswa membacakan puisi untuk para guru mereka.',
                'tanggal_berita' => '2025-11-25',
                'penulis' => 'Falih Elmanda Ghaisan'
            ],
            [
                'judul' => 'Pelatihan Literasi Digital untuk Siswa',
                'isi' => 'Sebagai upaya meningkatkan keterampilan digital siswa, SMA Negeri 100 Jakarta menyelenggarakan pelatihan literasi digital yang bekerja sama dengan Kementerian Komunikasi dan Informatika. Pelatihan ini meliputi materi keamanan digital, etika bermedia sosial, dan pemanfaatan teknologi untuk pembelajaran. Kegiatan ini diikuti oleh seluruh siswa kelas X dan XI di aula sekolah.',
                'tanggal_berita' => '2025-05-10',
                'penulis' => 'Muhammad Rafif Dwiarka'
            ],
            [
                'judul' => 'Penggalangan Dana untuk Korban Bencana Alam',
                'isi' => 'OSIS SMA Negeri 100 Jakarta mengadakan kegiatan penggalangan dana untuk membantu korban bencana alam di Sulawesi. Seluruh warga sekolah turut berpartisipasi dengan menyumbangkan dana, pakaian layak pakai, dan makanan. Dana yang terkumpul mencapai lebih dari Rp 50 juta dan telah disalurkan melalui lembaga resmi. Kepala sekolah mengapresiasi semangat kepedulian sosial yang tinggi dari para siswa.',
                'tanggal_berita' => '2025-01-20',
                'penulis' => 'Aurelia Putri Adhira'
            ],
            [
                'judul' => 'Festival Seni dan Budaya SMA Negeri 100 Jakarta',
                'isi' => 'Dalam rangka memperingati HUT sekolah, SMA Negeri 100 Jakarta menggelar Festival Seni dan Budaya yang diikuti oleh seluruh siswa dari berbagai jurusan. Acara ini menampilkan tari tradisional, musik modern, drama, dan pameran karya seni siswa. Festival ini juga menjadi ajang untuk mempererat persaudaraan antar siswa sekaligus melestarikan budaya bangsa.',
                'tanggal_berita' => '2025-09-05',
                'penulis' => 'Aqila Zahra Meisya'
            ]
        ];

        foreach ($dataBerita as $berita) {
            Berita::create($berita);
        }

        // Seed data prestasi
        $dataPrestasi = [
            ['id_siswa' => 1, 'nama_prestasi' => 'Juara 1 Olimpiade Matematika Nasional', 'tahun' => 2025],
            ['id_siswa' => 2, 'nama_prestasi' => 'Juara 2 Lomba Cerdas Cermat SMA se-DKI Jakarta', 'tahun' => 2024],
            ['id_siswa' => 3, 'nama_prestasi' => 'Juara 1 Lomba Debat Bahasa Inggris Tingkat Kota', 'tahun' => 2025],
            ['id_siswa' => 4, 'nama_prestasi' => 'Juara 3 Olimpiade Fisika SMA', 'tahun' => 2023],
            ['id_siswa' => 5, 'nama_prestasi' => 'Juara 1 Lomba Menulis Cerpen Tingkat Kota', 'tahun' => 2025],
            ['id_siswa' => 6, 'nama_prestasi' => 'Juara Harapan 1 Olimpiade Biologi', 'tahun' => 2024],
            ['id_siswa' => 7, 'nama_prestasi' => 'Juara 2 Kejuaraan Basket Putra SMA', 'tahun' => 2025],
            ['id_siswa' => 8, 'nama_prestasi' => 'Juara 1 Lomba Pidato Bahasa Indonesia', 'tahun' => 2023],
            ['id_siswa' => 9, 'nama_prestasi' => 'Juara 2 Lomba Kimia SMA', 'tahun' => 2024],
            ['id_siswa' => 10, 'nama_prestasi' => 'Juara 1 Lomba Desain Poster Kreatif', 'tahun' => 2025]
        ];

        foreach ($dataPrestasi as $prestasi) {
            Prestasi::create($prestasi);
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Data lengkap berhasil di-seed!');
        $this->command->info('- 50 data siswa telah ditambahkan');
        $this->command->info('- 10 data guru telah ditambahkan');
        $this->command->info('- 5 data berita telah ditambahkan');
        $this->command->info('- 10 data prestasi telah ditambahkan');
    }
}