<x-app-layout>
    @php
        $isAdmin = Auth::check() && Auth::user()->hasRole('admin');
    @endphp

    <div class="px-6 py-12 min-h-screen {{ $isAdmin ? 'bg-[#FFE1AB]' : 'bg-gradient-to-br from-[#FFE1AB] to-[#FBC0C6]' }}">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-4xl font-bold text-center text-gray-800 mb-12 font-playfair tracking-wide">
                The Galleries
            </h1>

            <!-- Henna Services -->
            <h2 class="text-2xl font-semibold mb-4">Henna Services</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-10">
                @include('components._portfolio-card', [
                    'link' => route('portfolio.handhenna'),
                    'image' => 'images/sample-hand.jpg',
                    'label' => 'Hand Henna'
                ])
                @include('components._portfolio-card', [
                    'link' => route('portfolio.leghenna'),
                    'image' => 'images/sample-leg.jpg',
                    'label' => 'Leg Henna'
                ])
                @include('components._portfolio-card', [
                    'link' => route('portfolio.bridalhenna'),
                    'image' => 'images/sample-bridal.jpg',
                    'label' => 'Bridal Henna'
                ])
            </div>

            <!-- Hairstyle Services -->
            <h2 class="text-2xl font-semibold mb-4">Hairstyle Services</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-10">
                @include('components._portfolio-card', [
                    'link' => route('portfolio.braidhairstyle'),
                    'image' => 'images/sample-braid.jpg',
                    'label' => 'Braid Hairstyle'
                ])
                @include('components._portfolio-card', [
                    'link' => route('portfolio.bunhairstyle'),
                    'image' => 'images/sample-bun.jpg',
                    'label' => 'Bun Hairstyle'
                ])
                @include('components._portfolio-card', [
                    'link' => route('portfolio.halfuphairstyle'),
                    'image' => 'images/sample-halfup.jpg',
                    'label' => 'Half-Up Hairstyle'
                ])
            </div>

            <!-- Makeup Services -->
            <h2 class="text-2xl font-semibold mb-4">Makeup Services</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-10">
                @include('components._portfolio-card', [
                    'link' => route('portfolio.bridalmakeup'),
                    'image' => 'images/sample-bridalmakeup.jpg',
                    'label' => 'Bridal Makeup'
                ])
                @include('components._portfolio-card', [
                    'link' => route('portfolio.chinesemakeup'),
                    'image' => 'images/sample-chinese.jpg',
                    'label' => 'Chinese Makeup'
                ])
                @include('components._portfolio-card', [
                    'link' => route('portfolio.indianmakeup'),
                    'image' => 'images/sample-indian.jpg',
                    'label' => 'Indian Makeup'
                ])
            </div>
        </div>
    </div>
</x-app-layout>
