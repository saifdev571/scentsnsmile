@extends('layouts.app')

@php
    $pageTitle = 'Scent Families | Scents N Smile';
    $metaDescription = 'Explore our diverse scent families. Find your perfect fragrance match from Fresh, Floral, Woody, and more.';
@endphp

@section('content')
    <div class="font-sans antialiased text-gray-900 bg-white min-h-screen">

        {{-- Header Spacing --}}
        <div class="h-16 md:h-20"></div>

        {{-- Hero Section --}}
        <div class="w-full relative bg-cover bg-center py-16 md:py-24" style="background-image: url('{{ asset('images/Perfume Background.jpg') }}');">
            <!-- Overlay for better text readability -->
            <div class="absolute inset-0 bg-white/60"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="max-w-3xl">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 mb-6 leading-tight">
                        Our Scent Families
                    </h1>
                    <div class="space-y-4 text-lg md:text-xl text-gray-700 leading-relaxed">
                        <p>Step into the world of ScentsNsmile, where every fragrance begins with intention.</p>
                        <p>Our collection is curated into seven distinctive olfactive families, each telling its own story through mood, depth, and emotion.</p>
                        <p>These families are the heart of our craft—the creative pillars that shape every composition, guiding its character from the first note to the lasting impression.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Container --}}
        <div class="w-full">

            @if($activeFamily)
                {{-- Active Scent Family Section (Expanded) --}}
                <div class="relative w-full overflow-hidden transition-all duration-500 ease-in-out"
                    style="background-color: {{ $activeFamily->color_code ?? '#dcfce7' }};">

                    {{-- Background Image with Overlay --}}
                    @if($activeFamily->imagekit_url)
                        <div class="absolute inset-0 z-0">
                            <img src="{{ $activeFamily->imagekit_url }}" alt="{{ $activeFamily->name }}"
                                class="w-full h-full object-cover opacity-60">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/70 via-white/40 to-transparent"></div>
                        </div>
                    @endif

                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16 relative z-10">
                        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">

                            {{-- Left Content: Text & Description --}}
                            <div
                                class="w-full md:w-1/3 flex flex-col items-center md:items-start text-center md:text-left space-y-6 z-10">
                                <div
                                    class="bg-white/90 backdrop-blur-md rounded-3xl p-8 shadow-xl border border-white/50 relative overflow-hidden">
                                    {{-- Decorative Elements --}}
                                    <div
                                        class="absolute -top-6 -right-6 w-24 h-24 bg-yellow-300 rounded-full opacity-20 blur-xl">
                                    </div>
                                    <div
                                        class="absolute bottom-0 left-0 w-32 h-32 bg-green-300 rounded-full opacity-20 blur-2xl">
                                    </div>

                                    <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tight mb-4 relative z-10">
                                        {{ $activeFamily->name }}</h1>

                                    <div
                                        class="text-gray-700 text-lg leading-relaxed relative z-10 prose prose-sm max-w-none">
                                        {!! $activeFamily->description ?? 'Discover our collection of fresh, vibrant scents perfect for everyday wear.' !!}
                                    </div>
                                </div>
                            </div>

                            {{-- Right Content: Product Carousel / Grid --}}
                            <div class="w-full md:w-2/3 relative z-10 group" id="products-grid">
                                @if($activeFamily->products->isNotEmpty())
                                    {{-- Slider Arrows (Only if more than 3 products) --}}
                                    @if($activeFamily->products->count() > 3)
                                        <button
                                            onclick="document.getElementById('scent-products-slider').scrollBy({left: -305, behavior: 'smooth'})"
                                            class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 z-30 bg-white shadow-lg text-gray-800 p-3 rounded-full hover:bg-gray-50 focus:outline-none hidden md:flex items-center justify-center border border-gray-100 cursor-pointer">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>

                                        <button
                                            onclick="document.getElementById('scent-products-slider').scrollBy({left: 305, behavior: 'smooth'})"
                                            class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 z-30 bg-white shadow-lg text-gray-800 p-3 rounded-full hover:bg-gray-50 focus:outline-none hidden md:flex items-center justify-center border border-gray-100 cursor-pointer">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    @endif

                                    {{-- Custom Scrollbar Container --}}
                                    <div id="scent-products-slider"
                                        class="flex overflow-x-auto gap-4 py-8 px-4 -mx-4 snap-x snap-proximity hide-scroll-bar scroll-smooth">
                                        @foreach($activeFamily->products as $product)
                                            <div class="flex-none w-72 snap-center">
                                                @include('partials.product-card', ['product' => $product])
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div
                                        class="flex items-center justify-center h-64 bg-white/50 rounded-3xl border-2 border-dashed border-gray-300">
                                        <p class="text-gray-500 font-medium">No products found in this family yet.</p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            @endif

            {{-- Other Families (Accordion List) --}}
            <div class="w-full bg-white mt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
                @foreach($allFamilies as $family)
                    @if(!$activeFamily || $family->id !== $activeFamily->id)
                        <a href="{{ route('scent-families', ['scent' => $family->slug]) }}"
                            class="group block border-b border-gray-100 hover:bg-gray-50 transition-all duration-300 relative overflow-hidden rounded-3xl shadow-sm hover:shadow-md">
                            
                            {{-- Background Image with Overlay --}}
                            @if($family->imagekit_url)
                                <div class="absolute inset-0 z-0">
                                    <img src="{{ $family->imagekit_url }}" alt="{{ $family->name }}"
                                        class="w-full h-full object-cover opacity-50 transition-opacity group-hover:opacity-60">
                                </div>
                            @endif
                            
                            <div class="px-6 py-12 flex items-center justify-between relative z-10">
                                {{-- White Pill Title --}}
                                <div class="bg-white rounded-full py-2 pl-6 pr-2 flex items-center gap-4 shadow-sm w-fit">
                                    <h2 class="text-xl md:text-2xl font-bold text-gray-900 uppercase tracking-tight whitespace-nowrap">
                                        {{ $family->name }}
                                    </h2>
                                    
                                    @if($family->imagekit_url)
                                        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-white shadow-inner flex-shrink-0">
                                            <img src="{{ $family->imagekit_thumbnail_url ?? $family->imagekit_url }}" 
                                                 alt="{{ $family->name }}" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                    @endif
                                </div>

                                {{-- Expand Icon --}}
                                <div class="w-12 h-12 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center text-gray-600 border border-white/50 group-hover:bg-white group-hover:scale-110 transition-all duration-300 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
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
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>
@endsection