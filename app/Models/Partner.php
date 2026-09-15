<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'website_url',
        'sort_order',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
