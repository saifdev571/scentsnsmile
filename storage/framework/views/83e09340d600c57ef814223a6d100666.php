

<?php $__env->startSection('title', 'Banner Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="h-full bg-gray-50">
    <div class="w-full max-w-none">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Banner Management</h1>
                        <p class="mt-2 text-sm text-gray-600">Manage website banners and sliders</p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="fillDemoData()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold rounded-xl shadow-lg transform transition hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Fill Demo Data
                        </button>
                        <button onclick="openAddModal()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg transform transition hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add New Banner
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Banners</p>
                            <h3 class="text-3xl font-bold text-gray-900 mt-2"><?php echo e($totalBanners); ?></h3>
                        </div>
                        <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Active Banners</p>
                            <h3 class="text-3xl font-bold text-green-600 mt-2"><?php echo e($activeBanners); ?></h3>
                        </div>
                        <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Banners List -->
        <div class="px-8 pb-8">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200">
                <div class="p-6">
                    <div id="banners-list" class="space-y-4">
                        <?php $__empty_1 = true; $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div data-banner-id="<?php echo e($banner->id); ?>" class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border-2 border-gray-200 hover:border-blue-300 transition-all cursor-move">
                            <div class="flex-shrink-0 cursor-grab">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                                </svg>
                            </div>
                            <?php if($banner->image): ?>
                                <img src="<?php echo e($banner->image); ?>" alt="<?php echo e($banner->title); ?>" class="w-32 h-20 object-cover rounded-lg">
                            <?php else: ?>
                                <div class="w-32 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900"><?php echo e($banner->title); ?></h3>
                                <p class="text-sm text-gray-500">Order: <?php echo e($banner->order); ?></p>
                                <?php if($banner->link): ?>
                                <a href="<?php echo e($banner->link); ?>" target="_blank" class="text-xs text-blue-600 hover:underline"><?php echo e(Str::limit($banner->link, 40)); ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="flex items-center gap-3">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" <?php echo e($banner->is_active ? 'checked' : ''); ?> onchange="toggleBanner(<?php echo e($banner->id); ?>, this.checked)" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                                <button onclick="editBanner(<?php echo e($banner->id); ?>)" class="p-2 bg-yellow-100 hover:bg-yellow-200 rounded-lg text-yellow-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button onclick="deleteBanner(<?php echo e($banner->id); ?>)" class="p-2 bg-red-100 hover:bg-red-200 rounded-lg text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="mt-4 text-gray-600">No banners yet. Add your first banner!</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="bannerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="px-8 py-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 id="modalTitle" class="text-2xl font-bold text-gray-900">Add New Banner</h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        <form id="bannerForm" class="px-8 py-6 space-y-6">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="bannerId" name="banner_id">
            <input type="hidden" id="bannerImage" name="image">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Banner Image</label>
                <div id="imageUploadArea" class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-500 transition-colors cursor-pointer">
                    <input type="file" id="imageInput" accept="image/*" class="hidden">
                    <div id="uploadPlaceholder">
                        <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Click to upload or drag and drop</p>
                        <p class="text-xs text-gray-500">PNG, JPG, WebP up to 5MB</p>
                    </div>
                    <div id="imagePreview" class="hidden">
                        <img id="previewImg" src="" alt="Preview" class="max-h-48 mx-auto rounded-lg">
                        <p id="uploadProgress" class="mt-2 text-sm text-blue-600 hidden">Uploading...</p>
                    </div>
                </div>
            </div>

            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                <input type="text" id="title" name="title" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Summer Sale Banner">
            </div>

            <div>
                <label for="subtitle" class="block text-sm font-semibold text-gray-700 mb-2">Subtitle (Optional)</label>
                <input type="text" id="subtitle" name="subtitle" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="SUMMER 2024">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="button_text" class="block text-sm font-semibold text-gray-700 mb-2">Button Text</label>
                    <input type="text" id="button_text" name="button_text" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Explore Now" value="Explore Now">
                </div>
                <div>
                    <label for="button_position" class="block text-sm font-semibold text-gray-700 mb-2">Button Position</label>
                    <select id="button_position" name="button_position" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="left">Left</option>
                        <option value="center">Center</option>
                        <option value="right">Right</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="link" class="block text-sm font-semibold text-gray-700 mb-2">Link (Optional)</label>
                <input type="url" id="link" name="link" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="https://example.com/sale">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="is_active" name="is_active" checked class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">Active</label>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal()" class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800">
                    Save Banner
                </button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(100px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.2s ease-out forwards;
}

.animate-slideUp {
    animation: slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
// Initialize Sortable for drag-and-drop
const el = document.getElementById('banners-list');
if (el) {
    new Sortable(el, {
        animation: 150,
        handle: '.cursor-grab',
        onEnd: function() {
            const items = [];
            document.querySelectorAll('[data-banner-id]').forEach((el, index) => {
                items.push({
                    id: el.dataset.bannerId,
                    order: index + 1
                });
            });
            
            fetch('<?php echo e(route("admin.banners.updateOrder")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ items })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                }
            });
        }
    });
}

// Image Upload with ImageKit
document.getElementById('imageUploadArea').addEventListener('click', () => {
    document.getElementById('imageInput').click();
});

document.getElementById('imageInput').addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
        uploadToImageKit(e.target.files[0]);
    }
});

