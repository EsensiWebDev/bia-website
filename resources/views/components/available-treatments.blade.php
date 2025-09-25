<section class="available-treatments py-16 {{ $bg }}">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-[400] font-signika {{ $titleColor }} mb-12">{{ $title }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <a href="#" class="group relative shadow-md hover:shadow-lg transition">
                <div class="overflow-hidden h-full">
                    <img src="{{ Vite::asset('resources/images/dental.webp') }}" alt="Dental Implant"
                        class="w-auto h-full object-cover group-hover:scale-105 transition">
                </div>
                <div
                    class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-[#7DB8D8] text-white px-5 py-2 font-semibold text-md uppercase tracking-wide shadow-lg whitespace-nowrap">
                    Dental Implant
                </div>
            </a>
            <a href="#" class="group relative shadow-md hover:shadow-lg transition">
                <div class="overflow-hidden h-full">
                    <img src="{{ Vite::asset('resources/images/dental_aesthetics.webp') }}" alt="Dental Aesthetics"
                        class="w-auto h-full object-cover group-hover:scale-105 transition">
                </div>
                <div
                    class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-[#7DB8D8] text-white px-5 py-2 font-semibold text-md uppercase tracking-wide shadow-lg whitespace-nowrap">
                    Dental Aesthetics
                </div>
            </a>
            <a href="#" class="group relative shadow-md hover:shadow-lg transition">
                <div class="overflow-hidden h-full">
                    <img src="{{ Vite::asset('resources/images/dental.webp') }}" alt="Emergency Dental"
                        class="w-auto h-full object-cover group-hover:scale-105 transition">
                </div>
                <div
                    class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-[#7DB8D8] text-white px-5 py-2 font-semibold text-md uppercase tracking-wide shadow-lg whitespace-nowrap">
                    Emergency Dental
                </div>
            </a>
        </div>


        <div class="flex flex-col md:flex-row justify-center gap-8 pt-0 md:pt-8">
            <a href="#" class="group relative shadow-md hover:shadow-lg transition w-full md:w-1/3 block">
                <div class="overflow-hidden h-full">
                    <img src="{{ Vite::asset('resources/images/general_maintenance.webp') }}"
                        alt="General & Maintenance" class="w-auto h-full object-cover group-hover:scale-105 transition">
                </div>
                <div
                    class="absolute -bottom-4 left-1/2 transform -translate-x-1/2
                bg-[#7DB8D8] text-white px-5 py-2 font-semibold text-md uppercase tracking-wide shadow-lg whitespace-nowrap">
                    General & Maintenance
                </div>
            </a>

            <a href="#" class="group relative shadow-md hover:shadow-lg transition w-full md:w-1/3 block">
                <div class="overflow-hidden h-full">
                    <img src="{{ Vite::asset('resources/images/special_treatments.webp') }}" alt="Special Treatments"
                        class="w-auto h-full object-cover group-hover:scale-105 transition">
                </div>
                <div
                    class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-[#7DB8D8] text-white px-5 py-2 font-semibold text-md uppercase tracking-wide shadow-lg whitespace-nowrap">
                    Special Treatments
                </div>
            </a>
        </div>

    </div>
</section>
