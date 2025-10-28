<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrestasiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_prestasi' => $this->id_prestasi,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'tanggal' => $this->tanggal ? $this->tanggal->format('Y-m-d') : null,
            'gambar' => $this->gambar,
            'tingkat' => $this->tingkat,
            'peringkat' => $this->peringkat,
            
            // Relationships (only if loaded)
            'sekolah' => $this->when($this->relationLoaded('sekolah'), function () {
                return [
                    'id_sekolah' => $this->sekolah->id_sekolah,
                    'nama_sekolah' => $this->sekolah->nama_sekolah,
                ];
            }),
        ];
    }
}
