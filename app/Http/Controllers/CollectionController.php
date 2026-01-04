<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Gender;
use App\Models\Tag;
use App\Models\ScentFamily;
use App\Models\Product;
use App\Models\HighlightNote;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index()
    {
        // Redirect to all products
        return redirect()->route('collections.show', 'all');
    }

    public function show($slug)
    {
        // Get sidebar/filter data
        $genders = Gender::where('is_active', true)->orderBy('sort_order')->get();
        $tags = Tag::where('is_active', true)->orderBy('usage_count', 'desc')->take(10)->get();
        $scentFamilies = ScentFamily::where('is_active', true)->orderBy('name')->get();
        $collections = Collection::where('is_active', true)->orderBy('sort_order')->get();
        $highlightNotes = HighlightNote::where('is_active', true)->orderBy('name')->get();

        // Handle "all" - show all products
        if ($slug === 'all') {
            $item = (object)[
                'name' => 'All Perfumes',
                'description' => 'Explore our complete collection of designer-inspired perfumes.',
                'id' => 0
            ];
            $type = 'all';
            $products = Product::where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->paginate(16);
                
            return view('collection-show', compact('item', 'type', 'products', 'genders', 'tags', 'scentFamilies', 'collections', 'highlightNotes', 'slug'));
        }

        // Handle "bestsellers" or "best-sellers" - show bestseller products
        if ($slug === 'bestsellers' || $slug === 'best-sellers') {
            $item = (object)[
                'name' => 'Bestsellers',
                'description' => 'Our most loved fragrances.',
                'id' => 0
            ];
            $type = 'special';
            $products = Product::where('status', 'active')
                ->where('is_bestseller', true)
                ->orderBy('created_at', 'desc')
                ->paginate(16);
                
            return view('collection-show', compact('item', 'type', 'products', 'genders', 'tags', 'scentFamilies', 'collections', 'highlightNotes', 'slug'));
        }

        // Handle "new-arrivals" - show new products
        if ($slug === 'new-arrivals') {
            $item = (object)[
                'name' => 'New Arrivals',
                'description' => 'Discover our latest fragrances.',
                'id' => 0
            ];
            $type = 'special';
            $products = Product::where('status', 'active')
                ->where('is_new', true)
                ->orderBy('created_at', 'desc')
                ->paginate(16);
                
            return view('collection-show', compact('item', 'type', 'products', 'genders', 'tags', 'scentFamilies', 'collections', 'highlightNotes', 'slug'));
        }

        // Try to find in Gender first
        $gender = Gender::where('slug', $slug)->where('is_active', true)->first();
        if ($gender) {
            $item = $gender;
            $type = 'gender';
            $products = $gender->products()->where('status', 'active')->orderBy('created_at', 'desc')->paginate(16);
            return view('collection-show', compact('item', 'type', 'products', 'genders', 'tags', 'scentFamilies', 'collections', 'highlightNotes', 'slug'));
        }

        // Try Tag
        $tag = Tag::where('slug', $slug)->where('is_active', true)->first();
        if ($tag) {
            $item = $tag;
            $type = 'tag';
            $products = $tag->products()->where('status', 'active')->orderBy('created_at', 'desc')->paginate(16);
            return view('collection-show', compact('item', 'type', 'products', 'genders', 'tags', 'scentFamilies', 'collections', 'highlightNotes', 'slug'));
        }

        // Try Collection
        $collection = Collection::where('slug', $slug)->where('is_active', true)->first();
        if ($collection) {
            $item = $collection;
            $type = 'collection';
            $products = $collection->products()->where('status', 'active')->orderBy('created_at', 'desc')->paginate(16);
            return view('collection-show', compact('item', 'type', 'products', 'genders', 'tags', 'scentFamilies', 'collections', 'highlightNotes', 'slug'));
        }

        // If nothing found, show all products
        $item = (object)[
            'name' => ucfirst(str_replace('-', ' ', $slug)),
            'description' => '',
            'id' => 0
        ];
        $type = 'all';
        $products = Product::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(16);
            
        return view('collection-show', compact('item', 'type', 'products', 'genders', 'tags', 'scentFamilies', 'collections', 'highlightNotes', 'slug'));
    }

    /**
     * AJAX Filter Products
     */
    public function filterProducts(Request $request)
    {
        $query = Product::where('status', 'active');

        // Gender filter
        if ($request->has('genders') && !empty($request->genders)) {
            $genderIds = array_filter($request->genders);
            if (!empty($genderIds)) {
                $query->whereHas('genders', function($q) use ($genderIds) {
                    $q->whereIn('genders.id', $genderIds);
                });
            }
        }

        // Tags filter
        if ($request->has('tags') && !empty($request->tags)) {
            $tagIds = array_filter($request->tags);
            if (!empty($tagIds)) {
                $query->whereHas('tagsList', function($q) use ($tagIds) {
                    $q->whereIn('tags.id', $tagIds);
                });
            }
        }

        // Scent Families filter
        if ($request->has('scent_families') && !empty($request->scent_families)) {
            $scentFamilyIds = array_filter($request->scent_families);
            if (!empty($scentFamilyIds)) {
                $query->whereHas('scentFamilies', function($q) use ($scentFamilyIds) {
                    $q->whereIn('scent_families.id', $scentFamilyIds);
                });
            }
        }

        // Collections filter
        if ($request->has('collections') && !empty($request->collections)) {
            $collectionIds = array_filter($request->collections);
            if (!empty($collectionIds)) {
                $query->whereHas('collectionsList', function($q) use ($collectionIds) {
                    $q->whereIn('collections.id', $collectionIds);
                });
            }
        }

        // Highlight Notes filter
        if ($request->has('highlight_notes') && !empty($request->highlight_notes)) {
            $noteIds = array_filter($request->highlight_notes);
            if (!empty($noteIds)) {
                $query->whereHas('highlightNotes', function($q) use ($noteIds) {
                    $q->whereIn('highlight_notes.id', $noteIds);
                });
            }
        }

        // Price filter
        if ($request->has('price_min') && $request->price_min !== null) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->has('price_max') && $request->price_max !== null) {
            $query->where('price', '<=', $request->price_max);
        }

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'relevance');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(16);

        // Return HTML for products grid
        $html = view('partials.products-grid', compact('products'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'total' => $products->total(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage()
        ]);
    }
}
