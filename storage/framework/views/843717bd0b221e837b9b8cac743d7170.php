<!-- Top Bar - Promotion Banner (Dynamic) - Hide on home page -->
<?php if(isset($headerPromotion) && $headerPromotion && !request()->routeIs('home')): ?>
    <div class="fixed top-0 left-0 right-0 z-[51] px-2 pt-1.5">
        <div class="text-white rounded-full mx-auto max-w-7xl"
            style="background-color: <?php echo e($headerPromotion->badge_color ?? '#000000'); ?>">
            <div class="px-4 py-1.5">
                <div class="flex items-center justify-between text-xs">
                    <!-- Left - Sale Name -->
                    <div class="flex items-center gap-2">
                        <span
                            class="font-black uppercase tracking-wider text-sm"><?php echo e($headerPromotion->banner_title ?? $headerPromotion->name); ?></span>
                    </div>

                    <!-- Center - Offers -->
                    <div class="hidden md:flex items-center gap-4 lg:gap-6">
                        <?php if($headerPromotion->discount_value > 0): ?>
                            <div class="flex items-center gap-1.5">
                                <span
                                    class="bg-white rounded-full w-5 h-5 flex items-center justify-center font-bold text-[10px]"
                                    style="color: <?php echo e($headerPromotion->badge_color ?? '#000000'); ?>"><?php echo e($headerPromotion->min_items); ?></span>
                                <span class="font-medium text-xs">Items <?php echo e($headerPromotion->discount_text); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if($headerPromotion->free_shipping): ?>
                            <div class="w-px h-4 bg-white/30"></div>
                            <div class="flex items-center gap-1.5">
                                <span
                                    class="bg-white rounded-full w-5 h-5 flex items-center justify-center font-bold text-[10px]"
                                    style="color: <?php echo e($headerPromotion->badge_color ?? '#000000'); ?>"><?php echo e($headerPromotion->free_shipping_min_items ?? 3); ?></span>
                                <span class="font-medium text-xs">Items Free shipping</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Right - Info Icon -->
                    <button class="hover:opacity-75 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2" />
                            <path d="M12 16v-4m0-4h.01" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
    $hasPromoBanner = isset($headerPromotion) && $headerPromotion && !request()->routeIs('home');
?>

