<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['items']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['items']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php if($items->isNotEmpty()): ?>
    <div class="py-16 sm:py-20 bg-[#f4f4f4] border-t border-gray-200">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-6">
                <div>
                    <h2 class="text-4xl sm:text-5xl md:text-6xl font-serif text-gray-900 leading-tight">
                        Words of affirmation<br>
                        from our favorite humans.
                    </h2>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs font-bold tracking-widest text-gray-400 uppercase hidden md:block">CHK...<br>SHORTS
                        OUT</span>
                    <a href="#"
                        class="inline-flex items-center px-6 py-2 rounded-full border border-gray-900 text-xs font-bold uppercase hover:bg-gray-900 hover:text-white transition-colors">
                        IN THE GOOD WAY, OMH ROOM
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Slider Container -->
            <div class="relative group">
                <div class="flex overflow-x-auto gap-4 pb-8 snap-x snap-mandatory scrollbar-hide scroll-smooth"
                    id="video-testimonials-slider">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!-- Card -->
                        <div class="flex-none snap-center w-[260px] sm:w-[280px] md:w-[300px] flex flex-col gap-4">
                            <!-- Video/Thumbnail Wrapper -->
                            <div class="relative aspect-[9/16] bg-black rounded-3xl overflow-hidden cursor-pointer group-card">
                                <?php if($item->thumbnail_url): ?>
                                    <img src="<?php echo e($item->thumbnail_url); ?>"
                                        class="w-full h-full object-cover opacity-90 transition-opacity duration-300 group-card-hover:opacity-100">
                                <?php else: ?>
                                    <video src="<?php echo e($item->video_url); ?>" class="w-full h-full object-cover opacity-90" muted
                                        playsinline loop></video>
                                <?php endif; ?>

                                <!-- Play Button Overlay -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div
                                        class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center pl-1 group-card-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Video Element for Modal/Lightbox (Hidden) -->
                                <a href="<?php echo e($item->video_url); ?>" class="absolute inset-0 z-10"
                                    data-fslightbox="gallery-videos"></a>
                            </div>

                            <!-- Content Below -->
                            <div class="px-1">
                                <p class="text-sm font-serif italic text-gray-900 mb-2 leading-snug">"<?php echo e($item->quote); ?>"</p>
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-[10px] font-bold uppercase text-gray-500"><?php echo e($item->author_name); ?></span>
                                    <?php if($item->product_text): ?>
                                        <span class="text-[10px] font-bold uppercase text-orange-500">USED
                                            <?php echo e($item->product_text); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Fslightbox for Video Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.0.9/index.min.js"></script>
    <style>
        .font-serif {
            font-family: 'Playfair Display', serif;
            /* Or system serif */
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
<?php endif; ?><?php /**PATH /Applications/XAMPP/htdocs/scentnsmile/resources/views/components/video-testimonials.blade.php ENDPATH**/ ?>