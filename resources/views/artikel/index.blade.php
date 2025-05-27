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
    
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
        <!-- Title -->
        <div class="mb-8 sm:mb-10 text-center">
            <h1 class="text-pink-500 text-2xl sm:text-3xl lg:text-4xl font-semibold mb-4">Stunting Watch</h1>
            <div class="inline-block w-full max-w-xs sm:max-w-sm lg:w-80 h-10 sm:h-12 bg-pink-500 rounded-[20px] sm:rounded-[30px] flex items-center justify-center mx-auto">
                <h2 class="text-white text-lg sm:text-xl lg:text-2xl font-semibold px-4">Artikel Edukasi</h2>
            </div>
        </div>

        <!-- Daftar Artikel -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            @foreach($artikels as $artikel)
                <div class="border border-pink-500 rounded-[20px] sm:rounded-[30px] shadow-md overflow-hidden flex flex-col">
                    <div class="bg-pink-500 py-3 sm:py-4 px-4 sm:px-6 text-white text-lg sm:text-xl lg:text-2xl font-semibold">
                        {{ Str::words($artikel->title, 2, '...') }}
                    </div>
                    
                    <div class="w-full h-28 sm:h-32 lg:h-36 rounded mb-2 overflow-hidden mx-2 sm:mx-0">
                        @if ($artikel->foto_artikel)
                            <img src="{{ asset('storage/' . $artikel->foto_artikel) }}" alt="{{ $artikel->title }}"
                                class="w-full h-full object-cover rounded">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500 text-xs sm:text-sm">
                                Tidak ada gambar
                            </div>
                        @endif
                    </div>

                    <div class="p-3 sm:p-4 text-xs sm:text-sm text-rose-900 flex-grow">
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($artikel->topic), 100, '...') }}</p>
                    </div>
                    
                    <form method="GET" action="{{ route('artikel.index') }}" class="p-3 sm:p-4">
                        <input type="hidden" name="selected_id" value="{{ $artikel->id }}">
                        <button 
                            type="submit"
                            class="w-full bg-pink-500 text-white font-medium rounded-lg text-xs sm:text-sm px-4 sm:px-5 py-2 sm:py-2.5 hover:bg-pink-600 transition active:bg-pink-700"
                        >
                            Baca Selengkapnya
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6 sm:mt-8">
            {{ $artikels->appends(request()->query())->links() }}
        </div>

        <!-- Modal Artikel Terpilih -->
        @if(!empty($selectedArtikel))
        <div 
            id="static-modal" 
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden p-4"
        >
            <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col">
                <!-- Header -->
                <div class="flex items-center justify-between p-4 sm:p-6 border-b flex-shrink-0">
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 pr-4 leading-tight">{{ $selectedArtikel->title }}</h3>
                    <button id="close-modal" class="text-gray-400 hover:text-gray-600 text-2xl sm:text-3xl flex-shrink-0 w-8 h-8 flex items-center justify-center">
                        &times;
                    </button>
                </div>
                
                <!-- Body -->
                <div class="p-4 sm:p-6 space-y-3 sm:space-y-4 text-gray-800 overflow-y-auto flex-grow">
                    <div class="space-y-2 text-sm sm:text-base">
                        <p class="font-medium">Topik: {{ $selectedArtikel->topic }}</p>
                        <p class="font-medium">Penulis: {{ $selectedArtikel->author->name }}</p>
                    </div>
                    <div class="prose prose-sm sm:prose max-w-none">
                        {!! $selectedArtikel->content !!}
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="flex justify-end p-4 sm:p-6 border-t flex-shrink-0">
                    <a 
                        href="{{ route('artikel.index') }}" 
                        class="text-pink-600 hover:underline text-sm sm:text-base"
                    >&larr; Kembali ke daftar</a>
                </div>
            </div>
        </div>
        
        <script>
            // Tampilkan modal setelah halaman load
            document.addEventListener('DOMContentLoaded', () => {
                const modal = document.getElementById('static-modal');
                const closeBtn = document.getElementById('close-modal');
                
                // Show modal
                modal.classList.remove('hidden');
                
                // Close modal on button click
                closeBtn.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
                
                // Close modal on backdrop click
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                    }
                });
                
                // Close modal on escape key
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        modal.classList.add('hidden');
                    }
                });
            });
        </script>
        @endif
        
    </main>
</x-app-layout>
</body>
</html>