<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table ="tb_siswa";
    protected $primaryKey = 'id_siswa';
    public $timestamps = false;

    protected $fillable = [
        'nis',
        'nama_siswa',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];

    public function getTanggalLahirFormatAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->format('d/m/Y') : '-';
    }

    public function getJenisKelaminLengkapAttribute()
    {
        return $this->jenis_kelamin = 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('manama_siswa'. 'LIKE', "%{$search}%")
                    ->orwhere('nis', 'LIKE', "%{$search}%");
    }
}