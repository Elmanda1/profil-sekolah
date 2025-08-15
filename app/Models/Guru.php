<?php
// app/Models/Guru.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guru extends Model
{
    protected $table = 'tb_guru';
    protected $primaryKey = 'id_guru';
    
    protected $fillable = [
        'id_sekolah',
        'nama_guru',
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
}