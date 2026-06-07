<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kos_id' => 'required|integer|exists:kos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'kos_id.required' => 'ID kos wajib diisi.',
            'kos_id.exists' => 'Kos tidak ditemukan.',
        ];
    }
}