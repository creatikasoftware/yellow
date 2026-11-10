<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'organization',
        'phone',
        'email',
        'city_country',
        'tier',
        'business_description',
        'status',
    ];
}