<!-- Header Navigation -->
<header id="header"
    class="fixed <?php echo e($hasPromoBanner ? 'top-10 md:top-12' : 'top-2'); ?> left-0 right-0 z-50 bg-transparent">
    <div class="mx-auto px-2 sm:px-4 py-1.5 md:py-2">
        <div class="flex items-center justify-between">
            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn"
                class="lg:hidden p-1.5 bg-white bg-opacity-90 text-gray-800 rounded-full backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Left Navigation - Hidden on mobile -->
            <div class="hidden lg:flex items-center gap-2 flex-1 justify-start">
                <!-- Categories Dropdown (Refactored to match About style) -->
                <div class="relative group">
                    <button id="categoriesBtn"
                        class="nav-button flex items-center gap-1 xl:gap-2 px-3 py-1.5 bg-white bg-opacity-90 text-gray-800 rounded-full text-xs font-medium hover:bg-opacity-100 backdrop-blur-sm">
                        CATEGORIES
                        <svg class="w-3 xl:w-4 h-3 xl:h-4 transition-transform group-hover:rotate-180"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>

                    <!-- Categories Dropdown Menu -->
                    <div
                        class="absolute top-full left-0 mt-2 w-80 bg-[#f5e6d3] rounded-2xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden z-50 max-h-[80vh] overflow-y-auto">
                        <div class="p-4 text-left">
                            <!-- Shop All Perfumes -->
                            <a href="<?php echo e(route('collections')); ?>"
                                class="block bg-white rounded-xl p-3 mb-4 flex items-center gap-3 hover:shadow-md transition-all">
                                <div class="w-14 h-14 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-gray-900">Shop All Perfumes</h3>
                            </a>

                            <!-- Shop by Category -->
                            <?php if(isset($categories) && $categories->count() > 0): ?>
                                <div class="mb-4">
                                    <h3 class="text-[10px] font-bold text-gray-900 uppercase tracking-wide mb-2 pl-1">SHOP
                                        BY CATEGORY</h3>
                                    <div class="bg-white rounded-xl overflow-hidden p-1">
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e(route('collections.show', $category->slug)); ?>"
                                                class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                                <?php if($category->imagekit_url): ?>
                                                    <img src="<?php echo e($category->imagekit_thumbnail_url ?? $category->imagekit_url); ?>"
                                                        alt="<?php echo e($category->name); ?>" class="w-10 h-10 rounded-lg object-cover"
                                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                    <div
                                                        class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-100 to-indigo-100 items-center justify-center hidden">
                                                        <span
                                                            class="text-xs font-bold text-blue-600"><?php echo e(substr($category->name, 0, 1)); ?></span>
                                                    </div>
                                                <?php else: ?>
                                                    <div
                                                        class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                                                        <span
                                                            class="text-xs font-bold text-blue-600"><?php echo e(substr($category->name, 0, 1)); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <span class="text-sm font-medium text-gray-800"><?php echo e($category->name); ?></span>
                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Shop by Gender -->
                            <div class="mb-4">
                                <h3 class="text-[10px] font-bold text-gray-900 uppercase tracking-wide mb-2 pl-1">SHOP
                                    BY GENDER</h3>
                                <div class="bg-white rounded-xl overflow-hidden p-1">
                                    <?php $__empty_1 = true; $__currentLoopData = $genders ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <a href="<?php echo e(route('collections.show', $gender->slug)); ?>"
                                            class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                            <?php if($gender->imagekit_url): ?>
                                                <img src="<?php echo e($gender->imagekit_thumbnail_url ?? $gender->imagekit_url); ?>"
                                                    alt="<?php echo e($gender->name); ?>" class="w-10 h-10 rounded-lg object-cover"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-gray-200 items-center justify-center hidden">
                                                    <span
                                                        class="text-xs font-bold text-gray-500"><?php echo e(substr($gender->name, 0, 1)); ?></span>
                                                </div>
                                            <?php else: ?>
                                                <div class="w-10 h-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <span
                                                        class="text-xs font-bold text-gray-500"><?php echo e(substr($gender->name, 0, 1)); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <span class="text-sm font-medium text-gray-800"><?php echo e($gender->name); ?></span>
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <!-- No fallback placeholders -->
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- More Ways to Shop -->
                            <div class="mb-4">
                                <h3 class="text-[10px] font-bold text-gray-900 uppercase tracking-wide mb-2 pl-1">MORE
                                    WAYS TO SHOP</h3>
                                <div class="bg-white rounded-xl overflow-hidden p-1">
                                    <?php $__empty_1 = true; $__currentLoopData = $featuredTags ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <a href="<?php echo e(route('collections.show', $tag->slug)); ?>"
                                            class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                            <?php if($tag->imagekit_url): ?>
                                                <img src="<?php echo e($tag->imagekit_thumbnail_url ?? $tag->imagekit_url); ?>"
                                                    alt="<?php echo e($tag->name); ?>" class="w-10 h-10 rounded-lg object-cover"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                <div class="w-10 h-10 rounded-lg items-center justify-center hidden"
                                                    style="background-color: <?php echo e($tag->color ?? '#3B82F6'); ?>20; border: 2px solid <?php echo e($tag->color ?? '#3B82F6'); ?>;">
                                                    <span class="text-xs font-bold"
                                                        style="color: <?php echo e($tag->color ?? '#3B82F6'); ?>;">
                                                        <?php echo e(substr($tag->name, 0, 1)); ?>

                                                    </span>
                                                </div>
                                            <?php else: ?>
                                                <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                                                    style="background-color: <?php echo e($tag->color ?? '#3B82F6'); ?>20; border: 2px solid <?php echo e($tag->color ?? '#3B82F6'); ?>;">
                                                    <span class="text-xs font-bold"
                                                        style="color: <?php echo e($tag->color ?? '#3B82F6'); ?>;">
                                                        <?php echo e(substr($tag->name, 0, 1)); ?>

                                                    </span>
                                                </div>
                                            <?php endif; ?>
                                            <span class="text-sm font-medium text-gray-800"><?php echo e($tag->name); ?></span>
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <a href="#"
                                            class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                            <img src="https://via.placeholder.com/60" alt="Bestsellers"
                                                class="w-10 h-10 rounded-lg object-cover">
                                            <span class="text-sm font-medium text-gray-800">Bestsellers</span>
                                        </a>
                                        <a href="#"
                                            class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                            <img src="https://via.placeholder.com/60" alt="New Arrivals"
                                                class="w-10 h-10 rounded-lg object-cover">
                                            <span class="text-sm font-medium text-gray-800">New Arrivals</span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Discover -->
                            <div>
                                <h3 class="text-[10px] font-bold text-gray-900 uppercase tracking-wide mb-2 pl-1">
                                    DISCOVER</h3>
                                <div class="bg-white rounded-xl overflow-hidden p-1">
                                    <!-- Scent Families Link (Fixed) -->
                                    <a href="<?php echo e(route('scent-families')); ?>"
                                        class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                        <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                                            <span class="text-lg">🌸</span>
                                        </div>
                                        <span class="text-sm font-medium text-gray-800">Scent Families</span>
                                    </a>

                                    <?php $__empty_1 = true; $__currentLoopData = $featuredCollections ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <a href="<?php echo e(route('collections.show', $collection->slug)); ?>"
                                            class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                            <?php if($collection->imagekit_url): ?>
                                                <img src="<?php echo e($collection->imagekit_thumbnail_url ?? $collection->imagekit_url); ?>"
                                                    alt="<?php echo e($collection->name); ?>" class="w-10 h-10 rounded-lg object-cover"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-100 to-pink-100 items-center justify-center hidden">
                                                    <span
                                                        class="text-xs font-bold text-purple-600"><?php echo e(substr($collection->name, 0, 1)); ?></span>
                                                </div>
                                            <?php else: ?>
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                                                    <span
                                                        class="text-xs font-bold text-purple-600"><?php echo e(substr($collection->name, 0, 1)); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <span class="text-sm font-medium text-gray-800"><?php echo e($collection->name); ?></span>
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <a href="#"
                                            class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                            <img src="https://via.placeholder.com/60" alt="Scent Families"
                                                class="w-10 h-10 rounded-lg object-cover">
                                            <span class="text-sm font-medium text-gray-800">Scent Families</span>
                                        </a>
                                        <a href="#"
                                            class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                            <img src="https://via.placeholder.com/60" alt="Layering Perfumes"
                                                class="w-10 h-10 rounded-lg object-cover">
                                            <span class="text-sm font-medium text-gray-800">Layering Perfumes</span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sale Badge (Dynamic) -->
                <?php if(isset($headerPromotion) && $headerPromotion && $headerPromotion->badge_text): ?>
                    <button
                        class="nav-button flex items-center gap-1 xl:gap-2 px-3 py-1.5 bg-opacity-90 rounded-full text-xs font-medium hover:bg-opacity-100 backdrop-blur-sm"
                        style="background-color: <?php echo e($headerPromotion->badge_color ?? '#ef4444'); ?>20; color: <?php echo e($headerPromotion->badge_color ?? '#ef4444'); ?>">
                        <span>❤️</span>
                        <span class="hidden md:inline"><?php echo e($headerPromotion->badge_text); ?></span>
                        <span class="md:hidden">SALE</span>
                    </button>
                <?php endif; ?>
            </div>

            <!-- Center Logo -->
            <div class="absolute left-1/2 transform -translate-x-1/2">
                <a href="<?php echo e(route('home')); ?>" class="block">
                    <img src="<?php echo e(asset('images/logo-transparent.png')); ?>"
                        alt="<?php echo e($settings['business_name'] ?? 'Scents N Smile'); ?>"
                        class="h-20 sm:h-24 md:h-32 lg:h-36 w-auto">
                </a>
            </div>

            <!-- Right Navigation -->
            <div class="flex items-center gap-1 sm:gap-2 flex-1 justify-end">
                <!-- Make a Bundle - Hidden on mobile/tablet -->
                <div class="hidden xl:block relative group">
                    <button id="bundleBtn"
                        class="nav-button px-3 py-1.5 bg-white bg-opacity-90 text-gray-800 rounded-full text-xs font-medium hover:bg-opacity-100 backdrop-blur-sm">
                        MAKE A BUNDLE
                    </button>

                    <!-- Bundle Dropdown -->
                    <div id="bundleDropdown"
                        class="absolute top-full left-0 mt-2 w-52 bg-white rounded-2xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden z-50">
                        <!-- Bundles Section -->
                        <div class="px-4 py-3">
                            <a href="<?php echo e(route('bundle.index')); ?>"
                                class="block px-2 py-2 text-base font-bold text-gray-900 hover:bg-gray-50 rounded-lg transition">
                                Build Your Own Bundle (And Save)
                            </a>
                        </div>

                        <!-- Pre-Built Bundles Section -->
                        <div class="px-4 pb-3">
                            <a href="<?php echo e(route('bundles.prebuilt')); ?>"
                                class="block px-2 py-2 text-base font-bold text-gray-900 hover:bg-gray-50 rounded-lg transition">
                                Pre-Built Bundles
                            </a>
                        </div>
                    </div>
                </div>

                <!-- About Dropdown - Hidden on mobile -->
                <div class="hidden lg:block relative group">
                    <button
                        class="nav-button flex items-center gap-1 xl:gap-2 px-3 py-1.5 bg-white bg-opacity-90 text-gray-800 rounded-full text-xs font-medium hover:bg-opacity-100 backdrop-blur-sm">
                        ABOUT
                        <svg class="w-3 h-3 transition-transform group-hover:rotate-180" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div
                        class="absolute top-full left-0 mt-2 w-52 bg-white rounded-2xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 overflow-hidden">
                        <!-- WHO WE ARE Section -->
                        <div class="px-4 py-2">
                            <h4 class="text-xs font-black uppercase tracking-wider text-gray-900 mb-1.5">WHO WE ARE
                            </h4>
                            <a href="<?php echo e(route('about')); ?>"
                                class="block px-2 py-1.5 text-sm text-gray-600 hover:bg-gray-50 rounded-lg transition">
                                About Us
                            </a>
                        </div>

                        <!-- HELP Section -->
                        <div class="px-4 py-2">
                            <h4 class="text-xs font-black uppercase tracking-wider text-gray-900 mb-1.5">HELP</h4>
                            <a href="<?php echo e(route('contact')); ?>"
                                class="block px-2 py-1.5 text-sm text-gray-600 hover:bg-gray-50 rounded-lg transition">
                                Contact Us
                            </a>
                            <a href="#"
                                class="block px-2 py-1.5 text-sm text-gray-600 hover:bg-gray-50 rounded-lg transition">
                                FAQ
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <button id="searchBtn"
                    class="p-1.5 bg-white bg-opacity-90 text-gray-800 rounded-full hover:bg-opacity-100 backdrop-blur-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Cart -->
                <button id="cartBtn"
                    class="p-1.5 bg-white bg-opacity-90 text-gray-800 rounded-full hover:bg-opacity-100 backdrop-blur-sm relative">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span id="cartCount"
                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center text-[10px]">1</span>
                </button>

                <!-- Account -->
                <a href="<?php echo e(route('user.login')); ?>" class="p-1.5 bg-blue-600 text-white rounded-full hover:bg-blue-700">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 10a4 4 0 100-8 4 4 0 000 8zm0 2c-4.42 0-8 1.79-8 4v2h16v-2c0-2.21-3.58-4-8-4z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobileMenu"
        class="hidden lg:hidden bg-white bg-opacity-95 backdrop-blur-md mx-2 mt-2 rounded-2xl shadow-lg overflow-hidden">
        <div class="p-4 space-y-2">
            <button
                class="w-full text-left px-4 py-3 text-gray-800 hover:bg-gray-100 rounded-lg font-medium">Perfumer</button>
            <button class="w-full text-left px-4 py-3 text-red-500 hover:bg-red-50 rounded-lg font-medium">❤️ Holiday
                Sale</button>
            <button class="w-full text-left px-4 py-3 text-gray-800 hover:bg-gray-100 rounded-lg font-medium">Make a
                Bundle</button>
            <a href="<?php echo e(route('about')); ?>"
                class="block w-full text-left px-4 py-3 text-gray-800 hover:bg-gray-100 rounded-lg font-medium">About</a>
        </div>
    </div>
