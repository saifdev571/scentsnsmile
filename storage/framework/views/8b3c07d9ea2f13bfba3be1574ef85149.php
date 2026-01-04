

<?php $__env->startSection('title', 'Checkout - Scents N Smile'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 pt-20 lg:pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-wider">CHECKOUT</h1>
            <p class="text-gray-600 mt-2">Complete your order</p>
        </div>

        <!-- Error/Success Messages -->
        <div id="alertContainer" class="hidden mb-6">
            <div id="alertMessage" class="px-4 py-3 rounded-lg text-sm"></div>
        </div>

        <!-- Saved Addresses Section -->
        <?php if(isset($addresses) && $addresses->count() > 0): ?>
        <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm mb-6">
            <h2 class="text-base sm:text-lg font-bold uppercase tracking-wider mb-4">Saved Addresses</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border-2 border-gray-200 rounded-xl p-3 sm:p-4 cursor-pointer hover:border-[#e8a598] transition-colors address-card <?php echo e($address->is_default ? 'border-[#e8a598] bg-[#e8a598]/5' : ''); ?>" 
                     data-address='<?php echo json_encode($address, 15, 512) ?>'>
                    <div class="flex items-start gap-3">
                        <input type="radio" name="selected_address" value="<?php echo e($address->id); ?>" 
                               class="w-5 h-5 text-[#e8a598] mt-1 flex-shrink-0" <?php echo e($address->is_default ? 'checked' : ''); ?>>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                <span class="font-bold text-gray-900"><?php echo e($address->name); ?></span>
                                <span class="text-xs px-2 py-0.5 rounded <?php echo e($address->type === 'home' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700'); ?>">
                                    <?php echo e(ucfirst($address->type ?? 'Home')); ?>

                                </span>
                                <?php if($address->is_default): ?>
                                <span class="text-xs px-2 py-0.5 rounded bg-green-100 text-green-700">Default</span>
                                <?php endif; ?>
                            </div>
                            <p class="text-sm text-gray-600"><?php echo e($address->phone); ?></p>
                            <p class="text-sm text-gray-500 line-clamp-2">
                                <?php echo e($address->address_line_1); ?><?php if($address->address_line_2): ?>, <?php echo e($address->address_line_2); ?><?php endif; ?>, 
                                <?php echo e($address->city); ?>, <?php echo e($address->state); ?> - <?php echo e($address->pincode); ?>

                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Left Column - Shipping Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Contact Information -->
                <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm">
                    <h2 class="text-base sm:text-lg font-bold uppercase tracking-wider mb-4">Contact Information</h2>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                                <input type="text" name="first_name" id="first_name" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors"
                                    value="<?php echo e(isset($defaultAddress) && $defaultAddress->name ? explode(' ', $defaultAddress->name)[0] : ($user->name ? explode(' ', $user->name)[0] : '')); ?>">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                                <input type="text" name="last_name" id="last_name" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors"
                                    value="<?php echo e(isset($defaultAddress) && $defaultAddress->name && count(explode(' ', $defaultAddress->name)) > 1 ? explode(' ', $defaultAddress->name, 2)[1] : ($user->name && count(explode(' ', $user->name)) > 1 ? explode(' ', $user->name, 2)[1] : '')); ?>">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" id="email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors"
                                value="<?php echo e($user->email ?? ''); ?>">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-4 py-3 bg-gray-100 border border-r-0 border-gray-300 rounded-l-lg text-gray-600 text-sm">
                                    +91
                                </span>
                                <input type="tel" name="phone" id="phone" required maxlength="10"
                                    class="flex-1 px-4 py-3 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors"
                                    value="<?php echo e(isset($defaultAddress) && $defaultAddress->phone ? preg_replace('/[^0-9]/', '', str_replace('+91', '', $defaultAddress->phone)) : ($user->phone ?? '')); ?>" placeholder="10-digit mobile number">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm">
                    <h2 class="text-base sm:text-lg font-bold uppercase tracking-wider mb-4">Shipping Address</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 1 *</label>
                            <input type="text" name="address" id="address" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors"
                                placeholder="House/Flat No., Building Name"
                                value="<?php echo e(isset($defaultAddress) ? $defaultAddress->address_line_1 : ''); ?>">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 2 (Optional)</label>
                            <input type="text" name="address_line_2" id="address_line_2"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors"
                                placeholder="Street, Area, Landmark"
                                value="<?php echo e(isset($defaultAddress) ? $defaultAddress->address_line_2 : ''); ?>">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">PIN Code *</label>
                                <input type="text" name="zipcode" id="zipcode" required maxlength="6"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors"
                                    placeholder="6-digit PIN"
                                    value="<?php echo e(isset($defaultAddress) ? $defaultAddress->pincode : ''); ?>">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                <input type="text" name="city" id="city" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors"
                                    value="<?php echo e(isset($defaultAddress) ? $defaultAddress->city : ''); ?>">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                            <input type="text" name="state" id="state" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors"
                                value="<?php echo e(isset($defaultAddress) ? $defaultAddress->state : ''); ?>">
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm">
                    <h2 class="text-base sm:text-lg font-bold uppercase tracking-wider mb-4">Payment Method</h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border-2 border-[#e8a598] bg-[#e8a598]/5 rounded-xl cursor-pointer transition-colors payment-option">
                            <input type="radio" name="payment_method" value="cod" checked class="w-5 h-5 text-[#e8a598] focus:ring-[#e8a598]">
                            <div class="ml-4 flex-1">
                                <span class="font-semibold text-gray-900">Cash on Delivery (COD)</span>
                                <p class="text-sm text-gray-500">Pay when you receive your order</p>
                            </div>
                            <span class="text-2xl">💵</span>
                        </label>
                        
                        <?php if($razorpayEnabled && $razorpayKeyId): ?>
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-[#e8a598] transition-colors payment-option">
                            <input type="radio" name="payment_method" value="online" class="w-5 h-5 text-[#e8a598] focus:ring-[#e8a598]">
                            <div class="ml-4 flex-1">
                                <span class="font-semibold text-gray-900">Pay Online</span>
                                <p class="text-sm text-gray-500">UPI, Card, Net Banking, Wallets</p>
                            </div>
                            <div class="flex items-center gap-1">
                                <img src="https://razorpay.com/favicon.png" alt="Razorpay" class="w-6 h-6">
                                <span class="text-xs text-gray-400">Secured by Razorpay</span>
                            </div>
                        </label>
                        <?php else: ?>
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-not-allowed opacity-50">
                            <input type="radio" name="payment_method" value="online" disabled class="w-5 h-5 text-gray-400">
                            <div class="ml-4 flex-1">
                                <span class="font-semibold text-gray-500">Pay Online</span>
                                <p class="text-sm text-gray-400">Currently unavailable</p>
                            </div>
                            <span class="text-2xl opacity-50">💳</span>
                        </label>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm">
                    <h2 class="text-base sm:text-lg font-bold uppercase tracking-wider mb-4">Order Notes (Optional)</h2>
                    <textarea name="order_notes" id="order_notes" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] outline-none transition-colors resize-none"
                        placeholder="Any special instructions for delivery..."></textarea>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm sticky top-24">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-[#e8a598] to-[#F27F6E] px-4 sm:px-6 py-4 rounded-t-2xl">
                        <h2 class="text-base sm:text-lg font-bold text-white uppercase tracking-wider">Order Summary</h2>
                        <p class="text-white/80 text-sm"><?php echo e($itemCount); ?> item(s)</p>
                    </div>

                    <!-- Cart Items -->
                    <div class="p-4 sm:p-6 border-b max-h-64 overflow-y-auto">
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex gap-3 mb-4 last:mb-0">
                            <div class="w-16 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                <?php if($item->product->image_url): ?>
                                <img src="<?php echo e($item->product->image_url); ?>" alt="<?php echo e($item->product->name); ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-2xl">🌸</div>
                                <?php endif; ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-sm text-gray-900 line-clamp-2"><?php echo e($item->product->name); ?></h4>
                                <p class="text-gray-500 text-xs mt-1">Qty: <?php echo e($item->quantity); ?></p>
                                <p class="font-bold text-sm mt-1">₹<?php echo e(number_format($item->price * $item->quantity, 0)); ?></p>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="p-4 sm:p-6 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold">₹<?php echo e(number_format($subtotal, 0)); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-semibold <?php echo e($shipping == 0 ? 'text-green-600' : ''); ?>">
                                <?php echo e($shipping == 0 ? 'FREE' : '₹' . number_format($shipping, 0)); ?>

                            </span>
                        </div>
                        
                        <?php if($discount > 0): ?>
                        <div class="flex justify-between" style="color: <?php echo e($activePromotion->badge_color ?? '#e8a598'); ?>">
                            <span class="font-medium"><?php echo e($activePromotion->cart_label ?? 'Discount'); ?> (<?php echo e($activePromotion ? $activePromotion->discount_text : '40% OFF'); ?>)</span>
                            <span class="font-semibold">-₹<?php echo e(number_format($discount, 0)); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="border-t pt-3 mt-3">
                            <div class="flex justify-between text-lg">
                                <span class="font-bold">Total</span>
                                <span class="font-bold text-[#e8a598]">₹<?php echo e(number_format($total, 0)); ?></span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Inclusive of all taxes</p>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <div class="p-4 sm:p-6 pt-0">
                        <button type="button" id="placeOrderBtn"
                            class="w-full bg-gradient-to-r from-[#e8a598] to-[#F27F6E] hover:opacity-90 text-white font-bold py-4 rounded-full text-base transition-all flex items-center justify-center gap-2">
                            <span id="btnText">PLACE ORDER</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </button>
                        <p class="text-center text-xs text-gray-500 mt-3">
                            By placing this order, you agree to our Terms & Conditions
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Processing Modal -->
<div id="processingModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl p-8 max-w-sm w-full text-center">
            <div class="w-16 h-16 border-4 border-[#e8a598] border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <h3 class="text-lg font-bold text-gray-900" id="processingTitle">Processing Order</h3>
            <p class="text-gray-500 mt-2" id="processingText">Please wait while we process your order...</p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- Razorpay SDK -->
<?php if($razorpayEnabled && $razorpayKeyId): ?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<?php endif; ?>

<script>
(function() {
    var razorpayEnabled = <?php echo e($razorpayEnabled ? 'true' : 'false'); ?>;
    var razorpayKeyId = '<?php echo e($razorpayKeyId ?? ""); ?>';
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Auto-fill form when saved address is clicked
    document.querySelectorAll('.address-card').forEach(function(card) {
        card.addEventListener('click', function() {
            var address = JSON.parse(this.dataset.address);
            
            var nameParts = (address.name || '').split(' ');
            document.getElementById('first_name').value = nameParts[0] || '';
            document.getElementById('last_name').value = nameParts.slice(1).join(' ') || '';
            
            document.getElementById('phone').value = (address.phone || '').replace('+91', '').trim();
            document.getElementById('address').value = address.address_line_1 || '';
            document.getElementById('address_line_2').value = address.address_line_2 || '';
            document.getElementById('city').value = address.city || '';
            document.getElementById('state').value = address.state || '';
            document.getElementById('zipcode').value = address.pincode || '';
            
            this.querySelector('input[type="radio"]').checked = true;
            
            document.querySelectorAll('.address-card').forEach(function(c) {
                c.classList.remove('border-[#e8a598]', 'bg-[#e8a598]/5');
                c.classList.add('border-gray-200');
            });
            
            this.classList.remove('border-gray-200');
            this.classList.add('border-[#e8a598]', 'bg-[#e8a598]/5');
        });
    });

    // Payment method selection styling
    document.querySelectorAll('.payment-option').forEach(function(option) {
        option.addEventListener('click', function() {
            var radio = this.querySelector('input[type="radio"]');
            if (radio && !radio.disabled) {
                document.querySelectorAll('.payment-option').forEach(function(o) {
                    o.classList.remove('border-[#e8a598]', 'bg-[#e8a598]/5');
                    o.classList.add('border-gray-200');
                });
                this.classList.remove('border-gray-200');
                this.classList.add('border-[#e8a598]', 'bg-[#e8a598]/5');
                
                // Update button text
                var btnText = document.getElementById('btnText');
                if (radio.value === 'online') {
                    btnText.textContent = 'PAY NOW';
                } else {
                    btnText.textContent = 'PLACE ORDER';
                }
            }
        });
    });

    // Show alert message
    function showAlert(message, type) {
        var container = document.getElementById('alertContainer');
        var alertEl = document.getElementById('alertMessage');
        
        container.classList.remove('hidden');
        alertEl.textContent = message;
        
        if (type === 'error') {
            alertEl.className = 'px-4 py-3 rounded-lg text-sm bg-red-50 border border-red-200 text-red-700';
        } else {
            alertEl.className = 'px-4 py-3 rounded-lg text-sm bg-green-50 border border-green-200 text-green-700';
        }
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        setTimeout(function() {
            container.classList.add('hidden');
        }, 5000);
    }

    // Show/hide processing modal
    function showProcessing(show, title, text) {
        var modal = document.getElementById('processingModal');
        if (show) {
            document.getElementById('processingTitle').textContent = title || 'Processing Order';
            document.getElementById('processingText').textContent = text || 'Please wait while we process your order...';
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    // Validate form
    function validateForm() {
        var required = ['first_name', 'last_name', 'email', 'phone', 'address', 'city', 'state', 'zipcode'];
        var errors = [];
        
        required.forEach(function(field) {
            var input = document.getElementById(field);
            if (!input.value.trim()) {
                errors.push(field.replace('_', ' ') + ' is required');
                input.classList.add('border-red-500');
            } else {
                input.classList.remove('border-red-500');
            }
        });
        
        var email = document.getElementById('email').value;
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            errors.push('Please enter a valid email address');
        }
        
        var phone = document.getElementById('phone').value;
        if (phone && !/^\d{10}$/.test(phone.replace(/\D/g, ''))) {
            errors.push('Please enter a valid 10-digit phone number');
        }
        
        var zipcode = document.getElementById('zipcode').value;
        if (zipcode && !/^\d{6}$/.test(zipcode)) {
            errors.push('Please enter a valid 6-digit PIN code');
        }
        
        return errors;
    }

    // Get form data
    function getFormData() {
        return {
            first_name: document.getElementById('first_name').value.trim(),
            last_name: document.getElementById('last_name').value.trim(),
            email: document.getElementById('email').value.trim(),
            phone: document.getElementById('phone').value.trim(),
            address: document.getElementById('address').value.trim(),
            address_line_2: document.getElementById('address_line_2').value.trim(),
            city: document.getElementById('city').value.trim(),
            state: document.getElementById('state').value.trim(),
            zipcode: document.getElementById('zipcode').value.trim(),
            order_notes: document.getElementById('order_notes').value.trim()
        };
    }

    // Process COD Order
    function processCODOrder(formData) {
        formData.payment_method = 'cod';
        
        fetch('<?php echo e(route("checkout.process")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(formData)
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            showProcessing(false);
            
            if (data.success) {
                window.location.href = data.redirect_url;
            } else {
                showAlert(data.message || 'Something went wrong. Please try again.', 'error');
                document.getElementById('placeOrderBtn').disabled = false;
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            showProcessing(false);
            showAlert('Something went wrong. Please try again.', 'error');
            document.getElementById('placeOrderBtn').disabled = false;
        });
    }

    // Process Online Payment with Razorpay
    function processOnlinePayment(formData) {
        showProcessing(true, 'Initializing Payment', 'Please wait while we set up your payment...');
        
        // First create Razorpay order
        fetch('<?php echo e(route("checkout.razorpay.create")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(formData)
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            showProcessing(false);
            
            if (data.success) {
                // Open Razorpay checkout
                openRazorpayCheckout(data);
            } else {
                showAlert(data.message || 'Failed to initialize payment', 'error');
                document.getElementById('placeOrderBtn').disabled = false;
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            showProcessing(false);
            showAlert('Failed to initialize payment. Please try again.', 'error');
            document.getElementById('placeOrderBtn').disabled = false;
        });
    }

    // Open Razorpay Checkout
    function openRazorpayCheckout(orderData) {
        var options = {
            key: orderData.razorpay_key_id,
            amount: orderData.amount,
            currency: orderData.currency,
            name: orderData.name,
            description: orderData.description,
            order_id: orderData.razorpay_order_id,
            prefill: orderData.prefill,
            theme: {
                color: '#e8a598'
            },
            modal: {
                ondismiss: function() {
                    document.getElementById('placeOrderBtn').disabled = false;
                    showAlert('Payment cancelled. You can try again.', 'error');
                }
            },
            handler: function(response) {
                // Payment successful, verify on server
                verifyPayment(response);
            }
        };
        
        var rzp = new Razorpay(options);
        
        rzp.on('payment.failed', function(response) {
            document.getElementById('placeOrderBtn').disabled = false;
            showAlert('Payment failed: ' + response.error.description, 'error');
        });
        
        rzp.open();
    }

    // Verify Payment on Server
    function verifyPayment(paymentResponse) {
        showProcessing(true, 'Verifying Payment', 'Please wait while we verify your payment...');
        
        fetch('<?php echo e(route("checkout.razorpay.verify")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                razorpay_payment_id: paymentResponse.razorpay_payment_id,
                razorpay_order_id: paymentResponse.razorpay_order_id,
                razorpay_signature: paymentResponse.razorpay_signature
            })
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            showProcessing(false);
            
            if (data.success) {
                // Redirect to success page
                window.location.href = data.redirect_url;
            } else {
                showAlert(data.message || 'Payment verification failed', 'error');
                document.getElementById('placeOrderBtn').disabled = false;
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            showProcessing(false);
            showAlert('Payment verification failed. Please contact support.', 'error');
            document.getElementById('placeOrderBtn').disabled = false;
        });
    }

    // Place Order Button Click
    document.getElementById('placeOrderBtn').addEventListener('click', function() {
        var errors = validateForm();
        
        if (errors.length > 0) {
            showAlert(errors[0], 'error');
            return;
        }
        
        // Disable button
        this.disabled = true;
        
        var formData = getFormData();
        var paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        
        if (paymentMethod === 'online' && razorpayEnabled) {
            // Online payment flow
            processOnlinePayment(formData);
        } else {
            // COD flow
            showProcessing(true, 'Processing Order', 'Please wait while we process your order...');
            processCODOrder(formData);
        }
    });

    // Auto-select default address on page load
    var defaultCard = document.querySelector('.address-card.border-\\[\\#e8a598\\]');
    if (defaultCard) {
        defaultCard.click();
    }
})();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/checkout.blade.php ENDPATH**/ ?>