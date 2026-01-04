

<?php $__env->startSection('title', 'My Orders - Scents N Smile'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 pt-20 lg:pt-24 pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-wider">My Orders</h1>
                <p class="text-gray-600 mt-1">Track and manage your orders</p>
            </div>
            <a href="<?php echo e(route('user.account')); ?>" 
               class="flex items-center gap-2 text-sm text-gray-600 hover:text-[#e8a598] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Account
            </a>
        </div>

        <?php if($orders->count() > 0): ?>
        <div class="space-y-4">
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <!-- Order Header -->
                <div class="bg-gray-50 px-4 sm:px-6 py-3 border-b flex flex-wrap items-center justify-between gap-2">
                    <div class="flex items-center gap-4 flex-wrap">
                        <span class="text-sm text-gray-500">Order</span>
                        <span class="font-bold text-gray-900"><?php echo e($order->order_number); ?></span>
                    </div>
                    <div class="flex items-center gap-4 flex-wrap">
                        <span class="text-sm text-gray-500"><?php echo e($order->created_at->format('d M Y')); ?></span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            <?php if($order->status === 'delivered'): ?> bg-green-100 text-green-700
                            <?php elseif($order->status === 'shipped'): ?> bg-blue-100 text-blue-700
                            <?php elseif($order->status === 'processing'): ?> bg-yellow-100 text-yellow-700
                            <?php elseif($order->status === 'cancelled'): ?> bg-red-100 text-red-700
                            <?php else: ?> bg-gray-100 text-gray-700
                            <?php endif; ?>">
                            <?php echo e(ucfirst($order->status)); ?>

                        </span>
                    </div>
                </div>

                <!-- Order Items Preview -->
                <div class="p-4 sm:p-6">
                    <div class="flex flex-wrap gap-4 mb-4">
                        <?php $__currentLoopData = $order->items->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-3">
                            <div class="w-14 h-14 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                <?php if($item->product && $item->product->image_url): ?>
                                    <img src="<?php echo e($item->product->image_url); ?>" alt="<?php echo e($item->product_name); ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-xl">🌸</div>
                                <?php endif; ?>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate max-w-[120px]"><?php echo e($item->product_name); ?></p>
                                <p class="text-xs text-gray-500">Qty: <?php echo e($item->quantity); ?></p>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($order->items->count() > 3): ?>
                        <div class="flex items-center">
                            <span class="text-sm text-gray-500">+<?php echo e($order->items->count() - 3); ?> more</span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Order Footer -->
                    <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t">
                        <div>
                            <span class="text-sm text-gray-500">Total:</span>
                            <span class="text-lg font-bold text-[#e8a598] ml-2">₹<?php echo e(number_format($order->total, 0)); ?></span>
                        </div>
                        <a href="<?php echo e(route('user.order.detail', $order->order_number)); ?>" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white text-sm font-semibold rounded-full transition-colors">
                            View Details
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <?php if($orders->hasPages()): ?>
        <div class="mt-8">
            <?php echo e($orders->links()); ?>

        </div>
        <?php endif; ?>

        <?php else: ?>
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-sm p-8 sm:p-12 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No Orders Yet</h3>
            <p class="text-gray-500 mb-6">Looks like you haven't placed any orders yet.</p>
            <a href="<?php echo e(route('home')); ?>" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#e8a598] to-[#F27F6E] hover:opacity-90 text-white font-bold rounded-full transition-all">
                Start Shopping
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/website/auth/orders.blade.php ENDPATH**/ ?>