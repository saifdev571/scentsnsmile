<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }

    public function boot(): void
    {

        View::composer(['admin.components.sidebar', 'components.admin-layout'], function ($view) {
            $view->with('siteName', Setting::get('site_name', config('app.name', 'Fashion Store')));
        });
    }
}