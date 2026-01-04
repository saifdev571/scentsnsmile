

<?php $__env->startSection('title', 'Order Confirmed - Scents N Smile'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 pt-20 lg:pt-24 pb-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Animation -->
        <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8 text-center mb-6">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-wider text-gray-900 mb-2">Order Confirmed!</h1>
            <p class="text-gray-600">Thank you for shopping with us</p>
            <div class="mt-4 inline-block bg-gray-100 px-4 py-2 rounded-lg">
                <p class="text-sm text-gray-500">Order Number</p>
                <p class="font-bold text-lg text-gray-900"><?php echo e($order->order_number); ?></p>
            </div>
            <p class="text-sm text-gray-500 mt-4">
                A confirmation email has been sent to <span class="font-medium"><?php echo e($order->email); ?></span>
            </p>
        </div>

        <!-- Order Timeline -->
        <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 mb-6">
            <h2 class="font-bold text-sm uppercase tracking-wider text-gray-500 mb-4">Order Status</h2>
            <div class="flex items-center justify-between">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="text-xs mt-2 text-center font-medium">Confirmed</p>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-2">
                    <div class="h-full bg-green-500 w-0"></div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <p class="text-xs mt-2 text-center text-gray-400">Shipped</p>
                </div>
                <div class="flex-1 h-1 bg-gray-200 mx-2"></div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <p class="text-xs mt-2 text-center text-gray-400">Delivered</p>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-[#e8a598] to-[#F27F6E] px-4 sm:px-6 py-4">
                <h2 class="font-bold text-white uppercase tracking-wider">Order Items</h2>
            </div>
            
            <div class="p-4 sm:p-6">
                <div class="space-y-4 mb-6">
                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex gap-4">
                        <div class="w-16 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                            <?php if($item->product && $item->product->image_url): ?>
                                <img src="<?php echo e($item->product->image_url); ?>" alt="<?php echo e($item->product_name); ?>" class="w-full h-full object-cover">
                            <?php elseif($item->product_image): ?>
                                <img src="<?php echo e($item->product_image); ?>" alt="<?php echo e($item->product_name); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-2xl">🌸</div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-sm text-gray-900 line-clamp-2"><?php echo e($item->product_name); ?></h4>
                            <p class="text-gray-500 text-xs mt-1">Qty: <?php echo e($item->quantity); ?></p>
                            <p class="font-bold text-sm mt-1">₹<?php echo e(number_format($item->total, 0)); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Price Summary -->
                <div class="border-t pt-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">₹<?php echo e(number_format($order->subtotal, 0)); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-semibold <?php echo e($order->shipping == 0 ? 'text-green-600' : ''); ?>">
                            <?php echo e($order->shipping == 0 ? 'FREE' : '₹' . number_format($order->shipping, 0)); ?>

                        </span>
                    </div>
                    <?php if($order->discount > 0): ?>
                    <div class="flex justify-between text-[#e8a598]">
                        <span class="font-medium">Discount</span>
                        <span class="font-semibold">-₹<?php echo e(number_format($order->discount, 0)); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="flex justify-between text-lg border-t pt-3 mt-3">
                        <span class="font-bold">Total Paid</span>
                        <span class="font-bold text-[#e8a598]">₹<?php echo e(number_format($order->total, 0)); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping & Payment Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <!-- Shipping Address -->
            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">
                <h3 class="font-bold text-sm uppercase tracking-wider text-gray-500 mb-3">Delivery Address</h3>
                <p class="font-semibold text-gray-900"><?php echo e($order->first_name); ?> <?php echo e($order->last_name); ?></p>
                <p class="text-sm text-gray-600 mt-1"><?php echo e($order->address); ?></p>
                <?php if($order->address_line_2): ?>
                <p class="text-sm text-gray-600"><?php echo e($order->address_line_2); ?></p>
                <?php endif; ?>
                <p class="text-sm text-gray-600"><?php echo e($order->city); ?>, <?php echo e($order->state); ?> - <?php echo e($order->zipcode); ?></p>
                <p class="text-sm text-gray-600 mt-2">📞 <?php echo e($order->phone); ?></p>
            </div>

            <!-- Payment Info -->
            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">
                <h3 class="font-bold text-sm uppercase tracking-wider text-gray-500 mb-3">Payment</h3>
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-2xl"><?php echo e($order->payment_method === 'cod' ? '💵' : '💳'); ?></span>
                    <div>
                        <p class="font-semibold text-gray-900">
                            <?php echo e($order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment'); ?>

                        </p>
                        <p class="text-xs text-gray-500">
                            <?php echo e($order->payment_method === 'cod' ? 'Pay when you receive' : 'Paid online'); ?>

                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full <?php echo e($order->payment_status === 'paid' ? 'bg-green-500' : 'bg-yellow-500'); ?>"></span>
                    <span class="text-sm capitalize <?php echo e($order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600'); ?>">
                        <?php echo e($order->payment_status === 'paid' ? 'Payment Received' : 'Payment Pending'); ?>

                    </span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="<?php echo e(route('home')); ?>" 
                class="px-6 py-3 bg-gradient-to-r from-[#e8a598] to-[#F27F6E] hover:opacity-90 text-white font-bold rounded-full text-center transition-all">
                CONTINUE SHOPPING
            </a>
            <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('user.orders')); ?>" 
                class="px-6 py-3 border-2 border-gray-900 hover:bg-gray-900 hover:text-white text-gray-900 font-bold rounded-full text-center transition-colors">
                VIEW MY ORDERS
            </a>
            <?php endif; ?>
        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500">
                Need help? <a href="#" class="text-[#e8a598] hover:underline">Contact Support</a>
            </p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/checkout-success.blade.php ENDPATH**/ ?>