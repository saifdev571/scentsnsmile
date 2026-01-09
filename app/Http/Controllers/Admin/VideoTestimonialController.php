<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoTestimonial;
use App\Services\ImageKitService;
use Illuminate\Http\Request;

class VideoTestimonialController extends Controller
{
    protected $imageKit;

    public function __construct(ImageKitService $imageKit)
    {
        $this->imageKit = $imageKit;
    }

    public function index()
    {
        $items = VideoTestimonial::orderBy('sort_order', 'asc')->get();
        return view('admin.video-testimonials.index', compact('items'));
    }

    public function create()
    {
        return view('admin.video-testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'video_file' => 'required|mimetypes:video/mp4,video/quicktime,video/x-m4v,video/webm|max:51200', // Max 50MB
            'thumbnail_file' => 'nullable|image|max:5120',
            'quote' => 'required|string',
            'author_name' => 'required|string|max:255',
            'product_text' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except(['video_file', 'thumbnail_file']);
        $data['is_active'] = $request->has('is_active');

        // Handle Video Upload
        if ($request->hasFile('video_file')) {
            $upload = $this->imageKit->uploadRawImage($request->file('video_file'), 'testimonials-video');
            if ($upload) {
                $data['video_url'] = $upload['url'];
            }
        }

        // Handle Thumbnail Upload
        if ($request->hasFile('thumbnail_file')) {
            $upload = $this->imageKit->uploadProductImage($request->file('thumbnail_file'), 'testimonials-thumb');
            if ($upload) {
                $data['thumbnail_url'] = $upload['url'];
            }
        }

        VideoTestimonial::create($data);

        return redirect()->route('admin.video-testimonials.index')->with('success', 'Video Testimonial created successfully.');
    }

    public function edit(VideoTestimonial $videoTestimonial)
    {
        return view('admin.video-testimonials.edit', compact('videoTestimonial'));
    }

    public function update(Request $request, VideoTestimonial $videoTestimonial)
    {
        $validated = $request->validate([
            'video_file' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-m4v,video/webm|max:51200', // Max 50MB
            'thumbnail_file' => 'nullable|image|max:5120',
            'quote' => 'required|string',
            'author_name' => 'required|string|max:255',
            'product_text' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except(['video_file', 'thumbnail_file']);
        $data['is_active'] = $request->has('is_active');

        // Handle Video Update
        if ($request->hasFile('video_file')) {
            $upload = $this->imageKit->uploadRawImage($request->file('video_file'), 'testimonials-video');
            if ($upload) {
                $data['video_url'] = $upload['url'];
            }
        }

        // Handle Thumbnail Update
        if ($request->hasFile('thumbnail_file')) {
            $upload = $this->imageKit->uploadProductImage($request->file('thumbnail_file'), 'testimonials-thumb');
            if ($upload) {
                $data['thumbnail_url'] = $upload['url'];
            }
        }

        $videoTestimonial->update($data);

        return redirect()->route('admin.video-testimonials.index')->with('success', 'Video Testimonial updated successfully.');
    }

    public function destroy(VideoTestimonial $videoTestimonial)
    {
        $videoTestimonial->delete();
        return redirect()->route('admin.video-testimonials.index')->with('success', 'Video Testimonial deleted successfully.');
    }
}
