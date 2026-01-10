<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'inspired_by',
        'retail_price',
        'retail_price_color',
        'scent_note',
        'scent_intensity',
        'slug',
        'sku',
        'description',
        'short_description',
        'additional_information',
        'ingredients',
        'price',
        'sale_price',
        'stock',
        'stock_status',
        'brand_id',
        'category_id',
        'images',
        'status',
        'visibility',
        'featured',
        'is_featured',
        'is_new',
        'is_trending',
        'is_bestseller',
        'is_topsale',
        'is_sale',
        'is_discounted',
        'show_in_homepage',
        'is_exclusive',
        'is_limited_edition',
        'is_bundle_product',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'focus_keywords',
        'canonical_url',
        'og_title',
        'og_description',
        // Product Tab Fields
        'about_scent',
        'fragrance_notes',
        'why_love_it',
        'what_makes_clean',
        'ingredients_details',
        'shipping_info',
        'disclaimer',
        'ask_question',
        // Shipping Dimensions (for Shiprocket)
        'weight',
        'length',
        'breadth',
        'height',
        'hsn_code',
        // Scent Intensity Texts
        'scent_intensity_soft_text',
        'scent_intensity_significant_text',
        'scent_intensity_statement_text'
    ];

    protected $hidden = [];

    protected $appends = [
        'image_url',
        'images_array'
    ];

    protected $casts = [
        'images' => 'array',
        'featured' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'is_trending' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_topsale' => 'boolean',
        'is_sale' => 'boolean',
        'is_discounted' => 'boolean',
        'show_in_homepage' => 'boolean',
        'is_exclusive' => 'boolean',
        'is_limited_edition' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'compare_price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'PRD-' . strtoupper(Str::random(8));
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function moments()
    {
        return $this->belongsToMany(Moment::class, 'product_moment')->withTimestamps();
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size', 'product_id', 'size_id')->withTimestamps();
    }

    public function genders()
    {
        return $this->belongsToMany(Gender::class, 'product_gender', 'product_id', 'gender_id')->withTimestamps();
    }

    public function tagsList()
    {
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id')->withTimestamps();
    }

    public function collectionsList()
    {
        return $this->belongsToMany(Collection::class, 'product_collection', 'product_id', 'collection_id')->withTimestamps();
    }

    public function highlightNotes()
    {
        return $this->belongsToMany(\App\Models\HighlightNote::class, 'product_highlight_note', 'product_id', 'highlight_note_id')->withTimestamps();
    }

    public function scentFamilies()
    {
        return $this->belongsToMany(\App\Models\ScentFamily::class, 'product_scent_family', 'product_id', 'scent_family_id')->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('is_approved', true);
    }

    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->approvedReviews()->count();
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function defaultVariant()
    {
        return $this->hasOne(ProductVariant::class)->where('is_default', true);
    }

    public function getImageUrlAttribute()
    {
        // Use the helper method for consistency
        return $this->getFirstImageUrl();
    }

    public function getImagesArrayAttribute()
    {
        $images = $this->images;
        $urls = [];

        if (is_string($images)) {
            $decoded = json_decode($images, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $images = $decoded;
            }
        }

        if (is_array($images)) {
            foreach ($images as $img) {
                if (is_string($img) && trim($img) !== '') {
                    $urls[] = trim($img);
                } elseif (is_array($img)) {
                    $u = $img['url'] ?? $img['path'] ?? null;
                    if (is_string($u) && trim($u) !== '') {
                        $urls[] = trim($u);
                    }
                }
            }
        }

        return array_values(array_unique($urls));
    }

    /**
     * Get the first product image URL
     * Uses the images column (first image)
     */
    public function getFirstImageUrl()
    {
        // Use 'images' column
        $images = $this->attributes['images'] ?? null;

        if (is_string($images) && !empty(trim($images))) {
            $decoded = json_decode($images, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && !empty($decoded)) {
                $firstImage = $decoded[0];

                // Handle if first element is string
                if (is_string($firstImage)) {
                    return $firstImage;
                }

                // Handle if first element is array with url/path
                if (is_array($firstImage)) {
                    return $firstImage['url'] ?? $firstImage['path'] ?? null;
                }
            }
        }

        if (is_array($images) && !empty($images)) {
            $firstImage = $images[0];

            if (is_string($firstImage)) {
                return $firstImage;
            }

            if (is_array($firstImage)) {
                return $firstImage['url'] ?? $firstImage['path'] ?? null;
            }
        }

        return null;
    }
}