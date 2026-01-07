

<?php $__env->startSection('title', 'Bundle Products - Scents N Smile'); ?>

<?php $__env->startSection('content'); ?>
<!-- Breadcrumb -->
<section class="pt-24 md:pt-28 pb-6 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <nav class="text-sm text-gray-600">
            <a href="<?php echo e(route('home')); ?>" class="hover:text-gray-900">Home</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium">Bundle Products</span>
        </nav>
    </div>
</section>

<!-- Page Title -->
<section class="py-8 bg-white border-b">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-black text-center mb-2">BUNDLE PRODUCTS</h1>
        <p class="text-center text-gray-600">Exclusive products available only in bundles</p>
    </div>
</section>

<!-- Bundle Products Section -->
<?php if($bundleProducts->count() > 0): ?>
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="mb-6">
            <p class="text-sm text-gray-600"><?php echo e($bundleProducts->count()); ?> Products</p>
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 lg:gap-6">
            <?php $__currentLoopData = $bundleProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php else: ?>
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No Bundle Products Yet</h3>
        <p class="text-gray-500 mb-6">Bundle products will appear here once they are added.</p>
        <a href="<?php echo e(route('collections')); ?>" class="inline-flex items-center px-8 py-3 bg-[#F27F6E] text-white rounded-full font-medium hover:bg-[#e06b5a] transition-colors">
            Browse All Products
        </a>
    </div>
</section>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/bundles/prebuilt.blade.php ENDPATH**/ ?>