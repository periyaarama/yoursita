<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    {{-- 🔁 Resend Email Verification Form --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
        @csrf
    </form>

    {{-- ✅ All fields below are part of the form in edit.blade.php --}}
    
    {{-- ID (Read-only) --}}
    <div>
        <x-input-label for="id" :value="__('User ID')" />
        <x-text-input id="id" name="id" type="text" class="mt-1 block w-full bg-gray-100 text-gray-700"
                      :value="$user->id" readonly />
    </div>

    {{-- Name --}}
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                      :value="old('name', $user->name)" required autofocus autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    {{-- First Name --}}
    <div>
        <x-input-label for="firstName" :value="__('First Name')" />
        <x-text-input id="firstName" name="firstName" type="text" class="mt-1 block w-full"
                      :value="old('firstName', $user->firstName)" required />
        <x-input-error class="mt-2" :messages="$errors->get('firstName')" />
    </div>

    {{-- Last Name --}}
    <div>
        <x-input-label for="lastName" :value="__('Last Name')" />
        <x-text-input id="lastName" name="lastName" type="text" class="mt-1 block w-full"
                      :value="old('lastName', $user->lastName)" required />
        <x-input-error class="mt-2" :messages="$errors->get('lastName')" />
    </div>

    {{-- Email --}}
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                      :value="old('email', $user->email)" required autocomplete="username" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    {{-- Phone Number --}}
    <div>
        <x-input-label for="phoneNumber" :value="__('Phone Number')" />
        <x-text-input id="phoneNumber" name="phoneNumber" type="text" class="mt-1 block w-full"
                      :value="old('phoneNumber', $user->phoneNumber)" />
        <x-input-error class="mt-2" :messages="$errors->get('phoneNumber')" />
    </div>

    {{-- Date of Birth --}}
    <div>
        <x-input-label for="dateOfBirth" :value="__('Date of Birth')" />
        <x-text-input id="dateOfBirth" name="dateOfBirth" type="date" class="mt-1 block w-full"
                      :value="old('dateOfBirth', $user->dateOfBirth)" />
        <x-input-error class="mt-2" :messages="$errors->get('dateOfBirth')" />
    </div>

</section>
