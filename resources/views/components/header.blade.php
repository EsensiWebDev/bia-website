<!-- resources/views/components/navbar.blade.php -->

<nav id="navbar"
    class="w-full fixed top-0 left-0 z-50 {{ request()->routeIs('home') || request()->routeIs('facilities') ? 'bg-transparent' : 'bg-white' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/">
                    @if (request()->routeIs('home') || request()->routeIs('facilities'))
                        <img class="h-12 w-auto" src="{{ Vite::asset('resources/images/logo-white.webp') }}"
                            alt="BIA Logo">
                    @else
                        <img id="biaLogox" class="h-12 w-auto"
                            src="{{ Vite::asset('resources/images/logo-blue.webp') }}" alt="BIA Logo">
                    @endif
                </a>
            </div>

            <!-- Desktop Menu -->
            <div
                class="hidden {{ request()->routeIs('home') || request()->routeIs('facilities') ? 'text-white' : 'text-[#203B6E]' }}  md:flex space-x-8 items-center">
                <a href="{{ route('home') }}" class=" hover:text-gray-300 font-medium">Home</a>
                <a href="{{ route('treatments.index') }}" class=" hover:text-gray-300 font-medium">Treatments</a>
                <a href="{{ route('allon4implant') }}" class=" hover:text-gray-300 font-medium">All-on-4 Implant</a>
                <a href="{{ route('pricing.index') }}" class=" hover:text-gray-300 font-medium">Pricing</a>
                <a href="{{ route('about') }}" class=" hover:text-gray-300 font-medium">About Us</a>
                <a href="{{ route('blog.index') }}" class=" hover:text-gray-300 font-medium">Blog</a>

                <!-- Book Now Button -->
                <div class="hidden md:flex">
                    <a href="{{ route('booknow') }}"
                        class="bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                        BOOK NOW
                    </a>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button"
                    class="{{ request()->routeIs('home') || request()->routeIs('facilities') ? 'text-white' : 'text-[#203B6E]' }} focus:outline-none">
                    <!-- Hamburger Icon -->
                    <svg id="icon-hamburger" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <!-- Close (X) Icon -->
                    <svg id="icon-close" class="h-6 w-6 hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-[#203B6E] pb-3">
        <a href="{{ route('home') }}" class="block px-4 py-2 text-white hover:bg-gray-700">Home</a>
        <a href="{{ route('treatments.index') }}" class="block px-4 py-2 text-white hover:bg-gray-700">Treatments</a>
        <a href="{{ route('allon4implant') }}" class="block px-4 py-2 text-white hover:bg-gray-700">All-on-4
            Implant</a>
        <a href="{{ route('pricing.index') }}" class="block px-4 py-2 text-white hover:bg-gray-700">Pricing</a>
        <a href="{{ route('about') }}" class="block px-4 py-2 text-white hover:bg-gray-700">About Us</a>
        <a href="{{ route('blog.index') }}" class="block px-4 py-2 text-white hover:bg-gray-700">Blog</a>
        <a href="{{ route('booknow') }}"
            class="block px-4 py-2 mr-2 ml-2 text-white bg-[#7DB8D8] hover:bg-[#6ca7c8] mt-2 rounded-md font-semibold">
            Book Now
        </a>
    </div>
</nav>

<script type="module">
    const button = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    const iconHamburger = document.getElementById('icon-hamburger');
    const iconClose = document.getElementById('icon-close');
    const navbar = document.getElementById('navbar');
    const biaLogox = document.getElementById('biaLogox');
    const isHome = {{ request()->routeIs('home') ? 'true' : 'false' }};
    const isFacilities = {{ request()->routeIs('facilities') ? 'true' : 'false' }};
    // Toggle mobile menu
    button.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        iconHamburger.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');

        if (iconHamburger.classList.contains('hidden')) {
            if (!isHome && !isFacilities) {
                biaLogox.src = "{{ Vite::asset('resources/images/logo-white.webp') }}";
                menu.classList.add('absolute', 'z-10', 'w-full');
                iconClose.classList.add('text-white');
                navbar.style.backgroundColor = '#203B6E';
            } else {
                navbar.style.backgroundColor = '#203B6E';
            }
        } else {
            if (!isHome && !isFacilities) {
                biaLogox.src = "{{ Vite::asset('resources/images/logo-blue.webp') }}";
                navbar.style.backgroundColor = '#ffffff'; // Kembali ke putih
            } else {
                navbar.style.backgroundColor = window.scrollY > 100 ? '#203B6E' : 'transparent';
            }
        }
    });

    // Scroll effect for navbar background + shadow
    window.addEventListener('scroll', () => {
        if (iconHamburger.classList.contains('hidden')) return;

        if (window.scrollY > 100) {
            navbar.style.boxShadow = '0 2px 6px rgba(0,0,0,0.2)';
            if (isHome || isFacilities) {
                navbar.style.backgroundColor = '#203B6E';
                navbar.style.transition = 'background-color 0.3s ease-in-out';
            }
        } else {
            navbar.style.boxShadow = 'none';
            if (isHome || isFacilities) {
                navbar.style.backgroundColor = 'transparent';
                navbar.style.transition = 'background-color 0.3s ease-in-out';
            }
        }

    });

    // Reset ke desktop (>= md: 768px)
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            menu.classList.add('hidden');
            iconHamburger.classList.remove('hidden');
            iconClose.classList.add('hidden');

            navbar.style.boxShadow = window.scrollY > 100 ? '0 2px 6px rgba(0,0,0,0.2)' : 'none';
            if (isHome || isFacilities) {
                navbar.style.backgroundColor = window.scrollY > 100 ? '#203B6E' : 'transparent';
            }
        }
    });
</script>
