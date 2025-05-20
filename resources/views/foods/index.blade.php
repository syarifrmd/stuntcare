<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Makanan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-white">
    <div class="bg-white">
                <x-app-layout>
    <span name="header"></span>
    <div class="bg-white">
                    <!-- Form Tambah Makanan -->
        <section class="container mx-auto px-4 pt-4">
            <h2 class="text-xl font-semibold text-pink-600 mb-4">Tambah Makanan Baru</h2>
            <form action="{{ route('food.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @csrf
                <input type="hidden" name="created_by" value="{{ Auth::id() }}">
                <input type="text" name="name" placeholder="Nama Makanan" class="border rounded px-3 py-2" required>
                <select name="category" class="border rounded px-3 py-2" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option value="Makanan Pokok">Makanan Pokok</option>
                    <option value="Sayuran">Sayuran</option>
                    <option value="Lauk Pauk">Lauk Pauk</option>
                    <option value="Buah">Buah</option>
                </select>
                <input type="number" name="energy" placeholder="Energi (kkal)" step="0.01" class="border rounded px-3 py-2">
                <input type="number" name="protein" placeholder="Protein (g)" step="0.01" class="border rounded px-3 py-2">
                <input type="number" name="fat" placeholder="Lemak (g)" step="0.01" class="border rounded px-3 py-2">
                <input type="number" name="carbohydrate" placeholder="Karbohidrat (g)" step="0.01" class="border rounded px-3 py-2">
                <button type="submit" class="col-span-full bg-pink-500 text-white py-2 rounded hover:bg-pink-600">Simpan</button>
            </form>
            
            @if(session('success'))
            <p class="mt-4 text-green-600">{{ session('success') }}</p>
            @endif
        </section>
        
        <!-- Daftar Makanan -->
        <section class="container mx-auto px-4">
            <h2 class="text-xl font-semibold text-pink-600 mb-4">Daftar Makanan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($foods as $food)
                <div class="bg-pink-50 rounded-lg shadow p-4">
                    <h3 class="text-lg font-semibold text-rose-900 mb-2">{{ $food->name }}</h3>
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
                        </select>
                        <button type="submit" class="bg-pink-500 text-white text-sm px-3 py-1 rounded hover:bg-pink-600 w-full">+ Tambah</button>
                    </form>
                </div>
                @endforeach
            </div>
        </section>
    </div>

    <br><br>
</x-app-layout>
    </div>

</body>
</html>
