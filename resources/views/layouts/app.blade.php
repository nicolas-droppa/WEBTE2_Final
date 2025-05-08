<!DOCTYPE html>
<html lang="sk" class="{{ session('theme', 'light') }}"> {{-- pridáme class pre dark mode --}}
<head>
    <meta charset="UTF-8">
    <title>M3th</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="//unpkg.com/alpinejs" defer></script>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">
    @include('layouts.navigation')

    <main class="container mx-auto mt-8">
        @yield('content')
    </main>
</body>
</html>