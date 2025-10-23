<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransaksiTabunganResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_transaksi' => $this->id_transaksi,
            'id_buku_tabungan' => $this->id_buku_tabungan,
            'jenis_transaksi' => $this->jenis_transaksi,
            'jumlah' => $this->jumlah,
            'tanggal_transaksi' => $this->tanggal_transaksi,
            'keterangan' => $this->keterangan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
