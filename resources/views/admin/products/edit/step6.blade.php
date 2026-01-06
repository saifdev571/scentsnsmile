@extends('admin.products.edit._layout')

@section('step_title', 'Step 6: SEO Optimization')
@section('step_description', 'Optimize for search engines and social media')

@section('step_content')
@php
    $currentStep = 6;
    $prevStepRoute = route('admin.products.edit.step5', $product->id);
@endphp

<form id="stepForm" action="{{ route('admin.products.edit.step6.process', $product->id) }}" method="POST">
    @csrf
    
    <div class="bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-teal-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-600 to-teal-600 rounded-lg flex items-center justify-center shadow-lg">
                        <span class="text-white text-xl">🔍</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">SEO & Marketing</h2>
                        <p class="text-gray-600 font-medium">Optimize for search engines & social media</p>
                    </div>
                </div>
                <button type="button" id="generateWithAI" class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-gray-900 to-gray-600 text-white rounded-lg font-semibold hover:from-black hover:to-gray-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Generate with AI
                </button>
            </div>
        </div>
        
        <div class="p-8 space-y-6">
            <!-- Search Engine Optimization -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">🔍 Search Engine Optimization</h3>
                
                <!-- Meta Title -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Meta Title</label>
                    <input type="text" name="meta_title" 
                        value="{{ old('meta_title', $productData['meta_title'] ?? '') }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400"
                        placeholder="Enter SEO title for search engines">
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>Appears in search results and browser tabs</span>
                        <span id="metaTitleCount">0/60</span>
                    </div>
                    @error('meta_title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Meta Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Meta Description</label>
                    <textarea name="meta_description" rows="3" 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400"
                        placeholder="Brief description that appears in search results">{{ old('meta_description', $productData['meta_description'] ?? '') }}</textarea>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>Shown in search results below the title</span>
                        <span id="metaDescCount">0/160</span>
                    </div>
                    @error('meta_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Focus Keywords -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Focus Keywords</label>
                    <input type="text" name="focus_keywords" 
                        value="{{ old('focus_keywords', $productData['focus_keywords'] ?? '') }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400"
                        placeholder="keyword1, keyword2, keyword3">
                    <p class="text-xs text-gray-500 mt-1">Comma-separated keywords you want to rank for</p>
                    @error('focus_keywords')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Canonical URL -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Canonical URL</label>
                    <input type="url" name="canonical_url" 
                        value="{{ old('canonical_url', $productData['canonical_url'] ?? '') }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400"
                        placeholder="https://example.com/product-url">
                    <p class="text-xs text-gray-500 mt-1">Preferred URL for this product (prevents duplicate content)</p>
                    @error('canonical_url')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Google Search Preview -->
                <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-6">
                    <h4 class="text-md font-bold text-gray-700 mb-4 flex items-center">
                        <span class="text-lg mr-2">👁️</span>
                        Google Search Preview
                    </h4>
                    <div class="bg-white p-4 rounded-lg border shadow-sm">
                        <div class="space-y-1">
                            <div id="previewTitle" class="text-blue-600 text-lg font-medium hover:underline cursor-pointer" style="line-height: 1.3;">
                                Enter a meta title to see preview...
                            </div>
                            <div id="previewUrl" class="text-green-700 text-sm" style="line-height: 1.4;">
                                https://yourstore.com/products/product-name
                            </div>
                            <div id="previewDescription" class="text-gray-600 text-sm" style="line-height: 1.4; max-width: 600px;">
                                Enter a meta description to see how it appears in Google search results...
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-xs text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        This is how your product will appear in Google search results
                    </div>
                </div>
            </div>

            <!-- Social Media Optimization -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2">📱 Social Media Optimization</h3>
                
                <!-- Open Graph Title -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Open Graph Title <span class="text-gray-500 text-xs">(Facebook, LinkedIn)</span></label>
                    <input type="text" name="og_title" maxlength="60" 
                        value="{{ old('og_title', $productData['og_title'] ?? '') }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400"
                        placeholder="Title for social media shares">
                    <p class="text-xs text-gray-500 mt-1">Title shown when shared on Facebook, LinkedIn</p>
                    @error('og_title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Open Graph Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Open Graph Description</label>
                    <textarea name="og_description" rows="3" 
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400"
                        placeholder="Description for social media shares">{{ old('og_description', $productData['og_description'] ?? '') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Description shown when shared on social media</p>
                    @error('og_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- SEO Tips -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h3 class="font-semibold text-yellow-800 mb-2">💡 SEO Best Practices</h3>
                <ul class="text-sm text-yellow-700 space-y-1">
                    <li>• Use your main keyword in the meta title</li>
                    <li>• Write compelling meta descriptions that encourage clicks</li>
                    <li>• Include relevant keywords naturally in descriptions</li>
                    <li>• Make social media titles engaging and share-worthy</li>
                    <li>• Keep URLs short, descriptive, and SEO-friendly</li>
                </ul>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // AI SEO Generation
    const generateBtn = document.getElementById('generateWithAI');
    if (generateBtn) {
        generateBtn.addEventListener('click', async function() {
            const button = this;
            const originalHTML = button.innerHTML;
            
            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (!csrfToken) {
                showNotification('CSRF token not found. Please refresh the page.', 'error');
                return;
            }
            
            // Disable button and show loading
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Generating...
            `;
            
            try {
                const response = await fetch('{{ route("admin.products.generate-seo") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: {{ $product->id ?? 'null' }}
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Fill in the form fields
                    if (result.data.meta_title) {
                        document.querySelector('input[name="meta_title"]').value = result.data.meta_title;
                        document.querySelector('input[name="meta_title"]').dispatchEvent(new Event('input'));
                    }
                    
                    if (result.data.meta_description) {
                        document.querySelector('textarea[name="meta_description"]').value = result.data.meta_description;
                        document.querySelector('textarea[name="meta_description"]').dispatchEvent(new Event('input'));
                    }
                    
                    if (result.data.focus_keywords) {
                        document.querySelector('input[name="focus_keywords"]').value = result.data.focus_keywords;
                    }
                    
                    if (result.data.canonical_url) {
                        document.querySelector('input[name="canonical_url"]').value = result.data.canonical_url;
                        document.querySelector('input[name="canonical_url"]').dispatchEvent(new Event('input'));
                    }
                    
                    if (result.data.og_title) {
                        document.querySelector('input[name="og_title"]').value = result.data.og_title;
                    }
                    
                    if (result.data.og_description) {
                        document.querySelector('textarea[name="og_description"]').value = result.data.og_description;
                    }
                    
                    // Show success message
                    showNotification('SEO content generated successfully!', 'success');
                } else {
                    showNotification(result.message || 'Failed to generate SEO content', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('An error occurred while generating SEO content', 'error');
            } finally {
                // Re-enable button
                button.disabled = false;
                button.innerHTML = originalHTML;
            }
        });
    }

    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white font-medium animate-fade-in-down`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }

    // Character count for meta fields & Real-time Google Preview
    const metaTitle = document.querySelector('input[name="meta_title"]');
    const metaDescription = document.querySelector('textarea[name="meta_description"]');
    const canonicalUrl = document.querySelector('input[name="canonical_url"]');
    const metaTitleCount = document.getElementById('metaTitleCount');
    const metaDescCount = document.getElementById('metaDescCount');
    
    // Preview elements
    const previewTitle = document.getElementById('previewTitle');
    const previewUrl = document.getElementById('previewUrl');
    const previewDescription = document.getElementById('previewDescription');
    
    // Get product name and slug from session storage (from step 1)
    const productName = sessionStorage.getItem('productName') || 'Product Name';
    const productSlug = sessionStorage.getItem('productSlug') || 'product-name';

    function updateCount(input, counter) {
        const current = input.value.length;
        const max = input.getAttribute('maxlength');
        counter.textContent = `${current}/${max}`;
        
        // Color coding for optimal lengths
        if (input.name === 'meta_title') {
            if (current >= 50 && current <= 60) {
                counter.className = 'text-green-600 font-semibold';
            } else if (current > 60) {
                counter.className = 'text-red-600 font-semibold';
            } else {
                counter.className = 'text-gray-500';
            }
        } else if (input.name === 'meta_description') {
            if (current >= 150 && current <= 160) {
                counter.className = 'text-green-600 font-semibold';
            } else if (current > 160) {
                counter.className = 'text-red-600 font-semibold';
            } else {
                counter.className = 'text-gray-500';
            }
        }
    }
    
    function updateGooglePreview() {
        // Update title
        const title = metaTitle.value.trim() || productName + ' | Your Store Name';
        previewTitle.textContent = title.length > 60 ? title.substring(0, 57) + '...' : title;
        
        // Update URL
        const baseUrl = canonicalUrl.value.trim() || `https://yourstore.com/products/${productSlug}`;
        previewUrl.textContent = baseUrl;
        
        // Update description
        const description = metaDescription.value.trim() || 'Enter a meta description to see how it appears in Google search results. This text helps users understand what your product is about.';
        previewDescription.textContent = description.length > 160 ? description.substring(0, 157) + '...' : description;
        
        // Update character count colors based on preview
        if (title.length > 60) {
            previewTitle.className = 'text-blue-600 text-lg font-medium hover:underline cursor-pointer truncate';
        } else {
            previewTitle.className = 'text-blue-600 text-lg font-medium hover:underline cursor-pointer';
        }
    }
    
    // Initialize counts and preview
    if (metaTitle && metaTitleCount) {
        updateCount(metaTitle, metaTitleCount);
        metaTitle.addEventListener('input', () => {
            updateCount(metaTitle, metaTitleCount);
            updateGooglePreview();
        });
    }

    if (metaDescription && metaDescCount) {
        updateCount(metaDescription, metaDescCount);
        metaDescription.addEventListener('input', () => {
            updateCount(metaDescription, metaDescCount);
            updateGooglePreview();
        });
    }
    
    if (canonicalUrl) {
        canonicalUrl.addEventListener('input', updateGooglePreview);
    }
    
    // Initial preview update
    updateGooglePreview();
});
</script>
@endpush
@endsection
