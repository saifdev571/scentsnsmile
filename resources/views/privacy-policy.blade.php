@extends('layouts.app')

@section('title', 'Privacy Policy - Scents N Smile')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section class="pt-32 pb-16 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tight">Privacy Policy</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Your privacy is important to us. Learn how we collect, use, and protect your personal information.
            </p>
            <div class="mt-6 text-sm text-gray-500">
                Last Updated: January 2026
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 px-4 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar Navigation -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Quick Navigation</h3>
                        <nav class="space-y-2">
                            <a href="#overview" class="block px-3 py-2 text-sm text-gray-700 hover:bg-[#e8a598] hover:bg-opacity-10 hover:text-[#e8a598] rounded-lg transition-colors">Overview</a>
                            <a href="#collecting" class="block px-3 py-2 text-sm text-gray-700 hover:bg-[#e8a598] hover:bg-opacity-10 hover:text-[#e8a598] rounded-lg transition-colors">Collecting Information</a>
                            <a href="#device-info" class="block px-3 py-2 text-sm text-gray-700 hover:bg-[#e8a598] hover:bg-opacity-10 hover:text-[#e8a598] rounded-lg transition-colors">Device Information</a>
                            <a href="#order-info" class="block px-3 py-2 text-sm text-gray-700 hover:bg-[#e8a598] hover:bg-opacity-10 hover:text-[#e8a598] rounded-lg transition-colors">Order Information</a>
                            <a href="#minors" class="block px-3 py-2 text-sm text-gray-700 hover:bg-[#e8a598] hover:bg-opacity-10 hover:text-[#e8a598] rounded-lg transition-colors">Minors</a>
                            <a href="#sharing" class="block px-3 py-2 text-sm text-gray-700 hover:bg-[#e8a598] hover:bg-opacity-10 hover:text-[#e8a598] rounded-lg transition-colors">Sharing Information</a>
                            <a href="#using" class="block px-3 py-2 text-sm text-gray-700 hover:bg-[#e8a598] hover:bg-opacity-10 hover:text-[#e8a598] rounded-lg transition-colors">Using Information</a>
                            <a href="#retention" class="block px-3 py-2 text-sm text-gray-700 hover:bg-[#e8a598] hover:bg-opacity-10 hover:text-[#e8a598] rounded-lg transition-colors">Retention</a>
                            <a href="#gdpr" class="block px-3 py-2 text-sm text-gray-700 hover:bg-[#e8a598] hover:bg-opacity-10 hover:text-[#e8a598] rounded-lg transition-colors">GDPR</a>
                            <a href="#ccpa" class="block px-3 py-2 text-sm text-gray-700 hover:bg-[#e8a598] hover:bg-opacity-10 hover:text-[#e8a598] rounded-lg transition-colors">CCPA</a>
                            <a href="#cookies" class="block px-3 py-2 text-sm text-gray-700 hover:bg-[#e8a598] hover:bg-opacity-10 hover:text-[#e8a598] rounded-lg transition-colors">Cookies</a>
                            <a href="#contact" class="block px-3 py-2 text-sm text-gray-700 hover:bg-[#e8a598] hover:bg-opacity-10 hover:text-[#e8a598] rounded-lg transition-colors">Contact Us</a>
                        </nav>
                    </div>
                </div>

                <!-- Content -->
                <div class="lg:col-span-3 space-y-8">
                    <!-- Overview -->
                    <div id="overview" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-black text-gray-900 mb-2">Privacy Policy Overview</h2>
                                <p class="text-gray-600 leading-relaxed">
                                    This Privacy Policy describes how <strong>scentsnsmile.com</strong> (the "Site" or "we") collects, uses, and discloses your Personal Information when you visit or make a purchase from the Site.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Collecting Personal Information -->
                    <div id="collecting" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 mb-4">Collecting Personal Information</h2>
                                <p class="text-gray-600 leading-relaxed mb-4">
                                    When you visit the Site, we collect certain information about your device, your interaction with the Site, and information necessary to process your purchases. We may also collect additional information if you contact us for customer support.
                                </p>
                                <p class="text-gray-600 leading-relaxed">
                                    In this Privacy Policy, we refer to any information that can uniquely identify an individual as <strong>"Personal Information"</strong>. See the sections below for more information about what Personal Information we collect and why.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Device Information -->
                    <div id="device-info" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 mb-4">Device Information</h2>
                                
                                <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl p-6 mb-4 border border-gray-200">
                                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3">Examples of Personal Information Collected:</h3>
                                    <ul class="space-y-2 text-gray-700">
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Version of web browser</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>IP address</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Time zone</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Cookie information</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Sites or products you view, search terms, and interaction with the Site</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                                        <h4 class="text-sm font-bold text-blue-900 mb-2">Purpose of Collection</h4>
                                        <p class="text-sm text-blue-800">To load the Site accurately for you, and to perform analytics on Site usage to optimize our Site.</p>
                                    </div>
                                    <div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
                                        <h4 class="text-sm font-bold text-purple-900 mb-2">Source of Collection</h4>
                                        <p class="text-sm text-purple-800">Collected automatically when you access our Site using cookies, log files, web beacons, tags, or pixels.</p>
                                    </div>
                                </div>

                                <div class="mt-4 bg-yellow-50 rounded-xl p-4 border border-yellow-200">
                                    <h4 class="text-sm font-bold text-yellow-900 mb-2">Disclosure for Business Purpose</h4>
                                    <p class="text-sm text-yellow-800">Shared with our processor Shopify.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Information -->
                    <div id="order-info" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 mb-4">Order Information</h2>
                                
                                <div class="bg-gradient-to-br from-gray-50 to-orange-50 rounded-xl p-6 mb-4 border border-gray-200">
                                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3">Examples of Personal Information Collected:</h3>
                                    <ul class="space-y-2 text-gray-700">
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-orange-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Name</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-orange-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Billing address</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-orange-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Shipping address</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-orange-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Payment information (including credit card numbers)</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-orange-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Email address</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-orange-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Phone number</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="space-y-4">
                                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                                        <h4 class="text-sm font-bold text-blue-900 mb-2">Purpose of Collection</h4>
                                        <p class="text-sm text-blue-800">To provide products or services to you, fulfill our contract, process your payment information, arrange for shipping, provide invoices and order confirmations, communicate with you, screen orders for potential risk or fraud, and provide you with information or advertising relating to our products or services.</p>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
                                            <h4 class="text-sm font-bold text-purple-900 mb-2">Source of Collection</h4>
                                            <p class="text-sm text-purple-800">Collected from you.</p>
                                        </div>
                                        <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-200">
                                            <h4 class="text-sm font-bold text-yellow-900 mb-2">Disclosure</h4>
                                            <p class="text-sm text-yellow-800">Shared with our processor Shopify.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Support Information -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 mb-4">Customer Support Information</h2>
                                <p class="text-gray-600 leading-relaxed mb-4">
                                    When you contact us for customer support, we collect information necessary to assist you with your inquiry.
                                </p>
                                <div class="bg-cyan-50 rounded-xl p-4 border border-cyan-200">
                                    <h4 class="text-sm font-bold text-cyan-900 mb-2">Purpose of Collection</h4>
                                    <p class="text-sm text-cyan-800">To provide customer support and resolve your inquiries.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Minors -->
                    <div id="minors" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 mb-4">Minors</h2>
                                <div class="bg-red-50 rounded-xl p-6 border-l-4 border-red-500">
                                    <p class="text-gray-800 leading-relaxed mb-3">
                                        The Site is not intended for individuals under the age of <strong>14</strong>. We do not intentionally collect Personal Information from children.
                                    </p>
                                    <p class="text-gray-800 leading-relaxed">
                                        If you are the parent or guardian and believe your child has provided us with Personal Information, please contact us at the address below to request deletion.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sharing Personal Information -->
                    <div id="sharing" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 mb-4">Sharing Personal Information</h2>
                                <p class="text-gray-600 leading-relaxed mb-4">
                                    We share your Personal Information with service providers to help us provide our services and fulfill our contracts with you, as described above.
                                </p>
                                
                                <div class="space-y-4">
                                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-6 border border-indigo-200">
                                        <h3 class="text-lg font-bold text-gray-900 mb-3">For Example:</h3>
                                        <ul class="space-y-2 text-gray-700">
                                            <li class="flex items-start">
                                                <svg class="w-5 h-5 text-indigo-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                <span>We use Shopify to power our online store. You can read more about how Shopify uses your Personal Information here: <a href="https://www.shopify.com/legal/privacy" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline">https://www.shopify.com/legal/privacy</a></span>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="bg-yellow-50 rounded-xl p-6 border-l-4 border-yellow-500">
                                        <p class="text-gray-800 leading-relaxed">
                                            We may share your Personal Information to comply with applicable laws and regulations, to respond to a subpoena, search warrant or other lawful request for information we receive, or to otherwise protect our rights.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Using Personal Information -->
                    <div id="using" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 mb-4">Using Personal Information</h2>
                                <p class="text-gray-600 leading-relaxed mb-4">
                                    We use your personal Information to provide our services to you, which includes:
                                </p>
                                
                                <div class="bg-gradient-to-br from-teal-50 to-green-50 rounded-xl p-6 border border-teal-200">
                                    <ul class="space-y-3 text-gray-700">
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-teal-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Offering products for sale</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-teal-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Processing payments</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-teal-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Shipping and fulfillment of your order</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-teal-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Keeping you up to date on new products, services, and offers</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="mt-6">
                                    <h3 class="text-lg font-bold text-gray-900 mb-3">Lawful Basis</h3>
                                    <p class="text-gray-600 leading-relaxed mb-4">
                                        Pursuant to the General Data Protection Regulation ("GDPR"), if you are a resident of the European Economic Area ("EEA"), we process your personal information under the following lawful bases:
                                    </p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                            <p class="text-sm font-semibold text-blue-900">Your consent</p>
                                        </div>
                                        <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                                            <p class="text-sm font-semibold text-purple-900">The performance of the contract between you and the Site</p>
                                        </div>
                                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                            <p class="text-sm font-semibold text-green-900">Compliance with our legal obligations</p>
                                        </div>
                                        <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                                            <p class="text-sm font-semibold text-orange-900">To protect your vital interests</p>
                                        </div>
                                        <div class="bg-pink-50 rounded-lg p-4 border border-pink-200">
                                            <p class="text-sm font-semibold text-pink-900">To perform a task carried out in the public interest</p>
                                        </div>
                                        <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-200">
                                            <p class="text-sm font-semibold text-indigo-900">For our legitimate interests, which do not override your fundamental rights and freedoms</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Retention -->
                    <div id="retention" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 mb-4">Retention</h2>
                                <p class="text-gray-600 leading-relaxed mb-4">
                                    When you place an order through the Site, we will retain your Personal Information for our records unless and until you ask us to erase this information.
                                </p>
                                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                    <p class="text-gray-700 leading-relaxed">
                                        For more information on your right of erasure, please see the <strong>'Your Rights'</strong> section below.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Automatic Decision-Making -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 mb-4">Automatic Decision-Making</h2>
                                <p class="text-gray-600 leading-relaxed mb-4">
                                    If you are a resident of the EEA, you have the right to object to processing based solely on automated decision-making (which includes profiling), when that decision-making has a legal effect on you or otherwise significantly affects you.
                                </p>
                                
                                <div class="bg-violet-50 rounded-xl p-6 border border-violet-200 mb-4">
                                    <p class="text-gray-800 leading-relaxed mb-3">
                                        We <strong>do not</strong> engage in fully automated decision-making that has a legal or otherwise significant effect using customer data.
                                    </p>
                                    <p class="text-gray-800 leading-relaxed">
                                        Our processor Shopify uses limited automated decision-making to prevent fraud that does not have a legal or otherwise significant effect on you.
                                    </p>
                                </div>

                                <div class="bg-gradient-to-br from-gray-50 to-violet-50 rounded-xl p-6 border border-gray-200">
                                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3">Services that include elements of automated decision-making include:</h3>
                                    <ul class="space-y-2 text-gray-700">
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-violet-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Temporary denylist of IP addresses associated with repeated failed transactions. This denylist persists for a small number of hours.</span>
                                        </li>
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-violet-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Temporary denylist of credit cards associated with denylisted IP addresses. This denylist persists for a small number of days.</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- GDPR -->
                    <div id="gdpr" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 mb-4">GDPR (General Data Protection Regulation)</h2>
                                <p class="text-gray-600 leading-relaxed mb-6">
                                    If you are a resident of the EEA, you have the right to access the Personal Information we hold about you, to port it to a new service, and to ask that your Personal Information be corrected, updated, or erased.
                                </p>
                                
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border-l-4 border-blue-600 mb-6">
                                    <p class="text-gray-800 leading-relaxed font-semibold">
                                        If you would like to exercise these rights, please contact us through the contact information below.
                                    </p>
                                </div>

                                <div class="bg-yellow-50 rounded-xl p-6 border border-yellow-200">
                                    <h3 class="text-sm font-bold text-yellow-900 uppercase tracking-wider mb-3">Data Transfer Notice</h3>
                                    <p class="text-gray-800 leading-relaxed mb-3">
                                        Your Personal Information will be initially processed in Ireland and then will be transferred outside of Europe for storage and further processing, including to Canada and the United States.
                                    </p>
                                    <p class="text-gray-700 text-sm">
                                        For more information on how data transfers comply with the GDPR, see Shopify's GDPR Whitepaper: <a href="https://help.shopify.com/en/manual/your-account/privacy/GDPR" target="_blank" class="text-blue-600 hover:text-blue-800 underline">https://help.shopify.com/en/manual/your-account/privacy/GDPR</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CCPA -->
                    <div id="ccpa" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 mb-4">CCPA (California Consumer Privacy Act)</h2>
                                <p class="text-gray-600 leading-relaxed mb-6">
                                    If you are a resident of California, you have the right to access the Personal Information we hold about you (also known as the <strong>'Right to Know'</strong>), to port it to a new service, and to ask that your Personal Information be corrected, updated, or erased.
                                </p>
                                
                                <div class="space-y-4">
                                    <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-xl p-6 border-l-4 border-red-600">
                                        <p class="text-gray-800 leading-relaxed font-semibold">
                                            If you would like to exercise these rights, please contact us through the contact information below.
                                        </p>
                                    </div>

                                    <div class="bg-orange-50 rounded-xl p-6 border border-orange-200">
                                        <h3 class="text-sm font-bold text-orange-900 uppercase tracking-wider mb-3">Authorized Agent</h3>
                                        <p class="text-gray-800 leading-relaxed">
                                            If you would like to designate an authorized agent to submit these requests on your behalf, please contact us at the address below.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cookies -->
                    <div id="cookies" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 mb-4">Cookies</h2>
                                <p class="text-gray-600 leading-relaxed mb-6">
                                    A cookie is a small amount of information that's downloaded to your computer or device when you visit our Site. We use a number of different cookies, including functional, performance, advertising, and social media or content cookies.
                                </p>
                                
                                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-200 mb-6">
                                    <p class="text-gray-800 leading-relaxed">
                                        Cookies make your browsing experience better by allowing the website to remember your actions and preferences (such as login and region selection). This means you don't have to re-enter this information each time you return to the site or browse from one page to another.
                                    </p>
                                </div>

                                <!-- Cookies Tables -->
                                <div class="space-y-6">
                                    <!-- Necessary Cookies -->
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 mb-4">Cookies Necessary for the Functioning of the Store</h3>
                                        <div class="overflow-x-auto">
                                            <table class="w-full border-collapse">
                                                <thead>
                                                    <tr class="bg-gray-100">
                                                        <th class="px-4 py-3 text-left text-sm font-bold text-gray-900 border border-gray-200">Name</th>
                                                        <th class="px-4 py-3 text-left text-sm font-bold text-gray-900 border border-gray-200">Function</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white">
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">_ab</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Used in connection with access to admin.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">_secure_session_id</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Used in connection with navigation through a storefront.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">cart</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Used in connection with shopping cart.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">cart_sig</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Used in connection with checkout.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">cart_ts</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Used in connection with checkout.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">checkout_token</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Used in connection with checkout.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">secret</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Used in connection with checkout.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">secure_customer_sig</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Used in connection with customer login.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">storefront_digest</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Used in connection with customer login.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">_shopify_u</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Used to facilitate updating customer account information.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Analytics Cookies -->
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 mb-4">Reporting and Analytics</h3>
                                        <div class="overflow-x-auto">
                                            <table class="w-full border-collapse">
                                                <thead>
                                                    <tr class="bg-gray-100">
                                                        <th class="px-4 py-3 text-left text-sm font-bold text-gray-900 border border-gray-200">Name</th>
                                                        <th class="px-4 py-3 text-left text-sm font-bold text-gray-900 border border-gray-200">Function</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white">
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">_tracking_consent</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Tracking preferences.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">_landing_page</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Track landing pages.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">_orig_referrer</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Track landing pages.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">_s</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Shopify analytics.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">_shopify_fs</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Shopify analytics.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">_shopify_s</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Shopify analytics.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">_shopify_sa_p</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Shopify analytics relating to marketing & referrals.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">_shopify_sa_t</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Shopify analytics relating to marketing & referrals.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">_shopify_y</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Shopify analytics.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200 font-mono">_y</td>
                                                        <td class="px-4 py-3 text-sm text-gray-700 border border-gray-200">Shopify analytics.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cookie Management -->
                                <div class="mt-6 space-y-4">
                                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                                        <h3 class="text-sm font-bold text-blue-900 uppercase tracking-wider mb-3">Cookie Duration</h3>
                                        <p class="text-gray-800 leading-relaxed">
                                            The length of time that a cookie remains on your computer or mobile device depends on whether it is a "persistent" or "session" cookie. Session cookies last until you stop browsing and persistent cookies last until they expire or are deleted. Most of the cookies we use are persistent and will expire between 30 minutes and two years from the date they are downloaded to your device.
                                        </p>
                                    </div>

                                    <div class="bg-purple-50 rounded-xl p-6 border border-purple-200">
                                        <h3 class="text-sm font-bold text-purple-900 uppercase tracking-wider mb-3">Managing Cookies</h3>
                                        <p class="text-gray-800 leading-relaxed mb-3">
                                            You can control and manage cookies in various ways. Please keep in mind that removing or blocking cookies can negatively impact your user experience and parts of our website may no longer be fully accessible.
                                        </p>
                                        <p class="text-gray-700 text-sm">
                                            Most browsers automatically accept cookies, but you can choose whether or not to accept cookies through your browser controls, often found in your browser's "Tools" or "Preferences" menu. For more information, visit <a href="http://www.allaboutcookies.org" target="_blank" class="text-purple-600 hover:text-purple-800 underline">www.allaboutcookies.org</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Do Not Track -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 mb-4">Do Not Track</h2>
                                <div class="bg-slate-50 rounded-xl p-6 border-l-4 border-slate-600">
                                    <p class="text-gray-800 leading-relaxed">
                                        Please note that because there is no consistent industry understanding of how to respond to "Do Not Track" signals, we do not alter our data collection and usage practices when we detect such a signal from your browser.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Changes -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-[#e8a598] rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-gray-900 mb-4">Changes to This Privacy Policy</h2>
                                <div class="bg-emerald-50 rounded-xl p-6 border border-emerald-200">
                                    <p class="text-gray-800 leading-relaxed">
                                        We may update this Privacy Policy from time to time in order to reflect, for example, changes to our practices or for other operational, legal, or regulatory reasons.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div id="contact" class="bg-gradient-to-br from-[#e8a598] to-[#d89588] rounded-2xl shadow-lg p-8 scroll-mt-24">
                        <div class="flex items-start space-x-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-black text-white mb-4">Contact Us</h2>
                                <p class="text-gray-300 leading-relaxed mb-6">
                                    For more information about our privacy practices, if you have questions, or if you would like to make a complaint, please contact us:
                                </p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-5 border border-white border-opacity-20">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            <h3 class="text-sm font-bold text-white uppercase tracking-wider">Email</h3>
                                        </div>
                                        <a href="mailto:hello@scentsnsmile.com" class="text-blue-300 hover:text-blue-200 transition-colors">hello@scentsnsmile.com</a>
                                    </div>

                                    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-5 border border-white border-opacity-20">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <h3 class="text-sm font-bold text-white uppercase tracking-wider">Address</h3>
                                        </div>
                                        <p class="text-gray-300 text-sm">Scents N Smile™<br>A/203, Mumbai, Maharashtra 400003</p>
                                    </div>
                                </div>

                                <div class="bg-yellow-500 bg-opacity-20 backdrop-blur-sm rounded-xl p-6 border-l-4 border-yellow-400">
                                    <h3 class="text-sm font-bold text-yellow-300 uppercase tracking-wider mb-3">Data Protection Authority</h3>
                                    <p class="text-gray-300 leading-relaxed mb-3">
                                        If you are not satisfied with our response to your complaint, you have the right to lodge your complaint with the relevant data protection authority.
                                    </p>
                                    <a href="https://ico.org.uk/make-a-complaint/" target="_blank" class="inline-flex items-center text-yellow-300 hover:text-yellow-200 transition-colors">
                                        <span class="mr-2">Contact your local data protection authority</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-4">Have Questions?</h2>
        <p class="text-lg text-gray-600 mb-8">
            Our team is here to help you understand how we protect your privacy.
        </p>
        <a href="{{ route('contact') }}" class="inline-block bg-[#e8a598] hover:bg-[#d89588] text-white font-bold px-8 py-4 rounded-full text-lg transition-colors">
            Contact Us
        </a>
    </div>
</section>

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
