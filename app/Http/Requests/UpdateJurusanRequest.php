<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJurusanRequest extends FormRequest
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
        $jurusanId = $this->route('jurusan')->id_jurusan;
        return [
            'id_sekolah' => 'required|exists:tb_sekolah,id_sekolah',
            'nama_jurusan' => 'required|string|max:255',
            'kode_jurusan' => 'required|string|max:10|unique:tb_jurusan,kode_jurusan,' . $jurusanId . ',id_jurusan',
            'deskripsi' => 'nullable|string'
        ];
    }
}
