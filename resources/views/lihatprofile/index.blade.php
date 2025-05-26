<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil</title>
  <style>
  
  </style>
</head>
<body>
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
<body>

    <!-- Header Navigation -->
   <x-app-layout>
    <span name="header"></span>

    <div class="flex gap-8 px-8 bg-gradient-to-l from-pink-50 to-pink-400/30 min-h-screen font-poppins">
    {{-- <div class="flex flex-col sm:flex-row gap-8 px-4 sm:px-8 bg-gradient-to-l from-pink-50 to-pink-400/30 min-h-screen font-poppins"> --}}

        <!-- Sidebar -->
        <aside class="sm:w-64 mt-10">
            <div class="bg-white rounded-t-[30px] p-6 mb-2">
                <a href="lihatprofile" class="block mb-3 text-black text-base font-medium font-montserrat hover:text-pink-500 transition-colors">Personal</a>
                {{-- <h3 class="text-black text-base font-medium font-montserrat mb-4">Personal</h3> --}}
                <nav class="space-y-3">
                    <a href="children/create" class="block text-black text-base font-medium font-montserrat hover:text-pink-500 transition-colors">Edit data anak</a>
                    {{-- <a href="#" class="block text-black text-base font-medium font-montserrat hover:text-pink-500 transition-colors">Pengaturan</a>
                </nav> --}}
            </div>
            <div class="bg-white rounded-b-[30px] p-6">
                <nav class="space-y-3">
                    <a href="#" class="block text-black text-base font-medium font-montserrat hover:text-pink-500 transition-colors">Account</a>
                    <a href="#" class="block text-black text-base font-medium font-montserrat hover:text-pink-500 transition-colors">Log Out</a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 mt-10 mb-10">
            <div class="bg-white rounded-tr-[191px] rounded-bl-[120px] rounded-br-[40px] shadow-[0px_10px_100px_10px_rgba(0,0,0,0.25)] p-8">

                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('lihatprofile.update', Auth::user()->id) }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="bg-pink-400/30 rounded-tl-[30px] rounded-tr-[103px] rounded-br-[30px] p-8 mb-8">
                        <div class="flex items-center gap-4 mb-6">
                                <div class="w-32 h-36 bg-zinc-300 rounded-full overflow-hidden">
                                    @if(Auth::user()->fotoprofil)
                                        <img src="{{ asset('storage/fotoprofil/' . Auth::user()->fotoprofil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://avatar.iran.liara.run/username?username={{ Auth::user()->name }}" alt="Default Avatar" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    
                                      <div>
                                <h1 class="text-black text-3xl font-medium font-montserrat">{{ Auth::user()->name }}</h1>
                            </div>
                                </div>
                            </div>
                       
                    </div>
                    

                    <div class="border-b border-black/40 pb-4">
                        <label class="text-black text-2xl font-medium font-montserrat block mb-2" for="name">Nama</label>
                        <p class="w-full border border-gray-300 rounded-lg p-3 bg-gray-100">
                            {{ Auth::user()->name }}
                        </p>
                    </div>

                     <div class="border-b border-black/40 pb-4">
                        <label class="text-black text-2xl font-medium font-montserrat block mb-2" for="telepon">Email</label>
                        <p class="w-full border border-gray-300 rounded-lg p-3 bg-gray-100">
                                {{ Auth::user()->email}}
                        </p>                      
                    </div>

                     <div class="border-b border-black/40 pb-4">
                        <label class="text-black text-2xl font-medium font-montserrat block mb-2" for="telepon">Password</label>
                        <p class="w-full border border-gray-300 rounded-lg p-3 bg-gray-100">
                ********
            </p>                      
                    </div>

                    {{-- <div class="border-b border-black/40 pb-4">
                        <label class="text-black text-2xl font-medium font-montserrat block mb-2" for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full border border-gray-300 rounded-lg p-3" required>
                    </div> --}}

                    {{-- <div class="border-b border-black/40 pb-4">
                        <label class="text-black text-2xl font-medium font-montserrat block mb-2" for="password">Password (opsional)</label>
                        <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-lg p-3">
                        <small class="text-gray-500 block mt-1">Kosongkan jika tidak ingin mengganti password.</small>
                    </div> --}}

                    <div class="border-b border-black/40 pb-4">
                        <label class="text-black text-2xl font-medium font-montserrat block mb-2" for="name">Nomor telepon</label>
                        <p class="w-full border border-gray-300 rounded-lg p-3 bg-gray-100">
                                {{ Auth::user()->telepon }}
                        </p>                    
                    </div>

                    <div class="border-b border-black/40 pb-4">
                        <label class="text-black text-2xl font-medium font-montserrat block mb-2" for="telepon">Alamat</label>
                        <p class="w-full border border-gray-300 rounded-lg p-3 bg-gray-100">
                                {{ Auth::user()->alamat }}
                        </p>                      
                    </div>
                    
                    
                </form>

                

                <!-- Modal Edit Profil -->
                    <div x-data="{ open: false }">
                        <!-- Tombol edit profil -->
                        <button @click="open = true" 
                                class="mt-4 ml-4 px-6 py-3 bg-pink-500 text-white rounded-lg font-medium hover:bg-pink-600 transition-colors">
                            Edit Profil
                        </button>

                <!-- Modal -->
                <div x-show="open" 
                    x-transition 
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div @click.away="open = false" class="bg-white w-full max-w-2xl rounded-xl p-8 relative shadow-lg overflow-y-auto max-h-screen">

                        <h2 class="text-2xl font-bold text-pink-600 mb-4">Edit Profil</h2>

                        <form action="{{ route('lihatprofile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <!-- Foto profil -->
                            <div class="flex items-center gap-4">
                                <div class="w-24 h-24 rounded-full overflow-hidden">
                                    @if(Auth::user()->fotoprofil)
                                        <img src="{{ asset('storage/fotoprofil/' . Auth::user()->fotoprofil) }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://avatar.iran.liara.run/username?username={{ Auth::user()->name }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ganti Foto</label>
                                    <input type="file" name="fotoprofil" class="text-sm mt-1">
                                </div>
                            </div>

                            <!-- Nama -->
                            <div>
                                <label for="name" class="text-gray-700 font-semibold">Nama</label>
                                <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full border rounded-lg p-3" required>
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="text-gray-700 font-semibold">Password (opsional)</label>
                                <input type="password" id="password" name="password" class="w-full border rounded-lg p-3">
                                <small class="text-gray-500">Kosongkan jika tidak ingin mengganti password.</small>
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <label for="telepon" class="text-gray-700 font-semibold">Nomor Telepon</label>
                                <input type="text" id="telepon" name="telepon" value="{{ old('telepon', Auth::user()->telepon) }}" class="w-full border rounded-lg p-3" required>
                            </div>

                            <!-- Alamat -->
                            <div>
                                <label for="alamat" class="text-gray-700 font-semibold">Alamat</label>
                                <input type="text" id="alamat" name="alamat" value="{{ old('alamat', Auth::user()->alamat) }}" class="w-full border rounded-lg p-3">
                            </div>

                            <!-- Tombol aksi -->
                            <div class="flex justify-end gap-4">
                                <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600">Simpan</button>
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
