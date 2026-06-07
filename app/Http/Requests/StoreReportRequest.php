<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reportable_type' => 'required|string|in:kos,review',
            'reportable_id' => 'required|integer',
            'description' => 'required|string|min:10|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'reportable_type.required' => 'Tipe pelaporan wajib diisi.',
            'reportable_type.in' => 'Tipe pelaporan tidak valid.',
            'reportable_id.required' => 'ID objek wajib diisi.',
            'description.required' => 'Deskripsi laporan wajib diisi.',
            'description.min' => 'Deskripsi minimal 10 karakter.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ];
    }
}