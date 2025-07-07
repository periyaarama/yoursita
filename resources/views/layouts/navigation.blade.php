@php
    $dashboardRoute = Auth::user()->hasRole('admin') ? route('admin.dashboard') : route('dashboard');
    $currentRoute = request()->route()->getName();
    $isAdmin = Auth::user()->hasRole('admin');
    $isClient = Auth::user()->hasRole('client');

    $navLinks = [
        [
            'name' => 'Dashboard',
            'route' => $isAdmin ? 'admin.dashboard' : 'dashboard',
            'icon' => 'M3 12l2-2m0 0l7-7 7 7m-9 2v10',
            'children' => $isAdmin ? [] : [
                ['name' => 'About', 'href' => route('dashboard') . '#about'],
                ['name' => 'FAQ', 'href' => route('dashboard') . '#faq'],
                ['name' => 'Feedback', 'href' => route('dashboard') . '#feedback'],
                ['name' => 'Contact', 'href' => route('dashboard') . '#contact'],
            ],
        ],
        [
            'name' => 'Services',
            'route' => $isAdmin ? 'admin.services.index' : null,
            'href' => $isAdmin ? route('admin.services.index') : route('dashboard') . '#services',
            'icon' => 'M9.75 17L9 21m6-4l.75 4M7 21h10M5 10l1.5 1.5L12 5l5.5 6.5L19 10',
        ],
        ['name' => 'Portfolio', 'route' => 'portfolio', 'icon' => 'M3 7V6a2 2 0 012-2h3.586a1 1 0 01.707.293L12 6h7a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z'],
        ['name' => 'Booking', 'route' => 'booking.view', 'clientOnly' => true, 'icon' => 'M8 7V3m8 4V3m-9 10h6m-6 4h4m4 0h1a2 2 0 002-2V7a2 2 0 00-2-2h-1m-4 0h-4'],
        ['name' => 'My Bookings', 'route' => $isAdmin ? 'admin.bookings.upcoming' : 'my_bookings', 'icon' => 'M8 16h8M8 12h8M9 8h6m-3-5a9 9 0 110 18 9 9 0 010-18z'],
        ['name' => 'Clients', 'route' => 'admin.clients', 'adminOnly' => true, 'icon' => 'M4 6h16M4 10h16M4 14h10M4 18h10'],
        ['name' => 'Analytics', 'route' => 'admin.analytics', 'adminOnly' => true, 'icon' => 'M11 3v2m0 14v2m8-8h2M3 12H1m15.07-6.93l1.41 1.41M4.93 19.07l1.41-1.41M19.07 19.07l-1.41-1.41M4.93 4.93L3.52 6.34'],
    ];
@endphp

<nav style="background-color: #fff4dc;" class="border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ $dashboardRoute }}">
                    <img src="{{ asset('images/yoursita_logo.png') }}" alt="Y Logo" class="block h-20 w-auto" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:flex items-center space-x-8">
                @foreach ($navLinks as $link)
                    @php
                        $isClientOnly = $link['clientOnly'] ?? false;
                        $isAdminOnly = $link['adminOnly'] ?? false;
                        $isVisible = !($isClientOnly && !$isClient || $isAdminOnly && !$isAdmin);
                        $isRoute = isset($link['route']);
                        $href = $link['href'] ?? ($isRoute ? route($link['route']) : '#');
                        $isActive = $isRoute && $currentRoute === $link['route'];
                        $hasDropdown = isset($link['children']) && count($link['children']) > 0;
                    @endphp

                    @if ($isVisible)
                        <div x-data="{ open: false }" class="relative">
                            @if ($hasDropdown)
                                <button @click="open = !open"
                                    class="text-gray-700 font-medium hover:text-yellow-500 text-base flex items-center gap-1 border-b-2 {{ $isActive ? 'border-blue-500' : 'border-transparent' }}">

                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="{{ $link['icon'] }}" />
                                    </svg>
                                    {{ $link['name'] }}
                                    <svg class="w-4 h-4 ml-1 transform transition-transform" :class="open ? 'rotate-180' : ''"
                                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition x-cloak
                                    class="absolute top-full mt-2 bg-white border border-gray-200 shadow-lg rounded-md w-44 z-50">
                                    @foreach ($link['children'] as $child)
                                        <a href="{{ $child['href'] }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-100">
                                            {{ $child['name'] }}
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <x-nav-link href="{{ $href }}" :active="$isActive"
                                    class="text-black font-bold hover:text-yellow-500 text-[19px] flex items-center gap-1 border-b-2 {{ $isActive ? 'border-blue-500' : 'border-transparent' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="{{ $link['icon'] }}" />
                                    </svg>
                                    {{ $link['name'] }}
                                </x-nav-link>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Right Section: Points, Reward, Profile -->
            <div class="relative flex items-center gap-3 ml-6">
                @if ($isClient)
                    <div class="bg-yellow-300 text-black font-bold text-sm px-3 py-1 rounded-full">
                        ⭐ {{ Auth::user()->loyaltyPoints }} pts
                    </div>
                @endif

                @if ($isClient && Auth::user()->loyaltyPoints >= 1000)
                    <div x-data="{ openReward: false }" class="relative z-50">
                        <button @click="openReward = !openReward"
                                class="cursor-pointer bg-green-600 hover:bg-green-700 text-white font-bold px-3 py-1.5 rounded-full shadow text-sm flex items-center justify-center">
                            🎁
                        </button>
                        <div x-show="openReward" @click.away="openReward = false" x-transition x-cloak
                             class="absolute top-full right-0 mt-2 w-56 bg-white border border-gray-200 shadow-lg rounded-lg p-3 text-sm text-center z-50">
                            <p class="font-semibold text-gray-800 mb-2">🎁 Redeem Free Makeover</p>
                            <form action="{{ route('redeem.reward') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded-md font-semibold shadow w-full">
                                    Redeem Now
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Profile Dropdown -->
                <div x-data="{ openProfile: false }" class="relative z-50">
                    <button @click="openProfile = !openProfile"
                            class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm font-bold rounded-md text-black bg-transparent hover:text-yellow-500 transition duration-150">
                        <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v1.2c0 .7.5 1.2 1.2 1.2h16.8c.7 0 1.2-.5 1.2-1.2v-1.2c0-3.2-6.4-4.8-9.6-4.8z" />
                        </svg>
                        <span class="text-sm font-semibold">{{ Auth::user()->name }}</span>
                    </button>
                    <div x-show="openProfile" @click.away="openProfile = false" x-transition x-cloak
                         class="absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-md shadow-md text-sm z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-yellow-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-yellow-100">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
