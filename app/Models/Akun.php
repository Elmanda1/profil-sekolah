<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Akun extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_akun';
    protected $primaryKey = 'id_akun';

    protected $fillable = [
        'username',
        'password',
        'role',
        'id_guru',
        'id_siswa'
    ];

    protected $hidden = [
        'password',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }
}