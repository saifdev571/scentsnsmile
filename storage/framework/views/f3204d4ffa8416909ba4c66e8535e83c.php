<!-- Add/Edit Testimonial Modal -->
<div id="testimonialModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-5 rounded-t-2xl z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center w-10 h-10 bg-white bg-opacity-20 rounded-xl backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <h3 id="modalTitle" class="text-xl font-black text-white">Add Testimonial</h3>
                </div>
                <button onclick="closeModal()" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <form id="testimonialForm" class="p-6 space-y-6">
            <input type="hidden" id="testimonialId" name="id">

            <!-- Customer Name -->
            <div>
                <label for="customerName" class="block text-sm font-bold text-gray-700 mb-2">
                    Customer Name
                    <span class="text-gray-400 font-normal">(Optional)</span>
                </label>
                <input type="text" id="customerName" name="customer_name" placeholder="Enter customer name or leave blank for Anonymous" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-100 focus:border-purple-400 transition-all duration-200">
            </div>

            <!-- Review Text -->
            <div>
                <label for="reviewText" class="block text-sm font-bold text-gray-700 mb-2">
                    Review Text
                    <span class="text-red-500">*</span>
                </label>
                <textarea id="reviewText" name="review_text" rows="4" placeholder="Enter customer review..." class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-100 focus:border-purple-400 transition-all duration-200 resize-none" required></textarea>
                <p class="mt-1 text-xs text-gray-500">Write the customer's testimonial or review</p>
            </div>

            <!-- Rating -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-3">
                    Rating
                    <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center space-x-2">
                    <div id="starRating" class="flex items-center space-x-1">
                        <button type="button" onclick="setRating(1)" class="star-btn focus:outline-none transition-transform hover:scale-110" data-rating="1">
                            <svg class="w-8 h-8 text-gray-300 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        </button>
                        <button type="button" onclick="setRating(2)" class="star-btn focus:outline-none transition-transform hover:scale-110" data-rating="2">
                            <svg class="w-8 h-8 text-gray-300 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        </button>
                        <button type="button" onclick="setRating(3)" class="star-btn focus:outline-none transition-transform hover:scale-110" data-rating="3">
                            <svg class="w-8 h-8 text-gray-300 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        </button>
                        <button type="button" onclick="setRating(4)" class="star-btn focus:outline-none transition-transform hover:scale-110" data-rating="4">
                            <svg class="w-8 h-8 text-gray-300 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        </button>
                        <button type="button" onclick="setRating(5)" class="star-btn focus:outline-none transition-transform hover:scale-110" data-rating="5">
                            <svg class="w-8 h-8 text-gray-300 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        </button>
                    </div>
                    <span id="ratingText" class="text-sm font-semibold text-gray-600 ml-2">5 stars</span>
                </div>
                <input type="hidden" id="rating" name="rating" value="5" required>
            </div>

            <!-- Sort Order -->
            <div>
                <label for="sortOrder" class="block text-sm font-bold text-gray-700 mb-2">
                    Sort Order
                </label>
                <input type="number" id="sortOrder" name="sort_order" value="0" min="0" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-100 focus:border-purple-400 transition-all duration-200">
                <p class="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
            </div>

            <!-- Status Toggle -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border-2 border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-xl">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">Active Status</p>
                        <p class="text-xs text-gray-500">Show this testimonial on website</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="isActive" name="is_active" class="sr-only peer" checked>
                    <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-purple-600 peer-checked:to-indigo-600"></div>
                </label>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t-2 border-gray-100">
                <button type="button" onclick="closeModal()" class="px-6 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-sm font-bold rounded-xl hover:from-purple-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all duration-200">
                    <span id="submitBtnText">Create Testimonial</span>
                </button>
            </div>
        </form>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\SCENTS N SMILE\resources\views/admin/testimonials/modal.blade.php ENDPATH**/ ?>