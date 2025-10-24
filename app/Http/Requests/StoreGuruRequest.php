<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuruRequest extends FormRequest
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
            'nama_guru' => 'required|string|max:255',
            'nip' => 'nullable|string|max:20|unique:tb_guru,nip',
            'email' => 'required|email|max:255|unique:tb_guru,email',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'create_account' => 'boolean',
            'username' => 'required_if:create_account,true|string|min:3|max:50|unique:tb_akun,username',
            'password' => 'required_if:create_account,true|string|min:8|confirmed',
            'mapel' => 'nullable|array',
            'mapel.*' => 'exists:tb_mapel,id_mapel'
        ];
    }
}
