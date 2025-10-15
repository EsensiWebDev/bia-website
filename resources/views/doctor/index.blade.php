@extends('layouts.app')

@section('content')
    {{-- After Header Section --}}
    <x-after-header stylesection="py-26 bg-white" title="Our Team" />

    <section class="doctors bg-white">
        <div class="mx-auto max-w-7xl lg:px-8 border-t border-gray-200 py-16 px-4">

            @if ($alldoctors->isEmpty())
                <p class="text-center text-gray-500">No data doctors found.</p>
            @else
                <div class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-4">
                    @foreach ($alldoctors as $doctor)
                        <article
                            class="flex max-w flex-col items-start justify-between overflow-hidden group cursor-pointer">
                            <a href="{{ route('doctor.show', $doctor->slug) }}" class="block w-full">
                                <div class="overflow-hidden w-full h-64">
                                    <img src="{{ asset('storage/' . $doctor->avatar) }}"
                                        alt="{{ $doctor->thumbnail_alt_text ?? 'Team Doctor Bia Dental' }}"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                </div>
                                <div class="w-full text-center py-2">
                                    <h3 class="text-2xl mt-3 font-semibold font-inter text-[#000]">{{ $doctor->name }}</h3>
                                    <p class="text-lg text-[#414141]">{{ $doctor->position }}</p>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            @endif

            <div class="flex justify-center mt-10">
                {{ $alldoctors->onEachSide(1)->links('vendor.pagination.custom-tailwind') }}
            </div>
        </div>
    </section>
@endsection
