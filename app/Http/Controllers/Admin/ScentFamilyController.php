<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScentFamily;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ScentFamilyController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $statusFilter = $request->get('status_filter', 'all');
        $sortField = $request->get('sort_field', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');
        $perPage = $request->get('per_page', 25);

        $query = ScentFamily::query()->withCount('products');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        $query->orderBy($sortField, $sortDirection);
        $scentFamilies = $query->paginate($perPage);

        $totalScentFamilies = ScentFamily::count();
        $activeScentFamilies = ScentFamily::where('is_active', true)->count();
        $inactiveScentFamilies = ScentFamily::where('is_active', false)->count();
        $usedScentFamilies = ScentFamily::withCount('products')->having('products_count', '>', 0)->count();

        return view('admin.scent-families.index', [
            'scentFamilies' => $scentFamilies,
            'totalScentFamilies' => $totalScentFamilies,
            'activeScentFamilies' => $activeScentFamilies,
            'inactiveScentFamilies' => $inactiveScentFamilies,
            'usedScentFamilies' => $usedScentFamilies,
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
            'name' => ['required', 'string', 'max:255', Rule::unique('scent_families', 'name')->whereNull('deleted_at')],
            'description' => 'nullable|string|max:1000',
            'imagekit_file_id' => 'nullable|string',
            'imagekit_url' => 'nullable|string',
            'imagekit_thumbnail_url' => 'nullable|string',
            'imagekit_file_path' => 'nullable|string',
            'image_size' => 'nullable|integer',
            'original_image_size' => 'nullable|integer',
            'image_width' => 'nullable|integer',
            'image_height' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        try {
            $scentFamily = ScentFamily::create($validated);
            $scentFamily->loadCount('products');

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Scent Family created successfully!',
                    'scentFamily' => [
                        'id' => $scentFamily->id,
                        'name' => $scentFamily->name,
                        'description' => $scentFamily->description,
                        'is_active' => (bool) $scentFamily->is_active,
                        'usage_count' => $scentFamily->products_count ?? 0,
                        'image_url' => $scentFamily->getImageUrl(),
                        'created_at' => $scentFamily->created_at->format('M d, Y'),
                    ]
                ]);
            }

            return redirect()->route('admin.scent-families.index')->with('success', 'Scent Family created successfully!');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to create scent family.'], 500);
            }
            return back()->withInput()->withErrors(['error' => 'Failed to create scent family.']);
        }
    }

    public function update(Request $request, ScentFamily $scentFamily)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('scent_families', 'name')->ignore($scentFamily->id)->whereNull('deleted_at')],
            'description' => 'nullable|string|max:1000',
            'imagekit_file_id' => 'nullable|string',
            'imagekit_url' => 'nullable|string',
            'imagekit_thumbnail_url' => 'nullable|string',
            'imagekit_file_path' => 'nullable|string',
            'image_size' => 'nullable|integer',
            'original_image_size' => 'nullable|integer',
            'image_width' => 'nullable|integer',
            'image_height' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        try {
            $scentFamily->update($validated);
            $scentFamily->loadCount('products');

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Scent Family updated successfully!',
                    'scentFamily' => [
                        'id' => $scentFamily->id,
                        'name' => $scentFamily->name,
                        'description' => $scentFamily->description,
                        'is_active' => (bool) $scentFamily->is_active,
                        'usage_count' => $scentFamily->products_count ?? 0,
                        'image_url' => $scentFamily->getImageUrl(),
                        'created_at' => $scentFamily->created_at->format('M d, Y'),
                    ]
                ]);
            }

            return redirect()->route('admin.scent-families.index')->with('success', 'Scent Family updated successfully!');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to update scent family.'], 500);
            }
            return back()->withInput()->withErrors(['error' => 'Failed to update scent family.']);
        }
    }

    public function destroy(ScentFamily $scentFamily)
    {
        try {
            $scentFamily->delete();
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Scent Family deleted successfully!']);
            }
            return redirect()->route('admin.scent-families.index')->with('success', 'Scent Family deleted successfully!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to delete scent family.'], 500);
            }
            return redirect()->route('admin.scent-families.index')->with('error', 'Failed to delete scent family.');
        }
    }

    public function toggle(Request $request, ScentFamily $scentFamily)
    {
        try {
            $field = $request->input('field');
            $value = $request->input('value');

            if (!in_array($field, ['is_active'])) {
                return response()->json(['success' => false, 'message' => 'Invalid field'], 400);
            }

            $scentFamily->update([$field => filter_var($value, FILTER_VALIDATE_BOOLEAN)]);
            return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update'], 500);
        }
    }

    public function bulkAction(Request $request)
    {
        try {
            $action = $request->input('action');
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json(['success' => false, 'message' => 'No items selected'], 400);
            }

            switch ($action) {
                case 'activate':
                    $count = ScentFamily::whereIn('id', $ids)->update(['is_active' => true]);
                    $message = "$count scent family(ies) activated!";
                    break;
                case 'deactivate':
                    $count = ScentFamily::whereIn('id', $ids)->update(['is_active' => false]);
                    $message = "$count scent family(ies) deactivated!";
                    break;
                case 'delete':
                    $count = ScentFamily::whereIn('id', $ids)->delete();
                    $message = "$count scent family(ies) deleted!";
                    break;
                default:
                    return response()->json(['success' => false, 'message' => 'Invalid action'], 400);
            }

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to perform action'], 500);
        }
    }

    public function uploadImage(Request $request, \App\Services\ImageKitService $imageKit)
    {
        try {
            $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240']);

            $result = $imageKit->uploadRawImage($request->file('image'), 'scent-families');

            if ($result && $result['success']) {
                return response()->json([
                    'success' => true,
                    'url' => $result['url'],
                    'file_id' => $result['file_id'],
                    'thumbnail_url' => $result['thumbnail_url'] ?? $result['url'],
                    'file_path' => $result['file_path'] ?? '',
                    'width' => $result['width'],
                    'height' => $result['height'],
                    'size' => $result['size'],
                    'original_size' => $result['original_size'],
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Failed to upload image'], 500);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function export()
    {
        $scentFamilies = ScentFamily::withCount('products')->orderBy('name')->get();
        $filename = 'scent_families_' . date('Y-m-d_His') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"$filename\""];

        $callback = function() use ($scentFamilies) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Description', 'Usage Count', 'Status', 'Created At']);
            foreach ($scentFamilies as $sf) {
                fputcsv($file, [$sf->id, $sf->name, $sf->description, $sf->products_count ?? 0, $sf->is_active ? 'Active' : 'Inactive', $sf->created_at->format('Y-m-d H:i:s')]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
