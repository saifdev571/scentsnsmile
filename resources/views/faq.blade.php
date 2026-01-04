@extends('layouts.app')

@section('title', 'FAQ - Scents N Smile')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section class="pt-32 pb-16 px-4 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-5xl mx-auto text-center">
            <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tight">❓ Frequently Asked Questions</h1>
            <p class="text-2xl md:text-3xl text-gray-700 mb-8 font-light">All your questions answered. Still curious?</p>
            
            <!-- Intro Message -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-10 text-left">
                <p class="text-lg text-gray-700 leading-relaxed mb-6">
                    We believe finding your perfect fragrance should be effortless. Below are some of the most frequent questions we receive every day, designed to bring you quick clarity and confidence.
                </p>
                <p class="text-lg text-gray-700 leading-relaxed">
                    <strong>Need a direct answer?</strong> Reach out anytime! We're happy to help you find your smile through our WhatsApp chat, or email us at 
                    <a href="mailto:hello@scentsnsmile.com" class="text-[#e8a598] hover:underline font-semibold">hello@scentsnsmile.com</a>. 
                    You can find more contact details on our <a href="{{ route('contact') }}" class="text-[#e8a598] hover:underline font-semibold">Contact Us</a> page.
                </p>
            </div>
        </div>
    </section>

    <!-- FAQ Content with Sidebar -->
    <section class="py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar Navigation -->
                <aside class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h3 class="text-lg font-black mb-4 text-gray-900">Quick Navigation</h3>
                        <nav class="space-y-2">
                            <a href="#product-quality" class="block text-sm text-gray-700 hover:text-[#e8a598] hover:translate-x-1 transition-all py-2 border-l-2 border-transparent hover:border-[#e8a598] pl-3">💎 Product & Quality</a>
                            <a href="#usage-care" class="block text-sm text-gray-700 hover:text-[#e8a598] hover:translate-x-1 transition-all py-2 border-l-2 border-transparent hover:border-[#e8a598] pl-3">💖 Usage & Care</a>
                            <a href="#ordering-shipping" class="block text-sm text-gray-700 hover:text-[#e8a598] hover:translate-x-1 transition-all py-2 border-l-2 border-transparent hover:border-[#e8a598] pl-3">🛒 Ordering & Shipping</a>
                            <a href="#returns-exchanges" class="block text-sm text-gray-700 hover:text-[#e8a598] hover:translate-x-1 transition-all py-2 border-l-2 border-transparent hover:border-[#e8a598] pl-3">🔁 Returns & Exchanges</a>
                            <a href="#delivery-store" class="block text-sm text-gray-700 hover:text-[#e8a598] hover:translate-x-1 transition-all py-2 border-l-2 border-transparent hover:border-[#e8a598] pl-3">📦 Delivery & Store</a>
                            <a href="#contact-form" class="block text-sm text-gray-700 hover:text-[#e8a598] hover:translate-x-1 transition-all py-2 border-l-2 border-transparent hover:border-[#e8a598] pl-3">💬 Still Curious?</a>
                        </nav>
                    </div>
                </aside>

                <!-- Main FAQ Content -->
                <div class="lg:col-span-3 space-y-12">
                    <!-- Product & Quality Information -->
                    <div id="product-quality" class="scroll-mt-24">
                        <h2 class="text-3xl font-black mb-6 text-gray-900">💎 Product & Quality Information</h2>
                        
                        <!-- FAQ Item -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Are Scents N' Smile™ inspired perfumes lasting?</h3>
                            <p class="text-gray-700 leading-relaxed">
                                Absolutely! Our fragrances are crafted with high-concentration perfume oils (average 35% concentration) and premium ingredients sourced from the same world-renowned factories that supply top luxury brands. Designed by expert perfumers, our scents offer impressive longevity—often matching or even exceeding the staying power of traditional designer perfumes.
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">What makes these fragrances so affordable?</h3>
                            <p class="text-gray-700 leading-relaxed">
                                Our approach to affordability involves eliminating the unnecessary costs associated with expensive packaging, celebrity endorsements, and excessive advertising. By prioritizing the quality of the fragrance itself (the 'juice'), we are able to offer the exact same luxurious scent profile at a fraction of the price.
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Are these real brand perfumes/fragrances?</h3>
                            <p class="text-gray-700 leading-relaxed">
                                Our fragrance blends are inspired by renowned brand fragrances, meticulously crafted to meet the same high-quality standards. We aim to provide customers with an affordable alternative. We are not affiliated with the mentioned brands in any way, nor do we sell their original products. We are in compliance with the Competition Commission of India's Act and Policies.
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Are your products original?</h3>
                            <p class="text-gray-700 leading-relaxed">
                                Yes, they are original products of Scents N' Smile™. We sell high-quality impressions of designer fragrances, using premium ingredients to create a new, inspired aroma that you will love.
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Do you use alcohol in your perfumes?</h3>
                            <p class="text-gray-700 leading-relaxed">
                                Yes—our spray perfumes contain alcohol, which is essential for fragrance projection and sillage. However, our roll-ons are 100% alcohol-free, made from concentrated perfume oils and natural carriers.
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Which One Smells Better — Oil or Spray?</h3>
                            <p class="text-gray-700 leading-relaxed mb-3">
                                Both versions are crafted with the same fragrance DNA, so they smell nearly identical.
                            </p>
                            <ul class="space-y-2 text-gray-700">
                                <li class="flex items-start">
                                    <span class="text-[#e8a598] mr-2">•</span>
                                    <span><strong>Perfume Oils (Roll-ons):</strong> Are more concentrated, may feel richer, and last longer directly on the skin.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-[#e8a598] mr-2">•</span>
                                    <span><strong>Sprays:</strong> Offer a more airy, diffused projection (sillage) and are ideal for quick top-ups and layering.</span>
                                </li>
                            </ul>
                            <p class="text-gray-700 leading-relaxed mt-3">
                                The best choice ultimately depends on your body chemistry and personal preference!
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">How Long Will the Perfume Bottle Last?</h3>
                            <p class="text-gray-700 leading-relaxed mb-4">This depends entirely on your usage habits.</p>
                            <div class="space-y-3">
                                <div class="flex items-start bg-gray-50 rounded-xl p-4">
                                    <span class="text-[#e8a598] font-bold mr-3">•</span>
                                    <div>
                                        <strong class="text-gray-900">10 ML Roll-on:</strong>
                                        <span class="text-gray-700"> Used once a day, lasts about 1–2 months.</span>
                                    </div>
                                </div>
                                <div class="flex items-start bg-gray-50 rounded-xl p-4">
                                    <span class="text-[#e8a598] font-bold mr-3">•</span>
                                    <div>
                                        <strong class="text-gray-900">50 ML Spray Bottle:</strong>
                                        <span class="text-gray-700"> Used once a day, lasts about 2–3 months.</span>
                                    </div>
                                </div>
                                <div class="flex items-start bg-gray-50 rounded-xl p-4">
                                    <span class="text-[#e8a598] font-bold mr-3">•</span>
                                    <div>
                                        <strong class="text-gray-900">100 ML Spray Bottle:</strong>
                                        <span class="text-gray-700"> Used once a day, lasts about 4–6 months.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Usage & Care -->
                    <div id="usage-care" class="scroll-mt-24">
                        <h2 class="text-3xl font-black mb-6 text-gray-900">💖 Usage & Care</h2>
                        
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">How do I apply perfume spray or oil for the best results?</h3>
                            <p class="text-gray-700 leading-relaxed mb-4">For maximum longevity and performance:</p>
                            <ul class="space-y-2 text-gray-700">
                                <li class="flex items-start">
                                    <span class="text-[#e8a598] mr-2">•</span>
                                    <span>Apply on clean, dry skin right after a shower for best absorption.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-[#e8a598] mr-2">•</span>
                                    <span>Moisturize with an unscented lotion before spraying to help the scent stick longer.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-[#e8a598] mr-2">•</span>
                                    <span>Spray from 5–7 inches away on pulse points—wrists, neck, behind ears, inside elbows, or behind knees.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-[#e8a598] mr-2">•</span>
                                    <span><strong>Avoid rubbing</strong> your wrists together after spraying—it breaks down the fragrance molecules!</span>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">What's the Best Way to Store Perfumes?</h3>
                            <p class="text-gray-700 leading-relaxed mb-4">To preserve your fragrance's quality and performance:</p>
                            <ul class="space-y-2 text-gray-700">
                                <li class="flex items-start">
                                    <span class="text-[#e8a598] mr-2">•</span>
                                    <span>Store in a cool, dark place.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-[#e8a598] mr-2">•</span>
                                    <span>Avoid direct sunlight or heat exposure (like windows or car dashboards).</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-[#e8a598] mr-2">•</span>
                                    <span>Keep the cap tightly closed when not in use.</span>
                                </li>
                            </ul>
                            <p class="text-gray-700 leading-relaxed mt-4 italic">
                                Heat and light can chemically alter the perfume, affecting its scent and longevity.
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Will My Namaz Be Acceptable If the Perfume Contains Alcohol?</h3>
                            <p class="text-gray-700 leading-relaxed">
                                Yes, your Namaz will be valid even if you use a perfume that contains alcohol. In Islamic jurisprudence, the prohibition is on consuming (drinking) intoxicating liquor (khamr), not on external use. Scholars have clarified that the type of alcohol used in perfumes, medicines, and detergents is permissible for external use, as it is typically synthetic or denatured and is not considered impure (najis).
                            </p>
                        </div>
                    </div>

                    <!-- Ordering & Shipping -->
                    <div id="ordering-shipping" class="scroll-mt-24">
                        <h2 class="text-3xl font-black mb-6 text-gray-900">🛒 Ordering & Shipping</h2>
                        
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Why should I buy from Scents N' Smile™?</h3>
                            <p class="text-gray-700 leading-relaxed mb-4">We offer unbeatable value, quality, and trust:</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="flex items-center bg-green-50 rounded-xl p-3">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span class="text-gray-800">4+ years in business</span>
                                </div>
                                <div class="flex items-center bg-green-50 rounded-xl p-3">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span class="text-gray-800">200,000+ followers on social media</span>
                                </div>
                                <div class="flex items-center bg-green-50 rounded-xl p-3">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span class="text-gray-800">5,000+ positive reviews</span>
                                </div>
                                <div class="flex items-center bg-green-50 rounded-xl p-3">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span class="text-gray-800">Friendly, knowledgeable support</span>
                                </div>
                                <div class="flex items-center bg-green-50 rounded-xl p-3">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span class="text-gray-800">Risk-free 14-day return policy</span>
                                </div>
                                <div class="flex items-center bg-green-50 rounded-xl p-3">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span class="text-gray-800">Tester options available</span>
                                </div>
                            </div>
                            <p class="text-gray-700 leading-relaxed mt-4">
                                Visit our Perfume Studio for a personal experience.
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">What countries do you ship to?</h3>
                            <p class="text-gray-700 leading-relaxed">
                                Currently, we only ship within <strong>India</strong> and select <strong>Gulf countries</strong>.
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">How much does shipping cost?</h3>
                            <div class="space-y-3">
                                <div class="flex items-start bg-gray-50 rounded-xl p-4">
                                    <span class="text-[#e8a598] font-bold mr-3">•</span>
                                    <div>
                                        <strong class="text-gray-900">Standard Shipping:</strong>
                                        <span class="text-gray-700"> ₹199</span>
                                    </div>
                                </div>
                                <div class="flex items-start bg-green-50 rounded-xl p-4">
                                    <span class="text-green-600 font-bold mr-3">✓</span>
                                    <div>
                                        <strong class="text-gray-900">Free Shipping:</strong>
                                        <span class="text-gray-700"> Available on all orders of 3 or more fragrances</span>
                                    </div>
                                </div>
                                <div class="flex items-start bg-blue-50 rounded-xl p-4">
                                    <span class="text-blue-600 font-bold mr-3">🎁</span>
                                    <div>
                                        <strong class="text-gray-900">Limited-Time Offers:</strong>
                                        <span class="text-gray-700"> Sometimes, we surprise you — free shipping during special promos. Stay tuned!</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">When Will My Parcel Reach Me?</h3>
                            <div class="space-y-3 mb-4">
                                <div class="flex items-start bg-gray-50 rounded-xl p-4">
                                    <span class="text-[#e8a598] font-bold mr-3">•</span>
                                    <div>
                                        <strong class="text-gray-900">Metro cities:</strong>
                                        <span class="text-gray-700"> 2–3 business days</span>
                                    </div>
                                </div>
                                <div class="flex items-start bg-gray-50 rounded-xl p-4">
                                    <span class="text-[#e8a598] font-bold mr-3">•</span>
                                    <div>
                                        <strong class="text-gray-900">Other cities/towns:</strong>
                                        <span class="text-gray-700"> 3–4 business days</span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-700 leading-relaxed mb-4 italic">
                                <strong>Note:</strong> During sale periods or festive rush, orders may take slightly longer due to high volumes.
                            </p>
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-xl">
                                <p class="text-gray-800">
                                    <strong>Already ordered?</strong> A dispatch confirmation with your tracking number is sent via email and WhatsApp once your order ships. 
                                    <a href="{{ route('tracking.index') }}" class="text-[#e8a598] hover:underline font-semibold">👉 Click here to track your order</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Returns & Exchanges -->
                    <div id="returns-exchanges" class="scroll-mt-24">
                        <h2 class="text-3xl font-black mb-6 text-gray-900">🔁 Returns & Exchanges</h2>
                        
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">What is your return policy?</h3>
                            <p class="text-gray-700 leading-relaxed mb-4">
                                We offer our <strong>Hassle-Free Return Promise</strong> for returns and exchanges within <strong>14 days of delivery</strong> on every eligible order.
                            </p>
                            <p class="text-gray-700 leading-relaxed mb-4">To be eligible for a return:</p>
                            <ul class="space-y-2 text-gray-700 mb-4">
                                <li class="flex items-start">
                                    <span class="text-[#e8a598] mr-2">•</span>
                                    <span>The item must be returned in its original condition and packaging, without damage.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-[#e8a598] mr-2">•</span>
                                    <span>The item must be unused or used no more than 5% of its total quantity.</span>
                                </li>
                            </ul>
                            <p class="text-gray-700 leading-relaxed mb-4">
                                Unfortunately, if more than 14 days have passed since delivery, we cannot offer a refund or exchange.
                            </p>
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-xl">
                                <p class="text-gray-800">
                                    For complete details on eligibility, fees, and non-returnable items, please refer to our 
                                    <a href="{{ route('return-refund') }}" class="text-[#e8a598] hover:underline font-semibold">Return & Refund Policy</a> page.
                                </p>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">How do I return or exchange an order?</h3>
                            <p class="text-gray-700 leading-relaxed">
                                If you want to return or exchange a fragrance, please contact our Customer Services team at 
                                <a href="mailto:hello@scentsnsmile.com" class="text-[#e8a598] hover:underline font-semibold">hello@scentsnsmile.com</a> 
                                so that we can guide you through the process and provide you with a return label.
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">How long does the refund process take?</h3>
                            <p class="text-gray-700 leading-relaxed">
                                Once your return is received and inspected, we will notify you of the approval or rejection of your refund. If approved, your refund will be processed, and the amount will be automatically credited to your bank account within the specified time frame.
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Who pays for return shipping?</h3>
                            <p class="text-gray-700 leading-relaxed">
                                You will be responsible for paying for your own shipping costs for returning your item (e.g., in cases of change of mind). Shipping costs are non-refundable. If you receive a refund, the cost of return shipping will be deducted from your total refund amount.
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">How do I cancel my order?</h3>
                            <p class="text-gray-700 leading-relaxed">
                                You can cancel your order if it has not been fulfilled yet, <strong>within one hour of placing the order</strong>. Please contact us at 
                                <a href="mailto:hello@scentsnsmile.com" class="text-[#e8a598] hover:underline font-semibold">hello@scentsnsmile.com</a> 
                                as soon as possible, during our business hours (10:00 AM – 7:00 PM IST). We cannot process cancellation requests outside of these hours.
                            </p>
                        </div>
                    </div>

                    <!-- Delivery & Store Location -->
                    <div id="delivery-store" class="scroll-mt-24">
                        <h2 class="text-3xl font-black mb-6 text-gray-900">📦 Ordering, Delivery & Store Location</h2>
                        
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Do You Offer Cash on Delivery (COD)?</h3>
                            <p class="text-gray-700 leading-relaxed mb-3">
                                Yes, we do offer Cash on Delivery (COD) for your convenience. Please note:
                            </p>
                            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-xl">
                                <p class="text-gray-800">
                                    For orders above <strong>₹15,000</strong>, we request a 50% advance payment to ensure a smooth and secure delivery process.
                                </p>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">I haven't received my order, can you help?</h3>
                            <p class="text-gray-700 leading-relaxed mb-4">
                                Please check the tracking link for details regarding your delivery. If the tracking information is unclear:
                            </p>
                            <ul class="space-y-2 text-gray-700 mb-4">
                                <li class="flex items-start">
                                    <span class="text-[#e8a598] mr-2">•</span>
                                    <span>As most couriers offer non-contact service, they are likely to leave your parcel in a safe place or with a neighbor.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-[#e8a598] mr-2">•</span>
                                    <span>Our couriers will complete a detailed investigation for claims of non-delivery. If delivery is found to be non-compliant, we will resend your order.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-[#e8a598] mr-2">•</span>
                                    <span>All cases of non-delivery must be reported within <strong>7 days</strong> of the delivery date.</span>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">Do you have any physical outlets?</h3>
                            <p class="text-gray-700 leading-relaxed mb-4">
                                Yes, we do! Scents N' Smile™ has two physical outlets in Mumbai.
                            </p>
                            <div class="bg-gradient-to-br from-[#e8a598] to-[#d89588] rounded-xl p-6 text-white">
                                <p class="text-lg font-semibold mb-2">Visit Our Perfume Studio</p>
                                <p class="text-white/95 mb-4">Experience our fragrances in person and get personalized recommendations from our experts.</p>
                                <a href="#" class="inline-block bg-white text-[#e8a598] font-bold px-6 py-3 rounded-full hover:bg-gray-100 transition-all">
                                    Get Directions →
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Still Curious -->
                    <div id="contact-form" class="scroll-mt-24">
                        <h2 class="text-3xl font-black mb-6 text-gray-900">💬 Still Curious? We're Here to Help!</h2>
                        
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
                            <p class="text-lg text-gray-700 leading-relaxed mb-8">
                                Didn't find the answer you were looking for? Don't hesitate to reach out! We're dedicated to ensuring you find the perfect fragrance with a smile.
                            </p>

                            <!-- Contact Methods -->
                            <div class="flex flex-wrap justify-center gap-4">
                                <a href="mailto:hello@scentsnsmile.com" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-6 py-3 rounded-full transition-all">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-900 font-semibold">Email Us</span>
                                </a>
                                <a href="https://wa.me/919876543210" target="_blank" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-full transition-all">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    <span class="font-semibold">WhatsApp</span>
                                </a>
                                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-[#e8a598] hover:bg-[#d89588] text-white px-6 py-3 rounded-full transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-semibold">Contact Page</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for sidebar navigation
    const navLinks = document.querySelectorAll('aside a[href^="#"]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                
                // Update active state
                navLinks.forEach(l => l.classList.remove('text-[#e8a598]', 'border-[#e8a598]'));
                this.classList.add('text-[#e8a598]', 'border-[#e8a598]');
            }
        });
    });

    // Highlight active section on scroll
    const sections = document.querySelectorAll('[id]');
    const observerOptions = {
        root: null,
        rootMargin: '-100px 0px -66%',
        threshold: 0
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.getAttribute('id');
                navLinks.forEach(link => {
                    link.classList.remove('text-[#e8a598]', 'border-[#e8a598]');
                    if (link.getAttribute('href') === '#' + id) {
                        link.classList.add('text-[#e8a598]', 'border-[#e8a598]');
                    }
                });
            }
        });
    }, observerOptions);

    sections.forEach(section => {
        if (section.id) {
            observer.observe(section);
        }
    });
});
</script>
@endsection
