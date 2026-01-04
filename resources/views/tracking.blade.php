@extends('layouts.app')

@section('title', 'Track Your Order - Scents N Smile')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section class="pt-32 pb-16 px-4 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-4xl mx-auto text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-[#e8a598] to-[#d89588] rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
            </div>
            <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tight">Track Your Order</h1>
            <p class="text-xl text-gray-700 mb-8 max-w-2xl mx-auto leading-relaxed">
                Stay updated on your fragrance journey. Enter your order number or AWB code to see real-time tracking updates.
            </p>
        </div>
    </section>

    <!-- Tracking Form Section -->
    <section class="py-12 px-4">
        <div class="max-w-3xl mx-auto">
            <!-- Search Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-10 mb-8">
                <form id="tracking-form" class="space-y-6">
                    <div>
                        <label for="tracking_number" class="block text-sm font-bold text-gray-900 mb-3">Order Number / AWB Code *</label>
                        <input type="text" 
                               id="tracking_number" 
                               name="tracking_number"
                               value="{{ request('order') }}"
                               class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] transition-all text-lg"
                               placeholder="Enter ORD-XXXXX or AWB number"
                               required>
                        <p class="mt-2 text-sm text-gray-500">You can find your order number in the confirmation email we sent you.</p>
                    </div>
                    <button type="submit" class="w-full px-6 py-4 bg-[#e8a598] hover:bg-[#d89588] text-white font-bold rounded-full text-lg shadow-lg transform hover:scale-[1.02] transition-all">
                        <span class="flex items-center justify-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Track My Order
                        </span>
                    </button>
                </form>
            </div>

            <!-- Help Section -->
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-r-2xl p-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">Need Help?</h3>
                        <p class="text-sm text-gray-700 mb-3">
                            If you're having trouble tracking your order or have any questions, our support team is here to help!
                        </p>
                        <div class="flex flex-wrap gap-3">
                            <a href="mailto:hello@scentsnsmile.com" class="inline-flex items-center text-sm font-semibold text-[#e8a598] hover:underline">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Email Us
                            </a>
                            <a href="https://wa.me/919876543210" target="_blank" class="inline-flex items-center text-sm font-semibold text-green-600 hover:underline">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Results Container -->
    <section class="py-8 px-4">
        <div class="max-w-5xl mx-auto">
            <div id="tracking-results" class="hidden">
                <!-- Will be populated by JavaScript -->
            </div>

        <!-- Order Info (if order found) -->
        @if(isset($order))
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Order Header -->
            <div class="bg-gradient-to-br from-[#e8a598] to-[#d89588] px-8 py-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between text-white gap-4">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Order Number</p>
                        <p class="text-2xl font-black">{{ $order->order_number }}</p>
                    </div>
                    <div class="md:text-right">
                        <p class="text-sm opacity-90 mb-1">Order Date</p>
                        <p class="text-lg font-bold">{{ $order->created_at->format('d M, Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <!-- Status Badge -->
                <div class="flex items-center justify-center mb-8">
                    <span class="inline-flex items-center px-6 py-3 rounded-full text-base font-bold shadow-sm
                        @if($order->status === 'delivered') bg-green-100 text-green-700 border-2 border-green-200
                        @elseif($order->status === 'shipped') bg-blue-100 text-blue-700 border-2 border-blue-200
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-700 border-2 border-red-200
                        @else bg-yellow-100 text-yellow-700 border-2 border-yellow-200
                        @endif">
                        @if($order->status === 'delivered') 
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Delivered
                        @elseif($order->status === 'shipped') 
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                            Shipped
                        @elseif($order->status === 'processing') 
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/>
                            </svg>
                            Processing
                        @elseif($order->status === 'cancelled') 
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            Cancelled
                        @else 
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            Pending
                        @endif
                    </span>
                </div>

                @if($order->shiprocket_awb_code)
                <!-- Shiprocket Tracking Info -->
                <div class="mb-8 p-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border border-gray-200">
                    <h3 class="text-lg font-black text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#e8a598]" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                        </svg>
                        Shipment Details
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white rounded-xl p-4 border border-gray-200">
                            <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">AWB Code</p>
                            <p class="font-bold text-gray-900 text-lg">{{ $order->shiprocket_awb_code }}</p>
                        </div>
                        <div class="bg-white rounded-xl p-4 border border-gray-200">
                            <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">Courier Partner</p>
                            <p class="font-bold text-gray-900 text-lg">{{ $order->shiprocket_courier_name ?? 'N/A' }}</p>
                        </div>
                        @if($order->shiprocket_expected_delivery_date)
                        <div class="bg-green-50 rounded-xl p-4 border-2 border-green-200 md:col-span-2">
                            <p class="text-xs text-green-700 mb-1 uppercase tracking-wide font-semibold">Expected Delivery</p>
                            <p class="font-black text-green-700 text-xl">{{ $order->shiprocket_expected_delivery_date->format('d M, Y') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Tracking Timeline -->
                <div id="tracking-timeline" class="mb-8">
                    <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#e8a598]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        Tracking Updates
                    </h3>
                    <div class="text-center py-8">
                        <svg class="animate-spin w-8 h-8 mx-auto text-[#e8a598]" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="mt-3 text-sm text-gray-500">Loading tracking updates...</p>
                    </div>
                </div>
                @endif

                <!-- Order Items -->
                <div class="border-t-2 border-gray-100 pt-8">
                    <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#e8a598]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                        </svg>
                        Order Items
                    </h3>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl border border-gray-200 hover:shadow-sm transition-shadow">
                            <div class="w-16 h-16 bg-white rounded-xl overflow-hidden border border-gray-200 flex-shrink-0">
                                @if($item->getImageUrl())
                                <img src="{{ $item->getImageUrl() }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-900 text-sm truncate">{{ $item->product_name }}</p>
                                <p class="text-xs text-gray-500 mt-1">Quantity: {{ $item->quantity }}</p>
                            </div>
                            <p class="font-black text-gray-900 text-lg">₹{{ number_format($item->price * $item->quantity, 0) }}</p>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Order Total -->
                    <div class="mt-6 pt-6 border-t-2 border-gray-100">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">Total Amount</span>
                            <span class="text-2xl font-black text-[#e8a598]">₹{{ number_format($order->total_amount, 0) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div class="border-t-2 border-gray-100 pt-8 mt-8">
                    <h3 class="text-lg font-black text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#e8a598]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        Delivery Address
                    </h3>
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <p class="text-sm text-gray-700 leading-relaxed">
                            <strong class="text-gray-900">{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                            {{ $order->address }}<br>
                            @if($order->address_line_2){{ $order->address_line_2 }}<br>@endif
                            {{ $order->city }}, {{ $order->state }} - {{ $order->zipcode }}<br>
                            <strong class="text-gray-900">Phone:</strong> {{ $order->phone }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif
        </div>
    </section>
</div>

<script>
document.getElementById('tracking-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const trackingNumber = document.getElementById('tracking_number').value.trim();
    if (trackingNumber) {
        window.location.href = '/track-order?order=' + encodeURIComponent(trackingNumber);
    }
});

@if(isset($order) && $order->shiprocket_awb_code)
// Load tracking timeline
fetch('/api/track/{{ $order->shiprocket_awb_code }}')
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('tracking-timeline');
        if (data.success && data.tracking && data.tracking.shipment_track_activities) {
            const activities = data.tracking.shipment_track_activities;
            container.innerHTML = `
                <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#e8a598]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    Tracking Updates
                </h3>
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <div class="space-y-6">
                        ${activities.map((a, i) => `
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 relative">
                                    <div class="w-4 h-4 mt-1 rounded-full ${i === 0 ? 'bg-[#e8a598] ring-4 ring-[#e8a598]/20' : 'bg-gray-300'}"></div>
                                    ${i < activities.length - 1 ? '<div class="absolute top-5 left-1.5 w-0.5 h-full bg-gray-200"></div>' : ''}
                                </div>
                                <div class="flex-1 pb-6">
                                    <div class="flex items-start justify-between mb-1">
                                        <p class="font-bold text-gray-900 text-sm ${i === 0 ? 'text-[#e8a598]' : ''}">${a.activity || a['sr-status-label'] || 'Update'}</p>
                                        <span class="text-xs text-gray-500 ml-4">${a.date || ''}</span>
                                    </div>
                                    ${a.location ? `<p class="text-xs text-gray-500 mt-1"><svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>${a.location}</p>` : ''}
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        } else {
            container.innerHTML = `
                <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#e8a598]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    Tracking Updates
                </h3>
                <div class="bg-gray-50 rounded-2xl border border-gray-200 p-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-gray-600">Tracking updates will appear here once the shipment is picked up by the courier.</p>
                </div>
            `;
        }
    })
    .catch(err => {
        document.getElementById('tracking-timeline').innerHTML = `
            <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#e8a598]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                </svg>
                Tracking Updates
            </h3>
            <div class="bg-red-50 rounded-2xl border border-red-200 p-8 text-center">
                <svg class="w-12 h-12 mx-auto text-red-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-red-600">Unable to load tracking updates at this time. Please try again later.</p>
            </div>
        `;
    });
@endif
</script>
@endsection
