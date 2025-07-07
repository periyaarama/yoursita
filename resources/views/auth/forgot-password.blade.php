<x-guest-layout>
    <style>
        body {
            background: radial-gradient(circle at top left, #ffe3a3, #fbc0c6);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: white;
            padding: 2.5rem 2rem;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
            margin-left: 570px;
        }

        .card img {
            width: 80px;
            margin: 0 auto 1.5rem;
            display: block;
        }

        .card h2 {
            font-size: 24px;
            margin-bottom: 0.25rem;
            color: #333;

        }

        .card p {
            font-size: 14px;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }

        .form-group label {
            font-size: 14px;
            color: #333;
            margin-left: 10px;
        }

        .form-group input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 999px;
        }

        .btn {
            background-color: #f39c12;
            color: white;
            border: none;
            padding: 10px 20px;
            width: 100%;
            border-radius: 999px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #e67e22;
        }

        .back-link {
            display: block;
            margin-top: 1rem;
            font-size: 13px;
            color: #444;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .status {
            font-size: 14px;
            color: green;
            margin-bottom: 10px;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>

    <div class="card">
        <img src="{{ asset('images/reset.png') }}" alt="Reset Icon">
        <h2>Forgot your password?</h2>
        <p><b>Enter your email so we can send you a password reset link</b></p>

        @if (session('status'))
            <div class="status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn" type="submit">Send Email</button>
        </form>

        <a href="{{ route('login') }}" class="back-link">&larr; Back to Login</a>
    </div>
</x-guest-layout>
