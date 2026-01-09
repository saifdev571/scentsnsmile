<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoTestimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_url',
        'thumbnail_url',
        'quote',
        'author_name',
        'product_text',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Scope for active items
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for sorting
    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
