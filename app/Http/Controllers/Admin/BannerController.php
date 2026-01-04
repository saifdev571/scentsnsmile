<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\ImageKitService;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use LogsActivity;
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $statusFilter = $request->get('status_filter', 'all');
        $sortField = $request->get('sort_field', 'order');
        $sortDirection = $request->get('sort_direction', 'asc');
        $perPage = $request->get('per_page', 10);

        $query = Banner::query();

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        if ($statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        $query->orderBy($sortField, $sortDirection);
        $banners = $query->paginate($perPage);

        $totalBanners = Banner::count();
        $activeBanners = Banner::where('is_active', true)->count();

        return view('admin.banners.index', [
            'banners' => $banners,
            'totalBanners' => $totalBanners,
            'activeBanners' => $activeBanners,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'perPage' => $perPage,
            'activeMenu' => 'banners',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|string',
            'link' => 'nullable|url',
            'button_text' => 'nullable|string|max:100',
            'button_position' => 'nullable|in:left,center,right',
            'order' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Handle is_active separately
        if ($request->has('is_active')) {
            $isActive = $request->input('is_active');
            $validated['is_active'] = filter_var($isActive, FILTER_VALIDATE_BOOLEAN);
        } else {
            $validated['is_active'] = true;
        }
        
        // Set default values
        $validated['button_text'] = $validated['button_text'] ?? 'Explore Now';
        $validated['button_position'] = $validated['button_position'] ?? 'left';
        $validated['order'] = $validated['order'] ?? Banner::max('order') + 1;

        try {
            $banner = Banner::create($validated);
            self::logActivity('created', "Created new banner: {$banner->title}", $banner);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Banner created successfully!',
                    'banner' => $banner
                ]);
            }

            return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully!');
        } catch (\Exception $e) {
            \Log::error('Banner creation failed', ['error' => $e->getMessage()]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create banner'
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Failed to create banner']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'banner' => $banner
            ]);
        }
        
        return view('admin.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|string',
            'link' => 'nullable|url',
            'button_text' => 'nullable|string|max:100',
            'button_position' => 'nullable|in:left,center,right',
            'order' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Handle is_active separately
        if ($request->has('is_active')) {
            $isActive = $request->input('is_active');
            $validated['is_active'] = filter_var($isActive, FILTER_VALIDATE_BOOLEAN);
        } else {
            $validated['is_active'] = true;
        }

        try {
            $oldData = $banner->only(['title', 'is_active']);
            $banner->update($validated);
            self::logActivity('updated', "Updated banner: {$banner->title}", $banner, $oldData, $validated);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Banner updated successfully!',
                    'banner' => $banner
                ]);
            }

            return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully!');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update banner'
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Failed to update banner']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        try {
            $title = $banner->title;
            $banner->delete();
            self::logActivity('deleted', "Deleted banner: {$title}");

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Banner deleted successfully!'
                ]);
            }

            return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete banner'
                ], 500);
            }

            return redirect()->route('admin.banners.index')->with('error', 'Failed to delete banner');
        }
    }

    public function uploadImage(Request $request, ImageKitService $imageKit)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            ]);

            $folder = 'banners';
            $result = $imageKit->uploadCategoryImage($request->file('image'), $folder);

            if ($result && $result['success']) {
                return response()->json([
                    'success' => true,
                    'url' => $result['url'],
                    'file_id' => $result['file_id'],
                    'message' => 'Banner image uploaded successfully!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to upload banner image'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function toggle(Request $request, Banner $banner)
    {
        try {
            $field = $request->input('field');
            $value = $request->input('value');

            if (!in_array($field, ['is_active'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid field'
                ], 400);
            }

            $boolValue = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            $banner->update([$field => $boolValue]);

            $status = $boolValue ? 'activated' : 'deactivated';
            self::logActivity('updated', "Changed banner {$banner->title} status to: {$status}", $banner);

            return response()->json([
                'success' => true,
                'message' => 'Banner status updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update banner status'
            ], 500);
        }
    }

    public function updateOrder(Request $request)
    {
        try {
            $items = $request->input('items', []);

            foreach ($items as $item) {
                Banner::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            self::logActivity('updated', 'Updated banner order');

            return response()->json([
                'success' => true,
                'message' => 'Banner order updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update banner order'
            ], 500);
        }
    }

    public function fillDemo()
    {
        try {
            $demoBanners = [
                [
                    'title' => 'Summer Sale 2024',
                    'image' => 'https://ik.imagekit.io/demo/img/sample_banner_1.jpg',
                    'link' => 'https://example.com/summer-sale',
                    'order' => 1,
                    'is_active' => true,
                ],
                [
                    'title' => 'New Arrivals',
                    'image' => 'https://ik.imagekit.io/demo/img/sample_banner_2.jpg',
                    'link' => 'https://example.com/new-arrivals',
                    'order' => 2,
                    'is_active' => true,
                ],
                [
                    'title' => 'Winter Collection',
                    'image' => 'https://ik.imagekit.io/demo/img/sample_banner_3.jpg',
                    'link' => 'https://example.com/winter',
                    'order' => 3,
                    'is_active' => true,
                ],
                [
                    'title' => 'Special Discount',
                    'image' => 'https://ik.imagekit.io/demo/img/sample_banner_4.jpg',
                    'link' => 'https://example.com/discount',
                    'order' => 4,
                    'is_active' => false,
                ],
                [
                    'title' => 'Free Shipping',
                    'image' => 'https://ik.imagekit.io/demo/img/sample_banner_5.jpg',
                    'link' => 'https://example.com/free-shipping',
                    'order' => 5,
                    'is_active' => true,
                ],
            ];

            foreach ($demoBanners as $bannerData) {
                Banner::create($bannerData);
            }

            self::logActivity('created', 'Filled demo banner data');

            return response()->json([
                'success' => true,
                'message' => '5 demo banners created successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create demo banners: ' . $e->getMessage()
            ], 500);
        }
    }
}
