@extends('layouts.app')


@section('content')
    <section
        class="bg-cover bg-center text-center text-white mt-24 py-16 px-4 min-h-[377px] flex flex-col justify-center relative">
        <div class="container mx-auto px-6 lg:px-20">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h1 class="w-full md:w-1/2 text-3xl md:text-5xl mx-auto font-signika text-[#000] mb-6 md:mb-10 break-words">
                    Career</h1>
                <p class="text-[#000000]">
                    We're hiring at BIA Dental Center! Join one of the best dental centers in Indonesia
                    with international standards. We are looking for passionate and professional
                    individuals to grow with us.
                </p>
            </div>

            @if ($Careers->isEmpty())
                <p class="text-center text-gray-500">No data found.</p>
            @else
                <!-- Career List -->
                <div class="px-6 lg:px-20 space-y-8 text-[#000000]">
                    <!-- Career Item -->
                    @foreach ($Careers as $career)
                        <div class="flex justify-between flex-col md:flex-row items-start border-b pb-8 mb-8">
                            <div class="w-full md:w-3/4 text-left">
                                <h3 class="text-3xl text-[#000000] font-semibold mb-4">
                                    {{ $career->career_title }}</h3>
                                <p class="text-[#000000]">
                                    {{ $career->short_desc }}
                                </p>
                            </div>
                            <a href="{{ route('career.show', $career->slug) }}"
                                class="text-[#000000] text-2xl font-medium flex items-center hover:text-[#203B6E] h-[50px] md:h-auto">
                                Apply
                                <svg width="32px" height="85px" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M7 17L17 7M17 7H8M17 7V16" stroke="#000000" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="flex justify-center mt-10">
                {{ $Careers->onEachSide(1)->links('vendor.pagination.custom-tailwind') }}
            </div>
        </div>
    </section>
@endsection
