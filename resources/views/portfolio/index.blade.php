<x-app-layout>
    <div class="bg-gradient-to-r from-[#FFE1AB] to-[#FBC0C6] py-12">
        <div class="max-w-6xl mx-auto px-6">
            <h1 class="text-4xl font-playfair font-bold text-center text-gray-800 mb-16 tracking-widest">THE GALLERIES</h1>

            {{-- HENNA SECTION --}}
            <div class="mb-16">
                <h2 class="text-2xl font-semibold mb-6 text-left text-gray-800">Henna Services</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <a href="{{ route('portfolio.handhenna') }}" class="relative group rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/portfolio/henna.jpg') }}"
                             class="w-full h-[400px] object-cover transition duration-300 group-hover:blur-sm"
                             alt="Hand Henna">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="text-white text-lg font-semibold">Hand Henna</span>
                        </div>
                    </a>
                    <a href="{{ route('portfolio.leghenna') }}" class="relative group rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/portfolio/leg_henna.jpg') }}"
                             class="w-full h-[400px] object-cover transition duration-300 group-hover:blur-sm"
                             alt="Leg Henna">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="text-white text-lg font-semibold">Leg Henna</span>
                        </div>
                    </a>
                    <a href="{{ route('portfolio.bridalhenna') }}" class="relative group rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/portfolio/bridalhenna.jpg') }}"
                             class="w-full h-[400px] object-cover transition duration-300 group-hover:blur-sm"
                             alt="Bridal Henna">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="text-white text-lg font-semibold">Bridal Henna</span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- HAIRDO SECTION --}}
            <div class="mb-16">
                <h2 class="text-2xl font-semibold mb-6 text-left text-gray-800">Hairdo Services</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <a href="{{ route('portfolio.bunhairstyle') }}" class="relative group rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/portfolio/bunhairstyle.jpg') }}"
                             class="w-full h-[400px] object-cover transition duration-300 group-hover:blur-sm"
                             alt="Bun Hairstyle">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="text-white text-lg font-semibold">Bun Hairstyle</span>
                        </div>
                    </a>
                    <a href="{{ route('portfolio.braidhairstyle') }}" class="relative group rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/portfolio/braidhairstyle.jpg') }}"
                             class="w-full h-[400px] object-cover transition duration-300 group-hover:blur-sm"
                             alt="Braid Hairstyle">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="text-white text-lg font-semibold">Braid Hairstyle</span>
                        </div>
                    </a>
                    <a href="{{ route('portfolio.halfuphairstyle') }}" class="relative group rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/portfolio/halfuphairstyle.png') }}"
                             class="w-full h-[400px] object-cover transition duration-300 group-hover:blur-sm"
                             alt="Half-up Hairstyle">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="text-white text-lg font-semibold">Half-up Hairstyle</span>
                        </div>
                    </a>
                </div>
            </div>

            {{-- MAKEUP SECTION --}}
            <div class="mb-10">
                <h2 class="text-2xl font-semibold mb-6 text-left text-gray-800">Makeup Services</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <a href="{{ route('portfolio.chinesemakeup') }}" class="relative group rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/portfolio/chinesemakeup.jpg') }}"
                             class="w-full h-[400px] object-cover transition duration-300 group-hover:blur-sm"
                             alt="Chinese Makeup">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="text-white text-lg font-semibold">Chinese Makeup</span>
                        </div>
                    </a>
                    <a href="{{ route('portfolio.indianmakeup') }}" class="relative group rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/portfolio/indianmakeup.jpg') }}"
                             class="w-full h-[400px] object-cover transition duration-300 group-hover:blur-sm"
                             alt="Indian Makeup">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="text-white text-lg font-semibold">Indian Makeup</span>
                        </div>
                    </a>
                    <a href="{{ route('portfolio.bridalmakeup') }}" class="relative group rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/portfolio/bridalmakeup.jpg') }}"
                             class="w-full h-[400px] object-cover transition duration-300 group-hover:blur-sm"
                             alt="Bridal Makeup">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                            <span class="text-white text-lg font-semibold">Bridal Makeup</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
