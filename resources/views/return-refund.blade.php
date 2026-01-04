@extends('layouts.app')

@section('title', 'Return & Refund Policy - Scents N Smile')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section class="pt-32 pb-16 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tight">Return & Refund Policy</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Thank you for choosing Scents N' Smile™! We understand that sometimes a fragrance just isn't "the one." True to our risk-free promise, we've made the exchange and return process as simple as possible.
            </p>
        </div>
    </section>

    <!-- Promise Section -->
    <section class="py-12 px-4 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-4xl mx-auto text-center">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-[#e8a598] rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold mb-4">Our Commitment to You</h2>
                <p class="text-lg text-gray-700 leading-relaxed">
                    We are committed to ensuring your experience with us always ends with a smile, and we won't rest until you're completely satisfied.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Policy Content -->
    <section class="py-12 px-4 bg-white">
        <div class="max-w-6xl mx-auto">
            <!-- Policy Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-black mb-4">📜 Our Effortless Return & Exchange Policy</h2>
                <p class="text-lg text-gray-600">True to our Scented Promise, we've made the process straightforward.</p>
            </div>

            <!-- 1. Eligibility and Time Frame -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
                <div class="flex items-start space-x-4 mb-6">
                    <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                        <span class="text-white font-black text-xl">1</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-black text-gray-900 mb-4">Eligibility and Time Frame</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-[#e8a598] mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-gray-700 leading-relaxed">We happily accept returns or exchanges for any fragrance that is unsatisfactory.</p>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-[#e8a598] mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-gray-700 leading-relaxed">The return window is <strong>14 days</strong> from the date your order was delivered.</p>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-6 mt-6">
                                <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3">Applicable Products</h4>
                                <p class="text-gray-700 mb-3">Returns and exchanges are only accommodated for:</p>
                                <ul class="space-y-2">
                                    <li class="flex items-center gap-3">
                                        <span class="w-2 h-2 bg-[#e8a598] rounded-full"></span>
                                        <span class="text-gray-700"><strong>Roll-ons:</strong> 6ML and 10ML sizes</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <span class="w-2 h-2 bg-[#e8a598] rounded-full"></span>
                                        <span class="text-gray-700"><strong>Perfume Bottles:</strong> 50ML and 100ML sizes</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Condition of Returned Items -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
                <div class="flex items-start space-x-4 mb-6">
                    <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                        <span class="text-white font-black text-xl">2</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-black text-gray-900 mb-4">Condition of Returned Items</h3>
                        <p class="text-gray-700 leading-relaxed mb-6">
                            To ensure a seamless return or exchange process, the returned product must meet the following criteria:
                        </p>

                        <!-- Condition Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-3 text-left text-sm font-bold text-gray-900 border border-gray-200">Condition</th>
                                        <th class="px-4 py-3 text-left text-sm font-bold text-gray-900 border border-gray-200">Perfume Usage Guidelines</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-semibold text-gray-900 border border-gray-200">Original Packaging</td>
                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">The item must include its original cellophane, any free testers, and the original box/packaging.</td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="px-4 py-3 text-sm font-semibold text-gray-900 border border-gray-200">Minimal Use</td>
                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Returns are eligible if less than 10% of the product volume has been used.</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-semibold text-gray-900 border border-gray-200">No Fee</td>
                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">No fees will be applied for negligible use (less than 1% of the product).</td>
                                    </tr>
                                    <tr class="bg-red-50">
                                        <td class="px-4 py-3 text-sm font-semibold text-red-900 border border-gray-200">Ineligible</td>
                                        <td class="px-4 py-3 text-sm text-red-700 border border-gray-200">Returns are not eligible if more than 10% of the product has been used.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="bg-yellow-50 rounded-xl p-6 border-l-4 border-yellow-500 mt-6">
                            <p class="text-sm font-semibold text-yellow-900 mb-2">⚠️ IMPORTANT</p>
                            <p class="text-sm text-yellow-800">
                                If the packaging is damaged beyond its condition at the time of delivery, or if the return does not meet these criteria, the corresponding fees listed below will be deducted from your refund.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Fees and Deductions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
                <div class="flex items-start space-x-4 mb-6">
                    <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                        <span class="text-white font-black text-xl">3</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-black text-gray-900 mb-4">Fees and Deductions</h3>
                        
                        <!-- Fees Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-3 text-left text-sm font-bold text-gray-900 border border-gray-200">Scenario</th>
                                        <th class="px-4 py-3 text-left text-sm font-bold text-gray-900 border border-gray-200">Fee / Deduction</th>
                                        <th class="px-4 py-3 text-left text-sm font-bold text-gray-900 border border-gray-200">Notes</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-semibold text-gray-900 border border-gray-200">Standard Shipping Fee<br><span class="text-xs text-gray-600">(Change of Mind/Error)</span></td>
                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">₹150 (One-Way)<br>OR<br>₹240 (Two-Way)</td>
                                        <td class="px-4 py-3 text-sm text-gray-600 border border-gray-200">This covers shipping and packaging costs for non-fault returns.</td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="px-4 py-3 text-sm font-semibold text-gray-900 border border-gray-200">Perfume Usage Fee</td>
                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">₹150</td>
                                        <td class="px-4 py-3 text-sm text-gray-600 border border-gray-200">Deducted if the product has been used up to 10% of its volume.</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-semibold text-gray-900 border border-gray-200">Missing/Damaged Box</td>
                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">₹100</td>
                                        <td class="px-4 py-3 text-sm text-gray-600 border border-gray-200">Deducted if the original box is damaged or missing.</td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="px-4 py-3 text-sm font-semibold text-gray-900 border border-gray-200">Missing/Damaged Cellophane</td>
                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">₹20</td>
                                        <td class="px-4 py-3 text-sm text-gray-600 border border-gray-200">Deducted if the original cellophane is missing or significantly damaged.</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-semibold text-gray-900 border border-gray-200">Missing/Used Testers</td>
                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">₹50 per Tester</td>
                                        <td class="px-4 py-3 text-sm text-gray-600 border border-gray-200">Deducted if any free testers are missing or have been used.</td>
                                    </tr>
                                    <tr class="bg-green-50">
                                        <td class="px-4 py-3 text-sm font-semibold text-green-900 border border-gray-200">Free Doorstep Return</td>
                                        <td class="px-4 py-3 text-sm font-bold text-green-700 border border-gray-200">₹0</td>
                                        <td class="px-4 py-3 text-sm text-green-700 border border-gray-200">Applicable only if the product is defective, damaged, or the wrong item was sent.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Non-Returnable Items -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
                <div class="flex items-start space-x-4 mb-6">
                    <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                        <span class="text-white font-black text-xl">4</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-black text-gray-900 mb-4">Non-Returnable Items (Final Sale)</h3>
                        <p class="text-gray-700 leading-relaxed mb-6">
                            Due to the nature of these products, the following items are considered final sale and cannot be returned or exchanged:
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-red-50 rounded-xl p-4 border border-red-200">
                                <div class="flex items-center gap-3 mb-2">
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-bold text-red-900">Product Categories</span>
                                </div>
                                <ul class="space-y-1 text-sm text-red-800">
                                    <li>• Waxes, Candles</li>
                                    <li>• Body Mist</li>
                                    <li>• Car/Air Freshener</li>
                                </ul>
                            </div>

                            <div class="bg-red-50 rounded-xl p-4 border border-red-200">
                                <div class="flex items-center gap-3 mb-2">
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-bold text-red-900">Special Items</span>
                                </div>
                                <ul class="space-y-1 text-sm text-red-800">
                                    <li>• Mystery Fragrance</li>
                                    <li>• 15ML Twister</li>
                                    <li>• Decant Organizer</li>
                                    <li>• Sample Traveling Pouch</li>
                                </ul>
                            </div>

                            <div class="bg-red-50 rounded-xl p-4 border border-red-200">
                                <div class="flex items-center gap-3 mb-2">
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-bold text-red-900">Samples & Testers</span>
                                </div>
                                <ul class="space-y-1 text-sm text-red-800">
                                    <li>• Any Sample Bottles</li>
                                    <li>• 5ML Spray Tester</li>
                                    <li>• All Tester Bottles</li>
                                </ul>
                            </div>

                            <div class="bg-red-50 rounded-xl p-4 border border-red-200">
                                <div class="flex items-center gap-3 mb-2">
                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-bold text-red-900">Sale Items</span>
                                </div>
                                <ul class="space-y-1 text-sm text-red-800">
                                    <li>• Products on sale</li>
                                    <li>• Significant discount items</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Process and Timing -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
                <div class="flex items-start space-x-4 mb-6">
                    <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                        <span class="text-white font-black text-xl">5</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-black text-gray-900 mb-6">Process and Timing</h3>
                        
                        <div class="space-y-6">
                            <!-- Timeline -->
                            <div class="relative">
                                <!-- Vertical Line -->
                                <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                                
                                <!-- Steps -->
                                <div class="space-y-8">
                                    <!-- Step 1 -->
                                    <div class="relative flex items-start gap-6">
                                        <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-full flex items-center justify-center z-10">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 pt-2">
                                            <h4 class="text-lg font-bold text-gray-900 mb-2">Damaged/Wrong Items</h4>
                                            <p class="text-gray-700 leading-relaxed">Be sure to inspect your order upon receipt of the parcel. Contact us immediately for any wrong, damaged, or defective products.</p>
                                        </div>
                                    </div>

                                    <!-- Step 2 -->
                                    <div class="relative flex items-start gap-6">
                                        <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-full flex items-center justify-center z-10">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 pt-2">
                                            <h4 class="text-lg font-bold text-gray-900 mb-2">Inspection</h4>
                                            <p class="text-gray-700 leading-relaxed">Once the return is received, it will be inspected and verified within <strong>48 working hours</strong>.</p>
                                        </div>
                                    </div>

                                    <!-- Step 3 -->
                                    <div class="relative flex items-start gap-6">
                                        <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-full flex items-center justify-center z-10">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 pt-2">
                                            <h4 class="text-lg font-bold text-gray-900 mb-2">Processing Time</h4>
                                            <p class="text-gray-700 leading-relaxed">Please note that it may take <strong>5 – 10 working days</strong> to fully process your request and for the refund to reflect in your account.</p>
                                        </div>
                                    </div>

                                    <!-- Step 4 -->
                                    <div class="relative flex items-start gap-6">
                                        <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-full flex items-center justify-center z-10">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 pt-2">
                                            <h4 class="text-lg font-bold text-gray-900 mb-2">Sale Item Exchange</h4>
                                            <p class="text-gray-700 leading-relaxed">Products purchased on sale are non-refundable but can be exchanged for a product of equal or greater value.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How to Initiate Return -->
            <div class="bg-gradient-to-br from-[#e8a598] to-[#d89588] rounded-2xl shadow-lg p-8 mb-8">
                <div class="text-center text-white">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 backdrop-blur-sm rounded-full mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black mb-4">How to Initiate a Return or Exchange</h3>
                    <p class="text-lg mb-6 opacity-90">
                        Please complete our return form or contact us directly so we can quickly and smoothly handle your request and help you discover your next beloved scent.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('contact') }}" class="inline-block bg-white text-[#e8a598] font-bold px-8 py-3 rounded-full hover:bg-gray-100 transition-colors">
                            Contact Us
                        </a>
                        <a href="mailto:hello@scentsnsmile.com" class="inline-block bg-white bg-opacity-20 backdrop-blur-sm text-white font-bold px-8 py-3 rounded-full hover:bg-opacity-30 transition-colors border-2 border-white">
                            Email Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 px-4 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-black text-center mb-12">Frequently Asked Questions</h2>
            
            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">What if I received a damaged or wrong product?</h3>
                    <p class="text-gray-700 leading-relaxed">Contact us immediately upon receiving your order. We offer free doorstep returns for defective, damaged, or wrong items with no additional charges.</p>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Can I return a product if I just don't like the scent?</h3>
                    <p class="text-gray-700 leading-relaxed">Yes! We accept returns within 14 days if the product has been used less than 10%. Standard shipping fees may apply for change of mind returns.</p>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">How long does it take to receive my refund?</h3>
                    <p class="text-gray-700 leading-relaxed">After we receive and inspect your return (within 48 working hours), it takes 5-10 working days for the refund to be processed and reflect in your account.</p>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Can I exchange a sale item?</h3>
                    <p class="text-gray-700 leading-relaxed">Products purchased on sale are non-refundable but can be exchanged for a product of equal or greater value.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 px-4 bg-white">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-4">Still Have Questions?</h2>
            <p class="text-lg text-gray-600 mb-8">
                Our customer support team is here to help you with your return or exchange.
            </p>
            <a href="{{ route('contact') }}" class="inline-block bg-[#e8a598] hover:bg-[#d89588] text-white font-bold px-8 py-4 rounded-full text-lg transition-colors">
                Get in Touch
            </a>
        </div>
    </section>
</div>

<!-- Smooth Scroll Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endsection
