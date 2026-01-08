

<?php
    $pageTitle = 'Scent Families | Scents N Smile';
    $metaDescription = 'Explore our diverse scent families. Find your perfect fragrance match from Fresh, Floral, Woody, and more.';
?>

<?php $__env->startSection('content'); ?>
<div class="font-sans antialiased text-gray-900 bg-white min-h-screen">
    
    
    <div class="h-16 md:h-20"></div>

    
    <div class="w-full">
        
        <?php if($activeFamily): ?>
            
            <div class="relative w-full overflow-hidden transition-all duration-500 ease-in-out" 
                 style="background-color: <?php echo e($activeFamily->color_code ?? '#dcfce7'); ?>;"> 
                
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
                    <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                        
                        
                        <div class="w-full md:w-1/3 flex flex-col items-center md:items-start text-center md:text-left space-y-6 z-10">
                            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-sm border border-white/50 relative overflow-hidden">
                                
                                <div class="absolute -top-6 -right-6 w-24 h-24 bg-yellow-300 rounded-full opacity-20 blur-xl"></div>
                                <div class="absolute bottom-0 left-0 w-32 h-32 bg-green-300 rounded-full opacity-20 blur-2xl"></div>

                                <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tight mb-4 relative z-10"><?php echo e($activeFamily->name); ?></h1>
                                
                                <p class="text-gray-700 text-lg leading-relaxed mb-6 relative z-10">
                                    <?php echo e($activeFamily->description ?? 'Discover our collection of fresh, vibrant scents perfect for everyday wear.'); ?>

                                </p>
                                
                                <a href="#products-grid" class="inline-block bg-black text-white font-bold py-3 px-8 rounded-full hover:bg-gray-800 transition-transform transform hover:scale-105 shadow-lg">
                                    SHOP <?php echo e(strtoupper($activeFamily->name)); ?>

                                </a>
                            </div>
                        </div>

                        
                        <div class="w-full md:w-2/3 relative z-10" id="products-grid">
                            <?php if($activeFamily->products->isNotEmpty()): ?>
                                
                                <div class="flex overflow-x-auto gap-4 pb-8 snap-x snap-mandatory hide-scroll-bar">
                                    <?php $__currentLoopData = $activeFamily->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex-none w-64 snap-center bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
                                            
                                            <div class="relative aspect-[3/4] overflow-hidden bg-gray-100">
                                                <?php if($product->imagekit_url): ?>
                                                    <img src="<?php echo e($product->imagekit_url); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                                <?php else: ?>
                                                     <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-50">No Image</div>
                                                <?php endif; ?>
                                                
                                                
                                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                                    <a href="<?php echo e(route('product.show', $product->slug)); ?>" class="bg-white text-black font-bold py-2 px-6 rounded-full transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                                        VIEW
                                                    </a>
                                                </div>
                                            </div>

                                            
                                            <div class="p-4 text-center">
                                                <h3 class="font-bold text-gray-900 uppercase tracking-wide text-sm mb-1 truncate"><?php echo e($product->name); ?></h3>
                                                <p class="text-xs text-gray-500 mb-2">Inspired by <?php echo e($product->brand->name ?? 'Designer Scent'); ?></p>
                                                <div class="font-black text-lg">₹<?php echo e(number_format($product->price ?? 0, 0)); ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center justify-center h-64 bg-white/50 rounded-3xl border-2 border-dashed border-gray-300">
                                    <p class="text-gray-500 font-medium">No products found in this family yet.</p>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>

        
        <div class="w-full bg-white">
            <?php $__currentLoopData = $allFamilies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $family): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!$activeFamily || $family->id !== $activeFamily->id): ?>
                    <a href="<?php echo e(route('scent-families', ['scent' => $family->slug])); ?>" 
                       class="group block border-b border-gray-100 hover:bg-gray-50 transition-colors duration-300">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
                            <div class="flex items-center gap-6">
                                
                                <div class="w-3 h-12 rounded-full" style="background-color: <?php echo e($family->color_code ?? '#e5e7eb'); ?>;"></div>
                                
                                <h2 class="text-2xl md:text-3xl font-bold text-gray-400 group-hover:text-gray-900 transition-colors uppercase tracking-tight">
                                    <?php echo e($family->name); ?>

                                </h2>
                            </div>
                            
                            
                            <div class="w-10 h-10 rounded-full border-2 border-gray-200 flex items-center justify-center group-hover:border-black group-hover:bg-black group-hover:text-white transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </div>
</div>

<style>
/* Hide scrollbar for Chrome, Safari and Opera */
.hide-scroll-bar::-webkit-scrollbar {
    display: none;
}
/* Hide scrollbar for IE, Edge and Firefox */
.hide-scroll-bar {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/scent-families.blade.php ENDPATH**/ ?>