<?php $__env->startSection('title', $item->name . ' - Scents N Smile'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen bg-[#FAF8F5]">

        <!-- FILTER SIDEBAR OVERLAY -->
        <div id="filterOverlay" class="fixed inset-0 bg-black/50 z-[60] hidden"></div>

        <!-- FILTER SIDEBAR -->
        <aside id="filterSidebar"
            class="fixed top-0 left-0 h-full w-[300px] bg-white z-[70] transform -translate-x-full transition-transform duration-300 ease-out overflow-y-auto">
            <div class="p-5">
                <!-- Close Button -->
                <div class="flex items-center justify-between mb-6">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-900">Filters</span>
                    <button id="closeFilterBtn" class="p-1 hover:bg-gray-100 rounded-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- SORT BY -->
                <div class="mb-6">
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-gray-500 mb-2">Sort by:</label>
                    <div class="relative">
                        <select id="sortSelect"
                            class="w-full appearance-none bg-[#F4ECDD] rounded-full px-4 py-3 text-sm font-medium text-gray-900 cursor-pointer focus:outline-none">
                            <option value="relevance">Relevance</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="newest">Newest</option>
                            <option value="name_asc">Name: A to Z</option>
                        </select>
                        <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-600"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- FILTERS LABEL -->
                <div class="mb-4">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-500">Filters:</span>
                </div>

                <!-- GENDER FILTER -->
                <div class="border-b border-gray-100">
                    <button data-accordion-toggle="genderFilter" class="w-full flex items-center justify-between py-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-900">Gender</span>
                        <svg class="w-4 h-4 text-gray-600 transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="genderFilter" class="pb-4 space-y-3">
                        <?php $__empty_1 = true; $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="gender[]" value="<?php echo e($gender->id); ?>"
                                    class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]" <?php echo e($type === 'gender' && $item->id === $gender->id ? 'checked' : ''); ?>>
                                <span class="text-sm text-gray-700 group-hover:text-gray-900"><?php echo e($gender->name); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <!-- Static fallback if no genders in database -->
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox"
                                    class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]">
                                <span class="text-sm text-gray-700 group-hover:text-gray-900">Women</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox"
                                    class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]">
                                <span class="text-sm text-gray-700 group-hover:text-gray-900">Men</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox"
                                    class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]">
                                <span class="text-sm text-gray-700 group-hover:text-gray-900">Unisex</span>
                            </label>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- TAGS / SCENT FAMILY FILTER -->
                <div class="border-b border-gray-100">
                    <button data-accordion-toggle="scentFilter" class="w-full flex items-center justify-between py-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-900">Tags</span>
                        <svg class="w-4 h-4 text-gray-600 transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="scentFilter" class="pb-4 space-y-3">
                        <?php $__empty_1 = true; $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <?php if($tag->icon): ?>
                                    <span class="text-base"><?php echo e($tag->icon); ?></span>
                                <?php else: ?>
                                    <span class="w-4 h-4 rounded-full"
                                        style="background-color: <?php echo e($tag->color ?? '#F27F6E'); ?>"></span>
                                <?php endif; ?>
                                <input type="checkbox" name="tag[]" value="<?php echo e($tag->id); ?>"
                                    class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]" <?php echo e($type === 'tag' && $item->id === $tag->id ? 'checked' : ''); ?>>
                                <span class="text-sm text-gray-700 group-hover:text-gray-900"><?php echo e($tag->name); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-gray-500">No tags available</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- SCENT FAMILIES FILTER -->
                <div class="border-b border-gray-100">
                    <button data-accordion-toggle="scentFamiliesFilter"
                        class="w-full flex items-center justify-between py-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-900">Scent Families</span>
                        <svg class="w-4 h-4 text-gray-600 transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="scentFamiliesFilter" class="pb-4 space-y-3">
                        <?php $__empty_1 = true; $__currentLoopData = $scentFamilies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scentFamily): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <?php if($scentFamily->icon): ?>
                                    <span class="text-base"><?php echo e($scentFamily->icon); ?></span>
                                <?php endif; ?>
                                <input type="checkbox" name="scent_family[]" value="<?php echo e($scentFamily->id); ?>"
                                    class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]">
                                <span class="text-sm text-gray-700 group-hover:text-gray-900"><?php echo e($scentFamily->name); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-sm text-gray-500">No scent families available</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- COLLECTIONS FILTER -->
                <div class="border-b border-gray-100">
                    <button data-accordion-toggle="collectionsFilter" class="w-full flex items-center justify-between py-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-900">Collections</span>
                        <svg class="w-4 h-4 text-gray-600 transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="collectionsFilter" class="pb-4 space-y-3">
                        <?php $__empty_1 = true; $__currentLoopData = $collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="collection[]" value="<?php echo e($collection->id); ?>"
                                    class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]" <?php echo e($type === 'collection' && $item->id === $collection->id ? 'checked' : ''); ?>>
                                <span class="text-sm text-gray-700 group-hover:text-gray-900"><?php echo e($collection->name); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <!-- Static fallback if no collections in database -->
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox"
                                    class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]">
                                <span class="text-sm text-gray-700 group-hover:text-gray-900">Summer Collection</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox"
                                    class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]">
                                <span class="text-sm text-gray-700 group-hover:text-gray-900">Winter Warmers</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox"
                                    class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]">
                                <span class="text-sm text-gray-700 group-hover:text-gray-900">Date Night</span>
                            </label>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- HIGHLIGHT NOTES FILTER -->
                <div class="border-b border-gray-100">
                    <button data-accordion-toggle="highlightNotesFilter"
                        class="w-full flex items-center justify-between py-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-900">Highlight Notes</span>
                        <svg class="w-4 h-4 text-gray-600 transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="highlightNotesFilter" class="pb-4 space-y-3">
                        <?php $__empty_1 = true; $__currentLoopData = $highlightNotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <?php if($note->imagekit_thumbnail_url || $note->imagekit_url): ?>
                                    <img src="<?php echo e($note->imagekit_thumbnail_url ?? $note->imagekit_url); ?>" alt="<?php echo e($note->name); ?>"
                                        class="w-6 h-6 rounded object-cover">
                                <?php else: ?>
                                    <div
                                        class="w-6 h-6 rounded bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center">
                                        <svg class="w-3 h-3 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    </div>
                                <?php endif; ?>
                                <input type="checkbox" name="highlight_note[]" value="<?php echo e($note->id); ?>"
                                    class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]">
                                <span class="text-sm text-gray-700 group-hover:text-gray-900"><?php echo e($note->name); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <!-- Static fallback if no highlight notes in database -->
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <span class="text-base">⭐</span>
                                <input type="checkbox"
                                    class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]">
                                <span class="text-sm text-gray-700 group-hover:text-gray-900">Long Lasting</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <span class="text-base">🌿</span>
                                <input type="checkbox"
                                    class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]">
                                <span class="text-sm text-gray-700 group-hover:text-gray-900">Vegan</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <span class="text-base">🐰</span>
                                <input type="checkbox"
                                    class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]">
                                <span class="text-sm text-gray-700 group-hover:text-gray-900">Cruelty Free</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <span class="text-base">💧</span>
                                <input type="checkbox"
                                    class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]">
                                <span class="text-sm text-gray-700 group-hover:text-gray-900">Alcohol Free</span>
                            </label>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- PRICE FILTER -->
                <div class="border-b border-gray-100">
                    <button data-accordion-toggle="priceFilter" class="w-full flex items-center justify-between py-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-900">Price</span>
                        <svg class="w-4 h-4 text-gray-600 transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="priceFilter" class="pb-4">
                        <!-- Price Range Inputs -->
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex-1">
                                <label class="text-xs text-gray-500 mb-1 block">Min</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">₹</span>
                                    <input type="number" id="priceMin" min="0" max="10000" value="0"
                                        class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-[#F27F6E] focus:border-[#F27F6E]">
                                </div>
                            </div>
                            <span class="text-gray-400 mt-5">-</span>
                            <div class="flex-1">
                                <label class="text-xs text-gray-500 mb-1 block">Max</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">₹</span>
                                    <input type="number" id="priceMax" min="0" max="10000" value="10000"
                                        class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-[#F27F6E] focus:border-[#F27F6E]">
                                </div>
                            </div>
                        </div>

                        <!-- Range Slider - Simplified Single Slider Approach -->
                        <div class="price-slider-container mt-6 mb-2">
                            <div class="price-slider-track"></div>
                            <div id="priceRangeTrack" class="price-slider-range"></div>
                            <input type="range" id="priceRangeMin" min="0" max="10000" value="0" step="100"
                                class="price-slider-thumb price-slider-thumb-left">
                            <input type="range" id="priceRangeMax" min="0" max="10000" value="10000" step="100"
                                class="price-slider-thumb price-slider-thumb-right">
                        </div>

                        <!-- Price Labels -->
                        <div class="flex justify-between text-xs text-gray-500 mt-3">
                            <span>₹0</span>
                            <span>₹10,000</span>
                        </div>
                    </div>
                </div>

                <!-- APPLY FILTERS BUTTON -->
                <div class="mt-6">
                    <button id="applyFilterBtn"
                        class="w-full py-3 bg-[#F27F6E] text-white rounded-full font-medium hover:bg-[#e06b5a] transition-colors">
                        Apply Filters
                    </button>
                </div>
            </div>
        </aside>

        <!-- TOP CATEGORY STRIP -->
        <section class="pt-24 sm:pt-28 lg:pt-32 pb-4">
            <div>
                <div class="flex gap-4 overflow-x-auto pb-2 hide-scrollbar pl-4">

                    <!-- Card 1: ALL PERFUMES -->
                    <a href="<?php echo e(route('collections.show', 'all')); ?>"
                        class="flex-shrink-0 w-[320px] h-24 rounded-[28px] flex items-center justify-between px-8 relative overflow-hidden transition-transform hover:scale-[1.02] <?php echo e($slug === 'all' ? 'bg-[#F27F6E]' : 'bg-[#F4ECDD]'); ?>">
                        <div class="flex flex-col justify-center z-10">
                            <span
                                class="<?php echo e($slug === 'all' ? 'text-white' : 'text-gray-900'); ?> text-lg font-bold uppercase tracking-wide">All
                                Perfumes</span>
                            <span
                                class="<?php echo e($slug === 'all' ? 'text-white/90' : 'text-gray-600'); ?> text-sm font-medium uppercase tracking-wider">Farewell
                                Sale</span>
                        </div>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2">
                            <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?w=100&h=120&fit=crop"
                                alt="Perfume" class="h-20 w-auto object-contain drop-shadow-lg">
                        </div>
                    </a>

                    <!-- Card 2: BESTSELLERS -->
                    <a href="<?php echo e(route('collections.show', 'bestsellers')); ?>"
                        class="flex-shrink-0 w-[280px] h-24 rounded-[28px] flex items-center justify-between px-8 relative overflow-hidden transition-transform hover:scale-[1.02] <?php echo e($slug === 'bestsellers' ? 'bg-[#F27F6E]' : 'bg-[#F4ECDD]'); ?>">
                        <div class="flex flex-col justify-center z-10">
                            <span
                                class="<?php echo e($slug === 'bestsellers' ? 'text-white' : 'text-gray-900'); ?> text-lg font-bold uppercase tracking-wide">Bestsellers</span>
                        </div>
                        <div class="absolute right-2 top-1/2 -translate-y-1/2">
                            <img src="https://images.unsplash.com/photo-1594035910387-fea47794261f?w=100&h=120&fit=crop"
                                alt="Bestsellers" class="h-20 w-auto object-contain drop-shadow-lg">
                        </div>
                    </a>

                    <!-- Card 3: NEW ARRIVALS -->
                    <a href="<?php echo e(route('collections.show', 'new-arrivals')); ?>"
                        class="flex-shrink-0 w-[280px] h-24 rounded-[28px] flex items-center justify-between px-8 relative overflow-hidden transition-transform hover:scale-[1.02] <?php echo e($slug === 'new-arrivals' ? 'bg-[#F27F6E]' : 'bg-[#F4ECDD]'); ?>">
                        <div class="flex flex-col justify-center z-10">
                            <span
                                class="<?php echo e($slug === 'new-arrivals' ? 'text-white' : 'text-gray-900'); ?> text-lg font-bold uppercase tracking-wide">New
                                Arrivals</span>
                        </div>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2">
                            <img src="https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=80&h=120&fit=crop"
                                alt="New Arrivals" class="h-20 w-auto object-contain drop-shadow-lg">
                        </div>
                    </a>

                    <!-- Dynamic Gender Cards -->
                    <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('collections.show', $gender->slug)); ?>"
                            class="flex-shrink-0 w-[240px] h-24 rounded-[28px] flex items-center justify-between px-8 relative overflow-hidden transition-transform hover:scale-[1.02] <?php echo e($type === 'gender' && $item->id === $gender->id ? 'bg-[#F27F6E]' : 'bg-[#F4ECDD]'); ?>">
                            <div class="flex flex-col justify-center z-10">
                                <span
                                    class="<?php echo e($type === 'gender' && $item->id === $gender->id ? 'text-white' : 'text-gray-900'); ?> text-lg font-bold uppercase tracking-wide"><?php echo e($gender->name); ?></span>
                            </div>
                            <?php if($gender->imagekit_thumbnail_url || $gender->imagekit_url): ?>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2">
                                    <img src="<?php echo e($gender->imagekit_thumbnail_url ?? $gender->imagekit_url); ?>"
                                        alt="<?php echo e($gender->name); ?>" class="h-16 w-auto object-contain drop-shadow-lg">
                                </div>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>

        <!-- FILTER & SEARCH BAR -->
        <section class="pb-6">
            <div class="px-4">
                <div class="flex flex-wrap items-center gap-3 lg:gap-4">

                    <!-- Sort & Filter Button -->
                    <button id="sortFilterBtn"
                        class="flex items-center gap-2 px-6 py-3 border border-gray-900 rounded-full text-sm font-medium text-gray-900 hover:bg-gray-900 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        Sort & Filter
                    </button>

                    <!-- Search Input -->
                    <div class="flex-1 min-w-[280px] relative">
                        <input type="text" id="collectionSearchInput" placeholder="Search scents, ingredients"
                            class="w-full pl-5 pr-14 py-3 border border-gray-900 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-[#F27F6E] focus:border-transparent bg-white">
                        <button id="collectionSearchBtn"
                            class="absolute right-1.5 top-1/2 -translate-y-1/2 w-10 h-10 bg-[#F27F6E] rounded-full flex items-center justify-center hover:bg-[#e06b5a] transition-colors">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Gender Filter Pill -->
                    <div class="relative">
                        <button id="genderPillBtn"
                            class="flex items-center gap-2 px-5 py-3 bg-[#F4ECDD] rounded-full text-sm font-medium text-gray-900 hover:bg-[#ebe3d4] transition-colors">
                            <svg class="w-4 h-4 text-[#F27F6E]" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                            Gender
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="genderPillDropdown"
                            class="hidden absolute top-full mt-2 left-0 bg-white rounded-2xl shadow-xl border border-gray-200 p-4 min-w-[200px] z-50">
                            <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label
                                    class="flex items-center gap-3 cursor-pointer group py-2 hover:bg-gray-50 rounded-lg px-2">
                                    <input type="checkbox" name="gender_pill[]" value="<?php echo e($gender->id); ?>"
                                        class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]" <?php echo e($type === 'gender' && $item->id === $gender->id ? 'checked' : ''); ?>>
                                    <span class="text-sm text-gray-700 group-hover:text-gray-900"><?php echo e($gender->name); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Scent Family Filter Pill -->
                    <div class="relative">
                        <button id="scentFamilyPillBtn"
                            class="flex items-center gap-2 px-5 py-3 bg-[#F4ECDD] rounded-full text-sm font-medium text-gray-900 hover:bg-[#ebe3d4] transition-colors">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Scent Family
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="scentFamilyPillDropdown"
                            class="hidden absolute top-full mt-2 left-0 bg-white rounded-2xl shadow-xl border border-gray-200 p-4 min-w-[200px] z-50">
                            <?php $__empty_1 = true; $__currentLoopData = $scentFamilies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scentFamily): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <label
                                    class="flex items-center gap-3 cursor-pointer group py-2 hover:bg-gray-50 rounded-lg px-2">
                                    <?php if($scentFamily->icon): ?>
                                        <span class="text-base"><?php echo e($scentFamily->icon); ?></span>
                                    <?php endif; ?>
                                    <input type="checkbox" name="scent_family_pill[]" value="<?php echo e($scentFamily->id); ?>"
                                        class="w-4 h-4 rounded border-gray-300 text-[#F27F6E] focus:ring-[#F27F6E]">
                                    <span
                                        class="text-sm text-gray-700 group-hover:text-gray-900"><?php echo e($scentFamily->name); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="text-sm text-gray-500 py-2">No scent families available</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- PRODUCTS SECTION -->
        <section class="pb-12">
            <div class="px-4">

                <!-- Results Header -->
                <div class="flex items-center justify-between mb-6">
                    <p class="text-gray-600 text-sm">
                        Explore designer-inspired perfumes, developed in France.
                        <span id="productCount" class="font-semibold text-gray-900 ml-2"><?php echo e($products->total()); ?>

                            Products</span>
                    </p>
                </div>

                <!-- Products Grid -->
                <!-- Products Grid -->
                <div id="productsGrid">
                    <div id="productsContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
                        <?php echo $__env->make('partials.products-grid', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>

                <!-- Load More Button (Outside productsGrid so it doesn't get replaced) -->
                <!-- Debug: Total=<?php echo e($products->total()); ?>, Count=<?php echo e($products->count()); ?>, HasMore=<?php echo e($products->hasMorePages() ? 'Yes' : 'No'); ?>, CurrentPage=<?php echo e($products->currentPage()); ?>, LastPage=<?php echo e($products->lastPage()); ?> -->
                <?php if($products->hasMorePages()): ?>
                    <div id="loadMoreContainer" class="mt-12 flex justify-center">
                        <button id="loadMoreBtn" data-next-page="<?php echo e($products->currentPage() + 1); ?>"
                            data-last-page="<?php echo e($products->lastPage()); ?>"
                            class="px-8 py-4 bg-gradient-to-r from-gray-900 to-gray-700 text-white rounded-full font-semibold hover:from-black hover:to-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
                            <span>Load More Products</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </section>

    </div>

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Ensure products grid doesn't break */
        #productsGrid {
            position: relative;
            z-index: 1;
        }

        #productsContainer.contents>* {
            display: block;
        }

        /* Price Slider Styles */
        .price-slider-container {
            position: relative;
            height: 20px;
        }

        .price-slider-track {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            height: 6px;
            background: #e5e7eb;
            border-radius: 9999px;
        }

        .price-slider-range {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            height: 6px;
            background: #F27F6E;
            border-radius: 9999px;
        }

        .price-slider-thumb {
            position: absolute;
            top: 0;
            width: 100%;
            height: 20px;
            -webkit-appearance: none;
            appearance: none;
            background: transparent;
            pointer-events: none;
        }

        .price-slider-thumb::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: white;
            border: 2px solid #F27F6E;
            border-radius: 50%;
            cursor: pointer;
            pointer-events: auto;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            transition: transform 0.15s ease;
        }

        .price-slider-thumb::-webkit-slider-thumb:hover {
            transform: scale(1.1);
        }

        .price-slider-thumb::-moz-range-thumb {
            width: 20px;
            height: 20px;
            background: white;
            border: 2px solid #F27F6E;
            border-radius: 50%;
            cursor: pointer;
            pointer-events: auto;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .price-slider-thumb-left {
            z-index: 3;
        }

        .price-slider-thumb-right {
            z-index: 4;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOM Content Loaded - Collection Page');

            const filterSidebar = document.getElementById('filterSidebar');
            const filterOverlay = document.getElementById('filterOverlay');
            const sortFilterBtn = document.getElementById('sortFilterBtn');
            const closeFilterBtn = document.getElementById('closeFilterBtn');
            const applyFilterBtn = document.getElementById('applyFilterBtn');
            const productsGrid = document.getElementById('productsGrid');
            const productCount = document.getElementById('productCount');
            const sortSelect = document.getElementById('sortSelect');
            const searchInput = document.getElementById('collectionSearchInput');
            const searchBtn = document.getElementById('collectionSearchBtn');

            console.log('Search elements found:', {
                searchInput: !!searchInput,
                searchBtn: !!searchBtn,
                productsGrid: !!productsGrid
            });

            // Price slider elements
            const priceMin = document.getElementById('priceMin');
            const priceMax = document.getElementById('priceMax');
            const priceRangeMin = document.getElementById('priceRangeMin');
            const priceRangeMax = document.getElementById('priceRangeMax');
            const priceRangeTrack = document.getElementById('priceRangeTrack');

            // Open filter sidebar
            if (sortFilterBtn) {
                sortFilterBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    filterSidebar.classList.remove('-translate-x-full');
                    filterOverlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            }

            // Close filter sidebar
            function closeFilter() {
                filterSidebar.classList.add('-translate-x-full');
                filterOverlay.classList.add('hidden');
                document.body.style.overflow = '';
            }

            if (filterOverlay) filterOverlay.addEventListener('click', closeFilter);
            if (closeFilterBtn) closeFilterBtn.addEventListener('click', closeFilter);

            // Apply filters button
            if (applyFilterBtn) {
                applyFilterBtn.addEventListener('click', function () {
                    closeFilter();
                    applyFilters();
                });
            }

            // Accordion toggles
            document.querySelectorAll('[data-accordion-toggle]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-accordion-toggle');
                    const content = document.getElementById(targetId);
                    const icon = this.querySelector('svg');

                    if (content.classList.contains('hidden')) {
                        content.classList.remove('hidden');
                        icon.classList.remove('rotate-180');
                    } else {
                        content.classList.add('hidden');
                        icon.classList.add('rotate-180');
                    }
                });
            });

            // Price Range Slider Logic
            function updatePriceTrack() {
                if (!priceRangeMin || !priceRangeMax || !priceRangeTrack) return;

                const min = parseInt(priceRangeMin.value);
                const max = parseInt(priceRangeMax.value);
                const maxRange = parseInt(priceRangeMin.max);

                const leftPercent = (min / maxRange) * 100;
                const rightPercent = ((maxRange - max) / maxRange) * 100;

                priceRangeTrack.style.left = leftPercent + '%';
                priceRangeTrack.style.right = rightPercent + '%';

                console.log('Price Track Updated:', { min, max, leftPercent, rightPercent });
            }

            if (priceRangeMin && priceRangeMax) {
                // Range slider min change
                priceRangeMin.addEventListener('input', function () {
                    let minVal = parseInt(this.value);
                    let maxVal = parseInt(priceRangeMax.value);

                    // Prevent min from exceeding max
                    if (minVal >= maxVal) {
                        minVal = maxVal - 100;
                        this.value = minVal;
                    }

                    priceMin.value = minVal;
                    updatePriceTrack();
                    console.log('Min slider changed:', minVal);
                });

                // Range slider max change
                priceRangeMax.addEventListener('input', function () {
                    let maxVal = parseInt(this.value);
                    let minVal = parseInt(priceRangeMin.value);

                    // Prevent max from going below min
                    if (maxVal <= minVal) {
                        maxVal = minVal + 100;
                        this.value = maxVal;
                    }

                    priceMax.value = maxVal;
                    updatePriceTrack();
                    console.log('Max slider changed:', maxVal);
                });

                // Number input min change
                priceMin.addEventListener('input', function () {
                    let val = parseInt(this.value) || 0;
                    const maxVal = parseInt(priceMax.value);

                    if (val < 0) val = 0;
                    if (val >= maxVal) val = maxVal - 100;
                    if (val > 10000) val = 10000;

                    this.value = val;
                    priceRangeMin.value = val;
                    updatePriceTrack();
                });

                // Number input max change
                priceMax.addEventListener('input', function () {
                    let val = parseInt(this.value) || 10000;
                    const minVal = parseInt(priceMin.value);

                    if (val > 10000) val = 10000;
                    if (val <= minVal) val = minVal + 100;
                    if (val < 0) val = 0;

                    this.value = val;
                    priceRangeMax.value = val;
                    updatePriceTrack();
                });

                // Initialize track on page load
                updatePriceTrack();
                console.log('Price slider initialized');
            }

            // Sort change
            if (sortSelect) {
                sortSelect.addEventListener('change', function () {
                    applyFilters();
                });
            }

            // Search
            if (searchBtn) {
                searchBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    console.log('Search button clicked, value:', searchInput.value);
                    applyFilters();
                });
            }
            if (searchInput) {
                searchInput.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        console.log('Enter pressed, value:', this.value);
                        applyFilters();
                    }
                });
            }

            // Auto-apply filters when checkboxes change
            document.querySelectorAll('input[type="checkbox"][name^="gender"], input[type="checkbox"][name^="tag"], input[type="checkbox"][name^="scent_family"], input[type="checkbox"][name^="collection"], input[type="checkbox"][name^="highlight_note"]').forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    applyFilters();
                });
            });

            // Pill dropdown toggles
            const genderPillBtn = document.getElementById('genderPillBtn');
            const genderPillDropdown = document.getElementById('genderPillDropdown');
            const scentFamilyPillBtn = document.getElementById('scentFamilyPillBtn');
            const scentFamilyPillDropdown = document.getElementById('scentFamilyPillDropdown');

            if (genderPillBtn && genderPillDropdown) {
                genderPillBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    genderPillDropdown.classList.toggle('hidden');
                    if (scentFamilyPillDropdown) scentFamilyPillDropdown.classList.add('hidden');
                });

                // Auto-apply when pill checkboxes change
                genderPillDropdown.querySelectorAll('input[type="checkbox"]').forEach(function (cb) {
                    cb.addEventListener('change', function () {
                        // Sync with sidebar checkboxes
                        const sidebarCheckbox = document.querySelector(`input[name="gender[]"][value="${this.value}"]`);
                        if (sidebarCheckbox) {
                            sidebarCheckbox.checked = this.checked;
                        }
                        applyFilters();
                    });
                });
            }

            if (scentFamilyPillBtn && scentFamilyPillDropdown) {
                scentFamilyPillBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    scentFamilyPillDropdown.classList.toggle('hidden');
                    if (genderPillDropdown) genderPillDropdown.classList.add('hidden');
                });

                // Auto-apply when pill checkboxes change
                scentFamilyPillDropdown.querySelectorAll('input[type="checkbox"]').forEach(function (cb) {
                    cb.addEventListener('change', function () {
                        // Sync with sidebar checkboxes
                        const sidebarCheckbox = document.querySelector(`input[name="scent_family[]"][value="${this.value}"]`);
                        if (sidebarCheckbox) {
                            sidebarCheckbox.checked = this.checked;
                        }
                        applyFilters();
                    });
                });
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function (e) {
                if (genderPillDropdown && !genderPillBtn.contains(e.target)) {
                    genderPillDropdown.classList.add('hidden');
                }
                if (scentFamilyPillDropdown && !scentFamilyPillBtn.contains(e.target)) {
                    scentFamilyPillDropdown.classList.add('hidden');
                }
            });

            // Get selected filter values
            function getFilterValues() {
                const genders = [];
                document.querySelectorAll('input[name="gender[]"]:checked, input[name="gender_pill[]"]:checked').forEach(function (cb) {
                    if (!genders.includes(cb.value)) {
                        genders.push(cb.value);
                    }
                });

                const tags = [];
                document.querySelectorAll('input[name="tag[]"]:checked').forEach(function (cb) {
                    tags.push(cb.value);
                });

                const scentFamilies = [];
                document.querySelectorAll('input[name="scent_family[]"]:checked, input[name="scent_family_pill[]"]:checked').forEach(function (cb) {
                    if (!scentFamilies.includes(cb.value)) {
                        scentFamilies.push(cb.value);
                    }
                });

                const collections = [];
                document.querySelectorAll('input[name="collection[]"]:checked').forEach(function (cb) {
                    collections.push(cb.value);
                });

                const highlightNotes = [];
                document.querySelectorAll('input[name="highlight_note[]"]:checked').forEach(function (cb) {
                    highlightNotes.push(cb.value);
                });

                return {
                    genders: genders,
                    tags: tags,
                    scent_families: scentFamilies,
                    collections: collections,
                    highlight_notes: highlightNotes,
                    price_min: priceMin ? priceMin.value : 0,
                    price_max: priceMax ? priceMax.value : 10000,
                    sort: sortSelect ? sortSelect.value : 'relevance',
                    search: searchInput ? searchInput.value : ''
                };
            }

            // Apply filters via AJAX
            function applyFilters() {
                console.log('applyFilters called');
                const filters = getFilterValues();
                console.log('Filters:', filters);

                // Show loading state
                const productsGrid = document.getElementById('productsGrid');
                if (productsGrid) {
                    productsGrid.innerHTML = '<div class="flex justify-center py-20"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#F27F6E]"></div></div>';
                } else {
                    console.error('productsGrid element not found');
                    return;
                }

                // Build form data
                const formData = new FormData();
                filters.genders.forEach(g => formData.append('genders[]', g));
                filters.tags.forEach(t => formData.append('tags[]', t));
                filters.scent_families.forEach(s => formData.append('scent_families[]', s));
                filters.collections.forEach(c => formData.append('collections[]', c));
                filters.highlight_notes.forEach(h => formData.append('highlight_notes[]', h));
                formData.append('price_min', filters.price_min);
                formData.append('price_max', filters.price_max);
                formData.append('sort', filters.sort);
                formData.append('search', filters.search);

                // AJAX request
                fetch('<?php echo e(route("collections.filter")); ?>', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Recreate the grid structure
                            if (productsGrid) {
                                if (data.total > 0) {
                                    // Has products - create grid directly
                                    productsGrid.innerHTML = `
                                        <div id="productsContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
                                            ${data.html}
                                        </div>
                                    `;
                                } else {
                                    // No products - simple container
                                    productsGrid.innerHTML = `
                                        <div id="productsContainer">
                                            ${data.html}
                                        </div>
                                    `;
                                }
                            }
                            productCount.textContent = data.total + ' Products';

                            // Update or create Load More button
                            let loadMoreContainer = document.getElementById('loadMoreContainer');

                            if (data.current_page < data.last_page) {
                                // Has more pages - show/create button
                                if (!loadMoreContainer) {
                                    // Create container and button
                                    loadMoreContainer = document.createElement('div');
                                    loadMoreContainer.id = 'loadMoreContainer';
                                    loadMoreContainer.className = 'mt-12 flex justify-center';
                                    productsGrid.parentElement.appendChild(loadMoreContainer);
                                }

                                loadMoreContainer.innerHTML = `
                                    <button id="loadMoreBtn" 
                                            data-next-page="${data.current_page + 1}"
                                            data-last-page="${data.last_page}"
                                            data-filters='${JSON.stringify(filters)}'
                                            class="px-8 py-4 bg-gradient-to-r from-gray-900 to-gray-700 text-white rounded-full font-semibold hover:from-black hover:to-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
                                        <span>Load More Products</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                `;

                                // Re-attach event listener
                                attachLoadMoreListener();
                            } else {
                                // No more pages - remove button
                                if (loadMoreContainer) {
                                    loadMoreContainer.remove();
                                }
                            }
                        } else {
                            if (productsGrid) {
                                productsGrid.innerHTML = '<div class="text-center py-20 text-red-500">Error loading products</div>';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Filter error:', error);
                        console.error('Error details:', error.message, error.stack);
                        if (productsGrid) {
                            productsGrid.innerHTML = '<div class="text-center py-20 text-red-500">Error loading products: ' + error.message + '</div>';
                        }
                        alert('Error loading products. Check console for details.');
                    });
            }

            // Attach Load More event listener (defined globally so it can be reused)
            window.attachLoadMoreListener = function () {
                const loadMoreBtn = document.getElementById('loadMoreBtn');
                if (loadMoreBtn) {
                    loadMoreBtn.addEventListener('click', async function () {
                        const button = this;
                        const nextPage = parseInt(button.getAttribute('data-next-page'));
                        const lastPage = parseInt(button.getAttribute('data-last-page'));
                        const filtersJson = button.getAttribute('data-filters');
                        const filters = filtersJson ? JSON.parse(filtersJson) : null;

                        const container = document.getElementById('productsContainer');
                        if (!container) {
                            console.error('Products container not found');
                            return;
                        }

                        // Disable button and show loading
                        button.disabled = true;
                        const originalHTML = button.innerHTML;
                        button.innerHTML = `
                                <svg class="animate-spin w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Loading...</span>
                            `;

                        try {
                            let response;

                            if (filters) {
                                // Load more with filters
                                const formData = new FormData();
                                filters.genders.forEach(g => formData.append('genders[]', g));
                                filters.tags.forEach(t => formData.append('tags[]', t));
                                filters.scent_families.forEach(s => formData.append('scent_families[]', s));
                                filters.collections.forEach(c => formData.append('collections[]', c));
                                filters.highlight_notes.forEach(h => formData.append('highlight_notes[]', h));
                                formData.append('price_min', filters.price_min);
                                formData.append('price_max', filters.price_max);
                                formData.append('sort', filters.sort);
                                formData.append('search', filters.search);
                                formData.append('page', nextPage);

                                response = await fetch('<?php echo e(route("collections.filter")); ?>', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        'Accept': 'application/json'
                                    },
                                    body: formData
                                });

                                const data = await response.json();
                                if (data.success) {
                                    // Append new products
                                    container.insertAdjacentHTML('beforeend', data.html);

                                    // Update button
                                    if (data.current_page >= data.last_page) {
                                        button.parentElement.remove();
                                    } else {
                                        button.setAttribute('data-next-page', data.current_page + 1);
                                        button.disabled = false;
                                        button.innerHTML = originalHTML;
                                    }
                                } else {
                                    throw new Error('Failed to load products');
                                }
                            } else {
                                // Load more without filters (normal pagination)
                                const url = new URL(window.location.href);
                                url.searchParams.set('page', nextPage);

                                response = await fetch(url.toString());
                                const html = await response.text();

                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newProductsContainer = doc.querySelector('#productsContainer');

                                if (newProductsContainer) {
                                    const newProducts = Array.from(newProductsContainer.children);
                                    newProducts.forEach(product => {
                                        container.appendChild(product.cloneNode(true));
                                    });

                                    // Update button
                                    if (nextPage >= lastPage) {
                                        button.parentElement.remove();
                                    } else {
                                        button.setAttribute('data-next-page', nextPage + 1);
                                        button.disabled = false;
                                        button.innerHTML = originalHTML;
                                    }
                                } else {
                                    throw new Error('No products found');
                                }
                            }
                        } catch (error) {
                            console.error('Error loading more products:', error);
                            button.disabled = false;
                            button.innerHTML = originalHTML;
                            alert('Failed to load more products. Please try again.');
                        }
                    });
                }
            };

            // Initialize Load More on page load
            attachLoadMoreListener();

            // Clear all filters
            window.clearAllFilters = function () {
                document.querySelectorAll('input[type="checkbox"]').forEach(function (cb) {
                    cb.checked = false;
                });
                if (sortSelect) sortSelect.value = 'relevance';
                if (searchInput) searchInput.value = '';
                if (priceMin) priceMin.value = 0;
                if (priceMax) priceMax.value = 10000;
                if (priceRangeMin) priceRangeMin.value = 0;
                if (priceRangeMax) priceRangeMax.value = 10000;
                updatePriceTrack();
                applyFilters();
            };
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Applications/XAMPP/htdocs/scentnsmile/resources/views/collection-show.blade.php ENDPATH**/ ?>