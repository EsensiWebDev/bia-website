@extends('layouts.app')

@section('content')
    <div>
        <section>
            @include('components.section_header', ['title' => 'All Treatments at BIA Dental Center'])
            
        </section>
        <section>
          <div class=" text-center py-[84px] px-5">
                <h1 class=" text-[#203B6E] font-signika text-[42px]">Flow of our treatments</h1>
                <div class="flex flex-wrap justify-center items-center space-x-48 text-2xl">
                    <div class="relative flex items-center">
                        <div class="flex flex-col items-center">
                            <img src="{{ Vite::asset('resources/images/treatments/flow-1.webp') }}" class="size-[94px]"
                                alt="">
                            <h1 class="font-bold">Consultation <br>& Diagnosis</h1>
                        </div>
                        <span class="absolute right-[-10rem] top-1/2 w-32 h-[2px] bg-[#343A40]"></span>
                    </div>
                    <div class="relative flex items-center">
                        <div class="flex flex-col items-center">
                            <img src="{{ Vite::asset('resources/images/treatments/flow-2.webp') }}" class="size-[94px]"
                                alt="">
                            <h1 class="font-bold">Pre-Treatment</h1>
                        </div>
                        <span class="absolute right-[-10rem] top-1/2 w-32 h-[2px] bg-[#343A40]"></span>
                    </div>
                    <div class="relative flex items-center">
                        <div class="flex flex-col items-center">
                            <img src="{{ Vite::asset('resources/images/treatments/flow-3.webp') }}" class="size-[94px]"
                                alt="">
                            <h1 class="font-bold">Dental Procedure</h1>
                        </div>
                        <span class="absolute right-[-10rem] top-1/2 w-32 h-[2px] bg-[#343A40]"></span>
                    </div>
                    <div class="flex flex-col items-center">
                        <img src="{{ Vite::asset('resources/images/treatments/flow-4.webp') }}" class="size-[94px]"
                            alt="">
                        <h1 class="font-bold">Recovery</h1>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
