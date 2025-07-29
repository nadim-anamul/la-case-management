<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ভূমি অধিগ্রহণ ম্যানেজমেন্ট')</title>
    
    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Fallback for production when Vite assets are not available -->
    @if(!app()->environment('local'))
        <script>
            // Check if Vite assets are loaded, if not, load fallback
            setTimeout(function() {
                if (!document.querySelector('link[href*="app-"]') && !document.querySelector('script[src*="app-"]')) {
                    console.log('Vite assets not loaded, using fallback');
                    // Load Tailwind CSS from CDN as fallback
                    const link = document.createElement('link');
                    link.rel = 'stylesheet';
                    link.href = 'https://cdn.tailwindcss.com';
                    document.head.appendChild(link);
                    
                    // Load Alpine.js from CDN
                    const script = document.createElement('script');
                    script.src = 'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js';
                    script.defer = true;
                    document.head.appendChild(script);
                }
            }, 1000);
        </script>
    @endif
    
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