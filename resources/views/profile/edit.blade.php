<x-app-layout>
    <div class="min-h-screen bg-gradient-to-r from-[#ffe3a3] to-[#f9b6c1] py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ✅ PROFILE INFO FORM --}}
            <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Profile Information</h2>
            <form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Column -->
        <div class="space-y-4">
            <div>
    <x-input-label for="username" :value="__('Username')" />
    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full"
        :value="old('username', $user->username)" />
</div>


            <div>
                <x-input-label for="firstName" :value="__('First Name')" />
                <x-text-input id="firstName" name="firstName" type="text" class="mt-1 block w-full"
                    :value="old('firstName', $user->firstName)" />
            </div>
            <div>
                <x-input-label for="phoneNumber" :value="__('Phone Number')" />
                <x-text-input id="phoneNumber" name="phoneNumber" type="text" class="mt-1 block w-full"
                    :value="old('phoneNumber', $user->phoneNumber)" />
            </div>
            
        </div>

        <!-- Right Column -->
        <div class="space-y-4">
        <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                    :value="old('email', $user->email)" />
            </div>
            <div>
                <x-input-label for="lastName" :value="__('Last Name')" />
                <x-text-input id="lastName" name="lastName" type="text" class="mt-1 block w-full"
                    :value="old('lastName', $user->lastName)" />
            </div>

            

            <div>
                <x-input-label for="dateOfBirth" :value="__('Date of Birth')" />
                <x-text-input id="dateOfBirth" name="dateOfBirth" type="date" class="mt-1 block w-full"
                    :value="$user->dateOfBirth ? \Carbon\Carbon::parse($user->dateOfBirth)->format('Y-m-d') : ''" />
            </div>
        </div>
    </div>

    <!-- Buttons -->
    <div class="mt-6 flex gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>
        <a href="{{ route('profile.edit') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md font-semibold text-sm shadow-sm transition">
            {{ __('Cancel') }}
        </a>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="mt-4 text-sm text-green-600">
            {{ __('Profile updated successfully.') }}
        </div>
    @endif
</form>

            </div>

            {{-- ✅ PASSWORD UPDATE FORM --}}
            <div class="bg-white shadow rounded-lg p-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- ✅ DELETE ACCOUNT FORM --}}
            <div class="bg-white shadow rounded-lg p-6">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
