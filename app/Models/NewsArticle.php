<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'image',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    /**
     * Always store a clean, URL-safe slug — whether it was auto-generated
     * from the title or typed in manually by an admin.
     */
    public function setSlugAttribute(?string $value): void
    {
        $this->attributes['slug'] = Str::slug($value ?: $this->title);
    }

    protected static function booted(): void
    {
        static::creating(function (NewsArticle $article) {
            if (blank($article->slug)) {
                $article->slug = $article->title;
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now()->toDateString())
            ->orderByDesc('published_at');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
