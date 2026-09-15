<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $eventId = $this->route('event')?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('events', 'slug')->ignore($eventId)],
            'summary' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'highlights' => ['nullable', 'string'],
            'starts_at' => ['required', 'date'],
            'start_time' => ['nullable', 'string', 'max:50'],
            'end_time' => ['nullable', 'string', 'max:50'],
            'location' => ['nullable', 'string', 'max:255'],
            'format' => ['nullable', 'string', 'max:255'],
            'expected_attendees' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:4096'],
            'registration_open' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'agenda_time' => ['nullable', 'array'],
            'agenda_title' => ['nullable', 'array'],
            'agenda_description' => ['nullable', 'array'],
        ];
    }
}
