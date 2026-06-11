<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryAssignment extends Model
{
    protected $fillable = [
        'order_id',
        'delivery_partner_id',
        'status',
        'picked_at',
        'delivered_at',
        'earnings',
    ];

    protected $casts = [
        'picked_at' => 'datetime',
        'delivered_at' => 'datetime',
        'earnings' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function partner()
    {
        return $this->belongsTo(DeliveryPartner::class, 'delivery_partner_id');
    }
}
