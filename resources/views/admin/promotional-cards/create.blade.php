@extends('admin.layouts.app')

@section('title', 'Add Promotional Card')

@section('content')
    <div class="min-h-screen bg-gray-50 p-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Add Promotional Card</h1>
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

        <div class="max-w-7xl mx-auto">
            <form action="{{ route('admin.promotional-cards.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Left Column: Main Content -->
                    <div class="lg:col-span-2 space-y-8">

                        <!-- Media Section -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Card Media
                                </h2>
                            </div>
                            <div class="p-6">
                                <div id="imageUploadSection" class="{{ old('type') == 'video' ? 'hidden' : '' }}">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Image</label>
                                    <div class="flex items-center justify-center w-full">
                                        <label
                                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to
                                                        upload</span> or drag and drop</p>
                                                <p class="text-xs text-gray-500">Vertical Aspect Ratio (3:4) Recommended</p>
                                            </div>
                                            <input type="file" name="image_file" accept="image/*" class="hidden" />
                                        </label>
                                    </div>
                                </div>

                                <div id="videoUploadSection" class="{{ old('type') == 'video' ? '' : 'hidden' }}">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Video</label>
                                    <input type="file" name="video_file" accept="video/mp4,video/quicktime"
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none mb-4 p-2">

                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Video
                                        Thumbnail/Poster</label>
                                    <input type="file" name="thumbnail_file" accept="image/*"
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-2">
                                </div>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Card Content
                                </h2>
                            </div>
                            <div class="p-6 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                                        <input type="text" name="title" value="{{ old('title') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Subtitle</label>
                                        <input type="text" name="subtitle" value="{{ old('subtitle') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                    <textarea name="description" rows="3"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">{{ old('description') }}</textarea>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Button Text</label>
                                        <input type="text" name="button_text" value="{{ old('button_text') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Button Link</label>
                                        <input type="text" name="button_link" value="{{ old('button_link') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Configuration -->
                        <div id="modalConfigSection" class="{{ old('action_type') == 'modal' ? '' : 'hidden' }}">
                            <div class="bg-purple-50 rounded-2xl shadow-sm border border-purple-100 overflow-hidden">
                                <div class="p-6 border-b border-purple-100 bg-purple-100/50">
                                    <h2 class="text-lg font-bold text-purple-900 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                        </svg>
                                        Modal Pop-up Configuration
                                    </h2>
                                </div>
                                <div class="p-6 space-y-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-purple-900 mb-2">Modal Image</label>
                                        <input type="file" name="modal_image_file" accept="image/*"
                                            class="block w-full text-sm text-purple-900 border border-purple-200 rounded-lg cursor-pointer bg-white focus:outline-none p-2">
                                    </div>
                                    <div class="grid grid-cols-1 gap-6">
                                        <div>
                                            <label class="block text-sm font-semibold text-purple-900 mb-2">Modal
                                                Title</label>
                                            <input type="text" name="modal_title" value="{{ old('modal_title') }}"
                                                class="w-full px-4 py-2.5 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-purple-900 mb-2">Modal
                                                Description (HTML Supported)</label>
                                            <textarea name="modal_description" rows="5"
                                                class="w-full px-4 py-2.5 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500">{{ old('modal_description') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-semibold text-purple-900 mb-2">Modal Button
                                                Text</label>
                                            <input type="text" name="modal_button_text"
                                                value="{{ old('modal_button_text') }}"
                                                class="w-full px-4 py-2.5 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-purple-900 mb-2">Modal Button
                                                Link</label>
                                            <input type="text" name="modal_button_link"
                                                value="{{ old('modal_button_link') }}"
                                                class="w-full px-4 py-2.5 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Settings -->
                    <div class="space-y-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-6">
                            <h3 class="font-bold text-gray-900 border-b pb-2">Card Settings</h3>

                            <!-- Internal Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Internal Name *</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                    placeholder="e.g. Summer Sale">
                            </div>

                            <!-- Position -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Grid Position *</label>
                                <input type="number" name="position" value="{{ old('position', 0) }}" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                <p class="text-xs text-gray-500 mt-1">0-based index. 0 = 1st card.</p>
                            </div>

                            <!-- Status -->
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <span class="text-sm font-semibold text-gray-700">Active Status</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600">
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-6">
                            <h3 class="font-bold text-gray-900 border-b pb-2">Configuration</h3>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Media Type</label>
                                <select name="type" id="mediaType"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 bg-white">
                                    <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image Card</option>
                                    <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video Card</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Action Type</label>
                                <select name="action_type" id="actionType"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 bg-white">
                                    <option value="link" {{ old('action_type') == 'link' ? 'selected' : '' }}>Link to URL
                                    </option>
                                    <option value="modal" {{ old('action_type') == 'modal' ? 'selected' : '' }}>Open Modal
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Text Color Scheme</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="text_color" value="dark" class="peer sr-only" {{ old('text_color') == 'dark' ? 'checked' : '' }}>
                                        <div
                                            class="text-center p-2 rounded-lg border border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:bg-gray-50">
                                            <div class="w-full h-4 bg-gray-900 rounded mb-1"></div>
                                            <span class="text-xs">Dark Text</span>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="text_color" value="light" class="peer sr-only" {{ old('text_color') == 'light' ? 'checked' : '' }}>
                                        <div
                                            class="text-center p-2 rounded-lg border border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:bg-gray-50">
                                            <div class="w-full h-4 bg-gray-200 rounded mb-1"></div>
                                            <span class="text-xs">Light Text</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Sticky Submit -->
                        <div class="sticky top-6">
                            <button type="submit"
                                class="w-full py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-xl hover:from-purple-700 hover:to-indigo-700 shadow-lg transform hover:scale-[1.02] transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Create Card
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Media Type Toggle
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

        // Action Type Toggle
        document.getElementById('actionType').addEventListener('change', function () {
            const type = this.value;
            const modalSection = document.getElementById('modalConfigSection');
            if (type === 'modal') {
                modalSection.classList.remove('hidden');
            } else {
                modalSection.classList.add('hidden');
            }
        });
    </script>
@endsection