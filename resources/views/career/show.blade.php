@extends('layouts.app')

@section('content')
    <section
        class="det-career bg-cover bg-center text-center text-white mt-24 pt-28 md:pt-42 pb-16 px-4 min-h-[377px] flex flex-col justify-center relative">
        <div class="container mx-auto px-6 lg:px-20">
            <div
                class="container absolute top-[4em] md:top-[6em] text-[#000000] hover:text-gray-300 font-medium m-auto left-1/2 -translate-x-1/2 -translate-y-1/2">
                <a href='{{ route('career.index') }}' class='absolute top-0 left-6'>
                    < BACK</a>
            </div>
            <!-- Section Header -->
            <div class="text-left max-w-6xl mx-auto mb-12">
                <h2 class="w-full text-4xl md:text-5xl mx-auto font-signika font-[600] text-[#203B6E] break-words">
                    {{ $career->career_title }}</h2>
                <div class="my-6 md:my-10">
                    <hr class="border-[#D9D5CB] ">
                    <p class="text-[#000] text-right italic">
                        @if ($career->start_date && $career->end_date)
                            *Recruitment Period: {{ \Carbon\Carbon::parse($career->start_date)->format('F j, Y') }} –
                            {{ \Carbon\Carbon::parse($career->end_date)->format('F j, Y') }}
                        @elseif ($career->start_date)
                            *Recruitment Starts From: {{ \Carbon\Carbon::parse($career->start_date)->format('F j, Y') }}
                        @elseif ($career->end_date)
                            *Recruitment Open Until: {{ \Carbon\Carbon::parse($career->end_date)->format('F j, Y') }}
                        @else
                            *Recruitment Period: Not Specified
                        @endif
                    </p>
                </div>
                <div class="content text-[#000000]">
                    {!! $career->content !!}
                </div>
                <br>
                <div class="apply content gap-1 flex flex-col text-left">
                    <h2 class="text-[#000] font-bold">How to Apply</h2>
                    <p class="text-[#000]">Send your CV and Portfolio to:</p>
                    <a href="mailto:{{ $career->email_send }}"
                        class="text-[#000] underline hover:text[#203B6E] ">{{ $career->email_send ?? 'hrm@biadentalcenter.com' }}
                    </a>
                    <p class="text-[#000]">Subject:
                        <span class="font-bold">{{ $career->subject_send ?? '[Position] – Your Name' }}</span>
                    </p>
                    <p class="text-[#000]">Example:
                        {{ $career->exsubject_send ?? 'Dental Technician – Satria Wijaya' }}
                    </p>
                </div>
            </div>


        </div>
    </section>
@endsection
