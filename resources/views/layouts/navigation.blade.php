<nav x-data="{ open: false }" class="bg-white border-b border-pink-100 shadow-sm">
    <!-- Primary Navigation Menu (Desktop) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <div class="text-pink-500">
                        <a href="#" class="flex items-center">
                            <div class="text-pink-stunt mr-2">
                                    <img src="{{ asset('images/logo.png') }}" alt="Dokter StuntCare" class="mx-auto w-fit h-10">
                            </div>
                        </a>
                        </div>
                    </a>
                </div>
            </div>
 
            <!-- Right Side Navigation Options (Desktop Only) -->
            <div class="hidden md:flex md:items-center md:space-x-3">
                <!-- Doctor Consultation Button -->

                <!--Home -->
                <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-2 text-sm font-medium rounded-full border transition delay-150 duration-300 ease-in-out
                {{ request()->routeIs('user.dashboard') 
                        ? 'text-white bg-pink-500 border-pink-600 shadow-lg ring-2 ring-pink-400' 
                        : 'text-pink-500 bg-pink-50 border-pink-300 hover:bg-pink-100 hover:-translate-y-1 hover:scale-110' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                        Home
                </a>

                 <!--Artikel -->
                <a href="{{ route('artikel.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-full border transition delay-150 duration-300 ease-in-out
                    {{ request()->routeIs('artikel.index') 
                    ? 'text-white bg-pink-500 border-pink-600 shadow-lg ring-2 ring-pink-400' 
                    : 'text-pink-500 bg-pink-50 border-pink-300 hover:bg-pink-100 hover:-translate-y-1 hover:scale-110' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                        Artikel
                </a>

                <!-- Pemantauan Gizi -->
                <a href="{{ route('children.create') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-full border transition delay-150 duration-300 ease-in-out
                    {{ request()->routeIs('children.create', 'pemantauan.index', 'histori.index', 'food.index') 
                    ? 'text-white bg-pink-500 border-pink-600 shadow-lg ring-2 ring-pink-400' 
                    : 'text-pink-500 bg-pink-50 border-pink-300 hover:bg-pink-100 hover:-translate-y-1 hover:scale-110' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                     </svg>
                        Pemantauan gizi
                </a>

                <!--Konsultasi Doktor -->
                <a href="{{ route('konsultasidokter.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-full border transition delay-150 duration-300 ease-in-out
                    {{ request()->routeIs('konsultasidokter.index') 
                    ? 'text-white bg-pink-500 border-pink-600 shadow-lg ring-2 ring-pink-400' 
                    : 'text-pink-500 bg-pink-50 border-pink-300 hover:bg-pink-100 hover:-translate-y-1 hover:scale-110' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Konsultasi Dokter
                </a>
             
                <!-- Notification Bell -->
                <button class="text-gray-400 hover:text-pink-400 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>

                <!-- User Dropdown (Desktop) -->
                <div x-data="{ open: false }" class="relative ml-4">
                    <button @click="open = !open" class="flex items-center focus:outline-none">
                        <div class="h-8 w-8 rounded-full overflow-hidden border-2 border-pink-100">
                                     @if(Auth::user()->fotoprofil)
                                        <img src="{{ asset('storage/fotoprofil/' . Auth::user()->fotoprofil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://avatar.iran.liara.run/username?username={{ Auth::user()->name }}" alt="Default Avatar" class="w-full h-full object-cover">
                                    @endif
                        </div>
                        <div class="ml-2 hidden lg:block text-left">
                            <p class="text-xs font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        <svg class="ml-1 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div
                        x-show="open"
                        @click.away="open = false"
                        x-transition
                        class="absolute right-0 mt-2 w-48 bg-white border border-pink-100 rounded-md shadow-lg z-50"
                    >
                        <a href="{{ route('lihatprofile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50">Edit Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-pink-50">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Top Bar - Only Logo and Profile -->
            <div class="flex items-center md:hidden">
                <!-- User Profile (Mobile Top) -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center focus:outline-none">
                        <div class="h-8 w-8 rounded-full overflow-hidden border-2 border-pink-100">
                                     @if(Auth::user()->fotoprofil)
                                        <img src="{{ asset('storage/fotoprofil/' . Auth::user()->fotoprofil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://avatar.iran.liara.run/username?username={{ Auth::user()->name }}" alt="Default Avatar" class="w-full h-full object-cover">
                                    @endif
                        </div>
                    </button>

                    <!-- Mobile Dropdown Menu -->
                    <div
                        x-show="open"
                        @click.away="open = false"
                        x-transition
                        class="absolute right-0 mt-2 w-48 bg-white border border-pink-100 rounded-md shadow-lg z-50"
                    >
                        <div class="px-4 py-3 border-b border-pink-100">
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="{{ route('lihatprofile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50">Edit Profil</a>
                        <!-- Notification in Mobile Dropdown -->
                        <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            Notifikasi
                        </button>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-pink-50">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Bottom Navigation -->
<div class="md:hidden">
    <!-- Bottom Navigation Bar -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-pink-100 shadow-lg z-40">
        <div class="flex justify-around items-center py-2 px-4">
            <!-- Home -->
            <a href="{{ route('dashboard') }}" 
               class="flex flex-col items-center py-2 px-3 rounded-xl transition-all duration-200 
               {{ request()->routeIs('user.dashboard') 
                   ? 'bg-pink-100 text-pink-600' 
                   : 'text-gray-500 hover:text-pink-500 hover:bg-pink-50' }}">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    @if(request()->routeIs('user.dashboard'))
                        <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-pink-600 rounded-full"></div>
                    @endif
                </div>
                <span class="text-xs font-medium mt-1">Home</span>
            </a>

            <!-- Artikel -->
            <a href="{{ route('artikel.index') }}" 
               class="flex flex-col items-center py-2 px-3 rounded-xl transition-all duration-200 
               {{ request()->routeIs('artikel.index') 
                   ? 'bg-pink-100 text-pink-600' 
                   : 'text-gray-500 hover:text-pink-500 hover:bg-pink-50' }}">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    @if(request()->routeIs('artikel.index'))
                        <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-pink-600 rounded-full"></div>
                    @endif
                </div>
                <span class="text-xs font-medium mt-1">Artikel</span>
            </a>

            <!-- Pemantauan Gizi -->
            <a href="{{ route('children.create') }}" 
               class="flex flex-col items-center py-2 px-3 rounded-xl transition-all duration-200 
               {{ request()->routeIs('children.create', 'pemantauan.index', 'histori.index', 'food.index') 
                   ? 'bg-pink-100 text-pink-600' 
                   : 'text-gray-500 hover:text-pink-500 hover:bg-pink-50' }}">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    @if(request()->routeIs('children.create'))
                        <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-pink-600 rounded-full"></div>
                    @endif
                </div>
                <span class="text-xs font-medium mt-1">Gizi</span>
            </a>

            <!-- Konsultasi Dokter -->
            <a href="{{ route('konsultasidokter.index') }}" 
               class="flex flex-col items-center py-2 px-3 rounded-xl transition-all duration-200 
               {{ request()->routeIs('konsultasidokter.index') 
                   ? 'bg-pink-100 text-pink-600' 
                   : 'text-gray-500 hover:text-pink-500 hover:bg-pink-50' }}">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    @if(request()->routeIs('konsultasidokter.index'))
                        <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-pink-600 rounded-full"></div>
                    @endif
                </div>
                <span class="text-xs font-medium mt-1">Dokter</span>
            </a>
        </div>
        
        <!-- Bottom indicator line -->
        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-12 h-1 bg-gray-300 rounded-full mb-1"></div>
    </div>
    
</div>
