<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrestasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_sekolah' => 'required|exists:tb_sekolah,id_sekolah',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'tahun' => 'required|integer|min:2000',
            'tingkat' => 'required|in:Sekolah,Kabupaten/Kota,Provinsi,Nasional,Internasional',
            'peringkat' => 'required|in:Juara 1,Juara 2,Juara 3,Harapan 1,Harapan 2,Harapan 3,Finalis,Peserta',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
