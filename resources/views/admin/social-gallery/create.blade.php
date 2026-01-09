@extends('admin.layouts.app')

@section('title', 'Add Social Gallery Item')

@section('content')
    <div class="min-h-screen bg-gray-50 p-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Add Social Gallery Item</h1>
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
            <form action="{{ route('admin.social-gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-8 space-y-8">

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Social Image *</label>
                            <label
                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 mb-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span>
                                        or drag and drop</p>
                                    <p class="text-xs text-gray-500">Square or Portrait Recommended (e.g. 500x500)</p>
                                </div>
                                <input type="file" name="image_file" accept="image/*" class="hidden" required />
                            </label>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Username -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Username Handle</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 font-bold">@</span>
                                    <input type="text" name="username" value="{{ old('username') }}"
                                        class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 transition-all font-medium"
                                        placeholder="username">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Displayed in the pill label.</p>
                            </div>

                            <!-- Sort Order -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Sort Order</label>
                                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 transition-all">
                            </div>
                        </div>

                        <!-- External Link -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Post Link (Optional)</label>
                            <input type="url" name="external_link" value="{{ old('external_link') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 transition-all"
                                placeholder="https://instagram.com/p/...">
                        </div>

                        <!-- Active Toggle -->
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <label class="relative inline-flex items-center cursor-pointer mr-3">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600">
                                </div>
                            </label>
                            <div>
                                <span class="block text-sm font-bold text-gray-900">Active Status</span>
                                <span class="text-xs text-gray-500">Show this post in the gallery</span>
                            </div>
                        </div>

                    </div>

                    <div class="px-8 py-5 bg-gray-50 border-t border-gray-200 flex justify-end">
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-xl hover:from-purple-700 hover:to-indigo-700 shadow-lg transform hover:scale-105 transition-all">
                            Create Item
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection