

<?php $__env->startSection('step_title', 'Step 7: Final Settings'); ?>
<?php $__env->startSection('step_description', 'Complete product configuration and publish settings'); ?>

<?php $__env->startSection('step_content'); ?>
<?php
    $currentStep = 7;
    $prevStepRoute = route('admin.products.edit.step6', $product->id);
?>

<form id="stepForm" action="<?php echo e(route('admin.products.edit.step7.process', $product->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    
    <div class="bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-purple-50">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                    <span class="text-white text-xl">⚙️</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Final Settings</h2>
                    <p class="text-gray-600 font-medium">Complete product configuration and publish settings</p>
                </div>
            </div>
        </div>
        
        <div class="p-8 space-y-8">
            <!-- Error Messages -->
            <?php if($errors->any()): ?>
                <div class="bg-red-50 border-2 border-red-500 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-red-800 mb-2">❌ Error Creating Product</h3>
                    <ul class="list-disc list-inside text-red-700">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Product Status & Visibility -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">📋 Publication Settings</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Product Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Product Status <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400">
                            <option value="">Select status</option>
                            <option value="active" <?php echo e(old('status', $productData['status'] ?? '') == 'active' ? 'selected' : ''); ?>>Active - Live on website</option>
                            <option value="draft" <?php echo e(old('status', $productData['status'] ?? '') == 'draft' ? 'selected' : ''); ?>>Draft - Save for later</option>
                            <option value="inactive" <?php echo e(old('status', $productData['status'] ?? '') == 'inactive' ? 'selected' : ''); ?>>Inactive - Hidden from website</option>
                        </select>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Visibility -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Visibility <span class="text-red-500">*</span></label>
                        <select name="visibility" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400">
                            <option value="">Select visibility</option>
                            <option value="visible" <?php echo e(old('visibility', $productData['visibility'] ?? '') == 'visible' ? 'selected' : ''); ?>>Visible - Everywhere</option>
                            <option value="catalog" <?php echo e(old('visibility', $productData['visibility'] ?? '') == 'catalog' ? 'selected' : ''); ?>>Catalog Only</option>
                            <option value="search" <?php echo e(old('visibility', $productData['visibility'] ?? '') == 'search' ? 'selected' : ''); ?>>Search Only</option>
                            <option value="hidden" <?php echo e(old('visibility', $productData['visibility'] ?? '') == 'hidden' ? 'selected' : ''); ?>>Hidden</option>
                        </select>
                        <?php $__errorArgs = ['visibility'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Product Attributes -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">⭐ Product Attributes</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Is Bestseller -->
                    <label class="flex items-center space-x-3 p-4 border-2 border-gray-200 rounded-lg hover:bg-orange-50 hover:border-orange-300 cursor-pointer transition-all duration-200">
                        <input type="checkbox" name="is_bestseller" value="1" 
                            <?php echo e(old('is_bestseller', $productData['is_bestseller'] ?? $product->is_bestseller ?? false) ? 'checked' : ''); ?>

                            class="h-5 w-5 text-orange-600 border-gray-300 rounded focus:ring-2 focus:ring-orange-500">
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">🔥 Bestseller</div>
                            <div class="text-xs text-gray-500">Mark as bestselling product</div>
                        </div>
                    </label>

                    <!-- Is New -->
                    <label class="flex items-center space-x-3 p-4 border-2 border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-300 cursor-pointer transition-all duration-200">
                        <input type="checkbox" name="is_new" value="1" 
                            <?php echo e(old('is_new', $productData['is_new'] ?? $product->is_new ?? false) ? 'checked' : ''); ?>

                            class="h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-2 focus:ring-green-500">
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">✨ New Arrival</div>
                            <div class="text-xs text-gray-500">Mark as new product</div>
                        </div>
                    </label>

                    <!-- Is Featured -->
                    <label class="flex items-center space-x-3 p-4 border-2 border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 cursor-pointer transition-all duration-200">
                        <input type="checkbox" name="is_featured" value="1" 
                            <?php echo e(old('is_featured', $productData['is_featured'] ?? $product->is_featured ?? false) ? 'checked' : ''); ?>

                            class="h-5 w-5 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">⭐ Featured</div>
                            <div class="text-xs text-gray-500">Highlight this product</div>
                        </div>
                    </label>

                    <!-- Is Trending -->
                    <label class="flex items-center space-x-3 p-4 border-2 border-gray-200 rounded-lg hover:bg-pink-50 hover:border-pink-300 cursor-pointer transition-all duration-200">
                        <input type="checkbox" name="is_trending" value="1" 
                            <?php echo e(old('is_trending', $productData['is_trending'] ?? $product->is_trending ?? false) ? 'checked' : ''); ?>

                            class="h-5 w-5 text-pink-600 border-gray-300 rounded focus:ring-2 focus:ring-pink-500">
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">📈 Trending</div>
                            <div class="text-xs text-gray-500">Mark as trending product</div>
                        </div>
                    </label>

                    <!-- Is Top Sale -->
                    <label class="flex items-center space-x-3 p-4 border-2 border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 cursor-pointer transition-all duration-200">
                        <input type="checkbox" name="is_topsale" value="1" 
                            <?php echo e(old('is_topsale', $productData['is_topsale'] ?? $product->is_topsale ?? false) ? 'checked' : ''); ?>

                            class="h-5 w-5 text-red-600 border-gray-300 rounded focus:ring-2 focus:ring-red-500">
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">💰 Top Sale</div>
                            <div class="text-xs text-gray-500">Mark as top selling product</div>
                        </div>
                    </label>

                    <!-- Show in Homepage -->
                    <label class="flex items-center space-x-3 p-4 border-2 border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 cursor-pointer transition-all duration-200">
                        <input type="checkbox" name="show_in_homepage" value="1" 
                            <?php echo e(old('show_in_homepage', $productData['show_in_homepage'] ?? $product->show_in_homepage ?? false) ? 'checked' : ''); ?>

                            class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">🏠 Show on Homepage</div>
                            <div class="text-xs text-gray-500">Display on homepage</div>
                        </div>
                    </label>

                    <!-- Bundle Product Only -->
                    <label class="flex items-center space-x-3 p-4 border-2 border-purple-200 rounded-lg hover:bg-purple-50 hover:border-purple-300 cursor-pointer transition-all duration-200">
                        <input type="checkbox" name="is_bundle_product" value="1" 
                            <?php echo e(old('is_bundle_product', $productData['is_bundle_product'] ?? $product->is_bundle_product ?? false) ? 'checked' : ''); ?>

                            class="h-5 w-5 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900">📦 Bundle Product Only</div>
                            <div class="text-xs text-gray-500">Only visible in pre-built bundles page</div>
                        </div>
                    </label>
                </div>
                <p class="text-xs text-gray-500 mt-2">💡 Select attributes to categorize and promote your product</p>
            </div>

            <!-- Final Action Buttons -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <h3 class="font-semibold text-green-800 mb-2">🎉 Ready to Update!</h3>
                <p class="text-sm text-green-700 mb-4">You've completed all the steps. Review your product details and click "Update Product" to save your changes.</p>
            </div>
        </div>
    </div>
</form>

<?php $__env->startPush('scripts'); ?>
<script>
// Update status and visibility display
document.addEventListener('DOMContentLoaded', function() {
    // No summary to update anymore
    console.log('Step 7 loaded');
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.products.edit._layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/admin/products/edit/step7.blade.php ENDPATH**/ ?>