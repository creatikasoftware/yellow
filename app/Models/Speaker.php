<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Speaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'role',
        'tagline',
        'bio',
        'expertise',
        'profile_content',
        'photo',
        'sort_order',
        'category_id',
    ];

    protected $casts = [
        'expertise' => 'array',
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
        static::creating(function (Speaker $speaker) {
            if (blank($speaker->slug)) {
                $speaker->slug = $speaker->name;
            }

            if (is_null($speaker->sort_order)) {
                $speaker->sort_order = 0;
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(SpeakerCategory::class, 'category_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
