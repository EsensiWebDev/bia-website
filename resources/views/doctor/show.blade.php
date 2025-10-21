@extends('layouts.app')

@section('content')
    <!-- First About Doctor Section -->
    <section class="first-about-doctor bg-white relative w-full mt-16">

        <div class="container mx-auto flex flex-col px-6 lg:px-20 py-24 gap-6 md:gap-12">

            <div class="container  hover:text-gray-300 font-medium m-auto">
                <a href='{{ route('about') }}' class=''>
                    < BACK</a>
            </div>
            <div class="flex flex-col lg:flex-row items-center gap-12 md:gap-24">
                <!-- Image -->
                <div class="w-full md:w-2/5 flex flex-col lg:flex-row justify-center lg:justify-start">
                    <h2 class="block md:hidden text-4xl font-signika text-[#203B6E] font-bold mb-2">{{ $doctor->name }}</h2>
                    <p class="block md:hidden text-3xl text-[#414141] mb-6 font-signika">{{ $doctor->position }}</p>
                    <img src="{{ asset('storage/' . $doctor->thumbnail_profile) }}" alt="Achievements BIA"
                        class="shadow-lg h-[600px] w-full object-cover">
                </div>

                <!-- Text Content -->
                <div class="w-full md:w-3/5">
                    <h2 class="hidden md:block text-5xl font-signika text-[#203B6E] font-bold mb-2">{{ $doctor->name }}</h2>
                    <p class="hidden md:block text-4xl text-[#414141] mb-6 font-signika">{{ $doctor->position }}</p>
                    <div class="w-full  text[#000000] mb-4">
                        {!! $doctor->desc !!}
                    </div>
                    <div class="language">
                        <h4 class="text-[#203B6E] font-montserrat font-bold">Language:</h4>
                        <p class="w-full  text[#000000]">{{ $doctor->language }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Second About Doctor Section -->
    <section class="second-about-doctor bg-[#D9D5CB] relative w-full mt-16">

        <div class="container mx-auto flex flex-col lg:flex-row items-center px-6 lg:px-20 py-24  gap-8 md:gap-18">

            <div class="w-full md:w-2/5 flex flex-col lg:flex-row justify-center lg:justify-end">
                <h2 class="text-4xl font-[400] font-signika text-[#203B6E] text-center md:text-right">Education
                    <br>Background
                </h2>
            </div>

            <!-- Text Content -->
            <div class="w-full md:w-3/5">
                @php
                    $educations = $doctor->educations->sortByDesc('graduation_year')->values();
                @endphp
                @if ($educations->isEmpty())
                    <p class="text-center text-gray-500">No Education Background Found.</p>
                @else
                    @foreach ($educations as $index => $education)
                        <ul>
                            <li class="text-[#000000] font-bold">
                                {{ $education->education_title }}
                                <span class="font-medium">| {{ $education->graduation_year }}</span>
                            </li>
                        </ul>

                        {{-- Tambahkan HR kecuali untuk item terakhir --}}
                        @if ($index !== $educations->count() - 1)
                            <hr class="my-3 border-[#000000]">
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Third About Doctor Section -->
    <section class="third-about-doctor bg-white relative w-full">

        <div class="container mx-auto flex flex-col-reverse lg:flex-row items-center px-6 lg:px-20 py-24  gap-8 md:gap-18">

            <!-- Text Content -->
            <div class="w-full md:w-3/5">
                @php
                    $certifications = $doctor->certifications->sortByDesc('certification_year')->values();
                @endphp
                @if ($certifications->isEmpty())
                    <p class="text-center text-gray-500">No Education Background Found.</p>
                @else
                    @foreach ($certifications as $index => $certification)
                        <ul>
                            <li class="text-[#000000] font-bold">
                                {{ $certification->certification_title }}
                                <span class="font-medium">| {{ $certification->certification_year }}</span>
                            </li>
                        </ul>

                        {{-- Tambahkan HR kecuali untuk item terakhir --}}
                        @if ($index !== $certifications->count() - 1)
                            <hr class="my-3 border-[#000000]">
                        @endif
                    @endforeach
                @endif
            </div>


            <div class="w-full md:w-2/5 flex flex-col lg:flex-row justify-center">
                <h2 class="text-4xl font-[400] font-signika text-[#203B6E] text-center">Certifications</h2>
            </div>
        </div>
    </section>

    {{-- Fourth About Doctor Section --}}
    <section class="fourth-about-doctor bg-[#D9D5CB] relative w-full">

        <div class="max-w-7xl mx-auto items-center px-6 lg:px-20 pt-24 pb-14">
            <h2 class="text-4xl font-[400] font-signika text-[#000000] text-center mb-8 md:mb-10">Associations
            </h2>


            @php
                $associations = $doctor->associations->sortBy('order')->values();
                $count = $doctor->associations->count();
                $chunks = collect();

                // Jika total <= 4 maka jadikan satu chunk saja
                if ($count <= 4) {
                    $chunks->push($doctor->associations);
                } else {
                    // Jika lebih dari 4 <i class="fa-solid fa-arrow-right"></i> bagi per 3 item
                    $chunks = $doctor->associations->chunk(3);
                }
            @endphp
            <!-- Text Content -->
            @if ($doctor->associations->isEmpty())
                <p class="text-center text-gray-500">No Association Found.</p>
            @else
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
                        @foreach ($chunk as $association)
                            <div class="flex flex-col items-center text-center px-4">
                                @if ($association->img)
                                    <img src="{{ asset('storage/' . $association->img) }}" alt="{{ $association->desc }}"
                                        class="w-56 h-56 mb-4 object-contain">
                                @endif
                                @if ($association->show_name == 1)
                                    <div class="text-sm md:text-base text-[#273746] w-2/4 md:w-3/4">
                                        {!! $association->association_name !!}
                                    </div>
                                @else
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>
    </section>
@endsection