</header>


<!-- Cart Sidebar -->
<div id="cartSidebar" class="fixed inset-0 z-[70] hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeCart()"></div>

    <!-- Sidebar -->
    <div id="cartPanel"
        class="absolute right-0 top-0 h-full w-full sm:w-[340px] bg-white shadow-2xl transform translate-x-full transition-transform duration-300 flex flex-col">
        <!-- Header -->
        <div class="flex items-center justify-between p-2.5 border-b">
            <button onclick="closeCart()" class="p-1 hover:bg-gray-100 rounded-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <img src="<?php echo e(asset('images/logo-transparent.png')); ?>"
                alt="<?php echo e($settings['business_name'] ?? 'Scents N Smile'); ?>" class="h-8 w-auto">
            <div class="w-6"></div>
        </div>

        <!-- Sale Banner (Dynamic) -->
        <?php if(isset($activePromotion) && $activePromotion): ?>
            <div class="text-white p-2.5 m-2.5 rounded-lg"
                style="background-color: <?php echo e($activePromotion->badge_color ?? '#000000'); ?>" id="cartPromoBanner"
                data-promo-id="<?php echo e($activePromotion->id); ?>" data-min-items="<?php echo e($activePromotion->min_items); ?>"
                data-discount-type="<?php echo e($activePromotion->discount_type); ?>"
                data-discount-value="<?php echo e($activePromotion->discount_value); ?>"
                data-free-shipping="<?php echo e($activePromotion->free_shipping ? 1 : 0); ?>"
                data-free-shipping-min="<?php echo e($activePromotion->free_shipping_min_items ?? 3); ?>"
                data-cart-label="<?php echo e($activePromotion->cart_label ?? $activePromotion->name . ' discount'); ?>">
                <div class="flex items-center gap-1.5 mb-2">
                    <h3 class="text-sm font-black uppercase tracking-wide">
                        <?php echo e($activePromotion->banner_title ?? $activePromotion->name); ?>

                    </h3>
                    <button class="w-4 h-4 rounded-full bg-white/20 flex items-center justify-center text-[10px]">i</button>
                </div>

                <?php if($activePromotion->discount_value > 0): ?>
                    <!-- Progress Bar 1 - Discount -->
                    <div class="mb-2.5">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[11px]"><?php echo e($activePromotion->min_items); ?>+ items
                                <?php echo e($activePromotion->discount_text); ?></span>
                        </div>
                        <div class="h-1 bg-white/20 rounded-full overflow-hidden">
                            <div id="progressBar1" class="h-full bg-white rounded-full transition-all duration-300"
                                style="width: 0%"></div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($activePromotion->free_shipping): ?>
                    <!-- Progress Bar 2 - Free Shipping -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[11px]"><?php echo e($activePromotion->free_shipping_min_items ?? 3); ?>+ items Free
                                shipping</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M18 18.5a1.5 1.5 0 01-1 0 1.5 1.5 0 011 0zM19.5 9.5h-2.5v-2h2.5c.28 0 .5.22.5.5v1c0 .28-.22.5-.5.5zM17 18.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM8.5 18.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM20 8h-3V6c0-1.1-.9-2-2-2H3c-1.1 0-2 .9-2 2v9c0 1.1.9 2 2 2 0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h1c.55 0 1-.45 1-1v-3c0-2.21-1.79-4-4-4z" />
                            </svg>
                        </div>
                        <div class="h-1 bg-white/20 rounded-full overflow-hidden">
                            <div id="progressBar2" class="h-full bg-white rounded-full transition-all duration-300"
                                style="width: 0%"></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- Default banner when no promotion -->
            <div class="bg-gray-800 text-white p-2.5 m-2.5 rounded-lg" id="cartPromoBanner" data-promo-id="0"
                data-min-items="2" data-discount-type="percentage" data-discount-value="0"
                data-free-shipping="<?php echo e(($settings['free_shipping_threshold'] ?? 999) > 0 ? '1' : '0'); ?>"
                data-free-shipping-min="3" data-free-shipping-threshold="<?php echo e($settings['free_shipping_threshold'] ?? 999); ?>"
                data-shipping-charge="<?php echo e($settings['shipping_charge'] ?? 99); ?>" data-cart-label="Discount">
                <div class="text-center py-2">
                    <?php if(($settings['free_shipping_threshold'] ?? 999) > 0): ?>
                        <p class="text-sm">Free shipping on orders above
                            ₹<?php echo e(number_format($settings['free_shipping_threshold'] ?? 999, 0)); ?></p>
                    <?php else: ?>
                        <p class="text-sm">Shipping: ₹<?php echo e(number_format($settings['shipping_charge'] ?? 99, 0)); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Cart Content - Scrollable -->
        <div class="flex-1 overflow-y-auto px-2.5">
            <!-- Step 1: Your Cart -->
            <div class="mb-3">
                <div class="bg-[#f5e6d3] rounded-xl px-4 py-3 flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                        <span class="text-lg font-bold"
                            style="color: <?php echo e($activePromotion->badge_color ?? '#ef4444'); ?>">1</span>
                    </div>
                    <h3 class="text-lg font-black uppercase">YOUR CART</h3>
                </div>

                <!-- Empty Cart Message -->
                <div id="emptyCartMessage" class="bg-[#f5e6d3] rounded-xl p-6 text-center">
                    <p class="text-gray-600">Your cart is empty</p>
                </div>

                <!-- Cart Items Container -->
                <div id="cartItemsContainer" class="space-y-3 hidden">
                    <!-- Cart items will be dynamically inserted here -->
                </div>
            </div>

            <!-- Step 2: Order Summary -->
            <div class="mb-3">
                <div class="border-2 border-red-400 rounded-xl overflow-hidden">
                    <!-- Header with beige background -->
                    <div class="bg-[#f5e6d3] px-4 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center">
                            <span class="text-lg font-bold"
                                style="color: <?php echo e($activePromotion->badge_color ?? '#ef4444'); ?>">2</span>
                        </div>
                        <h3 class="text-lg font-black uppercase">ORDER SUMMARY</h3>
                    </div>

                    <!-- Content -->
                    <div class="bg-white px-4 py-4 space-y-3">
                        <!-- Initial Price -->
                        <div class="flex justify-between text-base">
                            <span class="font-semibold text-gray-800">Initial price:</span>
                            <span id="cartInitialPrice" class="font-semibold text-gray-800">₹0.00</span>
                        </div>

                        <!-- Shipping -->
                        <div class="flex justify-between text-base">
                            <span class="font-semibold text-gray-800">Shipping:</span>
                            <span id="cartShipping" class="font-semibold text-gray-800">₹99.00</span>
                        </div>

                        <!-- Sale Discount (Dynamic) -->
                        <div class="flex justify-between text-base"
                            style="color: <?php echo e($activePromotion->badge_color ?? '#ef4444'); ?>">
                            <span class="font-semibold"
                                id="cartDiscountLabel"><?php echo e($activePromotion->cart_label ?? 'Sale discount'); ?>:</span>
                            <span id="cartDiscount" class="font-semibold">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer - Checkout Button -->
        <div class="p-3 border-t bg-white">
            <!-- Total Row -->
            <div class="flex justify-between items-center mb-3">
                <span class="text-lg font-black">Total:</span>
                <span id="cartTotal" class="text-lg font-black">₹0.00</span>
            </div>
            <a href="<?php echo e(route('checkout.index')); ?>" id="checkoutBtn"
                class="block w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 rounded-full text-base transition-colors text-center opacity-50 pointer-events-none">
                GO TO CHECKOUT
            </a>
        </div>
    </div>
