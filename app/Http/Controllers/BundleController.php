<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Bundle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BundleController extends Controller
{
    /**
     * Display the bundle page
     */
    public function index()
    {
        $products = Product::with(['genders', 'sizes', 'tagsList'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Get existing bundle for user or session
        $userId = Auth::check() ? Auth::id() : null;
        $sessionId = session()->getId();
        
        $existingBundle = Bundle::getByUserOrSession($userId, $sessionId);

        return view('bundle', compact('products', 'existingBundle'));
    }

    /**
     * Save bundle to database
     */
    public function save(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric',
            'items.*.name' => 'required|string',
            'items.*.image' => 'nullable|string',
        ]);

        $userId = Auth::check() ? Auth::id() : null;
        $sessionId = session()->getId();

        $bundle = Bundle::createOrUpdate($request->items, $userId, $sessionId);

        return response()->json([
            'success' => true,
            'message' => 'Bundle saved successfully',
            'bundle' => $bundle
        ]);
    }

    /**
     * Get current bundle
     */
    public function get()
    {
        $userId = Auth::check() ? Auth::id() : null;
        $sessionId = session()->getId();
        
        $bundle = Bundle::getByUserOrSession($userId, $sessionId);

        return response()->json([
            'success' => true,
            'bundle' => $bundle
        ]);
    }

    /**
     * Clear bundle
     */
    public function clear()
    {
        $userId = Auth::check() ? Auth::id() : null;
        $sessionId = session()->getId();
        
        $bundle = Bundle::getByUserOrSession($userId, $sessionId);
        
        if ($bundle) {
            $bundle->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Bundle cleared successfully'
        ]);
    }

    /**
     * Display pre-built bundles page
     */
    public function preBuilt()
    {
        // Sample bundle data - you can fetch from database later
        $bundles = [
            [
                'id' => 1,
                'name' => 'Best Sellers For Her Bundle',
                'price' => 10800,
                'original_price' => 13500,
                'discount' => '20%',
                'inspired_by' => 'Top Designer Brands',
                'image' => 'https://images.pexels.com/photos/965989/pexels-photo-965989.jpeg?auto=compress&cs=tinysrgb&w=400',
                'items' => 3
            ],
            [
                'id' => 2,
                'name' => 'Best Sellers For Him Bundle',
                'price' => 10800,
                'original_price' => 13500,
                'discount' => '20%',
                'inspired_by' => 'Premium Fragrances',
                'image' => 'https://images.pexels.com/photos/3059609/pexels-photo-3059609.jpeg?auto=compress&cs=tinysrgb&w=400',
                'items' => 3
            ],
            [
                'id' => 3,
                'name' => 'Paul Reacts - The Girls',
                'price' => 8200,
                'original_price' => 9800,
                'discount' => '16%',
                'inspired_by' => 'Floral Collection',
                'image' => 'https://images.pexels.com/photos/3373736/pexels-photo-3373736.jpeg?auto=compress&cs=tinysrgb&w=400',
                'items' => 2
            ],
            [
                'id' => 4,
                'name' => 'Daniel Rene\'s Favourites',
                'price' => 15900,
                'original_price' => 19800,
                'discount' => '20%',
                'inspired_by' => 'Celebrity Picks',
                'image' => 'https://images.pexels.com/photos/1961795/pexels-photo-1961795.jpeg?auto=compress&cs=tinysrgb&w=400',
                'items' => 4
            ],
        ];

        return view('bundles.prebuilt', compact('bundles'));
    }
}
