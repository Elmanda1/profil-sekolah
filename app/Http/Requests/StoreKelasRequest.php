<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKelasRequest extends FormRequest
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
            'id_jurusan' => 'required|exists:tb_jurusan,id_jurusan',
            'id_jenis_kelas' => 'required|exists:tb_jenis_kelas,id_jenis_kelas',
            'nama_kelas' => 'required|string|max:255',
            'wali_kelas' => 'nullable|exists:tb_guru,id_guru'
        ];
    }
}
