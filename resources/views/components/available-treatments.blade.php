<section class="available-treatments {{ $stylesection }}">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-[400] font-signika {{ $titleColor }} mb-12">{{ $title }}</h2>

        @php
            $count = $treatments ? $treatments->count() : 0;
        @endphp
        @if ($count === 0)
            <p class="text-center text-gray-500">Not Treatment Found</p>
        @else
            @php
                $chunks = $treatments->chunk(3);
            @endphp
            @foreach ($chunks as $chunk)
                @php
                    $chunkCount = $chunk->count();

                    $containerClass = match ($chunkCount) {
                        1, 2 => 'flex flex-col md:flex-row justify-center gap-10 pt-0 md:pt-8',
                        default => 'grid grid-cols-1 md:grid-cols-3 gap-10 mb-14',
                    };

                    $itemClass = match ($chunkCount) {
                        1, 2 => 'group relative shadow-md hover:shadow-lg transition w-full md:w-1/3 block',
                        default => 'group relative shadow-md hover:shadow-lg transition w-full block',
                    };
                @endphp

                <div class="{{ $containerClass }}">
                    @foreach ($chunk as $treatment)
                        @php
                            $href = isset($category)
                                ? route('treatments.show', ['category' => $category->slug, 'slug' => $treatment->slug])
                                : route('treatments.treatments', ['category' => $treatment->slug]);
                        @endphp

                        <a href="{{ $href }}" class="{{ $itemClass }}">
                            <div class="overflow-hidden h-[300px]">
                                <img src="{{ asset('storage/' . $treatment->thumbnail) }}"
                                    alt="{{ $treatment->thumbnail_alt_text = $treatment->thumbnail_alt_text ?: 'Treatment Bia Dental' }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition">
                            </div>
                            <div
                                class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-[#7DB8D8] text-white px-5 py-2 font-semibold text-md uppercase tracking-wide shadow-lg max-w-[350px] break-words whitespace-normal">
                                {{ explode('/', $treatment->title)[0] }}
                            </div>
                        </a>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
</section>
