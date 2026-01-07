

<?php $__env->startSection('title', ($selectedNote ? $selectedNote->name . ' Fragrances' : ($query ? 'Search: ' . $query : 'Search')) . ' - Scents N Smile'); ?>

<?php $__env->startSection('content'); ?>
<!-- Search Page -->
<section class="pt-20 pb-8 bg-white min-h-screen">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Back Button -->
        <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center gap-1.5 text-gray-600 hover:text-gray-900 mb-4 text-xs">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back
        </a>

        <!-- Search Bar -->
        <div class="mb-4">
            <form action="<?php echo e(route('search')); ?>" method="GET" class="relative">
                <input type="hidden" name="gender" value="<?php echo e($genderFilter); ?>">
                <input 
                    type="text" 
                    name="q"
                    value="<?php echo e($query); ?>"
                    placeholder="Search for fragrances..."
                    class="w-full px-4 py-2.5 pr-20 border-2 border-gray-300 rounded-full text-sm focus:outline-none focus:border-gray-400 transition"
                >
                <div class="absolute right-1.5 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
                    <?php if($query || $selectedNote): ?>
                    <a href="<?php echo e(route('search')); ?>" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                    <button type="submit" class="bg-[#e8a598] hover:bg-[#d99588] text-white rounded-full p-2 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Count -->
        <?php if($selectedNote): ?>
        <div class="flex items-center gap-2 mb-3">
            <p class="text-xs text-gray-600"><?php echo e($products->total()); ?> Products with scent note:</p>
            <span class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">
                <?php echo e($selectedNote->name); ?>

                <a href="<?php echo e(route('search')); ?>" class="ml-2 hover:text-amber-600">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </span>
        </div>
        <?php elseif($query): ?>
        <p class="text-xs text-gray-600 mb-3"><?php echo e($products->total()); ?> Results for "<span class="font-semibold"><?php echo e($query); ?></span>"</p>
        <?php else: ?>
        <p class="text-xs text-gray-600 mb-3"><?php echo e($products->total()); ?> Products</p>
        <?php endif; ?>

        <!-- Filter Tabs (Dynamic Genders) -->
        <div class="flex gap-2 mb-5 overflow-x-auto pb-2">
            <!-- All Tab -->
            <?php if($noteSlug): ?>
            <a href="<?php echo e(route('scent-notes.show', $noteSlug)); ?>" 
               class="px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap transition <?php echo e($genderFilter === 'all' ? 'bg-black text-white' : 'bg-white text-gray-700 border border-gray-300 hover:border-gray-400'); ?>">
                All (<?php echo e($totalCount); ?>)
            </a>
            <?php else: ?>
            <a href="<?php echo e(route('search', ['q' => $query, 'gender' => 'all'])); ?>" 
               class="px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap transition <?php echo e($genderFilter === 'all' ? 'bg-black text-white' : 'bg-white text-gray-700 border border-gray-300 hover:border-gray-400'); ?>">
                All (<?php echo e($totalCount); ?>)
            </a>
            <?php endif; ?>
            
            <!-- Dynamic Gender Tabs -->
            <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($noteSlug): ?>
            <a href="<?php echo e(route('scent-notes.show', ['slug' => $noteSlug, 'gender' => $gender->id])); ?>" 
               class="px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap transition <?php echo e($genderFilter == $gender->id ? 'bg-black text-white' : 'bg-white text-gray-700 border border-gray-300 hover:border-gray-400'); ?>">
                <?php echo e($gender->name); ?> (<?php echo e($genderCounts[$gender->id] ?? 0); ?>)
            </a>
            <?php else: ?>
            <a href="<?php echo e(route('search', ['q' => $query, 'gender' => $gender->id])); ?>" 
               class="px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap transition <?php echo e($genderFilter == $gender->id ? 'bg-black text-white' : 'bg-white text-gray-700 border border-gray-300 hover:border-gray-400'); ?>">
                <?php echo e($gender->name); ?> (<?php echo e($genderCounts[$gender->id] ?? 0); ?>)
            </a>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Products Grid -->
        <?php if($products->count() > 0): ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            <?php if($noteSlug): ?>
            <?php echo e($products->appends(['gender' => $genderFilter])->links()); ?>

            <?php else: ?>
            <?php echo e($products->appends(['q' => $query, 'gender' => $genderFilter])->links()); ?>

            <?php endif; ?>
        </div>
        <?php else: ?>
        <!-- No Results -->
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">No products found</h3>
            <?php if($query): ?>
            <p class="text-gray-600 text-sm mb-4">We couldn't find any products matching "<?php echo e($query); ?>"</p>
            <?php elseif($selectedNote): ?>
            <p class="text-gray-600 text-sm mb-4">No products found with scent note "<?php echo e($selectedNote->name); ?>"</p>
            <?php else: ?>
            <p class="text-gray-600 text-sm mb-4">Try searching for something else</p>
            <?php endif; ?>
            <a href="<?php echo e(route('collections')); ?>" class="inline-flex items-center px-6 py-2.5 bg-[#e8a598] text-white text-sm font-medium rounded-full hover:bg-[#d99588] transition">
                Browse All Products
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/search.blade.php ENDPATH**/ ?>