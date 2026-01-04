<script>
var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Free shipping toggle
document.getElementById('promoFreeShipping').addEventListener('change', function() {
    document.getElementById('freeShippingOptions').classList.toggle('hidden', !this.checked);
});

function openModal() {
    document.getElementById('modalTitle').textContent = 'Add Promotion';
    document.getElementById('promotionForm').reset();
    document.getElementById('promotionId').value = '';
    document.getElementById('promoBadgeColor').value = '#ef4444';
    document.getElementById('freeShippingOptions').classList.add('hidden');
    document.getElementById('promotionModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('promotionModal').classList.add('hidden');
}

function editPromotion(id) {
    document.getElementById('modalTitle').textContent = 'Edit Promotion';
    
    fetch('/admin/promotions/' + id + '/edit')
        .then(function(response) { return response.text(); })
        .then(function(html) {
            // Parse the HTML to get promotion data
            var parser = new DOMParser();
            var doc = parser.parseFromString(html, 'text/html');
            var dataEl = doc.getElementById('promotionData');
            
            if (dataEl) {
                var promotion = JSON.parse(dataEl.textContent);
                fillForm(promotion);
            }
        });
    
    document.getElementById('promotionModal').classList.remove('hidden');
}

function fillForm(p) {
    document.getElementById('promotionId').value = p.id;
    document.getElementById('promoName').value = p.name || '';
    document.getElementById('promoDescription').value = p.description || '';
    document.getElementById('promoDiscountType').value = p.discount_type || 'percentage';
    document.getElementById('promoDiscountValue').value = p.discount_value || '';
    document.getElementById('promoMinItems').value = p.min_items || 1;
    document.getElementById('promoFreeShipping').checked = p.free_shipping;
    document.getElementById('promoFreeShippingMinItems').value = p.free_shipping_min_items || 3;
    document.getElementById('promoBadgeText').value = p.badge_text || '';
    document.getElementById('promoBadgeColor').value = p.badge_color || '#ef4444';
    document.getElementById('promoBannerTitle').value = p.banner_title || '';
    document.getElementById('promoCartLabel').value = p.cart_label || '';
    document.getElementById('promoStartsAt').value = p.starts_at ? p.starts_at.slice(0, 16) : '';
    document.getElementById('promoEndsAt').value = p.ends_at ? p.ends_at.slice(0, 16) : '';
    document.getElementById('promoIsActive').checked = p.is_active;
    document.getElementById('promoShowHeader').checked = p.show_in_header;
    document.getElementById('promoShowCart').checked = p.show_in_cart;
    
    document.getElementById('freeShippingOptions').classList.toggle('hidden', !p.free_shipping);
}

function savePromotion() {
    var id = document.getElementById('promotionId').value;
    var url = id ? '/admin/promotions/' + id : '/admin/promotions';
    var method = id ? 'PUT' : 'POST';
    
    var formData = {
        name: document.getElementById('promoName').value,
        description: document.getElementById('promoDescription').value,
        discount_type: document.getElementById('promoDiscountType').value,
        discount_value: document.getElementById('promoDiscountValue').value,
        min_items: document.getElementById('promoMinItems').value,
        free_shipping: document.getElementById('promoFreeShipping').checked ? 1 : 0,
        free_shipping_min_items: document.getElementById('promoFreeShippingMinItems').value,
        badge_text: document.getElementById('promoBadgeText').value,
        badge_color: document.getElementById('promoBadgeColor').value,
        banner_title: document.getElementById('promoBannerTitle').value,
        cart_label: document.getElementById('promoCartLabel').value,
        starts_at: document.getElementById('promoStartsAt').value || null,
        ends_at: document.getElementById('promoEndsAt').value || null,
        is_active: document.getElementById('promoIsActive').checked ? 1 : 0,
        show_in_header: document.getElementById('promoShowHeader').checked ? 1 : 0,
        show_in_cart: document.getElementById('promoShowCart').checked ? 1 : 0
    };
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(formData)
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Error saving promotion');
        }
    })
    .catch(function(error) {
        console.error('Error:', error);
        alert('Error saving promotion');
    });
}

function togglePromotion(id) {
    fetch('/admin/promotions/' + id + '/toggle', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.success) {
            var toggle = document.getElementById('toggle-' + id);
            var dot = document.getElementById('toggle-dot-' + id);
            
            if (data.is_active) {
                toggle.classList.remove('bg-gray-300');
                toggle.classList.add('bg-green-500');
                dot.classList.remove('translate-x-1');
                dot.classList.add('translate-x-6');
            } else {
                toggle.classList.remove('bg-green-500');
                toggle.classList.add('bg-gray-300');
                dot.classList.remove('translate-x-6');
                dot.classList.add('translate-x-1');
            }
        }
    });
}

function deletePromotion(id) {
    if (!confirm('Are you sure you want to delete this promotion?')) return;
    
    fetch('/admin/promotions/' + id, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Error deleting promotion');
        }
    });
}
</script>
<?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/admin/promotions/scripts.blade.php ENDPATH**/ ?>