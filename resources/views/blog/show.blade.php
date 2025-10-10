@extends('layouts.app')

@section('content')
    {{-- After Header Section --}}
    <x-after-header styleSection="py-48" title="{{ $article->title }}"
        subHeading="<div class='mt-5 flex md:flex-row flex-wrap gap-3 md:gap-5 justify-center'>
                        <a href='{{ route('blog.category', $article->category->slug) }}' class='hover:text-[#7DB8D8] text-gray-100 uppercase'>{{ $article->category->title }}</a> |
                        <p class='text-gray-100 uppercase'>{{ $article->publish_date->format('d F Y') }}</p> |
                        <p class='capitalize'>by {{ $article->author }}</p>
                    </div>"
        backUrl="<a href='{{ route('blog.index') }}' class='absolute top-8 left-6'>< BACK</a>" />

    {{-- Article Thumbnail & Content --}}
    <section class="max-w-4xl mx-auto px-4 border-b border-gray-200">
        <!-- Gambar Thumbnail -->
        <div class="-mt-24 relative z-0">
            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->thumbnail_alt_text }}"
                class="w-full h-auto shadow-md">
        </div>

        <!-- Konten Rich HTML -->
        <article class="prose lg:prose-xl max-w-none mb-24 mt-8">
            {!! $article->content !!}
        </article>
    </section>

    {{-- Blog Section --}}
    <section class="related-posts bg-white">
        <div class="mx-auto max-w-6xl lg:px-8 py-16 px-4">
            <div class="max-w-6xl text-left mb-12">
                <h2 class="text-4xl font-[400] text-[#203B6E]">Recent Posts</h2>
            </div>
            @if ($relateds->isEmpty())
                <p class="text-center text-gray-500">No related posts found.</p>
            @else
                <div class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    @foreach ($relateds as $related)
                        <article
                            class="flex max-w flex-col items-start justify-between overflow-hidden group cursor-pointer">
                            <a href="{{ route('blog.show', [$related->category->slug, $related->slug]) }}"
                                class="block w-full">
                                <div class="overflow-hidden w-full h-64">
                                    <img src="{{ asset('storage/' . $related->thumbnail) }}"
                                        alt="{{ $related->thumbnail_alt_text }}"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                </div>
                            </a>
                            <div class="flex items-center gap-x-2 text-sm uppercase my-3">
                                <time datetime="{{ $related->publish_date->format('Y-m-d') }}">
                                    {{ $related->publish_date->format('d F Y') }}
                                </time> |
                                <a href="{{ route('blog.category', $related->category->slug) }}"
                                    class="hover:text-[#203B6E]">
                                    {{ $related->category->title }}
                                </a>
                            </div>
                            <div class="grow">
                                <a href="{{ route('blog.show', [$related->category->slug, $related->slug]) }}"
                                    class="block">
                                    <h3
                                        class="text-xl font-bold text-[#203B6E] transition-colors duration-300 group-hover:text-[#7DB8D8]">
                                        {{ $related->title }}
                                    </h3>
                                </a>
                                <p class="mt-2 line-clamp-3">
                                    {{ Str::limit(strip_tags($related->content), 70) }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
