@extends('admin.layouts.app')

@section('title', 'Promotions & Discounts')
@section('page-title', 'Promotions & Discounts')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Promotions & Sales</h2>
            <p class="text-gray-600 mt-1">Manage discounts, sales banners, and promotional offers</p>
        </div>
        <button onclick="openModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Promotion
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-4">
        <form method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Search promotions..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                Filter
            </button>
        </form>
    </div>

    <!-- Promotions List -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Promotion</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Discount</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Conditions</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Display</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Validity</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($promotions as $promotion)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white text-lg" 
                                     style="background-color: {{ $promotion->badge_color ?? '#ef4444' }}">
                                    %
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $promotion->name }}</p>
                                    @if($promotion->badge_text)
                                    <span class="text-xs px-2 py-0.5 rounded text-white" style="background-color: {{ $promotion->badge_color ?? '#ef4444' }}">
                                        {{ $promotion->badge_text }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-green-600">
                                {{ $promotion->discount_type === 'percentage' ? $promotion->discount_value . '%' : '₹' . number_format($promotion->discount_value, 0) }}
                            </span>
                            <span class="text-gray-500 text-sm">OFF</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <div>Min {{ $promotion->min_items }} items</div>
                            @if($promotion->free_shipping)
                            <div class="text-green-600">🚚 Free shipping ({{ $promotion->free_shipping_min_items }}+ items)</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-1">
                                @if($promotion->show_in_header)
                                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded">Header</span>
                                @endif
                                @if($promotion->show_in_cart)
                                <span class="text-xs px-2 py-1 bg-purple-100 text-purple-700 rounded">Cart</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($promotion->starts_at || $promotion->ends_at)
                            <div class="text-gray-600">
                                @if($promotion->starts_at)
                                {{ $promotion->starts_at->format('d M Y') }}
                                @else
                                Start
                                @endif
                                -
                                @if($promotion->ends_at)
                                {{ $promotion->ends_at->format('d M Y') }}
                                @else
                                No End
                                @endif
                            </div>
                            @else
                            <span class="text-gray-400">Always</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <button onclick="togglePromotion({{ $promotion->id }})" 
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $promotion->is_active ? 'bg-green-500' : 'bg-gray-300' }}"
                                id="toggle-{{ $promotion->id }}">
                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $promotion->is_active ? 'translate-x-6' : 'translate-x-1' }}"
                                    id="toggle-dot-{{ $promotion->id }}"></span>
                            </button>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="editPromotion({{ $promotion->id }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button onclick="deletePromotion({{ $promotion->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                                </svg>
                                <p class="text-lg font-medium">No promotions found</p>
                                <p class="text-sm">Create your first promotion to get started</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($promotions->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $promotions->links() }}
        </div>
        @endif
    </div>
</div>

@include('admin.promotions.modal')
@endsection

@push('scripts')
@include('admin.promotions.scripts')
@endpush
