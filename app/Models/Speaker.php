<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'photo',
        'sort_order',
    ];

    protected $casts = [
        'expertise' => 'array',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
