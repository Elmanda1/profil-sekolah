<?php
// app/Models/JenisKelas.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisKelas extends Model
{
    protected $table = 'tb_jenis_kelas';
    protected $primaryKey = 'id_jenis_kelas';
    
    protected $fillable = [
        'nama_jenis_kelas'
    ];

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'id_jenis_kelas', 'id_jenis_kelas');
    }
}