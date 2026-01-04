@extends('layouts.app')

@section('title', 'Shipping Policy - Scents N Smile')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section class="pt-32 pb-16 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tight">Shipping Policy</h1>
            <p class="text-2xl text-gray-700 max-w-3xl mx-auto leading-relaxed font-semibold">
                Your Fragrance, On Its Way! 🚀
            </p>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto mt-4 leading-relaxed">
                Hey there, scent lover! At Scents N Smile™, we're all about spreading joy with every spritz, and that starts with getting your order to you fast, safe, and with a smile.
            </p>
        </div>
    </section>

    <!-- Trust Section -->
    <section class="py-12 px-4 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-4xl mx-auto text-center">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-[#e8a598] rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold mb-4">Trusted Delivery Partners</h2>
                <p class="text-lg text-gray-700 leading-relaxed">
                    We've teamed up with India's top courier partners to deliver your favorite fragrances right to your doorstep, no matter where you are!
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 px-4 bg-white">
        <div class="max-w-6xl mx-auto">
            
            <!-- Your Order's Journey -->
            <div class="mb-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-black mb-4">🚚 Your Order's Journey</h2>
                    <p class="text-lg text-gray-600">From our hands to yours, here's how it works</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Step 1 -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center hover:shadow-lg transition-shadow">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-[#e8a598] rounded-full mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Packing with Love</h3>
                        <p class="text-gray-700 leading-relaxed">
                            We prep your order with care within <strong>1–2 business days</strong> (weekends and holidays are for chilling, so they don't count!).
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center hover:shadow-lg transition-shadow">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-[#e8a598] rounded-full mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">On the Move</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Once it's out the door, expect your package to arrive in <strong>3–6 business days</strong>, depending on your corner of India.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center hover:shadow-lg transition-shadow">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-[#e8a598] rounded-full mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Heads-Up</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Sometimes, couriers hit a speed bump (think weather or unexpected delays). If that happens, we've got your back and will keep you in the loop!
                        </p>
                    </div>
                </div>
            </div>

            <!-- We Ship Everywhere -->
            <div class="bg-gradient-to-br from-[#e8a598] to-[#d89588] rounded-2xl shadow-lg p-8 md:p-12 mb-12">
                <div class="text-center text-white">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white bg-opacity-20 backdrop-blur-sm rounded-full mb-6">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-black mb-4">🌏 We Ship Everywhere in India!</h2>
                    <p class="text-xl leading-relaxed opacity-95 max-w-3xl mx-auto">
                        From bustling cities to serene villages, Scents N Smile™ delivers nationwide. Our trusted logistics crew ensures your order arrives fresh and fabulous, no matter where you are.
                    </p>
                </div>
            </div>

            <!-- Where's My Package -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-12">
                <div class="flex items-start space-x-4 mb-6">
                    <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-black text-gray-900 mb-4">😕 Where's My Package?</h2>
                        <p class="text-gray-700 leading-relaxed mb-6">
                            If your order's playing hide-and-seek past the expected delivery date, don't worry! Here's what we'll do:
                        </p>

                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-[#e8a598] bg-opacity-20 rounded-full flex items-center justify-center">
                                    <span class="text-[#e8a598] font-bold text-sm">1</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Contact Us</h4>
                                    <p class="text-gray-700">Drop us a line at <a href="mailto:hello@scentsnsmile.com" class="text-[#e8a598] hover:underline font-semibold">hello@scentsnsmile.com</a></p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-[#e8a598] bg-opacity-20 rounded-full flex items-center justify-center">
                                    <span class="text-[#e8a598] font-bold text-sm">2</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">We Jump Into Action</h4>
                                    <p class="text-gray-700">We'll track your package with our courier partners immediately.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-[#e8a598] bg-opacity-20 rounded-full flex items-center justify-center">
                                    <span class="text-[#e8a598] font-bold text-sm">3</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Investigation Time</h4>
                                    <p class="text-gray-700">Investigations might take up to <strong>10 business days</strong>, but we'll keep you posted every step of the way.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-[#e8a598] bg-opacity-20 rounded-full flex items-center justify-center">
                                    <span class="text-[#e8a598] font-bold text-sm">4</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">We Make It Right</h4>
                                    <p class="text-gray-700">If your package goes on an unexpected adventure (aka gets lost), we'll make it right with a <strong>replacement or refund</strong>, per our policies.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Every Order's a VIP -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-12">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-black text-gray-900 mb-4">💖 Every Order's a VIP</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Whether you're treating yourself or gifting a loved one, every Scents N Smile™ package is packed with care to keep your fragrances pristine.
                        </p>
                        <p class="text-lg font-semibold text-gray-900">
                            We're not just shipping a product—we're delivering a little burst of happiness! ✨
                        </p>
                    </div>
                </div>
            </div>

            <!-- Got Questions -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl shadow-sm border border-gray-200 p-8">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-black text-gray-900 mb-4">📬 Got Questions?</h2>
                        <p class="text-gray-700 leading-relaxed mb-6">
                            Our friendly support team is ready to help with any shipping queries.
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white rounded-xl p-5 border border-gray-200">
                                <div class="flex items-center gap-3 mb-2">
                                    <svg class="w-5 h-5 text-[#e8a598]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm font-bold text-gray-900">Email</span>
                                </div>
                                <a href="mailto:hello@scentsnsmile.com" class="text-[#e8a598] hover:underline font-semibold">hello@scentsnsmile.com</a>
                            </div>

                            <div class="bg-white rounded-xl p-5 border border-gray-200">
                                <div class="flex items-center gap-3 mb-2">
                                    <svg class="w-5 h-5 text-[#e8a598]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm font-bold text-gray-900">Reply Time</span>
                                </div>
                                <p class="text-gray-700 text-sm">Within 24–48 hours on business days</p>
                            </div>
                        </div>
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
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Do you ship on weekends?</h3>
                    <p class="text-gray-700 leading-relaxed">We process orders on business days only. Orders placed on weekends or holidays will be processed on the next business day.</p>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Can I track my order?</h3>
                    <p class="text-gray-700 leading-relaxed">Absolutely! Once your order ships, you'll receive a tracking number via email. You can use it to track your package in real-time.</p>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">What if my delivery is delayed?</h3>
                    <p class="text-gray-700 leading-relaxed">Sometimes delays happen due to weather or courier issues. Contact us at hello@scentsnsmile.com and we'll track your package and keep you updated.</p>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Do you ship to remote areas?</h3>
                    <p class="text-gray-700 leading-relaxed">Yes! We deliver to all corners of India, from cities to villages. Delivery times may vary slightly for remote locations.</p>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">What if my package is lost?</h3>
                    <p class="text-gray-700 leading-relaxed">If your package is confirmed lost after investigation (up to 10 business days), we'll provide a replacement or refund according to our policies.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 px-4 bg-white">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-[#e8a598] rounded-full mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                </svg>
            </div>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-4">Thanks for Choosing Scents N Smile™!</h2>
            <p class="text-lg text-gray-600 mb-8">
                We're thrilled to send a little sparkle and scent your way! ✨
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('collections') }}" class="inline-block bg-[#e8a598] hover:bg-[#d89588] text-white font-bold px-8 py-4 rounded-full text-lg transition-colors">
                    Shop Now
                </a>
                <a href="{{ route('contact') }}" class="inline-block bg-gray-900 hover:bg-gray-800 text-white font-bold px-8 py-4 rounded-full text-lg transition-colors">
                    Contact Support
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
