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
                <div class="relative w-full overflow-hidden transition-all duration-700 ease-out"
                    style="background: linear-gradient(135deg, {{ $activeFamily->color_code ?? '#dcfce7' }} 0%, #ffffff 100%);">

                    {{-- Abstract Background Shapes --}}
                    <div
                        class="absolute top-0 right-0 w-[500px] h-[500px] bg-white opacity-20 blur-[100px] rounded-full mix-blend-overlay pointer-events-none">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-white opacity-30 blur-[120px] rounded-full mix-blend-soft-light pointer-events-none">
                    </div>

                    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative z-10">
                        <div class="flex flex-col lg:flex-row items-start gap-12 lg:gap-20">

                            {{-- Left Content: Text & Description --}}
                            <div
                                class="w-full lg:w-1/3 flex flex-col items-center lg:items-start text-center lg:text-left space-y-8 sticky top-24">

                                <!-- Main Heading -->
                                <div>
                                    <span class="block text-xs font-bold tracking-[0.2em] text-gray-500 uppercase mb-3">Discover
                                        Collection</span>
                                    <h1
                                        class="text-5xl md:text-7xl font-black uppercase tracking-tighter text-gray-900 leading-[0.9]">
                                        {{ $activeFamily->name }}
                                    </h1>
                                </div>

                                <!-- Description -->
                                <div class="relative">
                                    <span class="absolute -left-4 -top-2 text-6xl text-black opacity-5 font-serif">"</span>
                                    <p class="text-gray-700 text-lg md:text-xl font-medium leading-relaxed max-w-lg">
                                        {{ $activeFamily->description ?? 'Immerse yourself in our collection of curated scents. Designed to evoke emotion and capture memories.' }}
                                    </p>
                                </div>

                                <!-- CTA Button -->
                                <a href="#products-grid"
                                    class="group relative inline-flex items-center justify-center px-8 py-4 bg-gray-900 text-white text-sm font-bold tracking-widest uppercase rounded-full overflow-hidden shadow-2xl hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                    <span class="relative z-10 flex items-center gap-2">
                                        Shop Collection
                                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </span>
                                    <div
                                        class="absolute inset-0 bg-gray-800 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300">
                                    </div>
                                </a>

                                <!-- Scent Characteristics (Optional Mockup) -->
                                <div
                                    class="flex items-center gap-6 mt-4 pt-8 border-t border-black/5 w-full justify-center lg:justify-start">
                                    <div class="flex flex-col items-center lg:items-start">
                                        <span class="text-2xl font-bold text-gray-900">100%</span>
                                        <span class="text-xs uppercase tracking-wider text-gray-500 font-bold">Vegan</span>
                                    </div>
                                    <div class="w-px h-8 bg-black/10"></div>
                                    <div class="flex flex-col items-center lg:items-start">
                                        <span class="text-2xl font-bold text-gray-900">24h</span>
                                        <span class="text-xs uppercase tracking-wider text-gray-500 font-bold">Lasting</span>
                                    </div>
                                    <div class="w-px h-8 bg-black/10"></div>
                                    <div class="flex flex-col items-center lg:items-start">
                                        <span class="text-2xl font-bold text-gray-900">IFRA</span>
                                        <span class="text-xs uppercase tracking-wider text-gray-500 font-bold">Certified</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Right Content: Product Carousel / Grid --}}
                            <div class="w-full lg:w-2/3 relative group" id="products-grid">
                                @if($activeFamily->products->isNotEmpty())
                                    {{-- Slider Controls --}}
                                    <div class="absolute -top-16 right-0 hidden md:flex items-center gap-2">
                                        <button
                                            onclick="document.getElementById('scent-products-slider').scrollBy({left: -320, behavior: 'smooth'})"
                                            class="w-12 h-12 flex items-center justify-center rounded-full border border-gray-900/10 hover:bg-gray-900 hover:text-white transition-all text-gray-600 focus:outline-none">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <button
                                            onclick="document.getElementById('scent-products-slider').scrollBy({left: 320, behavior: 'smooth'})"
                                            class="w-12 h-12 flex items-center justify-center rounded-full border border-gray-900/10 hover:bg-gray-900 hover:text-white transition-all text-gray-600 focus:outline-none">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Products Slider --}}
                                    <div id="scent-products-slider"
                                        class="flex overflow-x-auto gap-6 py-4 px-1 -mx-1 snap-x snap-proximity hide-scroll-bar scroll-smooth">
                                        @foreach($activeFamily->products as $product)
                                            <div
                                                class="flex-none w-[280px] md:w-[320px] snap-center transform transition-transform duration-300 hover:-translate-y-2">
                                                @include('partials.product-card', ['product' => $product])
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div
                                        class="flex flex-col items-center justify-center h-96 bg-white/40 backdrop-blur-sm rounded-3xl border border-white/60 shadow-sm">
                                        <div
                                            class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-4xl">
                                            🍃</div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">Collection Coming Soon</h3>
                                        <p class="text-gray-500">We are curating the best {{ strtolower($activeFamily->name) }}
                                            scents for you.</p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            @endif

            {{-- Other Families (Accordion List) --}}
            <div class="bg-white py-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
                    <h2 class="text-2xl font-bold uppercase tracking-widest text-center text-gray-900">Explore Other
                        Families</h2>
                </div>

                <div class="max-w-4xl mx-auto px-4">
                    @foreach($allFamilies as $family)
                        @if(!$activeFamily || $family->id !== $activeFamily->id)
                            <a href="{{ route('scent-families', ['scent' => $family->slug]) }}"
                                class="group block relative overflow-hidden mb-4 rounded-2xl transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl">

                                <div class="absolute inset-0 bg-gray-100 transition-colors duration-500 group-hover:bg-opacity-0"
                                    style="background-color: {{ $family->color_code ?? '#f3f4f6' }}; opacity: 0.3;">
                                </div>

                                <div
                                    class="relative p-8 md:p-10 flex items-center justify-between bg-white border border-gray-100 rounded-2xl group-hover:border-transparent group-hover:bg-gradient-to-r group-hover:from-gray-50 group-hover:to-white transition-all duration-500">
                                    <div class="flex items-center gap-8">
                                        <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl bg-white shadow-sm group-hover:scale-110 transition-transform duration-500"
                                            style="color: {{ $family->color_code ?? '#000' }}; background-color: {{ $family->color_code ?? '#f3f4f6' }}20;">
                                            @if($family->icon) {{ $family->icon }} @else ● @endif
                                        </div>

                                        <div>
                                            <h3
                                                class="text-3xl md:text-4xl font-black text-gray-300 group-hover:text-gray-900 uppercase tracking-tighter transition-colors duration-300">
                                                {{ $family->name }}
                                            </h3>
                                            <p
                                                class="text-sm font-medium text-gray-400 group-hover:text-gray-600 mt-1 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300 delay-100">
                                                Click to explore collection
                                            </p>
                                        </div>
                                    </div>

                                    <div
                                        class="w-12 h-12 flex items-center justify-center rounded-full border border-gray-200 group-hover:bg-black group-hover:border-black group-hover:text-white transition-all duration-300">
                                        <svg class="w-5 h-5 transform -rotate-45 group-hover:rotate-0 transition-transform duration-500"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
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