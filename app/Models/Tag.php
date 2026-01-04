<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'imagekit_file_id',
        'imagekit_url',
        'imagekit_thumbnail_url',
        'imagekit_file_path',
        'image_size',
        'original_image_size',
        'image_width',
        'image_height',
        'is_active',
        'is_featured',
        'usage_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'usage_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            $tag->usage_count = 0;

            if (empty($tag->slug)) {
                $tag->slug = \Str::slug($tag->name);
            }
        });

        static::updating(function ($tag) {

            if ($tag->isDirty('name') && empty($tag->slug)) {
                $tag->slug = \Str::slug($tag->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->orderBy('usage_count', 'desc')->limit($limit);
    }

    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tag', 'tag_id', 'product_id')->withTimestamps();
    }

    public function getImageUrl()
    {
        return $this->imagekit_url;
    }

    public function getOptimizedImageUrl($width = 540, $height = 689, $quality = 80)
    {
        if ($this->imagekit_file_path) {
            $imageKitService = new \App\Services\ImageKitService();
            return $imageKitService->getOptimizedUrl($this->imagekit_file_path, $width, $height, $quality);
        }

        return $this->getImageUrl();
    }

    public function getThumbnailUrl()
    {
        if ($this->imagekit_thumbnail_url) {
            return $this->imagekit_thumbnail_url;
        }

        if ($this->imagekit_file_path) {
            $imageKitService = new \App\Services\ImageKitService();
            return $imageKitService->getThumbnailUrl($this->imagekit_file_path);
        }

        return null;
    }

    public function hasImageKitImage()
    {
        return !empty($this->imagekit_file_id) && !empty($this->imagekit_url);
    }
}