@extends('layouts.app')


@section('content')
    {{-- After Header Section --}}
    <x-after-header styleSection="py-48" title="{{ $achievement->title }}"
        backUrl="<a href='{{ route('achievements.index') }}' class='absolute top-8 left-6'>< BACK</a>" />


    {{-- Achievements Doc Preview --}}
    {{-- Article Thumbnail & Content --}}
    <section class="max-w-4xl mx-auto px-4 border-b border-gray-200">
        <!-- Gambar Thumbnail -->
        <div class="-mt-24 relative z-0">
            @php
                $docPath = asset('storage/' . $achievement->doc);
                $extension = strtolower(pathinfo($achievement->doc, PATHINFO_EXTENSION));
            @endphp

            @if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                <img src="{{ $docPath }}" alt="{{ $achievement->title }}"
                    class="w-full h-full object-contain shadow-md" />
            @elseif ($extension === 'pdf')
                <iframe src="{{ $docPath }}#toolbar=0&navpanes=0&scrollbar=1" title="{{ $achievement->title }}"
                    class="w-full shadow-md border-0 h-screen overflow-auto scrollbar-hide" allowfullscreen></iframe>
            @elseif (in_array($extension, ['doc', 'docx']))
                <!-- Office Online Viewer: minimal toolbar (zoom scroll terbatas) -->
                <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($docPath) }}&wdHideHeaders=1"
                    title="{{ $achievement->title }}" class="w-full h-full shadow-md border-0" allowfullscreen></iframe>
            @endif

        </div>

        <!-- Konten Rich HTML -->
        <article class="prose lg:prose-xl max-w-none mb-24 mt-8">
            {!! $achievement->content !!}
        </article>
    </section>
@endsection
