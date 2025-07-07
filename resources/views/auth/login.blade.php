<x-guest-layout>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            background: radial-gradient(circle at top left, #ffe3a3, #fbc0c6);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-wrapper {
            width: 900px;
            height: 550px;
            display: flex;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            overflow: hidden;
        }

        .left-panel {
            width: 50%;
            position: relative;
        }

        .slider {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .slide {
            position: absolute;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .slide.active {
            opacity: 1;
        }

        .right-panel {
            width: 50%;
            padding: 50px 40px;
            background-color: rgba(255, 255, 255, 0.9);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            width: 100px;
            margin: 0 auto 30px;
        }

        .login-form {
            width: 100%;
            max-width: 350px;
            margin: 0 auto;
        }

        .btn-login {
            background-color: #f1c40f;
            color: black;
            font-weight: bold;
            padding: 10px 25px;
        }

        .btn-login:hover {
            background-color: #e0ac00;
        }

        .form-link {
            font-size: 0.9rem;
            margin-top: 10px;
            display: inline-block;
            color: #666;
        }

        .form-link:hover {
            color: #d24f55;
        }
    </style>

    <div class="login-wrapper">
        <!-- LEFT PANEL (Image Slideshow) -->
        <div class="left-panel">
            <div class="slider">
                <div class="slide active" style="background-image: url('{{ asset('images/bride1.jpg') }}');"></div>
                <div class="slide" style="background-image: url('{{ asset('images/bride2.jpeg') }}');"></div>
                <div class="slide" style="background-image: url('{{ asset('images/bride3.jpeg') }}');"></div>
                <div class="slide" style="background-image: url('{{ asset('images/bride4.png') }}');"></div>
                <div class="slide" style="background-image: url('{{ asset('images/bride5.webp') }}');"></div>
            </div>
        </div>

        <!-- RIGHT PANEL (Login Form) -->
        <div class="right-panel">
            <img src="{{ asset('images/yoursita_logo.png') }}" alt="Y Logo" class="logo">

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4 text-left">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- Submit + Forgot -->
                <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="form-link" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="btn-login ml-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- SLIDESHOW SCRIPT -->
    <script>
        const slides = document.querySelectorAll('.slide');
        let index = 0;

        setInterval(() => {
            slides[index].classList.remove('active');
            index = (index + 1) % slides.length;
            slides[index].classList.add('active');
        }, 4000); // Change every 4 seconds
    </script>
</x-guest-layout>
