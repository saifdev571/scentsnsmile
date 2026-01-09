@extends('admin.layouts.app')

@section('title', 'Add Video Testimonial')

@section('content')
    <div class="min-h-screen bg-gray-50 p-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Add Video Testimonial</h1>
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

        <div class="max-w-4xl mx-auto">
            <form action="{{ route('admin.video-testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-8 space-y-8">

                        <!-- Upload Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Video Upload -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Video File *</label>
                                <label
                                    class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors relative"
                                    id="video-preview-container">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center"
                                        id="video-placeholder">
                                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload
                                                video</span></p>
                                        <p class="text-xs text-gray-500">MP4, MOV, WebM (Max 50MB)</p>
                                    </div>
                                    <input type="file" name="video_file" accept="video/*" class="hidden" required
                                        onchange="previewVideo(this)" />
                                    <video id="video-preview"
                                        class="hidden w-full h-full object-cover rounded-xl absolute inset-0"></video>
                                </label>
                            </div>

                            <!-- Thumbnail Upload -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Thumbnail (Optional)</label>
                                <label
                                    class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors relative"
                                    id="thumb-preview-container">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center"
                                        id="thumb-placeholder">
                                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Cover Image</span>
                                        </p>
                                        <p class="text-xs text-gray-500">Vertical Aspect recommended</p>
                                    </div>
                                    <input type="file" name="thumbnail_file" accept="image/*" class="hidden"
                                        onchange="previewThumbnail(this)" />
                                    <img id="thumb-preview"
                                        class="hidden w-full h-full object-cover rounded-xl absolute inset-0">
                                </label>
                            </div>
                        </div>

                        <!-- Content Info -->
                        <div class="space-y-6">
                            <!-- Quote -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Testimonial Quote *</label>
                                <textarea name="quote" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 transition-all"
                                    placeholder="This scent makes me feel so confident!"
                                    required>{{ old('quote') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Author Name -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Author Name *</label>
                                    <input type="text" name="author_name" value="{{ old('author_name') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 transition-all font-medium uppercase"
                                        placeholder="ALICE T." required>
                                </div>

                                <!-- Product Text -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Product Used Info</label>
                                    <input type="text" name="product_text" value="{{ old('product_text') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 transition-all font-medium uppercase text-orange-500 placeholder-orange-300"
                                        placeholder="USED MOON + LINEN SPRAY">
                                    <p class="text-xs text-gray-500 mt-1">Displayed in orange uppercase text.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Sort Order -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Sort Order</label>
                                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 transition-all">
                                </div>

                                <!-- Active Toggle -->
                                <div
                                    class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-200 mt-auto h-[50px]">
                                    <label class="relative inline-flex items-center cursor-pointer mr-3">
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600">
                                        </div>
                                    </label>
                                    <div>
                                        <span class="block text-sm font-bold text-gray-900">Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="px-8 py-5 bg-gray-50 border-t border-gray-200 flex justify-end">
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-xl hover:from-purple-700 hover:to-indigo-700 shadow-lg transform hover:scale-105 transition-all">
                            Save Video Testimonial
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewVideo(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const video = document.getElementById('video-preview');
                    const placeholder = document.getElementById('video-placeholder');
                    video.src = e.target.result;
                    video.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewThumbnail(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.getElementById('thumb-preview');
                    const placeholder = document.getElementById('thumb-placeholder');
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection