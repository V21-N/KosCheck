<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'rating_cleanliness' => 'nullable|integer|min:1|max:5',
            'rating_security' => 'nullable|integer|min:1|max:5',
            'rating_facilities' => 'nullable|integer|min:1|max:5',
            'comment' => 'required|string|min:30|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Rating wajib diisi.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'comment.required' => 'Review wajib diisi.',
            'comment.min' => 'Review minimal 30 karakter.',
            'comment.max' => 'Review maksimal 1000 karakter.',
        ];
    }
}
