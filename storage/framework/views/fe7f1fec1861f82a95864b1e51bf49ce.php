<?php if($products->count() > 0): ?>
    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make('partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
<div class="col-span-full text-center py-20">
    <div class="w-24 h-24 mx-auto mb-6 bg-[#F4ECDD] rounded-full flex items-center justify-center">
        <svg class="w-12 h-12 text-[#F27F6E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-2">No Products Found</h3>
    <p class="text-gray-500 mb-6">No products match your filters. Try adjusting your selection.</p>
    <button onclick="clearAllFilters()" class="inline-flex items-center px-8 py-3 bg-[#F27F6E] text-white rounded-full font-medium hover:bg-[#e06b5a] transition-colors">
        Clear All Filters
    </button>
</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/partials/products-grid.blade.php ENDPATH**/ ?>