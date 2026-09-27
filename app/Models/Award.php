<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Award extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'section',
        'short_description',
        'long_description',
        'image',
        'sort_order',
    ];

    public const SECTIONS = [
        'our_awards' => 'Our Awards',
        'our_categories' => 'Our Categories',
    ];

    /**
     * Always store a clean, URL-safe slug — whether it was auto-generated
     * from the name or typed in manually by an admin.
     */
    public function setSlugAttribute(?string $value): void
    {
        $this->attributes['slug'] = Str::slug($value ?: $this->name);
    }

    protected static function booted(): void
    {
        static::creating(function (Award $award) {
            if (blank($award->slug)) {
                $award->slug = $award->name;
            }
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopeSection($query, string $section)
    {
        return $query->where('section', $section);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
