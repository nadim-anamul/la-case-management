<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
            <title>@yield('title', 'LA ক্ষতিপূরণ ম্যানেজমেন্ট')</title>
    
    <!-- Use Vite assets for both development and production -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Tiro+Bangla&display=swap" rel="stylesheet">

    <!-- Page-specific Styles -->
    @yield('styles')

    <style>
        body { font-family: 'Tiro Bangla', serif; }
    </style>
</head>
<body class="bg-gray-100">
    @include('layouts.navigation')

    <main>
        @yield('content')
    </main>
    <!-- Page-specific Scripts -->
    @yield('scripts')
</body>
</html>