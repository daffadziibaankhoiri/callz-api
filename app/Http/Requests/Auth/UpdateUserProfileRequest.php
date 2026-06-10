<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Izinkan request
    }

    public function rules(): array
    {
        return [
            'first_name'    => 'sometimes|required|string|max:100',
            'last_name'     => 'sometimes|required|string|max:100',
            'phone'         => 'sometimes|required|string|max:20',
            'tanggal_lahir' => 'sometimes|nullable|date', // Validasi tanggal lahir baru
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors'  => $validator->errors(),
        ], 422));
    }
}