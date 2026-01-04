@extends('admin.layouts.app')

@section('title', 'Order Details - #' . $order->order_number)

@section('content')
    <!-- Main Container -->
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 p-6">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-center w-12 h-12 bg-white rounded-xl shadow-md hover:shadow-lg transition-all">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div class="flex items-center justify-center w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Order #{{ $order->order_number }}</h1>
                        <p class="mt-1 text-sm text-gray-600">Placed on {{ $order->created_at->format('d M, Y h:i A') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button onclick="window.print()" class="inline-flex items-center px-5 py-2.5 bg-white text-gray-700 text-sm font-semibold rounded-xl border-2 border-gray-200 hover:border-blue-400 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print
                    </button>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-4 rounded-xl shadow-md animate-slideIn">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-green-600 hover:text-green-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Order Items Card -->
                <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-slate-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-lg mr-3">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                </svg>
                            </span>
                            Order Items ({{ $order->items->count() }})
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl border border-gray-200 hover:shadow-md transition-all">
                                <div class="flex-shrink-0 w-20 h-20 bg-white rounded-lg overflow-hidden border-2 border-gray-200">
                                    @php
                                        // Try to get variant image first if variant exists
                                        $productImage = null;
                                        
                                        if ($item->variant && $item->variant->images && count($item->variant->images) > 0) {
                                            $firstImg = $item->variant->images[0];
                                            $productImage = is_array($firstImg) ? ($firstImg['url'] ?? $firstImg['path'] ?? null) : $firstImg;
                                        }
                                        
                                        // Fallback to getImageUrl method
                                        if (!$productImage) {
                                            $productImage = $item->getImageUrl();
                                        }
                                        
                                        // Fallback to product image
                                        if (!$productImage && $item->product) {
                                            $productImage = $item->product->image_url;
                                        }
                                        
                                        // Fallback to product images array
                                        if (!$productImage && $item->product && $item->product->images_array && count($item->product->images_array) > 0) {
                                            $productImage = $item->product->images_array[0];
                                        }
                                    @endphp
                                    @if($productImage)
                                        <img src="{{ $productImage }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center bg-gray-100\'><svg class=\'w-8 h-8 text-gray-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg></div>'">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-bold text-gray-900 truncate">{{ $item->product_name }}</h3>
                                    @if($item->variant)
                                        <p class="text-xs text-gray-500 mt-1">
                                            @if($item->variant->size) Size: <span class="font-semibold">{{ $item->variant->size->name }}</span> @endif
                                            @if($item->variant->color) @if($item->variant->size) | @endif Color: <span class="font-semibold">{{ $item->variant->color->name }}</span> @endif
                                        </p>
                                    @elseif($item->variant_name)
                                        <p class="text-xs text-gray-500 mt-1">{{ $item->variant_name }}</p>
                                    @endif
                                    <p class="text-xs text-gray-600 mt-1">Qty: <span class="font-bold">{{ $item->quantity }}</span> × ₹{{ number_format($item->price, 2) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-black text-blue-600">₹{{ number_format($item->quantity * $item->price, 2) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Shipping Address Card -->
                <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-slate-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-lg mr-3">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Shipping Address
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-2">
                            <p class="text-sm font-bold text-gray-900">{{ $order->first_name }} {{ $order->last_name }}</p>
                            <p class="text-sm text-gray-600">{{ $order->address }}</p>
                            @if($order->address_line_2)
                                <p class="text-sm text-gray-600">{{ $order->address_line_2 }}</p>
                            @endif
                            <p class="text-sm text-gray-600">{{ $order->city }}, {{ $order->state }} - {{ $order->zipcode }}</p>
                            <p class="text-sm text-gray-600">{{ $order->country }}</p>
                            <p class="text-sm text-gray-600">Phone: <span class="font-semibold">{{ $order->phone }}</span></p>
                            <p class="text-sm text-gray-600">Email: <span class="font-semibold">{{ $order->email }}</span></p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                
                <!-- Order Status Card -->
                <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-slate-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-purple-100 text-purple-600 rounded-lg mr-3">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Update Status
                        </h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Order Status</label>
                                    <select name="status" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>🔄 Processing</option>
                                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>🚚 Shipped</option>
                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-bold rounded-xl hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                                    Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Summary Card -->
                <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-slate-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-orange-100 text-orange-600 rounded-lg mr-3">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Order Summary
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold text-gray-900">₹{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            @if($order->discount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Discount</span>
                                <span class="font-semibold text-green-600">-₹{{ number_format($order->discount, 2) }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-semibold text-gray-900">₹{{ number_format($order->shipping, 2) }}</span>
                            </div>
                            @if($order->tax > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-semibold text-gray-900">₹{{ number_format($order->tax, 2) }}</span>
                            </div>
                            @endif
                            <div class="border-t-2 border-gray-200 pt-3 mt-3">
                                <div class="flex justify-between">
                                    <span class="text-base font-bold text-gray-900">Total</span>
                                    <span class="text-2xl font-black text-blue-600">₹{{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Info Card -->
                <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-slate-50 px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-indigo-100 text-indigo-600 rounded-lg mr-3">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Payment Info
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Method</span>
                                @if($order->payment_method === 'cod')
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-700 border border-yellow-300">
                                        💵 Cash on Delivery
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 border border-blue-300">
                                        💳 Online Payment
                                    </span>
                                @endif
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Payment Status</span>
                                @if($order->payment_status === 'paid')
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border border-green-300">
                                        ✅ Paid
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r from-orange-100 to-amber-100 text-orange-700 border border-orange-300">
                                        ⏳ Pending
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shiprocket Shipping Card -->
                <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-50 to-red-50 px-6 py-4 border-b border-orange-200">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-orange-100 text-orange-600 rounded-lg mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                                </svg>
                            </span>
                            Shiprocket Shipping
                        </h2>
                    </div>
                    <div class="p-6">
                        <div id="shiprocket-container">
                            @if($order->shiprocket_order_id)
                                <!-- Shiprocket Info -->
                                <div class="space-y-3 mb-4">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Shiprocket Order</span>
                                        <span class="font-semibold text-gray-900">#{{ $order->shiprocket_order_id }}</span>
                                    </div>
                                    @if($order->shiprocket_awb_code)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">AWB Code</span>
                                        <span class="font-mono font-bold text-blue-600">{{ $order->shiprocket_awb_code }}</span>
                                    </div>
                                    @endif
                                    @if($order->shiprocket_courier_name)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Courier</span>
                                        <span class="font-semibold text-gray-900">{{ $order->shiprocket_courier_name }}</span>
                                    </div>
                                    @endif
                                    @if($order->shiprocket_status)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Status</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold 
                                            @if(in_array($order->shiprocket_status, ['DELIVERED'])) bg-green-100 text-green-700
                                            @elseif(in_array($order->shiprocket_status, ['PICKED_UP', 'IN_TRANSIT', 'OUT_FOR_DELIVERY'])) bg-blue-100 text-blue-700
                                            @elseif(in_array($order->shiprocket_status, ['CANCELLED', 'RTO_INITIATED', 'RTO_DELIVERED'])) bg-red-100 text-red-700
                                            @else bg-yellow-100 text-yellow-700
                                            @endif">
                                            {{ str_replace('_', ' ', $order->shiprocket_status) }}
                                        </span>
                                    </div>
                                    @endif
                                    @if($order->shiprocket_expected_delivery_date)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Expected Delivery</span>
                                        <span class="font-semibold text-gray-900">{{ $order->shiprocket_expected_delivery_date->format('d M, Y') }}</span>
                                    </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="space-y-2">
                                    @if(!$order->shiprocket_awb_code)
                                        <button onclick="showCourierModal()" class="w-full px-4 py-2 bg-orange-500 text-white text-sm font-semibold rounded-lg hover:bg-orange-600 transition-all">
                                            🚚 Select Courier & Generate AWB
                                        </button>
                                    @else
                                        @if($order->shiprocket_status !== 'PICKUP_SCHEDULED')
                                        <button onclick="schedulePickup()" class="w-full px-4 py-2 bg-blue-500 text-white text-sm font-semibold rounded-lg hover:bg-blue-600 transition-all">
                                            📅 Schedule Pickup
                                        </button>
                                        @endif
                                        <div class="grid grid-cols-2 gap-2">
                                            <button onclick="generateLabel()" class="px-3 py-2 bg-gray-100 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-200 transition-all">
                                                🏷️ Print Label
                                            </button>
                                            <button onclick="generateManifest()" class="px-3 py-2 bg-gray-100 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-200 transition-all">
                                                📄 Manifest
                                            </button>
                                            <button onclick="trackShipment()" class="px-3 py-2 bg-gray-100 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-200 transition-all">
                                                📍 Track
                                            </button>
                                            <button onclick="cancelShipment()" class="px-3 py-2 bg-red-100 text-red-700 text-xs font-semibold rounded-lg hover:bg-red-200 transition-all">
                                                ❌ Cancel
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- Create Order Button -->
                                <div class="text-center py-4">
                                    <p class="text-sm text-gray-500 mb-4">Ship this order via Shiprocket</p>
                                    <button onclick="createShiprocketOrder()" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white text-sm font-bold rounded-xl hover:from-orange-600 hover:to-red-600 shadow-lg transform hover:scale-105 transition-all">
                                        🚀 Ship with Shiprocket
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Courier Selection Modal -->
    <div id="courier-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">Select Courier</h3>
                <button onclick="closeCourierModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <div id="courier-list" class="space-y-3 max-h-96 overflow-y-auto">
                    <div class="text-center py-8">
                        <svg class="animate-spin w-8 h-8 mx-auto text-orange-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Loading couriers...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tracking Modal -->
    <div id="tracking-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">Tracking Details</h3>
                <button onclick="closeTrackingModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <div id="tracking-content" class="space-y-4">
                    <div class="text-center py-8">
                        <svg class="animate-spin w-8 h-8 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Loading tracking info...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slideIn {
        animation: slideIn 0.3s ease-out forwards;
    }

    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

<script>
const orderId = {{ $order->id }};

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-xl shadow-lg text-white font-semibold ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} animate-slideIn`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

function createShiprocketOrder() {
    const btn = event.target;
    btn.disabled = true;
    btn.innerHTML = '⏳ Creating...';
    
    fetch(`/admin/shiprocket/orders/${orderId}/create`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast(data.message);
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Failed to create order', 'error');
            btn.disabled = false;
            btn.innerHTML = '🚀 Ship with Shiprocket';
        }
    })
    .catch(err => {
        showToast('Error creating order', 'error');
        btn.disabled = false;
        btn.innerHTML = '🚀 Ship with Shiprocket';
    });
}

function showCourierModal() {
    document.getElementById('courier-modal').classList.remove('hidden');
    loadCouriers();
}

function closeCourierModal() {
    document.getElementById('courier-modal').classList.add('hidden');
}

function loadCouriers() {
    fetch(`/admin/shiprocket/orders/${orderId}/couriers`, {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('courier-list');
        if (data.success && data.couriers && data.couriers.length > 0) {
            container.innerHTML = data.couriers.map(c => `
                <div class="p-4 border-2 border-gray-200 rounded-xl hover:border-orange-400 cursor-pointer transition-all" onclick="selectCourier(${c.courier_company_id}, '${c.courier_name}')">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-gray-900">${c.courier_name}</h4>
                            <p class="text-xs text-gray-500">ETA: ${c.etd || 'N/A'} days</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-orange-600">₹${c.rate || c.freight_charge || 0}</p>
                        </div>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = '<p class="text-center text-gray-500 py-8">No couriers available for this pincode</p>';
        }
    })
    .catch(err => {
        document.getElementById('courier-list').innerHTML = '<p class="text-center text-red-500 py-8">Failed to load couriers</p>';
    });
}

function selectCourier(courierId, courierName) {
    if (!confirm(`Generate AWB with ${courierName}?`)) return;
    
    closeCourierModal();
    
    fetch(`/admin/shiprocket/orders/${orderId}/awb`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ courier_id: courierId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast(data.message);
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Failed to generate AWB', 'error');
        }
    })
    .catch(err => showToast('Error generating AWB', 'error'));
}

