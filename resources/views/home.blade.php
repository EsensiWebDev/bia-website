@extends('layouts.app')

@section('content')
    <!-- resources/views/components/hero.blade.php -->
    <div class="home">
        <section class="hero relative w-full h-screen">
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img src="{{ Vite::asset('resources/images/hero-home.webp') }}" alt="Dental Hero"
                    class="w-full h-full object-cover">
                <!-- Overlay -->
                <div class="absolute inset-0 bg-[#00000070]"></div>
            </div>

            <!-- Hero Content -->
            <div
                class="relative z-10 flex flex-col justify-center items-start h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="font-signika  text-white text-4xl sm:text-5xl md:text-6xl font-bold leading-tight mb-4">
                    Transform Your Smile, <br>
                    From Missing To Meaningful
                </h1>
                <p class="text-white text-lg sm:text-xl max-w-xl mb-6">
                    We offer smile transformations through pain-free treatments so you can feel confident and live fully
                    again.
                </p>
                <div class="flex space-x-4">
                    <a href="#meet-dentist"
                        class="bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                        MEET THE DENTIST
                    </a>
                </div>
            </div>
        </section>
        <section class="about bg-white relative w-full">
            <div class="container mx-auto px-6 lg:px-20 py-16  flex flex-col lg:flex-row items-center gap-12">
                <!-- Text Content -->
                <div class="lg:w-1/2">
                    <h2 class="text-3xl font-signika font-semibold mb-6">About Us</h2>
                    <p class="text-gray-700 mb-4">
                        At BIA Dental Center, we believe that transforming your smile means restoring your confidence and
                        enhancing your quality of life.
                        Specialized in <span class="font-bold">Smile Makeovers</span> and <span class="font-bold">Full Mouth
                            Rehabilitation</span>, we've helped
                        <span class="font-bold">25,000++ local and international patients</span> achieve life-changing
                        results—all delivered with international dentistry standards.
                    </p>
                    <p class="text-gray-700 mb-4">
                        We also offer a comprehensive range of dental treatments, from <span class="font-bold">basic
                            care</span> to <span class="font-bold">advanced procedures</span>,
                        such as Crown, Veneer, Single Implant, Multiple Dental Implant, All on 4/X, Braces, Invisalign, Root
                        Canal, and many more.
                        All dental treatments are supported by the latest technology and state-of-the-art facilities.
                    </p>
                    <p class="text-gray-700 mb-6">
                        Most importantly, we're committed to providing <span class="font-bold">gentle and pain-free dental
                            experiences</span>, especially for those with dental anxiety.
                        From your first visit to your final result, our highly skilled and competent dentists ensure you
                        feel safe, calm, and confident every step of the way.
                    </p>
                    <a href="#meet-dentist"
                        class="inline-block bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                        MEET THE DENTIST
                    </a>
                </div>

                <!-- Image -->
                <div class="lg:w-1/2 flex flex-col justify-end lg:justify-start items-center">
                    <img src="{{ Vite::asset('resources/images/doctor-photo.webp') }}" alt="Dentist"
                        class="shadow-lg h-full w-full lg:max-w-sm lg:mt-[-13em] mt-0">
                    <div class="absolute flex flex-col gap-4 right-10 lg:top-5 sm:top-100">
                        <a href="#"
                            class="bg-[#D9D9D9] hover:bg-[#C1C1C1] text-white rounded-full w-24 h-24 flex items-center justify-center font-semibold text-center transition-all duration-300">
                            <span class="leading-tight">Virtual <br>360</span></a>
                        <a href="#"
                            class="bg-[#D9D9D9] hover:bg-[#C1C1C1] text-white rounded-full w-24 h-24 flex items-center justify-center font-semibold text-center transition-all duration-300">
                            <span class="leading-tight">Virtual <br>360</span></a>
                    </div>
                </div>

            </div>
        </section>

    </div>
@endsection
