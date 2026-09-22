<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GalleryCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('galleryCategory')?->id;

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('gallery_categories', 'name')->ignore($categoryId)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('gallery_categories', 'slug')->ignore($categoryId)],
        ];
    }
}
