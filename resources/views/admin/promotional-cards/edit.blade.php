@extends('admin.layouts.app')

@section('title', 'Edit Promotional Card')

@section('content')
    <div class="min-h-screen bg-gray-50 p-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Promotional Card</h1>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-xl">
                <ul class="list-disc list-inside text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden max-w-4xl mx-auto">
            <form action="{{ route('admin.promotional-cards.update', $promotionalCard) }}" method="POST"
                enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <!-- Internal Name -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Internal Name *</label>
                    <input type="text" name="name" value="{{ old('name', $promotionalCard->name) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Media Type *</label>
                        <select name="type" id="mediaType"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                            <option value="image" {{ old('type', $promotionalCard->type) == 'image' ? 'selected' : '' }}>Image
                            </option>
                            <option value="video" {{ old('type', $promotionalCard->type) == 'video' ? 'selected' : '' }}>Video
                            </option>
                        </select>
                    </div>

                    <!-- Position -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Grid Position (0-based Index) *</label>
                        <input type="number" name="position" value="{{ old('position', $promotionalCard->position) }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        <p class="text-xs text-gray-500 mt-1">0 = 1st Item, 4 = 5th Item</p>
                    </div>
                </div>

                <!-- Media Uploads -->
                <div class="p-6 bg-gray-50 rounded-xl border border-gray-200">
                    @if($promotionalCard->media_url)
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Current Media</label>
                            @if($promotionalCard->type == 'image')
                                <img src="{{ $promotionalCard->media_url }}" class="h-32 rounded-lg border border-gray-300">
                            @else
                                <div class="bg-black rounded-lg h-32 w-56 flex items-center justify-center text-white">Video Active
                                </div>
                            @endif
                        </div>
                    @endif

                    <div id="imageUploadSection"
                        class="{{ old('type', $promotionalCard->type) == 'video' ? 'hidden' : '' }}">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Upload New Image</label>
                        <input type="file" name="image_file" accept="image/*" class="w-full">
                    </div>

                    <div id="videoUploadSection"
                        class="{{ old('type', $promotionalCard->type) == 'video' ? '' : 'hidden' }}">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Upload New Video</label>
                        <input type="file" name="video_file" accept="video/mp4,video/quicktime" class="w-full mb-4">

                        <label class="block text-sm font-bold text-gray-700 mb-2">New Video Thumbnail/Poster</label>
                        <input type="file" name="thumbnail_file" accept="image/*" class="w-full">
                    </div>
                </div>

                <!-- Content -->
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Card Content</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" value="{{ old('title', $promotionalCard->title) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Subtitle</label>
                            <input type="text" name="subtitle" value="{{ old('subtitle', $promotionalCard->subtitle) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">{{ old('description', $promotionalCard->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Button Text</label>
                            <input type="text" name="button_text"
                                value="{{ old('button_text', $promotionalCard->button_text) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Button Link</label>
                            <input type="text" name="button_link"
                                value="{{ old('button_link', $promotionalCard->button_link) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>
                </div>

                <!-- Styling -->
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Styling</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Text Color</label>
                            <select name="text_color"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                <option value="dark" {{ old('text_color', $promotionalCard->text_color) == 'dark' ? 'selected' : '' }}>Dark (Black)</option>
                                <option value="light" {{ old('text_color', $promotionalCard->text_color) == 'light' ? 'selected' : '' }}>Light (White)</option>
                            </select>
                        </div>

                        <div class="flex items-center pt-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $promotionalCard->is_active) ? 'checked' : '' }}
                                    class="form-checkbox h-5 w-5 text-purple-600">
                                <span class="ml-2 text-gray-700 font-bold">Active</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6">
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-bold rounded-xl hover:from-purple-600 hover:to-pink-700 shadow-lg transform hover:scale-105 transition-all">
                        Update Card
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('mediaType').addEventListener('change', function () {
            const type = this.value;
            if (type === 'image') {
                document.getElementById('imageUploadSection').classList.remove('hidden');
                document.getElementById('videoUploadSection').classList.add('hidden');
            } else {
                document.getElementById('imageUploadSection').classList.add('hidden');
                document.getElementById('videoUploadSection').classList.remove('hidden');
            }
        });
    </script>
@endsection