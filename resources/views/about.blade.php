@extends('layouts.app')

@section('content')
    {{-- After Header Section --}}
    <x-after-header styleSection="py-48" title="About Us"
        subHeading="<div class='mt-5 flex md:flex-row flex-wrap gap-3 md:gap-5 justify-center'></div>"
        backUrl="<a href='#' class='hidden absolute top-8 left-6'></a>" />

    <!-- About Us Section -->
    <section class="about bg-[#F1F1F1] relative w-full">
        <div class="container mx-auto px-6 lg:px-20 py-16  flex flex-col lg:flex-row items-center gap-12">
            <!-- Text Content -->
            <div class="lg:w-1/2">
                <h2 class="text-4xl text-[#203B6E] font-[400] mb-6">Who We Are</h2>
                <p class="text-gray-700 mb-4">
                    Bali Implant Aesthetics (BIA) Dental Center is a leading dental clinic in Bali, specializing in Dental
                    Implants and Full Mouth Rehabilitation. We’re trusted by both domestic and international patients,
                    including public figures, for our commitment to high-quality, affordable care.
                </p>
                <p class="text-gray-700 mb-4">
                    Our collaborative team of experienced specialists, including implantologists, orthodontists, oral
                    surgeons, prosthodontic, pediatric, and endodontists, provides personalized treatment plans in a serene
                    and comfortable environment.
                </p>
                <p class="text-gray-700 mb-6">
                    We utilize state-of-the-art technology, including CBCT (3D X-rays), 3D intraoral scanners, and dental
                    microscopes, to ensure the best possible outcomes for every procedure, from crowns and implants to smile
                    makeovers.
                </p>

                <p class="text-gray-700 mb-6">To support comprehensive and efficient care, our clinic is equipped with
                    complete in-house facilities
                    such as BIA X-Ray, BIA Farma, BIA Dental Lab, and BIA Anesthesia, so you won’t need outside referrals.
                </p>

                <p class="text-gray-700 mb-6">We also understand that visiting the dentist isn’t easy for everyone. That’s
                    why we focus on gentle and
                    pain-free treatments, creating a space where you can feel safe, relaxed, and fully cared for from start
                    to finish.</p>
            </div>

            <!-- Image -->
            <div class="lg:w-1/2 flex flex-col justify-end lg:justify-start items-center">
                <div class="relative inline-block">
                    <div class="relative">
                        <div class="absolute inset-0 border-2 border-white translate-x-4 translate-y-4 z-10"></div>
                        <img src="{{ Vite::asset('resources/images/about-us1.webp') }}" alt="Dentist"
                            class="relative shadow-lg w-full lg:max-w-sm mt-0">
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- Our Doctors Section --}}
    <section class="before-after bg-white py-16 px-4 mb-0 md:mb-24">
        <div class="max-w-7xl mx-auto px-4">
            <div class="max-w-6xl mx-auto text-center mb-12">
                <h2 class="text-4xl font-[400] text-[#203B6E]">Our Team</h2>
            </div>

            {{-- === SLIDER UTAMA === --}}
            @if ($doctors->isEmpty())
                <p class="text-center text-gray-500">No teams found.</p>
            @else
                <div class="swiper ours-doctors overflow-hidden mb-10">
                    <div class="swiper-wrapper">
                        @foreach ($doctors as $doctor)
                            <div class="swiper-slide">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center px-8 md:px-12 ">
                                    {{-- Foto --}}
                                    <div class="flex justify-center">
                                        <img src="{{ asset('storage/' . $doctor->thumbnail_profile) }}"
                                            alt="{{ $doctor->thumbnail_alt_text ?? $doctor->name }}"
                                            class="object-cover h-[500px] w-full md:w-auto">
                                    </div>

                                    {{-- Detail --}}
                                    <div>
                                        <h3 class="text-4xl font-bold font-inter text-[#000] mb-2 md:mb-4">
                                            {{ $doctor->name }}
                                        </h3>
                                        <p class="text-2xl text-[#414141] font-inter">{{ $doctor->position }}</p>
                                        <div class="text-[#414141] leading-relaxed mb-6 mt-6 w-full md:w-3/4 min-h-46">
                                            {!! $doctor->short_desc !!}
                                        </div>
                                        <a href="{{ route('doctor.show', $doctor->slug) }}"
                                            class="inline-block bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                                            MORE
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Navigation -->
                    <div class="swiper-button-next !w-6 !h-6 !text-[#203B6E] stroke-[#203B6E]"></div>
                    <div class="swiper-button-prev !w-6 !h-6 !text-[#203B6E] stroke-[#203B6E]"></div>
                </div>
                {{-- === THUMBNAIL SLIDER === --}}
                <hr class="text-gray-300 mb-8">
                <div class="swiper doctors-thumbs overflow-hidden">
                    <div class="swiper-wrapper">
                        @foreach ($doctors as $doctor)
                            <div class="swiper-slide text-center cursor-pointer">
                                <img src="{{ asset('storage/' . $doctor->avatar) }}"
                                    alt="{{ $doctor->thumbnail_alt_text ?? $doctor->name }}"
                                    class="w-32 h-32 object-cover mx-auto border-2 border-transparent hover:border-blue-500 transition">
                                <h4 class="mt-3 font-semibold font-inter text-[#000]">{{ $doctor->name }}</h4>
                                <p class="text-[#414141]">{{ $doctor->position }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>


    <!-- Facilities Section -->
    <section class="facilities bg-[#F1F1F1] w-full py-16 px-6 lg:px-20">
        <div class="container mx-auto flex flex-col lg:flex-row items-center gap-12 md:gap-24">
            <!-- Text Content -->
            <div class="lg:w-1/2">
                <h2 class="text-4xl font-[400] mb-6">Facilities</h2>
                <p class="text-gray-700 mb-6 w-full md:w-3/4">
                    From diagnosis to recovery, everything happens in one place. With facilities like BIA
                    Anesthesia, BIA Farma, BIA X-Ray, and BIA Dental Lab, you can complete your treatment here.
                    No outside referrals needed.
                </p>
                <a href="{{ route(name: 'facilities') }}"
                    class="inline-block bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                    MORE
                </a>
            </div>

            <!-- Image -->
            <div class="w-full md:w-1/2 flex justify-center lg:justify-start">
                <div class="relative inline-block">
                    <div class="relative">
                        <div class="absolute inset-0 border-2 border-white translate-x-4 translate-y-4 z-10"></div>
                        <img src="{{ Vite::asset('resources/images/facilities.webp') }}" alt="BIA Facilities"
                            class="shadow-lg w-full max-w-2xl lg:mt-[-8em] mt-0">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievements & Certifications Section -->
    <section class="achivement bg-[#F1F1F1] relative w-full mt-16">
        <div class="container mx-auto px-6 lg:px-20 py-16 flex flex-col lg:flex-row items-center gap-12 md:gap-24">
            <!-- Image -->
            <div class="w-full md:w-1/2 flex justify-center lg:justify-start">
                <img src="{{ Vite::asset('resources/images/achievement.webp') }}" alt="Achievements BIA"
                    class="shadow-lg w-full">
            </div>

            <!-- Text Content -->
            <div class="lg:w-1/2">
                <h2 class="text-4xl font-[400] mb-6">Achievements &<br> Certifications</h2>
                <p class="w-full  text-gray-700 mb-4">
                    Behind our treatments is a team of doctors with proven skills and global certifications, dedicated to
                    delivering the best care and results at the highest standards.
                </p>
                <a href="{{ route(name: 'achievements.index') }}"
                    class="inline-block bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                    MORE
                </a>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <x-cta-section stylesection="py-26 bg-white" titleColor="text-[#343A40]"
        title="Ready To Transform Your Smile and Live Happier?" btnUrl="{{ route('booknow') }}"
        btnText="MEET THE DENTIST" />
@endsection
