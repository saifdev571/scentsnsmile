<!-- Footer -->
<footer class="bg-gradient-to-b from-gray-50 to-gray-100 pt-16 pb-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12 mb-12">
            <!-- Brand & Newsletter -->
            <div class="sm:col-span-2 lg:col-span-1">
                <!-- Logo -->
                <div class="mb-6">
                    <img src="<?php echo e(asset('images/logo-transparent.png')); ?>" alt="<?php echo e($settings['business_name'] ?? 'Scents N Smile'); ?>" class="h-12 w-auto">
                </div>
                <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                    Discover your signature scent. Premium fragrances crafted with love, designed to make you smile.
                </p>
                
                <!-- Newsletter -->
                <h3 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-wider">Stay Updated</h3>
                <form id="newsletterForm" class="flex gap-2 mb-2">
                    <input type="email" 
                           id="newsletterEmail"
                           placeholder="Your email" 
                           required
                           class="flex-1 px-4 py-2.5 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#e8a598] bg-white">
                    <button type="submit" id="newsletterBtn" class="px-5 py-2.5 bg-gradient-to-r from-[#e8a598] to-[#F27F6E] text-white rounded-full text-xs font-bold hover:opacity-90 transition-all uppercase tracking-wide disabled:opacity-50">
                        Join
                    </button>
                </form>
                <p id="newsletterMessage" class="text-xs mb-4 hidden"></p>
                
                <!-- Social Icons -->
                <div class="flex gap-3">
                    <?php if(isset($settings['instagram']) && $settings['instagram']): ?>
                    <a href="<?php echo e($settings['instagram']); ?>" target="_blank" class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center hover:bg-[#e8a598] hover:border-[#e8a598] hover:text-white transition-all group">
                        <svg class="w-4 h-4 text-gray-600 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                    <?php if(isset($settings['facebook']) && $settings['facebook']): ?>
                    <a href="<?php echo e($settings['facebook']); ?>" target="_blank" class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center hover:bg-[#e8a598] hover:border-[#e8a598] hover:text-white transition-all group">
                        <svg class="w-4 h-4 text-gray-600 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                    <?php if(isset($settings['twitter']) && $settings['twitter']): ?>
                    <a href="<?php echo e($settings['twitter']); ?>" target="_blank" class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center hover:bg-[#e8a598] hover:border-[#e8a598] hover:text-white transition-all group">
                        <svg class="w-4 h-4 text-gray-600 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                    <?php if(isset($settings['pinterest']) && $settings['pinterest']): ?>
                    <a href="<?php echo e($settings['pinterest']); ?>" target="_blank" class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center hover:bg-[#e8a598] hover:border-[#e8a598] hover:text-white transition-all group">
                        <svg class="w-4 h-4 text-gray-600 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Shop</h3>
                <ul class="space-y-3">
                    <li><a href="<?php echo e(route('collections')); ?>" class="text-sm text-gray-600 hover:text-[#e8a598] transition-colors">All Products</a></li>
                    <li><a href="<?php echo e(route('collections.show', 'bestsellers')); ?>" class="text-sm text-gray-600 hover:text-[#e8a598] transition-colors">Best Sellers</a></li>
                    <li><a href="<?php echo e(route('collections.show', 'new-arrivals')); ?>" class="text-sm text-gray-600 hover:text-[#e8a598] transition-colors">New Arrivals</a></li>
                    <li><a href="<?php echo e(route('bundle.index')); ?>" class="text-sm text-gray-600 hover:text-[#e8a598] transition-colors">Bundle</a></li>
                </ul>
            </div>

            <!-- Help -->
            <div>
                <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Help</h3>
                <ul class="space-y-3">
                    <li><a href="<?php echo e(route('about')); ?>" class="text-sm text-gray-600 hover:text-[#e8a598] transition-colors">About Us</a></li>
                    <li><a href="<?php echo e(route('contact')); ?>" class="text-sm text-gray-600 hover:text-[#e8a598] transition-colors">Contact Us</a></li>
                    <li><a href="<?php echo e(route('faq')); ?>" class="text-sm text-gray-600 hover:text-[#e8a598] transition-colors">FAQ</a></li>
                    <li><a href="<?php echo e(route('privacy-policy')); ?>" class="text-sm text-gray-600 hover:text-[#e8a598] transition-colors">Privacy Policy</a></li>
                    <li><a href="<?php echo e(route('return-refund')); ?>" class="text-sm text-gray-600 hover:text-[#e8a598] transition-colors">Return & Refund</a></li>
                    <li><a href="<?php echo e(route('shipping-policy')); ?>" class="text-sm text-gray-600 hover:text-[#e8a598] transition-colors">Shipping Policy</a></li>
                    <li><a href="<?php echo e(route('tracking.index')); ?>" class="text-sm text-gray-600 hover:text-[#e8a598] transition-colors">Track Order</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Contact</h3>
                <ul class="space-y-3">
                    <?php if(isset($settings['address']) && $settings['address']): ?>
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-[#e8a598] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm text-gray-600"><?php echo e($settings['address']); ?></span>
                    </li>
                    <?php endif; ?>
                    <?php if(isset($settings['phone']) && $settings['phone']): ?>
                    <li class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-[#e8a598] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <a href="tel:<?php echo e($settings['phone']); ?>" class="text-sm text-gray-600 hover:text-[#e8a598] transition-colors"><?php echo e($settings['phone']); ?></a>
                    </li>
                    <?php endif; ?>
                    <?php if(isset($settings['email']) && $settings['email']): ?>
                    <li class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-[#e8a598] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:<?php echo e($settings['email']); ?>" class="text-sm text-gray-600 hover:text-[#e8a598] transition-colors"><?php echo e($settings['email']); ?></a>
                    </li>
                    <?php endif; ?>
                </ul>

                <!-- Payment Methods -->
                <div class="mt-6">
                    <h4 class="text-xs font-bold text-gray-900 mb-3 uppercase tracking-wider">We Accept</h4>
                    <div class="flex flex-wrap gap-2">
                        <!-- Razorpay -->
                        <div class="h-7 px-2 bg-white border border-gray-200 rounded flex items-center justify-center" title="Razorpay">
                            <span class="text-[10px] font-bold text-[#072654]">Razorpay</span>
                        </div>
                        <!-- UPI -->
                        <div class="h-7 px-2 bg-white border border-gray-200 rounded flex items-center justify-center" title="UPI">
                            <span class="text-[10px] font-bold text-[#097939]">UPI</span>
                        </div>
                        <!-- Google Pay -->
                        <div class="h-7 px-2 bg-white border border-gray-200 rounded flex items-center justify-center" title="Google Pay">
                            <span class="text-[10px] font-bold">G</span><span class="text-[10px] font-bold text-blue-500">P</span><span class="text-[10px] font-bold text-yellow-500">a</span><span class="text-[10px] font-bold text-green-500">y</span>
                        </div>
                        <!-- PhonePe -->
                        <div class="h-7 px-2 bg-white border border-gray-200 rounded flex items-center justify-center" title="PhonePe">
                            <span class="text-[10px] font-bold text-[#5f259f]">PhonePe</span>
                        </div>
                        <!-- Paytm -->
                        <div class="h-7 px-2 bg-white border border-gray-200 rounded flex items-center justify-center" title="Paytm">
                            <span class="text-[10px] font-bold text-[#00BAF2]">Paytm</span>
                        </div>
                        <!-- Net Banking -->
                        <div class="h-7 px-2 bg-white border border-gray-200 rounded flex items-center justify-center" title="Net Banking">
                            <span class="text-[10px] font-bold text-gray-700">NetBanking</span>
                        </div>
                        <!-- Visa -->
                        <div class="h-7 px-2 bg-white border border-gray-200 rounded flex items-center justify-center" title="Visa">
                            <span class="text-[10px] font-bold text-[#1A1F71]">VISA</span>
                        </div>
                        <!-- Mastercard -->
                        <div class="h-7 px-2 bg-white border border-gray-200 rounded flex items-center justify-center" title="Mastercard">
                            <span class="text-[10px] font-bold text-[#EB001B]">Master</span>
                        </div>
                        <!-- RuPay -->
                        <div class="h-7 px-2 bg-white border border-gray-200 rounded flex items-center justify-center" title="RuPay">
                            <span class="text-[10px] font-bold text-[#097A44]">RuPay</span>
                        </div>
                        <!-- COD -->
                        <div class="h-7 px-2 bg-white border border-gray-200 rounded flex items-center justify-center" title="Cash on Delivery">
                            <span class="text-[10px] font-bold text-amber-600">COD</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="border-t border-gray-200 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <!-- Copyright -->
                <p class="text-sm text-gray-500 text-center md:text-left">
                    © <?php echo e(date('Y')); ?> <span class="font-semibold text-gray-700"><?php echo e($settings['business_name'] ?? 'Scents N Smile'); ?></span>. All Rights Reserved.
                </p>

                <!-- Links -->
                <div class="flex flex-wrap justify-center gap-4 text-sm">
                    <a href="<?php echo e(route('privacy-policy')); ?>" class="text-gray-500 hover:text-[#e8a598] transition-colors">Privacy Policy</a>
                    <span class="text-gray-300">|</span>
                    <a href="<?php echo e(route('return-refund')); ?>" class="text-gray-500 hover:text-[#e8a598] transition-colors">Return & Refund</a>
                    <span class="text-gray-300">|</span>
                    <a href="<?php echo e(route('terms-conditions')); ?>" class="text-gray-500 hover:text-[#e8a598] transition-colors">Terms & Conditions</a>
                    <span class="text-gray-300">|</span>
                    <a href="<?php echo e(route('faq')); ?>" class="text-gray-500 hover:text-[#e8a598] transition-colors">FAQ</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Newsletter AJAX Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('newsletterForm');
    const emailInput = document.getElementById('newsletterEmail');
    const btn = document.getElementById('newsletterBtn');
    const msg = document.getElementById('newsletterMessage');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = emailInput.value.trim();
            if (!email) return;

            btn.disabled = true;
            btn.textContent = '...';
            msg.classList.add('hidden');

            fetch('<?php echo e(route("newsletter.subscribe")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                msg.classList.remove('hidden');
                if (data.success) {
                    msg.className = 'text-xs mb-4 text-green-600';
                    msg.textContent = data.message;
                    emailInput.value = '';
                } else {
                    msg.className = 'text-xs mb-4 text-red-600';
                    msg.textContent = data.message;
                }
            })
            .catch(error => {
                msg.classList.remove('hidden');
                msg.className = 'text-xs mb-4 text-red-600';
                msg.textContent = 'Something went wrong. Please try again.';
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Join';
            });
        });
    }
});
</script><?php /**PATH /Applications/XAMPP/htdocs/scentnsmile/resources/views/partials/footer.blade.php ENDPATH**/ ?>