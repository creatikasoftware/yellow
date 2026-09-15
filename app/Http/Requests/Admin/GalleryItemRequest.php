<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GalleryItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => [$this->isMethod('post') ? 'required' : 'nullable', 'image', 'max:4096'],
            'caption' => ['nullable', 'string', 'max:255'],
            'event_id' => ['nullable', 'exists:events,id'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
