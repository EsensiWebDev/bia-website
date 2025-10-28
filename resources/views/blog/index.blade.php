@extends('layouts.app')

@section('content')
    {{-- After Header Section --}}
    <x-after-header stylesection="py-26 bg-white" title="Article" />

    <section class="blog bg-white">
        <div class="mx-auto max-w-7xl lg:px-8 border-t border-gray-200 py-16 px-4">

            @if ($articles->isEmpty())
                <p class="text-center text-gray-500">No posts found.</p>
            @else
                <div class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    @foreach ($articles as $article)
                        <article
                            class="flex max-w flex-col items-start justify-between overflow-hidden group cursor-pointer">
                            <a href="{{ route('article.show', [$article->category->slug, $article->slug]) }}"
                                class="block w-full">
                                <div class="overflow-hidden w-full h-64">
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}"
                                        alt="{{ $article->thumbnail_alt_text ?? 'Blog Article Bia Dental' }}"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                </div>
                            </a>
                            <div class="flex items-center gap-x-2 text-sm uppercase my-3">
                                <time datetime="{{ $article->publish_date->format('Y-m-d') }}">
                                    {{ $article->publish_date->format('d F Y') }}
                                </time> |
                                <a href="{{ route('article.category', $article->category->slug) }}"
                                    class="hover:text-[#203B6E]">
                                    {{ $article->category->title }}
                                </a>
                            </div>
                            <div class="grow">
                                <a href="{{ route('article.show', [$article->category->slug, $article->slug]) }}"
                                    class="block">
                                    <h3
                                        class="text-xl font-bold text-[#203B6E] transition-colors duration-300 group-hover:text-[#7DB8D8]">
                                        {{ $article->title }}
                                    </h3>
                                </a>
                                <p class="mt-2 line-clamp-3">
                                    {{ Str::limit(strip_tags($article->content), 150) }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

            <div class="flex justify-center mt-10">
                {{ $articles->onEachSide(1)->links('vendor.pagination.custom-tailwind') }}
            </div>
        </div>
    </section>
@endsection
