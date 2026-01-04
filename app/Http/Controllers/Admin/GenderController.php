<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use App\Services\ImageKitService;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenderController extends Controller
{
    use LogsActivity;
    
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $statusFilter = $request->get('status_filter', 'all');
        $sortField = $request->get('sort_field', 'sort_order');
        $sortDirection = $request->get('sort_direction', 'asc');
        $perPage = $request->get('per_page', 10);

        $query = Gender::query();

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
        }

        $query->orderBy($sortField, $sortDirection);
        $genders = $query->paginate($perPage);

        $totalGenders = Gender::count();
        $activeGenders = Gender::where('is_active', true)->count();

        return view('admin.genders.index', [
            'genders' => $genders,
            'totalGenders' => $totalGenders,
            'activeGenders' => $activeGenders,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'perPage' => $perPage,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genders,name,NULL,id,deleted_at,NULL',
            'slug' => 'nullable|string|max:255|unique:genders,slug,NULL,id,deleted_at,NULL',
            'description' => 'nullable|string',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            // Thumb image fields
            'imagekit_file_id' => 'nullable|string',
            'imagekit_url' => 'nullable|string',
            'imagekit_thumbnail_url' => 'nullable|string',
            'imagekit_file_path' => 'nullable|string',
            'image_size' => 'nullable|integer',
            'original_image_size' => 'nullable|integer',
            'image_width' => 'nullable|integer',
            'image_height' => 'nullable|integer',
            // Main image fields
            'main_imagekit_file_id' => 'nullable|string',
            'main_imagekit_url' => 'nullable|string',
            'main_imagekit_thumbnail_url' => 'nullable|string',
            'main_imagekit_file_path' => 'nullable|string',
            'main_image_size' => 'nullable|integer',
            'main_original_image_size' => 'nullable|integer',
            'main_image_width' => 'nullable|integer',
            'main_image_height' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->has('is_active');

        try {
            $gender = Gender::create($validated);

            self::logActivity('created', "Created new gender: {$gender->name}", $gender);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Gender created successfully!',
                    'gender' => [
                        'id' => $gender->id,
                        'name' => $gender->name,
                        'slug' => $gender->slug,
                        'description' => $gender->description,
                        'sort_order' => $gender->sort_order,
                        'is_active' => (bool) $gender->is_active,
                        'image_url' => $gender->getImageUrl(),
                        'imagekit_file_id' => $gender->imagekit_file_id,
                        'imagekit_url' => $gender->imagekit_url,
                        'imagekit_thumbnail_url' => $gender->imagekit_thumbnail_url,
                        'imagekit_file_path' => $gender->imagekit_file_path,
                        'main_image_url' => $gender->getMainImageUrl(),
                        'main_imagekit_file_id' => $gender->main_imagekit_file_id,
                        'main_imagekit_url' => $gender->main_imagekit_url,
                        'main_imagekit_thumbnail_url' => $gender->main_imagekit_thumbnail_url,
                        'main_imagekit_file_path' => $gender->main_imagekit_file_path,
                        'created_at' => $gender->created_at->format('M d, Y'),
                    ]
                ]);
            }

            return redirect()->route('admin.genders.index')->with('success', 'Gender created successfully!');
        } catch (\Exception $e) {
            \Log::error('Gender creation failed', ['error' => $e->getMessage()]);

            // Check if it's a duplicate entry error
            $message = 'Failed to create gender. Please try again.';
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                if (strpos($e->getMessage(), 'genders_name_unique') !== false) {
                    $message = 'A gender with this name already exists. Please use a different name.';
                } elseif (strpos($e->getMessage(), 'genders_slug_unique') !== false) {
                    $message = 'A gender with this slug already exists. Please use a different slug.';
                }
            }

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message
                ], 422);
            }

            return back()->withInput()->withErrors(['error' => $message]);
        }
    }

    public function update(Request $request, Gender $gender)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genders,name,' . $gender->id . ',id,deleted_at,NULL',
            'slug' => 'nullable|string|max:255|unique:genders,slug,' . $gender->id . ',id,deleted_at,NULL',
            'description' => 'nullable|string',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            // Thumb image fields
            'imagekit_file_id' => 'nullable|string',
            'imagekit_url' => 'nullable|string',
            'imagekit_thumbnail_url' => 'nullable|string',
            'imagekit_file_path' => 'nullable|string',
            'image_size' => 'nullable|integer',
            'original_image_size' => 'nullable|integer',
            'image_width' => 'nullable|integer',
            'image_height' => 'nullable|integer',
            // Main image fields
            'main_imagekit_file_id' => 'nullable|string',
            'main_imagekit_url' => 'nullable|string',
            'main_imagekit_thumbnail_url' => 'nullable|string',
            'main_imagekit_file_path' => 'nullable|string',
            'main_image_size' => 'nullable|integer',
            'main_original_image_size' => 'nullable|integer',
            'main_image_width' => 'nullable|integer',
            'main_image_height' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->has('is_active');

        try {
            // Delete old thumb image if new one is uploaded
            if ($request->filled('imagekit_file_id') && $gender->imagekit_file_id && $request->input('imagekit_file_id') !== $gender->imagekit_file_id) {
                $imageKitService = new ImageKitService();
                $imageKitService->deleteImage($gender->imagekit_file_id);
            }

            // Delete old main image if new one is uploaded
            if ($request->filled('main_imagekit_file_id') && $gender->main_imagekit_file_id && $request->input('main_imagekit_file_id') !== $gender->main_imagekit_file_id) {
                $imageKitService = new ImageKitService();
                $imageKitService->deleteImage($gender->main_imagekit_file_id);
            }

            $oldData = $gender->only(['name', 'slug', 'description']);
            $gender->update($validated);

            self::logActivity('updated', "Updated gender: {$gender->name}", $gender, $oldData, $validated);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Gender updated successfully!',
                    'gender' => [
                        'id' => $gender->id,
                        'name' => $gender->name,
                        'slug' => $gender->slug,
                        'description' => $gender->description,
                        'sort_order' => $gender->sort_order,
                        'is_active' => (bool) $gender->is_active,
                        'image_url' => $gender->getImageUrl(),
                        'imagekit_file_id' => $gender->imagekit_file_id,
                        'imagekit_url' => $gender->imagekit_url,
                        'imagekit_thumbnail_url' => $gender->imagekit_thumbnail_url,
                        'imagekit_file_path' => $gender->imagekit_file_path,
                        'main_image_url' => $gender->getMainImageUrl(),
                        'main_imagekit_file_id' => $gender->main_imagekit_file_id,
                        'main_imagekit_url' => $gender->main_imagekit_url,
                        'main_imagekit_thumbnail_url' => $gender->main_imagekit_thumbnail_url,
                        'main_imagekit_file_path' => $gender->main_imagekit_file_path,
                        'created_at' => $gender->created_at->format('M d, Y'),
                    ]
                ]);
            }

            return redirect()->route('admin.genders.index')->with('success', 'Gender updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Gender update failed', ['error' => $e->getMessage()]);

            // Check if it's a duplicate entry error
            $message = 'Failed to update gender. Please try again.';
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                if (strpos($e->getMessage(), 'genders_name_unique') !== false) {
                    $message = 'A gender with this name already exists. Please use a different name.';
                } elseif (strpos($e->getMessage(), 'genders_slug_unique') !== false) {
                    $message = 'A gender with this slug already exists. Please use a different slug.';
                }
            }

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message
                ], 422);
            }

            return back()->withInput()->withErrors(['error' => $message]);
        }
    }

    public function destroy(Gender $gender)
    {
        try {
            $name = $gender->name;
            
            // Delete thumb image from ImageKit if exists
            if ($gender->imagekit_file_id) {
                $imageKitService = new ImageKitService();
                $imageKitService->deleteImage($gender->imagekit_file_id);
            }
            
            // Delete main image from ImageKit if exists
            if ($gender->main_imagekit_file_id) {
                $imageKitService = new ImageKitService();
                $imageKitService->deleteImage($gender->main_imagekit_file_id);
            }
            
            $gender->delete();

            self::logActivity('deleted', "Deleted gender: {$name}");

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Gender deleted successfully!'
                ]);
            }

            return redirect()->route('admin.genders.index')
                ->with('success', 'Gender deleted successfully!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete gender. Please try again.'
                ], 500);
            }

            return redirect()->route('admin.genders.index')
                ->with('error', 'Failed to delete gender. Please try again.');
        }
    }

    public function toggle(Request $request, Gender $gender)
    {
        try {
            $field = $request->input('field');
            $value = $request->input('value');

            if (!in_array($field, ['is_active'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid field: ' . $field
                ], 400);
            }

            $boolValue = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            $gender->update([$field => $boolValue]);

            $message = 'Gender status updated successfully!';

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update gender'
            ], 500);
        }
    }

    public function bulkAction(Request $request)
    {
        try {
            $action = $request->input('action');
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No genders selected'
                ], 400);
            }

            $count = 0;

            switch ($action) {
                case 'activate':
                    $count = Gender::whereIn('id', $ids)->update(['is_active' => true]);
                    $message = "$count gender(s) activated successfully!";
                    break;

                case 'deactivate':
                    $count = Gender::whereIn('id', $ids)->update(['is_active' => false]);
                    $message = "$count gender(s) deactivated successfully!";
                    break;

                case 'delete':
                    $count = Gender::whereIn('id', $ids)->delete();
                    $message = "$count gender(s) deleted successfully!";
                    break;

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid action'
                    ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to perform bulk action'
            ], 500);
        }
    }

    public function uploadImage(Request $request, ImageKitService $imageKit)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            ]);

            $result = $imageKit->uploadCategoryImage($request->file('image'), 'genders');

            if ($result && $result['success']) {
                return response()->json([
                    'success' => true,
                    'url' => $result['url'],
                    'file_id' => $result['file_id'],
                    'fileId' => $result['file_id'],
                    'thumbnail_url' => $result['thumbnail_url'] ?? $result['url'],
                    'file_path' => $result['file_path'] ?? '',
                    'width' => $result['width'],
                    'height' => $result['height'],
                    'size' => $result['size'],
                    'original_size' => $result['original_size'],
                    'name' => $result['name'] ?? 'image',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image'
            ], 500);

        } catch (\Exception $e) {
            \Log::error('Gender image upload failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function export()
    {
        $genders = Gender::orderBy('sort_order')->get();

        $filename = 'genders_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($genders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Slug', 'Description', 'Sort Order', 'Status', 'Created At']);

            foreach ($genders as $gender) {
                fputcsv($file, [
                    $gender->id,
                    $gender->name,
                    $gender->slug,
                    $gender->description,
                    $gender->sort_order,
                    $gender->is_active ? 'Active' : 'Inactive',
                    $gender->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
