<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Makanan - FatSecret</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 font-poppins">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Cari Makanan dari FatSecret</h2>
            
            <form method="GET" action="{{ route('food.searchFatSecret') }}" class="mb-8">
                <div class="flex gap-4">
                    <input 
                        type="text" 
                        name="query" 
                        value="{{ request('query') }}"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                        placeholder="Cari makanan Indonesia (contoh: nasi goreng, ayam bakar, tempe, sate)..." 
                        required
                    >
                    
                    <button 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors" 
                        type="submit"
                    >
                        Cari
                    </button>
                </div>
            </form>

            @if(isset($foods) && count($foods) > 0)
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold text-gray-700 mb-4">Hasil Pencarian ({{ count($foods) }} makanan):</h4>
                    
                    <div class="grid gap-4">
                        @foreach($foods as $food)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-gray-800 text-lg">{{ $food['food_name'] ?? 'Nama tidak tersedia' }}</h5>
                                        @if(isset($food['brand_name']) && $food['brand_name'])
                                            <p class="text-sm text-gray-600 mt-1">{{ $food['brand_name'] }}</p>
                                        @endif
                                        @if(isset($food['food_description']))
                                            <p class="text-sm text-gray-500 mt-2">{{ Str::limit($food['food_description'], 100) }}</p>
                                        @endif
                                    </div>
                                    
                                    <form method="POST" action="{{ route('food.addFromFatSecret') }}" class="ml-4">
                                        @csrf
                                        <input type="hidden" name="food_id" value="{{ $food['food_id'] ?? '' }}">
                                        <input type="hidden" name="food_name" value="{{ $food['food_name'] ?? '' }}">
                                        <input type="hidden" name="region" value="{{ request('region', 'ID') }}">
                                        <input type="hidden" name="language" value="{{ request('language', 'id') }}">
                                        <button 
                                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors text-sm" 
                                            type="submit"
                                        >
                                            Tambah ke Database
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @elseif(request('query'))
                <div class="text-center py-8">
                    <p class="text-gray-500 text-lg">Tidak ada hasil ditemukan untuk "{{ request('query') }}"</p>
                    <p class="text-gray-400 text-sm mt-2">Coba kata kunci yang berbeda</p>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 text-lg">Masukkan kata kunci untuk mencari makanan</p>
                    <p class="text-gray-400 text-sm mt-2">Contoh: apple, rice, chicken, bread</p>
                </div>
            @endif

            @if(session('success'))
                <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if(isset($error) && $error)
                <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ $error }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>