</div>

<!-- Mobile Categories Sidebar -->
<div id="categoriesSidebar" class="fixed inset-0 z-[70] hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closeCategoriesSidebar()"></div>

    <!-- Sidebar -->
    <div id="categoriesPanel"
        class="absolute left-0 top-0 h-full w-full sm:w-[340px] bg-[#f5e6d3] shadow-2xl transform -translate-x-full transition-transform duration-300 overflow-y-auto">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-white sticky top-0 z-10">
            <h2 class="text-lg font-black uppercase">CATEGORIES</h2>
            <button onclick="closeCategoriesSidebar()" class="p-1 hover:bg-gray-100 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-4">
            <!-- Shop All Perfumes -->
            <a href="<?php echo e(route('collections')); ?>"
                class="block bg-white rounded-xl p-3 mb-4 flex items-center gap-3 hover:shadow-md transition-all">
                <div class="w-14 h-14 rounded-lg bg-gray-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">Shop All Perfumes</h3>
            </a>

            <!-- Shop by Category -->
            <?php if(isset($categories) && $categories->count() > 0): ?>
                <div class="mb-4">
                    <h3 class="text-[10px] font-bold text-gray-900 uppercase tracking-wide mb-2 pl-1">SHOP BY CATEGORY</h3>
                    <div class="bg-white rounded-xl overflow-hidden p-1">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('collections.show', $category->slug)); ?>"
                                class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                <?php if($category->imagekit_url): ?>
                                    <img src="<?php echo e($category->imagekit_thumbnail_url ?? $category->imagekit_url); ?>"
                                        alt="<?php echo e($category->name); ?>" class="w-10 h-10 rounded-lg object-cover"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-100 to-indigo-100 items-center justify-center hidden">
                                        <span class="text-xs font-bold text-blue-600"><?php echo e(substr($category->name, 0, 1)); ?></span>
                                    </div>
                                <?php else: ?>
                                    <div
                                        class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                                        <span class="text-xs font-bold text-blue-600"><?php echo e(substr($category->name, 0, 1)); ?></span>
                                    </div>
                                <?php endif; ?>
                                <span class="text-sm font-medium text-gray-800"><?php echo e($category->name); ?></span>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Shop by Gender -->
            <div class="mb-4">
                <h3 class="text-[10px] font-bold text-gray-900 uppercase tracking-wide mb-2 pl-1">SHOP BY GENDER</h3>
                <div class="bg-white rounded-xl overflow-hidden p-1">
                    <?php $__empty_1 = true; $__currentLoopData = $genders ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('collections.show', $gender->slug)); ?>"
                            class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                            <?php if($gender->imagekit_url): ?>
                                <img src="<?php echo e($gender->imagekit_thumbnail_url ?? $gender->imagekit_url); ?>"
                                    alt="<?php echo e($gender->name); ?>" class="w-10 h-10 rounded-lg object-cover"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-10 h-10 rounded-lg bg-gray-200 items-center justify-center hidden">
                                    <span class="text-xs font-bold text-gray-500"><?php echo e(substr($gender->name, 0, 1)); ?></span>
                                </div>
                            <?php else: ?>
                                <div class="w-10 h-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <span class="text-xs font-bold text-gray-500"><?php echo e(substr($gender->name, 0, 1)); ?></span>
                                </div>
                            <?php endif; ?>
                            <span class="text-sm font-medium text-gray-800"><?php echo e($gender->name); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <!-- No fallback placeholders -->
                    <?php endif; ?>
                </div>
            </div>

            <!-- More Ways to Shop -->
            <div class="mb-4">
                <h3 class="text-[10px] font-bold text-gray-900 uppercase tracking-wide mb-2 pl-1">MORE WAYS TO SHOP</h3>
                <div class="bg-white rounded-xl overflow-hidden p-1">
                    <?php $__empty_1 = true; $__currentLoopData = $featuredTags ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('collections.show', $tag->slug)); ?>"
                            class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                            <?php if($tag->imagekit_url): ?>
                                <img src="<?php echo e($tag->imagekit_thumbnail_url ?? $tag->imagekit_url); ?>" alt="<?php echo e($tag->name); ?>"
                                    class="w-10 h-10 rounded-lg object-cover"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-10 h-10 rounded-lg items-center justify-center hidden"
                                    style="background-color: <?php echo e($tag->color ?? '#3B82F6'); ?>20; border: 2px solid <?php echo e($tag->color ?? '#3B82F6'); ?>;">
                                    <span class="text-xs font-bold" style="color: <?php echo e($tag->color ?? '#3B82F6'); ?>;">
                                        <?php echo e(substr($tag->name, 0, 1)); ?>

                                    </span>
                                </div>
                            <?php else: ?>
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                                    style="background-color: <?php echo e($tag->color ?? '#3B82F6'); ?>20; border: 2px solid <?php echo e($tag->color ?? '#3B82F6'); ?>;">
                                    <span class="text-xs font-bold" style="color: <?php echo e($tag->color ?? '#3B82F6'); ?>;">
                                        <?php echo e(substr($tag->name, 0, 1)); ?>

                                    </span>
                                </div>
                            <?php endif; ?>
                            <span class="text-sm font-medium text-gray-800"><?php echo e($tag->name); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <a href="#" class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                            <img src="https://via.placeholder.com/60" alt="Bestsellers"
                                class="w-10 h-10 rounded-lg object-cover">
                            <span class="text-sm font-medium text-gray-800">Bestsellers</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                            <img src="https://via.placeholder.com/60" alt="New Arrivals"
                                class="w-10 h-10 rounded-lg object-cover">
                            <span class="text-sm font-medium text-gray-800">New Arrivals</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Discover -->
            <div>
                <h3 class="text-[10px] font-bold text-gray-900 uppercase tracking-wide mb-2 pl-1">DISCOVER</h3>
                <div class="bg-white rounded-xl overflow-hidden p-1">
                    <!-- Scent Families Link (Fixed Mobile) -->
                    <a href="<?php echo e(route('scent-families')); ?>"
                        class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                            <span class="text-lg">🌸</span>
                        </div>
                        <span class="text-sm font-medium text-gray-800">Scent Families</span>
                    </a>

                    <?php $__empty_1 = true; $__currentLoopData = $featuredCollections ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('collections.show', $collection->slug)); ?>"
                            class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                            <?php if($collection->imagekit_url): ?>
                                <img src="<?php echo e($collection->imagekit_thumbnail_url ?? $collection->imagekit_url); ?>"
                                    alt="<?php echo e($collection->name); ?>" class="w-10 h-10 rounded-lg object-cover"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div
                                    class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-100 to-pink-100 items-center justify-center hidden">
                                    <span class="text-xs font-bold text-purple-600"><?php echo e(substr($collection->name, 0, 1)); ?></span>
                                </div>
                            <?php else: ?>
                                <div
                                    class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                                    <span class="text-xs font-bold text-purple-600"><?php echo e(substr($collection->name, 0, 1)); ?></span>
                                </div>
                            <?php endif; ?>
                            <span class="text-sm font-medium text-gray-800"><?php echo e($collection->name); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <a href="<?php echo e(route('scent-families')); ?>"
                            class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                            <img src="https://via.placeholder.com/60" alt="Scent Families"
                                class="w-10 h-10 rounded-lg object-cover">
                            <span class="text-sm font-medium text-gray-800">Scent Families</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors">
                            <img src="https://via.placeholder.com/60" alt="Layering Perfumes"
                                class="w-10 h-10 rounded-lg object-cover">
                            <span class="text-sm font-medium text-gray-800">Layering Perfumes</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cart Item Template (hidden) -->
