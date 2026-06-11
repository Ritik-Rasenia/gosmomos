<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventLead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'event_type',
        'event_date',
        'guest_count',
        'budget',
        'city',
        'message',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'event_date' => 'date',
        'guest_count' => 'integer',
        'budget' => 'decimal:2',
    ];
}
