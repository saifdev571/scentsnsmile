<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'name',
        'email',
        'rating',
        'title',
        'comment',
        'images',
        'is_verified_purchase',
        'is_approved',
        'helpful_count',
    ];

    protected $casts = [
        'images' => 'array',
        'is_verified_purchase' => 'boolean',
        'is_approved' => 'boolean',
        'helpful_count' => 'integer',
        'rating' => 'integer',
    ];

    /**
     * Get the product that owns the review
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that wrote the review
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all helpful marks for this review
     */
    public function helpfulMarks()
    {
        return $this->hasMany(ReviewHelpful::class, 'review_id');
    }

    /**
     * Scope to get only approved reviews
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope to get reviews by rating
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Get reviewer name (user name or guest name)
     */
    public function getReviewerNameAttribute()
    {
        return $this->user ? $this->user->name : $this->name;
    }

    /**
     * Get reviewer avatar (user avatar or default)
     */
    public function getReviewerAvatarAttribute()
    {
        if ($this->user && $this->user->avatar) {
            return $this->user->avatar;
        }
        
        // Generate avatar from name initials
        $name = $this->reviewer_name;
        $initials = strtoupper(substr($name, 0, 1));
        return "https://ui-avatars.com/api/?name={$initials}&background=e8a598&color=fff&size=128";
    }
}
