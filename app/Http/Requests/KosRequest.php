<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'price' => 'required|integer|min:100000|max:10000000',
            'gender' => 'required|in:putra,putri,campur',
            'description' => 'nullable|string|max:500',
            'whatsapp' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
        ];

        if ($this->isMethod('POST')) {
            $rules['name'] .= '|unique:kos,name';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kos wajib diisi.',
            'name.unique' => 'Nama kos sudah digunakan.',
            'name.max' => 'Nama kos maksimal 100 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'price.min' => 'Harga minimal Rp 100.000.',
            'price.max' => 'Harga maksimal Rp 10.000.000.',
            'gender.required' => 'Tipe kos wajib dipilih.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
        ];
    }
}
