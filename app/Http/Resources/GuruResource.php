<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuruResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_guru' => $this->id_guru,
            'nip' => $this->nip,
            'nama_guru' => $this->nama_guru,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tanggal_lahir' => $this->when($this->tanggal_lahir, fn() => $this->tanggal_lahir->format('Y-m-d')),
            'alamat' => $this->alamat,
            'nomor_telepon' => $this->nomor_telepon,
            'email' => $this->email,
            'jabatan' => $this->jabatan,
            'created_at' => $this->when($this->created_at, fn() => $this->created_at->format('Y-m-d H:i:s')),
            'updated_at' => $this->when($this->updated_at, fn() => $this->updated_at->format('Y-m-d H:i:s')),
        ];
    }
}
