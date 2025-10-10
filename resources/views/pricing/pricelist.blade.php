@extends('layouts.app')

@section('content')
    {{-- After Header Section --}}
    <x-after-header stylesection="py-26 bg-white" title="Price List"
        backUrl="<a href='{{ route('pricing.index') }}' class='absolute top-8 left-6'>< BACK</a>" />

    {{-- PriceList Section --}}
    <section id="pricelist" class="bg-white py-20">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            {{-- <h2 class="text-3xl font-semibold text-[#203B6E] mb-12 text-center">Price List</h2> --}}

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Left Column -->
                <div class="space-y-10">

                    <!-- Implant -->
                    <div>
                        <h3 class="text-2xl font-montserrat mb-4">Implant</h3>
                        <div class="space-y-2 text-gray-700 text-sm">
                            <div>
                                <p class="font-bold text-sm md:text-md text-[#000000]">Single Dental Implant</p>
                                <div class="pl-4 border-l border-[#000] mt-1 space-y-2 ">
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Dentium</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                15.500.000</span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Straumann</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                19.500.000</span></span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between pt-0 md:pt-2">
                                <span class="font-bold text-sm md:text-md text-[#000000]">All On 4</span>
                                <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                        class="text-[#000000]">IDR
                                        100.000.000*</span></span>
                            </div>
                            <div class="flex justify-between pt-0 md:pt-2">
                                <span class="font-bold text-sm md:text-md text-[#000000]">All On 5</span>
                                <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                        class="text-[#000000]">IDR
                                        116.000.000*</span></span>
                            </div>
                            <div class="flex justify-between pt-0 md:pt-2">
                                <span class="font-bold text-sm md:text-md text-[#000000]">All On 6</span>
                                <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                        class="text-[#000000]">IDR
                                        132.000.000*</span></span>
                            </div>
                            <div class="flex justify-between pt-0 md:pt-2">
                                <span class="font-bold text-sm md:text-md text-[#000000]">Bone Graft</span>
                                <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                        class="text-[#000000]">IDR
                                        4.500.000</span></span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-3 leading-relaxed">
                            *) Note:<br>
                            • Price does not include X-ray, bone graft, tooth extraction if needed<br>
                            • Price includes temporary crown and sedation
                        </p>
                    </div>

                    <!-- Tooth Extraction -->
                    <div class="border-t border-gray-200 pt-10">
                        <h3 class="text-2xl font-montserrat mb-4">Tooth Extraction</h3>
                        <div class="space-y-2 text-gray-700 text-sm">
                            <div class="flex justify-between">
                                <span class="font-bold text-sm md:text-md text-[#000000]">Tooth Extraction</span>
                                <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                        class="text-[#000000]">IDR
                                        2.000.000</span></span>
                            </div>
                            <div class="flex justify-between pt-0 md:pt-2">
                                <span class="font-bold text-sm md:text-md text-[#000000]">Wisdom Tooth Extraction</span>
                                <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                        class="text-[#000000]">IDR
                                        5.000.000</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Orthodontics -->
                    <div class="border-t border-gray-200 pt-10">
                        <h3 class="text-2xl font-montserrat mb-4">Orthodontics</h3>
                        <div class="space-y-2 text-gray-700 text-sm">

                            <div>
                                <p class="font-bold text-sm md:text-md text-[#000000]">Braces</p>
                                <div class="pl-4 border-l border-[#000] mt-1 space-y-2 ">
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Metal</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                15.500.000*</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Clear</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                19.500.000*</span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Damon Metal</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                19.500.000*</span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Damon Clear</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                19.500.000*</span></span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-3 leading-relaxed">
                                *) Price does not include X-ray and monthly control
                            </p>

                            <div class="flex justify-between pt-0 md:pt-2">
                                <span class="font-bold text-sm md:text-md text-[#000000]">Aligner</span>
                                <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                        class="text-[#000000]">IDR
                                        40.000.000*</span></span>
                            </div>
                            <div class="flex justify-between pt-0 md:pt-2">
                                <span class="font-bold text-sm md:text-md text-[#000000]">Invisalign</span>
                                <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                        class="text-[#000000]">IDR
                                        45.000.000</span></span>
                            </div>
                            <div>
                                <p class="font-bold text-sm md:text-md text-[#000000] pt-0 md:pt-2">Retainer</p>
                                <div class="pl-4 border-l border-[#000] mt-1 space-y-2 ">
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Clear Retainer</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                1.300.000 /
                                                jaw</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Lingual Retainer</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                2.000.000 /
                                                jaw</span></span>
                                    </div>

                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-3 mb-8 leading-relaxed">
                                *) Price does not include X-ray and DSD if needed
                            </p>
                        </div>
                    </div>


                    <!-- Endodontics -->
                    <div class="border-t border-gray-200 pt-10">
                        <h3 class="text-2xl font-montserrat mb-4">Endodontics</h3>
                        <div class="space-y-2 text-gray-700 text-sm">

                            <div>
                                <p class="font-bold text-sm md:text-md text-[#000000]">Root Canal Treatment</p>
                                <div class="pl-4 border-l border-[#000] mt-1 space-y-2 ">
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Root Canal Treatment</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                1.300.000
                                                /
                                                jaw</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Root Canal Re-treatment</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                2.000.000
                                                /
                                                jaw</span></span>
                                    </div>

                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-3 mb-8 leading-relaxed">
                                *) Note:<br>
                                • Price does not include X-ray, dental filling, and crown if needed<br>
                                • Price is per canal
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-10">

                    <!-- Aesthetics -->
                    <div>
                        <h3 class="text-2xl font-montserrat mb-4">Aesthetics</h3>
                        <div class="space-y-3 text-gray-700 text-sm">
                            <div>
                                <p class="font-bold text-sm md:text-md text-[#000000]">Crown, Onlay, Inlay</p>
                                <div class="pl-4 border-l border-[#000] mt-1 space-y-2 ">
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Porcelain Zirconia Crown</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                15.500.000</span></span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="font-bold text-sm md:text-md text-[#000000] pt-0 md:pt-2">Veneer</p>
                                <div class="pl-4 border-l border-[#000] mt-1 space-y-2 ">
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Indirect Veneer (Porcelain)</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                15.500.000</span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Direct Veneer (Composite)</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                19.500.000</span></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="font-bold text-sm md:text-md text-[#000000] pt-0 md:pt-2">Teeth Whitening</p>
                                <div class="pl-4 border-l border-[#000] mt-1 space-y-2 ">
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Flash</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                15.500.000</span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Everbite</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                19.500.000</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-3">
                            *) Price does not include cleaning/scaling if needed
                        </p>
                    </div>

                    <!-- Anesthesia -->
                    <div class="border-t border-gray-200 pt-10">
                        <h3 class="text-2xl font-montserrat mb-4">Anesthesia</h3>
                        <div class="flex justify-between text-gray-700 text-sm">
                            <span class="font-bold text-sm md:text-md text-[#000000]">Sedation</span>
                            <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                    class="text-[#000000]">IDR 5.000.000
                                    /
                                    hour</span></span>
                        </div>
                        <p class="text-sm text-gray-500 mt-3">*) Sedation price does not include consultation</p>
                    </div>

                    <!-- General Dental Check-Up -->
                    <div class="border-t border-gray-200 pt-10">
                        <h3 class="text-2xl font-montserrat mb-4">General Dental Check-Up</h3>
                        <div class="space-y-2 text-gray-700 text-sm">
                            <div class="flex justify-between">
                                <span class="font-bold text-sm md:text-md text-[#000000]">Dental Filling</span>
                                <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                        class="text-[#000000]">IDR
                                        2.000.000</span></span>
                            </div>
                            <div class="flex justify-between pt-0 md:pt-2">
                                <span class="font-bold text-sm md:text-md text-[#000000]">Dental Consultation</span>
                                <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                        class="text-[#000000]">IDR
                                        5.000.000</span></span>
                            </div>

                            <div>
                                <p class="font-bold text-sm md:text-md text-[#000000] pt-0 md:pt-2">X-Ray</p>
                                <div class="pl-4 border-l border-[#000] mt-1 space-y-2 ">
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">3D CBCT</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                15.500.000</span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">2D Panoramic</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                19.500.000</span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Cephalometry</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                19.500.000</span></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="font-bold text-sm md:text-md text-[#000000] pt-0 md:pt-2">Cleaning</p>
                                <div class="pl-4 border-l border-[#000] mt-1 space-y-2 ">
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Scaling</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                15.500.000</span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Deep Cleaning</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                19.500.000</span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Dental Spa</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                19.500.000</span></span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-3">
                                *) Scaling includes dental polishing
                            </p>
                        </div>
                    </div>

                    <!-- Additionals -->
                    <div class="border-t border-gray-200 pt-10">
                        <h3 class="text-2xl font-montserrat mb-4">Additionals</h3>
                        <div class="space-y-2 text-gray-700 text-sm">
                            <div class="flex justify-between">
                                <span class="font-bold text-sm md:text-md text-[#000000]">Night Guard</span>
                                <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                        class="text-[#000000]">IDR
                                        2.000.000</span></span>
                            </div>
                            <div class="flex justify-between pt-0 md:pt-2">
                                <span class="font-bold text-sm md:text-md text-[#000000]">Mouth Guard</span>
                                <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                        class="text-[#000000]">IDR
                                        5.000.000</span></span>
                            </div>

                            <div>
                                <p class="font-bold text-sm md:text-md text-[#000000] pt-0 md:pt-2">Impression</p>
                                <div class="pl-4 border-l border-[#000] mt-1 space-y-2 ">
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Scan Impression</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                15.500.000</span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Mock Up</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                19.500.000</span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Dental Smile Design (DSD)</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                19.500.000</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Prosthodontics -->
                    <div class="border-t border-gray-200 pt-10">
                        <h3 class="text-2xl font-montserrat mb-4">Prosthodontics</h3>
                        <div class="space-y-2 text-gray-700 text-sm">
                            <div>
                                <p class="font-bold text-sm md:text-md text-[#000000]">Dentures</p>
                                <div class="pl-4 border-l border-[#000] mt-1 space-y-2 ">
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Acrylic Plate</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                15.500.000</span></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm md:text-md">Metal Plate</span>
                                        <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                                class="text-[#000000]">IDR
                                                19.500.000</span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between pt-0 md:pt-2">
                                <span class="font-bold text-sm md:text-md text-[#000000]">Denture Acrylic Tooth</span>
                                <span class="text-[#656565] text-right text-sm md:text-md">Start From <span
                                        class="text-[#000000]">IDR
                                        5.000.000</span></span>
                            </div>
                            <p class="text-sm text-gray-500 mt-3">
                                *) Price does not include mock-up and acrylic tooth
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="border-t border-gray-200 mt-24 px-2 lg:px-8 pt-4">
                <p class="text-sm text-[#000] mt-3 mb-8 leading-relaxed">
                    *)Notes:<br>
                    • The detailed pricing will be explained during your consultation with the doctor<br>
                    • Convert IDR to USD or other currencies using <a href="#" class="underline">this link</a>
                </p>
            </div>
        </div>
    </section>
@endsection
