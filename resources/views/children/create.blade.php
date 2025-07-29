<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Tambah Data Anak - StuntCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
        .backdrop-blur-md {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-white pb-20">
    <x-app-layout>
        <span name="header"></span>
        <div class="bg-white">
            <div class="bg-white max-w-screen-xl mx-auto relative overflow-hidden py-10">
                <h2 class="text-2xl px-6 py-2 font-semibold text-pink-600">Data Anak Anda</h2>
                <p class="text-base px-6 py-2 font-medium text-pink-600 mb-6">
                    Silakan tambahkan data anak Anda terlebih dahulu, lalu inputkan informasi makanan melalui fitur pemantauan dengan menekan tombol <b>Input Makanan</b>
                </p>
                
                <!-- Tombol Tambah Data Anak -->
                <div x-data="{ openAdd: false }" class="px-6 py-2">
                    <button @click="openAdd = true" class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition duration-200 shadow-md">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Data Anak
                    </button>

                    <!-- Modal Tambah Data Anak -->
                    <div x-show="openAdd" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="fixed inset-0 z-50 flex items-center justify-center bg-white/30 backdrop-blur-md p-4"
                         style="display: none;">
                        <div @click.away="openAdd = false" 
                             @keydown.escape.window="openAdd = false"
                             class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
                            
                            <!-- Header Modal -->
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-xl font-semibold text-pink-600">Tambah Data Anak</h2>
                                <button @click="openAdd = false" class="text-gray-400 hover:text-gray-600 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Form Tambah -->
                            <form action="{{ route('children.store') }}" method="POST" class="space-y-4">
                                @csrf

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Anak <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition" 
                                           placeholder="Masukkan nama anak" required>
                                    @error('name') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                                    @enderror
                                </div>

                                <div>
                                    <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">
                                        Tanggal Lahir <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition" required>
                                    @error('birth_date') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                                    @enderror
                                </div>

                                <div>
                                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">
                                        Jenis Kelamin <span class="text-red-500">*</span>
                                    </label>
                                    <select name="gender" id="gender" 
                                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition" required>
                                        <option value="">Pilih jenis kelamin</option>
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('gender') 
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                                    @enderror
                                </div>

                                <!-- Footer Modal -->
                                <div class="flex justify-end gap-3 pt-6 border-t">
                                    <button type="button" @click="openAdd = false"
                                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-200">
                                        Batal
                                    </button>
                                    <button type="submit"
                                            class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition duration-200 shadow-md">
                                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Daftar Anak -->
                <div class="max-w-screen-xl mx-auto relative overflow-hidden py-5">
                    @if ($children->count())
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 px-6">
                            @foreach ($children as $child)
                                <div x-data="{ openEdit: false, openDelete: false }" 
                                     class="bg-pink-50 border border-pink-200 rounded-xl shadow-md p-6 hover:shadow-lg transition duration-300">
                                    
                                    <!-- Identitas Anak -->
                                    <div class="flex items-center gap-4 mb-4">
                                    @php
                                        $avatarUrl = $child->gender === 'L'
                                            ? 'https://avatar.iran.liara.run/public/boy'
                                            : 'https://avatar.iran.liara.run/public/girl';
                                    @endphp

                                    <div class="w-12 h-12 rounded-full overflow-hidden bg-pink-200 border border-pink-300">
                                        <img src="{{ $avatarUrl }}" alt="Avatar Anak" class="w-full h-full object-cover">
                                    </div>
                                        <div>
                                            <p class="text-base font-semibold text-rose-900">{{ $child->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $child->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                        </div>
                                    </div>

                                    <!-- Informasi Anak -->
                                    <div class="text-sm text-gray-700 mb-4 bg-white p-3 rounded-lg">
                                        <p class="flex justify-between">
                                            <span class="font-medium">Tanggal Lahir:</span> 
                                            <span>{{ \Carbon\Carbon::parse($child->birth_date)->format('d M Y') }}</span>
                                        </p>
                                    <p class="flex justify-between mt-1">
                                        <span class="font-medium">Umur:</span> 
                                        <span>
                                            {{ number_format(\Carbon\Carbon::parse($child->birth_date)->diffInDays(now()) / 365, 1) }} tahun
                                        </span>
                                    </p>
                                    </div>

                                    <!-- Tombol Aksi -->
                                    <div class="space-y-2">
                                        <!-- Input Makanan -->
                                        <a href="{{ route('pemantauan.index', ['child_id' => $child->id]) }}"
                                           class="block w-full text-center bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition duration-200 shadow-md">
                                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Input Makanan
                                        </a>
                                        
                                        <!-- Edit & Delete -->
                                        <div class="flex gap-2">
                                            <button @click="openEdit = true"
                                                    class="flex-1 bg-transparent border-2 border-pink-500 text-pink-600 px-3 py-2 rounded-lg hover:bg-pink-50 transition duration-200">
                                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </button>

                                            <button @click="openDelete = true"
                                                    class="flex-1 bg-pink-500 text-white px-3 py-2 rounded-lg hover:bg-pink-600 transition duration-200">
                                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Modal Edit -->
                                    <div x-show="openEdit" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95"
                                         class="fixed inset-0 z-50 flex items-center justify-center bg-white/30 backdrop-blur-md p-4"
                                         style="display: none;">
                                        <div @click.away="openEdit = false" 
                                             @keydown.escape.window="openEdit = false"
                                             class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
                                            
                                            <!-- Header Modal -->
                                            <div class="flex justify-between items-center mb-6">
                                                <h2 class="text-xl font-semibold text-pink-600">Edit Data Anak</h2>
                                                <button @click="openEdit = false" class="text-gray-400 hover:text-gray-600 transition">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Form Edit -->
                                            <form action="{{ route('children.update', $child->id) }}" method="POST" class="space-y-4">
                                                @csrf
                                                @method('PUT')

                                                <div>
                                                    <label for="name{{ $child->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Nama Anak <span class="text-red-500">*</span>
                                                    </label>
                                                    <input type="text" name="name" id="name{{ $child->id }}" value="{{ $child->name }}"
                                                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition" required>
                                                </div>

                                                <div>
                                                    <label for="birth_date{{ $child->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Tanggal Lahir <span class="text-red-500">*</span>
                                                    </label>
                                                    <input type="date" name="birth_date" id="birth_date{{ $child->id }}" value="{{ $child->birth_date }}"
                                                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition" required>
                                                </div>

                                                <div>
                                                    <label for="gender{{ $child->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                                        Jenis Kelamin <span class="text-red-500">*</span>
                                                    </label>
                                                    <select name="gender" id="gender{{ $child->id }}" 
                                                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition" required>
                                                        <option value="">Pilih jenis kelamin</option>
                                                        <option value="L" {{ $child->gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                        <option value="P" {{ $child->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                    </select>
                                                </div>

                                                <!-- Footer Modal -->
                                                <div class="flex justify-end gap-3 pt-6 border-t">
                                                    <button type="button" @click="openEdit = false"
                                                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-200">
                                                        Batal
                                                    </button>
                                                    <button type="submit"
                                                            class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition duration-200 shadow-md">
                                                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        Simpan Perubahan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Modal Konfirmasi Hapus -->
                                    <div x-show="openDelete" 
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95"
                                         class="fixed inset-0 z-50 flex items-center justify-center bg-white/30 backdrop-blur-md p-4"
                                         style="display: none;">
                                        <div @click.away="openDelete = false" 
                                             @keydown.escape.window="openDelete = false"
                                             class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
                                            
                                            <!-- Header Modal -->
                                            <div class="flex items-center mb-4">
                                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus</h3>
                                                    <p class="text-sm text-gray-600">Tindakan ini tidak dapat dibatalkan</p>
                                                </div>
                                            </div>

                                            <p class="text-gray-700 mb-6">
                                                Apakah Anda yakin ingin menghapus data anak <strong>{{ $child->name }}</strong>? 
                                                Semua data terkait akan ikut terhapus.
                                            </p>

                                            <!-- Footer Modal -->
                                            <div class="flex justify-end gap-3">
                                                <button type="button" @click="openDelete = false"
                                                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-200">
                                                    Batal
                                                </button>
                                                <form action="{{ route('children.destroy', ['child' => $child->id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200 shadow-md">
                                                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        Ya, Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada data anak</h3>
                            <p class="mt-2 text-gray-500">Mulai dengan menambahkan data anak pertama Anda</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-app-layout>

</body>
</html>