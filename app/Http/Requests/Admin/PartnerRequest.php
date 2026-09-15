<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
