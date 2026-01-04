

<?php $__env->startSection('title', 'Pre-Built Bundles - Scents N Smile'); ?>

<?php $__env->startSection('content'); ?>
<!-- Breadcrumb -->
<section class="pt-24 md:pt-28 pb-6 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <nav class="text-sm text-gray-600">
            <a href="<?php echo e(route('home')); ?>" class="hover:text-gray-900">Home</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium">Bundles</span>
        </nav>
    </div>
</section>

<!-- Page Title -->
<section class="py-8 bg-white border-b">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-black text-center mb-2">BUNDLES</h1>
    </div>
</section>

<!-- Filter Tabs -->
<section class="py-6 bg-white border-b">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-wrap gap-3 justify-center items-center">
            <button class="px-6 py-2 bg-black text-white rounded-full text-sm font-bold hover:bg-gray-800 transition">
                ALL
            </button>
            <button class="px-6 py-2 bg-gray-100 text-gray-800 rounded-full text-sm font-bold hover:bg-gray-200 transition">
                NEW
            </button>
            <button class="px-6 py-2 bg-gray-100 text-gray-800 rounded-full text-sm font-bold hover:bg-gray-200 transition">
                WOMEN
            </button>
            <button class="px-6 py-2 bg-gray-100 text-gray-800 rounded-full text-sm font-bold hover:bg-gray-200 transition">
                MEN
            </button>
            <button class="px-6 py-2 bg-gray-100 text-gray-800 rounded-full text-sm font-bold hover:bg-gray-200 transition">
                UNISEX
            </button>
            <button class="px-6 py-2 bg-gray-100 text-gray-800 rounded-full text-sm font-bold hover:bg-gray-200 transition">
                GOURMAND COLLECTION
            </button>
            <button class="px-6 py-2 bg-gray-100 text-gray-800 rounded-full text-sm font-bold hover:bg-gray-200 transition">
                CANDY COLLECTION
            </button>
            <button class="px-6 py-2 bg-gray-100 text-gray-800 rounded-full text-sm font-bold hover:bg-gray-200 transition">
                RAINFOREST COLLECTION
            </button>
        </div>
    </div>
</section>

<!-- Show Filters & Items Count -->
<section class="py-4 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center">
            <button class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <span class="text-sm font-medium">Show Filters</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <span class="text-sm text-gray-600"><?php echo e(count($bundles)); ?> Items</span>
        </div>
    </div>
</section>

<!-- Bundles Grid -->
<section class="py-8 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php $__currentLoopData = $bundles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bundle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('product.demo')); ?>" class="group relative block">
                <!-- Wishlist Button -->
                <button onclick="event.preventDefault(); event.stopPropagation();" class="absolute top-3 right-3 z-10 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>

                <!-- Bundle Image -->
                <div class="relative overflow-hidden rounded-2xl bg-gray-100 aspect-square mb-4">
                    <img src="<?php echo e($bundle['image']); ?>" 
                         alt="<?php echo e($bundle['name']); ?>" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>

                <!-- Bundle Info -->
                <div class="space-y-2">
                    <h3 class="font-bold text-base leading-tight group-hover:text-red-500 transition-colors"><?php echo e($bundle['name']); ?></h3>
                    
                    <!-- Price -->
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-bold">Rs. <?php echo e(number_format($bundle['price'] / 100, 0)); ?></span>
                        <span class="text-sm text-gray-500 line-through">Rs. <?php echo e(number_format($bundle['original_price'] / 100, 0)); ?></span>
                    </div>

                    <!-- Inspired By -->
                    <p class="text-xs text-gray-600">
                        <span class="font-medium">Inspired by</span><br>
                        <?php echo e($bundle['inspired_by']); ?>

                    </p>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/bundles/prebuilt.blade.php ENDPATH**/ ?>