<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScentFamily extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
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

        static::creating(function ($scentFamily) {
            if (empty($scentFamily->slug)) {
                $scentFamily->slug = \Str::slug($scentFamily->name);
            }
        });

        static::updating(function ($scentFamily) {
            if ($scentFamily->isDirty('name') && empty($scentFamily->slug)) {
                $scentFamily->slug = \Str::slug($scentFamily->name);
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
        return $this->belongsToMany(Product::class, 'product_scent_family', 'scent_family_id', 'product_id')->withTimestamps();
    }

    public function getImageUrl()
    {
        return $this->imagekit_url;
    }

    public function getThumbnailUrl()
    {
        return $this->imagekit_thumbnail_url ?? $this->imagekit_url;
    }

    public function hasImageKitImage()
    {
        return !empty($this->imagekit_file_id) && !empty($this->imagekit_url);
    }

    public function getColorCodeAttribute()
    {
        // Map common scent family slugs to colors
        $colors = [
            'fresh' => '#dcfce7', // Green-100/200
            'floral' => '#fce7f3', // Pink-100
            'woody' => '#f3e8ff', // Purple-100 (or woody brown if preferred, e.g. #fae8d2)
            'oriental' => '#ffedd5', // Orange-100
            'amber' => '#ffedd5',
            'spicy' => '#fee2e2', // Red-100
            'fruity' => '#ffidfd', // Pinkish
            'gourmand' => '#fef3c7', // Yellow-100
            'aquatic' => '#e0f2fe', // Blue-100
            'citrus' => '#fef9c3', // Yellow-100
            'musk' => '#f3f4f6', // Gray-100
            'aromatic' => '#ecfccb', // Lime-100
        ];

        return $colors[$this->slug] ?? '#f3f4f6'; // Default gray
    }
}
