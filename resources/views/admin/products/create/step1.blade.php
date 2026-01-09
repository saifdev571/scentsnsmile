@extends('admin.products.create._layout')

@section('step_title', 'Step 1: Basic Information')
@section('step_description', 'Enter essential product details')

@section('step_content')
@php
    $currentStep = 1;
    $prevStepRoute = null;
@endphp

<form id="stepForm" action="{{ route('admin.products.create.step1.process') }}" method="POST">
    @csrf
    
    <div class="bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                    <span class="text-white text-xl">📝</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Basic Information</h2>
                    <p class="text-gray-600 font-medium">Enter essential product details</p>
                </div>
            </div>
        </div>
        
        <div class="p-8 space-y-6">
            <!-- Product Name & Slug (Side by Side) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Product Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="productName" required 
                        value="{{ old('name', $productData['name'] ?? '') }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400"
                        placeholder="Enter product name"
                        oninput="updateSlug()">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- URL Slug -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">URL Slug <span class="text-blue-500 text-xs">(Auto-generated)</span></label>
                    <input type="text" name="slug" id="productSlug" readonly
                        value="{{ old('slug', $productData['slug'] ?? '') }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg bg-gray-50 text-gray-700 cursor-not-allowed"
                        placeholder="will-be-generated-from-name">
                    <p class="text-xs text-blue-500 mt-1">✨ Automatically generated from product name</p>
                    @error('slug')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Inspired By Section -->
            <div class="border-t border-gray-200 pt-6 mt-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-r from-amber-500 to-orange-500 rounded-lg flex items-center justify-center shadow-lg">
                        <span class="text-white text-lg">✨</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Inspired By</h3>
                        <p class="text-gray-600 text-sm">Original fragrance reference and retail price</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Inspired By Text -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Inspired By <span class="text-gray-500 text-xs">(Optional)</span></label>
                        <input type="text" name="inspired_by" id="inspiredBy"
                            value="{{ old('inspired_by', $productData['inspired_by'] ?? '') }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 hover:border-gray-400"
                            placeholder="e.g., MFK's Baccarat Rouge 540">
                        @error('inspired_by')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Retail Price -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Retail Price <span class="text-gray-500 text-xs">(Optional)</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">RS.</span>
                            <input type="number" name="retail_price" id="retailPrice" step="0.01" min="0"
                                value="{{ old('retail_price', $productData['retail_price'] ?? '') }}"
                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 hover:border-gray-400"
                                placeholder="27400">
                        </div>
                        @error('retail_price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Retail Price Color -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Price Text Color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="retail_price_color" id="retailPriceColor"
                                value="{{ old('retail_price_color', $productData['retail_price_color'] ?? '#B8860B') }}"
                                class="w-14 h-12 border-2 border-gray-300 rounded-lg cursor-pointer">
                            <input type="text" id="retailPriceColorText"
                                value="{{ old('retail_price_color', $productData['retail_price_color'] ?? '#B8860B') }}"
                                class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 uppercase"
                                placeholder="#B8860B"
                                maxlength="7">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Color for retail price text display</p>
                    </div>
                </div>

                <!-- Preview -->
                <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs text-gray-500 mb-2">Preview:</p>
                    <div>
                        <p class="text-sm text-gray-600">Inspired by</p>
                        <p class="text-lg font-bold text-gray-900" id="previewInspiredBy">MFK's Baccarat Rouge 540</p>
                        <p class="text-sm font-medium" id="previewRetailPrice" style="color: #B8860B;">(RETAIL PRICE: RS. 27,400)</p>
                    </div>
                </div>
            </div>

            <!-- Highlight Notes -->
            @if(isset($highlightNotes) && $highlightNotes->count() > 0)
            <div x-data="highlightNotesDropdown()">
                <label class="block text-sm font-semibold text-gray-800 mb-3">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        Highlight Notes
                    </span>
                </label>
                <div class="relative">
                    <button @click="open = !open" type="button" class="w-full px-4 py-3 text-left border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 hover:border-gray-400 flex justify-between items-center">
                        <span x-text="selectedCount > 0 ? selectedCount + ' notes selected' : 'Select highlight notes'" class="truncate text-gray-700"></span>
                        <svg class="w-4 h-4 ml-2 text-gray-500 transition-transform duration-200 flex-shrink-0" :class="{'rotate-180': open}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute z-20 mt-2 w-full bg-white border-2 border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        <input type="text" placeholder="Search notes..." x-model="search" class="w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:ring-1 focus:ring-amber-500">
                        <template x-for="note in filteredNotes" :key="note.id">
                            <label class="flex items-center px-4 py-2 cursor-pointer hover:bg-amber-50">
                                <input type="checkbox" :value="note.id" x-model="selected" class="w-4 h-4 text-amber-500 border-gray-300 rounded focus:ring-amber-500 mr-3">
                                <span x-text="note.name" class="text-sm text-gray-700"></span>
                            </label>
                        </template>
                        <div x-show="filteredNotes.length === 0" class="px-4 py-2 text-gray-400">No results found.</div>
                    </div>
                    </div>
                    <!-- Hidden inputs for form submission -->
                    <template x-for="id in selected" :key="id">
                        <input type="hidden" name="highlight_notes[]" :value="id">
                    </template>
                </div>
                <p class="text-xs text-gray-500 mt-2">Select highlight notes to display on product page (searchable)</p>
            </div>
            @endif

            <!-- Scent Families -->
            @if(isset($scentFamilies) && $scentFamilies->count() > 0)
            <div x-data="scentFamiliesDropdown()">
                <label class="block text-sm font-semibold text-gray-800 mb-3">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Scent Families
                    </span>
                </label>
                <div class="relative">
                    <button @click="open = !open" type="button" class="w-full px-4 py-3 text-left border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 hover:border-gray-400 flex justify-between items-center">
                        <span x-text="selectedCount > 0 ? selectedCount + ' families selected' : 'Select scent families'" class="truncate text-gray-700"></span>
                        <svg class="w-4 h-4 ml-2 text-gray-500 transition-transform duration-200 flex-shrink-0" :class="{'rotate-180': open}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute z-20 mt-2 w-full bg-white border-2 border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        <input type="text" placeholder="Search families..." x-model="search" class="w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:ring-1 focus:ring-purple-500">
                        <template x-for="family in filteredFamilies" :key="family.id">
                            <label class="flex items-center px-4 py-2 cursor-pointer hover:bg-purple-50">
                                <input type="checkbox" :value="family.id" x-model="selected" class="w-4 h-4 text-purple-500 border-gray-300 rounded focus:ring-purple-500 mr-3">
                                <span x-text="family.name" class="text-sm text-gray-700"></span>
                            </label>
                        </template>
                        <div x-show="filteredFamilies.length === 0" class="px-4 py-2 text-gray-400">No results found.</div>
                    </div>
                    </div>
                    <!-- Hidden inputs for form submission -->
                    <template x-for="id in selected" :key="id">
                        <input type="hidden" name="scent_families[]" :value="id">
                    </template>
                </div>
                <p class="text-xs text-gray-500 mt-2">Select scent families for this product (searchable)</p>
            </div>
            @endif

            <!-- Scent Intensity Scale -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-3">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                        </svg>
                        Scent Intensity Scale
                    </span>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Soft -->
                    <label class="relative flex flex-col p-4 bg-gray-50 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-purple-400 hover:bg-purple-50 transition-all duration-200 group has-[:checked]:border-purple-500 has-[:checked]:bg-purple-50">
                        <input type="radio" name="scent_intensity" value="soft" 
                            class="absolute top-4 right-4 w-5 h-5 text-purple-500 border-gray-300 focus:ring-purple-500"
                            {{ old('scent_intensity', $productData['scent_intensity'] ?? '') === 'soft' ? 'checked' : '' }}>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-2xl">🌸</span>
                            </div>
                            <div>
                                <p class="text-base font-bold text-gray-900">Soft</p>
                                <p class="text-xs text-gray-500">Subtle & Delicate</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">Light, airy fragrance that stays close to the skin. Perfect for everyday wear and intimate settings.</p>
                    </label>

                    <!-- Significant -->
                    <label class="relative flex flex-col p-4 bg-gray-50 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-purple-400 hover:bg-purple-50 transition-all duration-200 group has-[:checked]:border-purple-500 has-[:checked]:bg-purple-50">
                        <input type="radio" name="scent_intensity" value="significant" 
                            class="absolute top-4 right-4 w-5 h-5 text-purple-500 border-gray-300 focus:ring-purple-500"
                            {{ old('scent_intensity', $productData['scent_intensity'] ?? '') === 'significant' ? 'checked' : '' }}>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-2xl">🌺</span>
                            </div>
                            <div>
                                <p class="text-base font-bold text-gray-900">Significant</p>
                                <p class="text-xs text-gray-500">Balanced & Noticeable</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">Moderate projection with good presence. Noticeable without being overwhelming. Ideal for most occasions.</p>
                    </label>

                    <!-- Statement -->
                    <label class="relative flex flex-col p-4 bg-gray-50 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-purple-400 hover:bg-purple-50 transition-all duration-200 group has-[:checked]:border-purple-500 has-[:checked]:bg-purple-50">
                        <input type="radio" name="scent_intensity" value="statement" 
                            class="absolute top-4 right-4 w-5 h-5 text-purple-500 border-gray-300 focus:ring-purple-500"
                            {{ old('scent_intensity', $productData['scent_intensity'] ?? '') === 'statement' ? 'checked' : '' }}>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-pink-100 to-red-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-2xl">🌹</span>
                            </div>
                            <div>
                                <p class="text-base font-bold text-gray-900">Statement</p>
                                <p class="text-xs text-gray-500">Bold & Powerful</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">Strong, commanding presence with excellent sillage. Makes a lasting impression. Best for special occasions.</p>
                    </label>
                </div>
                <p class="text-xs text-gray-500 mt-2">Select the intensity level that best describes this fragrance</p>
            </div>

            <!-- Moments Selection (Multiple) -->
            @if(isset($moments) && $moments->count() > 0)
            <div x-data="momentsDropdown()">
                <label class="block text-sm font-semibold text-gray-800 mb-3">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                        </svg>
                        Moments
                        <span class="text-gray-500 text-xs font-normal">(Optional)</span>
                    </span>
                </label>
                <div class="relative">
                    <button @click="open = !open" type="button" class="w-full px-4 py-3 text-left border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200 hover:border-gray-400 flex justify-between items-center">
                        <span x-text="selectedCount > 0 ? selectedCount + ' moments selected' : 'Select moments...'" class="truncate text-gray-700"></span>
                        <svg class="w-4 h-4 ml-2 text-gray-500 transition-transform duration-200 flex-shrink-0" :class="{'rotate-180': open}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute z-20 mt-2 w-full bg-white border-2 border-gray-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        <input type="text" placeholder="Search moments..." x-model="search" class="w-full px-3 py-2 border-b border-gray-200 focus:outline-none focus:ring-1 focus:ring-pink-500">
                        <template x-for="moment in filteredMoments" :key="moment.id">
                            <label class="flex items-center px-4 py-2 cursor-pointer hover:bg-pink-50">
                                <input type="checkbox" :value="moment.id" x-model="selected" name="moments[]" class="w-4 h-4 text-pink-500 border-gray-300 rounded focus:ring-pink-500 mr-3">
                                <span x-text="moment.name" class="text-sm text-gray-700"></span>
                            </label>
                        </template>
                        <div x-show="filteredMoments.length === 0" class="px-4 py-2 text-gray-400">No results found.</div>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Select moments/occasions this fragrance is perfect for (searchable, multiple selection)</p>
            </div>
            @endif

            <!-- Product Tab Content Header -->
            <div class="border-t border-gray-200 pt-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg flex items-center justify-center shadow-lg">
                        <span class="text-white text-lg">📋</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Product Tab Content</h3>
                        <p class="text-gray-600 text-sm">Content for product detail page tabs</p>
                    </div>
                </div>
            </div>

            <!-- About This Scent -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">About This Scent <span class="text-gray-500 text-xs">(Optional)</span></label>
                <div class="quill-editor-wrapper" id="aboutScentSection">
                    <div id="aboutScentEditor" style="height: 200px;"></div>
                </div>
                <textarea name="about_scent" id="aboutScentHidden" class="hidden">{{ old('about_scent', $productData['about_scent'] ?? '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Describe the scent profile and character</p>
            </div>

            <!-- Fragrance Notes -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Fragrance Notes <span class="text-gray-500 text-xs">(Optional)</span></label>
                <div class="quill-editor-wrapper" id="fragranceNotesSection">
                    <div id="fragranceNotesEditor" style="height: 200px;"></div>
                </div>
                <textarea name="fragrance_notes" id="fragranceNotesHidden" class="hidden">{{ old('fragrance_notes', $productData['fragrance_notes'] ?? '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Top, middle, and base notes</p>
            </div>

            <!-- Why You'll Love It -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Why You'll Love It <span class="text-gray-500 text-xs">(Optional)</span></label>
                <div class="quill-editor-wrapper" id="whyLoveSection">
                    <div id="whyLoveEditor" style="height: 200px;"></div>
                </div>
                <textarea name="why_love_it" id="whyLoveHidden" class="hidden">{{ old('why_love_it', $productData['why_love_it'] ?? '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Key selling points and benefits</p>
            </div>

            <!-- What Makes It Clean -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">What Makes It Clean <span class="text-gray-500 text-xs">(Optional)</span></label>
                <div class="quill-editor-wrapper" id="whatCleanSection">
                    <div id="whatCleanEditor" style="height: 200px;"></div>
                </div>
                <textarea name="what_makes_clean" id="whatCleanHidden" class="hidden">{{ old('what_makes_clean', $productData['what_makes_clean'] ?? '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Clean beauty and sustainability info</p>
            </div>

            <!-- Ingredients and Details -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Ingredients and Details <span class="text-gray-500 text-xs">(Optional)</span></label>
                <div class="quill-editor-wrapper" id="ingredientsDetailsSection">
                    <div id="ingredientsDetailsEditor" style="height: 200px;"></div>
                </div>
                <textarea name="ingredients_details" id="ingredientsDetailsHidden" class="hidden">{{ old('ingredients_details', $productData['ingredients_details'] ?? '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Full ingredients list and product details</p>
            </div>

            <!-- Shipping Information -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Shipping Information <span class="text-gray-500 text-xs">(Optional)</span></label>
                <div class="quill-editor-wrapper" id="shippingInfoSection">
                    <div id="shippingInfoEditor" style="height: 200px;"></div>
                </div>
                <textarea name="shipping_info" id="shippingInfoHidden" class="hidden">{{ old('shipping_info', $productData['shipping_info'] ?? '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Shipping times, costs, and policies</p>
            </div>

            <!-- Disclaimer -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Disclaimer <span class="text-gray-500 text-xs">(Optional)</span></label>
                <div class="quill-editor-wrapper" id="disclaimerSection">
                    <div id="disclaimerEditor" style="height: 200px;"></div>
                </div>
                <textarea name="disclaimer" id="disclaimerHidden" class="hidden">{{ old('disclaimer', $productData['disclaimer'] ?? '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Legal disclaimers and warnings</p>
            </div>

            <!-- Ask a Question -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Ask a Question <span class="text-gray-500 text-xs">(Optional)</span></label>
                <div class="quill-editor-wrapper" id="askQuestionSection">
                    <div id="askQuestionEditor" style="height: 200px;"></div>
                </div>
                <textarea name="ask_question" id="askQuestionHidden" class="hidden">{{ old('ask_question', $productData['ask_question'] ?? '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">FAQ or contact information for questions</p>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<!-- Alpine.js for Searchable Dropdowns -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Quill Editor -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<script>
// Moments Dropdown (Multiple Selection)
function momentsDropdown() {
    return {
        open: false,
        search: '',
        selected: @json(old('moments', $productData['moments'] ?? [])),
        moments: @json($moments),
        
        get filteredMoments() {
            return this.moments.filter(moment =>
                moment.name.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        
        get selectedCount() {
            return this.selected.length;
        }
    };
}

// Highlight Notes Dropdown (Multiple Selection)
function highlightNotesDropdown() {
    return {
        open: false,
        search: '',
        selected: @json(old('highlight_notes', $productData['highlight_notes'] ?? [])),
        notes: @json($highlightNotes),
        
        get filteredNotes() {
            return this.notes.filter(note =>
                note.name.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        
        get selectedCount() {
            return this.selected.length;
        }
    };
}

// Scent Families Dropdown (Multiple Selection)
function scentFamiliesDropdown() {
    return {
        open: false,
        search: '',
        selected: @json(old('scent_families', $productData['scent_families'] ?? [])),
        families: @json($scentFamilies),
        
        get filteredFamilies() {
            return this.families.filter(family =>
                family.name.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        
        get selectedCount() {
            return this.selected.length;
        }
    };
}

// Product Tab Editors with Color Option
let aboutScentQuill = new Quill('#aboutScentEditor', {
    theme: 'snow',
    placeholder: 'Describe the scent profile...',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'color': [] }, { 'background': [] }],
            ['link'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['clean']
        ]
    }
});

let fragranceNotesQuill = new Quill('#fragranceNotesEditor', {
    theme: 'snow',
    placeholder: 'Top, middle, and base notes...',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'color': [] }, { 'background': [] }],
            ['link'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['clean']
        ]
    }
});

let whyLoveQuill = new Quill('#whyLoveEditor', {
    theme: 'snow',
    placeholder: 'Why customers will love this product...',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'color': [] }, { 'background': [] }],
            ['link'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['clean']
        ]
    }
});

let whatCleanQuill = new Quill('#whatCleanEditor', {
    theme: 'snow',
    placeholder: 'Clean beauty and sustainability info...',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'color': [] }, { 'background': [] }],
            ['link'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['clean']
        ]
    }
});

let ingredientsDetailsQuill = new Quill('#ingredientsDetailsEditor', {
    theme: 'snow',
    placeholder: 'Full ingredients list...',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'color': [] }, { 'background': [] }],
            ['link'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['clean']
        ]
    }
});

let shippingInfoQuill = new Quill('#shippingInfoEditor', {
    theme: 'snow',
    placeholder: 'Shipping times and policies...',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'color': [] }, { 'background': [] }],
            ['link'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['clean']
        ]
    }
});

let disclaimerQuill = new Quill('#disclaimerEditor', {
    theme: 'snow',
    placeholder: 'Legal disclaimers...',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'color': [] }, { 'background': [] }],
            ['link'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['clean']
        ]
    }
});

let askQuestionQuill = new Quill('#askQuestionEditor', {
    theme: 'snow',
    placeholder: 'FAQ or contact info...',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            [{ 'color': [] }, { 'background': [] }],
            ['link'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['clean']
        ]
    }
});

// Product Tab Content
if (document.getElementById('aboutScentHidden').value) {
    aboutScentQuill.root.innerHTML = document.getElementById('aboutScentHidden').value;
}

if (document.getElementById('fragranceNotesHidden').value) {
    fragranceNotesQuill.root.innerHTML = document.getElementById('fragranceNotesHidden').value;
}

if (document.getElementById('whyLoveHidden').value) {
    whyLoveQuill.root.innerHTML = document.getElementById('whyLoveHidden').value;
}

if (document.getElementById('whatCleanHidden').value) {
    whatCleanQuill.root.innerHTML = document.getElementById('whatCleanHidden').value;
}

if (document.getElementById('ingredientsDetailsHidden').value) {
    ingredientsDetailsQuill.root.innerHTML = document.getElementById('ingredientsDetailsHidden').value;
}

if (document.getElementById('shippingInfoHidden').value) {
    shippingInfoQuill.root.innerHTML = document.getElementById('shippingInfoHidden').value;
}

if (document.getElementById('disclaimerHidden').value) {
    disclaimerQuill.root.innerHTML = document.getElementById('disclaimerHidden').value;
}

if (document.getElementById('askQuestionHidden').value) {
    askQuestionQuill.root.innerHTML = document.getElementById('askQuestionHidden').value;
}

// Product Tab Content change handlers
aboutScentQuill.on('text-change', function() {
    document.getElementById('aboutScentHidden').value = aboutScentQuill.root.innerHTML;
});

fragranceNotesQuill.on('text-change', function() {
    document.getElementById('fragranceNotesHidden').value = fragranceNotesQuill.root.innerHTML;
});

whyLoveQuill.on('text-change', function() {
    document.getElementById('whyLoveHidden').value = whyLoveQuill.root.innerHTML;
});

whatCleanQuill.on('text-change', function() {
    document.getElementById('whatCleanHidden').value = whatCleanQuill.root.innerHTML;
});

ingredientsDetailsQuill.on('text-change', function() {
    document.getElementById('ingredientsDetailsHidden').value = ingredientsDetailsQuill.root.innerHTML;
});

shippingInfoQuill.on('text-change', function() {
    document.getElementById('shippingInfoHidden').value = shippingInfoQuill.root.innerHTML;
});

disclaimerQuill.on('text-change', function() {
    document.getElementById('disclaimerHidden').value = disclaimerQuill.root.innerHTML;
});

askQuestionQuill.on('text-change', function() {
    document.getElementById('askQuestionHidden').value = askQuestionQuill.root.innerHTML;
});

// Auto-generate slug from product name
function updateSlug() {
    const name = document.getElementById('productName').value;
    const slug = name
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '') // Remove special characters except letters, numbers, spaces, hyphens
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens with single
        .replace(/^-+|-+$/g, '') // Remove leading/trailing hyphens
        .trim();
    
    document.getElementById('productSlug').value = slug || 'product-slug';
    
    // Store product name and slug in session storage for SKU generation and SEO preview
    sessionStorage.setItem('productName', name);
    sessionStorage.setItem('productSlug', slug || 'product-slug');
}

// Store initial product name on page load
window.addEventListener('DOMContentLoaded', function() {
    const productNameField = document.getElementById('productName');
    if (productNameField && productNameField.value) {
        sessionStorage.setItem('productName', productNameField.value);
    }
    
    // Initialize Inspired By preview
    updateInspiredByPreview();
});

// Color picker sync
const colorPicker = document.getElementById('retailPriceColor');
const colorText = document.getElementById('retailPriceColorText');

if (colorPicker && colorText) {
    colorPicker.addEventListener('input', function() {
        colorText.value = this.value.toUpperCase();
        updateInspiredByPreview();
    });
    
    colorText.addEventListener('input', function() {
        let val = this.value;
        if (!val.startsWith('#')) val = '#' + val;
        if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
            colorPicker.value = val;
        }
        updateInspiredByPreview();
    });
}

// Inspired By preview update
const inspiredByInput = document.getElementById('inspiredBy');
const retailPriceInput = document.getElementById('retailPrice');

if (inspiredByInput) {
    inspiredByInput.addEventListener('input', updateInspiredByPreview);
}
if (retailPriceInput) {
    retailPriceInput.addEventListener('input', updateInspiredByPreview);
}

function updateInspiredByPreview() {
    const inspiredBy = document.getElementById('inspiredBy')?.value || "MFK's Baccarat Rouge 540";
    const retailPrice = document.getElementById('retailPrice')?.value || '27400';
    const color = document.getElementById('retailPriceColor')?.value || '#B8860B';
    
    const previewInspiredBy = document.getElementById('previewInspiredBy');
    const previewRetailPrice = document.getElementById('previewRetailPrice');
    
    if (previewInspiredBy) {
        previewInspiredBy.textContent = inspiredBy || "MFK's Baccarat Rouge 540";
    }
    
    if (previewRetailPrice) {
        const formattedPrice = retailPrice ? Number(retailPrice).toLocaleString('en-IN') : '27,400';
        previewRetailPrice.textContent = `(RETAIL PRICE: RS. ${formattedPrice})`;
        previewRetailPrice.style.color = color;
    }
}

// Form submission handler
document.getElementById('stepForm').addEventListener('submit', function(e) {
    // Update hidden fields before submission - Product Tab Content
    document.getElementById('aboutScentHidden').value = aboutScentQuill.root.innerHTML;
    document.getElementById('fragranceNotesHidden').value = fragranceNotesQuill.root.innerHTML;
    document.getElementById('whyLoveHidden').value = whyLoveQuill.root.innerHTML;
    document.getElementById('whatCleanHidden').value = whatCleanQuill.root.innerHTML;
    document.getElementById('ingredientsDetailsHidden').value = ingredientsDetailsQuill.root.innerHTML;
    document.getElementById('shippingInfoHidden').value = shippingInfoQuill.root.innerHTML;
    document.getElementById('disclaimerHidden').value = disclaimerQuill.root.innerHTML;
    document.getElementById('askQuestionHidden').value = askQuestionQuill.root.innerHTML;
});
</script>
@endpush
@endsection