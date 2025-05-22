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
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-white">
    <div class="bg-white">
                <x-app-layout>
    <span name="header"></span>
    <div class="bg-white">
        
    </div>
        <!-- Modal dan Tombol dibungkus x-data --> 
    <div x-data="{ open: false }" class="mb-6 flex md:flex-row gap-4 pt-10 container mx-auto">
    <!-- Tombol buka modal -->
    <button @click="open = true"
        class="border border-pink-400 bg-pink-50 text-pink-600 rounded-full px-4 py-2 text-sm hover:bg-pink-100 transition">
        + Tambah Makanan
    </button>

    <!-- Filter dan Search -->
    <form method="GET" action="{{ route('food.index') }}" class="flex flex-col md:flex-row gap-4 w-full">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama makanan..."
            class="border border-pink-400 bg-pink-50 rounded-full px-4 py-2 text-pink-600 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">

        <select name="category" onchange="this.form.submit()"
            class="border border-pink-400 bg-pink-50 rounded-full px-4 py-2 text-pink-600 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
            <option value="">Semua Kategori</option>
            <option value="Makanan Pokok" {{ request('category') == 'Makanan Pokok' ? 'selected' : '' }}>Makanan Pokok</option>
            <option value="Sayuran" {{ request('category') == 'Sayuran' ? 'selected' : '' }}>Sayuran</option>
            <option value="Lauk Pauk" {{ request('category') == 'Lauk Pauk' ? 'selected' : '' }}>Lauk Pauk</option>
            <option value="Buah" {{ request('category') == 'Buah' ? 'selected' : '' }}>Buah</option>
            <option value="Cemilan" {{ request('category') == 'Cemilan' ? 'selected' : '' }}>Cemilan</option>
        </select>
    </form>

    <!-- Modal -->
    <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div @click.away="open = false"
            class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
            <h2 class="text-lg font-semibold text-pink-600 mb-4">Tambah Makanan Baru</h2>

            <form action="{{ route('food.store') }}" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" name="created_by" value="{{ Auth::id() }}">
                <input type="text" name="name" placeholder="Nama Makanan"
                    class="w-full border rounded px-3 py-2" required>
                <select name="category" class="w-full border rounded px-3 py-2" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option value="Makanan Pokok">Makanan Pokok</option>
                    <option value="Sayuran">Sayuran</option>
                    <option value="Lauk Pauk">Lauk Pauk</option>
                    <option value="Buah">Buah</option>
                    <option value="Cemilan">Cemilan</option>
                </select>
                <input type="number" name="energy" placeholder="Energi (kkal)" class="w-full border rounded px-3 py-2">
                <input type="number" name="protein" placeholder="Protein (g)" class="w-full border rounded px-3 py-2">
                <input type="number" name="fat" placeholder="Lemak (g)" class="w-full border rounded px-3 py-2">
                <input type="number" name="carbohydrate" placeholder="Karbohidrat (g)" class="w-full border rounded px-3 py-2">

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="open = false"
                        class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-pink-500 text-white rounded hover:bg-pink-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


        <!-- Daftar Makanan -->
        <section class="container mx-auto px-4">
            <h2 class="text-xl font-semibold text-pink-600 mb-4">Daftar Makanan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @if($foods->count())
        @foreach($foods as $food)
        <div class="bg-pink-50 rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold text-rose-900 mb-2">{{ $food->name }}</h3>
                <div class="w-full h-32 rounded mb-2 overflow-hidden"> 
                    @if ($food->foto) <img src="{{ asset('storage/' . $food->foto) }}" alt="{{ $food->name }}" 
                    class="w-full h-full object-cover rounded"> @else 
                    <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500 text-sm"> Tidak ada gambar </div>
                     @endif 
                </div>
            <p class="text-sm text-gray-700">Kategori: {{ $food->category }}</p>
            <p class="text-sm text-gray-700">Energi: {{ $food->energy }} kkal</p>
            <p class="text-sm text-gray-700">Protein: {{ $food->protein }} g</p>
            <p class="text-sm text-gray-700">Lemak: {{ $food->fat }} g</p>
            <p class="text-sm text-gray-700 mb-2">Karbohidrat: {{ $food->carbohydrate }} g</p>
            
            <form action="{{ route('intakes.storeDirect') }}" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="food_id" value="{{ $food->id }}">
                <input type="hidden" name="child_id" value="{{ $child->id ?? '' }}">
                <select name="time_of_day" class="border px-2 py-1 rounded text-sm w-full mb-2">
                    <option value="Pagi">Pagi</option>
                    <option value="Siang">Siang</option>
                    <option value="Malam">Malam</option>
                    <option value="Cemilan">Cemilan</option>
                </select>
                <button type="submit" class="bg-pink-500 text-white text-sm px-3 py-1 rounded hover:bg-pink-600 w-full">+ Tambah</button>
            </form>
        </div>
        @endforeach
    @else
        <div class="col-span-full text-center text-gray-500 py-10">
            Tidak ada makanan yang ditemukan.
        </div>
    @endif
</div>

        </section>
    </div>

    <br><br>
</x-app-layout>
    </div>

</body>
</html>
