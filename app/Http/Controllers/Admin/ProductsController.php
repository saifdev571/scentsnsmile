<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Size;
use App\Models\Tag;
use App\Models\Brand;
use App\Models\Gender;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageKitService;

class ProductsController extends Controller
{
    use LogsActivity;
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $filterStatus = $request->get('filter_status', '');
        $filterCategory = $request->get('filter_category', '');
        $sortField = $request->get('sort_field', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $perPage = $request->get('per_page', 10);

        $query = Product::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        if ($filterCategory) {
            $query->where('category_id', $filterCategory);
        }

        $query->orderBy($sortField, $sortDirection);
        $products = $query->with('category')->paginate($perPage);

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        $totalProducts = Product::count();
        $activeProducts = Product::where('status', 'active')->count();
        $featuredProducts = Product::where('is_featured', true)->count();
        $outOfStockProducts = Product::where('stock_status', 'out_of_stock')->count();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'totalProducts' => $totalProducts,
            'activeProducts' => $activeProducts,
            'featuredProducts' => $featuredProducts,
            'outOfStockProducts' => $outOfStockProducts,
            'search' => $search,
            'filterStatus' => $filterStatus,
            'filterCategory' => $filterCategory,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'perPage' => $perPage,
        ]);
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $collections = Collection::where('is_active', true)->orderBy('name')->get();
        $sizes = Size::where('is_active', true)->orderBy('name')->get();
        $genders = \App\Models\Gender::where('is_active', true)->orderBy('sort_order')->get();
        $brands = Brand::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
        $tags = Tag::where('is_active', true)
                   ->orderBy('usage_count', 'desc')
                   ->orderBy('name')
                   ->get();

        return view('admin.products.create', compact('categories', 'collections', 'sizes', 'genders', 'brands', 'tags'));
    }

    public function store(Request $request, ImageKitService $imageKit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'description' => 'required|string',
            'short_description' => 'nullable|string',
            'additional_information' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'collections' => 'nullable|array',
            'collections.*' => 'exists:collections,id',
            'genders' => 'nullable|array',
            'genders.*' => 'exists:genders,id',
            'status' => 'required|in:active,inactive,draft',
            'visibility' => 'required|in:visible,hidden,catalog,search',
            'additional_images' => 'nullable|string',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'focus_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'og_title' => 'nullable|string|max:60',
            'og_description' => 'nullable|string|max:160',
            'has_variants' => 'nullable|boolean',
            'variant_sizes' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if (empty($validated['sku'])) {
            $validated['sku'] = 'PRD-' . strtoupper(Str::random(8));
        }

        $additionalImages = $request->input('additional_images', []);
        if (is_string($additionalImages)) {
            $additionalImages = json_decode($additionalImages, true) ?? [];
        }
        $validated['images'] = $additionalImages;

        $tags = $request->input('tags', []);
        $collections = $request->input('collections', []);
        $genders = $request->input('genders', []);

        try {
            $product = Product::create($validated);

            // Sync relationships
            if (!empty($tags)) {
                $product->tagsList()->sync($tags);
            }
            
            if (!empty($collections)) {
                $product->collectionsList()->sync($collections);
            }
            
            if (!empty($genders)) {
                $product->genders()->sync($genders);
            }

            self::logActivity('created', "Created new product: {$product->name}", $product);

            if ($request->input('has_variants') === 'true') {
                $this->createProductVariants($product, $request);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product created successfully!',
                    'product' => $product
                ]);
            }

            return redirect()->route('admin.products')->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            \Log::error('Product creation failed', ['error' => $e->getMessage()]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create product: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Failed to create product: ' . $e->getMessage()]);
        }
    }

    public function show(Product $product)
    {
        // Load all relationships for the view
        $product->load([
            'category', 
            'brand', 
            'tagsList', 
            'collectionsList', 
            'sizes', 
            'genders', 
            'variants.size'
        ]);

        if (request()->expectsJson()) {
            try {

                try {
                    $product->load(['category', 'brand', 'tags', 'collections', 'sizes', 'genders', 'variants.size']);
                    
                    \Log::info('Product show debug', [
                        'product_id' => $product->id,
                        'category_id' => $product->category_id,
                        'category_loaded' => $product->relationLoaded('category'),
                        'category_exists' => $product->category ? 'yes' : 'no',
                        'category_is_object' => is_object($product->category) ? 'yes' : 'no'
                    ]);
                } catch (\Exception $e) {
                    \Log::warning('Failed to load product relationships: ' . $e->getMessage());
                }

                return response()->json([
                    'success' => true,
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'sku' => $product->sku,
                        'description' => $product->description,
                        'short_description' => $product->short_description,
                        'additional_information' => $product->additional_information,
                        'price' => $product->price,
                        'sale_price' => $product->sale_price,
                        'cost_price' => $product->cost_price ?? null,
                        'stock' => $product->stock,
                        'stock_status' => $product->stock_status,
                        'status' => $product->status,
                        'visibility' => $product->visibility ?? 'visible',
                        'is_featured' => (bool) $product->is_featured,
                        'is_new' => (bool) $product->is_new,
                        'is_sale' => (bool) $product->is_sale,
                        'is_trending' => (bool) $product->is_trending,
                        'is_bestseller' => (bool) $product->is_bestseller,
                        'is_topsale' => (bool) $product->is_topsale,
                        'is_exclusive' => (bool) $product->is_exclusive,
                        'is_limited_edition' => (bool) $product->is_limited_edition,
                        'show_in_homepage' => (bool) $product->show_in_homepage,

                        'category' => $product->category ? [
                            'id' => $product->category->id,
                            'name' => $product->category->name,
                            'slug' => $product->category->slug ?? null
                        ] : null,

                        'brand' => $product->brand ? [
                            'id' => $product->brand->id,
                            'name' => $product->brand->name,
                            'slug' => $product->brand->slug ?? null
                        ] : null,

                        'image' => $product->image_url,
                        'images' => $this->getProductImages($product),

                        'tags' => $this->processProductField($product, 'tags'),

                        'collections' => $this->processProductField($product, 'collections'),

                        'sizes' => $this->processProductField($product, 'sizes'),

                        'genders' => $this->processProductField($product, 'genders'),

                        'variants' => $product->variants->map(function($variant) {
                            return [
                                'id' => $variant->id,
                                'sku' => $variant->sku,
                                'size' => $variant->size ? [
                                    'id' => $variant->size->id,
                                    'name' => $variant->size->name
                                ] : null,
                                'price' => $variant->price,
                                'stock' => $variant->stock,
                                'images' => $variant->images ?? [],
                                'is_default' => $variant->is_default,
                                'is_active' => $variant->is_active
                            ];
                        }),

                        'meta_title' => $product->meta_title,
                        'meta_description' => $product->meta_description,
                        'focus_keywords' => $product->focus_keywords,
                        'canonical_url' => $product->canonical_url,
                        'og_title' => $product->og_title,
                        'og_description' => $product->og_description,

                        'created_at' => $product->created_at ? $product->created_at->format('M d, Y H:i A') : null,
                        'updated_at' => $product->updated_at ? $product->updated_at->format('M d, Y H:i A') : null,
                    ]
                ]);
            } catch (\Exception $e) {
                \Log::error('Error in product show method', [
                    'product_id' => $product->id,
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Error loading product: ' . $e->getMessage()
                ], 500);
            }
        }

        return view('admin.products.show', compact('product'));
    }

    public function toggle(Request $request, Product $product)
    {
        try {
            $field = $request->input('field');
            $value = $request->input('value');

            if (!in_array($field, ['status', 'is_featured', 'stock_status'])) {
                return response()->json(['success' => false, 'message' => 'Invalid field: ' . $field], 400);
            }

            if ($field === 'status') {
                if (!in_array($value, ['active', 'inactive', 'draft'])) {
                    return response()->json(['success' => false, 'message' => 'Invalid status value'], 400);
                }
                $product->update([$field => $value]);
            } elseif ($field === 'is_featured') {
                $boolValue = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                $product->update([$field => $boolValue]);
            } elseif ($field === 'stock_status') {
                if (!in_array($value, ['in_stock', 'out_of_stock'])) {
                    return response()->json(['success' => false, 'message' => 'Invalid stock status value'], 400);
                }
                $product->update([$field => $value]);
            }

            return response()->json(['success' => true, 'message' => 'Product updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update product'], 500);
        }
    }

    public function bulkAction(Request $request)
    {
        try {
            $action = $request->input('action');
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json(['success' => false, 'message' => 'No products selected'], 400);
            }

            $count = 0;
            switch ($action) {
                case 'activate':
                    $count = Product::whereIn('id', $ids)->update(['status' => 'active']);
                    $message = "$count product(s) activated!";
                    break;
                case 'deactivate':
                    $count = Product::whereIn('id', $ids)->update(['status' => 'inactive']);
                    $message = "$count product(s) deactivated!";
                    break;
                case 'feature':
                    $count = Product::whereIn('id', $ids)->update(['is_featured' => true]);
                    $message = "$count product(s) marked as featured!";
                    break;
                case 'unfeature':
                    $count = Product::whereIn('id', $ids)->update(['is_featured' => false]);
                    $message = "$count product(s) removed from featured!";
                    break;
                case 'in_stock':
                    $count = Product::whereIn('id', $ids)->update(['stock_status' => 'in_stock']);
                    $message = "$count product(s) marked as in stock!";
                    break;
                case 'out_of_stock':
                    $count = Product::whereIn('id', $ids)->update(['stock_status' => 'out_of_stock']);
                    $message = "$count product(s) marked as out of stock!";
                    break;
                case 'delete':
                    $count = Product::whereIn('id', $ids)->delete();
                    $message = "$count product(s) deleted!";
                    break;
                default:
                    return response()->json(['success' => false, 'message' => 'Invalid action'], 400);
            }

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to perform bulk action'], 500);
        }
    }

    public function export(Request $request)
    {
        $query = Product::query();

        $search = $request->get('search', '');
        $filterStatus = $request->get('filter_status', '');
        $filterCategory = $request->get('filter_category', '');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }

        if ($filterCategory) {
            $query->where('category_id', $filterCategory);
        }

        $products = $query->with('category')->orderBy('created_at', 'desc')->get();
        $filename = 'products_' . date('Y-m-d_His') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"$filename\""];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'SKU', 'Category', 'Price', 'Sale Price', 'Stock', 'Stock Status', 'Status', 'Featured', 'Created At']);
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id, 
                    $product->name, 
                    $product->sku ?? 'N/A',
                    $product->category ? $product->category->name : 'Uncategorized',
                    $product->price ?? 0,
                    $product->sale_price ?? 0,
                    $product->stock ?? 0,
                    $product->stock_status ?? 'in_stock',
                    $product->status,
                    $product->is_featured ? 'Yes' : 'No',
                    $product->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'slug' => 'sometimes|required|string|max:255|unique:products,slug,' . $product->id,
                'sku' => 'sometimes|nullable|string|max:100',
                'description' => 'sometimes|required|string',
                'short_description' => 'sometimes|nullable|string',
                'additional_information' => 'sometimes|nullable|string',
                'ingredients' => 'sometimes|nullable|string',
                'price' => 'sometimes|required|numeric|min:0',
                'sale_price' => 'sometimes|nullable|numeric|min:0',
                'stock' => 'sometimes|required|integer|min:0',
                'stock_status' => 'sometimes|required|in:in_stock,out_of_stock',
                'brand_id' => 'sometimes|nullable|exists:brands,id',
                'category_id' => 'sometimes|nullable|exists:categories,id',
                'images' => 'sometimes|nullable',
                'status' => 'sometimes|required|in:active,inactive,draft',
                'visibility' => 'sometimes|required|in:visible,hidden,catalog,search',
                'meta_title' => 'sometimes|nullable|string|max:60',
                'meta_description' => 'sometimes|nullable|string|max:160',
                'focus_keywords' => 'sometimes|nullable|string',
                'canonical_url' => 'sometimes|nullable|url',
                'og_title' => 'sometimes|nullable|string|max:60',
                'og_description' => 'sometimes|nullable|string|max:160',
                'tags' => 'sometimes|nullable|array',
                'tags.*' => 'exists:tags,id',
                'collections' => 'sometimes|nullable|array',
                'collections.*' => 'exists:collections,id',
                'genders' => 'sometimes|nullable|array',
                'genders.*' => 'exists:genders,id',
            ]);

            $tags = $validated['tags'] ?? null;
            $collections = $validated['collections'] ?? null;
            $genders = $validated['genders'] ?? null;
            unset($validated['tags'], $validated['collections'], $validated['genders']);

            $oldData = $product->only(['name', 'price', 'status', 'stock']);
            $product->update($validated);

            self::logActivity('updated', "Updated product: {$product->name}", $product, $oldData, $validated);

            if ($tags !== null) {
                $product->tagsList()->sync($tags);
            }
            if ($collections !== null) {
                $product->collectionsList()->sync($collections);
            }
            if ($genders !== null) {
                $product->genders()->sync($genders);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product updated successfully!',
                    'product' => $product
                ]);
            }

            return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Product update failed', ['error' => $e->getMessage(), 'product_id' => $product->id]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update product: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Failed to update product: ' . $e->getMessage()]);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Product deleted successfully!']);
            }
            return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to delete product.'], 500);
            }
            return redirect()->route('admin.products')->with('error', 'Failed to delete product.');
        }
    }

    public function updateStatus(Request $request, Product $product)
    {
        $request->validate([
            'status' => 'required|string|in:active,inactive,draft'
        ]);

        $product->update(['status' => $request->status]);
        return back()->with('success', 'Product status updated!');
    }

    public function toggleFeatured(Product $product)
    {
        $product->update(['featured' => !$product->featured]);
        return back()->with('success', 'Featured status updated!');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*' => 'exists:products,id'
        ]);

        Product::whereIn('id', $request->products)->delete();
        return back()->with('success', 'Selected products deleted!');
    }

    public function clearSession()
    {
        session()->forget('product_data');
        \Log::info('Product creation session cleared by user');

        return response()->json([
            'success' => true,
            'message' => 'Session cleared successfully'
        ]);
    }

    public function createStep1()
    {
        $productData = session('product_data', []);
        $highlightNotes = \App\Models\HighlightNote::where('is_active', true)->orderBy('name')->get();
        $scentFamilies = \App\Models\ScentFamily::where('is_active', true)->orderBy('name')->get();
        return view('admin.products.create.step1', compact('productData', 'highlightNotes', 'scentFamilies'));
    }

    public function processStep1(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255',
                'sku' => 'nullable|string|max:100',
                'inspired_by' => 'nullable|string|max:255',
                'retail_price' => 'nullable|numeric|min:0',
                'retail_price_color' => 'nullable|string|max:20',
                'about' => 'nullable|string',
                'notes' => 'nullable|string',
                'ingredients' => 'nullable|string',
                'details' => 'nullable|string',
                'genders' => 'nullable|array',
                'genders.*' => 'exists:genders,id',
                // Product Tab Fields
                'about_scent' => 'nullable|string',
                'fragrance_notes' => 'nullable|string',
                'why_love_it' => 'nullable|string',
                'what_makes_clean' => 'nullable|string',
                'ingredients_details' => 'nullable|string',
                'shipping_info' => 'nullable|string',
                'disclaimer' => 'nullable|string',
                'ask_question' => 'nullable|string',
                // Highlight Notes
                'highlight_notes' => 'nullable|array',
                'highlight_notes.*' => 'exists:highlight_notes,id',
                // Scent Intensity
                'scent_intensity' => 'nullable|in:soft,significant,statement',
                // Scent Families
                'scent_families' => 'nullable|array',
                'scent_families.*' => 'exists:scent_families,id',
            ]);

            if (empty($validated['slug'])) {
                $baseSlug = Str::slug($validated['name']);
                $slug = $baseSlug;
                $counter = 1;

                while (Product::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                $validated['slug'] = $slug;
            }

            // Clean empty HTML content
            foreach (['about', 'notes', 'ingredients', 'details', 'about_scent', 'fragrance_notes', 'why_love_it', 'what_makes_clean', 'ingredients_details', 'shipping_info', 'disclaimer', 'ask_question'] as $field) {
                if (isset($validated[$field])) {
                    $cleanContent = trim(strip_tags($validated[$field]));
                    if (empty($cleanContent)) {
                        $validated[$field] = null;
                    }
                }
            }

            // Map new fields to old database columns for backward compatibility
            $validated['description'] = $validated['about'] ?? null; // about -> description
            $validated['short_description'] = $validated['notes'] ?? null; // notes -> short_description
            $validated['additional_information'] = $validated['details'] ?? null; // details -> additional_information
            // ingredients will be stored as is (new column)

            // Remove the temporary field names since we've mapped them
            unset($validated['about']);
            unset($validated['notes']);
            unset($validated['details']);

            \Log::info('Step 1 - Fields received', [
                'about' => isset($validated['about']),
                'notes' => isset($validated['notes']),
                'ingredients' => isset($validated['ingredients']),
                'details' => isset($validated['details']),
                'inspired_by' => $validated['inspired_by'] ?? 'NOT SET',
                'retail_price' => $validated['retail_price'] ?? 'NOT SET',
                'retail_price_color' => $validated['retail_price_color'] ?? 'NOT SET',
            ]);

            $productData = array_merge(session('product_data', []), $validated);
            session(['product_data' => $productData]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Step 1 completed successfully!',
                    'next_step_url' => route('admin.products.create.step2'),
                    'data' => $validated
                ]);
            }

            return redirect()->route('admin.products.create.step2');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->validator->errors()
                ], 422);
            }

            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function createStep2()
    {
        $productData = session('product_data', []);
        if (empty($productData)) {
            return redirect()->route('admin.products.create.step1')->with('error', 'Please complete Step 1 first.');
        }
        return view('admin.products.create.step2', compact('productData'));
    }

    public function processStep2(Request $request)
    {
        try {
            $validated = $request->validate([
                'additional_images' => 'nullable|string',
            ]);

            $productData = array_merge(session('product_data', []), $validated);
            session(['product_data' => $productData]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Step 2 completed successfully!',
                    'next_step_url' => route('admin.products.create.step3'),
                    'data' => $validated
                ]);
            }

            return redirect()->route('admin.products.create.step3');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->validator->errors()
                ], 422);
            }

            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function createStep3()
    {
        $productData = session('product_data', []);
        if (empty($productData)) {
            return redirect()->route('admin.products.create.step1')->with('error', 'Please complete previous steps first.');
        }

        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $collections = Collection::where('is_active', true)->orderBy('name')->get();
        $brands = Brand::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
        $tags = Tag::where('is_active', true)->orderBy('usage_count', 'desc')->orderBy('name')->get();
        $genders = Gender::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.products.create.step3', compact('productData', 'categories', 'collections', 'brands', 'tags', 'genders'));
    }

    public function processStep3(Request $request)
    {
        try {
            $validated = $request->validate([
                'brand_id' => 'nullable|exists:brands,id',
                'category_id' => 'nullable|exists:categories,id',
                'sku' => 'nullable|string|max:100',
                'collections' => 'nullable|array',
                'collections.*' => 'exists:collections,id',
                'genders' => 'nullable|array',
                'genders.*' => 'exists:genders,id',
            ]);

            if (empty($validated['sku'])) {
                $validated['sku'] = 'PRD-' . strtoupper(Str::random(8));
            }

            $baseSku = $validated['sku'];
            $sku = $baseSku;
            $counter = 1;

            while (Product::where('sku', $sku)->exists()) {
                $sku = $baseSku . '-' . $counter;
                $counter++;
            }

            $validated['sku'] = $sku;

            $productData = array_merge(session('product_data', []), $validated);
            session(['product_data' => $productData]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Step 3 completed successfully!',
                    'next_step_url' => route('admin.products.create.step4'),
                    'data' => $validated
                ]);
            }

            return redirect()->route('admin.products.create.step4');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->validator->errors()
                ], 422);
            }

            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function createStep4()
    {
        $productData = session('product_data', []);
        if (empty($productData)) {
            return redirect()->route('admin.products.create.step1')->with('error', 'Please complete previous steps first.');
        }
        return view('admin.products.create.step4', compact('productData'));
    }

    public function processStep4(Request $request)
    {
        try {
            $validated = $request->validate([
                'price' => 'required|numeric|min:0',
                'sale_price' => 'nullable|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'stock_status' => 'required|in:in_stock,out_of_stock',
            ]);

            $productData = array_merge(session('product_data', []), $validated);
            session(['product_data' => $productData]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Step 4 completed successfully!',
                    'next_step_url' => route('admin.products.create.step5'),
                    'data' => $validated
                ]);
            }

            return redirect()->route('admin.products.create.step5');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->validator->errors()
                ], 422);
            }

            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function createStep5()
    {
        $productData = session('product_data', []);
        if (empty($productData)) {
            return redirect()->route('admin.products.create.step1')->with('error', 'Please complete previous steps first.');
        }

        $sizes = Size::where('is_active', true)->orderBy('name')->get();
        $genders = \App\Models\Gender::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.products.create.step5', compact('productData', 'sizes', 'genders'));
    }

    public function processStep5(Request $request)
    {
        try {
            $validated = $request->validate([
                'has_variants' => 'nullable|boolean',
                'variant_colors' => 'nullable|string',
                'variant_sizes' => 'nullable|string',
                'variant_images' => 'nullable|string',
            ]);

            $productData = array_merge(session('product_data', []), $validated);
            session(['product_data' => $productData]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Step 5 completed successfully!',
                    'next_step_url' => route('admin.products.create.step6'),
                    'data' => $validated
                ]);
            }

            return redirect()->route('admin.products.create.step6');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->validator->errors()
                ], 422);
            }

            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function createStep6()
    {
        $productData = session('product_data', []);
        if (empty($productData)) {
            return redirect()->route('admin.products.create.step1')->with('error', 'Please complete previous steps first.');
        }
        return view('admin.products.create.step6', compact('productData'));
    }

    public function processStep6(Request $request)
    {
        try {
            $validated = $request->validate([
                'meta_title' => 'nullable|string',
                'meta_description' => 'nullable|string',
                'focus_keywords' => 'nullable|string',
                'canonical_url' => 'nullable|url',
                'og_title' => 'nullable|string|max:60',
                'og_description' => 'nullable|string',
            ]);

            $productData = array_merge(session('product_data', []), $validated);
            session(['product_data' => $productData]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Step 6 completed successfully!',
                    'next_step_url' => route('admin.products.create.step7'),
                    'data' => $validated
                ]);
            }

            return redirect()->route('admin.products.create.step7');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->validator->errors()
                ], 422);
            }

            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function createStep7()
    {
        $productData = session('product_data', []);
        if (empty($productData)) {
            return redirect()->route('admin.products.create.step1')->with('error', 'Please complete previous steps first.');
        }
        
        $tags = \App\Models\Tag::where('is_active', true)
                   ->orderBy('usage_count', 'desc')
                   ->orderBy('name')
                   ->get();
        
        return view('admin.products.create.step7', compact('productData', 'tags'));
    }

    public function processStep7(Request $request)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:active,inactive,draft',
                'visibility' => 'required|in:visible,hidden,catalog,search',
                'tags' => 'nullable|array',
                'tags.*' => 'exists:tags,id',
            ]);

        $productData = array_merge(session('product_data', []), $validated);

        try {
            // Process additional images
            $additionalImages = $productData['additional_images'] ?? '[]';
            if (is_string($additionalImages)) {
                $additionalImages = json_decode($additionalImages, true) ?? [];
            }
            $productData['images'] = $additionalImages;

            // Set defaults for optional fields
            if (!isset($productData['category_id'])) {
                $productData['category_id'] = null;
            }

            $productData['stock_status'] = $productData['stock_status'] ?? 'in_stock';
            $productData['stock'] = $productData['stock'] ?? 0;
            $productData['price'] = $productData['price'] ?? 0;

            // Clean empty HTML content
            foreach (['additional_information', 'short_description', 'ingredients'] as $field) {
                if (isset($productData[$field])) {
                    $cleanContent = trim(strip_tags($productData[$field]));
                    if (empty($cleanContent)) {
                        $productData[$field] = null;
                    }
                }
            }

            // Extract relationship data
            $hasVariants = $productData['has_variants'] ?? false;
            $variantSizes = $productData['variant_sizes'] ?? '[]';
            $tags = $productData['tags'] ?? [];
            $collections = $productData['collections'] ?? [];
            $genders = $productData['genders'] ?? [];
            $highlightNotes = $productData['highlight_notes'] ?? [];

            // Remove relationship fields before creating product
            unset($productData['additional_images']);
            unset($productData['has_variants']);
            unset($productData['variant_sizes']);
            unset($productData['tags']);
            unset($productData['collections']);
            unset($productData['genders']);
            unset($productData['highlight_notes']);

            // Create product
            $product = Product::create($productData);

            // Sync relationships
            if (!empty($tags)) {
                $product->tagsList()->sync($tags);
            }

            if (!empty($collections)) {
                $product->collectionsList()->sync($collections);
            }

            if (!empty($genders)) {
                $product->genders()->sync($genders);
            }

            if (!empty($highlightNotes)) {
                $product->highlightNotes()->sync($highlightNotes);
            }

            // Sync scent families
            $scentFamilies = $productData['scent_families'] ?? [];
            if (!empty($scentFamilies)) {
                $product->scentFamilies()->sync($scentFamilies);
            }

            // Handle size variants
            if ($hasVariants) {
                $sizeIds = json_decode($variantSizes, true) ?? [];

                if (!empty($sizeIds)) {
                    $product->sizes()->sync($sizeIds);
                    
                    // Create variants for each size
                    $variantData = [
                        'variant_sizes' => $variantSizes,
                        'variant_images' => '{}'
                    ];
                    $this->createProductVariants($product, $variantData);
                }
            }

            session()->forget('product_data');

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product created successfully!',
                    'redirect_url' => route('admin.products'),
                    'product_id' => $product->id
                ]);
            }

            return redirect()->route('admin.products')->with('success', 'Product created successfully!');

        } catch (\Exception $e) {
            $errorMessage = 'Failed to create product: ' . $e->getMessage();
            if (config('app.debug')) {
                $errorMessage .= ' (Line: ' . $e->getLine() . ')';
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => $errorMessage]);
        }

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->validator->errors()
                ], 422);
            }

            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    private function createProductVariants(Product $product, $productData)
    {
        $sizes = json_decode($productData['variant_sizes'] ?? '[]', true) ?? [];
        $colorImages = json_decode($productData['variant_images'] ?? '{}', true) ?? [];

        $hasSizes = !empty($sizes);
        $isFirstVariant = true;

        if ($hasSizes) {
            // Only size variants
            foreach ($sizes as $sizeId) {
                $this->createVariant($product, null, $sizeId, $colorImages, $isFirstVariant);
                $isFirstVariant = false;
            }
        }
    }

    private function createVariant(Product $product, $colorId, $sizeId, $colorImages, $isDefault)
    {
        $sku = $product->sku;
        if ($sizeId) {
            $size = Size::find($sizeId);
            $sku .= '-' . ($size->abbreviation ?? strtoupper(substr($size->name ?? 'SIZ', 0, 2)));
        }
        $sku .= '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

        $variantImages = [];

        ProductVariant::create([
            'product_id' => $product->id,
            'sku' => $sku,
            'color_id' => null,
            'size_id' => $sizeId,
            'price' => $product->price,
            'stock' => $product->stock,
            'images' => $variantImages,
            'is_default' => $isDefault,
            'is_active' => true,
        ]);
    }

    private function getProductImages($product)
    {
        // First check if product has images from step 2
        if (!empty($product->images_array) && is_array($product->images_array)) {
            return $product->images_array;
        }

        // Fallback: Get images from product variants
        $variantImages = [];
        try {
            $variants = $product->variants()->get();
            
            foreach ($variants as $variant) {
                if (!empty($variant->images) && is_array($variant->images)) {
                    foreach ($variant->images as $image) {
                        if (is_string($image) && !empty($image)) {
                            $variantImages[] = $image;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to fetch variant images: ' . $e->getMessage());
        }

        return array_values(array_unique($variantImages));
    }

    private function processProductField($product, $fieldName)
    {
        try {

            if ($product->relationLoaded($fieldName)) {
                $relationData = $product->$fieldName;

                if (is_object($relationData) && method_exists($relationData, 'map')) {
                    return $relationData->map(function($item) use ($fieldName) {
                        return $this->mapFieldItem($item, $fieldName);
                    })->toArray();
                }
            }

            $fieldValue = $product->$fieldName;

            if (is_array($fieldValue)) {

                return collect($fieldValue)->map(function($item) use ($fieldName) {
                    return $this->mapFieldItem($item, $fieldName);
                })->toArray();
            }

            if (is_string($fieldValue)) {
                $decoded = json_decode($fieldValue, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    return collect($decoded)->map(function($item) use ($fieldName) {
                        return $this->mapFieldItem($item, $fieldName);
                    })->toArray();
                }
            }

            return [];
        } catch (\Exception $e) {
            \Log::warning("Failed to process product field {$fieldName}: " . $e->getMessage());
            return [];
        }
    }

    private function mapFieldItem($item, $fieldName)
    {
        if (is_object($item)) {

            $mapped = [
                'id' => $item->id ?? null,
                'name' => $item->name ?? null,
                'slug' => $item->slug ?? null
            ];

            if ($fieldName === 'sizes') {
                $mapped['size'] = $item->size ?? $item->name ?? null;
            }

            return $mapped;
        } elseif (is_array($item)) {

            $mapped = [
                'id' => $item['id'] ?? null,
                'name' => $item['name'] ?? $item,
                'slug' => $item['slug'] ?? null
            ];

            if ($fieldName === 'sizes') {
                $mapped['size'] = $item['size'] ?? $item['name'] ?? $item;
            }

            return $mapped;
        } else {

            $mapped = [
                'id' => null,
                'name' => $item,
                'slug' => null
            ];

            if ($fieldName === 'sizes') {
                $mapped['size'] = $item;
            }

            return $mapped;
        }
    }

    public function editStep1(Product $product)
    {

        session()->forget('edit_product_data');

        // Map database fields to view fields
        // description -> about
        // short_description -> notes
        // ingredients -> ingredients
        // additional_information -> details
        session(['edit_product_data' => [
            'product_id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'inspired_by' => $product->inspired_by,
            'retail_price' => $product->retail_price,
            'retail_price_color' => $product->retail_price_color ?? '#B8860B',
            'about' => $product->description,
            'notes' => $product->short_description,
            'ingredients' => $product->ingredients,
            'details' => $product->additional_information,
            // Product Tab Fields
            'about_scent' => $product->about_scent,
            'fragrance_notes' => $product->fragrance_notes,
            'why_love_it' => $product->why_love_it,
            'what_makes_clean' => $product->what_makes_clean,
            'ingredients_details' => $product->ingredients_details,
            'shipping_info' => $product->shipping_info,
            'disclaimer' => $product->disclaimer,
            'ask_question' => $product->ask_question,
            // Highlight Notes
            'highlight_notes' => $product->highlightNotes->pluck('id')->toArray(),
            // Scent Intensity
            'scent_intensity' => $product->scent_intensity,
            // Scent Families
            'scent_families' => $product->scentFamilies ? $product->scentFamilies->pluck('id')->toArray() : [],
        ]]);

        $productData = session('edit_product_data', []);
        $highlightNotes = \App\Models\HighlightNote::where('is_active', true)->orderBy('name')->get();
        $scentFamilies = \App\Models\ScentFamily::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.edit.step1', compact('product', 'productData', 'highlightNotes', 'scentFamilies'));
    }

    public function processEditStep1(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'inspired_by' => 'nullable|string|max:255',
            'retail_price' => 'nullable|numeric|min:0',
            'retail_price_color' => 'nullable|string|max:20',
            'about' => 'nullable|string',
            'notes' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'details' => 'nullable|string',
            // Product Tab Fields
            'about_scent' => 'nullable|string',
            'fragrance_notes' => 'nullable|string',
            'why_love_it' => 'nullable|string',
            'what_makes_clean' => 'nullable|string',
            'ingredients_details' => 'nullable|string',
            'shipping_info' => 'nullable|string',
            'disclaimer' => 'nullable|string',
            'ask_question' => 'nullable|string',
            // Highlight Notes
            'highlight_notes' => 'nullable|array',
            'highlight_notes.*' => 'exists:highlight_notes,id',
            // Scent Intensity
            'scent_intensity' => 'nullable|in:soft,significant,statement',
            // Scent Families
            'scent_families' => 'nullable|array',
            'scent_families.*' => 'exists:scent_families,id',
        ]);

        // Clean empty HTML content
        foreach (['about', 'notes', 'ingredients', 'details', 'about_scent', 'fragrance_notes', 'why_love_it', 'what_makes_clean', 'ingredients_details', 'shipping_info', 'disclaimer', 'ask_question'] as $field) {
            if (isset($validated[$field])) {
                $cleanContent = trim(strip_tags($validated[$field], '<p><br>'));
                if ($cleanContent === '' || $cleanContent === '<p><br></p>' || $cleanContent === '<p></p>') {
                    $validated[$field] = null;
                }
            }
        }

        // Map view fields to database fields
        $updateData = [
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'inspired_by' => $validated['inspired_by'] ?? null,
            'retail_price' => $validated['retail_price'] ?? null,
            'retail_price_color' => $validated['retail_price_color'] ?? '#B8860B',
            'description' => $validated['about'] ?? null,
            'short_description' => $validated['notes'] ?? null,
            'ingredients' => $validated['ingredients'] ?? null,
            'additional_information' => $validated['details'] ?? null,
            // Product Tab Fields
            'about_scent' => $validated['about_scent'] ?? null,
            'fragrance_notes' => $validated['fragrance_notes'] ?? null,
            'why_love_it' => $validated['why_love_it'] ?? null,
            'what_makes_clean' => $validated['what_makes_clean'] ?? null,
            'ingredients_details' => $validated['ingredients_details'] ?? null,
            'shipping_info' => $validated['shipping_info'] ?? null,
            'disclaimer' => $validated['disclaimer'] ?? null,
            'ask_question' => $validated['ask_question'] ?? null,
            // Scent Intensity
            'scent_intensity' => $validated['scent_intensity'] ?? null,
        ];

        $product->update($updateData);

        // Sync highlight notes
        $highlightNotes = $validated['highlight_notes'] ?? [];
        $product->highlightNotes()->sync($highlightNotes);

        // Sync scent families
        $scentFamilies = $validated['scent_families'] ?? [];
        $product->scentFamilies()->sync($scentFamilies);

        $editData = session('edit_product_data', []);
        $editData = array_merge($editData, $validated);
        session(['edit_product_data' => $editData]);

        return redirect()->route('admin.products.edit.step2', $product)
                        ->with('success', 'Basic information updated!');
    }

    public function editStep2(Product $product)
    {
        $editData = session('edit_product_data', []);

        $editData['image'] = $product->image;
        $editData['images'] = $product->images;
        session(['edit_product_data' => $editData]);

        $productData = $editData;

        return view('admin.products.edit.step2', compact('product', 'productData'));
    }

    public function processEditStep2(Request $request, Product $product)
    {
        $validated = $request->validate([
            'main_image' => 'nullable|string',
            'additional_images' => 'nullable|string',
        ]);

        $additionalImages = $request->input('additional_images', '[]');
        if (is_string($additionalImages)) {
            $additionalImages = json_decode($additionalImages, true) ?? [];
        }
        $validated['images'] = $additionalImages;

        $product->update($validated);

        $editData = session('edit_product_data', []);
        $editData = array_merge($editData, $validated);
        session(['edit_product_data' => $editData]);

        return redirect()->route('admin.products.edit.step3', $product)
                        ->with('success', 'Product images updated!');
    }

    public function editStep3(Product $product)
    {
        $editData = session('edit_product_data', []);

        // Load product's current category, brand, tags, collections, genders
        $editData = array_merge($editData, [
            'category_id' => $product->category_id,
            'brand_id' => $product->brand_id,
            'sku' => $product->sku,
            'tags' => $product->tagsList->pluck('id')->toArray(),
            'collections' => $product->collectionsList->pluck('id')->toArray(),
            'genders' => $product->genders->pluck('id')->toArray(),
        ]);
        session(['edit_product_data' => $editData]);

        $productData = $editData;

        $categories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
        $collections = \App\Models\Collection::where('is_active', true)->orderBy('name')->get();
        $brands = \App\Models\Brand::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
        $tags = \App\Models\Tag::where('is_active', true)->orderBy('usage_count', 'desc')->orderBy('name')->get();
        $genders = \App\Models\Gender::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.products.edit.step3', compact('product', 'productData', 'categories', 'collections', 'brands', 'tags', 'genders'));
    }

    public function processEditStep3(Request $request, Product $product)
    {
        $validated = $request->validate([
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'sku' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'collections' => 'nullable|array',
            'collections.*' => 'exists:collections,id',
            'genders' => 'nullable|array',
            'genders.*' => 'exists:genders,id',
        ]);

        $product->update([
            'category_id' => $validated['category_id'] ?? null,
            'brand_id' => $validated['brand_id'] ?? null,
            'sku' => $validated['sku'] ?? $product->sku,
        ]);

        // Sync tags, collections, and genders
        if (isset($validated['tags'])) {
            $product->tagsList()->sync($validated['tags']);
        }
        if (isset($validated['collections'])) {
            $product->collectionsList()->sync($validated['collections']);
        }
        if (isset($validated['genders'])) {
            $product->genders()->sync($validated['genders']);
        }

        $editData = session('edit_product_data', []);
        $editData = array_merge($editData, $validated);
        session(['edit_product_data' => $editData]);

        return redirect()->route('admin.products.edit.step4', $product)
                        ->with('success', 'Categories & Organization updated!');
    }

    public function editStep4(Product $product)
    {
        $editData = session('edit_product_data', []);

        $editData = array_merge($editData, [
            'price' => $product->price,
            'sale_price' => $product->sale_price,
            'cost_price' => $product->cost_price,
            'stock' => $product->stock,
            'stock_status' => $product->stock_status,
            'track_inventory' => $product->track_inventory ?? 1,
        ]);
        session(['edit_product_data' => $editData]);

        $productData = $editData;

        return view('admin.products.edit.step4', compact('product', 'productData'));
    }

    public function processEditStep4(Request $request, Product $product)
    {
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock,backorder',
            'track_inventory' => 'nullable|boolean',
        ]);

        $product->update($validated);

        $editData = session('edit_product_data', []);
        $editData = array_merge($editData, $validated);
        session(['edit_product_data' => $editData]);

        return redirect()->route('admin.products.edit.step5', $product)
                        ->with('success', 'Pricing & Inventory updated!');
    }

    public function editStep5(Product $product)
    {
        $editData = session('edit_product_data', []);

        $sizes = Size::where('is_active', true)->orderBy('name')->get();
        $genders = \App\Models\Gender::where('is_active', true)->orderBy('sort_order')->get();

        $product->load(['variants']);

        $variantSizeIds = $product->variants->pluck('size_id')->filter()->unique()->values()->toArray();

        $variantImages = [];

        $editData = array_merge($editData, [
            'has_variants' => $product->variants()->exists(),
            'variant_sizes' => json_encode($variantSizeIds),
            'variant_images' => json_encode($variantImages),
        ]);
        session(['edit_product_data' => $editData]);

        $productData = $editData;

        return view('admin.products.edit.step5', compact('product', 'productData', 'sizes', 'genders'));
    }

    public function processEditStep5(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sizes' => 'nullable|array',
            'sizes.*' => 'exists:sizes,id',
            'genders' => 'nullable|array',
            'genders.*' => 'exists:genders,id',
        ]);

        // Sync sizes and genders
        if (isset($validated['sizes'])) {
            $product->sizes()->sync($validated['sizes']);
        }
        if (isset($validated['genders'])) {
            $product->genders()->sync($validated['genders']);
        }

        $editData = session('edit_product_data', []);
        $editData = array_merge($editData, $validated);
        session(['edit_product_data' => $editData]);

        return redirect()->route('admin.products.edit.step6', $product)
                        ->with('success', 'Sizes & Genders updated!');
    }

    public function editStep6(Product $product)
    {
        $editData = session('edit_product_data', []);

        $editData = array_merge($editData, [
            'meta_title' => $product->meta_title,
            'meta_description' => $product->meta_description,
            'focus_keywords' => $product->focus_keywords,
            'canonical_url' => $product->canonical_url,
            'og_title' => $product->og_title,
            'og_description' => $product->og_description,
        ]);
        session(['edit_product_data' => $editData]);

        $productData = $editData;

        return view('admin.products.edit.step6', compact('product', 'productData'));
    }

    public function processEditStep6(Request $request, Product $product)
    {
        $validated = $request->validate([
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'focus_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'og_title' => 'nullable|string|max:60',
            'og_description' => 'nullable|string',
        ]);

        $product->update($validated);

        $editData = session('edit_product_data', []);
        $editData = array_merge($editData, $validated);
        session(['edit_product_data' => $editData]);

        return redirect()->route('admin.products.edit.step7', $product)
                        ->with('success', 'SEO settings updated!');
    }

    public function editStep7(Product $product)
    {
        $editData = session('edit_product_data', []);

        $tags = \App\Models\Tag::where('is_active', true)
                   ->orderBy('usage_count', 'desc')
                   ->orderBy('name')
                   ->get();

        // Get existing product tags
        $product->load('tagsList');
        $existingTagIds = $product->tagsList->pluck('id')->toArray();

        $editData = array_merge($editData, [
            'status' => $product->status,
            'visibility' => $product->visibility ?? 'visible',
            'tags' => $existingTagIds,
            'is_featured' => $product->is_featured,
            'is_new' => $product->is_new,
            'is_trending' => $product->is_trending,
            'is_bestseller' => $product->is_bestseller,
            'is_topsale' => $product->is_topsale,
            'is_sale' => $product->is_sale,
            'show_in_homepage' => $product->show_in_homepage,
            'is_exclusive' => $product->is_exclusive,
            'is_limited_edition' => $product->is_limited_edition,
        ]);
        session(['edit_product_data' => $editData]);

        $productData = $editData;

        return view('admin.products.edit.step7', compact('product', 'productData', 'tags'));
    }

    public function processEditStep7(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:active,inactive,draft',
                'visibility' => 'required|in:visible,hidden,catalog,search',
                'tags' => 'nullable|array',
                'tags.*' => 'exists:tags,id',
                'is_featured' => 'nullable|boolean',
                'is_new' => 'nullable|boolean',
                'is_trending' => 'nullable|boolean',
                'is_bestseller' => 'nullable|boolean',
                'is_topsale' => 'nullable|boolean',
                'is_sale' => 'nullable|boolean',
                'show_in_homepage' => 'nullable|boolean',
                'is_exclusive' => 'nullable|boolean',
                'is_limited_edition' => 'nullable|boolean',
            ]);

            $editData = session('edit_product_data', []);
            $allData = array_merge($editData, $validated);

            $allData['is_featured'] = $request->has('is_featured');
            $allData['is_new'] = $request->has('is_new');
            $allData['is_trending'] = $request->has('is_trending');
            $allData['is_bestseller'] = $request->has('is_bestseller');
            $allData['is_topsale'] = $request->has('is_topsale');
            $allData['is_sale'] = $request->has('is_sale');
            $allData['show_in_homepage'] = $request->has('show_in_homepage');
            $allData['is_exclusive'] = $request->has('is_exclusive');
            $allData['is_limited_edition'] = $request->has('is_limited_edition');

            $product->update($allData);

            if (isset($allData['tags'])) {
                $product->tagsList()->sync($allData['tags'] ?? []);
            }
            if (isset($allData['collections'])) {
                $product->collectionsList()->sync($allData['collections'] ?? []);
            }

            session()->forget('edit_product_data');

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product updated successfully!',
                    'redirect_url' => route('admin.products')
                ]);
            }

            return redirect()->route('admin.products')
                            ->with('success', 'Product updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Product update failed', ['error' => $e->getMessage(), 'product_id' => $product->id]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update product: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    /**
     * Duplicate a product
     */
    public function duplicate(Product $product)
    {
        try {
            // Load all relationships
            $product->load(['tagsList', 'collectionsList', 'genders', 'variants']);

            // Create new product with copied data
            $newProduct = $product->replicate();
            
            // Modify unique fields
            $newProduct->name = $product->name . ' (Copy)';
            $newProduct->slug = Str::slug($product->name . ' Copy ' . time());
            $newProduct->sku = 'PRD-' . strtoupper(Str::random(8));
            $newProduct->status = 'draft'; // Set as draft by default
            $newProduct->is_featured = false;
            $newProduct->show_in_homepage = false;
            
            $newProduct->save();

            // Sync relationships
            if ($product->tagsList->count() > 0) {
                $newProduct->tagsList()->sync($product->tagsList->pluck('id'));
            }
            
            if ($product->collectionsList->count() > 0) {
                $newProduct->collectionsList()->sync($product->collectionsList->pluck('id'));
            }
            
            if ($product->genders->count() > 0) {
                $newProduct->genders()->sync($product->genders->pluck('id'));
            }

            // Copy variants if any
            foreach ($product->variants as $variant) {
                $newVariant = $variant->replicate();
                $newVariant->product_id = $newProduct->id;
                $newVariant->sku = 'VAR-' . strtoupper(Str::random(8));
                $newVariant->save();
            }

            self::logActivity('duplicated', "Duplicated product: {$product->name} -> {$newProduct->name}", $newProduct);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product copy ho gaya! Naya product: ' . $newProduct->name,
                    'product' => $newProduct
                ]);
            }

            return redirect()->route('admin.products')->with('success', 'Product copy ho gaya!');

        } catch (\Exception $e) {
            \Log::error('Product duplication failed', ['error' => $e->getMessage(), 'product_id' => $product->id]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product copy karne mein error: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Product copy karne mein error: ' . $e->getMessage());
        }
    }
}