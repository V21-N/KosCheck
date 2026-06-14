<?php

namespace App\Http\Requests;

use App\Models\Kos;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKosRequest extends FormRequest
{
    public function authorize(): bool
    {
        $kos = $this->route('kos');

        if (!$kos) {
            return false;
        }

        return $this->user()?->isOwner() && $kos->user_id === $this->user()?->id
            || $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        $kos = $this->route('kos');

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                Rule::unique('kos', 'name')->ignore($kos?->id)->where(function ($query) {
                    return $query->where('user_id', $this->user()?->id);
                }),
            ],
            'address' => 'sometimes|required|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'price' => 'sometimes|required|integer|min:100000|max:50000000',
            'gender' => ['sometimes', 'required', Rule::in(Kos::$genders)],
            'description' => 'nullable|string|max:1000',
            'whatsapp' => 'sometimes|required|string|max:20',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'sometimes|boolean',
            'total_rooms' => 'nullable|integer|min:0|max:9999',
            'available_rooms' => 'nullable|integer|min:0|max:9999',
            'room_size' => 'nullable|integer|min:0|max:999',
            'deposit' => 'nullable|integer|min:0|max:999999999',
            'long_stay_discount' => 'sometimes|boolean',
            'rules' => 'nullable|array',
            'facilities' => 'nullable|array',
            'facilities.*' => 'nullable|string|max:50',
            'photos' => 'nullable|array|max:10',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp,heic|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Nama kos sudah digunakan.',
            'name.max' => 'Nama kos maksimal 100 karakter.',
            'latitude.between' => 'Latitude harus antara -90 dan 90.',
            'longitude.between' => 'Longitude harus antara -180 dan 180.',
            'price.min' => 'Harga minimal Rp 100.000.',
            'price.max' => 'Harga maksimal Rp 50.000.000.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'total_rooms.min' => 'Total kamar tidak boleh negatif.',
            'available_rooms.min' => 'Kamar tersedia tidak boleh negatif.',
            'room_size.min' => 'Luas kamar tidak boleh negatif.',
            'photos.max' => 'Maksimal 10 foto.',
            'photos.*.image' => 'File harus berupa gambar.',
            'photos.*.mimes' => 'Format gambar harus JPEG, PNG, JPG, GIF, WebP, atau HEIC.',
            'photos.*.max' => 'Ukuran foto maksimal 5MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Handle both rules[] (array format) and rules (JSON string)
        $rulesArray = $this->input('rules', []);
        $rulesArrayInput = $this->input('rules', []);

        // If rules is array from rules[], use it directly
        if (is_array($rulesArrayInput)) {
            $this->merge(['rules' => $rulesArrayInput]);
        }
        // If rules is JSON string, decode it
        elseif (is_string($rulesArrayInput)) {
            $decoded = json_decode($rulesArrayInput, true);
            if (is_array($decoded)) {
                $this->merge(['rules' => $decoded]);
            }
        }

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