<template id="cartItemTemplate">
    <div class="cart-item bg-[#f5e6d3] rounded-lg p-3" data-item-id="">
        <div class="flex gap-3">
            <!-- Product Image - Bigger -->
            <div class="w-24 h-28 bg-white rounded-lg overflow-hidden flex-shrink-0">
                <img src="" alt="" class="cart-item-image w-full h-full object-cover">
            </div>

            <!-- Product Details -->
            <div class="flex-1 min-w-0">
                <!-- Name & Price Row -->
                <div class="flex justify-between items-start mb-4">
                    <h4 class="cart-item-name font-bold text-sm leading-tight uppercase"></h4>
                    <span class="cart-item-price font-bold text-base whitespace-nowrap ml-2">₹0.00</span>
                </div>

                <!-- Quantity Controls Row -->
                <div class="flex items-center gap-3">
                    <div class="flex items-center border-2 border-gray-400 rounded-full">
                        <button onclick="updateCartQuantity(this, -1)"
                            class="w-9 h-9 flex items-center justify-center text-lg font-medium hover:text-red-500 transition">−</button>
                        <span class="cart-item-quantity font-bold text-base w-8 text-center">1</span>
                        <button onclick="updateCartQuantity(this, 1)"
                            class="w-9 h-9 flex items-center justify-center text-lg font-medium hover:text-red-500 transition">+</button>
                    </div>
                    <button onclick="removeFromCart(this)" class="text-gray-400 hover:text-red-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- Search Dropdown Overlay -->
