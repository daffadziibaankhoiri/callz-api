<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MitraVerificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'foto_ktp' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_sim' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'foto_ktp.required' => 'Foto KTP wajib diunggah.',
            'foto_ktp.image'    => 'Foto KTP harus berupa gambar.',
            'foto_ktp.max'      => 'Ukuran foto KTP maksimal 5MB.',
            'foto_sim.required' => 'Foto SIM wajib diunggah.',
            'foto_sim.image'    => 'Foto SIM harus berupa gambar.',
            'foto_sim.max'      => 'Ukuran foto SIM maksimal 5MB.',
        ];
    }
}