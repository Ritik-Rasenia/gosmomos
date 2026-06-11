<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FranchiseDocument extends Model
{
    protected $fillable = ['franchise_lead_id', 'document_type', 'file_path', 'is_verified'];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    public function lead()
    {
        return $this->belongsTo(FranchiseLead::class, 'franchise_lead_id');
    }
}
