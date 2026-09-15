<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SpeakerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $speakerId = $this->route('speaker')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('speakers', 'slug')->ignore($speakerId)],
            'role' => ['nullable', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'expertise' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
