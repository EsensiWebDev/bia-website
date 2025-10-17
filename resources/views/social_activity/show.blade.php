@extends('layouts.app')

@section('content')
    {{-- After Header Section --}}
    <x-after-header styleSection="py-48" title="{{ $socialAct->title }}"
        subHeading="<div class='mt-5 flex md:flex-row flex-wrap gap-3 md:gap-5 justify-center'>
                        <p class='text-gray-100 uppercase'>{{ $socialAct->publish_date->format('d F Y') }}</p> |
                        <p class='capitalize'>by {{ $socialAct->author }}</p>
                    </div>"
        backUrl="<a href='{{ route('social.index') }}' class='absolute top-8 left-6'>< BACK</a>" />

    {{-- Social Activity Thumbnail & Content --}}
    <section class="max-w-4xl mx-auto px-4 border-b border-gray-200">
        <!-- Gambar Thumbnail -->
        <div class="-mt-24 relative z-0">
            <img src="{{ asset('storage/' . $socialAct->thumbnail) }}" alt="{{ $socialAct->thumbnail_alt_text }}"
                class="w-full h-auto shadow-md">
        </div>

        <!-- Konten Rich HTML -->
        <article class="prose lg:prose-xl max-w-none mb-24 mt-8">
            {!! $socialAct->content !!}
        </article>
    </section>
@endsection
