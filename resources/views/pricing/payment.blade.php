@extends('layouts.app')

@section('content')
    {{-- After Header Section --}}
    <x-after-header stylesection="py-26 bg-white" title="Payment"
        backUrl="<a href='{{ route('pricing.index') }}' class='absolute top-8 left-6'>< BACK</a>" />

    {{-- Payment Section --}}
    <section id="payment-methods" class="bg-white py-20">
        <div class="max-w-4xl mx-auto text-center px-6 lg:px-8">
            <!-- Deskripsi -->
            <p class="text-gray-600 max-w-3xl mx-auto leading-relaxed mb-14">
                We accept a wide range of credit and debit cards, including
                <strong>Visa</strong>, <strong>Mastercard</strong>, <strong>American Express</strong>,
                <strong>BCA</strong>, and more.
                We also provide installment options for selected treatments.
            </p>

            <!-- Grid Logo -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-x-12 gap-y-24 justify-items-center items-center">
                <img src="{{ Vite::asset('resources/images/payments/visa.webp') }}" alt="Visa"
                    class="h-24 object-contain">
                <img src="{{ Vite::asset('resources/images/payments/mastercard.webp') }}" alt="Mastercard"
                    class="h-24 object-contain">
                <img src="{{ Vite::asset('resources/images/payments/americanexpress.webp') }}" alt="American Express"
                    class="h-24 object-contain">
                <img src="{{ Vite::asset('resources/images/payments/bca.webp') }}" alt="BCA"
                    class="h-24 object-contain">
                <img src="{{ Vite::asset('resources/images/payments/unionpay.webp') }}" alt="UnionPay"
                    class="h-24 object-contain">
                <img src="{{ Vite::asset('resources/images/payments/jcb.webp') }}" alt="JCB"
                    class="h-24 object-contain">
                <img src="{{ Vite::asset('resources/images/payments/gpn.webp') }}" alt="GPN"
                    class="h-24 object-contain">
                <img src="{{ Vite::asset('resources/images/payments/qris.webp') }}" alt="QRIS"
                    class="h-24 object-contain">
            </div>
        </div>
    </section>
@endsection
