<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $query = Promotion::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('badge_text', 'like', "%{$search}%")
                    ->orWhere('cart_label', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $promotions = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'discount_type' => 'required|in:percentage,fixed',
                'discount_value' => 'required|numeric|min:0',
                'min_items' => 'required|integer|min:1',
                'min_amount' => 'nullable|numeric|min:0',
                'free_shipping_min_items' => 'nullable|integer|min:1',
                'badge_text' => 'nullable|string|max:50',
                'badge_color' => 'nullable|string|max:20',
                'banner_title' => 'nullable|string|max:100',
                'banner_subtitle' => 'nullable|string|max:200',
                'cart_label' => 'nullable|string|max:100',
                'starts_at' => 'nullable|date',
                'ends_at' => 'nullable|date|after_or_equal:starts_at',
                'sort_order' => 'nullable|integer',
            ]);

            // Generate unique slug
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $counter = 1;
            while (Promotion::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
            
            // Handle boolean fields from JSON
            $validated['is_active'] = filter_var($request->input('is_active', false), FILTER_VALIDATE_BOOLEAN);
            $validated['free_shipping'] = filter_var($request->input('free_shipping', false), FILTER_VALIDATE_BOOLEAN);
            $validated['show_in_header'] = filter_var($request->input('show_in_header', false), FILTER_VALIDATE_BOOLEAN);
            $validated['show_in_cart'] = filter_var($request->input('show_in_cart', false), FILTER_VALIDATE_BOOLEAN);

            Promotion::create($validated);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Promotion created successfully']);
            }

            return redirect()->route('admin.promotions.index')->with('success', 'Promotion created successfully');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'discount_type' => 'required|in:percentage,fixed',
                'discount_value' => 'required|numeric|min:0',
                'min_items' => 'required|integer|min:1',
                'min_amount' => 'nullable|numeric|min:0',
                'free_shipping_min_items' => 'nullable|integer|min:1',
                'badge_text' => 'nullable|string|max:50',
                'badge_color' => 'nullable|string|max:20',
                'banner_title' => 'nullable|string|max:100',
                'banner_subtitle' => 'nullable|string|max:200',
                'cart_label' => 'nullable|string|max:100',
                'starts_at' => 'nullable|date',
                'ends_at' => 'nullable|date|after_or_equal:starts_at',
                'sort_order' => 'nullable|integer',
            ]);

            // Handle boolean fields from JSON
            $validated['is_active'] = filter_var($request->input('is_active', false), FILTER_VALIDATE_BOOLEAN);
            $validated['free_shipping'] = filter_var($request->input('free_shipping', false), FILTER_VALIDATE_BOOLEAN);
            $validated['show_in_header'] = filter_var($request->input('show_in_header', false), FILTER_VALIDATE_BOOLEAN);
            $validated['show_in_cart'] = filter_var($request->input('show_in_cart', false), FILTER_VALIDATE_BOOLEAN);

            $promotion->update($validated);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Promotion updated successfully']);
            }

            return redirect()->route('admin.promotions.index')->with('success', 'Promotion updated successfully');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Promotion deleted successfully']);
        }

        return redirect()->route('admin.promotions.index')->with('success', 'Promotion deleted successfully');
    }

    public function toggle(Promotion $promotion)
    {
        $promotion->update(['is_active' => !$promotion->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $promotion->is_active,
            'message' => $promotion->is_active ? 'Promotion activated' : 'Promotion deactivated'
        ]);
    }
}
