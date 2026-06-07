<?php

namespace App\Http\Requests;

use App\Models\Ad;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'image_url' => 'required|url|max:500',
            'target_url' => 'required|url|max:500',
            'position' => ['required', Rule::in(Ad::$positions)],
            'area' => 'nullable|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama iklan wajib diisi.',
            'name.max' => 'Nama iklan maksimal 100 karakter.',
            'image_url.required' => 'URL gambar iklan wajib diisi.',
            'image_url.url' => 'Format URL gambar tidak valid.',
            'target_url.required' => 'URL tujuan wajib diisi.',
            'target_url.url' => 'Format URL tujuan tidak valid.',
            'position.required' => 'Posisi iklan wajib dipilih.',
            'position.in' => 'Posisi iklan tidak valid.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'start_date.date' => 'Format tanggal mulai tidak valid.',
            'end_date.required' => 'Tanggal selesai wajib diisi.',
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
        ];
    }
}
