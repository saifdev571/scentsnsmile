<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Promotion extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'discount_type',
        'discount_value',
        'min_items',
        'min_amount',
        'free_shipping',
        'free_shipping_min_items',
        'badge_text',
        'badge_color',
        'banner_title',
        'banner_subtitle',
        'cart_label',
        'starts_at',
        'ends_at',
        'is_active',
        'show_in_header',
        'show_in_cart',
        'sort_order',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_amount' => 'decimal:2',
        'min_items' => 'integer',
        'free_shipping_min_items' => 'integer',
        'free_shipping' => 'boolean',
        'is_active' => 'boolean',
        'show_in_header' => 'boolean',
        'show_in_cart' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // Slug is now handled in controller to avoid duplicates
    }

    /**
     * Scope for active promotions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            });
    }

    /**
     * Scope for header promotions
     */
    public function scopeForHeader($query)
    {
        return $query->active()->where('show_in_header', true)->orderBy('sort_order');
    }

    /**
     * Scope for cart promotions
     */
    public function scopeForCart($query)
    {
        return $query->active()->where('show_in_cart', true)->orderBy('sort_order');
    }

    /**
     * Check if promotion is currently valid
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();

        if ($this->starts_at && $this->starts_at > $now) {
            return false;
        }

        if ($this->ends_at && $this->ends_at < $now) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount for given cart
     */
    public function calculateDiscount(float $subtotal, int $itemCount): float
    {
        if (!$this->isValid()) {
            return 0;
        }

        // Check minimum conditions
        if ($itemCount < $this->min_items) {
            return 0;
        }

        if ($subtotal < $this->min_amount) {
            return 0;
        }

        // Calculate discount
        if ($this->discount_type === 'percentage') {
            return $subtotal * ($this->discount_value / 100);
        }

        return min($this->discount_value, $subtotal);
    }

    /**
     * Check if free shipping applies
     */
    public function hasFreeShipping(int $itemCount): bool
    {
        if (!$this->isValid() || !$this->free_shipping) {
            return false;
        }

        if ($this->free_shipping_min_items && $itemCount < $this->free_shipping_min_items) {
            return false;
        }

        return true;
    }

    /**
     * Get formatted discount text
     */
    public function getDiscountTextAttribute(): string
    {
        if ($this->discount_type === 'percentage') {
            return $this->discount_value . '% OFF';
        }
        return '₹' . number_format($this->discount_value, 0) . ' OFF';
    }

    /**
     * Get the primary active promotion
     */
    public static function getPrimary()
    {
        return self::active()->orderBy('sort_order')->first();
    }
}
