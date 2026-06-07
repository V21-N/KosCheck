<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'converted_at' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'converted_at.date' => 'Format tanggal tidak valid.',
        ];
    }
}