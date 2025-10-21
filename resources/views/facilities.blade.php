@extends('layouts.app')

@section('content')
    <!-- resources/views/components/hero.blade.php -->
    <div id="facilities" class="facilities">
        <!-- Hero Section -->
        <section class="hero relative w-full h-screen">
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img src="{{ Vite::asset('resources/images/facilities/banner.webp') }}" alt="Facilities Bia Dental Hero"
                    class="w-full h-full object-cover">
                <!-- Overlay -->
                <div class="absolute inset-0 bg-[#00000070]"></div>
            </div>

            <!-- Hero Content -->
            <div
                class="relative z-10 flex flex-col justify-center items-center h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-baseline gap-4">
                    {{-- <div class="hidden md:block w-12 h-[3px] bg-white"></div> --}}
                    <div class="text-center md:text-center ">
                        <h1 class="font-signika text-white text-3xl sm:text-5xl md:text-6xl font-bold leading-tight">
                            Facilities
                        </h1>
                        <p class="text-white text-md sm:text-xl max-w-xl mb-6 mt-2">
                            With facilities like BIA Anesthesia, BIA Farma, BIA X-Ray, and BIA Dental Lab, you can complete
                            your treatment here. No outside referrals needed.
                        </p>

                    </div>
                </div>

            </div>
        </section>

        <!-- BIA Anesthesia Section -->
        <section class="anesthesia bg-[#D9D5CB] relative w-full">
            <div class="container mx-auto px-6 lg:px-20 pt-16 pb-48 flex flex-col lg:flex-row items-center gap-12">
                <!-- Text Content -->
                <div class="lg:w-1/2">
                    <h2 class="text-4xl font-[400] mb-6">BIA Anesthesia</h2>
                    <p class="text-gray-700 mb-4">
                        BIA Anesthesia provides a safe, sterile environment for administering both local and general
                        anesthesia, designed to ensure a pain-free and stress-free experience. This facility is especially
                        beneficial for patients with dental anxiety or those undergoing complex procedures such as surgeries
                        or implants. Our experienced anesthesiologist team is committed to your comfort and safety, helping
                        ease fears and making your visit as calm and reassuring as possible.
                    </p>
                </div>

                <!-- Image -->
                <div class="lg:w-1/2 flex flex-col justify-end lg:justify-start items-end">
                    <div class="relative inline-block">
                        <div class="relative">
                            <div class="absolute inset-0 border-2 border-white translate-x-4 translate-y-4 z-10"></div>
                            <img src="{{ Vite::asset('resources/images/facilities/bia_anesthesia.webp') }}"
                                alt="Facilities Bia Anesthesia"
                                class="relative shadow-lg w-full lg:max-w-sm lg:mt-[-13em] mt-0">
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <!-- BIA Farma Section -->
        <section class="farma bg-white relative w-full">
            <div
                class="container mx-auto px-6 lg:px-20 pt-16 pb-48 flex flex-col-reverse lg:flex-row-reverse items-center gap-12">
                <!-- Text Content -->
                <div class="lg:w-1/2">
                    <h2 class="text-4xl font-[400] mb-6">BIA Farma</h2>
                    <p class="text-gray-700 mb-4">
                        BIA Anesthesia provides a safe, sterile environment for administering both local and general
                        anesthesia, designed to ensure a pain-free and stress-free experience. This facility is especially
                        beneficial for patients with dental anxiety or those undergoing complex procedures such as surgeries
                        or implants. Our experienced anesthesiologist team is committed to your comfort and safety, helping
                        ease fears and making your visit as calm and reassuring as possible.
                    </p>
                </div>

                <!-- Image -->
                <div class="lg:w-1/2 flex flex-col justify-start lg:justify-start items-start">
                    <div class="relative inline-block">
                        <div class="relative">
                            <div class="absolute inset-0 border-2 border-white translate-x-4 translate-y-4 z-10"></div>
                            <img src="{{ Vite::asset('resources/images/facilities/bia_farma.webp') }}"
                                alt="Facilities Bia Farma" class="relative shadow-lg w-full lg:max-w-sm lg:mt-[-13em] mt-0">
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- BIA X-Ray Section -->
        <section class="x-ray bg-[#F1F1F1] relative w-full">
            <div class="container mx-auto px-6 lg:px-20 pt-16 pb-48 flex flex-col lg:flex-row items-center gap-12">
                <!-- Text Content -->
                <div class="lg:w-1/2">
                    <h2 class="text-4xl font-[400] mb-6">BIA X-Ray</h2>
                    <p class="text-gray-700 mb-4">
                        BIA Anesthesia provides a safe, sterile environment for administering both local and general
                        anesthesia, designed to ensure a pain-free and stress-free experience. This facility is especially
                        beneficial for patients with dental anxiety or those undergoing complex procedures such as surgeries
                        or implants. Our experienced anesthesiologist team is committed to your comfort and safety, helping
                        ease fears and making your visit as calm and reassuring as possible.
                    </p>
                </div>

                <!-- Image -->
                <div class="lg:w-1/2 flex flex-col justify-end lg:justify-start items-end">
                    <div class="relative inline-block">
                        <div class="relative">
                            <div class="absolute inset-0 border-2 border-white translate-x-4 translate-y-4 z-10"></div>
                            <img src="{{ Vite::asset('resources/images/facilities/bia_xray.webp') }}"
                                alt="Facilities Bia X-Ray" class="relative shadow-lg w-full lg:max-w-sm lg:mt-[-13em] mt-0">
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- BIA Dental Lab Section -->
        <section class="dental-lab bg-white relative w-full">
            <div
                class="container mx-auto px-6 lg:px-20 py-16 flex flex-col-reverse lg:flex-row-reverse items-center gap-12">
                <!-- Text Content -->
                <div class="lg:w-1/2">
                    <h2 class="text-4xl font-[400] mb-6">BIA Dental Lab</h2>
                    <p class="text-gray-700 mb-4">
                        BIA Anesthesia provides a safe, sterile environment for administering both local and general
                        anesthesia, designed to ensure a pain-free and stress-free experience. This facility is especially
                        beneficial for patients with dental anxiety or those undergoing complex procedures such as surgeries
                        or implants. Our experienced anesthesiologist team is committed to your comfort and safety, helping
                        ease fears and making your visit as calm and reassuring as possible.
                    </p>
                </div>

                <!-- Image -->
                <div class="lg:w-1/2 flex flex-col justify-start lg:justify-start items-start">
                    <div class="relative inline-block">
                        <div class="relative">
                            <div class="absolute inset-0 border-2 border-white translate-x-4 translate-y-4 z-10"></div>
                            <img src="{{ Vite::asset('resources/images/facilities/bia_dental_lab.webp') }}"
                                alt="Facilities Bia Dental Lab"
                                class="relative shadow-lg w-full lg:max-w-sm lg:mt-[-13em] mt-0">
                        </div>
                    </div>
                </div>

            </div>
        </section>

        {{-- Gallery Section --}}
        <section class="gallery-facilities bg-[#F1F1F1] py-16">
            <div class="container mx-auto px-6 lg:px-20 py-16 flex flex-col items-center">
                <h2 class="text-4xl font-[400] mb-6">Gallery</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                    <div class="group relative shadow-md hover:shadow-lg transition w-full block">
                        <div class="overflow-hidden h-min-[600px]">
                            <img src="{{ Vite::asset('resources/images/facilities/facilitiesgallery_1.webp') }}"
                                alt="Gallery Facilities 1 Bia Dental"
                                class="w-full h-full object-cover group-hover:scale-105 transition">
                        </div>
                    </div>

                    <div class="group relative shadow-md hover:shadow-lg transition w-full block">
                        <div class="overflow-hidden h-min-[600px]">
                            <img src="{{ Vite::asset('resources/images/facilities/facilitiesgallery_2.webp') }}"
                                alt="Gallery Facilities 2 Bia Dental"
                                class="w-full h-full object-cover group-hover:scale-105 transition">
                        </div>
                    </div>

                    <div class="group relative shadow-md hover:shadow-lg transition w-full block">
                        <div class="overflow-hidden h-min-[600px]">
                            <img src="{{ Vite::asset('resources/images/facilities/facilitiesgallery_3.webp') }}"
                                alt="Gallery Facilities 3 Bia Dental"
                                class="w-full h-full object-cover group-hover:scale-105 transition">
                        </div>
                    </div>

                    <div class="group relative shadow-md hover:shadow-lg transition w-full block">
                        <div class="overflow-hidden h-min-[600px]">
                            <img src="{{ Vite::asset('resources/images/facilities/facilitiesgallery_4.webp') }}"
                                alt="Gallery Facilities 4 Bia Dental"
                                class="w-full h-full object-cover group-hover:scale-105 transition">
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>
@endsection
