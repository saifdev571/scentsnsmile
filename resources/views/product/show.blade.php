@extends('layouts.app')

@section('title', $product->name . ' - Scents N Smile')

@section('content')
<!-- Breadcrumb -->
<section class="pt-24 md:pt-28 pb-4 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <nav class="flex items-center gap-2 text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-gray-900 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Shop All
            </a>
            @if($product->category)
            <span>/</span>
            <a href="#" class="hover:text-gray-900">{{ $product->category->name }}</a>
            @endif
            <span>/</span>
            <span class="text-gray-900 font-medium uppercase">{{ $product->name }}</span>
        </nav>
    </div>
</section>

<!-- Product Details -->
<section class="py-6 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left: Product Images -->
            <div class="flex gap-3">
                <!-- Thumbnail Column -->
                <div class="flex flex-col gap-2 w-20">
                    @php
                        $allImages = $product->images_array ?? [];
                    @endphp
                    @foreach($allImages as $index => $image)
                    <button onclick="changeMainImage('{{ $image }}', this)" class="thumbnail-btn border-2 {{ $index === 0 ? 'border-black' : 'border-gray-300' }} rounded-lg overflow-hidden hover:border-black transition">
                        <img src="{{ $image }}" alt="Thumbnail {{ $index + 1 }}" class="w-full aspect-square object-cover">
                    </button>
                    @endforeach
                </div>

                <!-- Main Image -->
                <div class="flex-1 relative">
                    <!-- Badges - Left Side -->
                    <div class="absolute top-3 left-3 z-10 flex gap-2">
                        @if($product->genders && $product->genders->count() > 0)
                        <span class="bg-white text-red-500 px-3 py-1 rounded-full text-xs font-bold border-2 border-red-500">{{ $product->genders->first()->name }}</span>
                        @endif
                        @if($product->is_bestseller || $product->is_featured)
                        <span class="bg-[#d4c4b0] text-gray-800 px-3 py-1 rounded-full text-xs font-bold">Bestseller</span>
                        @endif
                    </div>

                    <!-- Sale Badge - Right Side -->
                    @if($product->sale_price && $product->sale_price < $product->price)
                    @php
                        $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                    @endphp
                    <div class="absolute top-3 right-3 z-10">
                        <div class="bg-black text-white rounded-full w-16 h-16 flex flex-col items-center justify-center">
                            <span class="text-[8px] font-bold uppercase leading-none">SALE</span>
                            <span class="text-lg font-black leading-none">{{ $discount }}%</span>
                            <span class="text-[8px] font-bold uppercase leading-none">OFF</span>
                        </div>
                    </div>
                    @endif

                    <div class="bg-[#f5f5f0] rounded-2xl overflow-hidden aspect-square relative">
                        <img id="mainProductImage" src="{{ $product->image_url ?? 'https://images.pexels.com/photos/965989/pexels-photo-965989.jpeg?auto=compress&cs=tinysrgb&w=800' }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover transition-opacity duration-300">
                        
                        <!-- Navigation Arrows -->
                        @if(count($allImages) > 1)
                        <div class="absolute right-3 bottom-3 flex gap-2">
                            <button onclick="previousProductImage()" class="w-12 h-12 bg-gray-400 bg-opacity-70 hover:bg-opacity-90 rounded-full flex items-center justify-center shadow-lg transition">
                                <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button onclick="nextProductImage()" class="w-12 h-12 bg-white hover:bg-gray-100 rounded-full flex items-center justify-center shadow-lg transition">
                                <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right: Product Info -->
            <div class="space-y-4">
                <!-- Product Title -->
                <div>
                    <h1 class="text-2xl md:text-3xl font-black uppercase mb-2">{{ $product->name }}</h1>
                    
                    <!-- Rating -->
                    <div class="flex items-center gap-2 mb-2">
                        <div class="flex items-center text-black text-sm">★★★★★</div>
                        <span class="text-sm text-gray-600 underline">({{ rand(100, 500) }} reviews)</span>
                    </div>

                    <!-- Product Type / Scent Note -->
                    @if($product->scent_note || $product->short_description)
                    <div class="text-sm text-gray-600 mb-3">{!! strip_tags($product->scent_note ?? $product->short_description) !!}</div>
                    @endif
                </div>

                <!-- Brand Info -->
                @if($product->brand)
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-sm">
                        <span class="font-bold">Brand:</span> {{ $product->brand->name }}
                    </p>
                </div>
                @endif

                <!-- Tags -->
                @if($product->tagsList && $product->tagsList->count() > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($product->tagsList as $tag)
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs">{{ $tag->name }}</span>
                    @endforeach
                </div>
                @endif

                <!-- Sizes -->
                @if($product->sizes && $product->sizes->count() > 0)
                <div>
                    <p class="text-sm font-bold mb-2">Available Sizes:</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->sizes as $size)
                        <span class="border border-gray-300 px-3 py-1 rounded-lg text-sm hover:border-black cursor-pointer transition">{{ $size->name }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Scent Intensity Scale -->
                @if($product->scent_intensity)
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-700">Scent Intensity Scale:</span>
                        <span class="text-sm font-bold text-[#e8a598] capitalize">{{ ucfirst($product->scent_intensity) }}</span>
                        @php
                            $dots = $product->scent_intensity === 'soft' ? 1 : ($product->scent_intensity === 'significant' ? 2 : 3);
                        @endphp
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 3; $i++)
                                <span class="w-2 h-2 rounded-full {{ $i <= $dots ? 'bg-[#e8a598]' : 'bg-gray-300' }}"></span>
                            @endfor
                        </div>
                        <button onclick="openScentIntensityModal()" class="w-5 h-5 rounded-full bg-gray-400 text-white flex items-center justify-center text-xs hover:bg-gray-500 transition">
                            ?
                        </button>
                    </div>
                </div>
                @endif

                <!-- Price & Add to Cart -->
                <div class="border-t pt-4">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <div class="flex items-center gap-2">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                <span class="text-3xl font-black text-[#e8a598]">₹{{ number_format($product->sale_price, 2) }}</span>
                                <span class="text-xl text-gray-400 line-through">₹{{ number_format($product->price, 2) }}</span>
                                @else
                                <span class="text-3xl font-black text-[#e8a598]">₹{{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                            @if($product->sale_price && $product->sale_price < $product->price)
                            <p class="text-xs text-gray-500 mt-0.5">Save ₹{{ number_format($product->price - $product->sale_price, 2) }}</p>
                            @endif
                        </div>
                        <button class="w-9 h-9 border-2 border-gray-300 rounded-full flex items-center justify-center hover:border-red-500 hover:text-red-500 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Stock Status -->
                    @if($product->stock_status === 'in_stock' || $product->stock > 0)
                    <p class="text-sm text-green-600 mb-3">✓ In Stock</p>
                    @else
                    <p class="text-sm text-red-600 mb-3">✗ Out of Stock</p>
                    @endif

                    <button onclick="addToCart({{ $product->id }})" class="w-full bg-[#e8a598] hover:bg-[#d4948a] text-white font-bold py-3 rounded-full text-base transition-colors mb-4">
                        ADD TO CART
                    </button>

                    <!-- Secure Checkout -->
                    <div class="text-center mb-4">
                        <h3 class="text-sm font-medium text-gray-600 mb-3">Secure Checkout With</h3>
                        <div class="flex items-center justify-center gap-3">
                            <div class="bg-white rounded-lg p-2 shadow-sm">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/200px-Mastercard-logo.svg.png" alt="Mastercard" class="h-6 object-contain">
                            </div>
                            <div class="bg-white rounded-lg p-2 shadow-sm">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/200px-Visa_Inc._logo.svg.png" alt="Visa" class="h-6 object-contain">
                            </div>
                            <div class="bg-white rounded-lg p-2 shadow-sm">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/American_Express_logo_%282018%29.svg/200px-American_Express_logo_%282018%29.svg.png" alt="American Express" class="h-6 object-contain">
                            </div>
                            <div class="bg-white rounded-lg p-2 shadow-sm">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Apple_Pay_logo.svg/200px-Apple_Pay_logo.svg.png" alt="Apple Pay" class="h-6 object-contain">
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Info Banner -->
                    <div class="bg-[#f5ecd7] rounded-lg p-3 text-[#5c4033] mb-3">
                        <div class="flex items-center gap-1.5 mb-1">
                            <span class="text-sm font-medium">Free Shipping</span>
                        </div>
                        <p class="text-xs leading-relaxed">
                            Order within the next <span id="shippingCountdown" class="font-bold">--</span> for dispatch today
                        </p>
                    </div>
                </div>

                <!-- Horizontal Slider Tabs -->
                <div class="border-t pt-4">
                    <!-- Tab Slider Container with Navigation -->
                    <div class="relative flex items-center gap-2">
                        <!-- Left Arrow -->
                        <button onclick="slideTabsLeft()" id="tabSlideLeft" class="flex-shrink-0 w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition hidden">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        
                        <!-- Tabs Container -->
                        <div class="flex-1 overflow-hidden">
                            <div class="flex gap-3 transition-transform duration-300" id="tabSlider" style="transform: translateX(0);">
                                @php
                                    $tabIndex = 0;
                                    $firstTab = null;
                                    if($product->about_scent) $firstTab = 'aboutScent';
                                    elseif($product->fragrance_notes || ($product->highlightNotes && $product->highlightNotes->count() > 0)) $firstTab = 'fragranceNotes';
                                    elseif($product->ingredients_details) $firstTab = 'ingredientsDetails';
                                    elseif($product->shipping_info) $firstTab = 'shippingReturns';
                                @endphp
                                
                                @if($product->about_scent)
                                <button onclick="toggleProductTab('aboutScent')" id="aboutScentProductTab" 
                                    class="product-tab flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium whitespace-nowrap border border-gray-300 bg-white text-gray-700 hover:border-gray-400 transition-all duration-200 flex-shrink-0">
                                    <span>About</span>
                                    <svg class="w-4 h-4 tab-arrow transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                @endif
                                
                                @if($product->fragrance_notes || ($product->highlightNotes && $product->highlightNotes->count() > 0))
                                <button onclick="toggleProductTab('fragranceNotes')" id="fragranceNotesProductTab" 
                                    class="product-tab tab-active flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium whitespace-nowrap border border-gray-300 bg-white text-gray-700 hover:border-gray-400 transition-all duration-200 flex-shrink-0">
                                    <span>Notes</span>
                                    <svg class="w-4 h-4 tab-arrow transition-transform duration-200" style="transform: rotate(180deg);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                @endif
                                
                                @if($product->ingredients_details)
                                <button onclick="toggleProductTab('ingredientsDetails')" id="ingredientsDetailsProductTab" 
                                    class="product-tab flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium whitespace-nowrap border border-gray-300 bg-white text-gray-700 hover:border-gray-400 transition-all duration-200 flex-shrink-0">
                                    <span>Ingredients</span>
                                    <svg class="w-4 h-4 tab-arrow transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                @endif
                                
                                @if($product->shipping_info)
                                <button onclick="toggleProductTab('shippingReturns')" id="shippingReturnsProductTab" 
                                    class="product-tab flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium whitespace-nowrap border border-gray-300 bg-white text-gray-700 hover:border-gray-400 transition-all duration-200 flex-shrink-0">
                                    <span>Shipping + Returns</span>
                                    <svg class="w-4 h-4 tab-arrow transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                                @endif
                                
                                @if($product->why_love_it)
                                <button onclick="toggleProductTab('whyLove')" id="whyLoveProductTab" 
                                    class="product-tab flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium whitespace-nowrap border border-gray-300 bg-white text-gray-700 hover:border-gray-400 transition-all duration-200 flex-shrink-0">
                                    <span>Why You'll Love It</span>
                                    <svg class="w-4 h-4 tab-arrow transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                @endif
                                
                                @if($product->what_makes_clean)
                                <button onclick="toggleProductTab('whatClean')" id="whatCleanProductTab" 
                                    class="product-tab flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium whitespace-nowrap border border-gray-300 bg-white text-gray-700 hover:border-gray-400 transition-all duration-200 flex-shrink-0">
                                    <span>What Makes It Clean</span>
                                    <svg class="w-4 h-4 tab-arrow transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                @endif
                                
                                @if($product->disclaimer)
                                <button onclick="toggleProductTab('disclaimer')" id="disclaimerProductTab" 
                                    class="product-tab flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium whitespace-nowrap border border-gray-300 bg-white text-gray-700 hover:border-gray-400 transition-all duration-200 flex-shrink-0">
                                    <span>Disclaimer</span>
                                    <svg class="w-4 h-4 tab-arrow transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                @endif
                                
                                @if($product->ask_question)
                                <button onclick="toggleProductTab('askQuestion')" id="askQuestionProductTab" 
                                    class="product-tab flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium whitespace-nowrap border border-gray-300 bg-white text-gray-700 hover:border-gray-400 transition-all duration-200 flex-shrink-0">
                                    <span>Ask a Question</span>
                                    <svg class="w-4 h-4 tab-arrow transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Right Arrow -->
                        <button onclick="slideTabsRight()" id="tabSlideRight" class="flex-shrink-0 w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Divider Line -->
                    <div class="border-b border-gray-200 mt-3"></div>

                    <!-- Tab Content Box (Scrollable) -->
                    <div class="relative mt-4">
                        @if($product->about_scent)
                        <div id="aboutScentProductContent" class="product-tab-content hidden" data-tab="aboutScent">
                            <div class="border border-gray-200 rounded-xl bg-gray-50 p-4 max-h-48 overflow-y-auto custom-scrollbar">
                                <div class="text-sm text-gray-700 leading-relaxed prose prose-sm max-w-none">
                                    {!! $product->about_scent !!}
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($product->fragrance_notes || ($product->highlightNotes && $product->highlightNotes->count() > 0))
                        <div id="fragranceNotesProductContent" class="product-tab-content" data-tab="fragranceNotes">
                            <div class="border border-gray-200 rounded-xl bg-gray-50 p-4 max-h-48 overflow-y-auto custom-scrollbar">
                                <div class="text-sm text-gray-700 leading-relaxed prose prose-sm max-w-none">
                                    <!-- Highlight Notes -->
                                    @if($product->highlightNotes && $product->highlightNotes->count() > 0)
                                    <div class="mb-4">
                                        <h4 class="font-bold text-gray-900 mb-3">Highlight Notes</h4>
                                        <div class="flex flex-wrap gap-2 not-prose">
                                            @foreach($product->highlightNotes as $note)
                                            <div class="flex items-center gap-2 px-3 py-1.5 bg-white rounded-full border border-gray-200 shadow-sm">
                                                @if($note->imagekit_thumbnail_url || $note->imagekit_url)
                                                    <img src="{{ $note->imagekit_thumbnail_url ?? $note->imagekit_url }}" alt="{{ $note->name }}" class="w-5 h-5 object-contain">
                                                @endif
                                                <span class="text-xs font-medium text-gray-700">{{ $note->name }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($product->fragrance_notes)
                                    <div>
                                        <h4 class="font-bold text-gray-900 mb-2">Fragrance Notes</h4>
                                        {!! $product->fragrance_notes !!}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($product->ingredients_details)
                        <div id="ingredientsDetailsProductContent" class="product-tab-content hidden" data-tab="ingredientsDetails">
                            <div class="border border-gray-200 rounded-xl bg-gray-50 p-4 max-h-48 overflow-y-auto custom-scrollbar">
                                <div class="text-sm text-gray-700 leading-relaxed prose prose-sm max-w-none">
                                    <h4 class="font-bold text-gray-900 mb-2">Ingredients</h4>
                                    {!! $product->ingredients_details !!}
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($product->shipping_info)
                        <div id="shippingReturnsProductContent" class="product-tab-content hidden" data-tab="shippingReturns">
                            <div class="border border-gray-200 rounded-xl bg-gray-50 p-4 max-h-48 overflow-y-auto custom-scrollbar">
                                <div class="text-sm text-gray-700 leading-relaxed prose prose-sm max-w-none">
                                    {!! $product->shipping_info !!}
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($product->why_love_it)
                        <div id="whyLoveProductContent" class="product-tab-content hidden" data-tab="whyLove">
                            <div class="border border-gray-200 rounded-xl bg-gray-50 p-4 max-h-48 overflow-y-auto custom-scrollbar">
                                <div class="text-sm text-gray-700 leading-relaxed prose prose-sm max-w-none">
                                    {!! $product->why_love_it !!}
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($product->what_makes_clean)
                        <div id="whatCleanProductContent" class="product-tab-content hidden" data-tab="whatClean">
                            <div class="border border-gray-200 rounded-xl bg-gray-50 p-4 max-h-48 overflow-y-auto custom-scrollbar">
                                <div class="text-sm text-gray-700 leading-relaxed prose prose-sm max-w-none">
                                    {!! $product->what_makes_clean !!}
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($product->disclaimer)
                        <div id="disclaimerProductContent" class="product-tab-content hidden" data-tab="disclaimer">
                            <div class="border border-gray-200 rounded-xl bg-gray-50 p-4 max-h-48 overflow-y-auto custom-scrollbar">
                                <div class="text-sm text-gray-700 leading-relaxed prose prose-sm max-w-none">
                                    {!! $product->disclaimer !!}
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($product->ask_question)
                        <div id="askQuestionProductContent" class="product-tab-content hidden" data-tab="askQuestion">
                            <div class="border border-gray-200 rounded-xl bg-gray-50 p-4 max-h-48 overflow-y-auto custom-scrollbar">
                                <div class="text-sm text-gray-700 leading-relaxed prose prose-sm max-w-none">
                                    {!! $product->ask_question !!}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-6">You May Also Like</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($relatedProducts as $related)
            <a href="{{ route('product.show', $related->slug) }}" class="group">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">
                    <div class="aspect-square bg-[#f5f5f0] relative overflow-hidden">
                        <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-3">
                        <h3 class="font-bold text-sm uppercase truncate">{{ $related->name }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            @if($related->sale_price && $related->sale_price < $related->price)
                            <span class="text-[#e8a598] font-bold">₹{{ number_format($related->sale_price, 2) }}</span>
                            <span class="text-gray-400 text-sm line-through">₹{{ number_format($related->price, 2) }}</span>
                            @else
                            <span class="text-[#e8a598] font-bold">₹{{ number_format($related->price, 2) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Reviews Section - Flipkart Style -->
<section class="py-12 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-sm">
            <!-- Header with Rating Summary -->
            <div class="border-b border-gray-200 p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Ratings & Reviews</h2>
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-3">
                                <div class="text-4xl font-bold text-gray-900" id="averageRating">0.0</div>
                                <div>
                                    <div class="flex items-center gap-1 mb-1" id="averageStars">
                                        <span class="text-gray-300 text-lg">★★★★★</span>
                                    </div>
                                    <p class="text-sm text-gray-600"><span id="totalReviews">0</span> Ratings</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button onclick="toggleReviewForm()" class="bg-white border-2 border-gray-300 hover:border-[#e8a598] text-gray-700 font-medium px-6 py-2 rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Rate Product
                    </button>
                </div>

                <!-- Rating Breakdown -->
                <div class="mt-6 max-w-md">
                    <div class="space-y-2">
                        <div class="flex items-center gap-3" data-rating="5">
                            <button onclick="filterByRating(5)" class="text-sm text-gray-700 hover:text-[#e8a598] transition w-8">5 ★</button>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-green-500 transition-all duration-300" style="width: 0%" id="rating5Bar"></div>
                            </div>
                            <span class="text-sm text-gray-600 w-12 text-right" id="rating5Count">0</span>
                        </div>
                        <div class="flex items-center gap-3" data-rating="4">
                            <button onclick="filterByRating(4)" class="text-sm text-gray-700 hover:text-[#e8a598] transition w-8">4 ★</button>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-green-400 transition-all duration-300" style="width: 0%" id="rating4Bar"></div>
                            </div>
                            <span class="text-sm text-gray-600 w-12 text-right" id="rating4Count">0</span>
                        </div>
                        <div class="flex items-center gap-3" data-rating="3">
                            <button onclick="filterByRating(3)" class="text-sm text-gray-700 hover:text-[#e8a598] transition w-8">3 ★</button>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-400 transition-all duration-300" style="width: 0%" id="rating3Bar"></div>
                            </div>
                            <span class="text-sm text-gray-600 w-12 text-right" id="rating3Count">0</span>
                        </div>
                        <div class="flex items-center gap-3" data-rating="2">
                            <button onclick="filterByRating(2)" class="text-sm text-gray-700 hover:text-[#e8a598] transition w-8">2 ★</button>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-orange-400 transition-all duration-300" style="width: 0%" id="rating2Bar"></div>
                            </div>
                            <span class="text-sm text-gray-600 w-12 text-right" id="rating2Count">0</span>
                        </div>
                        <div class="flex items-center gap-3" data-rating="1">
                            <button onclick="filterByRating(1)" class="text-sm text-gray-700 hover:text-[#e8a598] transition w-8">1 ★</button>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-red-500 transition-all duration-300" style="width: 0%" id="rating1Bar"></div>
                            </div>
                            <span class="text-sm text-gray-600 w-12 text-right" id="rating1Count">0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Write Review Form (Collapsible) -->
            <div id="reviewFormSection" class="hidden border-b border-gray-200 bg-gray-50">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Rate this product</h3>
                    
                    <form id="reviewForm" onsubmit="submitReview(event)">
                        <!-- Star Rating -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Your Rating *</label>
                            <div class="flex items-center gap-2" id="starRating">
                                <button type="button" onclick="setRating(1)" class="star-btn text-3xl text-gray-300 hover:text-[#e8a598] transition">★</button>
                                <button type="button" onclick="setRating(2)" class="star-btn text-3xl text-gray-300 hover:text-[#e8a598] transition">★</button>
                                <button type="button" onclick="setRating(3)" class="star-btn text-3xl text-gray-300 hover:text-[#e8a598] transition">★</button>
                                <button type="button" onclick="setRating(4)" class="star-btn text-3xl text-gray-300 hover:text-[#e8a598] transition">★</button>
                                <button type="button" onclick="setRating(5)" class="star-btn text-3xl text-gray-300 hover:text-[#e8a598] transition">★</button>
                                <span id="ratingText" class="text-sm text-gray-600 ml-2"></span>
                            </div>
                            <input type="hidden" id="ratingInput" name="rating" required>
                            <p class="text-red-500 text-xs mt-1 hidden" id="ratingError">Please select a rating</p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <!-- Name -->
                            <div id="nameField">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                                <input type="text" id="reviewName" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#e8a598] focus:border-transparent" placeholder="Enter your name">
                                <p class="text-red-500 text-xs mt-1 hidden" id="nameError">Name is required</p>
                            </div>

                            <!-- Email -->
                            <div id="emailField">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" id="reviewEmail" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#e8a598] focus:border-transparent" placeholder="Enter your email">
                                <p class="text-red-500 text-xs mt-1 hidden" id="emailError">Valid email is required</p>
                            </div>
                        </div>

                        <!-- Review Title -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Review Title</label>
                            <input type="text" id="reviewTitle" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#e8a598] focus:border-transparent" placeholder="Sum up your experience" maxlength="255">
                        </div>

                        <!-- Review Comment -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Your Review *</label>
                            <textarea id="reviewComment" name="comment" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#e8a598] focus:border-transparent resize-none" placeholder="Share your thoughts about this product (minimum 10 characters)" minlength="10" maxlength="1000" required></textarea>
                            <div class="flex items-center justify-between mt-1">
                                <p class="text-red-500 text-xs hidden" id="commentError">Review must be at least 10 characters</p>
                                <p class="text-gray-500 text-xs"><span id="charCount">0</span>/1000</p>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Add Photos (Optional)</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-[#e8a598] transition cursor-pointer" id="imageUploadArea" onclick="document.getElementById('imageInput').click()">
                                <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm text-gray-600">Click to upload images (Max 5, 2MB each)</p>
                            </div>
                            <input type="file" id="imageInput" accept="image/jpeg,image/jpg,image/png,image/webp" multiple class="hidden" onchange="handleImageSelect(event)">
                            
                            <!-- Image Preview Grid -->
                            <div id="imagePreviewGrid" class="grid grid-cols-5 gap-2 mt-3 hidden"></div>
                            <p class="text-red-500 text-xs mt-1 hidden" id="imageError"></p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center gap-3">
                            <button type="submit" id="submitReviewBtn" class="bg-[#e8a598] hover:bg-[#d4948a] text-white font-bold px-6 py-2 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                Submit Review
                            </button>
                            <button type="button" onclick="toggleReviewForm()" class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                                Cancel
                            </button>
                        </div>

                        <!-- Success/Error Message -->
                        <div id="reviewFormMessage" class="mt-4 p-3 rounded-lg hidden"></div>
                    </form>
                </div>
            </div>

            <!-- Filter & Sort -->
            <div class="border-b border-gray-200 p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <select id="ratingFilter" onchange="applyFilters()" class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#e8a598]">
                        <option value="">All Ratings</option>
                        <option value="5">5 ★</option>
                        <option value="4">4 ★</option>
                        <option value="3">3 ★</option>
                        <option value="2">2 ★</option>
                        <option value="1">1 ★</option>
                    </select>

                    <select id="sortReviews" onchange="applyFilters()" class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#e8a598]">
                        <option value="recent">Most Recent</option>
                        <option value="helpful">Most Helpful</option>
                        <option value="highest">Highest Rating</option>
                        <option value="lowest">Lowest Rating</option>
                    </select>
                </div>
            </div>

            <!-- Reviews List -->
            <div id="reviewsList" class="divide-y divide-gray-200">
                <!-- Reviews will be loaded here via JavaScript -->
                <div class="text-center py-12">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-[#e8a598]"></div>
                    <p class="text-gray-600 mt-4">Loading reviews...</p>
                </div>
            </div>

            <!-- Load More Button -->
            <div id="loadMoreContainer" class="text-center p-6 hidden">
                <button onclick="loadMoreReviews()" id="loadMoreBtn" class="text-[#e8a598] hover:text-[#d4948a] font-medium text-sm">
                    View More Reviews ▼
                </button>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Product Images Array
    var productImages = @json($product->images_array ?? []);
    var currentProductImageIndex = 0;
    var activeTab = 'notesIngredients'; // Default open tab
    var tabSlidePosition = 0;

    function changeMainImage(imageUrl, btn) {
        const mainImage = document.getElementById('mainProductImage');
        if (mainImage) {
            mainImage.style.opacity = '0';
            setTimeout(() => {
                mainImage.src = imageUrl;
                mainImage.style.opacity = '1';
            }, 150);
        }
        
        // Update thumbnail borders
        if (btn) {
            document.querySelectorAll('.thumbnail-btn').forEach(b => {
                b.classList.remove('border-black');
                b.classList.add('border-gray-300');
            });
            btn.classList.remove('border-gray-300');
            btn.classList.add('border-black');
        }
        
        // Update current index
        currentProductImageIndex = productImages.indexOf(imageUrl);
        if (currentProductImageIndex === -1) currentProductImageIndex = 0;
    }

    function nextProductImage() {
        if (productImages.length > 0) {
            currentProductImageIndex = (currentProductImageIndex + 1) % productImages.length;
            const thumbnails = document.querySelectorAll('.thumbnail-btn');
            changeMainImage(productImages[currentProductImageIndex], thumbnails[currentProductImageIndex]);
        }
    }

    function previousProductImage() {
        if (productImages.length > 0) {
            currentProductImageIndex = (currentProductImageIndex - 1 + productImages.length) % productImages.length;
            const thumbnails = document.querySelectorAll('.thumbnail-btn');
            changeMainImage(productImages[currentProductImageIndex], thumbnails[currentProductImageIndex]);
        }
    }

    // Tab Slider Navigation
    function slideTabsLeft() {
        const slider = document.getElementById('tabSlider');
        if (!slider) return;
        
        tabSlidePosition += 200;
        if (tabSlidePosition > 0) tabSlidePosition = 0;
        
        slider.style.transform = 'translateX(' + tabSlidePosition + 'px)';
        updateSliderArrows();
    }

    function slideTabsRight() {
        const slider = document.getElementById('tabSlider');
        if (!slider) return;
        
        const containerWidth = slider.parentElement.offsetWidth;
        const sliderWidth = slider.scrollWidth;
        const maxSlide = -(sliderWidth - containerWidth);
        
        tabSlidePosition -= 200;
        if (tabSlidePosition < maxSlide) tabSlidePosition = maxSlide;
        
        slider.style.transform = 'translateX(' + tabSlidePosition + 'px)';
        updateSliderArrows();
    }

    function updateSliderArrows() {
        const slider = document.getElementById('tabSlider');
        const leftBtn = document.getElementById('tabSlideLeft');
        const rightBtn = document.getElementById('tabSlideRight');
        
        if (!slider || !leftBtn || !rightBtn) return;
        
        const containerWidth = slider.parentElement.offsetWidth;
        const sliderWidth = slider.scrollWidth;
        const maxSlide = -(sliderWidth - containerWidth);
        
        // Show/hide left arrow
        if (tabSlidePosition < 0) {
            leftBtn.classList.remove('hidden');
        } else {
            leftBtn.classList.add('hidden');
        }
        
        // Show/hide right arrow
        if (sliderWidth > containerWidth && tabSlidePosition > maxSlide) {
            rightBtn.classList.remove('hidden');
        } else {
            rightBtn.classList.add('hidden');
        }
    }

    // Toggle Product Tab (Accordion Style)
    function toggleProductTab(tabName) {
        const content = document.getElementById(tabName + 'ProductContent');
        const btn = document.getElementById(tabName + 'ProductTab');
        
        if (!content || !btn) return;
        
        // If clicking same tab, close it
        if (activeTab === tabName) {
            content.classList.add('hidden');
            btn.classList.remove('tab-active');
            const arrow = btn.querySelector('.tab-arrow');
            if (arrow) arrow.style.transform = '';
            activeTab = null;
            return;
        }
        
        // Close all tabs
        document.querySelectorAll('.product-tab-content').forEach(c => {
            c.classList.add('hidden');
        });
        
        // Reset all buttons
        document.querySelectorAll('.product-tab').forEach(b => {
            b.classList.remove('tab-active');
            const arrow = b.querySelector('.tab-arrow');
            if (arrow) arrow.style.transform = '';
        });
        
        // Open selected tab
        content.classList.remove('hidden');
        btn.classList.add('tab-active');
        const arrow = btn.querySelector('.tab-arrow');
        if (arrow) arrow.style.transform = 'rotate(180deg)';
        activeTab = tabName;
    }

    // Initialize slider arrows on load
    document.addEventListener('DOMContentLoaded', function() {
        updateSliderArrows();
        window.addEventListener('resize', updateSliderArrows);
    });

    // Shipping Countdown
    function updateCountdown() {
        const now = new Date();
        const midnight = new Date();
        midnight.setHours(24, 0, 0, 0);
        
        const diff = midnight - now;
        
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        const el = document.getElementById('shippingCountdown');
        if (el) {
            el.textContent = hours + 'h ' + minutes + 'm ' + seconds + 's';
        }
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000);

    // Scent Intensity Modal Functions
    function openScentIntensityModal() {
        document.getElementById('scentIntensityModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeScentIntensityModal() {
        document.getElementById('scentIntensityModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal on outside click
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('scentIntensityModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeScentIntensityModal();
                }
            });
        }

        // Initialize reviews on page load
        loadReviewStats();
        loadReviews();
    });

    // ============================================
    // PRODUCT REVIEWS JAVASCRIPT
    // ============================================
    
    const productId = {{ $product->id }};
    let currentPage = 1;
    let currentRatingFilter = '';
    let currentSort = 'recent';
    let selectedRating = 0;
    let uploadedImages = [];

    // Load Review Statistics
    function loadReviewStats() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/api/products/' + productId + '/reviews/stats', true);
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    updateReviewStats(response.stats);
                }
            }
        };
        
        xhr.send();
    }

    // Update Review Statistics UI
    function updateReviewStats(stats) {
        document.getElementById('averageRating').textContent = stats.average_rating.toFixed(1);
        document.getElementById('totalReviews').textContent = stats.total_reviews;
        
        // Update stars
        const starsHtml = generateStars(stats.average_rating);
        document.getElementById('averageStars').innerHTML = starsHtml;
        
        // Update rating breakdown
        for (let i = 1; i <= 5; i++) {
            const data = stats.rating_breakdown[i];
            document.getElementById('rating' + i + 'Bar').style.width = data.percentage + '%';
            document.getElementById('rating' + i + 'Count').textContent = data.count;
        }
    }

    // Generate Star HTML
    function generateStars(rating) {
        let html = '';
        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 >= 0.5;
        
        for (let i = 0; i < 5; i++) {
            if (i < fullStars) {
                html += '<span class="text-[#e8a598] text-2xl">★</span>';
            } else if (i === fullStars && hasHalfStar) {
                html += '<span class="text-[#e8a598] text-2xl">★</span>';
            } else {
                html += '<span class="text-gray-300 text-2xl">★</span>';
            }
        }
        
        return html;
    }

    // Load Reviews
    function loadReviews(page = 1) {
        const xhr = new XMLHttpRequest();
        let url = '/api/products/' + productId + '/reviews?page=' + page + '&sort=' + currentSort;
        
        if (currentRatingFilter) {
            url += '&rating=' + currentRatingFilter;
        }
        
        xhr.open('GET', url, true);
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    displayReviews(response.reviews, page === 1);
                    updatePagination(response.pagination);
                }
            }
        };
        
        xhr.send();
    }

    // Display Reviews
    function displayReviews(reviews, clearFirst = true) {
        const container = document.getElementById('reviewsList');
        
        if (clearFirst) {
            container.innerHTML = '';
        }
        
        if (reviews.length === 0 && clearFirst) {
            container.innerHTML = `
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    <p class="text-gray-600 text-lg font-medium">No reviews yet</p>
                    <p class="text-gray-500 text-sm mt-2">Be the first to review this product!</p>
                </div>
            `;
            return;
        }
        
        reviews.forEach(review => {
            container.appendChild(createReviewCard(review));
        });
    }

    // Create Review Card Element (Flipkart Style)
    function createReviewCard(review) {
        const card = document.createElement('div');
        card.className = 'p-6';
        
        const reviewerName = review.user ? review.user.name : review.name;
        const reviewerAvatar = review.user && review.user.avatar ? review.user.avatar : 
            'https://ui-avatars.com/api/?name=' + encodeURIComponent(reviewerName.charAt(0)) + '&background=e8a598&color=fff&size=128';
        
        const date = new Date(review.created_at);
        const formattedDate = date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        
        let imagesHtml = '';
        if (review.images && review.images.length > 0) {
            imagesHtml = '<div class="flex gap-2 mt-3">';
            review.images.forEach((img, index) => {
                imagesHtml += `
                    <img src="${img}" alt="Review image ${index + 1}" 
                         class="w-16 h-16 object-cover rounded border border-gray-200 cursor-pointer hover:opacity-75 transition"
                         onclick="openImageLightbox(${JSON.stringify(review.images)}, ${index})">
                `;
            });
            imagesHtml += '</div>';
        }
        
        card.innerHTML = `
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-[#e8a598] text-white flex items-center justify-center font-bold text-lg">
                        ${reviewerName.charAt(0).toUpperCase()}
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <h4 class="font-medium text-gray-900">${reviewerName}</h4>
                        ${review.is_verified_purchase ? '<span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded">✓ Verified Purchase</span>' : ''}
                    </div>
                    
                    <div class="flex items-center gap-3 mb-2">
                        <div class="flex items-center gap-1 px-2 py-0.5 bg-green-600 text-white rounded text-xs font-medium">
                            <span>${review.rating}</span>
                            <span>★</span>
                        </div>
                        <span class="text-sm text-gray-500">${formattedDate}</span>
                    </div>
                    
                    ${review.title ? `<h5 class="font-medium text-gray-900 mb-2">${review.title}</h5>` : ''}
                    
                    <p class="text-gray-700 text-sm leading-relaxed">${review.comment}</p>
                    
                    ${imagesHtml}
                    
                    <div class="flex items-center gap-4 mt-3 pt-3 border-t border-gray-100">
                        <button onclick="markReviewHelpful(${review.id})" 
                                class="flex items-center gap-1.5 text-sm ${review.user_marked_helpful ? 'text-[#e8a598] font-medium' : 'text-gray-600'} hover:text-[#e8a598] transition"
                                id="helpfulBtn${review.id}">
                            <svg class="w-4 h-4" fill="${review.user_marked_helpful ? 'currentColor' : 'none'}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                            </svg>
                            <span id="helpfulCount${review.id}">Helpful (${review.helpful_count})</span>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        return card;
    }

    // Update Pagination
    function updatePagination(pagination) {
        const container = document.getElementById('loadMoreContainer');
        const btn = document.getElementById('loadMoreBtn');
        
        if (pagination.current_page < pagination.last_page) {
            container.classList.remove('hidden');
            currentPage = pagination.current_page;
        } else {
            container.classList.add('hidden');
        }
    }

    // Load More Reviews
    function loadMoreReviews() {
        loadReviews(currentPage + 1);
    }

    // Apply Filters
    function applyFilters() {
        currentRatingFilter = document.getElementById('ratingFilter').value;
        currentSort = document.getElementById('sortReviews').value;
        currentPage = 1;
        loadReviews(1);
    }

    // Filter by Rating (from breakdown bars)
    function filterByRating(rating) {
        document.getElementById('ratingFilter').value = rating;
        applyFilters();
    }

    // Mark Review as Helpful
    function markReviewHelpful(reviewId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/reviews/' + reviewId + '/helpful', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Update UI
                    const btn = document.getElementById('helpfulBtn' + reviewId);
                    const countSpan = document.getElementById('helpfulCount' + reviewId);
                    const svg = btn.querySelector('svg');
                    
                    if (response.marked) {
                        btn.classList.add('text-[#e8a598]');
                        svg.setAttribute('fill', 'currentColor');
                    } else {
                        btn.classList.remove('text-[#e8a598]');
                        svg.setAttribute('fill', 'none');
                    }
                    
                    countSpan.textContent = 'Helpful (' + response.helpful_count + ')';
                }
            }
        };
        
        xhr.send();
    }

    // Toggle Review Form (Flipkart style - inline)
    function toggleReviewForm() {
        const formSection = document.getElementById('reviewFormSection');
        if (formSection.classList.contains('hidden')) {
            formSection.classList.remove('hidden');
            resetReviewForm();
            // Scroll to form
            formSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            formSection.classList.add('hidden');
        }
    }

    // Reset Review Form
    function resetReviewForm() {
        document.getElementById('reviewForm').reset();
        selectedRating = 0;
        uploadedImages = [];
        updateStarRating(0);
        document.getElementById('ratingInput').value = '';
        document.getElementById('imagePreviewGrid').innerHTML = '';
        document.getElementById('imagePreviewGrid').classList.add('hidden');
        document.getElementById('charCount').textContent = '0';
        hideAllErrors();
    }

    // Set Rating
    function setRating(rating) {
        selectedRating = rating;
        document.getElementById('ratingInput').value = rating;
        updateStarRating(rating);
        document.getElementById('ratingError').classList.add('hidden');
        
        const ratingTexts = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
        document.getElementById('ratingText').textContent = ratingTexts[rating];
    }

    // Update Star Rating Visual
    function updateStarRating(rating) {
        const stars = document.querySelectorAll('#starRating .star-btn');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-[#e8a598]');
            } else {
                star.classList.add('text-gray-300');
                star.classList.remove('text-[#e8a598]');
            }
        });
    }

    // Character Count
    document.addEventListener('DOMContentLoaded', function() {
        const commentField = document.getElementById('reviewComment');
        if (commentField) {
            commentField.addEventListener('input', function() {
                document.getElementById('charCount').textContent = this.value.length;
            });
        }
    });

    // Handle Image Select
    function handleImageSelect(event) {
        const files = Array.from(event.target.files);
        
        if (uploadedImages.length + files.length > 5) {
            showImageError('Maximum 5 images allowed');
            return;
        }
        
        files.forEach(file => {
            // Validate file
            if (!file.type.match('image/(jpeg|jpg|png|webp)')) {
                showImageError('Only JPG, PNG, and WEBP images are allowed');
                return;
            }
            
            if (file.size > 2 * 1024 * 1024) {
                showImageError('Image size must be less than 2MB');
                return;
            }
            
            // Upload image
            uploadReviewImage(file);
        });
        
        // Reset input
        event.target.value = '';
    }

    // Upload Review Image
    function uploadReviewImage(file) {
        const formData = new FormData();
        formData.append('image', file);
        
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/reviews/upload-image', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    uploadedImages.push(response.url);
                    addImagePreview(response.url, uploadedImages.length - 1);
                    document.getElementById('imageError').classList.add('hidden');
                } else {
                    showImageError('Failed to upload image');
                }
            } else {
                showImageError('Failed to upload image');
            }
        };
        
        xhr.onerror = function() {
            showImageError('Network error while uploading image');
        };
        
        xhr.send(formData);
    }

    // Add Image Preview
    function addImagePreview(url, index) {
        const grid = document.getElementById('imagePreviewGrid');
        grid.classList.remove('hidden');
        
        const preview = document.createElement('div');
        preview.className = 'relative group';
        preview.innerHTML = `
            <img src="${url}" class="w-full aspect-square object-cover rounded-lg">
            <button type="button" onclick="removeImage(${index})" 
                    class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;
        
        grid.appendChild(preview);
    }

    // Remove Image
    function removeImage(index) {
        uploadedImages.splice(index, 1);
        
        const grid = document.getElementById('imagePreviewGrid');
        grid.innerHTML = '';
        
        if (uploadedImages.length === 0) {
            grid.classList.add('hidden');
        } else {
            uploadedImages.forEach((url, i) => {
                addImagePreview(url, i);
            });
        }
    }

    // Show Image Error
    function showImageError(message) {
        const errorEl = document.getElementById('imageError');
        errorEl.textContent = message;
        errorEl.classList.remove('hidden');
        
        setTimeout(() => {
            errorEl.classList.add('hidden');
        }, 5000);
    }

    // Submit Review
    function submitReview(event) {
        event.preventDefault();
        
        // Validate
        if (!validateReviewForm()) {
            return;
        }
        
        const submitBtn = document.getElementById('submitReviewBtn');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';
        
        const formData = {
            rating: selectedRating,
            title: document.getElementById('reviewTitle').value,
            comment: document.getElementById('reviewComment').value,
            name: document.getElementById('reviewName').value,
            email: document.getElementById('reviewEmail').value,
            images: uploadedImages
        };
        
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/api/products/' + productId + '/reviews', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        
        xhr.onload = function() {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Submit Review';
            
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    showFormMessage('Thank you for your review!', 'success');
                    setTimeout(() => {
                        toggleReviewForm(); // Hide form
                        loadReviewStats();
                        loadReviews(1);
                    }, 2000);
                } else {
                    showFormMessage(response.message || 'Failed to submit review', 'error');
                }
            } else {
                const response = JSON.parse(xhr.responseText);
                showFormMessage(response.message || 'Failed to submit review', 'error');
            }
        };
        
        xhr.onerror = function() {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Submit Review';
            showFormMessage('Network error. Please try again.', 'error');
        };
        
        xhr.send(JSON.stringify(formData));
    }

    // Validate Review Form
    function validateReviewForm() {
        let isValid = true;
        hideAllErrors();
        
        // Rating
        if (!selectedRating || selectedRating < 1) {
            document.getElementById('ratingError').classList.remove('hidden');
            isValid = false;
        }
        
        // Name (for guests)
        const nameField = document.getElementById('reviewName');
        if (nameField && !nameField.value.trim()) {
            document.getElementById('nameError').classList.remove('hidden');
            isValid = false;
        }
        
        // Email (for guests)
        const emailField = document.getElementById('reviewEmail');
        if (emailField && !emailField.value.trim()) {
            document.getElementById('emailError').classList.remove('hidden');
            isValid = false;
        }
        
        // Comment
        const comment = document.getElementById('reviewComment').value.trim();
        if (comment.length < 10) {
            document.getElementById('commentError').classList.remove('hidden');
            isValid = false;
        }
        
        return isValid;
    }

    // Hide All Errors
    function hideAllErrors() {
        document.querySelectorAll('.text-red-500').forEach(el => {
            el.classList.add('hidden');
        });
    }

    // Show Form Message
    function showFormMessage(message, type) {
        const messageEl = document.getElementById('reviewFormMessage');
        messageEl.textContent = message;
        messageEl.className = 'mt-4 p-4 rounded-lg ' + (type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700');
        messageEl.classList.remove('hidden');
        
        setTimeout(() => {
            messageEl.classList.add('hidden');
        }, 5000);
    }

    // Image Lightbox
    let lightboxImages = [];
    let lightboxIndex = 0;

    function openImageLightbox(images, index) {
        lightboxImages = images;
        lightboxIndex = index;
        
        const lightbox = document.createElement('div');
        lightbox.id = 'imageLightbox';
        lightbox.className = 'fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4';
        lightbox.onclick = function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        };
        
        lightbox.innerHTML = `
            <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            ${images.length > 1 ? `
                <button onclick="previousLightboxImage()" class="absolute left-4 text-white hover:text-gray-300 transition">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                
                <button onclick="nextLightboxImage()" class="absolute right-4 text-white hover:text-gray-300 transition">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            ` : ''}
            
            <img id="lightboxImage" src="${images[index]}" class="max-w-full max-h-full object-contain">
            
            ${images.length > 1 ? `
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white text-sm">
                    <span id="lightboxCounter">${index + 1} / ${images.length}</span>
                </div>
            ` : ''}
        `;
        
        document.body.appendChild(lightbox);
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const lightbox = document.getElementById('imageLightbox');
        if (lightbox) {
            lightbox.remove();
            document.body.style.overflow = 'auto';
        }
    }

    function previousLightboxImage() {
        lightboxIndex = (lightboxIndex - 1 + lightboxImages.length) % lightboxImages.length;
        updateLightboxImage();
    }

    function nextLightboxImage() {
        lightboxIndex = (lightboxIndex + 1) % lightboxImages.length;
        updateLightboxImage();
    }

    function updateLightboxImage() {
        document.getElementById('lightboxImage').src = lightboxImages[lightboxIndex];
        const counter = document.getElementById('lightboxCounter');
        if (counter) {
            counter.textContent = (lightboxIndex + 1) + ' / ' + lightboxImages.length;
        }
    }


