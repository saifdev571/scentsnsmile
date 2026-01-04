<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HighlightNote extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'imagekit_file_id',
        'imagekit_url',
        'imagekit_thumbnail_url',
        'imagekit_file_path',
        'image_size',
        'original_image_size',
        'image_width',
        'image_height',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($highlightNote) {
            if (empty($highlightNote->slug)) {
                $highlightNote->slug = \Str::slug($highlightNote->name);
            }
        });

        static::updating(function ($highlightNote) {
            if ($highlightNote->isDirty('name') && empty($highlightNote->slug)) {
                $highlightNote->slug = \Str::slug($highlightNote->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_highlight_note', 'highlight_note_id', 'product_id')->withTimestamps();
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
