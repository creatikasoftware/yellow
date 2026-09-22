<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

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
        static::creating(function (Event $event) {
            if (blank($event->slug)) {
                $event->slug = $event->title;
            }
        });
    }

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

    public function scopePast($query)
    {
        return $query->where('starts_at', '<', now()->toDateString());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Combine the date with the free-text "start_time" field (e.g. "09:00
     * AM") into one Carbon instance, for the countdown timer. Falls back to
     * midnight on the event date if start_time is blank or unparsable.
     */
    public function getStartsAtWithTimeAttribute(): Carbon
    {
        $date = $this->starts_at->toDateString();

        if ($this->start_time) {
            try {
                return Carbon::parse("{$date} {$this->start_time}");
            } catch (\Exception) {
                // Fall through to date-only below.
            }
        }

        return Carbon::parse($date);
    }
}
