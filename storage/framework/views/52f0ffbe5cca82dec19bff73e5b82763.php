<script>
    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Search Modal Toggle with Animation
    const searchBtn = document.getElementById('searchBtn');
    const searchModal = document.getElementById('searchModal');
    const searchCloseBtn = document.getElementById('searchCloseBtn');
    const searchInput = document.getElementById('searchInput');
    
    function openSearch() {
        searchModal.classList.remove('hidden', 'closing');
        setTimeout(() => searchInput.focus(), 150);
    }
    
    function closeSearch() {
        searchModal.classList.add('closing');
        setTimeout(() => {
            searchModal.classList.add('hidden');
            searchModal.classList.remove('closing');
        }, 300);
    }
    
    if (searchBtn && searchModal) {
        searchBtn.addEventListener('click', openSearch);
    }
    
    if (searchCloseBtn && searchModal) {
        searchCloseBtn.addEventListener('click', closeSearch);
    }

    // Close search on backdrop click
    if (searchModal) {
        searchModal.addEventListener('click', (e) => {
            if (e.target === searchModal) {
                closeSearch();
            }
        });
    }

    // Close search on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && searchModal && !searchModal.classList.contains('hidden')) {
            closeSearch();
        }
    });

    // Search Form Submit
    var searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            var searchInputVal = document.getElementById('searchInput');
            if (searchInputVal && searchInputVal.value.trim() === '') {
                e.preventDefault();
                searchInputVal.focus();
            }
        });
    }

    // Search Gender Button Click
    document.querySelectorAll('.search-gender-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var genderId = this.dataset.genderId;
            var searchInputVal = document.getElementById('searchInput');
            var genderInput = document.getElementById('searchGenderInput');
            
            // Toggle selection
            document.querySelectorAll('.search-gender-btn').forEach(function(b) {
                b.classList.remove('bg-black', 'text-white');
                b.classList.add('bg-gray-100', 'text-gray-800');
            });
            this.classList.remove('bg-gray-100', 'text-gray-800');
            this.classList.add('bg-black', 'text-white');
            
            // Set gender value
            if (genderInput) {
                genderInput.value = genderId;
            }
            
            // If search input has value, submit form
            if (searchInputVal && searchInputVal.value.trim() !== '') {
                document.getElementById('searchForm').submit();
            }
        });
    });

    // Search Input Enter Key
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('searchForm').submit();
            }
        });
    }

    // Banner Slider - Only on Home Page
    if (document.querySelectorAll('.slide').length > 0) {
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        let autoSlideInterval;

        function showSlide(index) {
            // Guard check
            if (!slides[index]) return;

            // Remove active class from all slides
            slides.forEach(slide => {
                slide.classList.remove('active');
                slide.classList.add('opacity-0');
            });

            // Add active class to current slide
            slides[index].classList.add('active');
            slides[index].classList.remove('opacity-0');
            
            // Remove active state from all dots and highlight current (only if dots exist)
            if (dots.length > 0 && dots[index]) {
                dots.forEach(dot => {
                    dot.classList.remove('opacity-100');
                    dot.classList.add('opacity-50');
                });
                dots[index].classList.remove('opacity-50');
                dots[index].classList.add('opacity-100');
            }
        }

        window.changeSlide = function(direction) {
            currentSlide += direction;
            
            if (currentSlide >= slides.length) {
                currentSlide = 0;
            } else if (currentSlide < 0) {
                currentSlide = slides.length - 1;
            }
            
            showSlide(currentSlide);
            resetAutoSlide();
        }

        window.goToSlide = function(index) {
            currentSlide = index;
            showSlide(currentSlide);
            resetAutoSlide();
        }

        function autoSlide() {
            currentSlide++;
            if (currentSlide >= slides.length) {
                currentSlide = 0;
            }
            showSlide(currentSlide);
        }

        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(autoSlide, 5000);
        }

        // Initialize slider
        showSlide(0);
        autoSlideInterval = setInterval(autoSlide, 5000); // Auto slide every 5 seconds
    }

    // Testimonials Slider - Only on Home Page
    const testimonialsTrack = document.getElementById('testimonialsTrack');
    if (testimonialsTrack) {
        let testimonialPosition = 0;
        const cardWidth = 320 + 24; // card width + gap

        window.slideTestimonials = function(direction) {
            const maxScroll = testimonialsTrack.scrollWidth - testimonialsTrack.parentElement.offsetWidth;
            
            if (direction === 'next') {
                testimonialPosition = Math.min(testimonialPosition + cardWidth, maxScroll);
            } else {
                testimonialPosition = Math.max(testimonialPosition - cardWidth, 0);
            }
            
            testimonialsTrack.style.transform = `translateX(-${testimonialPosition}px)`;
        }

        // Auto-slide testimonials
        setInterval(() => {
            const maxScroll = testimonialsTrack.scrollWidth - testimonialsTrack.parentElement.offsetWidth;
            if (testimonialPosition >= maxScroll) {
                testimonialPosition = 0;
            } else {
                testimonialPosition += cardWidth;
            }
            testimonialsTrack.style.transform = `translateX(-${testimonialPosition}px)`;
        }, 4000);
    }

    // Tab Switching Function
    function switchTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active state from all buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('text-gray-900', 'font-bold', 'border-gray-900');
            btn.classList.add('text-gray-400', 'border-transparent');
        });
        
        // Show selected tab content
        document.getElementById(tabName + 'Tab').classList.remove('hidden');
        
        // Add active state to selected button
        const activeBtn = document.getElementById(tabName + 'TabBtn');
        activeBtn.classList.remove('text-gray-400', 'border-transparent');
        activeBtn.classList.add('text-gray-900', 'font-bold', 'border-gray-900');
    }

    // Cart Sidebar Functions
    const cartBtn = document.getElementById('cartBtn');
    const cartSidebar = document.getElementById('cartSidebar');
    const cartPanel = document.getElementById('cartPanel');

    // Make cart functions globally accessible
    window.openCart = function() {
        if (!cartSidebar || !cartPanel) return;
        cartSidebar.classList.remove('hidden');
        setTimeout(() => {
            cartPanel.classList.remove('translate-x-full');
        }, 10);
        document.body.style.overflow = 'hidden';
        loadCart();
    }

    window.closeCart = function() {
        if (!cartSidebar || !cartPanel) return;
        cartPanel.classList.add('translate-x-full');
        setTimeout(() => {
            cartSidebar.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }

    if (cartBtn) {
        cartBtn.addEventListener('click', openCart);
    }

    // Close cart on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && cartSidebar && !cartSidebar.classList.contains('hidden')) {
            closeCart();
        }
    });

    // Cart AJAX Functions
    window.loadCart = function() {
        fetch('/cart', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderCart(data);
            }
        })
        .catch(error => console.error('Error loading cart:', error));
    }

    // Make renderCart globally accessible
    window.renderCart = function(data) {
        const container = document.getElementById('cartItemsContainer');
        const emptyMessage = document.getElementById('emptyCartMessage');
        const template = document.getElementById('cartItemTemplate');
        const initialPrice = document.getElementById('cartInitialPrice');
        const shipping = document.getElementById('cartShipping');
        const discount = document.getElementById('cartDiscount');
        const total = document.getElementById('cartTotal');
        const progressBar1 = document.getElementById('progressBar1');
        const progressBar2 = document.getElementById('progressBar2');
        const checkoutBtn = document.getElementById('checkoutBtn');

        if (!container || !template) return;

        const itemCount = data.item_count || 0;
        const subtotal = parseFloat(data.subtotal) || 0;
        
        // Get shipping settings from cart promo banner data attributes
        const promoBanner = document.getElementById('cartPromoBanner');
        const defaultShipping = parseFloat(promoBanner?.dataset.shippingCharge) || <?php echo e($settings['shipping_charge'] ?? 99); ?>;
        const freeShippingThreshold = parseFloat(promoBanner?.dataset.freeShippingThreshold) || <?php echo e($settings['free_shipping_threshold'] ?? 999); ?>;
        const promoFreeShipping = promoBanner?.dataset.freeShipping === '1';
        const promoFreeShippingMin = parseInt(promoBanner?.dataset.freeShippingMin) || 3;

        // Update progress bars based on item count
        if (progressBar1) {
            progressBar1.style.width = Math.min(itemCount / 2 * 100, 100) + '%';
        }
        if (progressBar2) {
            progressBar2.style.width = Math.min(itemCount / 3 * 100, 100) + '%';
        }

        // Calculate shipping
        let shippingCost = defaultShipping;
        
        // Check promotion free shipping
        if (promoFreeShipping && itemCount >= promoFreeShippingMin) {
            shippingCost = 0;
        }
        // Check free shipping threshold
        else if (freeShippingThreshold > 0 && subtotal >= freeShippingThreshold) {
            shippingCost = 0;
        }
        
        // Calculate discount from promotion
        const promoMinItems = parseInt(promoBanner?.dataset.minItems) || 2;
        const promoDiscountType = promoBanner?.dataset.discountType || 'percentage';
        const promoDiscountValue = parseFloat(promoBanner?.dataset.discountValue) || 0;
        
        let discountAmount = 0;
        if (itemCount >= promoMinItems && promoDiscountValue > 0) {
            if (promoDiscountType === 'percentage') {
                discountAmount = subtotal * (promoDiscountValue / 100);
            } else {
                discountAmount = Math.min(promoDiscountValue, subtotal);
            }
        }
        
        // Calculate final total
        const finalTotal = subtotal - discountAmount + shippingCost;

        if (data.items && data.items.length > 0) {
            container.classList.remove('hidden');
            emptyMessage.classList.add('hidden');
            
            // Enable checkout button
            if (checkoutBtn) {
                checkoutBtn.classList.remove('opacity-50', 'pointer-events-none');
            }

            container.innerHTML = '';

            data.items.forEach(item => {
                const clone = template.content.cloneNode(true);
                const itemEl = clone.querySelector('.cart-item');
                
                itemEl.dataset.itemId = item.id;
                clone.querySelector('.cart-item-image').src = item.image || '';
                clone.querySelector('.cart-item-image').alt = item.name;
                
                // Split name into two lines (FLORAL<br>MARSHMALLOW style)
                const nameParts = item.name.toUpperCase().split(' ');
                const firstLine = nameParts.slice(0, Math.ceil(nameParts.length/2)).join(' ');
                const secondLine = nameParts.slice(Math.ceil(nameParts.length/2)).join(' ');
                clone.querySelector('.cart-item-name').innerHTML = firstLine + (secondLine ? '<br>' + secondLine : '');
                
                clone.querySelector('.cart-item-quantity').textContent = item.quantity;
                clone.querySelector('.cart-item-price').textContent = '₹' + parseFloat(item.total).toFixed(2);

                container.appendChild(clone);
            });

            // Update summary
            if (initialPrice) initialPrice.textContent = '₹' + subtotal.toFixed(2);
            if (shipping) shipping.textContent = shippingCost === 0 ? 'FREE' : '₹' + shippingCost.toFixed(2);
            if (discount) discount.textContent = discountAmount > 0 ? '-₹' + discountAmount.toFixed(2) : '0';
            if (total) total.textContent = '₹' + finalTotal.toFixed(2);
        } else {
            container.classList.add('hidden');
            emptyMessage.classList.remove('hidden');
            
            // Disable checkout button when cart is empty
            if (checkoutBtn) {
                checkoutBtn.classList.add('opacity-50', 'pointer-events-none');
            }
            
            if (initialPrice) initialPrice.textContent = '₹0.00';
            if (shipping) shipping.textContent = '₹' + defaultShipping.toFixed(2);
            if (discount) discount.textContent = '0';
            if (total) total.textContent = '₹0.00';
        }
    }

    // Make addToCart globally accessible
    window.addToCart = function(productId, quantity = 1) {
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderCart(data);
                openCart();
            }
        })
        .catch(error => console.error('Error adding to cart:', error));
    }

    function updateCartQuantity(btn, change) {
        const itemEl = btn.closest('.cart-item');
        if (!itemEl) return;
        
        const itemId = itemEl.dataset.itemId;
        const quantityEl = itemEl.querySelector('.cart-item-quantity');
        let newQuantity = parseInt(quantityEl.textContent) + change;
        
        if (newQuantity < 1) {
            removeFromCart(btn);
            return;
        }

        fetch('/cart/update/' + itemId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                quantity: newQuantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderCart(data);
            }
        })
        .catch(error => console.error('Error updating cart:', error));
    }

    function removeFromCart(btn) {
        const itemEl = btn.closest('.cart-item');
        if (!itemEl) return;
        
        const itemId = itemEl.dataset.itemId;

        fetch('/cart/remove/' + itemId, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderCart(data);
            }
        })
        .catch(error => console.error('Error removing from cart:', error));
    }

    // Load cart on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadCart();
    });

    // Bundle Tab Switching Function
    function switchBundleTab(tabName) {
        // Hide all bundle tab contents
        document.querySelectorAll('.bundle-tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active state from all bundle tab buttons
        document.querySelectorAll('.bundle-tab-btn').forEach(btn => {
            btn.classList.remove('text-gray-900', 'font-bold', 'border-black');
            btn.classList.add('text-gray-400', 'border-transparent');
        });
        
        // Show selected tab content
        document.getElementById(tabName + 'TabContent').classList.remove('hidden');
        
        // Add active state to selected button
        const activeBtn = document.getElementById(tabName + 'TabBtn');
        activeBtn.classList.remove('text-gray-400', 'border-transparent');
        activeBtn.classList.add('text-gray-900', 'font-bold', 'border-black');
    }

    // Product Image Change Function
    function changeMainImage(imageUrl, direction = 'next') {
        const mainImage = document.getElementById('mainProductImage');
        if (mainImage) {
            // Slide out animation
            if (direction === 'next') {
                mainImage.style.transform = 'translateX(-100%)';
            } else {
                mainImage.style.transform = 'translateX(100%)';
            }
            mainImage.style.transition = 'transform 0.4s ease';
            
            // Change image and slide in
            setTimeout(() => {
                mainImage.src = imageUrl;
                if (direction === 'next') {
                    mainImage.style.transform = 'translateX(100%)';
                } else {
                    mainImage.style.transform = 'translateX(-100%)';
                }
                
                setTimeout(() => {
                    mainImage.style.transform = 'translateX(0)';
                }, 50);
            }, 400);
        }
    }

    // Product Image Gallery Navigation - Only on Product Page
    if (document.getElementById('mainProductImage')) {
        var currentProductImageIndex = 0;
        var productImages = [
            '<?php echo e($product->imagekit_url ?? ""); ?>'
            <?php if(isset($product->gallery_images) && is_array($product->gallery_images)): ?>
                <?php $__currentLoopData = $product->gallery_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    ,'<?php echo e($image); ?>'
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        ];

        window.nextProductImage = function() {
            currentProductImageIndex = (currentProductImageIndex + 1) % productImages.length;
            changeMainImage(productImages[currentProductImageIndex], 'next');
        }

        window.previousProductImage = function() {
            currentProductImageIndex = (currentProductImageIndex - 1 + productImages.length) % productImages.length;
            changeMainImage(productImages[currentProductImageIndex], 'prev');
        }
    }

    // Product Tab Switching Function with Animation
    function switchProductTab(tabName) {
        // Hide all product tab contents with fade out
        document.querySelectorAll('.product-tab-content').forEach(content => {
            content.classList.add('hidden', 'opacity-0');
        });
        
        // Remove active state from all product tab buttons
        document.querySelectorAll('.product-tab').forEach(btn => {
            btn.classList.remove('bg-black', 'text-white');
            btn.classList.add('bg-white', 'text-gray-700', 'border-2', 'border-gray-300');
        });
        
        // Show selected tab content with fade in
        const selectedContent = document.getElementById(tabName + 'ProductContent');
        selectedContent.classList.remove('hidden');
        setTimeout(() => {
            selectedContent.classList.remove('opacity-0');
            selectedContent.classList.add('opacity-100');
        }, 50);
        
        // Add active state to selected button
        const activeBtn = document.getElementById(tabName + 'ProductTab');
        activeBtn.classList.remove('bg-white', 'text-gray-700', 'border-2', 'border-gray-300');
        activeBtn.classList.add('bg-black', 'text-white');
    }

    // Shipping Countdown Timer - Only on Product Page
    const shippingCountdown = document.getElementById('shippingCountdown');
    if (shippingCountdown) {
        function updateCountdown() {
            const now = new Date();
            const midnight = new Date();
            midnight.setHours(24, 0, 0, 0);
            
            const diff = midnight - now;
            
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            shippingCountdown.textContent = hours + 'Hours ' + minutes + 'Minutes ' + seconds + 'Seconds';
        }
        
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    // Filter Sidebar Functions - Only on Collections Page
    function openFilterSidebar() {
        const sidebar = document.getElementById('filterSidebar');
        const panel = document.getElementById('filterPanel');
        if (sidebar && panel) {
            sidebar.classList.remove('hidden');
            setTimeout(() => {
                panel.classList.remove('-translate-x-full');
            }, 10);
            document.body.style.overflow = 'hidden';
        }
    }

    function closeFilterSidebar() {
        const sidebar = document.getElementById('filterSidebar');
        const panel = document.getElementById('filterPanel');
        if (sidebar && panel) {
            panel.classList.add('-translate-x-full');
            setTimeout(() => {
                sidebar.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }
    }

    function toggleFilterSection(section) {
        const content = document.getElementById(section + 'Content');
        const icon = document.getElementById(section + 'Icon');
        if (content && icon) {
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
    }

    // Close filter sidebar on Escape key
    document.addEventListener('keydown', (e) => {
        const sidebar = document.getElementById('filterSidebar');
        if (e.key === 'Escape' && sidebar && !sidebar.classList.contains('hidden')) {
            closeFilterSidebar();
        }
    });
</script>
<?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/partials/scripts.blade.php ENDPATH**/ ?>