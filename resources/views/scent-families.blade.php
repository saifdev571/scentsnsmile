@extends('layouts.app')

@php
    $pageTitle = 'Scent Families | Scents N Smile';
    $metaDescription = 'Explore our diverse scent families. Find your perfect fragrance match from Fresh, Floral, Woody, and more.';
@endphp

@section('content')
<div class="font-sans antialiased text-gray-900 bg-white min-h-screen">
    
    {{-- Header Spacing --}}
    <div class="h-16 md:h-20"></div>

    {{-- Main Container --}}
    <div class="w-full">
        
        @if($activeFamily)
            {{-- Active Scent Family Section (Expanded) --}}
            <div class="relative w-full overflow-hidden transition-all duration-500 ease-in-out" 
                 style="background-color: {{ $activeFamily->color_code ?? '#dcfce7' }};"> {{-- Default green-100 --}}
                
                <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
                    <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                        
                        {{-- Left Content: Text & Description --}}
                        <div class="w-full md:w-1/3 flex flex-col items-center md:items-start text-center md:text-left space-y-6 z-10">
                            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-sm border border-white/50 relative overflow-hidden">
                                {{-- Decorative Elements (Simplified based on reference) --}}
                                <div class="absolute -top-6 -right-6 w-24 h-24 bg-yellow-300 rounded-full opacity-20 blur-xl"></div>
                                <div class="absolute bottom-0 left-0 w-32 h-32 bg-green-300 rounded-full opacity-20 blur-2xl"></div>

                                <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tight mb-4 relative z-10">{{ $activeFamily->name }}</h1>
                                
                                <p class="text-gray-700 text-lg leading-relaxed mb-6 relative z-10">
                                    {{ $activeFamily->description ?? 'Discover our collection of fresh, vibrant scents perfect for everyday wear.' }}
                                </p>
                                
                                <a href="#products-grid" class="inline-block bg-black text-white font-bold py-3 px-8 rounded-full hover:bg-gray-800 transition-transform transform hover:scale-105 shadow-lg">
                                    SHOP {{ strtoupper($activeFamily->name) }}
                                </a>
                            </div>
                        </div>

                        {{-- Right Content: Product Carousel / Grid --}}
                        <div class="w-full md:w-2/3 relative z-10 group" id="products-grid">
                            @if($activeFamily->products->isNotEmpty())
                                {{-- Slider Arrows --}}
                                <button onclick="document.getElementById('scent-products-slider').scrollBy({left: -320, behavior: 'smooth'})" 
                                        class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-20 bg-white/80 hover:bg-white text-gray-800 p-3 rounded-full shadow-lg backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100 disabled:opacity-0 focus:outline-none hidden md:block border border-gray-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                
                                <button onclick="document.getElementById('scent-products-slider').scrollBy({left: 320, behavior: 'smooth'})" 
                                        class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-20 bg-white/80 hover:bg-white text-gray-800 p-3 rounded-full shadow-lg backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100 disabled:opacity-0 focus:outline-none hidden md:block border border-gray-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>

                                {{-- Custom Scrollbar Container --}}
                                <div id="scent-products-slider" class="flex overflow-x-auto gap-4 py-8 px-4 -mx-4 snap-x snap-mandatory hide-scroll-bar scroll-smooth">
                                    @foreach($activeFamily->products as $product)
                                        <div class="flex-none w-72 snap-center">
                                            @include('partials.product-card', ['product' => $product])
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex items-center justify-center h-64 bg-white/50 rounded-3xl border-2 border-dashed border-gray-300">
                                    <p class="text-gray-500 font-medium">No products found in this family yet.</p>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        @endif

        {{-- Other Families (Accordion List) --}}
        <div class="w-full bg-white">
            @foreach($allFamilies as $family)
                @if(!$activeFamily || $family->id !== $activeFamily->id)
                    <a href="{{ route('scent-families', ['scent' => $family->slug]) }}" 
                       class="group block border-b border-gray-100 hover:bg-gray-50 transition-colors duration-300">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
                            <div class="flex items-center gap-6">
                                {{-- Family Color Dot --}}
                                <div class="w-3 h-12 rounded-full" style="background-color: {{ $family->color_code ?? '#e5e7eb' }};"></div>
                                
                                <h2 class="text-2xl md:text-3xl font-bold text-gray-400 group-hover:text-gray-900 transition-colors uppercase tracking-tight">
                                    {{ $family->name }}
                                </h2>
                            </div>
                            
                            {{-- Expand Icon --}}
                            <div class="w-10 h-10 rounded-full border-2 border-gray-200 flex items-center justify-center group-hover:border-black group-hover:bg-black group-hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>

    </div>
</div>

<style>
/* Hide scrollbar for Chrome, Safari and Opera */
.hide-scroll-bar::-webkit-scrollbar {
    display: none;
}
/* Hide scrollbar for IE, Edge and Firefox */
.hide-scroll-bar {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
</style>
@endsection
