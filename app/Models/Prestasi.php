<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class Prestasi extends Model
{
    protected $table = 'tb_prestasi';
    protected $primaryKey = 'id_prestasi';
    public $timestamps = false;

    protected $fillable = [
        'id_siswa',
        'nama_prestasi',
        'tahun'
    ];

    protected $casts = [
        'tahun' => 'integer'
    ];

    // Relasi dengan model Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    // Scope untuk prestasi berdasarkan tahun
    public function scopeByYear($query, $year)
    {
        return $query->where('tahun', $year);
    }

    // Scope untuk prestasi terbaru
    public function scopeLatest($query)
    {
        return $query->orderBy('tahun', 'desc');
    }

    // Accessor untuk nama lengkap siswa
    public function getNamaSiswaAttribute()
    {
        return $this->siswa ? $this->siswa->nama : 'N/A';
    }
}