<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Verifikasi OTP</title>
</head>
<body class="bg-gray-100">
    <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen">
        <!-- Left Column: OTP Form -->
        <div class="flex flex-col justify-center items-center p-6 lg:p-20 order-2 lg:order-1 bg-white">
            <h1 class="text-3xl mb-4 text-pink-500 text-center font-bold">Verifikasi OTP</h1>

            <!-- Gambar (hanya muncul di mobile di bawah judul) -->
            <div class="mb-6 block lg:hidden">
                <img src="{{ asset('images/dokterpesan.png') }}" alt="OTP Image" class="w-48 h-auto mx-auto">
            </div>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('verify.otp') }}" class="w-full max-w-md">
                @csrf

                <!-- OTP Input -->
                <div class="mb-4">
                    <label for="otp" class="block text-sm font-medium text-gray-700">Masukkan Kode OTP</label>
                    <input type="text" name="otp" id="otp" required autofocus
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <x-primary-button>
                        Verifikasi
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Right Column: Gambar (hanya tampil di layar besar) -->
        <div class="hidden lg:flex justify-center items-center bg-cover bg-center order-1 lg:order-2"
             style="background-image: url('{{ asset('images/dokterpesan.png') }}'); background-size: contain; background-repeat: no-repeat;">
        </div>
    </div>
</body>
</html>
