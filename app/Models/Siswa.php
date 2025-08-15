<?php
// app/Models/Siswa.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Siswa extends Model
{
    protected $table = 'tb_siswa';
    protected $primaryKey = 'id_siswa';
    
    protected $fillable = [
        'id_sekolah',
        'nisn',
        'nama_siswa',
        'jenis_kelamin',
        'email',
        'no_telp',
        'alamat',
        'foto'
    ];

    protected $casts = [
        'jenis_kelamin' => 'string'
    ];

    // Accessor untuk jenis kelamin
    public function getJenisKelaminTextAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    public function kelas(): BelongsToMany
    {
        return $this->belongsToMany(Kelas::class, 'tb_kelas_siswa', 'id_siswa', 'id_kelas');
    }
}