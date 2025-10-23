<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Siswa;

class AkunResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Load the related Siswa model if id_siswa exists
        $siswa = null;
        if ($this->id_siswa) {
            $siswa = Siswa::where('id_siswa', $this->id_siswa)->first();
        }

        return [
            'id' => $this->id, // Assuming 'id' is the primary key of Akun
            'id_siswa' => $this->id_siswa,
            'id_guru' => $this->id_guru,
            'username' => $this->username,
            'role' => $this->role,
            'nisn' => $siswa ? $siswa->nisn : null,
            'nama_siswa' => $siswa ? $siswa->nama_siswa : null,
            // Do NOT include password_hash or any sensitive password information here.
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
