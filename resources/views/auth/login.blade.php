<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Login</title>
</head>
<body class="bg-gray-100">
    <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen">
        <!-- Left Column: Login Form -->
        <div class="flex flex-col justify-center items-center p-6 lg:p-20 order-2 lg:order-1 bg-white">
            <h1 class="text-3xl mb-4 text-pink-500 text-center font-bold">Silahkan Masuk Ke Akun Anda</h1>

            <!-- Gambar (hanya muncul di mobile di bawah judul) -->
            <div class="mb-6 block lg:hidden">
                <img src="{{ asset('images/dokterpesan.png') }}" alt="Login Image" class="w-48 h-auto mx-auto">
            </div>

            <form method="POST" action="{{ route('login') }}" class="w-full max-w-md">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-2">
                    <div class="text-sm">
                        @if (Route::has('password.request'))
                            <a class="underline text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                        <a class="ml-2 underline text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                            Belum punya akun?
                        </a>
                    </div>
                    <x-primary-button>
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Right Column: Gambar (hanya tampil di layar besar) -->
        <div class="hidden lg:flex justify-center items-center bg-cover bg-center order-1 lg:order-2" style="background-image: url('{{ asset('images/dokterpesan.png') }}'); background-size: contain; background-repeat: no-repeat;">
        </div>
    </div>
</body>
</html>
