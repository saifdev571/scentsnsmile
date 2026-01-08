<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromotionalCard;
use App\Services\ImageKitService;
use Illuminate\Http\Request;

class PromotionalCardController extends Controller
{
    protected $imageKit;

    public function __construct(ImageKitService $imageKit)
    {
        $this->imageKit = $imageKit;
    }

    public function index()
    {
        $cards = PromotionalCard::orderBy('position')->get();
        return view('admin.promotional-cards.index', compact('cards'));
    }

    public function create()
    {
        return view('admin.promotional-cards.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:image,video',
            'image_file' => 'required_if:type,image|image|max:10240', // Max 10MB
            'video_file' => 'required_if:type,video|mimetypes:video/mp4,video/quicktime|max:51200', // Max 50MB
            'thumbnail_file' => 'required_if:type,video|image|max:5120',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'position' => 'required|integer|min:0',
            'text_color' => 'required|in:dark,light',
            'background_color' => 'nullable|string|max:7',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except(['image_file', 'video_file', 'thumbnail_file']);
        $data['is_active'] = $request->has('is_active');

        // Handle Media Upload
        if ($request->hasFile('image_file') && $validated['type'] === 'image') {
            $upload = $this->imageKit->uploadProductImage($request->file('image_file'), 'promos');
            if ($upload) {
                $data['media_url'] = $upload['url'];
            }
        } elseif ($request->hasFile('video_file') && $validated['type'] === 'video') {
            // Use raw upload for video (or product image upload if it skips optimization which we might want for video? No, ImageKitService uploadProductImage converts to base64 image data)
            // We need a method to upload raw files or specific video support.
            // Looking at ImageKitService, `uploadRawImage` uploads without compression. `uploadProductImage` does base64 encoding.
            // I'll use `uploadRawImage` for video.
            $upload = $this->imageKit->uploadRawImage($request->file('video_file'), 'promos-video');
            if ($upload) {
                $data['media_url'] = $upload['url'];
            }
        }

        // Handle Thumbnail for Video
        if ($request->hasFile('thumbnail_file')) {
            $upload = $this->imageKit->uploadProductImage($request->file('thumbnail_file'), 'promos-thumb');
            if ($upload) {
                $data['thumbnail_url'] = $upload['url'];
            }
        }

        PromotionalCard::create($data);

        return redirect()->route('admin.promotional-cards.index')->with('success', 'Promotional Card created successfully.');
    }

    public function edit(PromotionalCard $promotionalCard)
    {
        return view('admin.promotional-cards.edit', compact('promotionalCard'));
    }

    public function update(Request $request, PromotionalCard $promotionalCard)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:image,video',
            'image_file' => 'nullable|image|max:10240',
            'video_file' => 'nullable|mimetypes:video/mp4,video/quicktime|max:51200',
            'thumbnail_file' => 'nullable|image|max:5120',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'position' => 'required|integer|min:0',
            'text_color' => 'required|in:dark,light',
            'background_color' => 'nullable|string|max:7',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except(['image_file', 'video_file', 'thumbnail_file']);
        $data['is_active'] = $request->has('is_active');

        // Handle Media Update
        if ($request->hasFile('image_file') && $validated['type'] === 'image') {
            $upload = $this->imageKit->uploadProductImage($request->file('image_file'), 'promos');
            if ($upload) {
                $data['media_url'] = $upload['url'];
            }
        } elseif ($request->hasFile('video_file') && $validated['type'] === 'video') {
            $upload = $this->imageKit->uploadRawImage($request->file('video_file'), 'promos-video');
            if ($upload) {
                $data['media_url'] = $upload['url'];
            }
        }

        if ($request->hasFile('thumbnail_file')) {
            $upload = $this->imageKit->uploadProductImage($request->file('thumbnail_file'), 'promos-thumb');
            if ($upload) {
                $data['thumbnail_url'] = $upload['url'];
            }
        }

        $promotionalCard->update($data);

        return redirect()->route('admin.promotional-cards.index')->with('success', 'Promotional Card updated successfully.');
    }

    public function destroy(PromotionalCard $promotionalCard)
    {
        $promotionalCard->delete();
        return redirect()->route('admin.promotional-cards.index')->with('success', 'Promotional Card deleted successfully.');
    }
}
