<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\KelasResource;

class SiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
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
            'tanggal_lahir' => $this->tanggal_lahir,
            'alamat' => $this->alamat,
            'nomor_telepon' => $this->nomor_telepon,
            'email' => $this->email,
            'id_kelas' => $this->id_kelas,
            'kelas' => new KelasResource($this->whenLoaded('kelas')), // Assuming 'kelas' relationship exists
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