function schedulePickup() {
    if (!confirm('Schedule pickup for this shipment?')) return;
    
    fetch(`/admin/shiprocket/orders/${orderId}/pickup`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast(data.message);
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Failed to schedule pickup', 'error');
        }
    })
    .catch(err => showToast('Error scheduling pickup', 'error'));
}

function generateLabel() {
    fetch(`/admin/shiprocket/orders/${orderId}/label`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success && data.label_url) {
            window.open(data.label_url, '_blank');
        } else {
            showToast(data.message || 'Failed to generate label', 'error');
        }
    })
    .catch(err => showToast('Error generating label', 'error'));
}

function generateManifest() {
    fetch(`/admin/shiprocket/orders/${orderId}/manifest`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success && data.manifest_url) {
            window.open(data.manifest_url, '_blank');
        } else {
            showToast(data.message || 'Failed to generate manifest', 'error');
        }
    })
    .catch(err => showToast('Error generating manifest', 'error'));
}

function trackShipment() {
    document.getElementById('tracking-modal').classList.remove('hidden');
    
    fetch(`/admin/shiprocket/orders/${orderId}/track`, {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('tracking-content');
        if (data.success && data.tracking) {
            const t = data.tracking;
            container.innerHTML = `
                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 rounded-xl">
                        <p class="text-sm text-gray-600">Current Status</p>
                        <p class="text-lg font-bold text-blue-600">${data.order_status || 'Unknown'}</p>
                    </div>
                    ${t.shipment_track_activities ? `
                        <div class="space-y-3">
                            <h4 class="font-bold text-gray-900">Activity Log</h4>
                            ${t.shipment_track_activities.slice(0, 5).map(a => `
                                <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <div class="w-2 h-2 mt-2 bg-blue-500 rounded-full"></div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">${a.activity || a['sr-status-label'] || 'Update'}</p>
                                        <p class="text-xs text-gray-500">${a.date || ''} ${a.location || ''}</p>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    ` : '<p class="text-gray-500">No tracking activities found</p>'}
                </div>
            `;
        } else {
            container.innerHTML = '<p class="text-center text-red-500 py-8">Failed to load tracking info</p>';
        }
    })
    .catch(err => {
        document.getElementById('tracking-content').innerHTML = '<p class="text-center text-red-500 py-8">Error loading tracking</p>';
    });
}

function closeTrackingModal() {
    document.getElementById('tracking-modal').classList.add('hidden');
}

function cancelShipment() {
    if (!confirm('Are you sure you want to cancel this shipment?')) return;
    
    fetch(`/admin/shiprocket/orders/${orderId}/cancel`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast(data.message);
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Failed to cancel shipment', 'error');
        }
    })
    .catch(err => showToast('Error cancelling shipment', 'error'));
}
</script>
@endpush
