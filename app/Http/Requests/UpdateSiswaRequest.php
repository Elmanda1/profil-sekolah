<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiswaRequest extends FormRequest
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
        $siswaId = $this->route('siswa')->id_siswa;
        return [
            'id_sekolah' => 'required|exists:tb_sekolah,id_sekolah',
            'nisn' => 'required|string|unique:tb_siswa,nisn,' . $siswaId . ',id_siswa',
            'nama_siswa' => 'required|string|max:255',
            'email' => 'required|email|unique:tb_siswa,email,' . $siswaId . ',id_siswa',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date'
        ];
    }
}
