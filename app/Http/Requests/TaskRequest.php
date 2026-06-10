<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Validasi Langkah 1 — Kategori
            'package_category_id'   => 'required|exists:package_categories,id',
            'job_category_id'       => 'required|exists:job_categories,id',

            // Validasi Langkah 1 — Lokasi
            'pickup_address'        => 'required|string',
            'pickup_latitude'       => 'nullable|numeric',
            'pickup_longitude'      => 'nullable|numeric',
            'destination_address'   => 'required|string',
            'destination_latitude'  => 'nullable|numeric',
            'destination_longitude' => 'nullable|numeric',
            'location_notes'        => 'nullable|string|max:500',

            // Validasi Langkah 2 — Detail Tugas
            'title'                 => 'required|string|max:255',
            'instruction_detail'    => 'nullable|string',
            'receiver_name'         => 'nullable|string|max:100',
            'receiver_phone'        => 'required|string|max:20',

            // Validasi Biaya
            'base_fee'              => 'required|integer|min:0',
            'job_category_fee'      => 'nullable|integer|min:0',
            'distance_km'           => 'nullable|numeric|min:0',
            'distance_fee'          => 'nullable|integer|min:0',
            'tips_fee'              => 'nullable|integer|min:0',
            'discount'              => 'required|integer|min:0',
            'total_estimated_fee'   => 'required|integer|min:0',
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