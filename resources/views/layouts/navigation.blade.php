<nav class="bg-gradient-to-r from-slate-100 via-blue-100 to-indigo-100 border-b border-slate-300 shadow-md">
    <div class="container mx-auto px-8">
        <div class="flex justify-between items-center py-6">
            <!-- Enhanced Logo Section with Animations -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <!-- Logo Icon with Floating Animation -->
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-500 group-hover:scale-110 animate-float">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z" clip-rule="evenodd"></path>
                        <path fill-rule="evenodd" d="M6 8a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm0 3a1 1 0 011-1h4a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <!-- Logo Text with Fade-in Animation -->
                <div class="text-left animate-fade-in-left">
                    <div class="text-2xl font-bold text-slate-800 leading-tight group-hover:text-blue-600 transition-colors duration-300">LA ক্ষতিপূরণ</div>
                    <div class="text-sm font-medium text-slate-600 leading-tight group-hover:text-slate-700 transition-colors duration-300">ম্যানেজমেন্ট সিস্টেম</div>
                </div>
            </a>
            
            <!-- Enhanced Navigation Menu with Elegant Animations -->
            <div class="flex space-x-6">
                <a href="{{ route('compensation.index') }}" 
                   class="group relative px-6 py-3 rounded-xl text-base font-semibold transition-all duration-300 {{ request()->routeIs('compensation.*') 
                       ? 'bg-blue-600 text-white shadow-lg' 
                       : 'text-slate-700 bg-white hover:bg-blue-50 hover:text-blue-700 hover:shadow-lg border border-slate-200' }}">
                    <!-- Subtle Glow Effect -->
                    <div class="absolute inset-0 rounded-xl bg-blue-400/10 opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                    
                    <span class="relative z-10 transition-all duration-300 group-hover:translate-x-1 group-hover:font-bold">
                        ক্ষতিপূরণ কেস
                    </span>
                </a>
            </div>
        </div>
    </div>
</nav>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-8px); }
}

@keyframes fade-in-left {
    0% { opacity: 0; transform: translateX(-20px); }
    100% { opacity: 1; transform: translateX(0); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-fade-in-left {
    animation: fade-in-left 1s ease-out;
}

/* Smooth scrolling for the whole page */
html {
    scroll-behavior: smooth;
}

/* Custom hover effects */
.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

.group:hover .group-hover\:rotate-12 {
    transform: rotate(12deg);
}
</style>