<script>
    function openModal() {
        document.getElementById('highlightNoteModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('highlightNoteModal').classList.add('hidden');
        const submitBtn = document.getElementById('submitBtn');
        const spinner = document.getElementById('loadingSpinner');
        if (submitBtn) submitBtn.disabled = false;
        if (spinner) spinner.classList.add('hidden');
    }

    function resetForm() {
        document.getElementById('modalTitle').textContent = 'Add New Highlight Note';
        document.getElementById('submitBtnText').textContent = 'Create';
        document.getElementById('highlightNoteForm').action = '{{ route('admin.highlight-notes.store') }}';
        document.getElementById('methodField').value = 'POST';
        document.getElementById('highlightNoteId').value = '';
        document.getElementById('highlightNoteForm').reset();
        removeImage();
    }

    function openAddModal() {
        resetForm();
        openModal();
    }

    function openEditModal(data) {
        document.getElementById('modalTitle').textContent = 'Edit Highlight Note';
        document.getElementById('submitBtnText').textContent = 'Update';
        document.getElementById('highlightNoteForm').action = '/admin/highlight-notes/' + data.id;
        document.getElementById('methodField').value = 'PATCH';
        document.getElementById('highlightNoteId').value = data.id;
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
        `;
        toastContainer.appendChild(toast);
        setTimeout(() => toast.classList.remove('translate-x-full'), 100);
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    function showConfirmDialog(title, message, onConfirm) {
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
        const dialog = document.createElement('div');
        dialog.className = 'bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4';
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
                    <button id="cancelBtn" class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all">Cancel</button>
                    <button id="confirmBtn" class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-pink-700 transition-all shadow-lg">Delete</button>
                </div>
            </div>
        `;
        overlay.appendChild(dialog);
        document.body.appendChild(overlay);
        
        const closeDialog = () => overlay.remove();
        dialog.querySelector('#cancelBtn').addEventListener('click', closeDialog);
        overlay.addEventListener('click', (e) => { if (e.target === overlay) closeDialog(); });
        dialog.querySelector('#confirmBtn').addEventListener('click', () => { closeDialog(); onConfirm(); });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('closeModalBtn')?.addEventListener('click', closeModal);
        document.getElementById('cancelModalBtn')?.addEventListener('click', closeModal);
        document.getElementById('modalOverlay')?.addEventListener('click', closeModal);
        document.getElementById('removeImageBtn')?.addEventListener('click', removeImage);
        document.getElementById('refreshBtn')?.addEventListener('click', () => location.reload());

        // Image upload
        const uploadArea = document.getElementById('uploadArea');
        const imageInput = document.getElementById('imageInput');
        
        uploadArea?.addEventListener('click', () => imageInput?.click());
        uploadArea?.addEventListener('dragover', (e) => { e.preventDefault(); uploadArea.classList.add('border-amber-400', 'bg-amber-50'); });
        uploadArea?.addEventListener('dragleave', () => uploadArea.classList.remove('border-amber-400', 'bg-amber-50'));
        uploadArea?.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('border-amber-400', 'bg-amber-50');
            if (e.dataTransfer.files.length) {
                imageInput.files = e.dataTransfer.files;
                uploadImage(e.dataTransfer.files[0]);
            }
        });
        
        imageInput?.addEventListener('change', function() {
            if (this.files.length) uploadImage(this.files[0]);
        });

        function uploadImage(file) {
            const formData = new FormData();
            formData.append('image', file);
            
            document.getElementById('uploadProgress').classList.remove('hidden');
            document.getElementById('progressBar').style.width = '0%';

            fetch('{{ route('admin.highlight-notes.upload-image') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
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
            .catch(() => {
                document.getElementById('uploadProgress').classList.add('hidden');
                showToastNotification('Upload failed', 'error');
            });
        }

        // Edit buttons
        document.querySelectorAll('.edit-btn').forEach(btn => {
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
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const deleteBtn = this;

                showConfirmDialog('Delete Highlight Note?', `Are you sure you want to delete "${name}"?`, () => {
                    deleteBtn.disabled = true;
                    fetch('/admin/highlight-notes/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showToastNotification('Deleted successfully!', 'success');
                            const row = deleteBtn.closest('tr');
                            row.style.opacity = '0';
                            setTimeout(() => row.remove(), 300);
                        } else {
                            showToastNotification(data.message || 'Failed to delete', 'error');
                            deleteBtn.disabled = false;
                        }
                    })
                    .catch(() => {
                        showToastNotification('Network error', 'error');
                        deleteBtn.disabled = false;
                    });
                });
            });
        });

        // Toggle status
        document.querySelectorAll('.status-toggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const id = this.dataset.id;
                const field = this.dataset.field;
                const value = this.checked ? 1 : 0;

                fetch('/admin/highlight-notes/' + id + '/toggle', {
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
                    showToastNotification('Network error', 'error');
                });
            });
        });

        // Form submission
        document.getElementById('highlightNoteForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = document.getElementById('submitBtn');
            const spinner = document.getElementById('loadingSpinner');
            const formData = new FormData(this);

            submitBtn.disabled = true;
            spinner?.classList.remove('hidden');

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToastNotification(data.message, 'success');
                    closeModal();
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToastNotification(data.message || 'Failed to save', 'error');
                    submitBtn.disabled = false;
                    spinner?.classList.add('hidden');
                }
            })
            .catch(() => {
                showToastNotification('Network error', 'error');
                submitBtn.disabled = false;
                spinner?.classList.add('hidden');
            });
        });

        // Export
        document.getElementById('exportBtn')?.addEventListener('click', function() {
            window.open('/admin/highlight-notes/export', '_blank');
            showToastNotification('Export started', 'success');
        });

        // Bulk actions
        document.getElementById('selectAll')?.addEventListener('change', function() {
            document.querySelectorAll('.row-select').forEach(cb => cb.checked = this.checked);
            updateBulkButton();
        });

        document.querySelectorAll('.row-select').forEach(cb => {
            cb.addEventListener('change', updateBulkButton);
        });

        document.getElementById('applyBulkAction')?.addEventListener('click', function() {
            const action = document.getElementById('bulkAction')?.value;
            const selected = Array.from(document.querySelectorAll('.row-select:checked')).map(cb => cb.value);

            if (!action || selected.length === 0) {
                showToastNotification('Select action and items', 'error');
                return;
            }

            if (action === 'delete') {
                showConfirmDialog('Delete Multiple?', `Delete ${selected.length} selected item(s)?`, () => performBulkAction(action, selected));
                return;
            }
            performBulkAction(action, selected);
        });

        function performBulkAction(action, selected) {
            fetch('/admin/highlight-notes/bulk-action', {
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
                    setTimeout(() => location.reload(), 1000);
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
    });
</script>
