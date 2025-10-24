<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MassAssignSiswaToKelasRequest extends FormRequest
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
            'assignments' => 'required|array',
            'assignments.*.id_siswa' => 'required|exists:tb_siswa,id_siswa',
            'assignments.*.id_kelas' => 'required|exists:tb_kelas,id_kelas',
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:1,2'
        ];
    }
}
