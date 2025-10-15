@extends('layouts.app')

@section('content')
    <div class="treatment-details">

        <!-- Detail Treatments Section -->
        <section class="details bg-white relative w-full">
            <div
                class="container mt-24 mx-auto px-6 lg:px-20 py-16 flex flex-col-reverse md:flex-col lg:flex-row items-center gap-12 md:gap-24">
                <!-- Image -->
                <div class="w-full md:w-1/2 flex justify-center lg:justify-start">
                    <img src="{{ asset('storage/' . $treatment->thumbnail) }}" alt="{{ $treatment->thumbnail_alt_text }}"
                        class="shadow-lg w-full">
                </div>

                <!-- Text Content -->
                <div class="lg:w-1/2">
                    <h2 class="text-4xl font-[400] text-[#203B6E] mb-6 text-center md:text-left">{{ $treatment->title }}</h2>
                    <div class="w-full text-gray-700 mb-4">
                        {!! $treatment->desc !!}
                    </div>
                    <div class="text-center md:text-start">
                        <a href="{{ $treatment->contact ?? '#' }}"
                            class="inline-block bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                            MORE
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- Who Needs Treatment --}}
        @if ($treatment->whoNeeds->count() == 0)
        @else
            <section class="whoneed bg-[#E9E6DD] py-16">
                <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
                    <h2 class="text-4xl font-[400] text-[#203B6E] mb-6 md:mb-12 text-center">
                        Who Need This Treatment
                    </h2>

                    @php
                        $count = $treatment->whoNeeds->count();
                        $chunks = collect();

                        // Jika total <= 4 maka jadikan satu chunk saja
                        if ($count <= 4) {
                            $chunks->push($treatment->whoNeeds);
                        } else {
                            // Jika lebih dari 4 <i class="fa-solid fa-arrow-right"></i> bagi per 3 item
                            $chunks = $treatment->whoNeeds->chunk(3);
                        }
                    @endphp

                    @foreach ($chunks as $chunk)
                        @php
                            $chunkCount = $chunk->count();

                            // Tentukan grid layout berdasarkan jumlah item dalam chunk
                            $containerClass = match ($chunkCount) {
                                1 => 'flex justify-center gap-10 md:gap-16',
                                2 => 'flex flex-col md:flex-row justify-center gap-8 pt-0 md:pt-8',
                                3 => 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 md:gap-16',
                                4 => 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10 md:gap-16',
                                default => 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 md:gap-16',
                            };
                        @endphp

                        <div class="{{ $containerClass }} mb-10">
                            @foreach ($chunk as $need)
                                <div class="flex flex-col items-center text-center px-4">
                                    @if ($need->thumbnail)
                                        <img src="{{ asset('storage/' . $need->thumbnail) }}" alt="{{ $need->desc }}"
                                            class="w-16 h-16 mb-6 object-contain">
                                    @endif
                                    <div class="text-sm md:text-base text-[#273746] max-w-sm">
                                        {!! $need->desc !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Maintenance --}}
        <section class="maintenance-treatments bg-white relative w-full">
            <div class="container mx-auto px-6 lg:px-20 py-16 flex flex-col lg:flex-row items-center gap-0 md:gap-24">
                <!-- Text Content -->
                <div class="lg:w-1/2">
                    <h2 class="text-4xl font-[400] text-[#203B6E] mb-6 text-center">
                        Aftercare & <br> Maintenance
                    </h2>

                </div>

                <!-- Image -->
                <div class="lg:w-1/2 mx-3 md:mx-0">
                    <div class="detail-maintenance font-montserrat w-full text-gray-700 mb-4">
                        {!! $treatment->maintenance !!}
                    </div>
                </div>
            </div>
        </section>

        {{-- Treatment Time Frame Section --}}
        @if ($treatment->timeFrames->count() == 0)
        @else
            <section class="timeframe-treatments bg-white py-16 px-4 m-auto">
                <div class="max-w-7xl mx-auto text-center">
                    <h2 class="text-4xl font-[400] text-[#203B6E] md:mb-12 text-center">
                        Treatment Time Frame
                    </h2>

                    @foreach ($treatment->timeFrames as $frame)
                        @if ($frame->frame === 'arrow')
                            @php
                                $stageItems = $frame->stageItems->sortBy('order')->values();
                                $chunkCount = $stageItems->count();

                                $containerClass = match ($chunkCount) {
                                    1 => 'flex justify-center gap-10 lg:gap-16',
                                    2 => 'flex flex-col lg:flex-row justify-center gap-8 pt-0 lg:pt-8',
                                    3 => 'grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-16',
                                    4 => 'grid grid-cols-1 lg:grid-cols-4 gap-10 lg:gap-16',
                                    default => 'grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-16',
                                };

                                $columns = str_contains($containerClass, 'lg:grid-cols-4') ? 4 : 3;
                                $rows = $stageItems->chunk($columns);
                            @endphp

                            <div class="frame-arrow mb-12">
                                @if ($frame->show_stage == '0')
                                @else
                                    <div
                                        class="stage-title text-center {{ $frame->order == 1 ? 'mt-7' : 'mt-24' }} mb-6 md:mb-12 text-[#203B6E]">
                                        {!! $frame->stage !!}
                                    </div>
                                @endif

                                @foreach ($rows as $rowIndex => $rowItems)
                                    <div
                                        class="flex flex-col lg:flex-row justify-center items-stretch gap-8 lg:gap-4 mb-8 relative">
                                        @foreach ($rowItems as $index => $item)
                                            <div
                                                class="flex flex-col items-center justify-between text-center bg-white p-4 rounded-2xl h-full w-[90%] lg:w-[350px] mx-auto">
                                                <div>
                                                    <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                                        alt="{{ $item->title }}" class="w-20 h-20 mb-6 mx-auto">
                                                    <h4 class="text-2xl font-montserrat text-[#000] mb-4">
                                                        {!! $item->title !!}</h4>
                                                </div>
                                                <div class="text-md text-[#000000] text-center list-disc list-inside">
                                                    {!! $item->desc !!}
                                                </div>
                                            </div>

                                            @if (!$loop->last)
                                                <div
                                                    class="hidden lg:flex items-center justify-center text-[#203B6E] text-3xl mx-2">
                                                    <i class="fa-solid fa-arrow-right"></i>
                                                </div>
                                                <div
                                                    class="flex lg:hidden items-center justify-center text-[#203B6E] text-3xl my-4">
                                                    <i class="fa-solid fa-arrow-down"></i>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    @if ($rowIndex < $rows->count() - 1)
                                        <div class="flex justify-center mb-8">
                                            <i class="fa-solid fa-arrow-down text-[#203B6E] text-3xl"></i>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @elseif ($frame->frame === 'line')
                            <div class="frame-line mb-12">
                                @if ($frame->show_stage == '0')
                                @else
                                    <div
                                        class="stage-title text-center {{ $frame->order == 1 ? 'mt-7' : 'mt-24' }} mb-6 md:mb-12 text-[#203B6E]">
                                        {!! $frame->stage !!}
                                    </div>
                                @endif

                                <div class="space-y-16">
                                    @foreach ($frame->stageItems as $item)
                                        <div
                                            class="flex flex-col md:flex-row items-center md:items-center {{ !$loop->last ? 'border-b border-[#D9D9D9] pb-10' : '' }}">

                                            <div class="w-full md:w-1/3 flex flex-col items-center mb-6 md:mb-0">
                                                <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                                    alt="{{ $item->title }}" class="w-20 h-20 mb-4">
                                                <h4 class="w-full md:w-2/3 text-2xl font-montserrat text-[#000] mb-4">
                                                    {!! $item->title !!}
                                                </h4>
                                            </div>

                                            <div
                                                class="frame-line-treatment w-full md:w-2/3 text-center md:text-left px-4 flex flex-col justify-center">
                                                <div class="text-sm md:text-base text-[#273746]">
                                                    {!! $item->desc !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Additional Section --}}
        @if ($treatment->additionals->count() == 0)
        @else
            <section class="additional-treatments bg-white pb-16 px-4 m-auto">
                @php
                    $additionals = $treatment->additionals->sortBy('order')->values();
                    $count = $additionals->count();
                    $gridClass = match ($count) {
                        1 => 'grid-cols-1 justify-center',
                        2 => 'grid-cols-1 sm:grid-cols-2 justify-center',
                        3 => 'grid-cols-1 sm:grid-cols-2 md:grid-cols-3 justify-center',
                        default => 'grid-cols-1 sm:grid-cols-2 md:grid-cols-3 justify-center',
                    };
                @endphp
                <div class="max-w-5xl mx-auto text-center">
                    <div class="grid {{ $gridClass }} gap-10 md:gap-16 mb-10">
                        @foreach ($additionals as $item)
                            <div class="flex flex-col items-center text-center">
                                <div class="text-sm md:text-base text-justify text-[#000000] max-w-sm">
                                    {!! $item->desc !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

    </div>
@endsection
