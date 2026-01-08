

<?php $__env->startSection('title', 'Scents N Smile - Holiday Sale'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Slider Section -->
    <section class="relative h-[300px] sm:h-[400px] md:h-[500px] lg:h-[600px] overflow-hidden bg-gray-900">
        <div class="slider-container relative w-full h-full">
            <?php $__empty_1 = true; $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <!-- Slide <?php echo e($index + 1); ?> -->
                <div class="slide <?php echo e($index === 0 ? 'active' : 'opacity-0'); ?> absolute inset-0 transition-opacity duration-1000">
                    <img src="<?php echo e($banner->image); ?>"
                        alt="<?php echo e($banner->title); ?>" 
                        class="w-full h-full object-cover" 
                        loading="<?php echo e($index === 0 ? 'eager' : 'lazy'); ?>">
                    
                    <?php if($banner->title || $banner->subtitle || $banner->button_text): ?>
                        <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                            <div class="text-center text-white px-4 max-w-4xl">
                                <?php if($banner->title): ?>
                                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4"><?php echo e($banner->title); ?></h2>
                                <?php endif; ?>
                                <?php if($banner->subtitle): ?>
                                    <p class="text-lg sm:text-xl md:text-2xl mb-6"><?php echo e($banner->subtitle); ?></p>
                                <?php endif; ?>
                                <?php if($banner->button_text && $banner->link): ?>
                                    <a href="<?php echo e($banner->link); ?>" 
                                       class="inline-block bg-white text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition-all">
                                        <?php echo e($banner->button_text); ?>

                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <!-- Default Slide 1 -->
                <div class="slide active absolute inset-0 transition-opacity duration-1000">
                    <img src="https://images.pexels.com/photos/965989/pexels-photo-965989.jpeg?auto=compress&cs=tinysrgb&w=1920"
                        alt="Luxury Perfume" class="w-full h-full object-cover" loading="eager">
                </div>

                <!-- Default Slide 2 -->
                <div class="slide absolute inset-0 opacity-0 transition-opacity duration-1000">
                    <img src="https://images.pexels.com/photos/1961795/pexels-photo-1961795.jpeg?auto=compress&cs=tinysrgb&w=1920"
                        alt="Elegant Perfume" class="w-full h-full object-cover" loading="lazy">
                </div>

                <!-- Default Slide 3 -->
                <div class="slide absolute inset-0 opacity-0 transition-opacity duration-1000">
                    <img src="https://images.pexels.com/photos/3373736/pexels-photo-3373736.jpeg?auto=compress&cs=tinysrgb&w=1920"
                        alt="Modern Perfume" class="w-full h-full object-cover" loading="lazy">
                </div>

                <!-- Default Slide 4 -->
                <div class="slide absolute inset-0 opacity-0 transition-opacity duration-1000">
                    <img src="https://images.pexels.com/photos/3059609/pexels-photo-3059609.jpeg?auto=compress&cs=tinysrgb&w=1920"
                        alt="Premium Perfume" class="w-full h-full object-cover" loading="lazy">
                </div>
            <?php endif; ?>

            <?php if($banners->count() > 1): ?>
                <!-- Navigation Arrows -->
                <button onclick="changeSlide(-1)" class="absolute left-2 sm:left-4 lg:left-6 top-1/2 -translate-y-1/2 bg-white bg-opacity-70 hover:bg-opacity-90 text-gray-800 p-2 sm:p-3 lg:p-4 rounded-full transition-all duration-300 hover:scale-110 z-10 shadow-lg">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button onclick="changeSlide(1)" class="absolute right-2 sm:right-4 lg:right-6 top-1/2 -translate-y-1/2 bg-white bg-opacity-70 hover:bg-opacity-90 text-gray-800 p-2 sm:p-3 lg:p-4 rounded-full transition-all duration-300 hover:scale-110 z-10 shadow-lg">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <!-- Dots Navigation -->
                <div class="absolute bottom-4 sm:bottom-6 lg:bottom-8 left-1/2 -translate-x-1/2 flex gap-2 sm:gap-3 z-10">
                    <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button onclick="goToSlide(<?php echo e($index); ?>)" class="dot w-2 h-2 sm:w-3 sm:h-3 rounded-full bg-white opacity-50 hover:opacity-100 transition-all duration-300 hover:scale-125"></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>



    <!-- Stats Section -->
    <section class="bg-gray-50 py-6 sm:py-8 md:py-10">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
                <!-- Free Returns -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-gray-900">Free Returns</h3>
                        <p class="text-xs sm:text-sm text-gray-600">no questions asked.</p>
                    </div>
                </div>

                <!-- 6,000,000+ Bottles -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white rounded-lg flex items-center justify-center shadow-sm">
                            <span class="text-2xl sm:text-3xl">🧴</span>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-gray-900">6,000,000+</h3>
                        <p class="text-xs sm:text-sm text-gray-600">Bottles</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">over 6M bottles sold worldwide.</p>
                    </div>
                </div>

                <!-- 100,000+ Reviews -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-gray-900">100,000+</h3>
                        <p class="text-xs sm:text-sm text-gray-600">Reviews</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">over 100,000 5 star reviews.</p>
                    </div>
                </div>

                <!-- Viral fragrance brand -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-gray-900">Viral</h3>
                        <p class="text-xs sm:text-sm text-gray-600">fragrance brand</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">18+ views & dazzling social reviews.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Section -->
    <section class="bg-white px-2 sm:px-4">
        <div class="flex flex-col gap-2 md:grid md:grid-cols-<?php echo e(count($genders ?? []) > 0 ? min(count($genders), 3) : 3); ?>">
            <?php $__empty_1 = true; $__currentLoopData = $genders ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('collections.show', $gender->slug)); ?>" class="relative group cursor-pointer overflow-hidden rounded-2xl aspect-[3/4] md:aspect-[3/4] block">
                <?php if($gender->hasMainImage()): ?>
                    <img src="<?php echo e($gender->getMainImageUrl()); ?>" 
                         alt="<?php echo e($gender->name); ?> Perfumes" 
                         class="absolute inset-0 w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700 ease-out"
                         loading="lazy">
                <?php else: ?>
                    <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-orange-200 via-pink-200 to-purple-300 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                <?php endif; ?>
                <!-- Title at top-left -->
                <div class="absolute top-3 left-3 sm:top-4 sm:left-4 md:top-6 md:left-6 z-10">
                    <h3 class="text-white text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black uppercase tracking-wide drop-shadow-lg"><?php echo e($gender->name); ?></h3>
                </div>
                <!-- Shop button at bottom-left -->
                <div class="absolute bottom-3 left-3 sm:bottom-4 sm:left-4 md:bottom-6 md:left-6 z-10">
                    <span class="bg-white text-black px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-xs sm:text-sm font-bold uppercase tracking-wide shadow-lg hover:bg-gray-100 transition-colors">Shop <?php echo e($gender->name); ?></span>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <!-- Fallback static content if no genders -->
            <a href="<?php echo e(route('collections.show', 'women')); ?>" class="relative group cursor-pointer overflow-hidden rounded-2xl aspect-[3/4] md:aspect-[3/4] block">
                <img src="https://images.pexels.com/photos/3373736/pexels-photo-3373736.jpeg?auto=compress&cs=tinysrgb&w=800" 
                     alt="Women Perfumes" 
                     class="absolute inset-0 w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute top-3 left-3 sm:top-4 sm:left-4 md:top-6 md:left-6 z-10">
                    <h3 class="text-white text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black uppercase tracking-wide drop-shadow-lg">Women</h3>
                </div>
                <div class="absolute bottom-3 left-3 sm:bottom-4 sm:left-4 md:bottom-6 md:left-6 z-10">
                    <span class="bg-white text-black px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-xs sm:text-sm font-bold uppercase tracking-wide shadow-lg hover:bg-gray-100 transition-colors">Shop Women</span>
                </div>
            </a>
            <a href="<?php echo e(route('collections.show', 'men')); ?>" class="relative group cursor-pointer overflow-hidden rounded-2xl aspect-[3/4] md:aspect-[3/4] block">
                <img src="https://images.pexels.com/photos/3059609/pexels-photo-3059609.jpeg?auto=compress&cs=tinysrgb&w=800" 
                     alt="Men Perfumes" 
                     class="absolute inset-0 w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute top-3 left-3 sm:top-4 sm:left-4 md:top-6 md:left-6 z-10">
                    <h3 class="text-white text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black uppercase tracking-wide drop-shadow-lg">Men</h3>
                </div>
                <div class="absolute bottom-3 left-3 sm:bottom-4 sm:left-4 md:bottom-6 md:left-6 z-10">
                    <span class="bg-white text-black px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-xs sm:text-sm font-bold uppercase tracking-wide shadow-lg hover:bg-gray-100 transition-colors">Shop Men</span>
                </div>
            </a>
            <a href="<?php echo e(route('collections.show', 'unisex')); ?>" class="relative group cursor-pointer overflow-hidden rounded-2xl aspect-[3/4] md:aspect-[3/4] block">
                <img src="https://images.pexels.com/photos/1961795/pexels-photo-1961795.jpeg?auto=compress&cs=tinysrgb&w=800" 
                     alt="Unisex Perfumes" 
                     class="absolute inset-0 w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-700 ease-out">
                <div class="absolute top-3 left-3 sm:top-4 sm:left-4 md:top-6 md:left-6 z-10">
                    <h3 class="text-white text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black uppercase tracking-wide drop-shadow-lg">Unisex</h3>
                </div>
                <div class="absolute bottom-3 left-3 sm:bottom-4 sm:left-4 md:bottom-6 md:left-6 z-10">
                    <span class="bg-white text-black px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-xs sm:text-sm font-bold uppercase tracking-wide shadow-lg hover:bg-gray-100 transition-colors">Shop Unisex</span>
                </div>
            </a>
            <?php endif; ?>
        </div>
    </section>



    <!-- Best Sellers Section -->
    <section class="py-12 sm:py-16 bg-white">
        <div class="px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900">
                    Our <span class="text-[#e8a598]">Best Sellers</span>
                </h2>
            </div>

            <!-- Products Grid -->
            <?php if($bestSellers->count() > 0): ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
                <?php $__currentLoopData = $bestSellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <!-- View All Products Button -->
            <div class="flex justify-center mt-8">
                <a href="<?php echo e(route('collections.show', 'bestsellers')); ?>" 
                   class="inline-flex items-center gap-2 px-8 py-4 bg-[#F27F6E] text-white rounded-full font-semibold hover:bg-[#e06b5a] transition-all duration-200 shadow-lg hover:shadow-xl">
                    <span>View All Products</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
            <?php else: ?>
            <div class="text-center py-12 bg-gray-50 rounded-xl">
                <p class="text-gray-500">No bestseller products available yet.</p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- New Arrivals Section -->
    <section class="py-12 sm:py-16 bg-[#FAF8F5]">
        <div class="px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900">
                    New <span class="text-[#F27F6E]">Arrivals</span>
                </h2>
                <a href="<?php echo e(route('collections')); ?>" class="text-sm text-[#F27F6E] hover:underline font-medium">
                    View All →
                </a>
            </div>

            <!-- Products Grid -->
            <?php if($newArrivals->count() > 0): ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
                <?php $__currentLoopData = $newArrivals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
            <div class="text-center py-12 bg-white rounded-xl">
                <p class="text-gray-500">No new arrival products available yet.</p>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-12 sm:py-16 lg:py-20" style="background-color: #f5e6e0;">
        <div class="max-w-7xl mx-auto px-4">
            <div class="relative">
                <!-- Testimonials Slider -->
                <div class="overflow-hidden">
                    <div id="testimonialsTrack" class="flex gap-4 sm:gap-6 transition-transform duration-500 ease-out">
                        <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <!-- Testimonial <?php echo e($loop->iteration); ?> -->
                            <div class="flex-shrink-0 w-[280px] sm:w-[320px] bg-black text-white rounded-2xl p-6 border-2 border-red-500">
                                <div class="flex gap-1 mb-4">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php if($i <= $testimonial->rating): ?>
                                            <span class="text-yellow-400">★</span>
                                        <?php else: ?>
                                            <span class="text-gray-500">★</span>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <p class="text-sm leading-relaxed"><?php echo e($testimonial->review_text); ?></p>
                                <?php if($testimonial->customer_name): ?>
                                    <p class="text-xs text-gray-400 mt-4 font-semibold">- <?php echo e($testimonial->customer_name); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <!-- Default Testimonial 1 -->
                            <div class="flex-shrink-0 w-[280px] sm:w-[320px] bg-black text-white rounded-2xl p-6 border-2 border-red-500">
                                <div class="flex gap-1 mb-4">
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                </div>
                                <p class="text-sm leading-relaxed">Amazing fragrance! I get compliments everywhere I go. The scent lasts all day and smells exactly like the designer version. Best purchase ever!</p>
                            </div>

                            <!-- Default Testimonial 2 -->
                            <div class="flex-shrink-0 w-[280px] sm:w-[320px] bg-black text-white rounded-2xl p-6 border-2 border-red-500">
                                <div class="flex gap-1 mb-4">
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                </div>
                                <p class="text-sm leading-relaxed">I was skeptical at first, but this perfume exceeded my expectations. The quality is incredible for the price. Will definitely buy more!</p>
                            </div>

                            <!-- Default Testimonial 3 -->
                            <div class="flex-shrink-0 w-[280px] sm:w-[320px] bg-black text-white rounded-2xl p-6 border-2 border-red-500">
                                <div class="flex gap-1 mb-4">
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                </div>
                                <p class="text-sm leading-relaxed">Finally found my signature scent! The fragrance is long-lasting and the packaging is beautiful. Perfect gift for anyone who loves perfumes.</p>
                            </div>

                            <!-- Default Testimonial 4 -->
                            <div class="flex-shrink-0 w-[280px] sm:w-[320px] bg-black text-white rounded-2xl p-6 border-2 border-red-500">
                                <div class="flex gap-1 mb-4">
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                </div>
                                <p class="text-sm leading-relaxed">Love the variety of scents available. Each one is unique and high quality. Fast shipping and excellent customer service too!</p>
                            </div>

                            <!-- Default Testimonial 5 -->
                            <div class="flex-shrink-0 w-[280px] sm:w-[320px] bg-black text-white rounded-2xl p-6 border-2 border-red-500">
                                <div class="flex gap-1 mb-4">
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-yellow-400">★</span>
                                </div>
                                <p class="text-sm leading-relaxed">These perfumes are absolutely divine! The scent projection is amazing and I always get asked what I'm wearing. Highly recommend!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <div class="flex justify-end gap-3 mt-6">
                    <button onclick="slideTestimonials('prev')" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white border-2 border-red-500 flex items-center justify-center hover:bg-red-50 transition">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button onclick="slideTestimonials('next')" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white border-2 border-red-500 flex items-center justify-center hover:bg-red-50 transition">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Heading Section -->
            <div class="text-center mt-16 sm:mt-20 lg:mt-24">
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black mb-4 sm:mb-6" style="color: #b91c1c;">
                    1,00,000+ CUSTOMERS LOVE US
                </h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-700 max-w-2xl mx-auto">
                    We asked our customers about their<br class="hidden sm:block">
                    fragrance experience. Here's what they said...
                </p>
            </div>
        </div>
    </section>

    <!-- Brand Story Section -->
    <section class="py-12 sm:py-16 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-gray-50 rounded-3xl p-8 sm:p-12 lg:p-16">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <!-- Left Column -->
                    <div>
                        <p class="text-xs sm:text-sm uppercase tracking-wider text-gray-600 mb-4">LUXURY INSPIRED BY PERFUMES</p>
                        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black mb-6 lg:mb-8 leading-tight">
                            SCENTS N SMILE<br>
                            <span class="font-light italic">Fragrances</span>
                        </h2>
                        <button class="inline-flex items-center gap-2 px-6 py-3 border-2 border-red-500 text-red-500 rounded-full font-medium hover:bg-red-50 transition">
                            Find your perfect scent
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <p class="text-sm sm:text-base leading-relaxed text-gray-700">
                            Welcome to Scents N Smile, where luxury meets affordability. Our mission is to provide high-quality, designer-inspired scents at a fraction of the cost. Embrace the essence of opulence with our exquisite range of perfumes for both men and women, crafted from premium ingredients and designed to offer long-lasting, captivating aromas. With a commitment to sustainability and cruelty-free practices, Scents N Smile allows you to enjoy a sophisticated fragrance experience while being mindful of the environment. Discover your signature scent today and elevate your fragrance game effortlessly.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tabbed Section -->
    <section class="py-12 sm:py-16 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Tab Content -->
            <div class="mb-8">
                <!-- Story Tab Content -->
                <div id="storyTab" class="tab-content">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                        <!-- Left - Image -->
                        <div class="bg-gray-100 rounded-3xl overflow-hidden h-[300px] sm:h-[350px] lg:h-[400px]">
                            <img src="https://images.pexels.com/photos/965989/pexels-photo-965989.jpeg?auto=compress&cs=tinysrgb&w=800" 
                                 alt="Scents N Smile Story" 
                                 class="w-full h-full object-cover">
                        </div>
                        <!-- Right - Text -->
                        <div class="flex flex-col justify-center">
                            <p class="text-xs uppercase tracking-wider text-gray-500 mb-3">STORY</p>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-black mb-6">SCENTS N SMILE</h3>
                            <p class="text-sm sm:text-base text-gray-700 leading-relaxed">
                                At Scents N Smile, we believe that fragrance is a powerful form of self-expression. Our fragrances capture the distinctive characteristics of your personality. Each fragrance is designed to tell a story that resonates with your individuality and serves as a signature for your personal journey. With Scents N Smile, you're not just choosing a fragrance – you're discovering a fragrance that speaks to who you are.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quality Tab Content -->
                <div id="qualityTab" class="tab-content hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                        <!-- Left - Image -->
                        <div class="bg-gray-100 rounded-3xl overflow-hidden h-[300px] sm:h-[350px] lg:h-[400px]">
                            <img src="https://images.pexels.com/photos/3373736/pexels-photo-3373736.jpeg?auto=compress&cs=tinysrgb&w=800" 
                                 alt="Quality" 
                                 class="w-full h-full object-cover">
                        </div>
                        <!-- Right - Text -->
                        <div class="flex flex-col justify-center">
                            <p class="text-xs uppercase tracking-wider text-gray-400 mb-3">QUALITY</p>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-light text-gray-400 mb-6">A better way to enjoy fragrance</h3>
                            <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                                We believe fragrance should be accessible without compromising on quality. Our perfumes are crafted with premium ingredients and designed to offer long-lasting, captivating aromas that rival luxury brands at a fraction of the cost.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Sustainability Tab Content -->
                <div id="sustainabilityTab" class="tab-content hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                        <!-- Left - Image -->
                        <div class="bg-gray-100 rounded-3xl overflow-hidden h-[300px] sm:h-[350px] lg:h-[400px]">
                            <img src="https://images.pexels.com/photos/1961795/pexels-photo-1961795.jpeg?auto=compress&cs=tinysrgb&w=800" 
                                 alt="Sustainability" 
                                 class="w-full h-full object-cover">
                        </div>
                        <!-- Right - Text -->
                        <div class="flex flex-col justify-center">
                            <p class="text-xs uppercase tracking-wider text-gray-500 mb-3">SUSTAINABILITY</p>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-black mb-6">Eco-Friendly</h3>
                            <p class="text-sm sm:text-base text-gray-700 leading-relaxed">
                                With a commitment to sustainability and cruelty-free practices, Scents N Smile allows you to enjoy a sophisticated fragrance experience while being mindful of the environment. We use eco-friendly packaging and sustainable sourcing to minimize our environmental impact.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="border-t border-gray-200 pt-6">
                <div class="flex justify-center gap-8 sm:gap-12 lg:gap-16">
                    <button onclick="switchTab('story')" id="storyTabBtn" class="tab-btn text-sm sm:text-base uppercase tracking-wider font-bold text-gray-900 pb-2 border-b-2 border-gray-900 transition">
                        STORY
                    </button>
                    <button onclick="switchTab('quality')" id="qualityTabBtn" class="tab-btn text-sm sm:text-base uppercase tracking-wider text-gray-400 hover:text-gray-600 pb-2 border-b-2 border-transparent transition">
                        QUALITY
                    </button>
                    <button onclick="switchTab('sustainability')" id="sustainabilityTabBtn" class="tab-btn text-sm sm:text-base uppercase tracking-wider text-gray-400 hover:text-gray-600 pb-2 border-b-2 border-transparent transition">
                        SUSTAINABILITY
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-12 sm:py-16 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                <!-- Feature 1 - Smells Like the Original -->
                <div class="text-center">
                    <div class="flex justify-center mb-3">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold mb-2">Smells Like the Original</h3>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Smells like your favorite designer fragrances. Our perfumes give you the same luxury experience at a price you'll love.
                    </p>
                </div>

                <!-- Feature 2 - Luxury for Less -->
                <div class="text-center">
                    <div class="flex justify-center mb-3">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold mb-2">Luxury for Less</h3>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Feel chic and luxurious without overspending. Our perfumes are just as long-lasting and elegant as top brands, but much more affordable.
                    </p>
                </div>

                <!-- Feature 3 - Long Lasting -->
                <div class="text-center">
                    <div class="flex justify-center mb-3">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold mb-2">Long Lasting</h3>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Our perfumes are made to last all day. With our high-quality, vegan formulas, you'll stay fresh and confident from morning till night, no matter what your day holds.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-8 sm:py-12 lg:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8 sm:mb-12">Featured Perfumes</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="group">
                        <div class="relative overflow-hidden rounded-lg mb-2 sm:mb-4 aspect-square bg-gray-100">
                            <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="block w-full h-full">
                                <?php if($product->image_url): ?>
                                    <img src="<?php echo e($product->image_url); ?>" 
                                         alt="<?php echo e($product->name); ?>" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-100 to-pink-100">
                                        <span class="text-6xl">🌸</span>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <!-- Add to Cart Button (shows on hover) - OUTSIDE the link -->
                            <div class="absolute bottom-0 left-0 right-0 p-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-20">
                                <button type="button" data-add-to-cart="<?php echo e($product->id); ?>" class="w-full py-2 bg-white/95 border border-[#e8a598] text-[#e8a598] rounded-lg font-medium text-xs hover:bg-[#e8a598] hover:text-white transition-colors duration-200">
                                    ADD TO CART
                                </button>
                            </div>
                        </div>
                        
                        <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="block">
                            <?php if($product->tagsList && $product->tagsList->count() > 0): ?>
                                <div class="flex gap-1 sm:gap-2 mb-1 sm:mb-2 flex-wrap">
                                    <?php $__currentLoopData = $product->tagsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="text-[10px] sm:text-xs px-1.5 sm:px-2 py-0.5 sm:py-1 bg-gray-100 rounded-full text-gray-700">
                                            <?php echo e($tag->name); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                            
                            <h3 class="text-sm sm:text-base lg:text-lg font-semibold mb-1 sm:mb-2 text-gray-900 line-clamp-2"><?php echo e($product->name); ?></h3>
                            
                            <div class="flex items-center gap-1 sm:gap-2 flex-wrap">
                                <?php if($product->sale_price && $product->sale_price < $product->price): ?>
                                    <span class="text-base sm:text-lg lg:text-xl font-bold text-black">₹<?php echo e(number_format($product->sale_price, 2)); ?></span>
                                    <span class="text-xs sm:text-sm text-gray-500 line-through">₹<?php echo e(number_format($product->price, 2)); ?></span>
                                <?php else: ?>
                                    <span class="text-base sm:text-lg lg:text-xl font-bold text-black">₹<?php echo e(number_format($product->price, 2)); ?></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full text-center py-8 sm:py-12">
                        <p class="text-sm sm:text-base text-gray-500">No products available at the moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Make Every Moment Special Section -->
    <?php if($moments->count() > 0): ?>
    <section class="py-8 sm:py-12 bg-gradient-to-b from-pink-50 to-white overflow-hidden">
        <div class="mx-auto px-4">
            <!-- Heading -->
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-center mb-8 sm:mb-12" style="color: #8B1538;">
                MAKE EVERY MOMENT SPECIAL
            </h2>

            <!-- Carousel Container -->
            <div class="relative">
                <!-- Carousel Track -->
                <div class="overflow-hidden">
                    <div id="momentsCarousel" class="flex gap-6 sm:gap-8 md:gap-12 transition-transform duration-1000 ease-linear">
                        <?php $__currentLoopData = $moments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <!-- Moment Item -->
                            <a href="<?php echo e(route('collections.show', $moment->slug)); ?>" 
                               class="flex-shrink-0 flex flex-col items-center justify-center w-24 sm:w-28 md:w-32 lg:w-36 group cursor-pointer">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 mb-3 sm:mb-4 transition-transform duration-300 group-hover:scale-110 rounded-full overflow-hidden shadow-lg">
                                    <?php if($moment->hasImageKitImage()): ?>
                                        <img src="<?php echo e($moment->getOptimizedImageUrl(200, 200, 90)); ?>" 
                                             alt="<?php echo e($moment->name); ?>" 
                                             class="w-full h-full object-cover"
                                             loading="lazy">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-gradient-to-br from-pink-200 to-purple-200 flex items-center justify-center">
                                            <span class="text-3xl sm:text-4xl">🎉</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p class="text-xs sm:text-sm md:text-base font-semibold text-gray-800 text-center uppercase tracking-wide group-hover:text-[#8B1538] transition-colors">
                                    <?php echo e($moment->name); ?>

                                </p>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        <!-- Duplicate items for seamless loop -->
                        <?php $__currentLoopData = $moments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('collections.show', $moment->slug)); ?>" 
                               class="flex-shrink-0 flex flex-col items-center justify-center w-24 sm:w-28 md:w-32 lg:w-36 group cursor-pointer">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 mb-3 sm:mb-4 transition-transform duration-300 group-hover:scale-110 rounded-full overflow-hidden shadow-lg">
                                    <?php if($moment->hasImageKitImage()): ?>
                                        <img src="<?php echo e($moment->getOptimizedImageUrl(200, 200, 90)); ?>" 
                                             alt="<?php echo e($moment->name); ?>" 
                                             class="w-full h-full object-cover"
                                             loading="lazy">
                                    <?php else: ?>
                                        <div class="w-full h-full bg-gradient-to-br from-pink-200 to-purple-200 flex items-center justify-center">
                                            <span class="text-3xl sm:text-4xl">🎉</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p class="text-xs sm:text-sm md:text-base font-semibold text-gray-800 text-center uppercase tracking-wide group-hover:text-[#8B1538] transition-colors">
                                    <?php echo e($moment->name); ?>

                                </p>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Auto-sliding moments carousel
        (function() {
            const carousel = document.getElementById('momentsCarousel');
            if (!carousel) return;

            const items = carousel.children;
            const totalItems = items.length / 2; // Half are duplicates
            let currentPosition = 0;
            const speed = 0.5; // pixels per frame
            let animationId;

            function animate() {
                currentPosition += speed;
                
                // Calculate the width of one set of items
                let singleSetWidth = 0;
                for (let i = 0; i < totalItems; i++) {
                    singleSetWidth += items[i].offsetWidth;
                    // Add gap (48px for gap-12 on large screens, adjust based on screen size)
                    const gap = window.innerWidth >= 768 ? 48 : (window.innerWidth >= 640 ? 32 : 24);
                    singleSetWidth += gap;
                }

                // Reset position when first set is completely scrolled
                if (currentPosition >= singleSetWidth) {
                    currentPosition = 0;
                }

                carousel.style.transform = `translateX(-${currentPosition}px)`;
                animationId = requestAnimationFrame(animate);
            }

            // Start animation
            animate();

            // Pause on hover
            carousel.addEventListener('mouseenter', () => {
                cancelAnimationFrame(animationId);
            });

            carousel.addEventListener('mouseleave', () => {
                animate();
            });
        })();
    </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Event delegation for Add to Cart buttons
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('[data-add-to-cart]');
        if (btn) {
            e.preventDefault();
            e.stopPropagation();
            const productId = btn.getAttribute('data-add-to-cart');
            if (productId && window.addToCart) {
                window.addToCart(parseInt(productId));
            }
        }
    }, true);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/home.blade.php ENDPATH**/ ?>