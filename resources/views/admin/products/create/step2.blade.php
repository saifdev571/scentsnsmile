@extends('admin.products.create._layout')

@section('step_title', 'Step 2: Media & Images')
@section('step_description', 'Upload product images and media')

@push('styles')
<style>
/* SortableJS Custom Styles */
.sortable-ghost {
    opacity: 0.5;
    transform: rotate(2deg);
}

.sortable-chosen {
    transform: scale(1.05);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    border: 2px solid #3b82f6 !important;
}

.sortable-drag {
    transform: rotate(5deg) scale(1.1);
    z-index: 1000;
}

.image-item {
    transition: all 0.2s ease;
}

.image-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Upload area animations */
.image-upload-area {
    transition: all 0.3s ease;
}

.image-upload-area.dragover {
    transform: scale(1.02);
    border-color: #3b82f6;
    background-color: #eff6ff;
}
</style>
@endpush

@section('step_content')
@php
    $currentStep = 2;
    $prevStepRoute = route('admin.products.create.step1');
@endphp

<form id="stepForm" action="{{ route('admin.products.create.step2.process') }}" method="POST">
    @csrf
    
    <div class="bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg flex items-center justify-center shadow-lg">
                    <span class="text-white text-xl">📸</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Product Media</h2>
                    <p class="text-gray-600 font-medium">Upload high-quality product images</p>
                </div>
            </div>
        </div>
        
        <div class="p-8 space-y-8">
            <!-- Additional Images -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-3">Product Images <span class="text-red-500">*</span> <span class="text-gray-500 text-sm">(up to 8 images)</span></label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-500 transition-all cursor-pointer image-upload-area" id="additionalImagesUpload">
                    <input type="file" id="additionalImagesInput" accept="image/*" multiple class="hidden">
                    <div id="additionalImagesPlaceholder" class="space-y-4">
                        <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-gray-700">Click to upload product images</p>
                            <p class="text-sm text-gray-500">Select multiple images at once</p>
                            <p class="text-xs text-gray-400">PNG, JPG, GIF up to 10MB each • First image will be featured</p>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Images Preview Grid -->
                <div id="additionalImagesGrid" class="hidden mt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-sm font-semibold text-gray-800">Uploaded Images (<span id="imageCount">0</span>)</h4>
                        <p class="text-xs text-gray-500">Drag to reorder • First image will be featured</p>
                    </div>
                    <div id="sortableImages" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Images will be populated here -->
                    </div>
                </div>
                
                <input type="hidden" name="additional_images" id="additionalImagesData" value="{{ old('additional_images', $productData['additional_images'] ?? '[]') }}">
                @error('additional_images')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Tips -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="font-semibold text-blue-800 mb-2">📋 Media Guidelines</h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• <strong>Images:</strong> Uploaded in original quality via ImageKit</li>
                    <li>• <strong>First image becomes the featured/main product image</strong></li>
                    <li>• Drag & drop to reorder images</li>
                    <li>• Show product from multiple angles for better conversions</li>
                    <li>• <strong>Supported:</strong> Images (JPG, PNG, GIF, WebP)</li>
                </ul>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<!-- SortableJS for drag & drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
let additionalImages = [];
let sortable = null;

// Load existing images and videos if any
document.addEventListener('DOMContentLoaded', function() {
    // Load existing additional images
    const existingAdditionalImages = document.getElementById('additionalImagesData').value;
    if (existingAdditionalImages && existingAdditionalImages !== '[]') {
        try {
            const parsed = JSON.parse(existingAdditionalImages);
            // Ensure each image has required properties with defaults
            additionalImages = parsed.map(img => ({
                url: img.url || '',
                fileId: img.fileId || 'unknown',
                size: img.size || 0,
                originalSize: img.originalSize || img.size || 0,
                width: img.width || 360,
                height: img.height || 459,
                name: img.name || 'image'
            }));
            updateAdditionalImagesGrid();
        } catch (e) {
            console.error('Error parsing additional images:', e);
            additionalImages = [];
        }
    }
});

// Additional images upload
document.getElementById('additionalImagesUpload').addEventListener('click', function() {
    document.getElementById('additionalImagesInput').click();
});

document.getElementById('additionalImagesInput').addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    if (files.length > 0) {
        // Check maximum images limit (8 total)
        if (additionalImages.length + files.length > 8) {
            showNotification(`Maximum 8 images allowed. You can upload ${8 - additionalImages.length} more.`, 'error');
            return;
        }
        uploadAdditionalImages(files);
    }
});

