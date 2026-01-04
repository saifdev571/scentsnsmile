<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Setting;

class SettingsComposer
{
    public function compose(View $view)
    {
        $settings = [
            'business_name' => Setting::get('site_name', config('app.name', 'Scents N Smile')),
            'site_logo' => Setting::get('site_logo', null),
            'address' => Setting::get('site_address', ''),
            'email' => Setting::get('site_email', ''),
            'phone' => Setting::get('site_phone', ''),
            'facebook' => Setting::get('social_facebook', ''),
            'twitter' => Setting::get('social_twitter', ''),
            'instagram' => Setting::get('social_instagram', ''),
            'linkedin' => Setting::get('social_linkedin', ''),
            'youtube' => Setting::get('social_youtube', ''),
            'pinterest' => Setting::get('social_pinterest', ''),
            
            // Shipping Settings
            'shipping_charge' => (float) Setting::get('shipping_charge', 99),
            'free_shipping_threshold' => (float) Setting::get('free_shipping_threshold', 999),
        ];

        $view->with('settings', $settings);
    }
}
