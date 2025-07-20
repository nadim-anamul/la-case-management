<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ভূমি অধিগ্রহণ ম্যানেজমেন্ট')</title>
    
    <!-- Scripts and Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tiro+Bangla&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

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