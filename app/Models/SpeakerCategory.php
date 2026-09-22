<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class SpeakerCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_home_featured',
        'sort_order',
    ];

    protected $casts = [
        'is_home_featured' => 'boolean',
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
        static::creating(function (SpeakerCategory $category) {
            if (blank($category->slug)) {
                $category->slug = $category->name;
            }
        });
    }

    public function speakers(): HasMany
    {
        return $this->hasMany(Speaker::class, 'category_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
