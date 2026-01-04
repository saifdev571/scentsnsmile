

<?php $__env->startSection('step_title', 'Step 5: Product Variants'); ?>
<?php $__env->startSection('step_description', 'Add size variants for your product'); ?>

<?php $__env->startSection('step_content'); ?>
<?php
    $currentStep = 5;
    $prevStepRoute = route('admin.products.create.step4');
?>

<form id="stepForm" action="<?php echo e(route('admin.products.create.step5.process')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    
    <div class="bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-purple-50">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                    <span class="text-white text-xl">📏</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Product Variants</h2>
                    <p class="text-gray-600 font-medium">Add size variants for your product</p>
                </div>
            </div>
        </div>
        
        <div class="p-8 space-y-6">
            <!-- Enable Variants Toggle -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">📦</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Enable Size Variants</h3>
                        <p class="text-sm text-gray-600">Offer this product in multiple sizes</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="hasSizeVariants" class="sr-only peer">
                    <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-600"></div>
                </label>
            </div>

            <!-- Size Variants Section -->
            <div id="sizeVariantsSection" class="space-y-6" style="display: none;">
                <!-- Available Sizes -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-3">Select Available Sizes</label>
                    <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3">
                        <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="cursor-pointer group">
                            <input type="checkbox" name="selected_sizes[]" value="<?php echo e($size->id); ?>" class="hidden size-checkbox" data-size-name="<?php echo e($size->name); ?>">
                            <div class="relative">
                                <div class="h-16 rounded-lg border-2 border-gray-300 transition-all duration-200 flex flex-col items-center justify-center bg-white hover:border-indigo-400 hover:shadow-md size-box">
                                    <span class="font-bold text-lg text-gray-700"><?php echo e($size->abbreviation ?? substr($size->name, 0, 3)); ?></span>
                                    <span class="text-xs text-gray-500 mt-0.5"><?php echo e($size->name); ?></span>
                                </div>
                                <div class="absolute -top-2 -right-2 hidden size-checkmark">
                                    <div class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center shadow-lg">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">💡 Select all sizes that will be available for this product</p>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-900 mb-1">About Size Variants</h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Each size will have its own stock and pricing options</li>
                                <li>• You can manage individual size inventory later</li>
                                <li>• Customers will see all available sizes on the product page</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- No Variants Message -->
            <div id="noVariantsMessage" class="text-center py-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                    <span class="text-3xl">📦</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Variants Enabled</h3>
                <p class="text-gray-600">Enable size variants above to offer this product in multiple sizes</p>
            </div>

            <!-- Hidden inputs for variants -->
            <input type="hidden" name="has_variants" id="hasVariantsInput" value="0">
            <input type="hidden" name="variant_sizes" id="variantSizesInput" value="[]">
        </div>
    </div>
</form>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Step 5 Variant Manager Loaded');
    
    let selectedSizes = [];
    
    const hasSizeCheckbox = document.getElementById('hasSizeVariants');
    const sizeSection = document.getElementById('sizeVariantsSection');
    const noVariantsMessage = document.getElementById('noVariantsMessage');
    
    // Toggle Size Variants
    hasSizeCheckbox.addEventListener('change', function() {
        if (this.checked) {
            sizeSection.style.display = 'block';
            noVariantsMessage.style.display = 'none';
        } else {
            sizeSection.style.display = 'none';
            noVariantsMessage.style.display = 'block';
            selectedSizes = [];
            resetSizeCheckboxes();
        }
        updateHiddenInputs();
    });
    
    // Handle Size Selection
    document.querySelectorAll('.size-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const parent = this.parentElement;
            const sizeBox = parent.querySelector('.size-box');
            const checkmark = parent.querySelector('.size-checkmark');
            
            if (this.checked) {
                selectedSizes.push(this.value);
                sizeBox.classList.add('border-indigo-600', 'bg-indigo-50', 'ring-2', 'ring-indigo-200');
                sizeBox.classList.remove('border-gray-300', 'bg-white');
                sizeBox.querySelector('span:first-child').classList.add('text-indigo-700');
                sizeBox.querySelector('span:first-child').classList.remove('text-gray-700');
                checkmark.classList.remove('hidden');
            } else {
                selectedSizes = selectedSizes.filter(id => id !== this.value);
                sizeBox.classList.remove('border-indigo-600', 'bg-indigo-50', 'ring-2', 'ring-indigo-200');
                sizeBox.classList.add('border-gray-300', 'bg-white');
                sizeBox.querySelector('span:first-child').classList.remove('text-indigo-700');
                sizeBox.querySelector('span:first-child').classList.add('text-gray-700');
                checkmark.classList.add('hidden');
            }
            
            updateHiddenInputs();
        });
    });
    
    function updateHiddenInputs() {
        document.getElementById('hasVariantsInput').value = hasSizeCheckbox.checked ? '1' : '0';
        document.getElementById('variantSizesInput').value = JSON.stringify(selectedSizes);
        
        console.log('Variants Updated:', {
            hasVariants: hasSizeCheckbox.checked,
            selectedSizes: selectedSizes
        });
    }
    
    function resetSizeCheckboxes() {
        document.querySelectorAll('.size-checkbox').forEach(cb => {
            cb.checked = false;
            const parent = cb.parentElement;
            const box = parent.querySelector('.size-box');
            box.classList.remove('border-indigo-600', 'bg-indigo-50', 'ring-2', 'ring-indigo-200');
            box.classList.add('border-gray-300', 'bg-white');
            box.querySelector('span:first-child').classList.remove('text-indigo-700');
            box.querySelector('span:first-child').classList.add('text-gray-700');
            parent.querySelector('.size-checkmark').classList.add('hidden');
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.products.create._layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/admin/products/create/step5.blade.php ENDPATH**/ ?>