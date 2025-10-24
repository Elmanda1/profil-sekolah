<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
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
            'nisn' => 'required|string|unique:tb_siswa,nisn',
            'nama_siswa' => 'required|string|max:255',
            'email' => 'required|email|unique:tb_siswa,email',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'nullable|date',
            'id_kelas' => 'required|exists:tb_kelas,id_kelas',
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:1,2',
            'create_account' => 'boolean',
            'username' => 'required_if:create_account,1|string|unique:tb_akun,username',
            'password' => 'required_if:create_account,1|string|min:8'
        ];
    }
}
