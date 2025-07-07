<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Henna Services
        </h2>
    </x-slot>

    <div class="min-h-screen py-12 px-4" style="background: radial-gradient(circle at top left, #ffe3a3, #fbc0c6);">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10 font-playfair">
            Choose Your Henna Package
        </h1>

        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10">
            
            <!-- Group Henna -->
            <a href="{{ route('henna.group') }}" class="block bg-white rounded-xl shadow-lg overflow-hidden hover:scale-105 transition-transform">
                <img src="{{ asset('images/group_henna.jpg') }}" alt="Group Henna"
                     class="w-full h-72 object-cover">
                <div class="p-5 text-center">
                    <h2 class="text-2xl font-semibold text-pink-600 mb-2">Group Henna</h2>
                    <p class="text-gray-700 text-sm">
                        Ideal for events and weddings. Book multiple guests in one session.
                    </p>
                </div>
            </a>

            <!-- Individual Henna -->
            <a href="{{ route('henna.individual') }}" class="block bg-white rounded-xl shadow-lg overflow-hidden hover:scale-105 transition-transform">
                <img src="{{ asset('images/individual_henna.jpg') }}" alt="Individual Henna"
                     class="w-full h-72 object-cover">
                <div class="p-5 text-center">
                    <h2 class="text-2xl font-semibold text-pink-600 mb-2">Individual Henna</h2>
                    <p class="text-gray-700 text-sm">
                        Choose personalized designs for hands and legs.
                    </p>
                </div>
            </a>

        </div>
    </div>
</x-app-layout>
