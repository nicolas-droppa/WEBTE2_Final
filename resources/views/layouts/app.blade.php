<!DOCTYPE html>
<html lang="sk" class="{{ session('theme', 'light') }}"> {{-- pridáme class pre dark mode --}}

<head>
    <meta charset="UTF-8">
    <title>M3th</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Font-awesome ( icons ) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- KaTeX for expressions -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.15.3/dist/katex.min.css" />

    <script src="//unpkg.com/alpinejs" defer></script>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-[#18181a] dark:text-gray-100 transition-colors duration-300">
    @include('layouts.navigation')

    <main class="container mx-auto mt-8">
        @yield('content')
    </main>

    @yield('scripts')
</body>

</html>