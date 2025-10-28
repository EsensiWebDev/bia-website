@extends('layouts.app')

@section('content')
    <!-- resources/views/components/hero.blade.php -->
    <div id="home" class="home">
        <!-- Hero Section -->
        <section class="hero relative w-full h-screen">
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img src="{{ Vite::asset('resources/images/hero-home.webp') }}" alt="Dental Hero"
                    class="w-full h-full object-cover">
                <!-- Overlay -->
                <div class="absolute inset-0 bg-[#00000070]"></div>
            </div>

            <!-- Hero Content -->
            <div
                class="relative z-10 flex flex-col justify-center items-start h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-baseline gap-4">
                    <div class="hidden md:block w-12 h-[3px] bg-white"></div>
                    <div class="text-center md:text-start ">
                        <h1 class="font-signika text-white text-3xl sm:text-5xl md:text-6xl font-bold leading-tight">
                            Transform Your Smile, <br>
                            From Missing To Meaningful
                        </h1>
                        <p class="text-white text-md sm:text-xl max-w-xl mb-6 mt-2">
                            We offer smile transformations through pain-free treatments so you can feel confident and live
                            fully again.
                        </p>
                        <div class="justify-center md:justify-start flex space-x-4">
                            <a href="#meet-dentist"
                                class="bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                                MEET THE DENTIST
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- About Us Section -->
        <section class="about bg-white relative w-full">
            <div class="container mx-auto px-6 lg:px-20 py-16  flex flex-col lg:flex-row items-center gap-12">
                <!-- Text Content -->
                <div class="lg:w-1/2">
                    <h2 class="text-4xl font-[400] mb-6">About Us</h2>
                    <p class="text-gray-700 mb-4">
                        At BIA Dental Center, we believe that transforming your smile means restoring your confidence and
                        enhancing your quality of life.
                        Specialized in <span class="font-bold">Smile Makeovers</span> and <span class="font-bold">Full Mouth
                            Rehabilitation</span>, we've helped
                        <span class="font-bold"><span class="text-xl">25,000++</span> local and international
                            patients</span>
                        achieve life-changing
                        results—all delivered with international dentistry standards.
                    </p>
                    <p class="text-gray-700 mb-4">
                        We also offer a comprehensive range of dental treatments, from <span class="font-bold">basic
                            care</span> to <span class="font-bold">advanced procedures</span>,
                        such as Crown, Veneer, Single Implant, Multiple Dental Implant, All on 4/X, Braces, Invisalign, Root
                        Canal, and many more.
                        All dental treatments are supported by the latest technology and state-of-the-art facilities.
                    </p>
                    <p class="text-gray-700 mb-6">
                        Most importantly, we're committed to providing <span class="font-bold">gentle and pain-free dental
                            experiences</span>, especially for those with dental anxiety.
                        From your first visit to your final result, our highly skilled and competent dentists ensure you
                        feel safe, calm, and confident every step of the way.
                    </p>
                    <a href="#meet-dentist"
                        class="inline-block bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                        MEET THE DENTIST
                    </a>
                </div>

                <!-- Image -->
                <div class="lg:w-1/2 flex flex-col justify-end lg:justify-start items-center">
                    <div class="relative inline-block">
                        <div class="relative">
                            <div class="absolute inset-0 border-2 border-white translate-x-4 translate-y-4 z-10"></div>
                            <img src="{{ Vite::asset('resources/images/doctor-photo.webp') }}" alt="Dentist"
                                class="relative shadow-lg w-full lg:max-w-sm lg:mt-[-13em] mt-0">
                        </div>
                    </div>

                    <div class="absolute flex flex-col gap-4 right-10 lg:top-5 sm:top-100">
                        <a href="#"
                            class="bg-[#D9D9D9] hover:bg-[#C1C1C1] text-white rounded-full w-24 h-24 flex items-center justify-center font-semibold text-center transition-all duration-300">
                            <span class="leading-tight">Virtual <br>360</span></a>
                        <a href="#"
                            class="bg-[#D9D9D9] hover:bg-[#C1C1C1] text-white rounded-full w-24 h-24 flex items-center justify-center font-semibold text-center transition-all duration-300">
                            <span class="leading-tight">AI <br>Smile</span></a>
                    </div>
                </div>

            </div>
        </section>

        <!-- Available Treatments Section -->
        <x-available-treatments :treatments="$cattreatments" stylesection="bg-[#F1F1F1] pt-16 pb-24" title="Treatments Available"
            titleColor="text-[#203B6E]" />

        <!-- WCU Section -->
        <section class="wcu bg-gray-200 py-16">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h2 class="text-4xl font-[400] mb-12">Why Choose Us</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                    <div class="flex flex-col items-center text-center">
                        <img src="{{ Vite::asset('resources/images/wcu/wcu1.webp') }}" alt="Pain-Free Treatment"
                            class="w-auto h-24 mb-4">
                        <h3 class="font-semibold mb-2 font-montserrat">Pain-Free Treatment</h3>
                        <p>We offer gentle dental care to help everyone, even those with
                            dental anxiety, feel safe and comfortable throughout the process.</p>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <img src="{{ Vite::asset('resources/images/wcu/wcu2.webp') }}" alt="Globally Trained Dentists"
                            class="w-auto h-24 mb-4">
                        <h3 class="font-semibold mb-2 font-montserrat">Globally Trained Dentists</h3>
                        <p>Our dentists have completed courses and training in various
                            countries to deliver high quality and up-to-date care.</p>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <img src="{{ Vite::asset('resources/images/wcu/wcu3.webp') }}" alt="Expert in Implantology"
                            class="w-auto h-24 mb-4">
                        <h3 class="font-semibold mb-2 font-montserrat">Expert in Implantology</h3>
                        <p>Our Chief Clinical Officer and implantologist, Dr. Andhika, is the
                            first dentist in Indonesia to graduate with a Master of Science in Oral Implantology, delivering
                            exceptional and long-lasting results.</p>
                    </div>

                    <div class="flex flex-col items-center text-center">
                        <img src="{{ Vite::asset('resources/images/wcu/wcu4.webp') }}" alt="Advanced Digital Technology"
                            class="w-auto h-24 mb-4">
                        <h3 class="font-semibold mb-2 font-montserrat">Advanced Digital Technology</h3>
                        <p>Experience premium dental care with the latest digital technology,
                            from 3D scanning to guided implant surgery. Faster, safer, and pain-free procedures with
                            precise, personalized results.</p>
                    </div>

                </div>
            </div>
        </section>

        {{-- Our Doctor’s Background Section --}}
        <x-our-doctors-bg />

        <!-- Testimonials Section -->
        <section class="testimonials-review bg-white py-16 px-6">
            <div class="max-w-6xl mx-auto">
                <div class="flex flex-col-reverse md:flex-row justify-between items-start md:items-center mb-12 gap-3">
                    <div class="lg:w-8/12 sm:w-full">
                        <div class="mb-4">
                            <p class="font-bold">772 Reviews</p>
                            <div class="flex items-center my-3">
                                <h2 class="text-4xl ">4.9</h2>
                                <div class="ml-2 text-[#203B6E] flex">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <!-- Testimonials -->
                        <div class="grid gap-8 md:grid-cols-1">
                            <div class="flex items-start gap-5">
                                <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Melay Presores"
                                    class="w-18 rounded-full object-cover">
                                <div>
                                    <p class="font-semibold">Melay Presores</p>
                                    <div class="text-[#203B6E] text-xs my-1 my-1">
                                        @for ($i = 0; $i < 5; $i++)
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        @endfor
                                    </div>
                                    <p class="leading-relaxed">
                                        Thank you so much to BIA Dental, and special thanks to my doctor Felix, who is
                                        incredibly kind, professional, and helpful. I loved my porcelain crown teeth. You
                                        restored the beauty and self-assurance to my smile. It was worth travelling to Bali
                                        for my teeth and vacation. From the first day to day 5, Doc. Felix ensures that
                                        everything is delivered on time, which is why I highly recommend them. The timeline
                                        was remarkable. Before my flight to Australia, you made sure that everything was
                                        complete on schedule.
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-5">
                                <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="Suzanna Sandie"
                                    class="w-18 rounded-full object-cover">
                                <div>
                                    <p class="font-semibold">Suzanna Sandic</p>
                                    <div class="text-[#203B6E] text-xs my-1 my-1">
                                        @for ($i = 0; $i < 5; $i++)
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        @endfor
                                    </div>
                                    <p class="leading-relaxed">
                                        Seen Dr Felix excellent dentist extremely happy with his bed side manner and work.
                                        This dentist is very honest and trustworthy. I fly to Bali from Brisbane just to see
                                        Dr Felix. Highly recommend this dental practice and Dr Felix.
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-5">
                                <div
                                    class="w-18 h-18 rounded-full bg-yellow-500 flex items-center justify-center text-white font-bold text-lg shrink-0">
                                    S
                                </div>
                                <div>
                                    <p class="font-semibold">Simon Lucas</p>
                                    <div class="text-[#203B6E] text-xs my-1">
                                        @for ($i = 0; $i < 4; $i++)
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        @endfor
                                    </div>
                                    <p class="leading-relaxed">
                                        Needed to get a quick appointment for my wisdom tooth. Was able to come the next
                                        day. The dentist was extremely friendly and careful. Also amazing follow up on
                                        WhatsApp after the treatment. Prices are also really good, especially compared to
                                        Europe. Can highly recommend!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-4/12 mt-6 md:mt-0 text-center">
                        <h2 class="text-4xl font-[400] text-[#203B6E] mb-6">Patient Testimonials</h2>
                        <p class="mt-2 mb-6">
                            Read honest feedback from our patients about the experiences and results they received at BIA
                            Dental Center.
                        </p>
                        <div class="hidden md:flex space-x-4 justify-center">
                            <a href="#"
                                class="mt-4 bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                                VIEW MORE REVIEWS
                            </a>
                        </div>
                    </div>
                </div>

                <div class="md:hidden flex space-x-4 justify-center">
                    <a href="#"
                        class="bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                        VIEW MORE REVIEWS
                    </a>
                </div>
            </div>
        </section>

        {{-- Before After Section --}}
        <section class="before-after bg-white py-16 px-4">
            <div class="max-w-6xl mx-auto text-center mb-12">
                <h2 class="text-4xl font-[400] text-[#203B6E]">Before & After</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">

                <div class="space-y-0">
                    <div class="relative w-full h-48 overflow-hidden">
                        <img src="{{ Vite::asset('resources/images/before-after/before1.webp') }}" alt="Before"
                            class="w-full h-full object-cover clip-bottom-slant" />
                        <span
                            class="absolute top-0 left-0 bg-[#203B6E] text-white px-2 py-1 w-[80px] text-center font-signika">Before</span>
                    </div>

                    <div class="relative
                            w-full h-48 overflow-hidden -mt-8">
                        <img src="{{ Vite::asset('resources/images/before-after/after1.webp') }}" alt="After"
                            class="w-full h-full object-cover clip-top-slant translate-y-[-10px]" />
                        <span
                            class="absolute bottom-0 left-0 bg-[#2265E3] text-white px-2 py-1 translate-y-[-10px] w-[80px] text-center font-signika">After</span>
                    </div>
                </div>


                <div class="space-y-0">
                    <div class="relative w-full h-48 overflow-hidden">
                        <img src="{{ Vite::asset('resources/images/before-after/before2.webp') }}" alt="Before"
                            class="w-full h-full object-cover clip-bottom-slant" />
                        <span
                            class="absolute top-0 left-0 bg-[#203B6E] text-white px-2 py-1 w-[80px] text-center font-signika">Before</span>
                    </div>

                    <div class="relative
                            w-full h-48 overflow-hidden -mt-8">
                        <img src="{{ Vite::asset('resources/images/before-after/after2.webp') }}" alt="After"
                            class="w-full h-full object-cover clip-top-slant translate-y-[-10px]" />
                        <span
                            class="absolute bottom-0 left-0 bg-[#2265E3] text-white px-2 py-1 translate-y-[-10px] w-[80px] text-center font-signika">After</span>
                    </div>
                </div>

                <div class="space-y-0">
                    <div class="relative w-full h-48 overflow-hidden">
                        <img src="{{ Vite::asset('resources/images/before-after/before3.webp') }}" alt="Before"
                            class="w-full h-full object-cover clip-bottom-slant" />
                        <span
                            class="absolute top-0 left-0 bg-[#203B6E] text-white px-2 py-1 w-[80px] text-center font-signika">Before</span>
                    </div>

                    <div class="relative
                            w-full h-48 overflow-hidden -mt-8">
                        <img src="{{ Vite::asset('resources/images/before-after/after3.webp') }}" alt="After"
                            class="w-full h-full object-cover clip-top-slant translate-y-[-10px]" />
                        <span
                            class="absolute bottom-0 left-0 bg-[#2265E3] text-white px-2 py-1 translate-y-[-10px] w-[80px] text-center font-signika">After</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- Blog/Article Section --}}
        <section class="blog bg-white">
            <div class="mx-auto max-w-7xl lg:px-8 border-t border-gray-200 py-16 px-4">
                <div class="max-w-6xl mx-auto text-center mb-12">
                    <h2 class="text-4xl font-[400] text-[#203B6E]">Blog</h2>
                </div>
                @if ($articles->isEmpty())
                    <p class="text-center text-gray-500">No posts found.</p>
                @else
                    <div
                        class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                        @foreach ($articles as $article)
                            <article
                                class="flex max-w flex-col items-start justify-between overflow-hidden group cursor-pointer">
                                <a href="{{ route('blog.show', [$article->category->slug, $article->slug]) }}"
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
                                    <a href="{{ route('blog.category', $article->category->slug) }}"
                                        class="hover:text-[#203B6E]">
                                        {{ $article->category->title }}
                                    </a>
                                </div>
                                <div class="grow">
                                    <a href="{{ route('blog.show', [$article->category->slug, $article->slug]) }}"
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
                <div class="flex space-x-4 justify-center mt-8">
                    <a href="{{ route('blog.index') }}"
                        class="bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                        VIEW MORE ARTICLES
                    </a>
                </div>
            </div>
        </section>

        {{-- CTA Section --}}
        <x-cta-section stylesection="py-26 bg-white" titleColor="text-[#343A40]"
            title="Ready To Transform Your Smile and Live Happier?" btnUrl="/" btnText="MEET THE DENTIST" />
    </div>
@endsection
