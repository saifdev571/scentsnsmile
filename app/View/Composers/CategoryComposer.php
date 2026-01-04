<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Category;

class CategoryComposer
{
    public function compose(View $view)
    {
        // Fetch ALL active categories (both parent and child categories)
        // Show all categories in navbar, not just parent categories
        $headerCategories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Fetch latest 7 categories for footer
        $footerCategories = Category::where('is_active', true)
            ->latest()
            ->take(7)
            ->get();

        $view->with([
            'headerCategories' => $headerCategories,
            'footerCategories' => $footerCategories
        ]);
    }
}
