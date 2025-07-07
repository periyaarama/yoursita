<x-app-layout>
    <div x-data="{ showModal: false, currentImage: '' }">
        <div class="px-6 py-12 min-h-screen bg-gradient-to-r from-[#FFE1AB] to-[#FBC0C6]">
            <div class="max-w-6xl mx-auto">
                <!-- Title -->
                <h1 class="text-3xl font-bold font-playfair capitalize mb-10 text-center text-gray-800 tracking-wide">
                    Leg Henna Portfolio
                </h1>

                <!-- Gallery -->
                <div class="columns-1 sm:columns-2 md:columns-3 gap-6 space-y-6">
                    @foreach ($images as $img)
    <div @click="showModal = true; currentImage = '{{ asset($img->url) }}'"
     data-aos="fade-up"
     class="break-inside-avoid cursor-pointer transition-transform duration-300 hover:scale-[1.02]">

        <img src="{{ asset($img->url) }}"
             alt="Leg Henna"
             class="w-full rounded-xl shadow-md object-cover">
    </div>
@endforeach


                </div>

                <!-- Back Button -->
                <div class="mt-12 text-center">
                    <a href="{{ route('portfolio') }}"
                       class="inline-block bg-pink-600 text-white px-6 py-2 rounded-full font-semibold hover:bg-pink-700 transition">
                        ← Back to Galleries
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal (outside the grid, but inside Alpine scope) -->
        <div x-show="showModal" x-transition
             class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50"
             @keydown.window.escape="showModal = false">
            <div class="relative max-w-4xl w-full px-4">
                <img :src="currentImage"
                     class="max-h-[90vh] mx-auto rounded-xl object-contain shadow-2xl"
                     alt="Enlarged Image">
                <button @click="showModal = false"
                        class="absolute top-3 right-4 text-white text-4xl font-bold hover:text-pink-400 leading-none z-50">
                    &times;
                </button>
            </div>
        </div>
    </div>

    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init();</script>
</x-app-layout>
