<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialGalleryItem;
use App\Services\ImageKitService;
use Illuminate\Http\Request;

class SocialGalleryController extends Controller
{
    protected $imageKit;

    public function __construct(ImageKitService $imageKit)
    {
        $this->imageKit = $imageKit;
    }

    public function index()
    {
        $items = SocialGalleryItem::orderBy('sort_order', 'asc')->get();
        return view('admin.social-gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.social-gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image_file' => 'required|image|max:10240', // Max 10MB
            'username' => 'nullable|string|max:255',
            'external_link' => 'nullable|url|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except(['image_file']);
        $data['is_active'] = $request->has('is_active');

        // Handle Image Upload
        if ($request->hasFile('image_file')) {
            $upload = $this->imageKit->uploadProductImage($request->file('image_file'), 'social-gallery');
            if ($upload) {
                $data['image_url'] = $upload['url'];
            }
        }

        SocialGalleryItem::create($data);

        return redirect()->route('admin.social-gallery.index')->with('success', 'Social Gallery Item created successfully.');
    }

    public function edit(SocialGalleryItem $socialGalleryItem)
    {
        return view('admin.social-gallery.edit', compact('socialGalleryItem'));
    }

    public function update(Request $request, SocialGalleryItem $socialGalleryItem)
    {
        $validated = $request->validate([
            'image_file' => 'nullable|image|max:10240', // Max 10MB
            'username' => 'nullable|string|max:255',
            'external_link' => 'nullable|url|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except(['image_file']);
        $data['is_active'] = $request->has('is_active');

        // Handle Image Update
        if ($request->hasFile('image_file')) {
            $upload = $this->imageKit->uploadProductImage($request->file('image_file'), 'social-gallery');
            if ($upload) {
                $data['image_url'] = $upload['url'];
            }
        }

        $socialGalleryItem->update($data);

        return redirect()->route('admin.social-gallery.index')->with('success', 'Social Gallery Item updated successfully.');
    }

    public function destroy(SocialGalleryItem $socialGalleryItem)
    {
        $socialGalleryItem->delete();
        return redirect()->route('admin.social-gallery.index')->with('success', 'Social Gallery Item deleted successfully.');
    }
}
