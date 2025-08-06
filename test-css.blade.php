<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSS Test</title>
    
    <!-- Development: Use Vite assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Tiro Bangla', serif; }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-blue-600 mb-8">CSS Test Page</h1>
        
        <!-- Test Progress Indicator -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Progress Indicator Test</h2>
            
            <!-- Progress Bar Container -->
            <div class="relative">
                <!-- Background Progress Bar -->
                <div class="absolute top-5 left-0 right-0 h-1.5 bg-gray-200 rounded-full"></div>
                
                <!-- Active Progress Bar -->
                <div class="absolute top-5 left-0 h-1.5 bg-gradient-to-r from-blue-500 to-green-500 rounded-full transition-all duration-500 ease-in-out shadow-sm"
                     :style="`width: ${getProgressWidth()}%`"></div>
                
                <!-- Step Indicators -->
                <div class="relative flex justify-between items-center">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <!-- Step Circle -->
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold cursor-pointer transition-all duration-300 hover:scale-110 bg-green-500 text-white shadow-md">
                                <span>১</span>
                                
                                <!-- Check Icon for Completed Steps -->
                                <svg class="absolute inset-0 w-9 h-9 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Step Label -->
                        <div class="mt-3 text-center transition-all duration-200 hover:-translate-y-0.5">
                            <div class="text-sm font-semibold text-green-500">
                                রেকর্ডের বর্ণনা
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <!-- Step Circle -->
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold cursor-pointer transition-all duration-300 hover:scale-110 bg-blue-500 text-white shadow-lg ring-2 ring-blue-300">
                                <span>২</span>
                                
                                <!-- Pulse Animation for Current Step -->
                                <div class="absolute inset-0 rounded-full bg-blue-400 animate-ping opacity-75 w-9 h-9"></div>
                            </div>
                        </div>
                        
                        <!-- Step Label -->
                        <div class="mt-3 text-center transition-all duration-200 hover:-translate-y-0.5">
                            <div class="text-sm font-semibold text-blue-500">
                                হস্তান্তর/রেকর্ড
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <!-- Step Circle -->
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold cursor-pointer transition-all duration-300 hover:scale-110 bg-gray-300 text-gray-600 hover:bg-gray-400">
                                <span>৩</span>
                            </div>
                        </div>
                        
                        <!-- Step Label -->
                        <div class="mt-3 text-center transition-all duration-200 hover:-translate-y-0.5">
                            <div class="text-sm font-semibold text-gray-500">
                                আবেদনকারী তথ্য
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Test Buttons -->
        <div class="space-y-4">
            <h2 class="text-xl font-semibold mb-4">Button Test</h2>
            
            <button class="btn-primary">Primary Button</button>
            <button class="btn-secondary">Secondary Button</button>
            <button class="btn-success">Success Button</button>
            <button class="btn-danger">×</button>
        </div>
        
        <!-- Test Colors -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Color Test</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-blue-500 text-white p-4 rounded">Blue 500</div>
                <div class="bg-green-500 text-white p-4 rounded">Green 500</div>
                <div class="bg-gray-300 text-gray-600 p-4 rounded">Gray 300</div>
                <div class="bg-purple-500 text-white p-4 rounded">Purple 500</div>
            </div>
        </div>
    </div>
</body>
</html> 