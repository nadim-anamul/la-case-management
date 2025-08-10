<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LA ক্ষতিপূরণ ম্যানেজমেন্ট')</title>
    
    <!-- PDF-optimized Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'bangla': ['Tiro Bangla', 'serif'],
                    }
                }
            }
        }
    </script>
    
    <link href="https://fonts.googleapis.com/css2?family=Tiro+Bangla&display=swap" rel="stylesheet">

    <!-- Page-specific Styles -->
    @yield('styles')

    <style>
        body { 
            font-family: 'Tiro Bangla', serif; 
            margin: 0;
            padding: 0;
        }
        
        /* PDF-specific optimizations */
        .page-break {
            page-break-before: always;
        }
        
        .avoid-break {
            page-break-inside: avoid;
        }
        
        /* Ensure proper font rendering in PDF */
        * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
    </style>
</head>
<body class="bg-white">
    <main>
        @yield('content')
    </main>
</body>
</html>
