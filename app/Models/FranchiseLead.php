<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FranchiseLead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'city',
        'state',
        'investment_budget',
        'franchise_type',
        'experience',
        'message',
        'status',
        'admin_notes',
        'follow_up_date',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
    ];

    public function documents()
    {
        return $this->hasMany(FranchiseDocument::class);
    }
}
