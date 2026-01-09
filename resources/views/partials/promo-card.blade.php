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
        <div x-show="showModal" style="display: none;" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-[100] flex items-center justify-center p-4">

            {{-- Backdrop --}}
            <div @click="showModal = false" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

            {{-- Modal Content --}}
            <div
                class="relative w-full max-w-6xl bg-[#e5e9d9] rounded-2xl overflow-hidden shadow-2xl flex flex-col md:flex-row max-h-[90vh]">

                {{-- Close Button --}}
                <button @click="showModal = false"
                    class="absolute top-4 right-4 z-20 text-gray-800 hover:text-black font-bold text-sm underline z-30">
                    Close
                </button>

                {{-- Left Side: Image/Background --}}
                <div class="w-full md:w-3/5 relative min-h-[300px] md:min-h-full">
                    @if($card->modal_image_url)
                        <img src="{{ $card->modal_image_url }}" alt="{{ $card->modal_title }}"
                            class="absolute inset-0 w-full h-full object-cover">
                    @else
                        <div class="absolute inset-0 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif
                </div>

                {{-- Right Side: Content --}}
                <div
                    class="w-full md:w-2/5 p-8 md:p-12 flex flex-col justify-center items-center text-center bg-gradient-to-br from-[#f8f9f0] to-[#e5e9d9]">

                    @if($card->modal_title)
                        <div class="bg-white px-8 py-4 rounded-2xl shadow-sm mb-6 max-w-sm">
                            <h2 class="text-2xl md:text-3xl font-black text-gray-900 leading-tight">
                                {!! nl2br(e($card->modal_title)) !!}
                            </h2>
                        </div>
                    @endif

                    @if($card->modal_description)
                        <div class="bg-[#fcfbf9] px-8 py-6 rounded-2xl shadow-sm w-full max-w-sm">
                            <div class="prose prose-sm text-gray-700">
                                {!! $card->modal_description !!}
                            </div>
                        </div>
                    @endif

                    @if($card->modal_button_text && $card->modal_button_link)
                        <a href="{{ $card->modal_button_link }}"
                            class="mt-8 px-10 py-3 bg-[#ee7562] text-white font-bold rounded-full hover:bg-[#d6604d] transition-colors shadow-lg transform hover:scale-105 active:scale-95">
                            {{ $card->modal_button_text }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>