async function uploadAdditionalImages(files) {
    // Show upload progress
    showAdditionalImagesLoading(files.length);
    
    const uploadPromises = files.map(async (file, index) => {
        const formData = new FormData();
        formData.append('image', file);
        formData.append('folder', 'products');
        
        try {
            const response = await fetch('{{ route("admin.upload.image") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const result = await response.json();
            
            // Debug log for additional images
            console.log('Additional Image Upload Response:', result, 'Original file size:', file.size);
            
            if (result.success) {
                // Estimate compressed size if not provided (rough calculation: 35% of original)
                const estimatedSize = result.size || Math.round(file.size * 0.35);
                const originalSize = result.original_size || result.originalSize || file.size || 0;
                
                return {
                    url: result.url,
                    fileId: result.file_id || result.fileId || 'unknown',
                    size: estimatedSize,
                    originalSize: originalSize,
                    width: result.width || 360,
                    height: result.height || 459,
                    name: result.name || file.name || 'image'
                };
            } else {
                throw new Error(result.message || 'Upload failed');
            }
        } catch (error) {
            console.error('Upload error:', error);
            showNotification('Failed to upload image: ' + error.message, 'error');
            return null;
        }
    });
    
    const uploadedImages = await Promise.all(uploadPromises);
    const validImages = uploadedImages.filter(img => img !== null);
    
    if (validImages.length > 0) {
        additionalImages = [...additionalImages, ...validImages];
        updateAdditionalImagesGrid();
        updateAdditionalImagesInput();
        const totalSize = validImages.reduce((sum, img) => sum + (img.size || 0), 0);
        const sizeText = totalSize > 0 ? ` Total compressed: ${formatFileSize(totalSize)}` : ' All optimized via ImageKit!';
        showNotification(`Successfully uploaded ${validImages.length} image(s)!${sizeText}`, 'success');
    }
}

function updateAdditionalImagesGrid() {
    const grid = document.getElementById('additionalImagesGrid');
    const placeholder = document.getElementById('additionalImagesPlaceholder');
    const sortableContainer = document.getElementById('sortableImages');
    const imageCount = document.getElementById('imageCount');
    
    if (additionalImages.length === 0) {
        grid.classList.add('hidden');
        placeholder.classList.remove('hidden');
        return;
    }
    
    grid.classList.remove('hidden');
    placeholder.classList.add('hidden');
    imageCount.textContent = additionalImages.length;
    
    sortableContainer.innerHTML = additionalImages.map((image, index) => `
        <div class="image-item relative group border-2 rounded-lg overflow-hidden transition-all hover:border-blue-500 ${
            index === 0 ? 'border-blue-500 ring-2 ring-blue-200' : 'border-gray-200'
        }" data-index="${index}">
            <div class="relative">
                <img src="${image.url}" class="w-full h-32 object-cover cursor-move">
                ${index === 0 ? '<div class="absolute top-1 left-1 bg-blue-500 text-white text-xs px-2 py-1 rounded">Featured</div>' : ''}
                <div class="absolute top-1 right-1 bg-black bg-opacity-60 text-white text-xs px-1.5 py-0.5 rounded">
                    ${image.width || 360}×${image.height || 459}
                </div>
            </div>
            <div class="p-2 bg-white">
                <div class="text-xs text-gray-600 flex justify-between items-center">
                    <span>📦 ${image.size && image.size > 0 ? formatFileSize(image.size) : 'ImageKit Optimized'}</span>
                    <span class="text-green-600">🗜️ ${image.size && image.originalSize && image.originalSize > 0 ? Math.round((1 - image.size / image.originalSize) * 100) + '% saved' : 'Compressed'}</span>
                </div>
                <div class="mt-1 flex justify-between items-center">
                    <span class="text-xs text-gray-500 cursor-move">🔄 Drag to reorder</span>
                    <button type="button" onclick="removeAdditionalImage(${index})" class="text-red-500 hover:text-red-700 p-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `).join('');
    
    // Initialize or update sortable
    if (sortable) {
        sortable.destroy();
    }
    
    sortable = Sortable.create(sortableContainer, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        dragClass: 'sortable-drag',
        onEnd: function(evt) {
            // Reorder the additionalImages array
            const item = additionalImages.splice(evt.oldIndex, 1)[0];
            additionalImages.splice(evt.newIndex, 0, item);
            
            // Update the grid to reflect new order
            updateAdditionalImagesGrid();
            updateAdditionalImagesInput();
            
            showNotification('Images reordered successfully!', 'success');
        }
    });
}

function removeAdditionalImage(index) {
    additionalImages.splice(index, 1);
    updateAdditionalImagesGrid();
    updateAdditionalImagesInput();
}

function updateAdditionalImagesInput() {
    document.getElementById('additionalImagesData').value = JSON.stringify(additionalImages);
}

// Drag and drop functionality
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    document.getElementById('additionalImagesUpload').addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    document.getElementById('additionalImagesUpload').addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    document.getElementById('additionalImagesUpload').addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    e.currentTarget.classList.add('dragover');
}

function unhighlight(e) {
    e.currentTarget.classList.remove('dragover');
}

document.getElementById('additionalImagesUpload').addEventListener('drop', handleAdditionalImagesDrop, false);

function handleAdditionalImagesDrop(e) {
    const dt = e.dataTransfer;
    const files = Array.from(dt.files);
    
    if (files.length > 0) {
        // Check maximum images limit (8 total)
        if (additionalImages.length + files.length > 8) {
            showNotification(`Maximum 8 images allowed. You can upload ${8 - additionalImages.length} more.`, 'error');
            return;
        }
        uploadAdditionalImages(files);
    }
}

// Show loading for additional images
function showAdditionalImagesLoading(fileCount) {
    const placeholder = document.getElementById('additionalImagesPlaceholder');
    placeholder.innerHTML = `
        <div class="space-y-4">
            <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center animate-pulse">
                <svg class="w-8 h-8 text-blue-500 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <div class="text-center">
                <p class="text-lg font-semibold text-blue-600">Uploading ${fileCount} image(s)...</p>
                <p class="text-xs text-gray-500 mt-1">Compressing to 360×459px with ImageKit</p>
            </div>
        </div>
    `;
}

// Utility function to format file sizes
function formatFileSize(bytes) {
    // Handle null, undefined, NaN values
    if (!bytes || isNaN(bytes) || bytes <= 0) return '0 B';
    
    const k = 1024;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    // Ensure we don't exceed array bounds
    const sizeIndex = Math.min(i, sizes.length - 1);
    const formattedSize = parseFloat((bytes / Math.pow(k, sizeIndex)).toFixed(1));
    
    return formattedSize + ' ' + sizes[sizeIndex];
}
</script>
@endpush
@endsection
