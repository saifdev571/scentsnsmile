@props(['items'])

@if($items->isNotEmpty())
    <div class="py-16 bg-[#f9f9f9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-10 font-heading">
                Join the <span class="font-handwriting text-5xl ml-2 transform -rotate-2 inline-block">ScentSmile</span>
                club
            </h2>

            <div class="relative group">
                <!-- Navigation Buttons (Desktop) -->
                <button
                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 bg-white rounded-full p-3 shadow-lg border border-gray-200 text-gray-800 hover:scale-110 transition-transform hidden md:flex items-center justify-center cursor-pointer"
                    id="social-slider-prev">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10 bg-white rounded-full p-3 shadow-lg border border-gray-200 text-gray-800 hover:scale-110 transition-transform hidden md:flex items-center justify-center cursor-pointer"
                    id="social-slider-next">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Slider Container -->
                <div class="flex overflow-x-auto gap-6 pb-8 snap-x snap-mandatory scrollbar-hide scroll-smooth"
                    id="social-slider">
                    @foreach($items as $item)
                        <!-- Card -->
                        <div
                            class="flex-none snap-center w-[280px] md:w-[320px] relative transition-transform duration-300 hover:scale-[1.02]">
                            <a href="{{ $item->external_link ?? '#' }}" target="{{ $item->external_link ? '_blank' : '_self' }}"
                                class="block relative aspect-[4/5] rounded-[2.5rem] overflow-hidden shadow-sm border border-gray-100 group-card">
                                <img src="{{ $item->image_url }}" alt="{{ $item->username }}"
                                    class="w-full h-full object-cover">

                                <!-- Pill Label -->
                                @if($item->username)
                                    <div
                                        class="absolute bottom-6 left-1/2 transform -translate-x-1/2 bg-white px-6 py-2.5 rounded-full shadow-md border border-gray-100 transition-all duration-300 group-card-hover:scale-105">
                                        <span
                                            class="text-xs font-bold uppercase tracking-wider text-gray-900 border-none">{{ $item->username }}</span>
                                    </div>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Font Logic (Quick inline for demo match) -->
    <style>
        .font-handwriting {
            font-family: 'Comic Sans MS', 'Chalkboard SE', sans-serif;
            /* Fallback for demo */
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slider = document.getElementById('social-slider');
            const prevBtn = document.getElementById('social-slider-prev');
            const nextBtn = document.getElementById('social-slider-next');

            if (slider && prevBtn && nextBtn) {
                prevBtn.addEventListener('click', () => {
                    slider.scrollBy({ left: -340, behavior: 'smooth' });
                });

                nextBtn.addEventListener('click', () => {
                    slider.scrollBy({ left: 340, behavior: 'smooth' });
                });
            }
        });
    </script>
@endif