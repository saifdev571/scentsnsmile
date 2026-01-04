<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display product details
     */
    public function show($id)
    {
        $product = Product::with(['category', 'tagsList'])->findOrFail($id);
        
        // Related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->limit(4)
            ->get();

        return view('product.show', compact('product', 'relatedProducts'));
    }
}
