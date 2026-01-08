@extends('admin.layouts.app')

@section('title', 'Promotional Cards')

@section('content')
    <div class="min-h-screen bg-gray-50 p-6">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">Promotional Cards</h1>
                <a href="{{ route('admin.promotional-cards.create') }}"
                    class="px-6 py-2.5 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-700 shadow-lg">
                    Add New Card
                </a>
            </div>
            <p class="mt-2 text-gray-600">Manage promotional cards injected into the product grid.</p>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-xl">
                <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Position</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Preview</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Name/Title</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($cards as $card)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-gray-900">#{{ $card->position }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($card->type === 'image')
                                        <img src="{{ $card->media_url }}" alt="Preview"
                                            class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                                    @else
                                        <div
                                            class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                            <span class="text-xs font-bold text-gray-500">VIDEO</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $card->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $card->title ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full {{ $card->type === 'image' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                                        {{ strtoupper($card->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full {{ $card->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $card->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.promotional-cards.edit', $card) }}"
                                        class="text-purple-600 hover:text-purple-900 mr-3">Edit</a>
                                    <form action="{{ route('admin.promotional-cards.destroy', $card) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    No promotional cards found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection