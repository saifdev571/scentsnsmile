<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slideIn {
        animation: slideIn 0.3s ease-out forwards;
    }

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

<script>
    // Helper Functions
    function showConfirmDialog(title, message, onConfirm) {
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center animate-fadeIn';
        
        const dialog = document.createElement('div');
        dialog.className = 'bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 animate-slideUp';
        dialog.innerHTML = `
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-red-100 to-pink-100">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">${title}</h3>
                <p class="text-gray-600 text-center mb-6">${message}</p>
                <div class="flex gap-3">
                    <button id="cancelBtn" class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all">
                        Cancel
                    </button>
                    <button id="confirmBtn" class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-pink-700 transition-all shadow-lg hover:shadow-xl">
                        Delete
                    </button>
                </div>
            </div>
        `;
        
        overlay.appendChild(dialog);
        document.body.appendChild(overlay);
        
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

    function showToastNotification(message, type = 'success') {
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'fixed top-4 right-4 z-50 space-y-2';
            document.body.appendChild(toastContainer);
        }

        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'from-green-500 to-emerald-600' : 'from-red-500 to-pink-600';

        toast.className = `bg-gradient-to-r ${bgColor} text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-3 transform transition-all duration-300 translate-x-full`;
        toast.innerHTML = `
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-semibold">${message}</span>
            <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        `;

        toastContainer.appendChild(toast);
        setTimeout(() => toast.classList.remove('translate-x-full'), 100);
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // DOMContentLoaded Event
    document.addEventListener('DOMContentLoaded', function() {
        // Delete buttons with confirmation dialog
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const momentId = this.dataset.id;
                const momentName = this.dataset.name;
                const deleteBtn = this;

                showConfirmDialog(
                    'Delete Moment?',
                    `Are you sure you want to delete "${momentName}"? This action cannot be undone.`,
                    () => {
                        deleteBtn.disabled = true;
                        deleteBtn.innerHTML = '<svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

                        fetch('/admin/moments/' + momentId, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                showToastNotification('Moment deleted successfully!', 'success');
                                const row = deleteBtn.closest('tr');
                                row.style.transition = 'all 0.3s ease';
                                row.style.opacity = '0';
                                row.style.transform = 'translateX(-20px)';
                                setTimeout(() => row.remove(), 300);
                            } else {
                                showToastNotification(data.message || 'Failed to delete moment', 'error');
                                deleteBtn.disabled = false;
                                deleteBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>';
                            }
                        })
                        .catch(error => {
                            showToastNotification('Network error occurred', 'error');
                            deleteBtn.disabled = false;
                            deleteBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>';
                        });
                    }
                );
            });
        });

        // Toggle switches for all fields
        document.querySelectorAll('.feature-toggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const momentId = this.dataset.id;
                const field = this.dataset.field;
                const value = this.checked ? 1 : 0;

                fetch('/admin/moments/' + momentId + '/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ field, value })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToastNotification(data.message, 'success');
                    } else {
                        this.checked = !this.checked;
                        showToastNotification(data.message, 'error');
                    }
                })
                .catch(() => {
                    this.checked = !this.checked;
                    showToastNotification('Network error occurred', 'error');
                });
            });
        });

        // Refresh button
        const refreshBtn = document.getElementById('refreshBtn');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', () => location.reload());
        }

        // Export button
        const exportBtn = document.getElementById('exportBtn');
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                window.open('/admin/moments/export', '_blank');
                showToastNotification('Export started', 'success');
            });
        }

        // Select All checkbox
        const selectAllCheckbox = document.getElementById('selectAll');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                document.querySelectorAll('.row-select').forEach(cb => cb.checked = this.checked);
                updateBulkButton();
            });
        }

        // Individual row checkboxes
        document.querySelectorAll('.row-select').forEach(cb => {
            cb.addEventListener('change', updateBulkButton);
        });

        // Bulk action button
        const applyBulkActionBtn = document.getElementById('applyBulkAction');
        if (applyBulkActionBtn) {
            applyBulkActionBtn.addEventListener('click', function() {
                const action = document.getElementById('bulkAction')?.value;
                const selected = Array.from(document.querySelectorAll('.row-select:checked')).map(cb => cb.value);

                if (!action || selected.length === 0) {
                    showToastNotification('Select action and items', 'error');
                    return;
                }

                if (action === 'delete') {
                    showConfirmDialog(
                        'Delete Multiple Moments?',
                        `Are you sure you want to delete ${selected.length} selected moment${selected.length > 1 ? 's' : ''}? This action cannot be undone.`,
                        () => {
                            performBulkAction(action, selected);
                        }
                    );
                    return;
                }

                performBulkAction(action, selected);
            });
        }

        function performBulkAction(action, selected) {
            fetch('/admin/moments/bulk-action', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ action, ids: selected })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToastNotification(data.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToastNotification(data.message, 'error');
                }
            })
            .catch(() => showToastNotification('Error occurred', 'error'));
        }

        function updateBulkButton() {
            const selected = document.querySelectorAll('.row-select:checked').length;
            const btn = document.getElementById('applyBulkAction');
            const count = document.getElementById('selectedCount');

            if (btn) {
                btn.disabled = selected === 0;
                btn.textContent = selected > 0 ? `Apply (${selected})` : 'Apply';
            }

            if (count) count.textContent = selected;
        }

        // Image Upload with Progress Bar
        function removeImage() {
            document.getElementById('imageInput').value = '';
            document.getElementById('imagekitFileId').value = '';
            document.getElementById('imagekitUrl').value = '';
            document.getElementById('imagekitThumbnailUrl').value = '';
            document.getElementById('imagekitFilePath').value = '';
            
            document.getElementById('uploadArea').classList.remove('hidden');
            document.getElementById('imagePreview').classList.add('hidden');
            document.getElementById('uploadProgress').classList.add('hidden');
        }

        // Image upload handler with live progress bar
        document.getElementById('imageInput')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Validate file type
            if (!file.type.match('image.*')) {
                showToastNotification('Please select an image file', 'error');
                return;
            }

            // Validate file size (10MB)
            if (file.size > 10 * 1024 * 1024) {
                showToastNotification('Image size must be less than 10MB', 'error');
                return;
            }

            // Show progress
            document.getElementById('uploadArea').classList.add('hidden');
            document.getElementById('uploadProgress').classList.remove('hidden');

            // Upload to ImageKit
            const formData = new FormData();
            formData.append('image', file);
            formData.append('folder', 'moments');

            const xhr = new XMLHttpRequest();

            // Progress tracking
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = Math.round((e.loaded / e.total) * 100);
                    document.getElementById('progressBar').style.width = percentComplete + '%';
                    document.getElementById('progressText').textContent = `Uploading... ${percentComplete}%`;
                }
            });

            xhr.addEventListener('load', function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        
                        if (response.success) {
                            // Store ImageKit data
                            document.getElementById('imagekitFileId').value = response.file_id;
                            document.getElementById('imagekitUrl').value = response.url;
                            document.getElementById('imagekitThumbnailUrl').value = response.thumbnail_url;
                            document.getElementById('imagekitFilePath').value = response.file_path;

                            // Show preview
                            document.getElementById('previewImg').src = response.url;
                            document.getElementById('uploadProgress').classList.add('hidden');
                            document.getElementById('imagePreview').classList.remove('hidden');

                            showToastNotification('Image uploaded successfully!', 'success');
                        } else {
                            throw new Error(response.message || 'Upload failed');
                        }
                    } catch (error) {
                        console.error('Upload error:', error);
                        showToastNotification('Failed to upload image', 'error');
                        removeImage();
                    }
                } else {
                    showToastNotification('Upload failed. Please try again.', 'error');
                    removeImage();
                }
            });

            xhr.addEventListener('error', function() {
                showToastNotification('Network error occurred', 'error');
                removeImage();
            });

            xhr.open('POST', '/admin/moments/upload-image');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
            xhr.send(formData);
        });

        // Make removeImage globally accessible
        window.removeImage = removeImage;
    });
</script>
<?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/admin/moments/scripts.blade.php ENDPATH**/ ?>