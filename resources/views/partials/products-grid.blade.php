@if($products->count() > 0)
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 lg:gap-6">
    @foreach($products as $product)
    @include('partials.product-card', ['product' => $product])
    @endforeach
</div>

@if($products->hasPages())
<div class="mt-12 flex justify-center">
    {{ $products->links() }}
</div>
@endif

@else
<div class="text-center py-20">
    <div class="w-24 h-24 mx-auto mb-6 bg-[#F4ECDD] rounded-full flex items-center justify-center">
        <svg class="w-12 h-12 text-[#F27F6E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-2">No Products Found</h3>
    <p class="text-gray-500 mb-6">No products match your filters. Try adjusting your selection.</p>
    <button onclick="clearAllFilters()" class="inline-flex items-center px-8 py-3 bg-[#F27F6E] text-white rounded-full font-medium hover:bg-[#e06b5a] transition-colors">
        Clear All Filters
    </button>
</div>
@endif
