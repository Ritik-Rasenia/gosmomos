<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryPartner extends Model
{
    protected $fillable = [
        'user_id',
        'vehicle_type',
        'vehicle_number',
        'license_number',
        'is_verified',
        'is_online',
        'current_lat',
        'current_lng',
        'rating',
        'total_deliveries',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_online' => 'boolean',
        'current_lat' => 'decimal:8',
        'current_lng' => 'decimal:8',
        'rating' => 'decimal:2',
        'total_deliveries' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignments()
    {
        return $this->hasMany(DeliveryAssignment::class);
    }

    public function scopeOnline($query)
    {
        return $query->where('is_online', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
}
