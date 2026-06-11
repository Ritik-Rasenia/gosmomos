<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'session_id', 'location_id'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function getTotalAttribute()
    {
        return $this->items->sum(function ($item) {
            $price = $item->variant ? $item->variant->price : $item->product->base_price;
            return $price * $item->quantity;
        });
    }
}
