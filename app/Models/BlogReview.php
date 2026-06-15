<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogReview extends Model
{
    protected $fillable = [
        'user_id',
        'blog_id',
        'rating',
        'comment',
        'is_approved',
        'admin_reply',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
}
