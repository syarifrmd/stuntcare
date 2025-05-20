<nav x-data="{ open: false }" class="bg-white border-b border-pink-100 shadow-sm">
    <!-- Primary Navigation Menu -->
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

            <!-- Right Side Navigation Options -->
            <div class="hidden sm:flex sm:items-center sm:space-x-3">
                <!-- Doctor Consultation Button -->

                 <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-pink-500 bg-pink-50 border border-pink-300 rounded-full hover:bg-pink-100 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                        Home
                 </a>
                <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-pink-500 bg-pink-50 border border-pink-300 rounded-full hover:bg-pink-100 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                        Artikel
                </a>
                <a href="{{ route('food.index') }}" class="flex items-center px-4 py-2 text-sm font-medium text-pink-500 bg-pink-50 border border-pink-300 rounded-full hover:bg-pink-100 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                     </svg>
                        Pemantauan gizi
                </a>
                <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-pink-500 bg-pink-50 border border-pink-300 rounded-full hover:bg-pink-100 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition">
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
                        <img class="h-8 w-8 rounded-full border-2 border-pink-100" src="https://avatar.iran.liara.run/username?username={{ Auth::user()->name }}" alt="User Avatar">
                        <div class="ml-2 hidden md:block text-left">
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
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50">Edit Profil</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50">Pengaturan</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-pink-50">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-pink-500 hover:bg-pink-50 focus:outline-none focus:bg-pink-50 focus:text-pink-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="#" class="flex items-center px-4 py-2 text-base font-medium text-pink-500 bg-pink-50 border-l-4 border-pink-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Home
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-base font-medium text-gray-600 hover:bg-pink-50 hover:text-pink-500 hover:border-l-4 hover:border-pink-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                Artikel
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-base font-medium text-gray-600 hover:bg-pink-50 hover:text-pink-500 hover:border-l-4 hover:border-pink-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Pemantauan gizi
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-base font-medium text-gray-600 hover:bg-pink-50 hover:text-pink-500 hover:border-l-4 hover:border-pink-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Konsultasi Dokter
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-pink-100">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full border-2 border-pink-100" src="/api/placeholder/40/40" alt="User Avatar">
                </div>
                <div class="ml-3">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="#" class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-pink-50 hover:text-pink-500">
                    Profile
                </a>
                <a href="#" class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-pink-50 hover:text-pink-500">
                    Settings
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-base font-medium text-gray-600 hover:bg-pink-50 hover:text-pink-500">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>