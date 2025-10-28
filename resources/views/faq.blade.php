@extends('layouts.app')

@section('content')
    {{-- After Header Section --}}
    <x-after-header title="FAQ"
        subHeading="<div class='mt-5 flex md:flex-row flex-wrap gap-3 md:gap-5 justify-center'></div>"
        backUrl="<a href='#' class='hidden absolute top-8 left-6'></a>" />

    {{-- FAQ Section --}}
    <section class="faq-detail bg-white relative w-full">
        <div class="container mx-auto px-6 lg:px-20 py-16 flex flex-col-reverse lg:flex-row items-center gap-12">
            <!-- Text Content -->
            <div class="lg:w-1/2">
                <div class="w-full max-w-2xl mx-auto divide-y divide-gray-200">
                    <details class="faq group" data-img="{{ Vite::asset('resources/images/faq/faq1.webp') }}">
                        <summary
                            class="flex justify-between items-center cursor-pointer p-4 font-semibold text-gray-800 hover:text-[#203B6E]">
                            <p class="w-3/4">
                                How does BIA Dental Center ensure a high standard of care for every patient?
                            </p>
                            <svg class="w-5 h-5 text-gray-500 transition-transform duration-300 group-open:rotate-180"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="p-4 pt-0 text-[#000000]">
                            Because your health deserves nothing less than excellence. At BIA Dental Center, we follow
                            <strong>international clinical protocols</strong> in every procedure—ensuring not only excellent
                            results, but also your <strong>safety, precision,</strong> and <strong>overall mental wellbeing
                                from start to finish.</strong>
                        </div>
                    </details>

                    <details class="faq group" data-img="{{ Vite::asset('resources/images/faq/faq2.webp') }}">
                        <summary
                            class="flex justify-between items-center cursor-pointer p-4 font-semibold text-gray-800 hover:text-[#203B6E]">
                            <p class="w-3/4">
                                Why is it important to choose premium quality implant systems at BIA Dental Center?
                            </p>
                            <svg class="w-5 h-5 text-gray-500 transition-transform duration-300 group-open:rotate-180"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="p-4 pt-0 text-[#000000]">
                            Because your smile deserves to last a lifetime. At BIA Dental Center, we use only
                            <strong>globally trusted implant brands</strong> with a strong reputation for
                            <strong>safety, durability, and success.</strong> This ensures you get a
                            <strong>natural-looking, fully functional smile</strong>—built to last, and backed by science.
                        </div>
                    </details>

                    <details class="faq group" data-img="{{ Vite::asset('resources/images/faq/faq3.webp') }}">
                        <summary
                            class="flex justify-between items-center cursor-pointer p-4 font-semibold text-gray-800 hover:text-[#203B6E]">
                            <p class="w-3/4">
                                How does BIA Dental Center ensure clear and culturally sensitive communication with
                                patients?
                            </p>
                            <svg class="w-5 h-5 text-gray-500 transition-transform duration-300 group-open:rotate-180"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="p-4 pt-0 text-[#000000]">
                            We believe great care begins with great communication. That’s why our team is trained in
                            <strong>empathetic, bilingual communication,</strong> ensuring you feel <strong>heard,
                                understood,</strong> and respected at every step. No confusion, no barriers—just
                            <strong>honest, caring conversations that build trust</strong> and <strong>comfort.</strong>
                        </div>
                    </details>

                    <details class="faq group" data-img="{{ Vite::asset('resources/images/faq/faq4.webp') }}">
                        <summary
                            class="flex justify-between items-center cursor-pointer p-4 font-semibold text-gray-800 hover:text-[#203B6E]">
                            <p class="w-3/4">
                                Why is personalized and thoughtful treatment time important at BIA Dental Center?
                            </p>
                            <svg class="w-5 h-5 text-gray-500 transition-transform duration-300 group-open:rotate-180"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="p-4 pt-0 text-[#000000]">
                            Because your smile is unique—and so is the care you deserve. At BIA Dental Center, we never rush
                            treatment. Every step is <strong>carefully planned</strong> around your <strong>needs,
                                lifestyle, and goals,</strong> ensuring
                            <strong>comfort, precision,</strong> and results that last a lifetime.
                        </div>
                    </details>

                    <details class="faq group" data-img="{{ Vite::asset('resources/images/faq/faq5.webp') }}">
                        <summary
                            class="flex justify-between items-center cursor-pointer p-4 font-semibold text-gray-800 hover:text-[#203B6E]">
                            <p class="w-3/4">
                                How does BIA Dental Center maintain international-standard hygiene and sterilization?
                            </p>
                            <svg class="w-5 h-5 text-gray-500 transition-transform duration-300 group-open:rotate-180"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="p-4 pt-0 text-[#000000]">
                            Your safety is our highest priority. At BIA Dental Center, we follow strict sterilization and
                            infection control protocols that meet—and often exceed—international standards. From every
                            instrument to every surface, we create a clean, secure environment where you can feel completely
                            at ease.
                        </div>
                    </details>

                    <details class="faq group" data-img="{{ Vite::asset('resources/images/faq/faq6.webp') }}">
                        <summary
                            class="flex justify-between items-center cursor-pointer p-4 font-semibold text-gray-800 hover:text-[#203B6E]">
                            <p class="w-3/4">
                                How does BIA Dental Center minimize risks during dental treatment?
                            </p>
                            <svg class="w-5 h-5 text-gray-500 transition-transform duration-300 group-open:rotate-180"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="p-4 pt-0 text-[#000000]">
                            At BIA Dental Center, your safety comes first. With a <strong>highly skilled clinical team,
                                advanced digital technology,</strong> and <strong>comprehensive treatment
                                planning,</strong> we ensure every procedure is carried out with precision. The result?
                            <strong>Minimized risks, predictable outcomes,</strong> and full <strong>professional
                                responsibility</strong> — every step of the way.
                        </div>
                    </details>

                    <details class="faq group" data-img="{{ Vite::asset('resources/images/faq/faq7.webp') }}">
                        <summary
                            class="flex justify-between items-center cursor-pointer p-4 font-semibold text-gray-800 hover:text-[#203B6E]">
                            <p class="w-3/4">
                                Is BIA Dental Center a legally regulated and trustworthy clinic?
                            </p>
                            <svg class="w-5 h-5 text-gray-500 transition-transform duration-300 group-open:rotate-180"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="p-4 pt-0 text-[#000000]">
                            Yes, absolutely. BIA Dental Center is a <strong>fully licensed and professionally
                                regulated</strong> dental
                            facility in Indonesia. Every treatment is delivered by <strong>highly qualified
                                dentists,</strong> guided by <strong>international standards, medical ethics,</strong> and
                            <strong>legal protection</strong> — giving you total confidence, safety, and peace of mind.
                        </div>
                    </details>
                </div>
            </div>

            <!-- Image -->
            <div class="lg:w-1/2 flex flex-col justify-end lg:justify-start items-center">
                <div class="relative inline-block">
                    <img id="faq-image" src="{{ Vite::asset('resources/images/faq/faq1.webp') }}" alt="Dentist"
                        class="relative shadow-lg w-full lg:max-w mt-0 transition-all duration-500 ease-in-out">
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <x-cta-section stylesection="py-26 bg-white" titleColor="text-[#343A40]"
        title="Ready To Transform Your Smile and Live Happier?" btnUrl="/" btnText="MEET THE DENTIST" />
@endsection
