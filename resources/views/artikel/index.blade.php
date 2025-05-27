<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Stunting Watch – Artikel Edukasi</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white font-['Poppins']">

<x-app-layout>
    <span name="header"></span>
    
    <main class="max-w-7xl mx-auto px-4 py-10">
        <!-- Title -->
        <div class="mb-10 text-center">
            <h1 class="text-pink-500 text-4xl font-semibold mb-4">Stunting Watch</h1>
            <div class="inline-block w-80 h-12 bg-pink-500 rounded-[30px] flex items-center justify-center mx-auto">
        <h2 class="text-white text-2xl font-semibold">Artikel Edukasi</h2>
      </div>
    </div>

    <!-- Daftar Artikel -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($artikels as $artikel)
        <div class="border border-pink-500 rounded-[30px] shadow-md overflow-hidden flex flex-col">
          <div class="bg-pink-500 py-4 px-6 text-white text-2xl font-semibold">
              {{ $artikel->title }}
          </div>
          
              <div class="w-full h-32 rounded mb-2 overflow-hidden">
                    @if ($artikel->foto_artikel)
                        <img src="{{ asset('storage/' . $artikel->foto_artikel) }}" alt="{{ $artikel->title }}"
                            class="w-full h-full object-cover rounded">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500 text-sm">
                            Tidak ada gambar
                        </div>
                    @endif
              </div>

          <div class="p-4 text-sm text-rose-900 flex-grow">
            <p>{{ \Illuminate\Support\Str::limit(strip_tags($artikel->topic), 100, '...') }}</p>
          </div>
          <form method="GET" action="{{ route('artikel.index') }}" class="p-4">
            <input type="hidden" name="selected_id" value="{{ $artikel->id }}">
            <button 
              type="submit"
              class="w-full bg-pink-500 text-white font-medium rounded-lg text-sm px-5 py-2.5 hover:bg-pink-600 transition"
            >
              Baca Selengkapnya
            </button>
          </form>
        </div>
      @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
      {{ $artikels->appends(request()->query())->links() }}
    </div>

    <!-- Modal Artikel Terpilih -->
    @if(!empty($selectedArtikel))
    <div 
    id="static-modal" 
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden"
      >
        <div class="bg-white rounded-lg shadow-lg min-w-sm max-w-5xl  mx-4">
          <!-- Header -->
          <div class="flex items-center justify-between p-4 border-b">
            <h3 class="text-xl font-semibold text-gray-900">{{ $selectedArtikel->title }}</h3>
            <button id="close-modal" class="text-gray-400 hover:text-gray-600">
              &times;
            </button>
          </div>
          <!-- Body -->
          <div class="p-6 space-y-4 text-gray-800">
              <p class="font-medium">Topik: {{ $selectedArtikel->topic }}</p>
              <p class="font-medium">Penulis: {{ $selectedArtikel->author->name }}</p>
            <div class="prose max-w-none">
              {!! $selectedArtikel->content !!}
            </div>
          </div>
          <!-- Footer -->
          <div class="flex justify-end p-4 border-t">
              <a 
              href="{{ route('artikel.index') }}" 
              class="text-pink-600 hover:underline"
            >&larr; Kembali ke daftar</a>
          </div>
        </div>
      </div>
      <script>
        // Tampilkan modal setelah halaman load
        document.addEventListener('DOMContentLoaded', () => {
          document.getElementById('static-modal').classList.remove('hidden');
          // Tutup modal
          document.getElementById('close-modal')
            .addEventListener('click', () => {
              document.getElementById('static-modal').classList.add('hidden');
            });
        });
        </script>
    @endif
    
</x-app-layout>
</main>
</body>
</html>
