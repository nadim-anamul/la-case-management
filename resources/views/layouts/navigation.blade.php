<nav class="bg-white shadow-md">
    <div class="container mx-auto px-8">
        <div class="flex justify-between items-center py-4">
            <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">LA ক্ষতিপূরণ ম্যানেজমেন্ট</a>
            <div class="flex space-x-4">
                <a href="{{ route('order.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('order.*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-200' }}">আদেশপত্র</a>
                <a href="{{ route('compensation.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('compensation.*') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-200' }}">ক্ষতিপূরণ কেস</a>
            </div>
        </div>
    </div>
</nav>