<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\JurusanResource;

class KelasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_kelas' => $this->id_kelas,
            'nama_kelas' => $this->nama_kelas,
            'tingkat' => $this->tingkat,
            'id_jurusan' => $this->id_jurusan,
            'jurusan' => new JurusanResource($this->whenLoaded('jurusan')), // Assuming 'jurusan' relationship exists
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
