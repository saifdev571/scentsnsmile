<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Gender extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumb_image',
        'imagekit_file_id',
        'imagekit_url',
        'imagekit_thumbnail_url',
        'imagekit_file_path',
        'image_size',
        'original_image_size',
        'image_width',
        'image_height',
        'main_image',
        'main_imagekit_file_id',
        'main_imagekit_url',
        'main_imagekit_thumbnail_url',
        'main_imagekit_file_path',
        'main_image_size',
        'main_original_image_size',
        'main_image_width',
        'main_image_height',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gender) {
            if (empty($gender->slug)) {
                $gender->slug = Str::slug($gender->name);
            }
        });

        static::updating(function ($gender) {
            if ($gender->isDirty('name') && empty($gender->slug)) {
                $gender->slug = Str::slug($gender->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_gender', 'gender_id', 'product_id')->withTimestamps();
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

    public function getListImageUrl()
    {
        if ($this->imagekit_file_path) {
            $imageKitService = new \App\Services\ImageKitService();
            return $imageKitService->getListUrl($this->imagekit_file_path);
        }

        return null;
    }

    public function hasImageKitImage()
    {
        return !empty($this->imagekit_file_id) && !empty($this->imagekit_url);
    }

    public function hasMainImage()
    {
        return !empty($this->main_imagekit_file_id) && !empty($this->main_imagekit_url);
    }

    public function getMainImageUrl()
    {
        return $this->main_imagekit_url;
    }

    public function getMainOptimizedImageUrl($width = 540, $height = 689, $quality = 80)
    {
        if ($this->main_imagekit_file_path) {
            $imageKitService = new \App\Services\ImageKitService();
            return $imageKitService->getOptimizedUrl($this->main_imagekit_file_path, $width, $height, $quality);
        }

        return $this->getMainImageUrl();
    }

    public function getMainThumbnailUrl()
    {
        if ($this->main_imagekit_thumbnail_url) {
            return $this->main_imagekit_thumbnail_url;
        }

        if ($this->main_imagekit_file_path) {
            $imageKitService = new \App\Services\ImageKitService();
            return $imageKitService->getThumbnailUrl($this->main_imagekit_file_path);
        }

        return null;
    }

    public function getMainListImageUrl()
    {
        if ($this->main_imagekit_file_path) {
            $imageKitService = new \App\Services\ImageKitService();
            return $imageKitService->getListUrl($this->main_imagekit_file_path);
        }

        return null;
    }

    public function getFormattedImageSize()
    {
        if (!$this->image_size) {
            return 'N/A';
        }

        $size = $this->image_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return round($size, 2) . ' ' . $units[$unitIndex];
    }
}
