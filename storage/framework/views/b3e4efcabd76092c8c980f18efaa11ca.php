<script>
// Modal Functions
function openAddModal() {
    document.getElementById('testimonialModal').classList.remove('hidden');
    document.getElementById('testimonialModal').classList.add('flex');
    setTimeout(() => {
        document.getElementById('modalContent').classList.remove('scale-95', 'opacity-0');
        document.getElementById('modalContent').classList.add('scale-100', 'opacity-100');
    }, 10);
    
    document.getElementById('modalTitle').textContent = 'Add Testimonial';
    document.getElementById('submitBtnText').textContent = 'Create Testimonial';
    document.getElementById('testimonialForm').reset();
    document.getElementById('testimonialId').value = '';
    setRating(5); // Default 5 stars
}

function closeModal() {
    document.getElementById('modalContent').classList.remove('scale-100', 'opacity-100');
    document.getElementById('modalContent').classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        document.getElementById('testimonialModal').classList.add('hidden');
        document.getElementById('testimonialModal').classList.remove('flex');
    }, 300);
}

// Close modal on outside click
document.getElementById('testimonialModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Rating Functions
function setRating(rating) {
    document.getElementById('rating').value = rating;
    const stars = document.querySelectorAll('.star-btn svg');
    const ratingText = document.getElementById('ratingText');
    
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-400');
        } else {
            star.classList.add('text-gray-300');
            star.classList.remove('text-yellow-400');
        }
    });
    
    ratingText.textContent = `${rating} star${rating !== 1 ? 's' : ''}`;
}

// Form Submission
document.getElementById('testimonialForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const testimonialId = document.getElementById('testimonialId').value;
    const isEdit = testimonialId !== '';
    
    const formData = {
        customer_name: document.getElementById('customerName').value || null,
        review_text: document.getElementById('reviewText').value,
        rating: parseInt(document.getElementById('rating').value),
        sort_order: parseInt(document.getElementById('sortOrder').value) || 0,
        is_active: document.getElementById('isActive').checked ? 1 : 0,
    };
    
    const url = isEdit 
        ? `/admin/testimonials/${testimonialId}`
        : '/admin/testimonials';
    
    const method = isEdit ? 'PUT' : 'POST';
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (data.success) {
            showToastNotification(data.message, 'success');
            closeModal();
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showToastNotification(data.message || 'Operation failed', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToastNotification('An error occurred. Please try again.', 'error');
    }
});

// Edit Testimonial
async function editTestimonial(id) {
    try {
        const response = await fetch(`/admin/testimonials/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            const testimonial = data.testimonial;
            
            document.getElementById('testimonialId').value = testimonial.id;
            document.getElementById('customerName').value = testimonial.customer_name || '';
            document.getElementById('reviewText').value = testimonial.review_text;
            document.getElementById('sortOrder').value = testimonial.sort_order;
            document.getElementById('isActive').checked = testimonial.is_active;
            setRating(testimonial.rating);
            
            document.getElementById('modalTitle').textContent = 'Edit Testimonial';
            document.getElementById('submitBtnText').textContent = 'Update Testimonial';
            
            document.getElementById('testimonialModal').classList.remove('hidden');
            document.getElementById('testimonialModal').classList.add('flex');
            setTimeout(() => {
                document.getElementById('modalContent').classList.remove('scale-95', 'opacity-0');
                document.getElementById('modalContent').classList.add('scale-100', 'opacity-100');
            }, 10);
        }
    } catch (error) {
        console.error('Error:', error);
        showToastNotification('Failed to load testimonial', 'error');
    }
}

// Delete Testimonial
async function deleteTestimonial(id) {
    if (!confirm('Are you sure you want to delete this testimonial? This action cannot be undone.')) {
        return;
    }
    
    try {
        const response = await fetch(`/admin/testimonials/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showToastNotification(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showToastNotification(data.message || 'Failed to delete testimonial', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToastNotification('An error occurred while deleting', 'error');
    }
}

// Toggle Status
async function toggleStatus(id) {
    try {
        const response = await fetch(`/admin/testimonials/${id}/toggle`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showToastNotification(data.message, 'success');
            setTimeout(() => window.location.reload(), 500);
        } else {
            showToastNotification(data.message || 'Failed to toggle status', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToastNotification('An error occurred', 'error');
    }
}

// Bulk Actions
function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => cb.checked = checkbox.checked);
    updateBulkActionsBar();
}

function selectAll() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => cb.checked = true);
    document.getElementById('selectAllCheckbox').checked = true;
    updateBulkActionsBar();
}

function deselectAll() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => cb.checked = false);
    document.getElementById('selectAllCheckbox').checked = false;
    updateBulkActionsBar();
}

function updateBulkActionsBar() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    const bulkActionsBar = document.getElementById('bulkActionsBar');
    const selectedCount = document.getElementById('selectedCount');
    
    if (checkedBoxes.length > 0) {
        bulkActionsBar.classList.remove('hidden');
        selectedCount.textContent = `${checkedBoxes.length} selected`;
    } else {
        bulkActionsBar.classList.add('hidden');
    }
}

// Add event listeners to checkboxes
document.querySelectorAll('.row-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkActionsBar);
});

async function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    const ids = Array.from(checkedBoxes).map(cb => cb.value);
    
    if (ids.length === 0) {
        showToastNotification('Please select at least one testimonial', 'error');
        return;
    }
    
    const actionText = action === 'delete' ? 'delete' : action;
    if (!confirm(`Are you sure you want to ${actionText} ${ids.length} testimonial(s)?`)) {
        return;
    }
    
    try {
        const response = await fetch('/admin/testimonials/bulk-action', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ action, ids })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showToastNotification(data.message, 'success');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            showToastNotification(data.message || 'Bulk action failed', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToastNotification('An error occurred', 'error');
    }
}

// Export
document.getElementById('exportBtn')?.addEventListener('click', function() {
    window.location.href = '/admin/testimonials/export';
});

// Refresh
document.getElementById('refreshBtn')?.addEventListener('click', function() {
    window.location.reload();
});

// Toast Notification
function showToastNotification(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-2xl transform transition-all duration-300 translate-x-full ${
        type === 'success' 
            ? 'bg-gradient-to-r from-green-500 to-emerald-600' 
            : 'bg-gradient-to-r from-red-500 to-pink-600'
    }`;
    
    toast.innerHTML = `
        <div class="flex items-center space-x-3">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                ${type === 'success' 
                    ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>'
                    : '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>'
                }
            </svg>
            <p class="text-white font-semibold">${message}</p>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
<?php /**PATH C:\xamppp\htdocs\scentsnsmile\resources\views/admin/testimonials/scripts.blade.php ENDPATH**/ ?>