@extends('layouts.app')


@section('content')
    {{-- After Header Section --}}
    <x-after-header stylesection="py-26 bg-white" title="Achievements" />

    {{-- Achievement Section --}}
    <section class="social-activity bg-white">
        <div class="mx-auto max-w-7xl lg:px-8 border-t border-gray-200 py-16 px-4">

            @if ($Achievements->isEmpty())
                <p class="text-center text-gray-500">No data found.</p>
            @else
                <div class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    @foreach ($Achievements as $achievement)
                        <article
                            class="flex max-w flex-col items-start justify-between overflow-hidden group cursor-pointer">
                            <a href="{{ route('achievements.show', $achievement->slug) }}" class="block w-full">
                                <div class="overflow-hidden w-full h-64">
                                    <img src="{{ asset('storage/' . $achievement->thumbnail) }}"
                                        alt="{{ $achievement->thumbnail_alt_text ?? 'Blog Article Bia Dental' }}"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                </div>
                            </a>
                            <div class="grow mt-6">
                                <a href="{{ route('achievements.show', $achievement->slug) }}" class="block">
                                    <h3
                                        class="min-h-[35px] text-xl font-bold font-inter text-[#000000] transition-colors duration-300 group-hover:text-[#383838]">
                                        {{ $achievement->title }}
                                    </h3>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

            <div class="flex justify-center mt-10">
                {{ $Achievements->onEachSide(1)->links('vendor.pagination.custom-tailwind') }}
            </div>
        </div>
    </section>
@endsection
