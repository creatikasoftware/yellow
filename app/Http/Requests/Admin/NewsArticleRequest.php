<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $articleId = $this->route('newsArticle')?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('news_articles', 'slug')->ignore($articleId)],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'published_at' => ['required', 'date'],
        ];
    }
}
