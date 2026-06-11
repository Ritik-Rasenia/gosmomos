<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'type',
        'address',
        'city',
        'state',
        'pincode',
        'lat',
        'lng',
        'phone',
        'opening_time',
        'closing_time',
        'is_active',
        'image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
