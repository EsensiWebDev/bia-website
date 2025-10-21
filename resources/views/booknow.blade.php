@extends('layouts.app')

@section('content')
    {{-- After Header Section --}}
    <x-after-header styleSection="pt-48 pb-86" title="Reservation Form"
        subHeading="<div class='mt-5 flex md:flex-row flex-wrap gap-3 md:gap-5 justify-center'></div>"
        backUrl="<a href='#' class='hidden absolute top-8 left-6'></a>" />

    {{-- Form Reservation & Content --}}
    <section class="max-w-4xl mx-auto px-4 border-b border-gray-200 pb-24">
        <!-- Gambar Thumbnail -->
        <div class="-mt-36 relative z-0 shadow-md">
            <div class="bg-white py-18 px-18">

                {{-- ✅ Alert messages --}}
                @if (session('success'))
                    <div class="mb-6 rounded-md bg-green-100 border border-green-300 text-green-700 px-4 py-3">
                        {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="mb-6 rounded-md bg-red-100 border border-red-300 text-red-700 px-4 py-3">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('booknow.store') }}" method="POST" class="mx-auto">
                    @csrf
                    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">

                        {{-- First Name --}}
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-gray-900">First name</label>
                            <div class="mt-2.5">
                                <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}"
                                    class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 outline-gray-300
                        placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600"
                                    required>
                                @error('first_name')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Last Name --}}
                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-gray-900">Last name</label>
                            <div class="mt-2.5">
                                <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}"
                                    class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 outline-gray-300
                        placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600"
                                    required>
                                @error('last_name')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-900">Phone number</label>
                            <div class="mt-2.5">
                                <input id="phone" name="phone" type="text" placeholder="123-456-7890"
                                    value="{{ old('phone') }}"
                                    class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 outline-gray-300
                        placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600"
                                    required>
                                @error('phone')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-900">Email</label>
                            <div class="mt-2.5">
                                <input id="email" name="email" type="email" value="{{ old('email') }}"
                                    class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 outline-gray-300
                        placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600"
                                    required>
                                @error('email')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Preferred Date --}}
                        <div>
                            <label for="preferred_date" class="block text-sm font-semibold text-gray-900">Preferred
                                Date</label>
                            <div class="mt-2.5">
                                <input id="preferred_date" name="preferred_date" type="date"
                                    value="{{ old('preferred_date') }}"
                                    class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 outline-gray-300
                        focus:outline-2 focus:outline-indigo-600"
                                    required>
                                @error('preferred_date')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Preferred Time --}}
                        <div>
                            <label for="preferred_time" class="block text-sm font-semibold text-gray-900">Preferred
                                Time</label>
                            <div class="mt-2.5">
                                <input id="preferred_time" name="preferred_time" type="time"
                                    value="{{ old('preferred_time', '00:00') }}"
                                    class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 outline-gray-300
                        focus:outline-2 focus:outline-indigo-600"
                                    required>
                                @error('preferred_time')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Required Service --}}
                        <div>
                            <label for="required_service" class="block text-sm font-semibold text-gray-900">Required
                                Service</label>
                            <div class="mt-2.5 grid shrink-0 grid-cols-1 focus-within:relative">
                                <select id="required_service" name="required_service"
                                    class="col-start-1 row-start-1 w-full appearance-none rounded-md py-2 pr-7 pl-3.5 text-base text-[#000] placeholder:text-gray-400 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 !bg-none"
                                    required>
                                    {{-- Placeholder (tidak bisa dipilih) --}}
                                    <option value="" disabled {{ old('required_service') ? '' : 'selected' }}>
                                        -- Select Service --
                                    </option>
                                    @if ($treatments && $treatments->count())
                                        @foreach ($treatments as $treatment)
                                            <option value="{{ $treatment->title }}" @selected(old('required_service') === $treatment->title)>
                                                {{ $treatment->title }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>Service not found</option>
                                    @endif
                                </select>
                                <svg viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"
                                    class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4">
                                    <path
                                        d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" />
                                </svg>
                                @error('required_service')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Country of Origin --}}
                        <div>
                            <label for="country_of_origin" class="block text-sm font-semibold text-gray-900">Country of
                                Origin</label>
                            <div class="mt-2.5 grid shrink-0 grid-cols-1 focus-within:relative">
                                <select id="country_of_origin" name="country_of_origin"
                                    class="col-start-1 row-start-1 w-full appearance-none rounded-md py-2 pr-7 pl-3.5 text-base text-[#000] placeholder:text-gray-400 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 !bg-none"
                                    required>
                                    <option value="" disabled {{ old('country_of_origin') ? '' : 'selected' }}>
                                        -- Select Country --
                                    </option>
                                    <option value="Indonesia" @selected(old('country_of_origin') === 'Indonesia')>Indonesia</option>
                                    <option value="Malaysia" @selected(old('country_of_origin') === 'Malaysia')>Malaysia</option>
                                    <option value="Singapore" @selected(old('country_of_origin') === 'Singapore')>Singapore</option>
                                    <option value="Thailand" @selected(old('country_of_origin') === 'Thailand')>Thailand</option>
                                    <option value="Philippines" @selected(old('country_of_origin') === 'Philippines')>Philippines</option>
                                    <option value="Vietnam" @selected(old('country_of_origin') === 'Vietnam')>Vietnam</option>
                                    <option value="United States" @selected(old('country_of_origin') === 'United States')>United States</option>
                                    <option value="Canada" @selected(old('country_of_origin') === 'Canada')>Canada</option>
                                    <option value="United Kingdom" @selected(old('country_of_origin') === 'United Kingdom')>United Kingdom</option>
                                    <option value="Australia" @selected(old('country_of_origin') === 'Australia')>Australia</option>
                                    <option value="Japan" @selected(old('country_of_origin') === 'Japan')>Japan</option>
                                    <option value="South Korea" @selected(old('country_of_origin') === 'South Korea')>South Korea</option>
                                    <option value="China" @selected(old('country_of_origin') === 'China')>China</option>
                                    <option value="India" @selected(old('country_of_origin') === 'India')>India</option>
                                    <option value="France" @selected(old('country_of_origin') === 'France')>France</option>
                                    <option value="Germany" @selected(old('country_of_origin') === 'Germany')>Germany</option>
                                    <option value="Netherlands" @selected(old('country_of_origin') === 'Netherlands')>Netherlands</option>
                                    <option value="New Zealand" @selected(old('country_of_origin') === 'New Zealand')>New Zealand</option>
                                    <option value="United Arab Emirates" @selected(old('country_of_origin') === 'United Arab Emirates')>United Arab Emirates
                                    </option>
                                </select>
                                <svg viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"
                                    class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4">
                                    <path
                                        d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" />
                                </svg>
                                @error('country_of_origin')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- How did you find out --}}
                        <div class="sm:col-span-2">
                            <label for="how_did_you_find_out" class="block text-sm font-semibold text-gray-900">How did
                                you
                                find out?</label>
                            <div class="mt-2.5">
                                <input id="how_did_you_find_out" name="how_did_you_find_out" type="text"
                                    value="{{ old('how_did_you_find_out') }}"
                                    class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 outline-gray-300
                        focus:outline-2 focus:outline-indigo-600"
                                    required>
                            </div>
                        </div>

                        {{-- Message --}}
                        <div class="sm:col-span-2">
                            <label for="message" class="block text-sm font-semibold text-gray-900">Message</label>
                            <div class="mt-2.5">
                                <textarea id="message" name="message" rows="4"
                                    class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 outline-gray-300
                        focus:outline-2 focus:outline-indigo-600"
                                    required>{{ old('message') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <button type="submit"
                            class="inline-block bg-[#7DB8D8] hover:bg-[#6ca7c8] text-white px-6 py-3 font-semibold transition">
                            SUBMIT
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </section>

    {{-- Cancelled & Missed Appointments Section --}}
    <section class="cancel_missed bg-white relative w-full">
        <div class="container mx-auto px-6 lg:px-20 py-16 flex flex-col lg:flex-row items-center gap-0 md:gap-24">
            <!-- Text Content -->
            <div class="lg:w-1/2">
                <h2 class="text-4xl font-[400] text-[#000] mb-6 text-center md:text-right">
                    Cancelled & Missed <br>Appointments
                </h2>

            </div>

            <!-- Image -->
            <div class="lg:w-1/2 mx-3 md:mx-0">
                <div class="detail-maintenance font-montserrat w-full text-gray-700 mb-4">
                    <p class="mb-6 text-justify">At BIA Dental Center, we value both your time and the personalized care we
                        provide for each patient. To ensure we maintain the highest standards of service and accommodate all
                        our valued guests, we kindly ask for your understanding and cooperation regarding appointment
                        changes.
                    </p>

                    <h2 class="text-2xl">Cancellation Notice</h2>
                    <p class="mb-6 text-justify">If you are unable to attend your scheduled appointment, we kindly request
                        that you notify us at least 24 hours in advance. This allows us to offer your reserved time to other
                        patients in need of care.</p>

                    <h2 class="text-2xl">Missed or Late Cancellation Fee</h2>
                    <p class="mb-6 text-justify">Appointments that are cancelled with less than 24 hours notice or missed
                        without prior notice will incur a cancellation fee of IDR 200,000. This policy supports the
                        commitment of our team and ensures availability for all patients seeking timely treatment.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Operating Hours Section --}}
    <section class="operating_hours bg-[#203B6E] relative w-full  px-6 lg:px-20 py-16">
        <h2 class="text-4xl font-[400] text-[#fff] mb-6 text-center">
            Operating Hours
        </h2>
        <div class="container max-w-3xl mx-auto flex flex-col md:flex-row items-center gap-10 md:gap-8 mt-12">
            <!-- Text Content -->
            <div class="w-full md:w-1/2 gap-4 flex flex-col text-center">
                <h2 class="text-[#fff] text-2xl font-montserrat ">Monday - Friday</h2>
                <p class="text-[#fff]"> 09.00 AM - 09.00 PM</p>
            </div>

            <!-- Image -->
            <div class="w-full md:w-1/2 gap-4 flex flex-col text-center">
                <h2 class="text-[#fff] text-2xl font-montserrat ">Saturday & Sunday</h2>
                <p class="text-[#fff]"> 09.00 AM - 07.00 PM</p>
            </div>
        </div>
    </section>

    {{-- Map & Contact Section --}}
    <section class="maps_contact bg-[#fff] relative w-full  px-6 lg:px-20 py-16">
        <h2 class="text-4xl font-[400] text-[#000] mb-6 text-center">
            Map & Contact Info
        </h2>
        <div class="max-w-7xl grid grid-cols-1 md:grid-cols-3 gap-10 mb-14 m-auto mt-12">
            <!-- Text Content -->
            <div
                class="group relative bg-[#FBFBFB] shadow-lg rounded-md hover:shadow-xl transition w-full py-6 px-4 flex flex-row items-center justify-around gap-4">
                <div class="bg-[#AFF4C6] px-2 py-4 rounded-2xl"><i
                        class="text-[3.5em] text-[#14AE5C] fab fa-whatsapp"></i></div>
                <div>
                    <h2 class="text-[#000] font-semibold text-xl font-montserrat mb-2">Whatsapp</h2>
                    <p class="text-[#000] text-lg">+62 1234567890</p>
                </div>
            </div>

            <!-- Image -->
            <div
                class="group relative bg-[#FBFBFB] shadow-lg rounded-md hover:shadow-xl transition w-full py-6 px-4 flex flex-row items-center justify-around gap-4">
                <div class="bg-[#FFE8A3] px-2 py-4 rounded-2xl"><i
                        class="text-[3.5em] text-[#E6A204] fa-regular fa-envelope"></i></div>
                <div>
                    <h2 class="text-[#000] font-semibold text-xl font-montserrat mb-2">Email</h2>
                    <p class="text-[#000] text-lg">email@email.com</p>
                </div>
            </div>

            <!-- Image -->
            <div
                class="group relative bg-[#FBFBFB] shadow-lg rounded-md hover:shadow-xl transition w-full py-6 px-4 flex flex-row items-center justify-around gap-4">
                <div class="bg-[#AFF4C6] px-2 py-4 rounded-2xl"><i
                        class="text-[3.5em] text-[#14AE5C] fa-solid fa-phone"></i></div>
                <div>
                    <h2 class="text-[#000] font-semibold text-xl font-montserrat mb-2">Phone</h2>
                    <p class="text-[#000] text-lg">+62 123456789</p>
                </div>
            </div>
        </div>
        <div class="w-full grid grid-cols-1">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3291.852693716313!2d115.16796597413621!3d-8.685783888456143!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2478e9c76768d%3A0xc2b5978e9604021f!2sBIA%20(Bali%20Implant%20Aesthetic)%20Dental%20Center!5e1!3m2!1sid!2sid!4v1760673209232!5m2!1sid!2sid"
                class="w-full h-[700px] border-0" allowfullscreen loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>
@endsection
