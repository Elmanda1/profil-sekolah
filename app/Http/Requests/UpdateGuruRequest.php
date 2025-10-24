<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UpdateGuruRequest extends FormRequest
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
        $guruId = $this->route('guru')->id_guru;
        return [
            'id_sekolah' => 'required|exists:tb_sekolah,id_sekolah',
            'nama_guru' => 'required|string|max:255',
            'nip' => ['nullable', 'string', 'max:20', Rule::unique('tb_guru', 'nip')->ignore($guruId, 'id_guru')],
            'email' => ['required', 'email', 'max:255', Rule::unique('tb_guru', 'email')->ignore($guruId, 'id_guru')],
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'mapel' => 'nullable|array',
            'mapel.*' => 'exists:tb_mapel,id_mapel'
        ];
    }
}