<div id="searchModal" class="hidden fixed inset-0 z-[60]">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity duration-300"></div>

    <!-- Search Dropdown -->
    <div class="relative max-w-6xl mx-auto mt-4 px-4">
        <div class="search-dropdown bg-white rounded-3xl shadow-2xl overflow-hidden">
            <!-- Search Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-4">
                    <form action="<?php echo e(route('search')); ?>" method="GET" class="flex-1 relative" id="searchForm">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="q" id="searchInput" placeholder="Search"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-full text-base focus:outline-none focus:ring-2 focus:ring-gray-900">
                        <input type="hidden" name="gender" id="searchGenderInput" value="all">
                    </form>
                    <button id="searchCloseBtn" class="p-2 hover:bg-gray-100 rounded-full transition">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Search Content -->
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Filters -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Gender Section (Dynamic) -->
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
                                </svg>
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Gender</h3>
                            </div>
                            <div class="flex flex-wrap gap-2" id="searchGenderButtons">
                                <?php $__empty_1 = true; $__currentLoopData = $genders ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <button type="button"
                                        class="search-gender-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full text-sm font-medium text-gray-800 transition"
                                        data-gender-id="<?php echo e($gender->id); ?>"
                                        data-gender-slug="<?php echo e($gender->slug); ?>"><?php echo e($gender->name); ?></button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <button type="button"
                                        class="search-gender-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full text-sm font-medium text-gray-800 transition"
                                        data-gender-id="1" data-gender-slug="women">Women</button>
                                    <button type="button"
                                        class="search-gender-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full text-sm font-medium text-gray-800 transition"
                                        data-gender-id="2" data-gender-slug="men">Men</button>
                                    <button type="button"
                                        class="search-gender-btn px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full text-sm font-medium text-gray-800 transition"
                                        data-gender-id="3" data-gender-slug="unisex">Unisex</button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Scent Notes Section (Dynamic from Highlight Notes) -->
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
                                </svg>
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Scent Notes</h3>
                            </div>
                            <div class="flex flex-wrap gap-2" id="searchScentNotesButtons">
                                <?php $__empty_1 = true; $__currentLoopData = $highlightNotes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <a href="<?php echo e(route('scent-notes.show', $note->slug)); ?>"
                                        class="px-4 py-2 bg-amber-100 hover:bg-amber-200 rounded-full text-sm font-medium text-amber-800 transition"><?php echo e($note->name); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <span class="text-sm text-gray-500">No scent notes available</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Quick Links -->
                    <div class="bg-gray-50 rounded-2xl p-4">
                        <h3 class="text-base font-bold text-gray-900 mb-1">Quick Search</h3>
                        <p class="text-sm text-gray-600 mb-4">Popular searches</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="<?php echo e(route('search', ['q' => 'floral'])); ?>"
                                class="px-4 py-2 rounded-full text-sm font-medium transition hover:opacity-80"
                                style="background-color: #FFB6C1; color: #000;">Floral</a>
                            <a href="<?php echo e(route('search', ['q' => 'vanilla'])); ?>"
                                class="px-4 py-2 rounded-full text-sm font-medium transition hover:opacity-80"
                                style="background-color: #FFD700; color: #000;">Vanilla</a>
                            <a href="<?php echo e(route('search', ['q' => 'gourmand'])); ?>"
                                class="px-4 py-2 rounded-full text-sm font-medium transition hover:opacity-80"
                                style="background-color: #FF8C69; color: #000;">Gourmand</a>
                            <a href="<?php echo e(route('search', ['q' => 'fresh'])); ?>"
                                class="px-4 py-2 rounded-full text-sm font-medium transition hover:opacity-80"
                                style="background-color: #98FB98; color: #000;">Fresh</a>
                            <a href="<?php echo e(route('search', ['q' => 'woody'])); ?>"
                                class="px-4 py-2 rounded-full text-sm font-medium transition hover:opacity-80"
                                style="background-color: #DEB887; color: #000;">Woody</a>
                            <a href="<?php echo e(route('search', ['q' => 'citrus'])); ?>"
                                class="px-4 py-2 rounded-full text-sm font-medium transition hover:opacity-80"
                                style="background-color: #9ACD32; color: #000;">Citrus</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div><?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/partials/header.blade.php ENDPATH**/ ?>