<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'tb_guru';
    protected $primarykey = 'id_guru';
    public $timestamps = false;

    protected $fillable = [
        'nip',
        'nama_guru',
        'jenis_kelamin',
        'mata_pelajaran',
        'alamat'
    ];

    public function getJenisKelaminLengkapAttribute()
    {
        return $this->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('nama_guru', 'LIKE', "%{$search}%")
                     ->orWhere('nip', 'LIKE', "%{$search}%")
                     ->orwhere('mata_pelajaran', 'LIKE', "%{$search}%");
    }
}