<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'role_company' => ['nullable', 'string', 'max:255'],
            'quote' => ['required', 'string'],
            'avatar_initials' => ['nullable', 'string', 'max:4'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
