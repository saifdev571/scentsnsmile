<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Moment;
use App\Traits\LogsActivity;
use App\Services\ImageKitService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MomentController extends Controller
{
    use LogsActivity;
    
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $statusFilter = $request->get('status_filter', 'all');
        $sortField = $request->get('sort_field', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');
        $perPage = $request->get('per_page', 10);

        $query = Moment::query()->withCount('products');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('slug', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($statusFilter === 'inactive') {
            $query->where('is_active', false);
        } elseif ($statusFilter === 'featured') {
            $query->where('is_featured', true);
        }

        $query->orderBy($sortField, $sortDirection);
        $moments = $query->paginate($perPage);

        $totalMoments = Moment::count();
        $activeMoments = Moment::where('is_active', true)->count();
        $featuredMoments = Moment::where('is_featured', true)->count();

        return view('admin.moments.index', [
            'moments' => $moments,
            'totalMoments' => $totalMoments,
            'activeMoments' => $activeMoments,
            'featuredMoments' => $featuredMoments,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'perPage' => $perPage,
        ]);
    }

    public function create()
    {
        // Not needed - using modal
        return redirect()->route('admin.moments.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:moments,name,NULL,id,deleted_at,NULL',
            'slug' => 'nullable|string|max:255|unique:moments,slug,NULL,id,deleted_at,NULL',
            'description' => 'nullable|string',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'show_in_navbar' => 'nullable|boolean',
            'show_in_homepage' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['show_in_navbar'] = $request->has('show_in_navbar');
        $validated['show_in_homepage'] = $request->has('show_in_homepage');

        if ($request->hasFile('image')) {
            try {
                set_time_limit(120);
                
                $imageKitService = new ImageKitService();
                $uploadResult = $imageKitService->uploadCategoryImage($request->file('image'), 'moments');

                if ($uploadResult && $uploadResult['success']) {
                    $validated['imagekit_file_id'] = $uploadResult['file_id'];
                    $validated['imagekit_url'] = $uploadResult['url'];
                    $validated['imagekit_thumbnail_url'] = $uploadResult['thumbnail_url'];
                    $validated['imagekit_file_path'] = $uploadResult['file_path'];
                    $validated['image_size'] = $uploadResult['size'];
                    $validated['original_image_size'] = $uploadResult['original_size'];
                    $validated['image_width'] = $uploadResult['width'];
                    $validated['image_height'] = $uploadResult['height'];
                    $validated['image'] = null;
                } else {
                    \Log::error('ImageKit upload failed', ['result' => $uploadResult]);

                    if (request()->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Failed to upload image to ImageKit. Please try again.',
                            'errors' => ['image' => ['Failed to upload image to ImageKit. Please try again.']]
                        ], 422);
                    }

                    return back()->withInput()->withErrors(['image' => 'Failed to upload image to ImageKit. Please try again.']);
                }
            } catch (\Exception $e) {
                \Log::error('ImageKit upload exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Image upload failed: ' . $e->getMessage(),
                        'errors' => ['image' => ['Image upload failed: ' . $e->getMessage()]]
                    ], 422);
                }

                return back()->withInput()->withErrors(['image' => 'Image upload failed: ' . $e->getMessage()]);
            }
        }

        try {
            $moment = Moment::create($validated);

            self::logActivity('created', "Created new moment: {$moment->name}", $moment);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Moment created successfully!',
                    'moment' => [
                        'id' => $moment->id,
                        'name' => $moment->name,
                        'slug' => $moment->slug,
                        'description' => $moment->description,
                        'sort_order' => $moment->sort_order,
                        'is_active' => $moment->is_active,
                        'is_featured' => $moment->is_featured,
                        'show_in_navbar' => $moment->show_in_navbar,
                        'show_in_homepage' => $moment->show_in_homepage,
                        'imagekit_url' => $moment->imagekit_url,
                        'imagekit_thumbnail_url' => $moment->imagekit_thumbnail_url,
                        'created_at' => $moment->created_at->format('M d, Y'),
                    ]
                ]);
            }

            return redirect()->route('admin.moments.index')->with('success', 'Moment created successfully!');
        } catch (\Exception $e) {
            \Log::error('Moment creation failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create moment. Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Failed to create moment. Please try again.']);
        }
    }

    public function show(Moment $moment)
    {
        return view('admin.moments.show', compact('moment'));
    }

    public function edit(Moment $moment)
    {
        // Not needed - using modal
        return redirect()->route('admin.moments.index');
    }

    public function update(Request $request, Moment $moment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:moments,name,' . $moment->id . ',id,deleted_at,NULL',
            'slug' => 'nullable|string|max:255|unique:moments,slug,' . $moment->id . ',id,deleted_at,NULL',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'show_in_navbar' => 'nullable|boolean',
            'show_in_homepage' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['show_in_navbar'] = $request->has('show_in_navbar');
        $validated['show_in_homepage'] = $request->has('show_in_homepage');

        if ($request->hasFile('image')) {
            try {
                set_time_limit(120);

                if ($moment->imagekit_file_id) {
                    $imageKitService = new ImageKitService();
                    $imageKitService->deleteImage($moment->imagekit_file_id);
                }

                $imageKitService = new ImageKitService();
                $uploadResult = $imageKitService->uploadCategoryImage($request->file('image'), 'moments');

                if ($uploadResult && $uploadResult['success']) {
                    $validated['imagekit_file_id'] = $uploadResult['file_id'];
                    $validated['imagekit_url'] = $uploadResult['url'];
                    $validated['imagekit_thumbnail_url'] = $uploadResult['thumbnail_url'];
                    $validated['imagekit_file_path'] = $uploadResult['file_path'];
                    $validated['image_size'] = $uploadResult['size'];
                    $validated['original_image_size'] = $uploadResult['original_size'];
                    $validated['image_width'] = $uploadResult['width'];
                    $validated['image_height'] = $uploadResult['height'];
                    $validated['image'] = null;
                } else {
                    \Log::error('ImageKit upload failed', ['result' => $uploadResult]);

                    if (request()->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Failed to upload image to ImageKit. Please try again.',
                            'errors' => ['image' => ['Failed to upload image to ImageKit. Please try again.']]
                        ], 422);
                    }

                    return back()->withInput()->withErrors(['image' => 'Failed to upload image to ImageKit. Please try again.']);
                }
            } catch (\Exception $e) {
                \Log::error('ImageKit upload exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Image upload failed: ' . $e->getMessage(),
                        'errors' => ['image' => ['Image upload failed: ' . $e->getMessage()]]
                    ], 422);
                }

                return back()->withInput()->withErrors(['image' => 'Image upload failed: ' . $e->getMessage()]);
            }
        }

        try {
            $moment->update($validated);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Moment updated successfully!',
                    'moment' => [
                        'id' => $moment->id,
                        'name' => $moment->name,
                        'slug' => $moment->slug,
                        'description' => $moment->description,
                        'sort_order' => $moment->sort_order,
                        'is_active' => $moment->is_active,
                        'is_featured' => $moment->is_featured,
                        'show_in_navbar' => $moment->show_in_navbar,
                        'show_in_homepage' => $moment->show_in_homepage,
                        'imagekit_url' => $moment->imagekit_url,
                        'imagekit_thumbnail_url' => $moment->imagekit_thumbnail_url,
                        'created_at' => $moment->created_at->format('M d, Y'),
                    ]
                ]);
            }

            return redirect()->route('admin.moments.index')->with('success', 'Moment updated successfully!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update moment. Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Failed to update moment. Please try again.']);
        }
    }

    public function destroy(Moment $moment)
    {
        try {
            if ($moment->imagekit_file_id) {
                $imageKitService = new ImageKitService();
                $imageKitService->deleteImage($moment->imagekit_file_id);
            }

            $moment->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Moment deleted successfully!'
                ]);
            }

            return redirect()->route('admin.moments.index')
                ->with('success', 'Moment deleted successfully!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete moment. Please try again.'
                ], 500);
            }

            return redirect()->route('admin.moments.index')
                ->with('error', 'Failed to delete moment. Please try again.');
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'moments' => 'required|array',
            'moments.*' => 'exists:moments,id'
        ]);

        try {
            $moments = Moment::whereIn('id', $request->moments)->get();

            foreach ($moments as $moment) {
                if ($moment->imagekit_file_id) {
                    $imageKitService = new ImageKitService();
                    $imageKitService->deleteImage($moment->imagekit_file_id);
                }
                $moment->delete();
            }

            return redirect()->route('admin.moments.index')->with('success', 'Selected moments deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.moments.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Moment $moment)
    {
        $moment->update(['is_active' => !$moment->is_active]);
        return back()->with('success', 'Moment status updated!');
    }

    public function toggleFeatured(Moment $moment)
    {
        $moment->update(['is_featured' => !$moment->is_featured]);
        return back()->with('success', 'Featured status updated!');
    }

    public function toggle(Request $request, Moment $moment)
    {
        try {
            $field = $request->input('field');
            $value = $request->input('value');

            if (!in_array($field, ['is_active', 'is_featured', 'show_in_navbar', 'show_in_homepage'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid field: ' . $field
                ], 400);
            }

            $boolValue = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            $moment->update([$field => $boolValue]);

            $fieldNames = [
                'is_active' => 'active status',
                'is_featured' => 'featured status', 
                'show_in_navbar' => 'navbar visibility',
                'show_in_homepage' => 'homepage visibility'
            ];

            $message = 'Moment ' . ($fieldNames[$field] ?? $field) . ' updated successfully!';

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update moment'
            ], 500);
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,feature,unfeature',
            'ids' => 'required|array',
            'ids.*' => 'exists:moments,id'
        ]);

        $action = $request->input('action');
        $ids = $request->input('ids');
        $moments = Moment::whereIn('id', $ids);

        try {
            switch ($action) {
                case 'delete':
                    $count = $moments->count();
                    $moments->delete();
                    $message = "Successfully deleted {$count} moments";
                    break;

                case 'activate':
                    $count = $moments->update(['is_active' => true]);
                    $message = "Successfully activated {$count} moments";
                    break;

                case 'deactivate':
                    $count = $moments->update(['is_active' => false]);
                    $message = "Successfully deactivated {$count} moments";
                    break;

                case 'feature':
                    $count = $moments->update(['is_featured' => true]);
                    $message = "Successfully marked {$count} moments as featured";
                    break;

                case 'unfeature':
                    $count = $moments->update(['is_featured' => false]);
                    $message = "Successfully removed {$count} moments from featured";
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bulk action failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            set_time_limit(120);
            
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
                'folder' => 'nullable|string'
            ]);

            $folder = $request->input('folder', 'moments');
            $imageKitService = new ImageKitService();
            $uploadResult = $imageKitService->uploadCategoryImage($request->file('image'), $folder);

            if ($uploadResult && $uploadResult['success']) {
                return response()->json($uploadResult);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload image to ImageKit'
                ], 422);
            }
        } catch (\Exception $e) {
            \Log::error('Instant image upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function export(Request $request)
    {
        $query = Moment::query();

        if ($request->filled('status')) {
            $query->where('is_active', $request->status == '1');
        }

        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured == '1');
        }

        if ($request->filled('navbar')) {
            $query->where('show_in_navbar', $request->navbar == '1');
        }

        $moments = $query->orderBy('sort_order')->get();

        $filename = 'moments_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($moments) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID', 'Name', 'Slug', 'Description', 
                'Sort Order', 'Active', 'Featured', 'Show in Navbar', 
                'Show in Homepage', 'Products Count', 'Created At', 'Updated At'
            ]);

            foreach ($moments as $moment) {
                fputcsv($file, [
                    $moment->id,
                    $moment->name,
                    $moment->slug,
                    $moment->description,
                    $moment->sort_order,
                    $moment->is_active ? 'Yes' : 'No',
                    $moment->is_featured ? 'Yes' : 'No',
                    $moment->show_in_navbar ? 'Yes' : 'No',
                    $moment->show_in_homepage ? 'Yes' : 'No',
                    $moment->products()->count(),
                    $moment->created_at->format('Y-m-d H:i:s'),
                    $moment->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
