<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
