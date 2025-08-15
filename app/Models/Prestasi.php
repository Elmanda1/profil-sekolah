<?php
// app/Models/Prestasi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prestasi extends Model
{
    protected $table = 'tb_prestasi';
    protected $primaryKey = 'id_prestasi';
    
    protected $fillable = [
        'id_sekolah',
        'judul',
        'deskripsi',
        'tanggal',
        'gambar'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }
}