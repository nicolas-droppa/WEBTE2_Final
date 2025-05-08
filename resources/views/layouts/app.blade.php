<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>M3th</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-900">
    @include('layouts.navigation')

    <main class="container mx-auto mt-8">
        @yield('content')
    </main>
</body>
</html>
