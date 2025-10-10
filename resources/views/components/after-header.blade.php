<section class="after-header relative w-full">
    <div class="bg-cover bg-center text-center text-white mt-24 {{ $styleSection ?? 'py-16' }} px-4 min-h-[377px] flex flex-col justify-center relative"
        style="background-image: url('{{ Vite::asset('resources/images/section-header.webp') }}');">

        @if ($backUrl)
            <div
                class="container absolute top-[5em] hover:text-gray-300 font-medium m-auto left-1/2 -translate-x-1/2 -translate-y-1/2">
                {!! $backUrl !!}
            </div>
        @endif

        <h1 class="w-full md:w-1/2 text-3xl md:text-5xl mx-auto font-signika">{{ $title }}</h1>

        @if ($subHeading)
            {!! $subHeading !!}
        @endif
    </div>
</section>
