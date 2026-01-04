@extends('layouts.app')

@section('title', 'Contact Us - Scents N Smile')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Hero Section with Poetic Message -->
    <section class="pt-32 pb-16 px-4 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-7xl font-black mb-8 tracking-tight">Get in Touch</h1>
            
            <!-- Poetic Message -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12 mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">Customer First — Always.</h2>
                <div class="space-y-4 text-lg text-gray-700 leading-relaxed italic">
                    <p>You are the soul of our scent story,</p>
                    <p>The spark behind every bottle we pour.</p>
                    <p>From fragrance wishes to heartfelt thoughts,</p>
                    <p>Your voice is the muse we adore.</p>
                    <p class="pt-4">Have an idea, a dream, a note to share?</p>
                    <p>Whisper it our way — we're always near.</p>
                    <p>Our team will reply with care and delight,</p>
                    <p>Because your words make our world feel right.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-10">
                    <h2 class="text-3xl font-black mb-4">Drop Us A Line</h2>
                    <p class="text-gray-600 mb-8">Fill out this quick form, and we'll get back to you promptly!</p>

                    <form id="contactForm" class="space-y-6">
                        @csrf
                        
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-900 mb-2">Your Name *</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] transition-all"
                                   placeholder="Enter your full name">
                            <span id="nameError" class="text-red-600 text-sm hidden"></span>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-bold text-gray-900 mb-2">Your Phone *</label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone"
                                   required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] transition-all"
                                   placeholder="+91 98765 43210">
                            <span id="phoneError" class="text-red-600 text-sm hidden"></span>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-900 mb-2">Your Email *</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] transition-all"
                                   placeholder="your.email@example.com">
                            <span id="emailError" class="text-red-600 text-sm hidden"></span>
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-bold text-gray-900 mb-2">Subject *</label>
                            <select id="subject" 
                                    name="subject" 
                                    required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] transition-all">
                                <option value="">Select a subject</option>
                                <option value="General Inquiry">General Inquiry</option>
                                <option value="Product Inquiry">Product Inquiry</option>
                                <option value="Order Status">Order Status</option>
                                <option value="Shipping & Delivery">Shipping & Delivery</option>
                                <option value="Returns & Refunds">Returns & Refunds</option>
                                <option value="Product Recommendation">Product Recommendation</option>
                                <option value="Wholesale Enquiries">Wholesale Enquiries</option>
                                <option value="Press & Media">Press & Media</option>
                                <option value="Feedback">Feedback</option>
                                <option value="Other">Other</option>
                            </select>
                            <span id="subjectError" class="text-red-600 text-sm hidden"></span>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-bold text-gray-900 mb-2">Your Comment / Message *</label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="6" 
                                      required
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#e8a598] focus:border-[#e8a598] transition-all resize-none"
                                      placeholder="Please tell us how we can help!"></textarea>
                            <span id="messageError" class="text-red-600 text-sm hidden"></span>
                        </div>

                        <!-- Privacy Policy Checkbox -->
                        <div class="flex items-start gap-3">
                            <input type="checkbox" 
                                   id="privacy" 
                                   name="privacy" 
                                   required
                                   class="mt-1 w-4 h-4 text-[#e8a598] border-gray-300 rounded focus:ring-[#e8a598]">
                            <label for="privacy" class="text-sm text-gray-700">
                                I agree to the <a href="{{ route('privacy-policy') }}" class="text-[#e8a598] hover:underline font-semibold">Privacy Policy</a> of the website. *
                            </label>
                        </div>

                        <!-- Success/Error Message -->
                        <div id="formMessage" class="hidden p-4 rounded-xl"></div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                id="submitBtn"
                                class="w-full bg-[#e8a598] hover:bg-[#d89588] text-white font-bold py-4 rounded-full text-lg transition-all transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed">
                            SUBMIT MESSAGE
                        </button>
                    </form>
                </div>

                <!-- Contact Information & Availability -->
                <div class="space-y-8">
                    <!-- Thank You Message -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-2xl font-black mb-4">📞 Contact Information & Availability</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Thank you for reaching out to <strong>Scents N' Smile™</strong>. Your satisfaction is always our priority.
                        </p>
                    </div>

                    <!-- Contact Methods Table -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900 border-b border-gray-200">Contact Method</th>
                                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900 border-b border-gray-200">Details</th>
                                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-900 border-b border-gray-200">Available Hours (IST)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-gray-200">
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">General Enquiries</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            Email: <a href="mailto:hello@scentsnsmile.com" class="text-[#e8a598] hover:underline font-semibold">hello@scentsnsmile.com</a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">24-Hour Response Guarantee</td>
                                    </tr>
                                    <tr class="border-b border-gray-200 bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">Customer Service Calls</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            Call / WhatsApp: <a href="tel:+919876543210" class="text-[#e8a598] hover:underline font-semibold">+91 98765 43210</a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">Monday to Saturday<br>10:00 AM – 7:00 PM</td>
                                    </tr>
                                    <tr class="border-b border-gray-200">
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">Wholesale Enquiries</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            Email: <a href="mailto:sales@scentsnsmile.com" class="text-[#e8a598] hover:underline font-semibold">sales@scentsnsmile.com</a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">24-Hour Response Guarantee</td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">Press & Media Enquiries</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            Email: <a href="mailto:hello@scentsnsmile.com" class="text-[#e8a598] hover:underline font-semibold">hello@scentsnsmile.com</a>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">24-Hour Response Guarantee</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Response Pledge -->
                    <div class="bg-gradient-to-br from-[#e8a598] to-[#d89588] rounded-2xl p-8 text-white">
                        <h4 class="text-lg font-bold mb-3">Response Pledge</h4>
                        <p class="text-white/95 leading-relaxed">
                            Our support team guarantees a response within <strong>24 hours</strong> with the care and attention you deserve. If your email arrives outside our regular business hours (Sundays or public holidays), a dedicated representative will be assigned the following business day.
                        </p>
                    </div>

                    <!-- Warehouse Address -->
                    <div class="bg-yellow-50 rounded-2xl p-8 border-l-4 border-yellow-500">
                        <h4 class="text-lg font-bold text-yellow-900 mb-3">Our Warehouse Address</h4>
                        <p class="text-sm text-yellow-800 mb-2 font-semibold">(Not for Returns)</p>
                        <p class="text-gray-800 leading-relaxed">
                            Scents N Smile™<br>
                            A/203, Mumbai, Maharashtra 400003
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 px-4 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-4xl font-black text-center mb-12">Frequently Asked Questions</h2>
            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-2">How long does shipping take?</h3>
                    <p class="text-gray-600">We typically ship orders within 1-2 business days. Delivery usually takes 3-7 business days depending on your location.</p>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-2">What is your return policy?</h3>
                    <p class="text-gray-600">We offer a 30-day return policy. If you're not satisfied with your purchase, you can return it for a full refund within 30 days of delivery.</p>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-2">Are your fragrances authentic?</h3>
                    <p class="text-gray-600">Yes! All our fragrances are inspired by designer brands and crafted with premium ingredients. We guarantee quality and authenticity.</p>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold mb-2">Do you offer bulk discounts?</h3>
                    <p class="text-gray-600">Yes, we offer special pricing for bulk orders. Please contact us with your requirements and we'll provide a custom quote.</p>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const formMessage = document.getElementById('formMessage');
    
    // Form fields
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const subjectInput = document.getElementById('subject');
    const messageInput = document.getElementById('message');

    // Validation functions
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function validatePhone(phone) {
        if (!phone) return true; // Phone is optional
        const re = /^[\d\s\+\-\(\)]+$/;
        return re.test(phone) && phone.replace(/\D/g, '').length >= 10;
    }

    function showError(message) {
        formMessage.className = 'p-4 rounded-xl bg-red-50 border border-red-200 text-red-800';
        formMessage.textContent = message;
        formMessage.classList.remove('hidden');
        
        // Scroll to message
        formMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function showSuccess(message) {
        formMessage.className = 'p-4 rounded-xl bg-green-50 border border-green-200 text-green-800';
        formMessage.textContent = message;
        formMessage.classList.remove('hidden');
        
        // Scroll to message
        formMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function hideMessage() {
        formMessage.classList.add('hidden');
    }

    // Real-time validation
    emailInput.addEventListener('blur', function() {
        if (this.value && !validateEmail(this.value)) {
            this.classList.add('border-red-500');
            this.classList.remove('border-gray-300');
        } else {
            this.classList.remove('border-red-500');
            this.classList.add('border-gray-300');
        }
    });

    phoneInput.addEventListener('blur', function() {
        if (this.value && !validatePhone(this.value)) {
            this.classList.add('border-red-500');
            this.classList.remove('border-gray-300');
        } else {
            this.classList.remove('border-red-500');
            this.classList.add('border-gray-300');
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        hideMessage();

        // Validate all fields
        const name = nameInput.value.trim();
        const email = emailInput.value.trim();
        const phone = phoneInput.value.trim();
        const subject = subjectInput.value;
        const message = messageInput.value.trim();

        // Client-side validation
        if (!name) {
            showError('Please enter your name.');
            nameInput.focus();
            return;
        }

        if (!email) {
            showError('Please enter your email address.');
            emailInput.focus();
            return;
        }

        if (!validateEmail(email)) {
            showError('Please enter a valid email address.');
            emailInput.focus();
            return;
        }

        if (phone && !validatePhone(phone)) {
            showError('Please enter a valid phone number (at least 10 digits).');
            phoneInput.focus();
            return;
        }

        if (!subject) {
            showError('Please select a subject.');
            subjectInput.focus();
            return;
        }

        if (!message) {
            showError('Please enter your message.');
            messageInput.focus();
            return;
        }

        if (message.length < 10) {
            showError('Message must be at least 10 characters long.');
            messageInput.focus();
            return;
        }

        // Disable button and show loading state
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending...';
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

        // Prepare form data
        const formData = new FormData(form);

        // Send AJAX request using XMLHttpRequest (Pure Vanilla JS)
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("contact.store") }}', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.setRequestHeader('Accept', 'application/json');

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    
                    if (response.success) {
                        showSuccess(response.message || 'Thank you for contacting us! We will get back to you soon.');
                        form.reset();
                        
                        // Hide success message after 5 seconds
                        setTimeout(function() {
                            hideMessage();
                        }, 5000);
                    } else {
                        showError(response.message || 'Something went wrong. Please try again.');
                    }
                } catch (e) {
                    showError('Failed to process response. Please try again.');
                    console.error('Parse error:', e);
                }
            } else if (xhr.status === 422) {
                // Validation errors
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.errors) {
                        const firstError = Object.values(response.errors)[0][0];
                        showError(firstError);
                    } else {
                        showError(response.message || 'Validation failed. Please check your inputs.');
                    }
                } catch (e) {
                    showError('Validation failed. Please check your inputs.');
                }
            } else {
                showError('Server error. Please try again later.');
            }
        };

        xhr.onerror = function() {
            showError('Network error. Please check your connection and try again.');
        };

        xhr.ontimeout = function() {
            showError('Request timeout. Please try again.');
        };

        // Set timeout (30 seconds)
        xhr.timeout = 30000;

        // Send request
        xhr.send(formData);

        // Re-enable button after request completes
        xhr.onloadend = function() {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Send Message';
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        };
    });

    // Clear error styling on input
    [nameInput, emailInput, phoneInput, subjectInput, messageInput].forEach(function(input) {
        input.addEventListener('input', function() {
            this.classList.remove('border-red-500');
            this.classList.add('border-gray-300');
        });
    });
});
</script>
@endsection
