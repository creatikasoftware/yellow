<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Route-level 'auth' + 'admin' middleware already restricts access;
        // by the time this request is validated the user is a confirmed admin.
        return true;
    }

    public function rules(): array
    {
        $serviceId = $this->route('service')?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('services', 'slug')->ignore($serviceId)],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            // Images are validated on three fronts: real content-sniffed MIME
            // type (`image`), allowed extensions (`mimes`), and file size.
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'icon' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'featured' => ['nullable', 'boolean'],
            'status' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'featured_image.image' => 'The featured image must be a genuine image file.',
            'featured_image.mimes' => 'The featured image must be a JPEG, PNG or WEBP file.',
            'featured_image.max' => 'The featured image may not be larger than 2MB.',
        ];
    }
}
