<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Makanan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
        }
        
        /* Custom responsive utilities */
        @media (max-width: 640px) {
            .modal-responsive {
                margin: 1rem;
                max-width: calc(100vw - 2rem);
            }
        }
        
        /* Smooth transitions */
        .transition-custom {
            transition: all 0.3s ease;
        }
        
        /* Food card hover effects */
        .food-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="bg-white shadow-sm">
        <x-app-layout>
            <span name="header"></span>
            <div x-data="{ 
                showConfirmModal: false, 
                selectedFoodId: null, 
                selectedTime: 'Pagi',
                showAddFoodModal: false,
                showEditFoodModal: false,
                showDeleteConfirmModal: false,
                editingFood: null,
                deletingFoodId: null
            }">
            
            <!-- Header Section -->
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center text-pink-500 mb-4 font-semibold text-xl sm:text-2xl">
                    <a href="{{route('pemantauan.index', ['child_id' => $child->id])}}" class="p-2 items-center text-pink-500 rounded-full hover:bg-pink-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left mr-2 sm:mr-4" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                        </svg>
                    </a>
                    <h1 class="font-semibold text-xl sm:text-2xl">Tambah Makanan</h1>
                </div>

                <!-- Controls Section -->
                <div class="space-y-4">
                    <!-- Add Food Button and Search/Filter Row -->
                    <div class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-center pt-6 sm:pt-10">
                        <!-- Add Food Button -->
                        <button @click="showAddFoodModal = true"
                            class="border border-pink-400 bg-pink-50 text-pink-600 rounded-full px-3 py-3 text-xs font-medium hover:bg-pink-100 transition-custom flex-shrink-0">
                            <span class="inline-flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Tambah Mandiri
                            </span>
                        </button>

                        <a href="{{ route('food.searchFatSecret', ['child_id' => $child->id]) }}"
                            class="border border-pink-400 bg-pink-50 text-pink-600 rounded-lg px-3 py-2 text-xs font-medium hover:bg-pink-100 transition-custom flex-shrink-0">
                            <span class="inline-flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Tambah FatSecret
                            </span>
                        </a>

                        <!-- Search and Filter Form -->
                        <form method="GET" action="{{ route('food.index', ['child_id' => $child->id]) }}" class="flex flex-col sm:flex-row gap-3 sm:gap-4 flex-1 order-2 sm:order-none">
                            <input type="hidden" name="child_id" value="{{ $child->id }}">
                            
                            <!-- Search Input -->
                            <div class="flex-1">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama makanan..."
                                    class="w-full border border-pink-400 bg-pink-50 rounded-full px-4 py-2 sm:py-3 text-pink-600 text-sm placeholder-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-custom">
                            </div>
                            
                            <!-- Category Filter -->
                            <div class="sm:w-48">
                                <select name="category" onchange="this.form.submit()"
                                    class="w-full border border-pink-400 bg-pink-50 rounded-full px-4 py-2 sm:py-3 text-pink-600 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-custom">
                                    <option value="">Semua Kategori</option>
                                    <option value="Makanan Pokok" {{ request('category') == 'Makanan Pokok' ? 'selected' : '' }}>Makanan Pokok</option>
                                    <option value="Sayuran" {{ request('category') == 'Sayuran' ? 'selected' : '' }}>Sayuran</option>
                                    <option value="Lauk Pauk" {{ request('category') == 'Lauk Pauk' ? 'selected' : '' }}>Lauk Pauk</option>
                                    <option value="Buah" {{ request('category') == 'Buah' ? 'selected' : '' }}>Buah</option>
                                    <option value="Cemilan" {{ request('category') == 'Cemilan' ? 'selected' : '' }}>Cemilan</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Food List Section -->
            <div class="container mx-auto px-4 py-6">
                <h2 class="text-lg sm:text-xl font-semibold text-pink-600 mb-4 sm:mb-2">Daftar Makanan</h2>
                <p class="text-lg sm:text-base font-medium text-pink-600 mb-4 sm:mb-6">Silakan tambahkan makanan sesuai kebutuhan Anda dengan menekan tombol <b>Tambah ke Menu </b> di bawah ini. Jika makanan yang Anda cari belum tersedia, silakan tambahkan melalui menu <b>Tambah Makanan</b> di atas</p>

                <!-- Food Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                    @if($foods->count())
                        @foreach($foods as $food)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden food-card transition-custom">
                            <!-- Food Image -->
                            <div class="w-full h-32 sm:h-40 overflow-hidden">
                                @if ($food->foto) 
                                    <img src="{{ asset('storage/' . $food->foto) }}" alt="{{ $food->name }}" 
                                        class="w-full h-full object-cover"> 
                                @else 
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-pink-100 to-pink-200 text-pink-400 text-sm"> 
                                        Tidak ada gambar 
                                    </div>
                                @endif 
                            </div>
                            
                            <!-- Food Info -->
                            <div class="p-3 sm:p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-sm sm:text-base font-semibold text-rose-900 flex-1">{{ $food->name }}</h3>
                                    <!-- Edit Button -->
                                    <button @click="editingFood = {{ $food->toJson() }}; showEditFoodModal = true"
                                        class="text-blue-500 hover:text-blue-700 p-1 rounded-full bg-blue-50 hover:bg-blue-100 transition ml-2"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <p class="text-xs sm:text-sm text-gray-600 mb-3">Kategori: {{ $food->category }}</p>
                                
                                <!-- Nutrition Info -->
                                <div class="grid grid-cols-2 gap-1 sm:gap-2 text-xs text-gray-600 mb-4">
                                    <div>Energi: {{ $food->energy }} kkal</div>
                                    <div>Protein: {{ $food->protein }} g</div>
                                    <div>Lemak: {{ $food->fat }} g</div>
                                    <div>Karbohidrat: {{ $food->carbohydrate }} g</div>
                                </div>
                                
                                <!-- Add & Delete Buttons -->
                                <div class="flex items-center gap-2">
                                    <!-- Tombol Hapus -->
                                    <button @click="deletingFoodId = {{ $food->id }}; showDeleteConfirmModal = true"
                                        class="text-red-500 hover:text-red-700 p-2 rounded-full bg-red-50 hover:bg-red-100 transition" 
                                        title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                        </svg>
                                    </button>

                                    <!-- Tombol Tambah ke Menu -->
                                    <button 
                                        @click="selectedFoodId = {{ $food->id }}; selectedTime = 'Pagi'; showConfirmModal = true"
                                        class="flex-1 bg-pink-500 text-white text-sm font-medium px-3 py-2 rounded-lg hover:bg-pink-600 transition-custom">
                                        + Tambah ke Menu
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <!-- Empty State -->
                        <div class="col-span-full">
                            <div class="text-center py-12">
                                <div class="w-16 h-16 sm:w-24 sm:h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 sm:w-12 sm:h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2">Tidak ada makanan yang ditemukan</h3>
                                <p class="text-sm text-gray-500 mb-4">Coba ubah kata kunci pencarian atau filter kategori.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- MODAL 1: Add Food Modal -->
            <div x-show="showAddFoodModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                 style="display: none;">
                <div @click.away="showAddFoodModal = false"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="bg-white w-full max-w-md rounded-xl shadow-xl modal-responsive">
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-pink-600">Tambah Makanan Baru</h2>
                        <button @click="showAddFoodModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Content -->
                    <form action="{{ route('food.store') }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                        @csrf
                        <input type="hidden" name="created_by" value="{{ Auth::id() }}">
                        <input type="hidden" name="child_id" value="{{ $child->id }}">
                        
                        <!-- Name Input -->
                        <div>
                            <input type="text" name="name" placeholder="Nama Makanan"
                                class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-custom" required>
                        </div>
                        
                        <!-- Category Select -->
                        <div>
                            <select name="category" class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-custom" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="Makanan Pokok">Makanan Pokok</option>
                                <option value="Sayuran">Sayuran</option>
                                <option value="Lauk Pauk">Lauk Pauk</option>
                                <option value="Buah">Buah</option>
                                <option value="Cemilan">Cemilan</option>
                            </select>
                        </div>
                        
                        <!-- Nutrition Inputs -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <input type="number" name="energy" placeholder="Energi (kkal)" 
                                class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-custom" required>
                            <input type="number" name="protein" placeholder="Protein (g)" 
                                class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-custom" required>
                            <input type="number" name="fat" placeholder="Lemak (g)" 
                                class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-custom" required>
                            <input type="number" name="carbohydrate" placeholder="Karbohidrat (g)" 
                                class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-custom" required>
                        </div>

                        <div>
                            <label for="foto" class="block text-sm font-medium text-gray-700">Foto Makanan (opsional)</label>
                            <input type="file" name="foto" id="foto" accept="image/*" class="mt-1 p-2 w-full border border-gray-300 rounded">
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 pt-4">
                            <button type="button" @click="showAddFoodModal = false"
                                class="flex-1 px-4 py-2 sm:py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-custom">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 px-4 py-2 sm:py-3 bg-pink-500 text-white font-medium rounded-lg hover:bg-pink-600 transition-custom">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- MODAL 2: Edit Food Modal -->
            <div x-show="showEditFoodModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                 style="display: none;">
                <div @click.away="showEditFoodModal = false"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="bg-white w-full max-w-md rounded-xl shadow-xl modal-responsive">
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-pink-600">Edit Makanan</h2>
                        <button @click="showEditFoodModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Content -->
                    <form :action="`{{ url('food') }}/${editingFood?.id}`" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <!-- Name Input -->
                        <div>
                            <input type="text" name="name" :value="editingFood?.name" placeholder="Nama Makanan"
                                class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-custom" required>
                        </div>
                        
                        <!-- Category Select -->
                        <div>
                            <select name="category" class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-custom" required>
                                <option value="" disabled>Pilih Kategori</option>
                                <option value="Makanan Pokok" :selected="editingFood?.category === 'Makanan Pokok'">Makanan Pokok</option>
                                <option value="Sayuran" :selected="editingFood?.category === 'Sayuran'">Sayuran</option>
                                <option value="Lauk Pauk" :selected="editingFood?.category === 'Lauk Pauk'">Lauk Pauk</option>
                                <option value="Buah" :selected="editingFood?.category === 'Buah'">Buah</option>
                                <option value="Cemilan" :selected="editingFood?.category === 'Cemilan'">Cemilan</option>
                            </select>
                        </div>
                        
                        <!-- Nutrition Inputs -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <input type="number" name="energy" :value="editingFood?.energy" placeholder="Energi (kkal)" 
                                class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-custom" required>
                            <input type="number" name="protein" :value="editingFood?.protein" placeholder="Protein (g)" 
                                class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-custom" required>
                            <input type="number" name="fat" :value="editingFood?.fat" placeholder="Lemak (g)" 
                                class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-custom" required>
                            <input type="number" name="carbohydrate" :value="editingFood?.carbohydrate" placeholder="Karbohidrat (g)" 
                                class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-custom" required>
                        </div>


                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 pt-4">
                            <button type="button" @click="showEditFoodModal = false"
                                class="flex-1 px-4 py-2 sm:py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-custom">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 px-4 py-2 sm:py-3 bg-pink-500 text-white font-medium rounded-lg hover:bg-pink-600 transition-custom">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- MODAL 3: Delete Confirmation Modal -->
            <div x-show="showDeleteConfirmModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                 style="display: none;">
                <div @click.away="showDeleteConfirmModal = false"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="bg-white w-full max-w-sm rounded-xl shadow-xl p-6">
                    
                    <div class="text-center">
                        <!-- Warning Icon -->
                        <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full bg-red-100 mb-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Konfirmasi Hapus</h3>
                        <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menghapus makanan ini? Tindakan ini tidak dapat dibatalkan.</p>
                        
                        <div class="flex gap-3">
                            <button @click="showDeleteConfirmModal = false"
                                class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-custom">
                                Batal
                            </button>
                            
                            <form :action="`{{ url('food') }}/${deletingFoodId}`" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-custom">
                                    Ya, Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL 4: Add to Menu Confirmation Modal -->
            <div x-show="showConfirmModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-50 p-4"
                 style="display: none;">
                <div @click.away="showConfirmModal = false" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="bg-white rounded-xl shadow-lg w-full max-w-sm p-6">
                    
                    <div class="text-center mb-4">
                        <!-- Success Icon -->
                        <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full bg-green-100 mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Tambah Makanan</h2>
                        <p class="text-sm text-gray-600">Apakah Anda yakin ingin menambahkan makanan ini ke menu anak?</p>
                    </div>

                    <form :action="`{{ route('intakes.storeDirect') }}`" method="POST">
                        @csrf
                        <input type="hidden" name="food_id" :value="selectedFoodId">
                        <input type="hidden" name="child_id" value="{{ $child->id }}">

                        <!-- Time Selection -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Waktu Makan:</label>
                            <select name="time_of_day" x-model="selectedTime"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent transition-custom">
                                <option value="Pagi">Pagi</option>
                                <option value="Siang">Siang</option>
                                <option value="Malam">Malam</option>
                                <option value="Cemilan">Cemilan</option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <button type="button" @click="showConfirmModal = false"
                                class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-custom">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-custom">
                                Ya, Tambahkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- MODAL 5: Success Notification Modal (Optional) -->
            <div x-data="{ showSuccessModal: false }" 
                 x-init="
                    @if(session('success'))
                        showSuccessModal = true;
                        setTimeout(() => showSuccessModal = false, 3000);
                    @endif
                 ">
                <div x-show="showSuccessModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-4"
                     class="fixed top-4 right-4 z-[9999] bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg"
                     style="display: none;">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm font-medium">
                            @if(session('success'))
                                {{ session('success') }}
                            @endif
                        </span>
                        <button @click="showSuccessModal = false" class="ml-4 text-white hover:text-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Spacing -->
        <div class="h-16"></div>
        </x-app-layout>
    </div>

    <!-- Custom JavaScript for Enhanced Functionality -->
    <script>
        // Enhanced Alpine.js functionality
        document.addEventListener('alpine:init', () => {
            Alpine.data('foodManager', () => ({
                // Additional methods can be added here for complex operations
                resetForms() {
                    // Reset all form fields when modals are closed
                    document.querySelectorAll('form input[type="text"], form input[type="number"], form select').forEach(input => {
                        if (!input.hasAttribute('x-model') && !input.name.includes('_token') && !input.name.includes('_method')) {
                            input.value = '';
                        }
                    });
                },
                
                confirmDelete(foodId, foodName) {
                    return confirm(`Apakah Anda yakin ingin menghapus "${foodName}"?`);
                }
            }));
        });

        // Auto-hide success messages
        document.addEventListener('DOMContentLoaded', function() {
            const successMessages = document.querySelectorAll('.alert-success');
            successMessages.forEach(message => {
                setTimeout(() => {
                    message.style.transition = 'opacity 0.5s';
                    message.style.opacity = '0';
                    setTimeout(() => message.remove(), 500);
                }, 5000);
            });
        });

        // Form validation enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const requiredFields = form.querySelectorAll('[required]');
                    let isValid = true;
                    
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            field.classList.add('border-red-500');
                            isValid = false;
                        } else {
                            field.classList.remove('border-red-500');
                        }
                    });
                    
                    if (!isValid) {
                        e.preventDefault();
                        alert('Mohon lengkapi semua field yang wajib diisi.');
                    }
                });
            });
        });
    </script>

    <!-- Include notification and service worker scripts -->
    @auth
        <x-notification-scripts />
    @endauth

</body>
</html>