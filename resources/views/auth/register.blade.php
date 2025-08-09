<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Register</title>
</head>
<body class="bg-gray-100 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen">
        <!-- Left Column: Form -->
        <div class="flex flex-col items-center justify-center bg-white py-12 sm:py-16 px-4 sm:px-6 lg:px-8 order-2 lg:order-1">
            <div class="w-full max-w-lg">
                <h1 class="text-3xl mb-6 text-pink-500 text-center font-bold">Silahkan Buat Akun Anda</h1>

                <!-- Gambar untuk Mobile -->
                <div class="mb-6 block lg:hidden">
                    <img src="{{ asset('images/dokterlaptop.png') }}" alt="Gambar Register" class="w-48 h-auto mx-auto">
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-gray-700" />
                        <x-text-input id="name" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- Email -->
                    <div class="mt-6">
                        <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                        <x-text-input id="email" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- Password -->
                    <div class="mt-6">
                        <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                        <x-text-input id="password" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50"
                                        type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-6">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-500 focus:ring-opacity-50"
                                        type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- Register Button -->
                    <div class="flex items-center justify-end mt-8">
                        <a class="underline text-sm text-gray-600 hover:text-pink-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                        <x-primary-button class="ms-3 bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50 transition duration-150 ease-in-out">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column: Gambar untuk Desktop -->
        <div class="hidden lg:flex justify-center items-center bg-center bg-no-repeat bg-white order-1 lg:order-2"
             style="background-image: url('{{ asset('images/dokterlaptop.png') }}'); background-size: contain;">
        </div>
    </div>
    
    <!-- Include notification and service worker scripts for authenticated users -->
    @auth
        <x-notification-scripts />
    @endauth
</body>
</html>
