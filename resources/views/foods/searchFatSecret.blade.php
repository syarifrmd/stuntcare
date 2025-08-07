<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pencarian Makanan - StuntCare</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-pink-50 font-inter min-h-screen" x-data="{ 
    showModal: false, 
    selectedFood: null, 
    showDetailModal: false, 
    detailFood: null, 
    loadingDetail: false,
    
    async showFoodDetail(foodId) {
        this.loadingDetail = true;
        this.showDetailModal = true;
        
        try {
            const response = await fetch('{{ route('food.getFoodDetails') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                body: JSON.stringify({ food_id: foodId })
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.detailFood = data.food;
            } else {
                alert('Gagal memuat detail makanan: ' + data.message);
                this.showDetailModal = false;
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat detail makanan');
            this.showDetailModal = false;
        }
        
        this.loadingDetail = false;
    }
}">
    <!-- Header Section -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center space-x-4">
                <a href="{{ $child ? route('food.index', ['child_id' => $child->id]) : url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                <div class="bg-pink-500 p-3 rounded-xl">
                    <i class="fas fa-search text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Pencarian Makanan</h1>
                    <p class="text-gray-600">Temukan dan tambahkan makanan dari database FatSecret</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Search Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
            <div class="bg-pink-500 p-6">
                <h2 class="text-xl font-semibold text-white mb-2">
                    <i class="fas fa-utensils mr-2"></i>
                    Cari Makanan Bergizi
                </h2>
                <p class="text-pink-100 text-sm">Gunakan database FatSecret untuk menemukan informasi nutrisi makanan</p>
            </div>
            <div class="p-6">
            
            <form method="GET" action="{{ route('food.searchFatSecret') }}" class="space-y-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input 
                        type="text" 
                        name="query" 
                        value="{{ request('query') }}"
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 text-gray-700 placeholder-gray-500" 
                        placeholder="Cari makanan Indonesia (contoh: nasi goreng, ayam bakar, tempe, sate)..." 
                        required
                    >
                </div>
                
                <button 
                    class="w-full md:w-auto px-8 py-3 bg-pink-500 text-white rounded-xl hover:bg-pink-600 focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-all duration-200 font-semibold shadow-lg" 
                    type="submit"
                >
                    <i class="fas fa-search mr-2"></i>
                    Cari Makanan
                </button>
            </form>
        </div>
    </div>

        <!-- Results Section -->
        @if(isset($foods) && count($foods) > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-list mr-2 text-pink-500"></i>
                            Hasil Pencarian
                        </h3>
                        <span class="bg-pink-100 text-pink-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ count($foods) }} makanan ditemukan
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid gap-4">
                        @foreach($foods as $food)
                            @php
                                // Daftar kategori enum yang valid di DB, update sesuai enum di model Food
                                $validCategories = ['buah', 'sayur', 'daging', 'minuman', 'lainnya'];
                                // Mapping kategori FatSecret ke enum DB
                                $categoryMap = [
                                    'Generic' => 'buah',
                                    'Brand' => 'lainnya',
                                    // tambahkan mapping lain sesuai enum DB
                                ];
                                $fatSecretCategory = $food['food_type'] ?? null;
                                $dbCategory = $categoryMap[$fatSecretCategory] ?? null;
                                $isValidCategory = $dbCategory && in_array($dbCategory, $validCategories);
                            @endphp
                            
                            <div class="bg-gradient-to-r from-white to-gray-50 rounded-xl p-5 border border-gray-200 hover:shadow-md transition-all duration-200">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-start space-x-3">
                                            <div class="bg-pink-100 p-2 rounded-lg">
                                                <i class="fas fa-apple-alt text-pink-500"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 text-lg mb-1">
                                                    {{ $food['food_name'] ?? 'Nama tidak tersedia' }}
                                                </h4>
                                                @if(isset($food['brand_name']) && $food['brand_name'])
                                                    <div class="flex items-center mb-2">
                                                        <i class="fas fa-tag text-gray-400 text-xs mr-1"></i>
                                                        <span class="text-sm text-gray-600 bg-gray-100 px-2 py-1 rounded-full">{{ $food['brand_name'] }}</span>
                                                    </div>
                                                @endif
                                                @if(isset($food['food_description']))
                                                    <p class="text-sm text-gray-600 leading-relaxed">
                                                        {{ Str::limit($food['food_description'], 150) }}
                                                    </p>
                                                @endif
                                                
                                                <!-- Category Status -->
                                                <div class="mt-3">
                                                    @if($isValidCategory)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <i class="fas fa-check-circle mr-1"></i>
                                                            Kategori: {{ ucfirst($dbCategory) }}
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                                            Kategori tidak valid: {{ $fatSecretCategory ?? 'Tidak tersedia' }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="ml-6 flex flex-col space-y-2">
                                        @if($isValidCategory)
                                            <button 
                                                @click="selectedFood = {{ json_encode($food) }}; selectedFood.dbCategory = '{{ $dbCategory }}'; showModal = true"
                                                class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-all duration-200 text-sm font-medium shadow-lg"
                                            >
                                                <i class="fas fa-plus mr-2"></i>
                                                Tambah ke Database
                                            </button>
                                        @else
                                            <button 
                                                class="px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed text-sm font-medium" 
                                                disabled
                                            >
                                                <i class="fas fa-times mr-2"></i>
                                                Tidak Dapat Ditambah
                                            </button>
                                        @endif
                                        
                                        <button 
                                            @click="showFoodDetail('{{ $food['food_id'] ?? '' }}')"
                                            class="px-4 py-2 bg-pink-100 text-pink-600 rounded-lg hover:bg-pink-200 transition-colors text-sm font-medium"
                                        >
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @elseif(request('query'))
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="text-center py-16">
                    <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak ada hasil ditemukan</h3>
                    <p class="text-gray-500 mb-1">Tidak dapat menemukan makanan untuk kata kunci "{{ request('query') }}"</p>
                    <p class="text-gray-400 text-sm">Coba gunakan kata kunci yang berbeda atau lebih spesifik</p>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="text-center py-16">
                    <div class="bg-pink-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-utensils text-pink-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Siap untuk mencari makanan bergizi?</h3>
                    <p class="text-gray-500 mb-1">Masukkan kata kunci untuk mencari makanan di database FatSecret</p>
                    <p class="text-gray-400 text-sm">Contoh: nasi goreng, ayam bakar, tempe, sate ayam</p>
                </div>
            </div>
        @endif

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                <div class="flex items-center">
                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-green-800">Berhasil!</h4>
                        <p class="text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                <div class="flex items-center">
                    <div class="bg-red-100 p-2 rounded-lg mr-3">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-red-800">Terjadi Kesalahan</h4>
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(isset($error) && $error)
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                <div class="flex items-start">
                    <div class="bg-red-100 p-2 rounded-lg mr-3 mt-1">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-red-800 mb-2">Masalah Koneksi API</h4>
                        <p class="text-red-700 mb-3">{{ $error }}</p>
                        
                        <div class="bg-red-100 rounded-lg p-3">
                            <h5 class="font-medium text-red-800 mb-2">Kemungkinan Penyebab:</h5>
                            <ul class="text-sm text-red-700 space-y-1">
                                <li>• Koneksi internet tidak stabil</li>
                                <li>• API FatSecret sedang mengalami gangguan</li>
                                <li>• Kata kunci pencarian tidak ditemukan</li>
                                <li>• Konfigurasi API credentials bermasalah</li>
                            </ul>
                        </div>
                        
                        <div class="mt-3 flex flex-wrap gap-2">
                            <button onclick="location.reload()" class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                                <i class="fas fa-refresh mr-1"></i>
                                Coba Lagi
                            </button>
                            <button onclick="window.history.back()" class="px-3 py-1 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-sm">
                                <i class="fas fa-arrow-left mr-1"></i>
                                Kembali
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Food Detail Modal -->
    <div x-show="showDetailModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" @click.away="showDetailModal = false">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-screen overflow-y-auto" @click.stop>
            <div class="p-6">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">
                        <i class="fas fa-info-circle text-pink-600 mr-2"></i>
                        Detail Makanan
                    </h3>
                    <button @click="showDetailModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Loading State -->
                <div x-show="loadingDetail" class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-pink-500"></div>
                    <p class="text-gray-600 mt-2">Memuat detail makanan...</p>
                </div>

                <!-- Food Detail Content -->
                <div x-show="!loadingDetail && detailFood" class="space-y-6">
                    <!-- Food Image -->
                    <div x-show="detailFood?.food_images?.food_image" class="text-center">
                        <template x-for="(image, index) in (Array.isArray(detailFood?.food_images?.food_image) ? detailFood?.food_images?.food_image : [detailFood?.food_images?.food_image])" :key="index">
                            <img 
                                :src="image" 
                                :alt="detailFood?.food_name"
                                class="w-full max-w-sm mx-auto rounded-xl shadow-lg border border-gray-200 mb-4"
                                onerror="this.style.display='none'"
                            >
                        </template>
                    </div>

                    <!-- Food Basic Info -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex items-start space-x-3">
                            <div class="bg-pink-100 p-3 rounded-lg">
                                <i class="fas fa-utensils text-pink-500 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 text-xl mb-2" x-text="detailFood?.food_name || 'Nama tidak tersedia'"></h4>
                                <div class="space-y-2">
                                    <div x-show="detailFood?.brand_name" class="flex items-center">
                                        <i class="fas fa-tag text-gray-400 text-sm mr-2"></i>
                                        <span class="text-sm text-gray-700 bg-gray-100 px-3 py-1 rounded-full" x-text="detailFood?.brand_name"></span>
                                    </div>
                                    <div x-show="detailFood?.food_type" class="flex items-center">
                                        <i class="fas fa-list text-gray-400 text-sm mr-2"></i>
                                        <span class="text-sm text-gray-700">Tipe: <span x-text="detailFood?.food_type"></span></span>
                                    </div>
                                    <div x-show="detailFood?.food_url" class="flex items-center">
                                        <i class="fas fa-external-link-alt text-gray-400 text-sm mr-2"></i>
                                        <a :href="detailFood?.food_url" target="_blank" class="text-sm text-pink-600 hover:text-pink-700 underline">
                                            Lihat di FatSecret
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nutrition Information -->
                    <div x-show="detailFood?.servings && detailFood?.servings.length > 0" class="space-y-4">
                        <h5 class="font-semibold text-gray-900 text-lg border-b border-gray-200 pb-2">
                            <i class="fas fa-chart-bar text-pink-500 mr-2"></i>
                            Informasi Nutrisi per Takaran
                        </h5>
                        
                        <div class="space-y-3">
                            <template x-for="(serving, index) in detailFood?.servings" :key="index">
                                <div class="bg-gradient-to-r from-pink-50 to-white rounded-xl p-4 border border-pink-100">
                                    <div class="mb-3">
                                        <h6 class="font-semibold text-gray-800 text-base" x-text="serving?.serving_description || 'Takaran ' + (index + 1)"></h6>
                                        <p x-show="serving?.metric_serving_amount" class="text-sm text-gray-600">
                                            <span x-text="serving?.metric_serving_amount"></span>
                                            <span x-text="serving?.metric_serving_unit"></span>
                                        </p>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                                        <div class="bg-white rounded-lg p-3 text-center border">
                                            <div class="text-orange-600 font-semibold text-lg" x-text="serving?.calories || '0'"></div>
                                            <div class="text-gray-600">Kalori</div>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 text-center border">
                                            <div class="text-blue-600 font-semibold text-lg" x-text="serving?.protein ? serving.protein + 'g' : '0g'"></div>
                                            <div class="text-gray-600">Protein</div>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 text-center border">
                                            <div class="text-green-600 font-semibold text-lg" x-text="serving?.carbohydrate ? serving.carbohydrate + 'g' : '0g'"></div>
                                            <div class="text-gray-600">Karbohidrat</div>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 text-center border">
                                            <div class="text-yellow-600 font-semibold text-lg" x-text="serving?.fat ? serving.fat + 'g' : '0g'"></div>
                                            <div class="text-gray-600">Lemak</div>
                                        </div>
                                    </div>
                                    
                                    <!-- Additional nutrients if available -->
                                    <div x-show="serving?.fiber || serving?.sugar || serving?.sodium" class="mt-3 pt-3 border-t border-gray-100">
                                        <div class="grid grid-cols-3 gap-2 text-xs text-gray-600">
                                            <div x-show="serving?.fiber" class="text-center">
                                                <span class="font-medium" x-text="serving?.fiber + 'g'"></span>
                                                <div>Serat</div>
                                            </div>
                                            <div x-show="serving?.sugar" class="text-center">
                                                <span class="font-medium" x-text="serving?.sugar + 'g'"></span>
                                                <div>Gula</div>
                                            </div>
                                            <div x-show="serving?.sodium" class="text-center">
                                                <span class="font-medium" x-text="serving?.sodium + 'mg'"></span>
                                                <div>Sodium</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="bg-pink-50 rounded-xl p-4 border border-pink-100">
                        <h5 class="font-medium text-pink-800 mb-2">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Tips Penggunaan
                        </h5>
                        <ul class="text-sm text-pink-700 space-y-1">
                            <li>• Gunakan tombol "Tambah ke Database" untuk menyimpan makanan</li>
                            <li>• Semua takaran akan disimpan sebagai variasi terpisah</li>
                            <li>• Data nutrisi diambil langsung dari database FatSecret</li>
                        </ul>
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="flex space-x-3 mt-6">
                    <button 
                        @click="showDetailModal = false" 
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors font-medium"
                    >
                        <i class="fas fa-times mr-2"></i>
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" @click.away="showModal = false">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-screen overflow-y-auto" @click.stop>
            <div class="p-6">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">
                        <i class="fas fa-plus-circle text-green-600 mr-2"></i>
                        Konfirmasi Tambah Makanan
                    </h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Food Info -->
                <div x-show="selectedFood" class="space-y-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex items-start space-x-3">
                            <div class="bg-pink-100 p-2 rounded-lg">
                                <i class="fas fa-apple-alt text-pink-500"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 text-lg" x-text="selectedFood?.food_name || 'Nama tidak tersedia'"></h4>
                                <div x-show="selectedFood?.brand_name" class="mt-1">
                                    <span class="text-sm text-gray-600 bg-gray-100 px-2 py-1 rounded-full" x-text="selectedFood?.brand_name"></span>
                                </div>
                                <p x-show="selectedFood?.food_description" class="text-sm text-gray-600 mt-2" x-text="selectedFood?.food_description?.substring(0, 100) + (selectedFood?.food_description?.length > 100 ? '...' : '')"></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-xl p-4">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-green-600"></i>
                            <span class="font-medium text-green-800">Kategori yang akan disimpan:</span>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm font-medium" x-text="selectedFood?.dbCategory ? selectedFood.dbCategory.charAt(0).toUpperCase() + selectedFood.dbCategory.slice(1) : ''"></span>
                        </div>
                    </div>

                    <div class="bg-pink-50 rounded-xl p-4 border border-pink-100">
                        <h5 class="font-medium text-pink-800 mb-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Informasi Tambahan
                        </h5>
                        <ul class="text-sm text-pink-700 space-y-1">
                            <li>• Makanan akan ditambahkan ke database lokal</li>
                            <li>• Data nutrisi akan diambil dari FatSecret</li>
                            <li>• Anda dapat mengedit informasi setelah ditambahkan</li>
                        </ul>
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="flex space-x-3 mt-6">
                    <button 
                        @click="showModal = false" 
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors font-medium"
                    >
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </button>
                    <form x-show="selectedFood" method="POST" action="{{ route('food.addFromFatSecret') }}" class="flex-1">
                        @csrf
                        <input type="hidden" name="food_id" x-bind:value="selectedFood?.food_id">
                        <input type="hidden" name="food_name" x-bind:value="selectedFood?.food_name">
                        <input type="hidden" name="category" x-bind:value="selectedFood?.dbCategory">
                        <button 
                            type="submit"
                            class="w-full px-4 py-3 bg-pink-500 text-white rounded-xl hover:bg-pink-600 transition-all duration-200 font-medium shadow-lg"
                        >
                            <i class="fas fa-plus mr-2"></i>
                            Tambah ke Database
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .font-inter { font-family: 'Inter', sans-serif; }
    </style>
</body>
</html>


