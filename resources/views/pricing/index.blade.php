@extends('layouts.app')

@section('content')
    <!-- Pricing1 Section -->
    <section class="pricing1 bg-white relative w-full">
        <div
            class="container mt-24 mx-auto px-6 lg:px-20 py-16 flex flex-col-reverse md:flex-col lg:flex-row items-center gap-12 md:gap-24">
            <!-- Text Content -->
            <div class="lg:w-1/2">
                <h2 class="text-4xl font-[400] text-[#203B6E] mb-6 text-center md:text-left">Pricing</h2>
                <p class="w-full md:w-2/3 text-gray-700 mb-4">
                    We believe in price transparency. Our treatments start with transparent essential charges, without any
                    costs that are not disclosed.
                </p>
                <div class="text-center md:text-start">
                    <a href="{{ route('pricing.pricelist') }}"
                        class="inline-block bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                        MORE
                    </a>
                </div>
            </div>

            <!-- Image -->
            <div class="w-full md:w-1/2 flex justify-center lg:justify-start">
                <img src="{{ Vite::asset('resources/images/sectionpricing1.webp') }}" alt="Dentist"
                    class="shadow-lg w-full">
            </div>
        </div>
    </section>

    <!-- Pricing2 Section -->
    <section class="pricing2 bg-gray-200 relative w-full">
        <div class="container mx-auto px-6 lg:px-20 py-16 flex flex-col lg:flex-row items-center gap-12 md:gap-24">
            <!-- Image -->
            <div class="w-full md:w-1/2 flex justify-center lg:justify-start">
                <img src="{{ Vite::asset('resources/images/sectionpricing2.webp') }}" alt="Dentist"
                    class="shadow-lg w-full">
            </div>

            <!-- Text Content -->
            <div class="lg:w-1/2">
                <h2 class="text-4xl font-[400] text-[#203B6E] mb-6 text-center md:text-left">Payments</h2>
                <p class="w-full md:w-2/3 text-gray-700 mb-4">
                    We accept a wide range of credit and debit cards, including Visa, Mastercard, American Express, etc. We
                    also provide installment options for selected treatments.
                </p>
                <div class="text-center md:text-start">
                    <a href="{{ route('pricing.payments') }}"
                        class="inline-block bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                        MORE
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
