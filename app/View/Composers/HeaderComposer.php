<?php

namespace App\View\Composers;

use App\Models\Gender;
use App\Models\Tag;
use App\Models\Collection;
use App\Models\HighlightNote;
use App\Models\Category;
use App\Models\ScentFamily;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view)
    {
        $scentFamilies = ScentFamily::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $genders = Gender::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $featuredTags = Tag::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('usage_count', 'desc')
            ->limit(6)
            ->get();

        $featuredCollections = Collection::where('is_active', true)
            ->where('show_in_homepage', true)
            ->orderBy('sort_order', 'asc')
            ->limit(5)
            ->get();

        $highlightNotes = HighlightNote::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->limit(12)
            ->get();

        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order', 'asc')
            ->limit(8)
            ->get();

        $view->with([
            'scentFamilies' => $scentFamilies,
            'genders' => $genders,
            'featuredTags' => $featuredTags,
            'featuredCollections' => $featuredCollections,
            'highlightNotes' => $highlightNotes,
            'categories' => $categories
        ]);
    }
}
