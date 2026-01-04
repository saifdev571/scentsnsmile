@extends('admin.layouts.app')

@section('title', 'Product Details - ' . $product->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-indigo-50 p-6">
    
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.products') }}" class="flex items-center justify-center w-10 h-10 bg-white rounded-xl hover:bg-gray-100 transition-all">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">Product Details</h1>
                    <p class="mt-1 text-sm text-gray-600">View complete product information</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.products.edit.step1', $product) }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-bold rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Product
                </a>
                <button onclick="deleteProduct()" class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white text-sm font-bold rounded-xl hover:bg-red-700 shadow-lg hover:shadow-xl transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Images & Basic Info -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Product Image -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Product Image</h3>
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-80 object-cover rounded-xl">
                @else
                    <div class="w-full h-80 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-xl flex items-center justify-center">
                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Status Cards -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Status</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-semibold text-gray-700">Product Status</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-semibold text-gray-700">Stock Status</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $product->stock_status === 'in_stock' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ str_replace('_', ' ', ucfirst($product->stock_status)) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm font-semibold text-gray-700">Featured</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $product->is_featured ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $product->is_featured ? 'Yes' : 'No' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Details -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Basic Information -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Product Name</label>
                        <p class="text-base font-bold text-gray-900">{{ $product->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">SKU</label>
                        <p class="text-base font-mono text-gray-900">{{ $product->sku }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Category</label>
                        <p class="text-base text-gray-900">{{ $product->category->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Brand</label>
                        <p class="text-base text-gray-900">{{ $product->brand->name ?? 'N/A' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Short Description</label>
                        <p class="text-sm text-gray-700">{{ $product->short_description ?? 'N/A' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Description</label>
                        <div class="text-sm text-gray-700 prose max-w-none">
                            {!! $product->description ?? 'N/A' !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing & Stock -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Pricing & Stock</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-4 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border-2 border-green-200">
                        <label class="block text-sm font-semibold text-green-700 mb-2">Regular Price</label>
                        <p class="text-2xl font-black text-green-900">₹{{ number_format($product->price, 2) }}</p>
                    </div>
                    @if($product->sale_price)
                    <div class="p-4 bg-gradient-to-br from-red-50 to-pink-50 rounded-xl border-2 border-red-200">
                        <label class="block text-sm font-semibold text-red-700 mb-2">Sale Price</label>
                        <p class="text-2xl font-black text-red-900">₹{{ number_format($product->sale_price, 2) }}</p>
                    </div>
                    @endif
                    <div class="p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-200">
                        <label class="block text-sm font-semibold text-blue-700 mb-2">Stock Quantity</label>
                        <p class="text-2xl font-black text-blue-900">{{ $product->stock }}</p>
                    </div>
                </div>
            </div>

            <!-- Tags, Collections, Sizes, Genders -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Classifications</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tags -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-3">Tags</label>
                        <div class="flex flex-wrap gap-2">
                            @forelse($product->tagsList ?? [] as $tag)
                                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                    {{ $tag->name }}
                                </span>
                            @empty
                                <span class="text-sm text-gray-500">No tags</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- Collections -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-3">Collections</label>
                        <div class="flex flex-wrap gap-2">
                            @forelse($product->collectionsList ?? [] as $collection)
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-semibold">
                                    {{ $collection->name }}
                                </span>
                            @empty
                                <span class="text-sm text-gray-500">No collections</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- Sizes -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-3">Sizes</label>
                        <div class="flex flex-wrap gap-2">
                            @forelse($product->sizes ?? [] as $size)
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                    {{ $size->name }}
                                </span>
                            @empty
                                <span class="text-sm text-gray-500">No sizes</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- Genders -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-3">Genders</label>
                        <div class="flex flex-wrap gap-2">
                            @forelse($product->genders ?? [] as $gender)
                                <span class="px-3 py-1 bg-pink-100 text-pink-800 rounded-full text-xs font-semibold">
                                    {{ $gender->name }}
                                </span>
                            @empty
                                <span class="text-sm text-gray-500">No genders</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Gallery -->
            @if($product->gallery_images && is_array($product->gallery_images) && count($product->gallery_images) > 0)
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Product Gallery</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($product->gallery_images as $image)
                        <div class="relative group">
                            <img src="{{ $image }}" alt="Gallery Image" class="w-full h-32 object-cover rounded-lg">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all rounded-lg"></div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Product Variants -->
            @if($product->variants && $product->variants->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Product Variants</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">SKU</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Size</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Price</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Stock</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($product->variants as $variant)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-mono text-gray-900">{{ $variant->sku }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $variant->size->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">₹{{ number_format($variant->price, 2) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $variant->stock }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-bold {{ $variant->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $variant->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- SEO Information -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">SEO Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Meta Title</label>
                        <p class="text-sm text-gray-900">{{ $product->meta_title ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Meta Description</label>
                        <p class="text-sm text-gray-700">{{ $product->meta_description ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Focus Keywords</label>
                        <p class="text-sm text-gray-700">{{ $product->focus_keywords ?? 'N/A' }}</p>
                    </div>
                    @if($product->canonical_url)
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Canonical URL</label>
                        <a href="{{ $product->canonical_url }}" target="_blank" class="text-sm text-blue-600 hover:underline">{{ $product->canonical_url }}</a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Tab Content -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg flex items-center justify-center shadow-lg">
                        <span class="text-white text-lg">📋</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Product Tab Content</h3>
                </div>
                <div class="space-y-6">
                    @if($product->about_scent)
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">About This Scent</label>
                        <div class="text-sm text-gray-700 prose max-w-none bg-gray-50 p-4 rounded-lg">{!! $product->about_scent !!}</div>
                    </div>
                    @endif

                    @if($product->fragrance_notes)
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Fragrance Notes</label>
                        <div class="text-sm text-gray-700 prose max-w-none bg-gray-50 p-4 rounded-lg">{!! $product->fragrance_notes !!}</div>
                    </div>
                    @endif

                    @if($product->why_love_it)
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Why You'll Love It</label>
                        <div class="text-sm text-gray-700 prose max-w-none bg-gray-50 p-4 rounded-lg">{!! $product->why_love_it !!}</div>
                    </div>
                    @endif

                    @if($product->what_makes_clean)
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">What Makes It Clean</label>
                        <div class="text-sm text-gray-700 prose max-w-none bg-gray-50 p-4 rounded-lg">{!! $product->what_makes_clean !!}</div>
                    </div>
                    @endif

                    @if($product->ingredients_details)
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Ingredients and Details</label>
                        <div class="text-sm text-gray-700 prose max-w-none bg-gray-50 p-4 rounded-lg">{!! $product->ingredients_details !!}</div>
                    </div>
                    @endif

                    @if($product->shipping_info)
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Shipping Information</label>
                        <div class="text-sm text-gray-700 prose max-w-none bg-gray-50 p-4 rounded-lg">{!! $product->shipping_info !!}</div>
                    </div>
                    @endif

                    @if($product->disclaimer)
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Disclaimer</label>
                        <div class="text-sm text-gray-700 prose max-w-none bg-gray-50 p-4 rounded-lg">{!! $product->disclaimer !!}</div>
                    </div>
                    @endif

                    @if($product->ask_question)
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Ask a Question</label>
                        <div class="text-sm text-gray-700 prose max-w-none bg-gray-50 p-4 rounded-lg">{!! $product->ask_question !!}</div>
                    </div>
                    @endif

                    @if(!$product->about_scent && !$product->fragrance_notes && !$product->why_love_it && !$product->what_makes_clean && !$product->ingredients_details && !$product->shipping_info && !$product->disclaimer && !$product->ask_question)
                    <p class="text-sm text-gray-500 italic">No product tab content added yet.</p>
                    @endif
                </div>
            </div>

            <!-- Additional Information -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Additional Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Created At</label>
                        <p class="text-sm text-gray-900">{{ $product->created_at->format('M d, Y H:i A') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Last Updated</label>
                        <p class="text-sm text-gray-900">{{ $product->updated_at->format('M d, Y H:i A') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Visibility</label>
                        <p class="text-sm text-gray-900">{{ ucfirst($product->visibility ?? 'visible') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Show in Homepage</label>
                        <p class="text-sm text-gray-900">{{ $product->show_in_homepage ? 'Yes' : 'No' }}</p>
                    </div>
                </div>
            </div>

            <!-- Product Badges -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Product Badges</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full {{ $product->is_new ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                        <span class="text-sm font-semibold text-gray-700">New</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full {{ $product->is_sale ? 'bg-red-500' : 'bg-gray-300' }}"></div>
                        <span class="text-sm font-semibold text-gray-700">Sale</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full {{ $product->is_trending ? 'bg-purple-500' : 'bg-gray-300' }}"></div>
                        <span class="text-sm font-semibold text-gray-700">Trending</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full {{ $product->is_bestseller ? 'bg-yellow-500' : 'bg-gray-300' }}"></div>
                        <span class="text-sm font-semibold text-gray-700">Bestseller</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full {{ $product->is_topsale ? 'bg-orange-500' : 'bg-gray-300' }}"></div>
                        <span class="text-sm font-semibold text-gray-700">Top Sale</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full {{ $product->is_exclusive ? 'bg-indigo-500' : 'bg-gray-300' }}"></div>
                        <span class="text-sm font-semibold text-gray-700">Exclusive</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full {{ $product->is_limited_edition ? 'bg-pink-500' : 'bg-gray-300' }}"></div>
                        <span class="text-sm font-semibold text-gray-700">Limited Edition</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteProduct() {
    if (!confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        return;
    }
    
    fetch('{{ route("admin.products.destroy", $product) }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '{{ route("admin.products") }}';
        } else {
            alert('Failed to delete product');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while deleting the product');
    });
}
</script>
@endsection
