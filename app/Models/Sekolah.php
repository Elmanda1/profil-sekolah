<?php
// app/Models/Sekolah.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sekolah extends Model
{
    protected $table = 'tb_sekolah';
    protected $primaryKey = 'id_sekolah';
    
    protected $fillable = [
        'nama_sekolah',
        'alamat',
        'no_telp',
        'email',
        'website'
    ];

    public function guru(): HasMany
    {
        return $this->hasMany(Guru::class, 'id_sekolah', 'id_sekolah');
    }

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'id_sekolah', 'id_sekolah');
    }

    public function artikel(): HasMany
    {
        return $this->hasMany(Artikel::class, 'id_sekolah', 'id_sekolah');
    }

    public function prestasi(): HasMany
    {
        return $this->hasMany(Prestasi::class, 'id_sekolah', 'id_sekolah');
    }

    public function jurusan(): HasMany
    {
        return $this->hasMany(Jurusan::class, 'id_sekolah', 'id_sekolah');
    }
}