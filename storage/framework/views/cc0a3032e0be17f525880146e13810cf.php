

<?php $__env->startSection('title', 'Order #' . $order->order_number . ' - Scents N Smile'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 pt-20 lg:pt-24 pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <a href="<?php echo e(route('user.orders')); ?>" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-[#e8a598] transition-colors mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Orders
                </a>
                <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-wider">Order Details</h1>
            </div>
        </div>

        <!-- Order Status Card -->
        <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 mb-6">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div>
                    <p class="text-sm text-gray-500">Order Number</p>
                    <p class="text-lg font-bold text-gray-900"><?php echo e($order->order_number); ?></p>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-semibold
                    <?php if($order->status === 'delivered'): ?> bg-green-100 text-green-700
                    <?php elseif($order->status === 'shipped'): ?> bg-blue-100 text-blue-700
                    <?php elseif($order->status === 'processing'): ?> bg-yellow-100 text-yellow-700
                    <?php elseif($order->status === 'cancelled'): ?> bg-red-100 text-red-700
                    <?php else: ?> bg-gray-100 text-gray-700
                    <?php endif; ?>">
                    <?php echo e(ucfirst($order->status)); ?>

                </span>
            </div>

            <!-- Order Timeline -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white
                        <?php echo e(in_array($order->status, ['pending', 'processing', 'shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-200'); ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="text-xs mt-2 text-center font-medium">Confirmed</p>
                </div>
                <div class="flex-1 h-1 mx-2 <?php echo e(in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-200'); ?>"></div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center
                        <?php echo e(in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <p class="text-xs mt-2 text-center <?php echo e(in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'font-medium' : 'text-gray-400'); ?>">Processing</p>
                </div>
                <div class="flex-1 h-1 mx-2 <?php echo e(in_array($order->status, ['shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-200'); ?>"></div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center
                        <?php echo e(in_array($order->status, ['shipped', 'delivered']) ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                        </svg>
                    </div>
                    <p class="text-xs mt-2 text-center <?php echo e(in_array($order->status, ['shipped', 'delivered']) ? 'font-medium' : 'text-gray-400'); ?>">Shipped</p>
                </div>
                <div class="flex-1 h-1 mx-2 <?php echo e($order->status === 'delivered' ? 'bg-green-500' : 'bg-gray-200'); ?>"></div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center
                        <?php echo e($order->status === 'delivered' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400'); ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <p class="text-xs mt-2 text-center <?php echo e($order->status === 'delivered' ? 'font-medium' : 'text-gray-400'); ?>">Delivered</p>
                </div>
            </div>

            <!-- Order Info Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 border-t">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Order Date</p>
                    <p class="font-semibold text-gray-900 mt-1"><?php echo e($order->created_at->format('d M Y')); ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Payment</p>
                    <p class="font-semibold text-gray-900 mt-1"><?php echo e($order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online'); ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Payment Status</p>
                    <p class="font-semibold mt-1 <?php echo e($order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600'); ?>">
                        <?php echo e(ucfirst($order->payment_status)); ?>

                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Total</p>
                    <p class="font-bold text-[#e8a598] text-lg mt-1">₹<?php echo e(number_format($order->total, 0)); ?></p>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-[#e8a598] to-[#F27F6E] px-4 sm:px-6 py-4">
                <h2 class="font-bold text-white uppercase tracking-wider">Order Items (<?php echo e($order->items->count()); ?>)</h2>
            </div>
            
            <div class="p-4 sm:p-6">
                <div class="space-y-4">
                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex gap-4 pb-4 <?php echo e(!$loop->last ? 'border-b' : ''); ?>">
                        <div class="w-20 h-24 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                            <?php if($item->product && $item->product->image_url): ?>
                                <img src="<?php echo e($item->product->image_url); ?>" alt="<?php echo e($item->product_name); ?>" class="w-full h-full object-cover">
                            <?php elseif($item->product_image): ?>
                                <img src="<?php echo e($item->product_image); ?>" alt="<?php echo e($item->product_name); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-2xl">🌸</div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-gray-900"><?php echo e($item->product_name); ?></h4>
                            <?php if($item->variant_name): ?>
                            <p class="text-sm text-gray-500"><?php echo e($item->variant_name); ?></p>
                            <?php endif; ?>
                            <p class="text-sm text-gray-500 mt-1">Qty: <?php echo e($item->quantity); ?> × ₹<?php echo e(number_format($item->price, 0)); ?></p>
                            <p class="font-bold text-gray-900 mt-2">₹<?php echo e(number_format($item->total, 0)); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Price Summary -->
                <div class="border-t pt-4 mt-4 space-y-2 text-sm">
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
                        <span class="font-bold">Total</span>
                        <span class="font-bold text-[#e8a598]">₹<?php echo e(number_format($order->total, 0)); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping & Payment Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                <p class="text-sm text-gray-600">✉️ <?php echo e($order->email); ?></p>
            </div>

            <!-- Order Notes -->
            <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">
                <h3 class="font-bold text-sm uppercase tracking-wider text-gray-500 mb-3">Order Notes</h3>
                <?php if($order->order_notes): ?>
                <p class="text-sm text-gray-600"><?php echo e($order->order_notes); ?></p>
                <?php else: ?>
                <p class="text-sm text-gray-400 italic">No special instructions</p>
                <?php endif; ?>

                <?php if($order->status === 'delivered' && $order->delivered_at): ?>
                <div class="mt-4 pt-4 border-t">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Delivered On</p>
                    <p class="font-semibold text-green-600 mt-1"><?php echo e($order->delivered_at->format('d M Y, h:i A')); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if($order->shiprocket_awb_code): ?>
        <!-- Tracking Info Card -->
        <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6 mt-4">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-sm uppercase tracking-wider text-gray-500">Shipment Tracking</h3>
                <a href="<?php echo e(route('tracking.index', ['order' => $order->order_number])); ?>" 
                   class="text-sm font-semibold text-[#e8a598] hover:text-[#F27F6E] transition-colors">
                    View Full Tracking →
                </a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">AWB Code</p>
                    <p class="font-mono font-bold text-gray-900 mt-1"><?php echo e($order->shiprocket_awb_code); ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Courier</p>
                    <p class="font-semibold text-gray-900 mt-1"><?php echo e($order->shiprocket_courier_name ?? 'N/A'); ?></p>
                </div>
                <?php if($order->shiprocket_status): ?>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Status</p>
                    <p class="font-semibold mt-1 
                        <?php if(in_array($order->shiprocket_status, ['DELIVERED'])): ?> text-green-600
                        <?php elseif(in_array($order->shiprocket_status, ['PICKED_UP', 'IN_TRANSIT', 'OUT_FOR_DELIVERY'])): ?> text-blue-600
                        <?php else: ?> text-yellow-600
                        <?php endif; ?>">
                        <?php echo e(str_replace('_', ' ', $order->shiprocket_status)); ?>

                    </p>
                </div>
                <?php endif; ?>
                <?php if($order->shiprocket_expected_delivery_date): ?>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Expected Delivery</p>
                    <p class="font-semibold text-green-600 mt-1"><?php echo e($order->shiprocket_expected_delivery_date->format('d M Y')); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center mt-8">
            <a href="<?php echo e(route('home')); ?>" 
                class="px-6 py-3 bg-gradient-to-r from-[#e8a598] to-[#F27F6E] hover:opacity-90 text-white font-bold rounded-full text-center transition-all">
                CONTINUE SHOPPING
            </a>
            <a href="<?php echo e(route('user.orders')); ?>" 
                class="px-6 py-3 border-2 border-gray-900 hover:bg-gray-900 hover:text-white text-gray-900 font-bold rounded-full text-center transition-colors">
                VIEW ALL ORDERS
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/website/auth/order-detail.blade.php ENDPATH**/ ?>