function uploadToImageKit(file) {
    const formData = new FormData();
    formData.append('image', file);
    
    document.getElementById('uploadPlaceholder').classList.add('hidden');
    document.getElementById('imagePreview').classList.remove('hidden');
    document.getElementById('uploadProgress').classList.remove('hidden');
    
    fetch('<?php echo e(route("admin.banners.uploadImage")); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('uploadProgress').classList.add('hidden');
        if (data.success) {
            document.getElementById('previewImg').src = data.url;
            document.getElementById('bannerImage').value = data.url;
            showToast('Image uploaded successfully!', 'success');
        } else {
            showToast(data.message, 'error');
            resetUploadArea();
        }
    })
    .catch(error => {
        showToast('Failed to upload image', 'error');
        resetUploadArea();
    });
}

function resetUploadArea() {
    document.getElementById('uploadPlaceholder').classList.remove('hidden');
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('bannerImage').value = '';
}

function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Add New Banner';
    document.getElementById('bannerForm').reset();
    document.getElementById('bannerId').value = '';
    document.getElementById('bannerImage').value = '';
    resetUploadArea();
    document.getElementById('bannerModal').classList.remove('hidden');
}

function editBanner(id) {
    // Fetch banner data
    fetch(`/admin/banners/${id}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.banner) {
            const banner = data.banner;
            
            // Set modal title
            document.getElementById('modalTitle').textContent = 'Edit Banner';
            document.getElementById('bannerId').value = banner.id;
            
            // Fill form fields
            document.getElementById('title').value = banner.title || '';
            document.getElementById('subtitle').value = banner.subtitle || '';
            document.getElementById('button_text').value = banner.button_text || 'Explore Now';
            document.getElementById('button_position').value = banner.button_position || 'left';
            document.getElementById('link').value = banner.link || '';
            document.getElementById('start_date').value = banner.start_date || '';
            document.getElementById('end_date').value = banner.end_date || '';
            document.getElementById('is_active').checked = banner.is_active;
            
            // Handle image preview
            if (banner.image) {
                document.getElementById('bannerImage').value = banner.image;
                document.getElementById('previewImg').src = banner.image;
                document.getElementById('uploadPlaceholder').classList.add('hidden');
                document.getElementById('imagePreview').classList.remove('hidden');
            } else {
                resetUploadArea();
            }
            
            // Show modal
            document.getElementById('bannerModal').classList.remove('hidden');
        } else {
            showToast('Failed to load banner data', 'error');
        }
    })
    .catch(error => {
        showToast('Error loading banner', 'error');
    });
}

function closeModal() {
    document.getElementById('bannerModal').classList.add('hidden');
}

// Form submission
document.getElementById('bannerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const bannerId = document.getElementById('bannerId').value;
    const formData = new FormData(this);
    const url = bannerId ? `/admin/banners/${bannerId}` : '<?php echo e(route("admin.banners.store")); ?>';
    
    if (bannerId) {
        formData.append('_method', 'PUT');
    }
    
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            closeModal();
            location.reload();
        } else {
            showToast(data.message, 'error');
        }
    });
});

function toggleBanner(id, checked) {
    fetch(`/admin/banners/${id}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ field: 'is_active', value: checked })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
        }
    });
}

