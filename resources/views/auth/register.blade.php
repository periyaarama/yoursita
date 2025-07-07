<x-guest-layout>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            background: radial-gradient(circle at top left, #ffe3a3, #fbc0c6);
        }

        .page-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .register-card {
            background: white;
            padding: 3rem 5rem;
            border-radius: 1.5rem;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 1200px;
        }

        .logo {
            width: 140px;
            margin: 0 auto 50px;
            display: block;
        }

        .form-row {
            display: flex;
            gap: 2rem;
        }

        .form-row>div {
            flex: 1;
        }

        .btn-register {
            background-color: #f1c40f;
            color: black;
            font-weight: bold;
            padding: 10px 25px;
        }

        .btn-register:hover {
            background-color: #e0ac00;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-section {
            margin-top: 1.5rem;
        }
    </style>

    <div class="page-wrapper">
        <div class="register-card">
            <img src="{{ asset('images/yoursita_logo.png') }}" alt="Y Logo" class="logo">

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <!-- Username & Email -->
                <div class="form-row">
                    <div>
                        <x-input-label for="username" :value="__('Username')" />
                        <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                            :value="old('username')" required />
                    </div>
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required />
                    </div>
                </div>


                <!-- Passwords -->
                <div class="form-row form-section">
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />
                    </div>
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required />
                    </div>
                </div>

                <!-- First & Last Name -->
                <div class="form-row form-section">
                    <div>
                        <x-input-label for="firstName" :value="__('First Name')" />
                        <x-text-input id="firstName" class="block mt-1 w-full" type="text" name="firstName"
                            :value="old('firstName')" required />
                    </div>
                    <div>
                        <x-input-label for="lastName" :value="__('Last Name')" />
                        <x-text-input id="lastName" class="block mt-1 w-full" type="text" name="lastName"
                            :value="old('lastName')" required />
                    </div>
                </div>

                <!-- Phone & DOB -->
                <div class="form-row form-section">
                    <div>
                        <x-input-label for="phoneNumber" :value="__('Phone Number')" />
                        <x-text-input id="phoneNumber" class="block mt-1 w-full" type="text" name="phoneNumber"
                            :value="old('phoneNumber')" required />
                    </div>
                    <div>
                        <x-input-label for="dateOfBirth" :value="__('Date of Birth')" />
                        <x-text-input id="dateOfBirth" class="block mt-1 w-full" type="date" name="dateOfBirth"
                            :value="old('dateOfBirth')" required />
                    </div>
                </div>

                <!-- Footer -->
                <div class="form-footer mt-6">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="btn-register">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>