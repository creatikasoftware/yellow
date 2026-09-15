<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'highlights',
        'starts_at',
        'start_time',
        'end_time',
        'location',
        'format',
        'expected_attendees',
        'image',
        'brochure_path',
        'registration_open',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'highlights' => 'array',
        'starts_at' => 'date',
        'registration_open' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function agendaItems(): HasMany
    {
        return $this->hasMany(EventAgendaItem::class)->orderBy('sort_order');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function galleryItems(): HasMany
    {
        return $this->hasMany(GalleryItem::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        // Filtering only, deliberately no ordering here — callers want
        // different sort priorities (soonest-first vs featured-first), so
        // baking an order into the scope made that impossible to override.
        return $query->where('starts_at', '>=', now()->toDateString());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
