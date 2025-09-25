<footer class="bg-[#203B6E] text-white py-10">
    <div class="container mx-auto px-4 py-6 flex flex-col md:flex-row md:justify-between lg:gap-8 gap-12">

        <!-- Kolom 1: Logo & Sosial Media -->
        <div class="flex-1">
            <!-- Logo -->
            <div class="mb-4">
                <img src="{{ Vite::asset('resources/images/logo-white.webp') }}" alt="Logo"
                    class="h-16 w-auto pb-2 m-auto">
            </div>
            <!-- Social Media -->
            <div class="flex space-x-3 justify-center">
                <a href="#" aria-label="Instagram" class="hover:text-gray-400">
                    <i class="fa-xl fab fa-instagram"></i>
                </a>
                <a href="#" aria-label="Facebook" class="hover:text-gray-400">
                    <i class="fa-xl fab fa-facebook-f"></i>
                </a>
                <a href="#" aria-label="Youtube" class="hover:text-gray-400">
                    <i class="fa-xl fab fa-youtube"></i>
                </a>
                <a href="#" aria-label="Twitter" class="hover:text-gray-400">
                    <i class="fa-xl fab fa-twitter"></i>
                </a>
                <a href="#" aria-label="Twitter" class="hover:text-gray-400">
                    <i class="fa-xl fab fa-x-twitter"></i>
                </a>
                <a href="#" aria-label="Whatsapp" class="hover:text-gray-400">
                    <i class="fa-xl fab fa-whatsapp"></i>
                </a>
                <a href="#" aria-label="LinkedIn" class="hover:text-gray-400">
                    <i class="fa-xl fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>

        <!-- Kolom 2: Address & Opening Hours -->
        <div class="flex-1">
            <h3 class="font-montserrat font-semibold mb-2">Address</h3>
            <p class="text-gray-300 mb-4 w-3/4 md:w-full">
                Jln. Sunset Road No. 168, Seminyak, Kuta, Badung, Bali, Indonesia 80361
            </p>
            <h3 class="font-montserrat font-semibold mb-2">Opening Hours</h3>
            <ul class="text-gray-300">
                <li><span>&#8226;</span> Monday - Friday | 09.00 AM - 09.00 PM</li>
                <li><span>&#8226;</span> Saturday & Sunday | 09.00 AM - 07.00 PM</li>
            </ul>
        </div>

        <!-- Kolom 3: Links -->
        <div class="flex-1">
            <ul class="flex flex-row md:flex-col space-x-4 md:space-x-0 md:space-y-2 justify-around md:justify-start">
                <li><a href="#" class="hover:text-gray-400">Career</a></li>
                <li><a href="#" class="hover:text-gray-400">Social Activity</a></li>
                <li><a href="#" class="hover:text-gray-400">FAQ</a></li>
            </ul>
        </div>

    </div>
</footer>