function deleteBanner(id) {
    const bannerElement = document.querySelector(`[data-banner-id="${id}"]`);
    if (!bannerElement) return;
    
    const bannerTitle = bannerElement.querySelector('h3').textContent;
    const toggle = bannerElement.querySelector('input[type="checkbox"]');
    const wasActive = toggle ? toggle.checked : false;
    
    showConfirmDialog(
        'Delete Banner?',
        `Are you sure you want to delete "${bannerTitle}"? This action cannot be undone.`,
        () => {
            fetch(`/admin/banners/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    
                    // Update stats
                    updateStatsOnDelete(wasActive);
                    
                    // Animate and remove
                    bannerElement.style.transition = 'all 0.3s ease';
                    bannerElement.style.opacity = '0';
                    bannerElement.style.transform = 'translateX(-20px)';
                    setTimeout(() => bannerElement.remove(), 300);
                } else {
                    showToast(data.message || 'Failed to delete banner', 'error');
                }
            })
            .catch(error => {
                showToast('Network error occurred', 'error');
            });
        }
    );
}

function showConfirmDialog(title, message, onConfirm, confirmText = 'Delete') {
    // Create overlay
    const overlay = document.createElement('div');
    overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center animate-fadeIn';
    overlay.style.animation = 'fadeIn 0.2s ease-out';
    
    // Determine icon and colors based on action type
    const isDelete = confirmText.toLowerCase().includes('delete');
    const iconColor = isDelete ? 'text-red-600' : 'text-blue-600';
    const bgColor = isDelete ? 'from-red-100 to-pink-100' : 'from-blue-100 to-indigo-100';
    const btnColor = isDelete ? 'from-red-500 to-pink-600' : 'from-blue-500 to-indigo-600';
    const btnHoverColor = isDelete ? 'hover:from-red-600 hover:to-pink-700' : 'hover:from-blue-600 hover:to-indigo-700';
    
    // Create dialog
    const dialog = document.createElement('div');
    dialog.className = 'bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300';
    dialog.style.animation = 'slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
    dialog.innerHTML = `
        <div class="p-6">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br ${bgColor}">
                <svg class="w-8 h-8 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 text-center mb-2">${title}</h3>
            <p class="text-gray-600 text-center mb-6">${message}</p>
            <div class="flex gap-3">
                <button id="cancelBtn" class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all">
                    Cancel
                </button>
                <button id="confirmBtn" class="flex-1 px-4 py-3 bg-gradient-to-r ${btnColor} text-white font-semibold rounded-xl ${btnHoverColor} transition-all shadow-lg hover:shadow-xl">
                    ${confirmText}
                </button>
            </div>
        </div>
    `;
    
    overlay.appendChild(dialog);
    document.body.appendChild(overlay);
    
    // Handle buttons
    const cancelBtn = dialog.querySelector('#cancelBtn');
    const confirmBtn = dialog.querySelector('#confirmBtn');
    
    const closeDialog = () => {
        overlay.style.opacity = '0';
        dialog.style.transform = 'scale(0.95)';
        setTimeout(() => overlay.remove(), 200);
    };
    
    cancelBtn.addEventListener('click', closeDialog);
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeDialog();
    });
    
    confirmBtn.addEventListener('click', () => {
        closeDialog();
        onConfirm();
    });
}

function updateStatsOnDelete(wasActive) {
    // Update Total Banners
    const totalBannersEl = document.querySelector('.text-gray-900 h3');
    if (totalBannersEl) {
        const currentTotal = parseInt(totalBannersEl.textContent);
        totalBannersEl.textContent = Math.max(0, currentTotal - 1);
    }
    
    // Update Active Banners if it was active
    if (wasActive) {
        const activeBannersEl = document.querySelectorAll('.text-3xl.font-bold')[1];
        if (activeBannersEl) {
            const currentActive = parseInt(activeBannersEl.textContent);
            activeBannersEl.textContent = Math.max(0, currentActive - 1);
        }
    }
}

function fillDemoData() {
    showConfirmDialog(
        'Fill Demo Data?',
        'This will create 5 sample banners with demo images. Continue?',
        () => {
            fetch('<?php echo e(route("admin.banners.fillDemo")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(data.message || 'Failed to create demo data', 'error');
                }
            })
            .catch(error => {
                showToast('Failed to create demo data', 'error');
            });
        },
        'Continue'
    );
}

function showToast(message, type = 'success') {
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-lg shadow-lg z-50`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/admin/banners/index.blade.php ENDPATH**/ ?>