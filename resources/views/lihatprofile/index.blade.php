<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - StuntCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'poppins': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-poppins bg-white">
    <x-app-layout>
        <span name="header"></span>
    <div class="bg-white flex flex-col lg:flex-row gap-4 lg:gap-8 px-4 sm:px-6 md:px-8 py-6 md:py-8 bg-gradient-to-l from-pink-50 to-pink-400/30 min-h-screen">

            <aside class="w-full lg:w-64 lg:mt-10 mb-6 lg:mb-0 flex-shrink-0">
                <div class="bg-pink-500 rounded-t-[30px] p-4 sm:p-6 mb-2">
                    <a href="lihatprofile" class="block mb-3 text-gray-100 text-sm sm:text-base font-medium font-montserrat hover:text-white transition-colors py-2">Personal</a>
                    <nav class="space-y-2 sm:space-y-3">
                        <a href="{{ route('children.create') ?? '#' }}" class="block text-gray-100 text-sm sm:text-base font-medium font-montserrat  hover:text-white transition-colors py-1 sm:py-2">Edit data anak</a>
                        {{-- <a href="#" class="block text-white text-base font-medium font-montserrat hover:text-pink-500 transition-colors">Pengaturan</a> --}}
                    </nav>
                </div>
                <div class="bg-pink-500 rounded-b-[30px] p-4 sm:p-6">
                    <nav class="space-y-2 sm:space-y-3">
                        <a href="#" class="block text-gray-100 text-sm sm:text-base font-medium font-montserrat  hover:text-white transition-colors py-1 sm:py-2">Account</a>
                        <form method="POST" action="{{ route('logout') ?? '#' }}">
                            @csrf
                            <a href="{{ route('logout') ?? '#' }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="block text-white text-sm sm:text-base font-medium font-montserrat  hover:text-white transition-colors py-1 sm:py-2">
                                Log Out
                            </a>
                        </form>
                    </nav>
                </div>
            </aside>

            <main class="flex-1 w-full lg:mt-10 mb-10 lg:mb-0">
                <div class="bg-white rounded-3xl lg:rounded-tr-[191px] lg:rounded-bl-[120px] lg:rounded-br-[40px] lg:rounded-tl-xl shadow-l lg:shadow-[0px_10px_100px_10px_rgba(0,0,0,0.25)] p-4 sm:p-6 md:p-8">

                    @if(session('success'))
                        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4 sm:mb-6 text-sm sm:text-base">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form> <div class="bg-pink-500 sm:bg-pink-500 rounded-2xl sm:rounded-tl-[30px] sm:rounded-tr-[103px] sm:rounded-br-[30px] sm:rounded-bl-xl p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8">
                            <div class="flex flex-col sm:flex-row items-center text-center sm:text-left gap-4 sm:gap-6 mb-4 sm:mb-6">
                                <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 bg-zinc-300 rounded-full overflow-hidden flex-shrink-0">
                                    @if(Auth::user()->fotoprofil)
                                        <img src="{{ asset('storage/fotoprofil/' . Auth::user()->fotoprofil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=ec4899&color=ffffff&size=120&rounded=true" alt="Default Avatar" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <h1 class="text-white text-xl sm:text-2xl lg:text-3xl font-bold font-montserrat">{{ Auth::user()->name }}</h1>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 sm:space-y-6">
                            <div class="border-b border-black/20 pb-3 sm:pb-4">
                                <label class="text-black text-md sm:text-lg lg:text-xl font-medium font-montserrat block mb-1 sm:mb-2" for="name_display">Nama</label>
                                <p id="name_display" class="w-full rounded-lg p-2 sm:p-3 bg-gray-100 text-sm sm:text-base text-gray-700">
                                    {{ Auth::user()->name }}
                                </p>
                            </div>

                            <div class="border-b border-black/20 pb-3 sm:pb-4">
                                <label class="text-black text-md sm:text-lg lg:text-xl font-medium font-montserrat block mb-1 sm:mb-2" for="email_display">Email</label>
                                <p id="email_display" class="w-full rounded-lg p-2 sm:p-3 bg-gray-100 text-sm sm:text-base text-gray-700">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>

                            <div class="border-b border-black/20 pb-3 sm:pb-4">
                                <label class="text-black text-md sm:text-lg lg:text-xl font-medium font-montserrat block mb-1 sm:mb-2" for="password_display">Password</label>
                                <p id="password_display" class="w-full rounded-lg p-2 sm:p-3 bg-gray-100 text-sm sm:text-base text-gray-700">
                                    ********
                                </p>
                            </div>

                            <div class="border-b border-black/20 pb-3 sm:pb-4">
                                <label class="text-black text-md sm:text-lg lg:text-xl font-medium font-montserrat block mb-1 sm:mb-2" for="telepon_display">Nomor telepon</label>
                                <p id="telepon_display" class="w-full rounded-lg p-2 sm:p-3 bg-gray-100 text-sm sm:text-base text-gray-700">
                                    {{ Auth::user()->telepon ?? '-' }}
                                </p>
                            </div>

                            <div class="border-b border-black/20 pb-3 sm:pb-4">
                                <label class="text-black text-md sm:text-lg lg:text-xl font-medium font-montserrat block mb-1 sm:mb-2" for="alamat_display">Alamat</label>
                                <p id="alamat_display" class="w-full rounded-lg p-2 sm:p-3 bg-gray-100 text-sm sm:text-base text-gray-700">
                                    {{ Auth::user()->alamat ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </form>

                    <div x-data="{ open: false }" class="flex justify-end mt-6 sm:mt-8">
                        <button @click="open = true"
                                class="px-5 py-2.5 sm:px-6 sm:py-3 bg-pink-500 text-white rounded-lg font-medium hover:bg-pink-600 transition-colors text-sm sm:text-base">
                            Edit Profil
                        </button>

                        <div x-show="open"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4"
                             style="display: none;"> <div @click.away="open = false" class="bg-white w-full max-w-xs sm:max-w-md md:max-w-lg lg:max-w-xl rounded-xl p-5 sm:p-6 md:p-8 relative shadow-2xl overflow-y-auto max-h-[90vh]">

                                <h2 class="text-xl sm:text-2xl font-bold text-pink-600 mb-5 sm:mb-6 font-montserrat">Edit Profil</h2>

                                <form action="{{ route('lihatprofile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-5">
                                    @csrf
                                    @method('PUT')

                                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-3 sm:gap-4">
                                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden flex-shrink-0 bg-gray-200">
                                            @if(Auth::user()->fotoprofil)
                                                <img src="{{ asset('storage/fotoprofil/' . Auth::user()->fotoprofil) }}" alt="Current Profile Photo" class="w-full h-full object-cover">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=ec4899&color=ffffff&size=96&rounded=true" alt="Default Avatar" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="text-center sm:text-left">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Ganti Foto</label>
                                            <input type="file" name="fotoprofil" class="text-xs sm:text-sm text-gray-600 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200 w-full">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="name" class="block text-sm sm:text-base font-semibold text-gray-700 mb-1">Nama</label>
                                        <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full border border-gray-300 rounded-lg p-2 sm:p-3 text-sm sm:text-base focus:ring-pink-500 focus:border-pink-500" required>
                                    </div>

                                    <div>
                                        <label for="password" class="block text-sm sm:text-base font-semibold text-gray-700 mb-1">Password Baru (opsional)</label>
                                        <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-lg p-2 sm:p-3 text-sm sm:text-base focus:ring-pink-500 focus:border-pink-500">
                                        <small class="text-gray-500 text-xs sm:text-sm mt-1">Kosongkan jika tidak ingin mengganti password.</small>
                                    </div>

                                    <div>
                                        <label for="telepon" class="block text-sm sm:text-base font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                                        <input type="text" id="telepon" name="telepon" value="{{ old('telepon', Auth::user()->telepon) }}" class="w-full border border-gray-300 rounded-lg p-2 sm:p-3 text-sm sm:text-base focus:ring-pink-500 focus:border-pink-500">
                                    </div>

                                    <div>
                                        <label for="alamat" class="block text-sm sm:text-base font-semibold text-gray-700 mb-1">Alamat</label>
                                        <input type="text" id="alamat" name="alamat" value="{{ old('alamat', Auth::user()->alamat) }}" class="w-full border border-gray-300 rounded-lg p-2 sm:p-3 text-sm sm:text-base focus:ring-pink-500 focus:border-pink-500">
                                    </div>

                                    <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 pt-3 sm:pt-4">
                                        <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm sm:text-base order-2 sm:order-1">Batal</button>
                                        <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 text-sm sm:text-base order-1 sm:order-2">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
     </x-app-layout>
    </body>
</html>
