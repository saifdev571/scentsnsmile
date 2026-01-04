<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with([
            'category',
            'brand',
            'variants.size',
            'sizes',
            'genders'
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }
}
