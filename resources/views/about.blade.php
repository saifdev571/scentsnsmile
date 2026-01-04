@extends('layouts.app')

@section('title', 'About Us - Scents N Smile')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section class="pt-32 pb-16 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-5xl md:text-7xl font-black mb-8 tracking-tight">About Us</h1>
        </div>
    </section>

    <!-- Creative Lab Section -->
    <section class="py-12 px-4 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-12">An Inside Look at our Creative Lab.</h2>
            
            <!-- Awards/Achievements Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-16">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-lg font-semibold text-gray-800">Premium Quality Fragrances at Affordable Prices</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-lg font-semibold text-gray-800">Trusted by Thousands of Happy Customers</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-lg font-semibold text-gray-800">100% Vegan & Cruelty-Free Products</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-lg font-semibold text-gray-800">Inspired by World's Best Designer Fragrances</p>
                </div>
            </div>

            <a href="{{ route('collections') }}" class="inline-block bg-[#e8a598] hover:bg-[#d89588] text-white font-bold px-8 py-4 rounded-full text-lg transition-colors">
                Explore Our Products
            </a>
        </div>
    </section>

    <!-- About Our Impressions Section -->
    <section class="py-20 px-4 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Image -->
                <div class="relative">
                    <div class="aspect-square bg-gradient-to-br from-[#e8a598] to-[#d89588] rounded-3xl overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?w=800" 
                             alt="Perfume Collection" 
                             class="w-full h-full object-cover opacity-90">
                    </div>
                </div>

                <!-- Content -->
                <div>
                    <h2 class="text-4xl font-black mb-6">About Our Impressions</h2>
                    <p class="text-xl font-semibold text-gray-800 mb-8">Luxury scents inspired by designer brands, no excessive markups.</p>
                    
                    <!-- Features -->
                    <div class="space-y-4 mb-8">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#e8a598] rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-lg font-medium">Premium Quality Ingredients</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#e8a598] rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-lg font-medium">Vegan & Cruelty-Free</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#e8a598] rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-lg font-medium">70%-90% less than designer brands</span>
                        </div>
                    </div>

                    <p class="text-gray-600 leading-relaxed mb-8">
                        Scents N Smile offers an ever-growing selection of designer-inspired fragrances based on customer insights. Enjoy the luxurious experience of your favorite scents minus the brand tax.
                    </p>

                    <a href="{{ route('collections') }}" class="inline-block bg-gray-900 hover:bg-gray-800 text-white font-bold px-8 py-3 rounded-full transition-colors">
                        Shop Scents N Smile
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- What We Stand For Section -->
    <section class="py-20 px-4 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl md:text-5xl font-black text-center mb-16">What we stand for</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Craftsmanship -->
                <div class="bg-white p-8 rounded-2xl shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 bg-[#e8a598] rounded-full"></div>
                        <h3 class="text-2xl font-bold">Craftsmanship.</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        We never cut corners, just the markups necessary to offer the highest quality products for less. Pay for luxurious products, not a prestige tax. With every bottle of Scents N Smile purchased, you're guaranteed to receive the highest-quality perfume crafted with care and precision.
                    </p>
                </div>

                <!-- Transparency -->
                <div class="bg-white p-8 rounded-2xl shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 bg-[#e8a598] rounded-full"></div>
                        <h3 class="text-2xl font-bold">Transparency.</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        We offer straightforward information, so customers can make an informed choice when purchasing our products. Scents N Smile offers transparent information on everything you want to know from sharing details on how we source ingredients to our upfront approach to pricing. No smoke and mirrors necessary.
                    </p>
                </div>

                <!-- Perfume for All -->
                <div class="bg-white p-8 rounded-2xl shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 bg-[#e8a598] rounded-full"></div>
                        <h3 class="text-2xl font-bold">Perfume for all.</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        In an industry that notoriously feeds on insecurities and profits from making us feel like we lack something only they can supply, we won't dictate trends or tell you which scents are best for you. Try the scents that ignite your senses and make your own rules.
                    </p>
                </div>

                <!-- Clean -->
                <div class="bg-white p-8 rounded-2xl shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-3 h-3 bg-[#e8a598] rounded-full"></div>
                        <h3 class="text-2xl font-bold">Clean.</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        We follow strict cosmetic safety recommendations to ensure all our products are formulated using ethical and sustainable practices and are sourced from the highest quality ingredients. Our fragrances are 100% non-toxic, cruelty-free, vegan, and eco-friendly, so that you can indulge guilt-free.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 px-4 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-[#e8a598] rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-black text-white">1</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Order.</h3>
                    <p class="text-gray-600">Browse our collection and place your order with ease.</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-[#e8a598] rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-black text-white">2</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Try.</h3>
                    <p class="text-gray-600">Experience the luxury of premium fragrances at home.</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-[#e8a598] rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-black text-white">3</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Decide.</h3>
                    <p class="text-gray-600">Love it or return it. Your satisfaction is guaranteed.</p>
                </div>
            </div>

            <p class="text-center text-sm text-gray-500 max-w-3xl mx-auto">
                **Note: All accepted returns will receive a full refund of the purchase price. Return shipping included. Returns must be postmarked within 30 days of the initial order.
            </p>
        </div>
    </section>

    <!-- Origins Section -->
    <section class="py-20 px-4 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl md:text-5xl font-black text-center mb-16">Origins of the Scents N Smile perfume house.</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div>
                    <h3 class="text-2xl font-bold mb-6">Rethinking the fragrance industry became a reality.</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Scents N Smile was founded to make premium fragrances accessible to everyone. We saw how a lack of transparency and excessive markups plagued the fragrance industry. So, we established our fair-priced perfumery with a mission to bring luxury scents to all.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        All Scents N Smile fragrances are crafted with the finest ingredients and inspired by the world's most beloved designer scents. We believe everyone deserves to smell amazing without breaking the bank.
                    </p>
                </div>

                <!-- Images Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="aspect-square bg-gray-200 rounded-2xl overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1594035910387-fea47794261f?w=400" 
                             alt="Perfume Making" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="aspect-square bg-gray-200 rounded-2xl overflow-hidden mt-8">
                        <img src="https://images.unsplash.com/photo-1615634260167-c8cdede054de?w=400" 
                             alt="Ingredients" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="aspect-square bg-gray-200 rounded-2xl overflow-hidden -mt-8">
                        <img src="https://images.unsplash.com/photo-1587017539504-67cfbddac569?w=400" 
                             alt="Perfume Bottles" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="aspect-square bg-gray-200 rounded-2xl overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?w=400" 
                             alt="Fragrance Collection" 
                             class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 bg-[#e8a598]">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">Ready to find your signature scent?</h2>
            <p class="text-xl text-white/90 mb-8">Explore our collection of premium fragrances today.</p>
            <a href="{{ route('collections') }}" class="inline-block bg-white hover:bg-gray-100 text-gray-900 font-bold px-10 py-4 rounded-full text-lg transition-colors">
                Shop Now
            </a>
        </div>
    </section>
</div>
@endsection
