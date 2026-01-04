<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/debug-categories', function () {
    $parentCategories = Category::with('children')
        ->orderBy('sort_order')
        ->orderBy('name')
        ->get();
    
    $html = '<h1>Debug Categories Dropdown</h1>';
    $html .= '<p>Total Categories: ' . $parentCategories->count() . '</p>';
    $html .= '<select name="parent_id" style="width: 400px; font-size: 16px;">';
    $html .= '<option value="">None (Top Level)</option>';
    
    foreach ($parentCategories as $category) {
        if (!$category->parent_id) {
            $html .= '<option value="' . $category->id . '">' . $category->name . '</option>';
            
            if ($category->children && $category->children->count() > 0) {
                foreach ($category->children as $child) {
                    $html .= '<option value="' . $child->id . '">&nbsp;&nbsp;&nbsp;→ ' . $child->name . '</option>';
                    
                    if ($child->children && $child->children->count() > 0) {
                        foreach ($child->children as $grandchild) {
                            $html .= '<option value="' . $grandchild->id . '">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;→→ ' . $grandchild->name . '</option>';
                        }
                    }
                }
            }
        }
    }
    
    $html .= '</select>';
    
    $html .= '<h2>Raw Data:</h2><pre>';
    foreach ($parentCategories as $cat) {
        if (!$cat->parent_id) {
            $html .= "Parent: {$cat->name} (ID: {$cat->id})\n";
            $html .= "  Children: {$cat->children->count()}\n";
            foreach ($cat->children as $child) {
                $html .= "    → {$child->name} (ID: {$child->id})\n";
            }
            $html .= "\n";
        }
    }
    $html .= '</pre>';
    
    return $html;
});
