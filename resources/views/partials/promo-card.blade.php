@props(['card'])

<div x-data="{ showModal: false }" class="h-full">
    <div
        class="group block bg-gradient-to-br from-gray-50 to-gray-100/80 rounded-2xl p-3 shadow-md hover:shadow-xl transition-all duration-300 border border-gray-200/60 hover:border-gray-300 h-full">
        <a href="{{ $card->action_type === 'modal' ? '#' : ($card->button_link ?? '#') }}"
            @if($card->action_type === 'modal') @click.prevent="showModal = true" @endif
            class="block w-full h-full relative rounded-xl overflow-hidden aspect-[3/4] cursor-pointer">
            {{-- Media --}}
            <div class="absolute inset-0">
                @if($card->type === 'video')
                    <video src="{{ $card->media_url }}" class="w-full h-full object-cover" autoplay muted loop playsinline
                        poster="{{ $card->thumbnail_url }}">
                    </video>
                @else
                    <img src="{{ $card->media_url }}" alt="{{ $card->name }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                @endif

                {{-- Overlay --}}
                <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors"></div>
            </div>

            {{-- Content --}}
            <div class="absolute inset-0 p-6 flex flex-col justify-end text-center items-center z-10">
                @if($card->subtitle)
                    <p
                        class="text-xs font-bold uppercase tracking-wider mb-2 {{ $card->text_color === 'light' ? 'text-white/90' : 'text-gray-900/90' }}">
                        {{ $card->subtitle }}
                    </p>
                @endif

                @if($card->title)
                    <h3
                        class="text-2xl font-black mb-3 {{ $card->text_color === 'light' ? 'text-white' : 'text-gray-900' }}">
                        {{ $card->title }}
                    </h3>
                @endif

                @if($card->description)
                    <p
                        class="text-sm line-clamp-2 mb-4 {{ $card->text_color === 'light' ? 'text-white/80' : 'text-gray-800/80' }}">
                        {{ $card->description }}
                    </p>
                @endif

                @if($card->button_text)
                    <span
                        class="inline-flex items-center px-6 py-2.5 rounded-full text-xs font-bold uppercase tracking-wide transition-all duration-300 transform group-hover:-translate-y-1 {{ $card->text_color === 'light' ? 'bg-white text-gray-900 hover:bg-gray-100' : 'bg-black text-white hover:bg-gray-900' }}">
                        {{ $card->button_text }}
                    </span>
                @endif
            </div>
        </a>
    </div>

    {{-- Modal --}}
    @if($card->action_type === 'modal')
        <div x-show="showModal" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-8">
            
            {{-- Backdrop --}}
            <div @click="showModal = false" class="absolute inset-0 bg-black/40 backdrop-blur-md transition-opacity"></div>

            {{-- Modal Content Wrapper --}}
            <div class="relative w-full max-w-7xl h-[85vh] bg-gray-100 rounded-[2rem] overflow-hidden shadow-2xl flex flex-col md:flex-row">
                
                {{-- Close Button --}}
                <button @click="showModal = false" class="absolute top-6 right-8 z-50 text-gray-800 hover:text-black font-bold text-lg underline tracking-wide bg-white/50 px-3 py-1 rounded-lg backdrop-blur-sm hover:bg-white/80 transition-all">
                    Close
                </button>

                {{-- Full Background Image --}}
                <div class="absolute inset-0 z-0">
                    @if($card->modal_image_url)
                        <img src="{{ $card->modal_image_url }}" alt="{{ $card->modal_title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                            <span class="text-gray-400 font-bold text-xl">No Image Uploaded</span>
                        </div>
                    @endif
                </div>

                {{-- Content Container (Floating Overlay) --}}
                <div class="absolute inset-0 z-10 p-6 md:p-16 flex flex-col justify-center items-center md:items-end pointer-events-none">
                    <div class="w-full max-w-lg flex flex-col items-center md:items-end space-y-4 md:space-y-6 pointer-events-auto">
                        
                        @if($card->modal_title)
                        <div class="bg-white px-8 md:px-12 py-6 rounded-[2rem] shadow-xl transform md:rotate-1 transition-transform hover:rotate-0">
                            <h2 class="text-2xl md:text-4xl font-black text-gray-900 leading-tight text-center md:text-right">
                                {!! nl2br(e($card->modal_title)) !!}
                            </h2>
                        </div>
                        @endif

                        @if($card->modal_description)
                            <div class="bg-[#fcfbf9] px-8 md:px-10 py-6 md:py-8 rounded-[2rem] shadow-xl w-full">
                                <div class="prose prose-sm md:prose-base text-gray-700 text-center md:text-right">
                                    {!! $card->modal_description !!}
                                </div>
                            </div>
                        @endif

                        @if($card->modal_button_text && $card->modal_button_link)
                            <a href="{{ $card->modal_button_link }}" 
                               class="w-full md:w-auto text-center px-12 py-4 bg-[#ee7562] text-white font-black text-lg tracking-wide rounded-full hover:bg-[#d6604d] transition-all shadow-xl transform hover:scale-105 active:scale-95 shadow-orange-200">
                                {{ $card->modal_button_text }}
                            </a>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>