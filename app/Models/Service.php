<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'featured_image',
        'icon',
        'sort_order',
        'featured',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'featured' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * Always store a clean, URL-safe slug — whether it was auto-generated
     * from the title or typed in manually by an admin.
     */
    public function setSlugAttribute(?string $value): void
    {
        $this->attributes['slug'] = Str::slug($value ?: $this->title);
    }

    /**
     * Safety net for callers that omit the "slug" key entirely (a mass
     * assignment mutator never fires for a key that isn't present at all —
     * e.g. Service::create(['title' => 'X']) from a seeder or tinker).
     */
    protected static function booted(): void
    {
        static::creating(function (Service $service) {
            if (blank($service->slug)) {
                $service->slug = $service->title;
            }
        });
    }

    /**
     * Services are looked up by slug in routes (/services/{service}), not id.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    /**
     * SEO helpers with sensible fallbacks, so a service never renders with
     * blank <title>/meta tags just because the admin left SEO fields empty.
     */
    public function getMetaTitleOrFallbackAttribute(): string
    {
        return $this->meta_title ?: $this->title;
    }

    public function getMetaDescriptionOrFallbackAttribute(): ?string
    {
        return $this->meta_description ?: $this->short_description;
    }
}
