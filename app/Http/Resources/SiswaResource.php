<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * OPTIMIZED: Only return essential fields for list view
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_siswa' => $this->id_siswa,
            'nisn' => $this->nisn,
            'nama_siswa' => $this->nama_siswa,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tanggal_lahir' => $this->tanggal_lahir ? $this->tanggal_lahir->format('Y-m-d') : null,
            'alamat' => $this->alamat,
            
            // Conditional fields (only if loaded)
            'email' => $this->when($this->email, $this->email),
            'no_telp' => $this->when($this->no_telp, $this->no_telp),
            'foto' => $this->when($this->foto, $this->foto),
            
            // Relationships (only if loaded)
            'sekolah' => $this->when($this->relationLoaded('sekolah'), function () {
                return [
                    'id_sekolah' => $this->sekolah->id_sekolah,
                    'nama_sekolah' => $this->sekolah->nama_sekolah,
                ];
            }),
            
            'akun' => $this->when($this->relationLoaded('akun'), function () {
                return [
                    'id_akun' => $this->akun->id_akun,
                    'username' => $this->akun->username,
                ];
            }),
            
            'kelas' => $this->when($this->relationLoaded('kelas'), function () {
                return $this->kelas->map(function ($kelas) {
                    return [
                        'id_kelas' => $kelas->id_kelas,
                        'nama_kelas' => $kelas->nama_kelas,
                    ];
                });
            }),
        ];
    }
}