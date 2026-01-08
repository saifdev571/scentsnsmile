<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionalCard extends Model
{
    protected $fillable = [
        'name',
        'type',
        'media_url',
        'thumbnail_url',
        'title',
        'subtitle',
        'description',
        'button_text',
        'button_link',
        'position',
        'text_color',
        'background_color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'position' => 'integer',
    ];
}