</script>

<!-- Scent Intensity Modal -->
<div id="scentIntensityModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-gradient-to-br from-blue-100 to-blue-200 rounded-3xl max-w-4xl w-full max-h-[90vh] overflow-y-auto relative">
        <!-- Close Button -->
        <button onclick="closeScentIntensityModal()" class="absolute top-4 right-4 text-gray-700 hover:text-gray-900 text-2xl font-bold z-10">
            Close
        </button>

        <div class="p-8 md:p-12">
            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-3">
                    What is the <span class="text-gray-800">scent<br>intensity scale?</span>
                </h2>
                <div class="flex items-center gap-2">
                    <span class="w-4 h-4 rounded-full bg-orange-300"></span>
                    <span class="w-4 h-4 rounded-full bg-orange-400"></span>
                    <span class="w-4 h-4 rounded-full bg-orange-500"></span>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8 items-center">
                <!-- Left: Image -->
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?w=400&h=400&fit=crop" 
                         alt="Perfume Bottles" 
                         class="w-full rounded-2xl shadow-lg">
                </div>

                <!-- Right: Content -->
                <div class="space-y-6">
                    <!-- Description -->
                    <div class="bg-white rounded-2xl p-6 shadow-md">
                        <p class="text-gray-700 leading-relaxed">
                            The <span class="font-bold">scent intensity scale</span> was created by our Nose to rank the 
                            <span class="text-orange-500 font-semibold">intensity</span> of each fragrance based on both the 
                            <span class="font-semibold">projection</span> (i.e. how faint or strong the scent is) and 
                            <span class="font-semibold">longevity</span> (i.e. how long the scent is detectable on the skin).
                        </p>
                    </div>

                    <!-- Soft -->
                    <div class="bg-white rounded-2xl p-6 shadow-md">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="flex items-center gap-1">
                                <span class="w-3 h-3 rounded-full bg-orange-300"></span>
                                <span class="w-3 h-3 rounded-full bg-gray-200"></span>
                                <span class="w-3 h-3 rounded-full bg-gray-200"></span>
                            </div>
                            <h3 class="text-xl font-bold text-orange-400">Soft:</h3>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Delicate, lighter scents that will entice your senses, without overpowering them.
                        </p>
                    </div>

                    <!-- Significant -->
                    <div class="bg-white rounded-2xl p-6 shadow-md">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="flex items-center gap-1">
                                <span class="w-3 h-3 rounded-full bg-orange-400"></span>
                                <span class="w-3 h-3 rounded-full bg-orange-400"></span>
                                <span class="w-3 h-3 rounded-full bg-gray-200"></span>
                            </div>
                            <h3 class="text-xl font-bold text-orange-500">Significant:</h3>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Captivating scents that stay present on the skin, but won't overwhelm the room.
                        </p>
                    </div>

                    <!-- Statement -->
                    <div class="bg-white rounded-2xl p-6 shadow-md">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="flex items-center gap-1">
                                <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                                <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                                <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                            </div>
                            <h3 class="text-xl font-bold text-orange-600">Statement:</h3>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Bold, head-turning fragrances. Stand out from the crowd with every spritz.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</script>

<style>
    /* Active tab style */
    .product-tab.tab-active {
        background-color: #f3f4f6;
        border-color: #9ca3af;
    }
    
    /* Custom scrollbar for content box */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #e5e7eb;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #9ca3af;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #6b7280;
    }
</style>
@endpush
