<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HighlightNote;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HighlightNoteController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $statusFilter = $request->get('status_filter', 'all');
        $sortField = $request->get('sort_field', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');
        $perPage = $request->get('per_page', 25);

        $query = HighlightNote::query()->withCount('products');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        $query->orderBy($sortField, $sortDirection);
        $highlightNotes = $query->paginate($perPage);

        $totalHighlightNotes = HighlightNote::count();
        $activeHighlightNotes = HighlightNote::where('is_active', true)->count();
        $inactiveHighlightNotes = HighlightNote::where('is_active', false)->count();

        $usedHighlightNotes = HighlightNote::withCount('products')->having('products_count', '>', 0)->count();
        $totalUsageCount = \DB::table('product_highlight_note')->count();

        return view('admin.highlight-notes.index', [
            'highlightNotes' => $highlightNotes,
            'totalHighlightNotes' => $totalHighlightNotes,
            'activeHighlightNotes' => $activeHighlightNotes,
            'inactiveHighlightNotes' => $inactiveHighlightNotes,
            'usedHighlightNotes' => $usedHighlightNotes,
            'totalUsageCount' => $totalUsageCount,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'perPage' => $perPage,
        ]);
    }

    public function show(HighlightNote $highlightNote)
    {
        $highlightNote->loadCount('products');

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'highlightNote' => [
                    'id' => $highlightNote->id,
                    'name' => $highlightNote->name,
                    'is_active' => (bool) $highlightNote->is_active,
                    'usage_count' => $highlightNote->products_count ?? 0,
                ]
            ]);
        }

        return view('admin.highlight-notes.show', compact('highlightNote'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('highlight_notes', 'name')->whereNull('deleted_at')],
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
            $highlightNote = HighlightNote::create($validated);
            $highlightNote->loadCount('products');

            self::logActivity('created', "Created new highlight note: {$highlightNote->name}", $highlightNote);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Highlight Note created successfully!',
                    'highlightNote' => [
                        'id' => $highlightNote->id,
                        'name' => $highlightNote->name,
                        'is_active' => (bool) $highlightNote->is_active,
                        'usage_count' => $highlightNote->products_count ?? 0,
                        'image_url' => $highlightNote->getImageUrl(),
                        'imagekit_file_id' => $highlightNote->imagekit_file_id,
                        'imagekit_url' => $highlightNote->imagekit_url,
                        'imagekit_thumbnail_url' => $highlightNote->imagekit_thumbnail_url,
                        'imagekit_file_path' => $highlightNote->imagekit_file_path,
                        'created_at' => $highlightNote->created_at->format('M d, Y'),
                    ]
                ]);
            }

            return redirect()->route('admin.highlight-notes.index')->with('success', 'Highlight Note created successfully!');
        } catch (\Exception $e) {
            \Log::error('Highlight Note creation failed', ['error' => $e->getMessage()]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create highlight note.'
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Failed to create highlight note.']);
        }
    }

    public function update(Request $request, HighlightNote $highlightNote)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('highlight_notes', 'name')->ignore($highlightNote->id)->whereNull('deleted_at')],
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
            // Delete old image if new one is uploaded
            if ($request->filled('imagekit_file_id') && $highlightNote->imagekit_file_id && $request->input('imagekit_file_id') !== $highlightNote->imagekit_file_id) {
                $imageKitService = new \App\Services\ImageKitService();
                $imageKitService->deleteImage($highlightNote->imagekit_file_id);
            }

            $oldData = $highlightNote->only(['name', 'is_active']);
            $highlightNote->update($validated);
            $highlightNote->loadCount('products');

            self::logActivity('updated', "Updated highlight note: {$highlightNote->name}", $highlightNote, $oldData, $validated);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Highlight Note updated successfully!',
                    'highlightNote' => [
                        'id' => $highlightNote->id,
                        'name' => $highlightNote->name,
                        'is_active' => (bool) $highlightNote->is_active,
                        'usage_count' => $highlightNote->products_count ?? 0,
                        'image_url' => $highlightNote->getImageUrl(),
                        'imagekit_file_id' => $highlightNote->imagekit_file_id,
                        'imagekit_url' => $highlightNote->imagekit_url,
                        'imagekit_thumbnail_url' => $highlightNote->imagekit_thumbnail_url,
                        'imagekit_file_path' => $highlightNote->imagekit_file_path,
                        'created_at' => $highlightNote->created_at->format('M d, Y'),
                    ]
                ]);
            }

            return redirect()->route('admin.highlight-notes.index')->with('success', 'Highlight Note updated successfully!');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to update highlight note.'], 500);
            }
            return back()->withInput()->withErrors(['error' => 'Failed to update highlight note.']);
        }
    }

    public function destroy(HighlightNote $highlightNote)
    {
        try {
            $name = $highlightNote->name;
            $highlightNote->delete();

            self::logActivity('deleted', "Deleted highlight note: {$name}");
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Highlight Note deleted successfully!']);
            }
            return redirect()->route('admin.highlight-notes.index')->with('success', 'Highlight Note deleted successfully!');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to delete highlight note.'], 500);
            }
            return redirect()->route('admin.highlight-notes.index')->with('error', 'Failed to delete highlight note.');
        }
    }

    public function toggle(Request $request, HighlightNote $highlightNote)
    {
        try {
            $field = $request->input('field');
            $value = $request->input('value');

            if (!in_array($field, ['is_active'])) {
                return response()->json(['success' => false, 'message' => 'Invalid field: ' . $field], 400);
            }

            $boolValue = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            $highlightNote->update([$field => $boolValue]);

            return response()->json(['success' => true, 'message' => 'Highlight Note status updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update highlight note'], 500);
        }
    }

    public function bulkAction(Request $request)
    {
        try {
            $action = $request->input('action');
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json(['success' => false, 'message' => 'No highlight notes selected'], 400);
            }

            $count = 0;
            switch ($action) {
                case 'activate':
                    $count = HighlightNote::whereIn('id', $ids)->update(['is_active' => true]);
                    $message = "$count highlight note(s) activated!";
                    break;
                case 'deactivate':
                    $count = HighlightNote::whereIn('id', $ids)->update(['is_active' => false]);
                    $message = "$count highlight note(s) deactivated!";
                    break;
                case 'delete':
                    $count = HighlightNote::whereIn('id', $ids)->delete();
                    $message = "$count highlight note(s) deleted!";
                    break;
                default:
                    return response()->json(['success' => false, 'message' => 'Invalid action'], 400);
            }

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to perform bulk action'], 500);
        }
    }

    public function uploadImage(Request $request, \App\Services\ImageKitService $imageKit)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
            ]);

            // Use uploadRawImage - NO compression, NO resize
            $result = $imageKit->uploadRawImage($request->file('image'), 'highlight-notes');

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
            \Log::error('Highlight Note image upload failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function export()
    {
        $highlightNotes = HighlightNote::withCount('products')->orderBy('products_count', 'desc')->get();
        $filename = 'highlight_notes_' . date('Y-m-d_His') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=\"$filename\""];

        $callback = function() use ($highlightNotes) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Usage Count', 'Status', 'Created At']);
            foreach ($highlightNotes as $highlightNote) {
                fputcsv($file, [
                    $highlightNote->id, $highlightNote->name, $highlightNote->products_count ?? 0, 
                    $highlightNote->is_active ? 'Active' : 'Inactive',
                    $highlightNote->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
