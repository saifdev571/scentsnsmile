<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'mobile',
        'pincode',
        'address',
        'locality',
        'city',
        'state',
        'landmark',
        'alternate_mobile',
        'address_type',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute()
    {
        $parts = [
            $this->address,
            $this->locality,
            $this->city,
            $this->state,
            $this->pincode
        ];
        
        if ($this->landmark) {
            array_splice($parts, 2, 0, "Near {$this->landmark}");
        }
        
        return implode(', ', array_filter($parts));
    }
}
