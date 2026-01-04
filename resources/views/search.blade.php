@extends('layouts.app')

@section('title', ($selectedNote ? $selectedNote->name . ' Fragrances' : ($query ? 'Search: ' . $query : 'Search')) . ' - Scents N Smile')

@section('content')
<!-- Search Page -->
<section class="pt-20 pb-8 bg-white min-h-screen">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Back Button -->
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-gray-600 hover:text-gray-900 mb-4 text-xs">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back
        </a>

        <!-- Search Bar -->
        <div class="mb-4">
            <form action="{{ route('search') }}" method="GET" class="relative">
                <input type="hidden" name="gender" value="{{ $genderFilter }}">
                <input 
                    type="text" 
                    name="q"
                    value="{{ $query }}"
                    placeholder="Search for fragrances..."
                    class="w-full px-4 py-2.5 pr-20 border-2 border-gray-300 rounded-full text-sm focus:outline-none focus:border-gray-400 transition"
                >
                <div class="absolute right-1.5 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
                    @if($query || $selectedNote)
                    <a href="{{ route('search') }}" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                    @endif
                    <button type="submit" class="bg-[#e8a598] hover:bg-[#d99588] text-white rounded-full p-2 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Count -->
        @if($selectedNote)
        <div class="flex items-center gap-2 mb-3">
            <p class="text-xs text-gray-600">{{ $products->total() }} Products with scent note:</p>
            <span class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">
                {{ $selectedNote->name }}
                <a href="{{ route('search') }}" class="ml-2 hover:text-amber-600">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </span>
        </div>
        @elseif($query)
        <p class="text-xs text-gray-600 mb-3">{{ $products->total() }} Results for "<span class="font-semibold">{{ $query }}</span>"</p>
        @else
        <p class="text-xs text-gray-600 mb-3">{{ $products->total() }} Products</p>
        @endif

        <!-- Filter Tabs (Dynamic Genders) -->
        <div class="flex gap-2 mb-5 overflow-x-auto pb-2">
            <!-- All Tab -->
            @if($noteSlug)
            <a href="{{ route('scent-notes.show', $noteSlug) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap transition {{ $genderFilter === 'all' ? 'bg-black text-white' : 'bg-white text-gray-700 border border-gray-300 hover:border-gray-400' }}">
                All ({{ $totalCount }})
            </a>
            @else
            <a href="{{ route('search', ['q' => $query, 'gender' => 'all']) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap transition {{ $genderFilter === 'all' ? 'bg-black text-white' : 'bg-white text-gray-700 border border-gray-300 hover:border-gray-400' }}">
                All ({{ $totalCount }})
            </a>
            @endif
            
            <!-- Dynamic Gender Tabs -->
            @foreach($genders as $gender)
            @if($noteSlug)
            <a href="{{ route('scent-notes.show', ['slug' => $noteSlug, 'gender' => $gender->id]) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap transition {{ $genderFilter == $gender->id ? 'bg-black text-white' : 'bg-white text-gray-700 border border-gray-300 hover:border-gray-400' }}">
                {{ $gender->name }} ({{ $genderCounts[$gender->id] ?? 0 }})
            </a>
            @else
            <a href="{{ route('search', ['q' => $query, 'gender' => $gender->id]) }}" 
               class="px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap transition {{ $genderFilter == $gender->id ? 'bg-black text-white' : 'bg-white text-gray-700 border border-gray-300 hover:border-gray-400' }}">
                {{ $gender->name }} ({{ $genderCounts[$gender->id] ?? 0 }})
            </a>
            @endif
            @endforeach
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($products as $product)
            @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            @if($noteSlug)
            {{ $products->appends(['gender' => $genderFilter])->links() }}
            @else
            {{ $products->appends(['q' => $query, 'gender' => $genderFilter])->links() }}
            @endif
        </div>
        @else
        <!-- No Results -->
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">No products found</h3>
            @if($query)
            <p class="text-gray-600 text-sm mb-4">We couldn't find any products matching "{{ $query }}"</p>
            @elseif($selectedNote)
            <p class="text-gray-600 text-sm mb-4">No products found with scent note "{{ $selectedNote->name }}"</p>
            @else
            <p class="text-gray-600 text-sm mb-4">Try searching for something else</p>
            @endif
            <a href="{{ route('collections') }}" class="inline-flex items-center px-6 py-2.5 bg-[#e8a598] text-white text-sm font-medium rounded-full hover:bg-[#d99588] transition">
                Browse All Products
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
