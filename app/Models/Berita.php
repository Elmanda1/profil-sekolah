<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table ='tb_berita';
    protected $primaryKey = 'id_berita';
    public $timestamps = false;

    protected $fillable = [
        'judul',
        'isi',
        'tanggal_berita',
        'penulis'
    ];

    public $casts = [
        'tanggal_berita' => 'date'
    ];

    public function scopeLatest($query)
    {
        return $query->orderBy('tanggal_berita', 'desc');
    }

    public function getTanggalFormatAttribute()
    {
        return $this->tanggal_berita->format('d F Y');
    }

    public function getExcerptAttribute()
    {
        return substr(strip_tags($this->isi), 0, 150) . '...';
    }
}