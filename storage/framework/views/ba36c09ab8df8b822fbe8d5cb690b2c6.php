

<?php $__env->startSection('title', 'Login - Scents N Smile'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .gradient-bg {
        background: linear-gradient(135deg, #e8a598 0%, #F27F6E 100%);
    }
    .input-focus:focus {
        border-color: #F27F6E;
        box-shadow: 0 0 0 2px rgba(242, 127, 110, 0.2);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Main Content -->
    <main class="py-8 px-4 mt-16 min-h-[70vh]">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row min-h-[500px]">
                
                <!-- Left Side - Branding (Flipkart Style) -->
                <div class="gradient-bg p-8 md:p-10 md:w-[40%] flex flex-col justify-between text-white">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold mb-4">Login</h2>
                        <p class="text-white/90 text-sm md:text-base leading-relaxed">
                            Get access to your Orders, Wishlist and Recommendations
                        </p>
                    </div>
                    <div class="hidden md:block mt-auto">
                        <!-- Removed static image -->
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="p-6 md:p-10 md:w-[60%] flex flex-col">
                    <!-- Error Messages -->
                    <?php if(session('success')): ?>
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(session('info')): ?>
                        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg mb-4 text-sm flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <?php echo e(session('info')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-4 text-sm">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p><?php echo e($error); ?></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('user.login.post')); ?>" method="POST" class="flex-1 flex flex-col">
                        <?php echo csrf_field(); ?>
                        
                        <!-- Email Input -->
                        <div class="mb-6">
                            <label for="email" class="block text-gray-500 text-sm mb-2">Enter Email</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="<?php echo e(old('email')); ?>"
                                   required
                                   class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-gray-800 text-base outline-none transition-all"
                                   placeholder="Enter your email">
                        </div>

                        <!-- Password Input -->
                        <div class="mb-6">
                            <label for="password" class="block text-gray-500 text-sm mb-2">Enter Password</label>
                            <div class="relative">
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       required
                                       class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-gray-800 text-base outline-none transition-all pr-12"
                                       placeholder="Enter your password">
                                <button type="button" 
                                        onclick="togglePassword()"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Terms Text -->
                        <p class="text-xs text-gray-500 mb-6">
                            By continuing, you agree to Scents N Smile's 
                            <a href="#" class="text-[#F27F6E] hover:underline">Terms of Use</a> and 
                            <a href="#" class="text-[#F27F6E] hover:underline">Privacy Policy</a>.
                        </p>

                        <!-- Login Button -->
                        <button type="submit" 
                                class="w-full gradient-bg text-white font-semibold py-3 px-4 rounded-lg hover:opacity-90 transition-opacity shadow-md">
                            Login
                        </button>

                        <!-- Register Link -->
                        <div class="mt-auto pt-6 text-center">
                            <p class="text-gray-600 text-sm">
                                New to Scents N Smile? 
                                <a href="<?php echo e(route('user.register')); ?>" class="text-[#F27F6E] font-semibold hover:underline">
                                    Create an account
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/website/auth/login.blade.php ENDPATH**/ ?>