<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'session_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'company',
        'country',
        'address',
        'address_line_2',
        'city',
        'state',
        'zipcode',
        'subtotal',
        'shipping',
        'tax',
        'discount',
        'total',
        'payment_method',
        'payment_status',
        'status',
        'order_notes',
        'transaction_id',
        'paid_at',
        'shipped_at',
        'delivered_at',
        // Shiprocket fields
        'shiprocket_order_id',
        'shiprocket_shipment_id',
        'shiprocket_awb_code',
        'shiprocket_courier_id',
        'shiprocket_courier_name',
        'shiprocket_label_url',
        'shiprocket_manifest_url',
        'shiprocket_invoice_url',
        'shiprocket_status',
        'shiprocket_tracking_url',
        'shiprocket_pickup_scheduled_date',
        'shiprocket_expected_delivery_date',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'shiprocket_pickup_scheduled_date' => 'date',
        'shiprocket_expected_delivery_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFullAddressAttribute()
    {
        $parts = [
            $this->address,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->zipcode,
            $this->country
        ];
        
        return implode(', ', array_filter($parts));
    }

    /**
     * Check if order is shipped via Shiprocket
     */
    public function isShippedViaShiprocket(): bool
    {
        return !empty($this->shiprocket_order_id);
    }

    /**
     * Check if AWB is assigned
     */
    public function hasAwb(): bool
    {
        return !empty($this->shiprocket_awb_code);
    }

    /**
     * Get Shiprocket status badge color
     */
    public function getShiprocketStatusColorAttribute(): string
    {
        return match($this->shiprocket_status) {
            'NEW', 'PICKUP_SCHEDULED' => 'yellow',
            'PICKED_UP', 'IN_TRANSIT', 'OUT_FOR_DELIVERY' => 'blue',
            'DELIVERED' => 'green',
            'CANCELLED', 'RTO_INITIATED', 'RTO_DELIVERED' => 'red',
            default => 'gray',
        };
    }

    /**
     * Calculate total weight of order items
     */
    public function getTotalWeightAttribute(): float
    {
        $weight = 0;
        foreach ($this->items as $item) {
            if ($item->product) {
                $weight += ($item->product->weight ?? 0.5) * $item->quantity;
            } else {
                $weight += 0.5 * $item->quantity; // Default weight
            }
        }
        return max($weight, 0.5); // Minimum 0.5 KG
    }

    /**
     * Get package dimensions (max of all items)
     */
    public function getPackageDimensionsAttribute(): array
    {
        $length = 10;
        $breadth = 10;
        $height = 10;

        foreach ($this->items as $item) {
            if ($item->product) {
                $length = max($length, $item->product->length ?? 10);
                $breadth = max($breadth, $item->product->breadth ?? 10);
                $height = max($height, ($item->product->height ?? 10) * $item->quantity);
            }
        }

        return [
            'length' => $length,
            'breadth' => $breadth,
            'height' => min($height, 100), // Max 100cm height
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = 'ORD-' . strtoupper(uniqid());
            }
        });
    }
}
