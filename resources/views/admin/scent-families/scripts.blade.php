<script>
    function openModal() {
        document.getElementById('scentFamilyModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('scentFamilyModal').classList.add('hidden');
        var submitBtn = document.getElementById('submitBtn');
        var spinner = document.getElementById('loadingSpinner');
        if (submitBtn) submitBtn.disabled = false;
        if (spinner) spinner.classList.add('hidden');
    }

    function resetForm() {
        document.getElementById('modalTitle').textContent = 'Add New Scent Family';
        document.getElementById('submitBtnText').textContent = 'Create';
        document.getElementById('scentFamilyForm').action = '{{ route('admin.scent-families.store') }}';
        document.getElementById('methodField').value = 'POST';
        document.getElementById('scentFamilyId').value = '';
        document.getElementById('scentFamilyForm').reset();
        removeImage();
    }

    function openAddModal() {
        resetForm();
        openModal();
    }

    function openEditModal(data) {
        document.getElementById('modalTitle').textContent = 'Edit Scent Family';
        document.getElementById('submitBtnText').textContent = 'Update';
        document.getElementById('scentFamilyForm').action = '/admin/scent-families/' + data.id;
        document.getElementById('methodField').value = 'PATCH';
        document.getElementById('scentFamilyId').value = data.id;
        document.getElementById('name').value = data.name;
        document.querySelector('input[name="is_active"]').checked = data.isActive;

        if (data.imageUrl && data.imagekitFileId) {
            document.getElementById('imagekitFileId').value = data.imagekitFileId || '';
            document.getElementById('imagekitUrl').value = data.imagekitUrl || '';
            document.getElementById('imagekitThumbnailUrl').value = data.imagekitThumbnailUrl || '';
            document.getElementById('imagekitFilePath').value = data.imagekitFilePath || '';
            document.getElementById('previewImg').src = data.imageUrl;
            document.getElementById('uploadArea').classList.add('hidden');
            document.getElementById('imagePreview').classList.remove('hidden');
        } else {
            removeImage();
        }
        openModal();
    }

    function removeImage() {
        document.getElementById('imagekitFileId').value = '';
        document.getElementById('imagekitUrl').value = '';
        document.getElementById('imagekitThumbnailUrl').value = '';
        document.getElementById('imagekitFilePath').value = '';
        document.getElementById('imageSize').value = '';
        document.getElementById('originalImageSize').value = '';
        document.getElementById('imageWidth').value = '';
        document.getElementById('imageHeight').value = '';
        document.getElementById('previewImg').src = '';
        document.getElementById('uploadArea').classList.remove('hidden');
        document.getElementById('imagePreview').classList.add('hidden');
        document.getElementById('imageInput').value = '';
    }

    function showToastNotification(message, type) {
        type = type || 'success';
        var toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'fixed top-4 right-4 z-50 space-y-2';
            document.body.appendChild(toastContainer);
        }

        var toast = document.createElement('div');
        var bgColor = type === 'success' ? 'from-green-500 to-emerald-600' : 'from-red-500 to-pink-600';
        toast.className = 'bg-gradient-to-r ' + bgColor + ' text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-3 transform transition-all duration-300 translate-x-full';
        toast.innerHTML = '<svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span class="font-semibold">' + message + '</span>';
        toastContainer.appendChild(toast);
        setTimeout(function() { toast.classList.remove('translate-x-full'); }, 100);
        setTimeout(function() {
            toast.classList.add('translate-x-full');
            setTimeout(function() { toast.remove(); }, 300);
        }, 3000);
    }

    function showConfirmDialog(title, message, onConfirm) {
        var overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
        var dialog = document.createElement('div');
        dialog.className = 'bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4';
        dialog.innerHTML = '<div class="p-6"><div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-red-100 to-pink-100"><svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></div><h3 class="text-xl font-bold text-gray-900 text-center mb-2">' + title + '</h3><p class="text-gray-600 text-center mb-6">' + message + '</p><div class="flex gap-3"><button id="cancelBtn" class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all">Cancel</button><button id="confirmBtn" class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-pink-700 transition-all shadow-lg">Delete</button></div></div>';
        overlay.appendChild(dialog);
        document.body.appendChild(overlay);
        
        var closeDialog = function() { overlay.remove(); };
        dialog.querySelector('#cancelBtn').addEventListener('click', closeDialog);
        overlay.addEventListener('click', function(e) { if (e.target === overlay) closeDialog(); });
        dialog.querySelector('#confirmBtn').addEventListener('click', function() { closeDialog(); onConfirm(); });
    }

    document.addEventListener('DOMContentLoaded', function() {
        var closeModalBtn = document.getElementById('closeModalBtn');
        var cancelModalBtn = document.getElementById('cancelModalBtn');
        var modalOverlay = document.getElementById('modalOverlay');
        var removeImageBtn = document.getElementById('removeImageBtn');
        var refreshBtn = document.getElementById('refreshBtn');

        if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
        if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);
        if (modalOverlay) modalOverlay.addEventListener('click', closeModal);
        if (removeImageBtn) removeImageBtn.addEventListener('click', removeImage);
        if (refreshBtn) refreshBtn.addEventListener('click', function() { location.reload(); });

        // Image upload
        var uploadArea = document.getElementById('uploadArea');
        var imageInput = document.getElementById('imageInput');
        
        if (uploadArea) {
            uploadArea.addEventListener('click', function() { if (imageInput) imageInput.click(); });
            uploadArea.addEventListener('dragover', function(e) { e.preventDefault(); uploadArea.classList.add('border-purple-400', 'bg-purple-50'); });
            uploadArea.addEventListener('dragleave', function() { uploadArea.classList.remove('border-purple-400', 'bg-purple-50'); });
            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-purple-400', 'bg-purple-50');
                if (e.dataTransfer.files.length) {
                    imageInput.files = e.dataTransfer.files;
                    uploadImage(e.dataTransfer.files[0]);
                }
            });
        }
        
        if (imageInput) {
            imageInput.addEventListener('change', function() {
                if (this.files.length) uploadImage(this.files[0]);
            });
        }

        function uploadImage(file) {
            var formData = new FormData();
            formData.append('image', file);
            
            document.getElementById('uploadProgress').classList.remove('hidden');
            document.getElementById('progressBar').style.width = '0%';

            fetch('{{ route('admin.scent-families.upload-image') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                document.getElementById('uploadProgress').classList.add('hidden');
                if (data.success) {
                    document.getElementById('imagekitFileId').value = data.file_id;
                    document.getElementById('imagekitUrl').value = data.url;
                    document.getElementById('imagekitThumbnailUrl').value = data.thumbnail_url;
                    document.getElementById('imagekitFilePath').value = data.file_path;
                    document.getElementById('imageSize').value = data.size;
                    document.getElementById('originalImageSize').value = data.original_size;
                    document.getElementById('imageWidth').value = data.width;
                    document.getElementById('imageHeight').value = data.height;
                    document.getElementById('previewImg').src = data.url;
                    document.getElementById('uploadArea').classList.add('hidden');
                    document.getElementById('imagePreview').classList.remove('hidden');
                    showToastNotification('Image uploaded successfully!', 'success');
                } else {
                    showToastNotification(data.message || 'Upload failed', 'error');
                }
            })
            .catch(function() {
                document.getElementById('uploadProgress').classList.add('hidden');
                showToastNotification('Upload failed', 'error');
            });
        }

        // Edit buttons
        document.querySelectorAll('.edit-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                openEditModal({
                    id: this.dataset.id,
                    name: this.dataset.name,
                    isActive: this.dataset.isActive === 'true',
                    imageUrl: this.dataset.imageUrl,
                    imagekitFileId: this.dataset.imagekitFileId,
                    imagekitUrl: this.dataset.imagekitUrl,
                    imagekitThumbnailUrl: this.dataset.imagekitThumbnailUrl,
                    imagekitFilePath: this.dataset.imagekitFilePath
                });
            });
        });

        // Delete buttons
        document.querySelectorAll('.delete-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = this.dataset.id;
                var name = this.dataset.name;
                var deleteBtn = this;

                showConfirmDialog('Delete Scent Family?', 'Are you sure you want to delete "' + name + '"?', function() {
                    deleteBtn.disabled = true;
                    fetch('/admin/scent-families/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(function(res) { return res.json(); })
                    .then(function(data) {
                        if (data.success) {
                            showToastNotification('Deleted successfully!', 'success');
                            var row = deleteBtn.closest('tr');
                            row.style.opacity = '0';
                            setTimeout(function() { row.remove(); }, 300);
                        } else {
                            showToastNotification(data.message || 'Failed to delete', 'error');
                            deleteBtn.disabled = false;
                        }
                    })
                    .catch(function() {
                        showToastNotification('Network error', 'error');
                        deleteBtn.disabled = false;
                    });
                });
            });
        });

        // Toggle status
        document.querySelectorAll('.status-toggle').forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                var id = this.dataset.id;
                var field = this.dataset.field;
                var value = this.checked ? 1 : 0;
                var toggleEl = this;

                fetch('/admin/scent-families/' + id + '/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ field: field, value: value })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.success) {
                        showToastNotification(data.message, 'success');
                    } else {
                        toggleEl.checked = !toggleEl.checked;
                        showToastNotification(data.message, 'error');
                    }
                })
                .catch(function() {
                    toggleEl.checked = !toggleEl.checked;
                    showToastNotification('Network error', 'error');
                });
            });
        });

        // Form submission
        var scentFamilyForm = document.getElementById('scentFamilyForm');
        if (scentFamilyForm) {
            scentFamilyForm.addEventListener('submit', function(e) {
                e.preventDefault();
                var submitBtn = document.getElementById('submitBtn');
                var spinner = document.getElementById('loadingSpinner');
                var formData = new FormData(this);

                submitBtn.disabled = true;
                if (spinner) spinner.classList.remove('hidden');

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.success) {
                        showToastNotification(data.message, 'success');
                        closeModal();
                        setTimeout(function() { location.reload(); }, 1000);
                    } else {
                        showToastNotification(data.message || 'Failed to save', 'error');
                        submitBtn.disabled = false;
                        if (spinner) spinner.classList.add('hidden');
                    }
                })
                .catch(function() {
                    showToastNotification('Network error', 'error');
                    submitBtn.disabled = false;
                    if (spinner) spinner.classList.add('hidden');
                });
            });
        }

        // Export
        var exportBtn = document.getElementById('exportBtn');
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                window.open('/admin/scent-families/export', '_blank');
                showToastNotification('Export started', 'success');
            });
        }

        // Bulk actions
        var selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.row-select').forEach(function(cb) { cb.checked = selectAll.checked; });
                updateBulkButton();
            });
        }

        document.querySelectorAll('.row-select').forEach(function(cb) {
            cb.addEventListener('change', updateBulkButton);
        });

        var applyBulkAction = document.getElementById('applyBulkAction');
        if (applyBulkAction) {
            applyBulkAction.addEventListener('click', function() {
                var bulkActionSelect = document.getElementById('bulkAction');
                var action = bulkActionSelect ? bulkActionSelect.value : '';
                var selected = [];
                document.querySelectorAll('.row-select:checked').forEach(function(cb) { selected.push(cb.value); });

                if (!action || selected.length === 0) {
                    showToastNotification('Select action and items', 'error');
                    return;
                }

                if (action === 'delete') {
                    showConfirmDialog('Delete Multiple?', 'Delete ' + selected.length + ' selected item(s)?', function() { performBulkAction(action, selected); });
                    return;
                }
                performBulkAction(action, selected);
            });
        }

        function performBulkAction(action, selected) {
            fetch('/admin/scent-families/bulk-action', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ action: action, ids: selected })
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.success) {
                    showToastNotification(data.message, 'success');
                    setTimeout(function() { location.reload(); }, 1000);
                } else {
                    showToastNotification(data.message, 'error');
                }
            })
            .catch(function() { showToastNotification('Error occurred', 'error'); });
        }

        function updateBulkButton() {
            var selected = document.querySelectorAll('.row-select:checked').length;
            var btn = document.getElementById('applyBulkAction');
            var count = document.getElementById('selectedCount');
            if (btn) {
                btn.disabled = selected === 0;
                btn.textContent = selected > 0 ? 'Apply (' + selected + ')' : 'Apply';
            }
            if (count) count.textContent = selected;
        }
    });
</script>
