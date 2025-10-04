<!-- resources/views/components/navbar.blade.php -->

<nav id="navbar"
    class="w-full {{ request()->routeIs('home') ? 'bg-transparent fixed top-0' : 'bg-white' }} left-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/">
                    @if (request()->routeIs('home'))
                        <img class="h-12 w-auto" src="{{ Vite::asset('resources/images/logo-white.webp') }}"
                            alt="BIA Logo">
                    @else
                        <img class="h-12 w-auto" src="{{ Vite::asset('resources/images/logo-blue.webp') }}"
                            alt="BIA Logo">
                    @endif
                </a>
            </div>

            <!-- Desktop Menu -->
            <div
                class="hidden {{ request()->routeIs('home') ? 'text-white' : 'text-[#203B6E]' }}  md:flex space-x-8 items-center">
                <a href="/" class=" hover:text-gray-300 font-medium">Home</a>
                <a href="/treatments" class=" hover:text-gray-300 font-medium">Treatments</a>
                <a href="#" class=" hover:text-gray-300 font-medium">All-on-4 Implant</a>
                <a href="#" class=" hover:text-gray-300 font-medium">Pricing</a>
                <a href="#" class=" hover:text-gray-300 font-medium">About Us</a>
                <a href="/blog" class=" hover:text-gray-300 font-medium">Blog</a>

                <!-- Book Now Button -->
                <div class="hidden md:flex">
                    <a href="#"
                        class="bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                        BOOK NOW
                    </a>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-white focus:outline-none">
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
        <a href="/" class="block px-4 py-2 text-white hover:bg-gray-700">Home</a>
        <a href="#" class="block px-4 py-2 text-white hover:bg-gray-700">Treatments</a>
        <a href="#" class="block px-4 py-2 text-white hover:bg-gray-700">All-on-4 Implant</a>
        <a href="#" class="block px-4 py-2 text-white hover:bg-gray-700">Pricing</a>
        <a href="#" class="block px-4 py-2 text-white hover:bg-gray-700">About Us</a>
        <a href="#" class="block px-4 py-2 text-white hover:bg-gray-700">Blog</a>
        <a href="#"
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

    // Toggle mobile menu
    button.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        iconHamburger.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');

        if (iconHamburger.classList.contains('hidden')) {
            navbar.style.backgroundColor = '#203B6E';
        } else {
            if (window.scrollY > 100) {
                navbar.style.backgroundColor = '#203B6E';
            } else {
                navbar.style.backgroundColor = 'transparent';
            }
        }
    });

    // Scroll effect for navbar background + shadow
    window.addEventListener('scroll', () => {
        if (iconHamburger.classList.contains('hidden')) return;

        if (window.scrollY > 100) {
            navbar.style.backgroundColor = '#203B6E';
            navbar.style.boxShadow = '0 2px 6px rgba(0,0,0,0.2)';
        } else {
            navbar.style.backgroundColor = 'transparent';
            navbar.style.boxShadow = 'none';
        }
    });

    // Reset ke desktop (>= md: 768px)
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            menu.classList.add('hidden');
            iconHamburger.classList.remove('hidden');
            iconClose.classList.add('hidden');

            if (window.scrollY > 100) {
                navbar.style.backgroundColor = '#203B6E';
            } else {
                navbar.style.backgroundColor = 'transparent';
            }
        }
    });
</script>
