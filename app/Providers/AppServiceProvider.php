<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\ViewComposers\CartComposer;
use App\View\Composers\CategoryComposer;
use App\View\Composers\SettingsComposer;
use App\View\Composers\HeaderComposer;
use App\View\Composers\PromotionComposer;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }

    public function boot(): void
    {
        // Share cart count and categories with header and footer partials
        View::composer('website.layouts.partials.header', CartComposer::class);
        View::composer(['website.layouts.partials.header', 'website.layouts.partials.footer'], CategoryComposer::class);
        
        // Share genders with header
        View::composer('partials.header', HeaderComposer::class);
        
        // Share promotions with header and all website views
        View::composer('partials.header', PromotionComposer::class);
        View::composer([
            'layouts.app',
            'home',
            'checkout',
            'checkout-success',
            'collection-show',
            'product-show',
            'bundle.*',
            'website.*',
        ], PromotionComposer::class);
        
        // Share settings with all website and admin views
        View::composer([
            // Main layouts
            'layouts.app',
            'website.layouts.app',
            'website.layouts.partials.header',
            'website.layouts.partials.footer',
            
            // Partials
            'partials.header',
            'partials.footer',
            
            // Auth pages
            'website.auth.*',
            
            // Website pages
            'website.pages.*',
            
            // Admin
            'admin.components.sidebar',
            'admin.layouts.app'
        ], SettingsComposer::class);
    }
}