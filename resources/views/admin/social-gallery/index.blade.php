@extends('admin.layouts.app')

@section('title', 'Social Gallery')

@section('content')
    <div class="min-h-screen bg-gray-50 p-6">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Social Gallery</h1>
                <p class="text-gray-500 mt-1">Manage external social media posts for the "Join the Club" slider.</p>
            </div>
            <a href="{{ route('admin.social-gallery.create') }}"
                class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-xl hover:from-purple-700 hover:to-indigo-700 shadow-lg transform hover:scale-105 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Post
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-xl flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Order</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Preview</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Username</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">External Link</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($items as $item)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-600 font-bold text-sm">
                                        {{ $item->sort_order }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="relative h-16 w-16 rounded-xl overflow-hidden border border-gray-200 shadow-sm group-hover:shadow-md transition-all">
                                        <img src="{{ $item->image_url }}" class="h-full w-full object-cover">
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $item->username ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                     @if($item->external_link)
                                        <a href="{{ $item->external_link }}" target="_blank" class="text-sm text-purple-600 hover:text-purple-800 hover:underline flex items-center gap-1">
                                            View Link
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400">No Link</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->is_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ route('admin.social-gallery.edit', $item) }}" 
                                           class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('admin.social-gallery.destroy', $item) }}" method="POST" class="inline-block"
                                              onsubmit="return confirm('Are you sure you want to delete this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900">No Social items yet</h3>
                                        <p class="text-gray-500 mt-1 mb-4">Get started by adding your first social media post.</p>
                                        <a href="{{ route('admin.social-gallery.create') }}" class="text-purple-600 hover:text-purple-700 font-medium">Add New Post &rarr;</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
