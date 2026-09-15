<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AwardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $awardId = $this->route('award')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('awards', 'slug')->ignore($awardId)],
            'icon' => ['required', 'string', 'max:100'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'long_description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
