<!-- Product Card -->
<a href="<?php echo e(route('product.show', $product->slug)); ?>" class="group block">
    <div class="relative mb-3">
        <!-- Badges -->
        <?php if($product->genders->count() > 0): ?>
        <span class="absolute top-2 left-2 z-10 border-2 border-red-400 text-red-400 text-[10px] sm:text-xs font-medium px-2 sm:px-3 py-1 rounded-full bg-white/90">
            <?php echo e($product->genders->first()->name); ?>

        </span>
        <?php endif; ?>
        <?php if($product->is_bestseller): ?>
        <span class="absolute top-2 right-2 z-10 bg-[#d4c4b0] text-gray-800 text-[10px] sm:text-xs font-medium px-2 sm:px-3 py-1 rounded-lg">
            Bestseller
        </span>
        <?php elseif($product->is_new): ?>
        <span class="absolute top-2 right-2 z-10 bg-green-500 text-white text-[10px] sm:text-xs font-medium px-2 sm:px-3 py-1 rounded-lg">
            New
        </span>
        <?php elseif($product->is_trending): ?>
        <span class="absolute top-2 right-2 z-10 bg-orange-500 text-white text-[10px] sm:text-xs font-medium px-2 sm:px-3 py-1 rounded-lg">
            Trending
        </span>
        <?php endif; ?>

        <!-- Product Image -->
        <div class="aspect-square rounded-xl overflow-hidden bg-[#f5f5f0]/50 relative"
             x-data="{ currentImage: 0, images: <?php echo e(json_encode($product->images_array ?? [])); ?> }"
             @mouseenter="if(images.length > 1) currentImage = 1"
             @mouseleave="currentImage = 0">
            <?php if($product->images_array && count($product->images_array) > 0): ?>
                <?php $__currentLoopData = $product->images_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <img src="<?php echo e($image); ?>" 
                     alt="<?php echo e($product->name); ?>" 
                     class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500"
                     :class="currentImage === <?php echo e($index); ?> ? 'opacity-100' : 'opacity-0'"
                     loading="lazy">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php elseif($product->image_url): ?>
                <img src="<?php echo e($product->image_url); ?>" 
                     alt="<?php echo e($product->name); ?>" 
                     class="w-full h-full object-cover"
                     loading="lazy">
            <?php else: ?>
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-100 to-pink-100">
                    <span class="text-5xl">🌸</span>
                </div>
            <?php endif; ?>

            <!-- Add to Cart/Bundle Button -->
            <div class="absolute bottom-0 left-0 right-0 p-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                <button onclick="event.preventDefault(); <?php echo e(isset($buttonClass) && $buttonClass === 'add-to-bundle-btn' ? 'addToBundle' : 'addToCart'); ?>(<?php echo e($product->id); ?>)" 
                        class="w-full py-2 bg-white/95 border border-[#e8a598] text-[#e8a598] rounded-lg font-medium text-xs hover:bg-[#e8a598] hover:text-white transition-colors duration-200 <?php echo e($buttonClass ?? ''); ?>">
                    <?php echo e($buttonText ?? 'ADD TO CART'); ?>

                </button>
            </div>
        </div>
    </div>

    <!-- Rating -->
    <div class="flex items-center gap-1.5 mb-2">
        <div class="flex text-black text-sm">★★★★★</div>
        <span class="text-xs text-gray-500 underline"><?php echo e(rand(100, 999)); ?></span>
    </div>

    <!-- Inspired By -->
    <?php if($product->inspired_by): ?>
    <div class="mb-2">
        <p class="text-xs text-gray-500 italic">inspired by</p>
        <p class="text-sm text-[#e8a598] font-medium"><?php echo e($product->inspired_by); ?></p>
    </div>
    <?php endif; ?>

    <!-- Name & Price -->
    <div class="flex items-end justify-between gap-2">
        <?php
            $nameParts = explode(' ', strtoupper($product->name), 2);
        ?>
        <div>
            <h3 class="font-bold text-sm text-gray-900 leading-tight uppercase"><?php echo e($nameParts[0] ?? ''); ?></h3>
            <p class="font-bold text-sm text-gray-900 leading-tight uppercase"><?php echo e($nameParts[1] ?? ''); ?></p>
        </div>
        <div class="text-right flex-shrink-0">
            <?php if($product->sale_price && $product->sale_price < $product->price): ?>
                <?php
                    $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                ?>
                <span class="inline-block bg-[#e8a598] text-white text-[10px] px-2 py-0.5 rounded mb-1">-<?php echo e($discount); ?>%</span>
                <p class="text-[#e8a598] text-base font-bold italic">₹<?php echo e(number_format($product->sale_price, 0)); ?></p>
                <p class="text-gray-400 text-xs line-through">₹<?php echo e(number_format($product->price, 0)); ?></p>
            <?php else: ?>
                <p class="text-[#e8a598] text-base font-bold italic">₹<?php echo e(number_format($product->price, 0)); ?></p>
            <?php endif; ?>
        </div>
    </div>
</a>
<?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/partials/product-card.blade.php ENDPATH**/ ?>