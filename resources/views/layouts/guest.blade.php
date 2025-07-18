<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-custom flex min-h-screen justify-center items-center" style="margin:0; padding:0; font-family: 'Segoe UI', sans-serif; background: radial-gradient(circle at top left, #ffeaa7, #fab1a0, #fbc0c6);">
    <div class="w-full">
        {{ $slot }}
    </div>
</body>

</html>
