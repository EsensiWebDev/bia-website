@extends('layouts.app')

@section('content')
    <div class="treatment-category">

        {{-- After Header Section --}}
        <x-after-header styleSection="md:py-32 bg-white" :title="$category->title" :subHeading="'<div class=\'text-white text-md sm:text-xl max-w-3xl text-center m-auto mt-6\'>' .
            $category->desc .
            '</div>'" />


        <!-- Available Treatments Section -->
        <x-available-treatments :treatments="$treatments" :category="$category" stylesection="bg-[#F1F1F1] pt-16 pb-24"
            title="Treatments Available" titleColor="text-[#203B6E]" />

        {{-- CTA Section --}}
        <x-cta-section stylesection="py-26 bg-white" titleColor="text-[#343A40]"
            title="Ready To Transform Your Smile and Live Happier?" btnUrl="/" btnText="MEET THE DENTIST" />
    </div>
@endsection
