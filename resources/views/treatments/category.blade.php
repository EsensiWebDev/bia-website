@extends('layouts.app')

@section('content')
    <div class="treatment-category">

        {{-- After Header Section --}}
        <x-after-header stylesection="py-26 bg-white"
            subHeading='<p class="text-white text-md sm:text-xl max-w-3xl text-center m-auto">
        Dental implants are one of the most trusted solutions in modern tooth replacement.
        Designed to look, feel, and function like natural teeth, implants offer a long-lasting
        alternative to removable dentures. <br><br>
        In more complex cases, the treatment may involve a longer timeline and multiple stages,
        with additional procedures sometimes required to achieve the best possible outcome.</p>' />


        {{-- Section Flow Section --}}
        <section class="flow-treatments
            bg-white relative w-full py-16">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h1 class=" text-[#203B6E] text-4xl font-[400] mb-12">Flow of our treatments</h1>

                <!-- Flow Steps -->
                <div class="flex flex-col md:flex-row md:space-x-24 items-center justify-around">

                    <div class="relative flex flex-col md:py-0 py-4 items-center md:flex-row">
                        <div class="flex flex-col items-center text-center">
                            <img src="{{ Vite::asset('resources/images/treatments/flow-1.webp') }}"
                                class="w-20 h-20 md:size-[94px]" alt="">
                            <h3 class="font-montserrat font-bold text-lg md:text-xl mt-2">Consultation <br>& Diagnosis</h3>
                        </div>
                        <span
                            class="absolute md:right-[-10rem] md:top-1/2 md:w-32 md:h-[3px] md:bg-[#343A40]
                      md:block hidden"></span>
                        <span class="absolute md:hidden bottom-[-4rem] left-1/2 w-[2px] h-16 bg-[#343A40]"></span>
                    </div>

                    <div class="relative flex flex-col md:py-0 py-4 items-center md:flex-row mt-16 md:mt-0">
                        <div class="flex flex-col items-center text-center">
                            <img src="{{ Vite::asset('resources/images/treatments/flow-2.webp') }}"
                                class="w-20 h-20 md:size-[94px]" alt="">
                            <h3 class="font-montserrat font-bold text-lg md:text-xl mt-2">Pre-Treatment</h3>
                        </div>
                        <span
                            class="absolute md:right-[-10rem] md:top-1/2 md:w-32 md:h-[3px] md:bg-[#343A40]
                      md:block hidden"></span>
                        <span class="absolute md:hidden bottom-[-4rem] left-1/2 w-[2px] h-16 bg-[#343A40]"></span>
                    </div>

                    <div class="relative flex flex-col md:py-0 py-4 items-center md:flex-row mt-16 md:mt-0">
                        <div class="flex flex-col items-center text-center">
                            <img src="{{ Vite::asset('resources/images/treatments/flow-3.webp') }}"
                                class="w-20 h-20 md:size-[94px]" alt="">
                            <h3 class="font-montserrat font-bold text-lg md:text-xl mt-2">Dental Procedure</h3>
                        </div>
                        <span
                            class="absolute md:right-[-10rem] md:top-1/2 md:w-32 md:h-[3px] md:bg-[#343A40]
                      md:block hidden"></span>
                        <span class="absolute md:hidden bottom-[-4rem] left-1/2 w-[2px] h-16 bg-[#343A40]"></span>
                    </div>

                    <div class="flex flex-col items-center mt-16 md:mt-0">
                        <img src="{{ Vite::asset('resources/images/treatments/flow-4.webp') }}"
                            class="w-20 h-20 md:size-[94px]" alt="">
                        <h3 class="font-montserrat font-bold text-lg md:text-xl mt-2">Recovery</h3>
                    </div>

                </div>
            </div>
        </section>

        <!-- Available Treatments Section -->
        <x-available-treatments stylesection="bg-[#F1F1F1] pt-16 pb-24" title="Treatments Available"
            titleColor="text-[#203B6E]" />

        {{-- CTA Section --}}
        <x-cta-section stylesection="py-26 bg-white" />
    </div>
@endsection
