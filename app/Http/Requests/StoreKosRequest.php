<?php

namespace App\Http\Requests;

use App\Models\Kos;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isOwner() || $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kos', 'name')->where(function ($query) {
                    return $query->where('user_id', $this->user()?->id);
                }),
            ],
            'address' => 'required|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'price' => 'required|integer|min:100000|max:50000000',
            'gender' => ['required', Rule::in(Kos::$genders)],
            'description' => 'nullable|string|max:1000',
            'whatsapp' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'photos' => 'nullable|array|max:10',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kos wajib diisi.',
            'name.unique' => 'Nama kos sudah digunakan.',
            'name.max' => 'Nama kos maksimal 100 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'latitude.between' => 'Latitude harus antara -90 dan 90.',
            'longitude.between' => 'Longitude harus antara -180 dan 180.',
            'price.required' => 'Harga wajib diisi.',
            'price.min' => 'Harga minimal Rp 100.000.',
            'price.max' => 'Harga maksimal Rp 50.000.000.',
            'gender.required' => 'Tipe kos (putra/putri/campur) wajib dipilih.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'photos.max' => 'Maksimal 10 foto.',
            'photos.*.image' => 'File harus berupa gambar.',
            'photos.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'photos.*.max' => 'Ukuran foto maksimal 2MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('latitude') && $this->latitude !== null) {
            $this->merge([
                'latitude' => str_replace(',', '.', $this->latitude),
            ]);
        }

        if ($this->has('longitude') && $this->longitude !== null) {
            $this->merge([
                'longitude' => str_replace(',', '.', $this->longitude),
            ]);
        }
    }
}