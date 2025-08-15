<?php
// app/Models/Kelas.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kelas extends Model
{
    protected $table = 'tb_kelas';
    protected $primaryKey = 'id_kelas';
    
    protected $fillable = [
        'id_sekolah',
        'id_jurusan',
        'id_jenis_kelas',
        'nama_kelas',
        'wali_kelas'
    ];

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }

    public function jenisKelas(): BelongsTo
    {
        return $this->belongsTo(JenisKelas::class, 'id_jenis_kelas', 'id_jenis_kelas');
    }

    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'wali_kelas', 'id_guru');
    }

    public function siswa(): BelongsToMany
    {
        return $this->belongsToMany(Siswa::class, 'tb_kelas_siswa', 'id_kelas', 'id_siswa');
    }
}