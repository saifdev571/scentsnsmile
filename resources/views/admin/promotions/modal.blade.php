<!-- Promotion Modal -->
<div id="promotionModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50" onclick="closeModal()"></div>
    <div class="absolute inset-4 sm:inset-auto sm:top-1/2 sm:left-1/2 sm:-translate-x-1/2 sm:-translate-y-1/2 sm:w-full sm:max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b bg-gradient-to-r from-red-500 to-orange-500">
            <h3 class="text-lg font-bold text-white" id="modalTitle">Add Promotion</h3>
            <button onclick="closeModal()" class="text-white/80 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Form -->
        <form id="promotionForm" class="flex-1 overflow-y-auto p-6">
            <input type="hidden" id="promotionId" name="id">
            
            <div class="space-y-6">
                <!-- Basic Info -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Promotion Name *</label>
                        <input type="text" name="name" id="promoName" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            placeholder="e.g., Holiday Sale, Summer Discount">
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="promoDescription" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            placeholder="Brief description of the promotion"></textarea>
                    </div>
                </div>

                <!-- Discount Settings -->
                <div class="bg-green-50 rounded-xl p-4">
                    <h4 class="font-bold text-green-800 mb-3">💰 Discount Settings</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Discount Type</label>
                            <select name="discount_type" id="promoDiscountType"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount (₹)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Discount Value *</label>
                            <input type="number" name="discount_value" id="promoDiscountValue" required min="0" step="0.01"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                placeholder="40">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Items Required *</label>
                            <input type="number" name="min_items" id="promoMinItems" required min="1" value="2"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>
                </div>

                <!-- Free Shipping -->
                <div class="bg-blue-50 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-bold text-blue-800">🚚 Free Shipping</h4>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="free_shipping" id="promoFreeShipping" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <div id="freeShippingOptions" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Min Items for Free Shipping</label>
                        <input type="number" name="free_shipping_min_items" id="promoFreeShippingMinItems" min="1" value="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Display Settings -->
                <div class="bg-purple-50 rounded-xl p-4">
                    <h4 class="font-bold text-purple-800 mb-3">🎨 Display Settings</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Badge Text (Header)</label>
                            <input type="text" name="badge_text" id="promoBadgeText"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                placeholder="HOLIDAY SALE">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Badge Color</label>
                            <input type="color" name="badge_color" id="promoBadgeColor" value="#ef4444"
                                class="w-full h-10 border border-gray-300 rounded-lg cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Banner Title</label>
                            <input type="text" name="banner_title" id="promoBannerTitle"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                placeholder="HOLIDAY SALE">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cart Label</label>
                            <input type="text" name="cart_label" id="promoCartLabel"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                placeholder="Holiday Sale discount">
                        </div>
                    </div>
                </div>

                <!-- Validity -->
                <div class="bg-yellow-50 rounded-xl p-4">
                    <h4 class="font-bold text-yellow-800 mb-3">📅 Validity Period</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                            <input type="datetime-local" name="starts_at" id="promoStartsAt"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input type="datetime-local" name="ends_at" id="promoEndsAt"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500">
                        </div>
                    </div>
                </div>

                <!-- Toggles -->
                <div class="flex flex-wrap gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" id="promoIsActive" checked
                            class="w-5 h-5 text-green-600 rounded focus:ring-green-500">
                        <span class="font-medium">Active</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="show_in_header" id="promoShowHeader" checked
                            class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                        <span class="font-medium">Show in Header</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="show_in_cart" id="promoShowCart" checked
                            class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500">
                        <span class="font-medium">Show in Cart</span>
                    </label>
                </div>
            </div>
        </form>

        <!-- Footer -->
        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t bg-gray-50">
            <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-700 hover:bg-gray-200 rounded-lg transition-colors">
                Cancel
            </button>
            <button type="button" onclick="savePromotion()" class="px-6 py-2 bg-gradient-to-r from-red-500 to-orange-500 text-white font-semibold rounded-lg hover:opacity-90 transition-opacity">
                Save Promotion
            </button>
        </div>
    </div>
</div>
