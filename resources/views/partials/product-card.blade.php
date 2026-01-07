<!-- Product Card -->
<a href="{{ route('product.show', $product->slug) }}" class="group block bg-gradient-to-br from-gray-50 to-gray-100/80 rounded-2xl p-3 shadow-md hover:shadow-xl transition-all duration-300 border border-gray-200/60 hover:border-gray-300">
    <div class="relative mb-3">
        <!-- Badges -->
        @if($product->genders->count() > 0)
        <span class="absolute top-2 left-2 z-10 border-2 border-red-400 text-red-400 text-[10px] sm:text-xs font-medium px-2 sm:px-3 py-1 rounded-full bg-white/90">
            {{ $product->genders->first()->name }}
        </span>
        @endif
        @if($product->is_bestseller)
        <span class="absolute top-2 right-2 z-10 bg-[#d4c4b0] text-gray-800 text-[10px] sm:text-xs font-medium px-2 sm:px-3 py-1 rounded-lg">
            Bestseller
        </span>
        @elseif($product->is_new)
        <span class="absolute top-2 right-2 z-10 bg-green-500 text-white text-[10px] sm:text-xs font-medium px-2 sm:px-3 py-1 rounded-lg">
            New
        </span>
        @elseif($product->is_trending)
        <span class="absolute top-2 right-2 z-10 bg-orange-500 text-white text-[10px] sm:text-xs font-medium px-2 sm:px-3 py-1 rounded-lg">
            Trending
        </span>
        @endif

        <!-- Product Image -->
        <div class="aspect-square rounded-xl overflow-hidden bg-gradient-to-br from-[#faf8f5] to-[#f0ebe3] relative shadow-sm"
             x-data="{ currentImage: 0, images: {{ json_encode($product->images_array ?? []) }} }"
             @mouseenter="if(images.length > 1) currentImage = 1"
             @mouseleave="currentImage = 0">
            @if($product->images_array && count($product->images_array) > 0)
                @foreach($product->images_array as $index => $image)
                <img src="{{ $image }}" 
                     alt="{{ $product->name }}" 
                     class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500"
                     :class="currentImage === {{ $index }} ? 'opacity-100' : 'opacity-0'"
                     loading="lazy">
                @endforeach
            @elseif($product->image_url)
                <img src="{{ $product->image_url }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover"
                     loading="lazy">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-100 to-pink-100">
                    <span class="text-5xl">🌸</span>
                </div>
            @endif

            <!-- Add to Cart/Bundle Button -->
            <div class="absolute bottom-0 left-0 right-0 p-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                <button onclick="event.preventDefault(); {{ isset($buttonClass) && $buttonClass === 'add-to-bundle-btn' ? 'addToBundle' : 'addToCart' }}({{ $product->id }})" 
                        class="w-full py-2 bg-white/95 border border-[#e8a598] text-[#e8a598] rounded-lg font-medium text-xs hover:bg-[#e8a598] hover:text-white transition-colors duration-200 {{ $buttonClass ?? '' }}">
                    {{ $buttonText ?? 'ADD TO CART' }}
                </button>
            </div>
        </div>
    </div>

    <!-- Rating -->
    <div class="flex items-center gap-1.5 mb-2">
        @php
            $avgRating = round($product->average_rating);
            $reviewCount = $product->reviews_count;
        @endphp
        <div class="flex text-sm">
            @for($i = 1; $i <= 5; $i++)
                <span class="{{ $i <= $avgRating ? 'text-black' : 'text-gray-300' }}">★</span>
            @endfor
        </div>
        @if($reviewCount > 0)
        <span class="text-xs text-gray-500 underline">({{ $reviewCount }})</span>
        @else
        <span class="text-xs text-gray-400">No reviews</span>
        @endif
    </div>

    <!-- Inspired By -->
    @if($product->inspired_by)
    <div class="mb-2">
        <p class="text-xs text-gray-500 italic">inspired by</p>
        <p class="text-sm text-[#e8a598] font-medium">{{ $product->inspired_by }}</p>
    </div>
    @endif

    <!-- Name & Price -->
    <div class="flex items-end justify-between gap-2">
        @php
            $nameParts = explode(' ', strtoupper($product->name), 2);
        @endphp
        <div>
            <h3 class="font-bold text-sm text-gray-900 leading-tight uppercase">{{ $nameParts[0] ?? '' }}</h3>
            <p class="font-bold text-sm text-gray-900 leading-tight uppercase">{{ $nameParts[1] ?? '' }}</p>
        </div>
        <div class="text-right flex-shrink-0">
            @if($product->sale_price && $product->sale_price < $product->price)
                @php
                    $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                @endphp
                <span class="inline-block bg-[#e8a598] text-white text-[10px] px-2 py-0.5 rounded mb-1">-{{ $discount }}%</span>
                <p class="text-[#e8a598] text-base font-bold italic">₹{{ number_format($product->sale_price, 0) }}</p>
                <p class="text-gray-400 text-xs line-through">₹{{ number_format($product->price, 0) }}</p>
            @else
                <p class="text-[#e8a598] text-base font-bold italic">₹{{ number_format($product->price, 0) }}</p>
            @endif
        </div>
    </div>
</a>
