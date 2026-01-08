@props(['card'])

<div
    class="group block bg-gradient-to-br from-gray-50 to-gray-100/80 rounded-2xl p-3 shadow-md hover:shadow-xl transition-all duration-300 border border-gray-200/60 hover:border-gray-300 h-full">
    <a href="{{ $card->button_link ?? '#' }}"
        class="block w-full h-full relative rounded-xl overflow-hidden aspect-[3/4]">
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
                <h3 class="text-2xl font-black mb-3 {{ $card->text_color === 'light' ? 'text-white' : 'text-gray-900' }}">
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