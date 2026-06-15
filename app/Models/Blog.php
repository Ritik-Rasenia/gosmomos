<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'blog_category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'is_published',
        'published_at',
        'views',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function reviews()
    {
        return $this->hasMany(BlogReview::class)->latest();
    }

    public function averageRating()
    {
        return round($this->reviews()->approved()->avg('rating') ?? 0, 1);
    }

    public function approvedReviewsCount()
    {
        return $this->reviews()->approved()->count();
    }

    public function getReadingTimeAttribute()
    {
        $wordsCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordsCount / 200);
        return $minutes > 0 ? $minutes : 1;
    }
}
