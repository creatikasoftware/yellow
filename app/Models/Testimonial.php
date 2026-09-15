<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role_company',
        'quote',
        'avatar_initials',
        'photo',
        'rating',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'rating' => 'integer',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
