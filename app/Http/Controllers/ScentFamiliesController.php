<?php

namespace App\Http\Controllers;

use App\Models\ScentFamily;
use Illuminate\Http\Request;

class ScentFamiliesController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all active scent families with their products
        // Ordered by sort_order
        $allFamilies = ScentFamily::with([
            'products' => function ($q) {
                $q->where('status', 'active');
            }
        ])
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        // Determine the active family to expand
        // If 'scent' param is provided, try to find that family
        // Otherwise default to the first one
        $activeSlug = $request->query('scent');
        $activeFamily = null;

        if ($activeSlug) {
            $activeFamily = $allFamilies->firstWhere('slug', $activeSlug);
        }

        // Fallback to first family if slug matches nothing or no slug provided
        if (!$activeFamily && $allFamilies->isNotEmpty()) {
            $activeFamily = $allFamilies->first();
        }

        return view('scent-families', compact('allFamilies', 'activeFamily'));
    }
}
