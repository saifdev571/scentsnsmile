

<?php $__env->startSection('title', 'Bundle - Scents N Smile'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen pt-36 sm:pt-28 md:pt-32 pb-6 sm:pb-8 px-3 sm:px-4" style="background-color: #f5e6d3;">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Bundle Section -->
                <div class="lg:col-span-2">
                    <div class="bg-[#e8d5c4] rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8">
                        <!-- Header -->
                        <div class="mb-4 sm:mb-6">
                            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-1 sm:mb-2">Bundle.</h1>
                            <p class="text-xs sm:text-sm md:text-base text-gray-700">
                                Choose 2+ fragrances for better savings. More (common) scents pays off.
                            </p>
                        </div>

                        <!-- Bundle Slots Carousel -->
                        <div class="relative">
                            <!-- Left Arrow -->
                            <button id="prevBtn"
                                class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 sm:-translate-x-3 md:-translate-x-4 z-10 bg-white rounded-full p-2 sm:p-2.5 md:p-3 shadow-lg hover:shadow-xl transition-shadow disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-gray-700" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <!-- Cards Container -->
                            <div class="overflow-hidden">
                                <div id="carouselTrack"
                                    class="flex gap-2 sm:gap-2.5 md:gap-3 transition-transform duration-300 ease-in-out">
                                    <!-- Slot 1 -->
                                    <div
                                        class="bundle-slot bg-white rounded-xl sm:rounded-2xl w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 flex-shrink-0 flex flex-col items-center justify-center cursor-pointer hover:shadow-lg transition-shadow">
                                        <button
                                            class="add-item-btn text-red-400 text-2xl sm:text-3xl mb-0.5 sm:mb-1">+</button>
                                        <span class="slot-number text-lg sm:text-xl md:text-2xl font-light text-gray-400">1</span>
                                    </div>

                                    <!-- Slot 2 - 40% OFF -->
                                    <div
                                        class="bundle-slot bg-white rounded-xl sm:rounded-2xl w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 flex-shrink-0 flex flex-col items-center justify-center cursor-pointer hover:shadow-lg transition-shadow relative">
                                        <div class="slot-badge absolute top-0.5 sm:top-1 left-1/2 -translate-x-1/2">
                                            <span
                                                class="bg-red-500 text-white text-[8px] sm:text-[9px] px-1.5 sm:px-2 py-0.5 rounded-full font-bold">40%
                                                OFF</span>
                                        </div>
                                        <button
                                            class="add-item-btn text-red-400 text-2xl sm:text-3xl mb-0.5 sm:mb-1 mt-2 sm:mt-3">+</button>
                                        <span class="slot-number text-lg sm:text-xl md:text-2xl font-light text-gray-400">2</span>
                                    </div>

                                    <!-- Slot 3 - Free Shipping -->
                                    <div
                                        class="bundle-slot bg-white rounded-xl sm:rounded-2xl w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 flex-shrink-0 flex flex-col items-center justify-center cursor-pointer hover:shadow-lg transition-shadow relative">
                                        <div class="slot-badge absolute top-0.5 sm:top-1 left-1/2 -translate-x-1/2 w-[85%]">
                                            <span
                                                class="bg-red-500 text-white text-[8px] sm:text-[9px] px-1 sm:px-1.5 py-0.5 rounded-full font-bold block text-center">Free
                                                Shipping</span>
                                        </div>
                                        <button
                                            class="add-item-btn text-red-400 text-2xl sm:text-3xl mb-0.5 sm:mb-1 mt-2 sm:mt-3">+</button>
                                        <span class="slot-number text-lg sm:text-xl md:text-2xl font-light text-gray-400">3</span>
                                    </div>

                                    <!-- Slot 4-9 -->
                                    <?php for($i = 4; $i <= 9; $i++): ?>
                                    <div
                                        class="bundle-slot bg-white rounded-xl sm:rounded-2xl w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 flex-shrink-0 flex flex-col items-center justify-center cursor-pointer hover:shadow-lg transition-shadow">
                                        <button
                                            class="add-item-btn text-red-400 text-2xl sm:text-3xl mb-0.5 sm:mb-1">+</button>
                                        <span class="slot-number text-lg sm:text-xl md:text-2xl font-light text-gray-400"><?php echo e($i); ?></span>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <!-- Right Arrow -->
                            <button id="nextBtn"
                                class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 sm:translate-x-3 md:translate-x-4 z-10 bg-white rounded-full p-2 sm:p-2.5 md:p-3 shadow-lg hover:shadow-xl transition-shadow disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pricing Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-[#e8d5c4] rounded-2xl sm:rounded-3xl p-4 sm:p-5 md:p-6 lg:sticky lg:top-24">
                        <!-- Initial Price -->
                        <div class="mb-4 sm:mb-5 md:mb-6">
                            <div class="flex justify-between items-center mb-1 sm:mb-2">
                                <span class="text-xs sm:text-sm font-medium text-gray-700">Initial Price</span>
                                <span class="initial-price text-base sm:text-lg font-bold">₹0</span>
                            </div>
                        </div>

                        <!-- Discount Message -->
                        <div class="mb-4 sm:mb-5 md:mb-6 pb-4 sm:pb-5 md:pb-6 border-b border-gray-400">
                            <p class="discount-message text-xs sm:text-sm text-gray-700">Add 2 items for 40% off</p>
                        </div>

                        <!-- Subtotal -->
                        <div class="mb-4 sm:mb-5 md:mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-base sm:text-lg font-bold">SUBTOTAL</span>
                                <span class="subtotal-price text-xl sm:text-2xl font-bold">₹0</span>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <button
                            class="checkout-btn w-full bg-[#ff8b7b] hover:bg-[#ff7a68] text-white font-bold py-3 sm:py-3.5 md:py-4 rounded-full text-sm sm:text-base md:text-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            CHECKOUT
                        </button>
                    </div>
                </div>

                <!-- Product Listing Section - Full Width Below -->
                <div class="lg:col-span-3">
                    <section class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8">
                        <!-- Top Filter Bar -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                            <!-- Left Side - Filter Pills -->
                            <div class="flex items-center gap-3">
                                <button class="h-9 px-4 text-sm font-medium rounded-full border border-[#ff6b5a] text-[#ff6b5a] bg-white">All Perfumes</button>
                                <button class="h-9 px-4 text-sm font-medium rounded-full border border-[#ff6b5a] text-[#ff6b5a] bg-white">Bestsellers</button>
                            </div>
                            <!-- Right Side - Search -->
                            <div class="relative w-full sm:w-auto">
                                <input type="text" placeholder="Search perfumes..." class="h-9 w-full sm:w-64 pl-4 pr-12 text-sm rounded-full border border-gray-300 focus:outline-none focus:border-[#ff6b5a]">
                                <button class="absolute right-1 top-1/2 -translate-y-1/2 w-7 h-7 bg-[#ff6b5a] rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Product Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo $__env->make('partials.product-card', ['product' => $product, 'buttonText' => 'ADD TO BUNDLE', 'buttonClass' => 'add-to-bundle-btn'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Bundle Management System - Each item has product info + quantity
        let bundleItems = [];
        const maxSlots = 9;
        <?php
            $bundleData = $products->map(function($p) {
                $firstImage = $p->images_array && count($p->images_array) > 0 ? $p->images_array[0] : ($p->image_url ?? '');
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'price' => $p->sale_price && $p->sale_price < $p->price ? $p->sale_price : $p->price,
                    'image' => $firstImage
                ];
            });
        ?>
        let bundleData = <?php echo json_encode($bundleData, 15, 512) ?>;

        // Load existing bundle from database
        <?php if(isset($existingBundle) && $existingBundle): ?>
            bundleItems = <?php echo json_encode($existingBundle->items, 15, 512) ?>;
            console.log('Loaded existing bundle:', bundleItems);
        <?php endif; ?>

        // Save bundle to database
        function saveBundleToDatabase() {
            // If bundle is empty, clear it from database
            if (bundleItems.length === 0) {
                fetch('<?php echo e(route("bundle.clear")); ?>', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Bundle cleared from database');
                    }
                })
                .catch(error => {
                    console.error('Error clearing bundle:', error);
                });
                return;
            }

            fetch('<?php echo e(route("bundle.save")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    items: bundleItems
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Bundle saved to database:', data.bundle);
                }
            })
            .catch(error => {
                console.error('Error saving bundle:', error);
            });
        }

        // Add to Bundle Function
        window.addToBundle = function(productId) {
            const product = bundleData.find(p => p.id === productId);
            if (!product) return;

            // Check if product already exists in bundle
            const existingItem = bundleItems.find(item => item.id === productId);
            
            if (existingItem) {
                // Just increase quantity - DON'T move the slot
                existingItem.quantity++;
            } else {
                // Check if we have space for new slot
                if (bundleItems.length >= maxSlots) {
                    alert('Maximum 9 different products allowed in bundle');
                    return;
                }
                // Add new product with quantity 1
                bundleItems.push({
                    ...product,
                    quantity: 1
                });
            }
            
            updateBundleUI();
            updatePricing();
            saveBundleToDatabase(); // Save to database
        };

        // Remove from Bundle - Decrease quantity or remove if quantity is 1
        window.removeFromBundle = function(index) {
            console.log('Removing from bundle, index:', index);
            console.log('Before remove:', JSON.parse(JSON.stringify(bundleItems)));
            
            const item = bundleItems[index];
            
            if (!item) {
                console.error('Item not found at index:', index);
                return;
            }
            
            if (item.quantity > 1) {
                // Decrease quantity by 1
                item.quantity--;
                console.log('Decreased quantity to:', item.quantity);
            } else {
                // Remove item completely if quantity is 1
                bundleItems.splice(index, 1);
                console.log('Removed item completely');
            }
            
            console.log('After remove:', JSON.parse(JSON.stringify(bundleItems)));
            
            updateBundleUI();
            updatePricing();
            saveBundleToDatabase(); // Save to database
        };

        // Update Bundle Slots UI
        function updateBundleUI() {
            const slots = document.querySelectorAll('.bundle-slot');
            
            slots.forEach((slot, index) => {
                const addBtn = slot.querySelector('.add-item-btn');
                const slotNumber = slot.querySelector('.slot-number, span:not(.bg-red-500):not(.bg-green-600):not([class*="bg-red"])');
                const slotBadge = slot.querySelector('.slot-badge, div[class*="absolute top"]');
                
                // Make slot relative for absolute positioning
                slot.style.position = 'relative';
                
                // Clear existing content
                slot.querySelectorAll('.bundle-item-content').forEach(el => el.remove());
                
                if (bundleItems[index]) {
                    const item = bundleItems[index];
                    
                    // Hide add button, number, and badges
                    if (addBtn) addBtn.style.display = 'none';
                    if (slotNumber) slotNumber.style.display = 'none';
                    if (slotBadge) slotBadge.style.display = 'none';
                    
                    // Add product image, name, and quantity badge
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'bundle-item-content absolute inset-0 flex flex-col items-center justify-center p-2';
                    itemDiv.innerHTML = `
                        <button onclick="removeFromBundle(${index})" class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white rounded-full text-xs flex items-center justify-center hover:bg-red-600 z-10">
                            ×
                        </button>
                        ${item.quantity > 1 ? `<span class="absolute bottom-1 left-1 min-w-[20px] h-5 px-1.5 bg-green-600 text-white rounded-full text-xs flex items-center justify-center font-bold z-10">${item.quantity}</span>` : ''}
                        <img src="${item.image || ''}" alt="${item.name}" class="w-full h-3/4 object-contain mb-1" onerror="this.style.display='none'">
                        <p class="text-[8px] sm:text-[9px] text-center font-medium text-gray-700 line-clamp-2">${item.name}</p>
                    `;
                    slot.appendChild(itemDiv);
                } else {
                    // Show add button, number, and badges
                    if (addBtn) addBtn.style.display = 'block';
                    if (slotNumber) slotNumber.style.display = 'block';
                    if (slotBadge) slotBadge.style.display = 'block';
                }
            });
        }

        // Update Pricing and Discounts
        function updatePricing() {
            // Calculate total items (including quantities)
            const totalItems = bundleItems.reduce((sum, item) => sum + item.quantity, 0);
            
            // Calculate total price (price * quantity for each item)
            let totalPrice = bundleItems.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0);
            
            let discount = 0;
            let discountMessage = '';

            // Calculate discount based on total item count
            if (totalItems >= 2) {
                discount = 0.40; // 40% off
                discountMessage = `${totalItems} item${totalItems > 1 ? 's' : ''} - 40% OFF applied!`;
            }

            const discountedPrice = totalPrice * (1 - discount);
            const savings = totalPrice - discountedPrice;

            // Update Initial Price
            const initialPriceEl = document.querySelector('.initial-price');
            if (initialPriceEl) {
                initialPriceEl.textContent = '₹' + Math.round(totalPrice);
            }

            // Update Discount Message
            const discountMsgEl = document.querySelector('.discount-message');
            if (discountMsgEl) {
                if (totalItems < 2) {
                    discountMsgEl.textContent = `Add ${2 - totalItems} item${2 - totalItems > 1 ? 's' : ''} for 40% off`;
                    discountMsgEl.className = 'discount-message text-xs sm:text-sm text-gray-700';
                } else {
                    discountMsgEl.textContent = discountMessage + ` (Save ₹${Math.round(savings)})`;
                    discountMsgEl.className = 'discount-message text-xs sm:text-sm text-green-700 font-semibold';
                }
            }

            // Update Subtotal
            const subtotalEl = document.querySelector('.subtotal-price');
            if (subtotalEl) {
                subtotalEl.textContent = '₹' + Math.round(discountedPrice);
            }

            // Update Checkout Button
            const checkoutBtn = document.querySelector('.checkout-btn');
            if (checkoutBtn) {
                if (totalItems === 0) {
                    checkoutBtn.disabled = true;
                    checkoutBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    checkoutBtn.disabled = false;
                    checkoutBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        // Carousel navigation
        let currentIndex = 0;
        const track = document.getElementById('carouselTrack');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const totalCards = 9;
        const visibleCards = 6;
        const maxIndex = totalCards - visibleCards;

        function getCardWidth() {
            const cards = document.querySelectorAll('.bundle-slot');
            if (cards.length > 0) {
                const cardRect = cards[0].getBoundingClientRect();
                const gap = window.innerWidth < 640 ? 8 : (window.innerWidth < 768 ? 10 : 12);
                return cardRect.width + gap;
            }
            return 140;
        }

        function updateCarousel() {
            const cardWidth = getCardWidth();
            const translateX = -(currentIndex * cardWidth);
            track.style.transform = `translateX(${translateX}px)`;
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= maxIndex;
        }

        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentIndex < maxIndex) {
                currentIndex++;
                updateCarousel();
            }
        });

        // Checkout Function
        document.querySelector('.checkout-btn').addEventListener('click', function() {
            if (bundleItems.length === 0) {
                alert('Please add items to your bundle');
                return;
            }
            
            // Add bundle items to cart with their quantities
            bundleItems.forEach(item => {
                for (let i = 0; i < item.quantity; i++) {
                    addToCart(item.id);
                }
            });
            
            // Redirect to cart
            setTimeout(() => {
                window.location.href = '<?php echo e(route("cart.index")); ?>';
            }, 500);
        });

        updateCarousel();
        window.addEventListener('resize', updateCarousel);
        
        // Initialize bundle UI and pricing on page load
        if (bundleItems.length > 0) {
            updateBundleUI();
            updatePricing();
        } else {
            updatePricing(); // Initialize pricing even if empty
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/bundle.blade.php ENDPATH**/ ?>