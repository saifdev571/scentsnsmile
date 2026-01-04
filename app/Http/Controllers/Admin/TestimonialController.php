<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $statusFilter = $request->get('status_filter', 'all');
        $sortField = $request->get('sort_field', 'sort_order');
        $sortDirection = $request->get('sort_direction', 'asc');
        $perPage = $request->get('per_page', 25);

        $query = Testimonial::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', '%' . $search . '%')
                  ->orWhere('review_text', 'like', '%' . $search . '%');
            });
        }

        if ($statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        $query->orderBy($sortField, $sortDirection);
        $testimonials = $query->paginate($perPage);

        $totalTestimonials = Testimonial::count();
        $activeTestimonials = Testimonial::where('is_active', true)->count();
        $inactiveTestimonials = Testimonial::where('is_active', false)->count();

        return view('admin.testimonials.index', [
            'testimonials' => $testimonials,
            'totalTestimonials' => $totalTestimonials,
            'activeTestimonials' => $activeTestimonials,
            'inactiveTestimonials' => $inactiveTestimonials,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'perPage' => $perPage,
        ]);
    }

    public function show(Testimonial $testimonial)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'testimonial' => $testimonial
            ]);
        }

        return view('admin.testimonials.show', compact('testimonial'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'review_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        try {
            $testimonial = Testimonial::create($validated);

            $this->logActivity('created', "Created testimonial: {$testimonial->customer_name}", $testimonial);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Testimonial created successfully',
                    'testimonial' => $testimonial
                ]);
            }

            return redirect()->route('admin.testimonials.index')
                ->with('success', 'Testimonial created successfully');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create testimonial. Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Failed to create testimonial: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'review_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $testimonial->sort_order;

        try {
            $testimonial->update($validated);

            $this->logActivity('updated', "Updated testimonial: {$testimonial->customer_name}", $testimonial);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Testimonial updated successfully',
                    'testimonial' => $testimonial
                ]);
            }

            return redirect()->route('admin.testimonials.index')
                ->with('success', 'Testimonial updated successfully');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update testimonial. Error: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Failed to update testimonial: ' . $e->getMessage());
        }
    }

    public function destroy(Testimonial $testimonial)
    {
        try {
            $name = $testimonial->customer_name ?? 'Anonymous';
            $testimonial->delete();

            $this->logActivity('deleted', "Deleted testimonial: {$name}", $testimonial);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Testimonial deleted successfully'
                ]);
            }

            return redirect()->route('admin.testimonials.index')
                ->with('success', 'Testimonial deleted successfully');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete testimonial'
                ], 500);
            }

            return back()->with('error', 'Failed to delete testimonial');
        }
    }

    public function toggle(Testimonial $testimonial)
    {
        try {
            $testimonial->is_active = !$testimonial->is_active;
            $testimonial->save();

            $status = $testimonial->is_active ? 'activated' : 'deactivated';
            $this->logActivity('toggled', "Testimonial {$status}", $testimonial);

            return response()->json([
                'success' => true,
                'is_active' => $testimonial->is_active,
                'message' => "Testimonial {$status} successfully"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle testimonial status'
            ], 500);
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:testimonials,id'
        ]);

        try {
            $count = 0;
            $action = $request->action;

            foreach ($request->ids as $id) {
                $testimonial = Testimonial::find($id);
                if (!$testimonial) continue;

                switch ($action) {
                    case 'activate':
                        $testimonial->update(['is_active' => true]);
                        break;
                    case 'deactivate':
                        $testimonial->update(['is_active' => false]);
                        break;
                    case 'delete':
                        $testimonial->delete();
                        break;
                }
                $count++;
            }

            $this->logActivity('bulk_action', "Bulk {$action} performed on {$count} testimonials");

            return response()->json([
                'success' => true,
                'message' => "{$count} testimonials {$action}d successfully"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bulk action failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function export(Request $request)
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();

        $filename = 'testimonials_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($testimonials) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Customer Name', 'Review', 'Rating', 'Status', 'Sort Order', 'Created At']);

            foreach ($testimonials as $testimonial) {
                fputcsv($file, [
                    $testimonial->id,
                    $testimonial->customer_name ?? 'Anonymous',
                    $testimonial->review_text,
                    $testimonial->rating,
                    $testimonial->is_active ? 'Active' : 'Inactive',
                    $testimonial->sort_order,
                    $testimonial->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
