<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'items',
        'total_price',
        'discount_amount',
        'final_price',
        'total_items',
    ];

    protected $casts = [
        'items' => 'array',
        'total_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the bundle
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get bundle by user or session
     */
    public static function getByUserOrSession($userId = null, $sessionId = null)
    {
        $query = self::query();

        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($sessionId) {
            $query->where('session_id', $sessionId)->whereNull('user_id');
        } else {
            return null;
        }

        return $query->latest()->first();
    }

    /**
     * Create or update bundle
     */
    public static function createOrUpdate($items, $userId = null, $sessionId = null)
    {
        // If items are empty, delete the bundle
        if (empty($items)) {
            $bundle = self::getByUserOrSession($userId, $sessionId);
            if ($bundle) {
                $bundle->delete();
            }
            return null;
        }

        $bundle = self::getByUserOrSession($userId, $sessionId);

        $totalItems = collect($items)->sum('quantity');
        $totalPrice = collect($items)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Calculate discount (40% off if 2+ items)
        $discountAmount = $totalItems >= 2 ? $totalPrice * 0.40 : 0;
        $finalPrice = $totalPrice - $discountAmount;

        $data = [
            'items' => $items,
            'total_price' => $totalPrice,
            'discount_amount' => $discountAmount,
            'final_price' => $finalPrice,
            'total_items' => $totalItems,
        ];

        if ($bundle) {
            $bundle->update($data);
        } else {
            $data['user_id'] = $userId;
            $data['session_id'] = $sessionId;
            $bundle = self::create($data);
        }

        return $bundle;
    }
}
