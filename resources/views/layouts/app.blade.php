<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LA ক্ষতিপূরণ ম্যানেজমেন্ট')</title>
    
    @if(app()->environment('production'))
        <!-- Production: Use CDN for Tailwind CSS and Alpine.js -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            'bangla': ['Tiro Bangla', 'serif'],
                        }
                    }
                },
                safelist: [
                    // Progress indicator classes
                    'bg-blue-500', 'text-white', 'shadow-lg', 'ring-2', 'ring-blue-300',
                    'bg-green-500', 'shadow-md', 'bg-gray-300', 'text-gray-600',
                    'hover:bg-gray-400', 'cursor-pointer', 'bg-gray-200', 'text-gray-400',
                    'cursor-not-allowed', 'bg-gradient-to-r', 'from-blue-500', 'to-green-500',
                    'rounded-full', 'transition-all', 'duration-500', 'ease-in-out', 'shadow-sm',
                    'w-9', 'h-9', 'flex', 'items-center', 'justify-center', 'text-sm',
                    'font-bold', 'duration-300', 'hover:scale-110', 'relative',
                    'absolute', '-top-1', '-right-1', 'w-4', 'h-4', 'p-0.5',
                    'top-4.5', 'left-9', 'w-full', 'h-0.5', 'transform', '-translate-y-px',
                    'mt-3', 'text-center', 'duration-200', 'hover:-translate-y-0.5',
                    'font-semibold', 'transition-colors', 'text-blue-500', 'text-green-500',
                    'text-gray-500', 'mb-8', 'max-w-4xl', 'mx-auto', 'left-0', 'right-0',
                    'justify-between', 'flex-col', 'fill-current', 'fill-rule', 'evenodd', 'clip-rule'
                ]
            }
        </script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @else
        <!-- Development: Use Vite for local build -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
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