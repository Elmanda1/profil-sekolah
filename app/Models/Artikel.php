<?php
// app/Models/Artikel.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artikel extends Model
{
    protected $table = 'tb_artikel';
    protected $primaryKey = 'id_artikel';
    
    protected $fillable = [
        'id_sekolah',
        'judul',
        'isi',
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