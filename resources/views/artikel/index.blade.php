<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Stunting Watch – Artikel Edukasi</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .modal-backdrop {
      backdrop-filter: blur(5px);
      -webkit-backdrop-filter: blur(5px);
    }
    
    .modal-enter {
      animation: modalEnter 0.3s ease-out;
    }
    
    .modal-exit {
      animation: modalExit 0.3s ease-in;
    }
    
    @keyframes modalEnter {
      from {
        opacity: 0;
        transform: scale(0.9) translateY(-20px);
      }
      to {
        opacity: 1;
        transform: scale(1) translateY(0);
      }
    }
    
    @keyframes modalExit {
      from {
        opacity: 1;
        transform: scale(1) translateY(0);
      }
      to {
        opacity: 0;
        transform: scale(0.9) translateY(-20px);
      }
    }
    
    .content-blur {
      filter: blur(3px);
      transition: filter 0.3s ease;
    }
    
    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
      color: #be185d;
    }
    
    .prose p {
      line-height: 1.7;
      margin-bottom: 1rem;
    }
    
    .prose img {
      border-radius: 8px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body class="bg-white font-['Poppins']">

<x-app-layout>
    <span name="header"></span>
    
    <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
        <!-- Title -->
        <div class="mb-8 sm:mb-10 text-center">
            <div class="inline-block w-full max-w-xs sm:max-w-sm lg:w-80 h-10 sm:h-12 bg-pink-500 rounded-[20px] sm:rounded-[30px] flex items-center justify-center mx-auto">
                <h2 class="text-white text-lg sm:text-xl lg:text-2xl font-semibold px-4">Artikel Edukasi</h2>
            </div>
        </div>

        <!-- Daftar Artikel -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            @foreach($artikels as $artikel)
                <div class="border border-pink-500 rounded-[20px] sm:rounded-[30px] shadow-md overflow-hidden flex flex-col hover:shadow-lg transition-shadow duration-300">
                    <div class="bg-pink-500 py-3 sm:py-4 px-4 sm:px-6 text-white text-lg sm:text-xl lg:text-2xl font-semibold">
                        {{ Str::words($artikel->title, 2, '...') }}
                    </div>
                    
                    <div class="w-full h-28 sm:h-32 lg:h-36 rounded mb-2 overflow-hidden mx-2 sm:mx-0">
                        @if ($artikel->foto_artikel)
                            <img src="{{ asset('storage/' . $artikel->foto_artikel) }}" alt="{{ $artikel->title }}"
                                class="w-full h-full object-cover rounded transition-transform duration-300 hover:scale-105">
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
                            class="w-full bg-pink-500 text-white font-medium rounded-lg text-xs sm:text-sm px-4 sm:px-5 py-2 sm:py-2.5 hover:bg-pink-600 transition duration-300 active:bg-pink-700 transform hover:scale-105"
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
    </main>
</x-app-layout>

<!-- Modal Artikel Terpilih -->
@if(!empty($selectedArtikel))
<div 
    id="article-modal" 
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 modal-backdrop z-50 hidden p-4"
>
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[95vh] overflow-hidden flex flex-col modal-enter">
        <!-- Header dengan Gambar -->
        <div class="relative">
            <!-- Gambar Header -->
            @if ($selectedArtikel->foto_artikel)
                <div class="w-full h-48 sm:h-56 lg:h-64 overflow-hidden">
                    <img src="{{ asset('storage/' . $selectedArtikel->foto_artikel) }}" 
                         alt="{{ $selectedArtikel->title }}"
                         class="w-full h-full object-cover">
                </div>
                <!-- Overlay gradient -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
            @endif
            
            <!-- Close Button -->
            <button id="close-modal" class="absolute top-4 right-4 bg-white/90 hover:bg-white text-gray-700 hover:text-gray-900 rounded-full p-2 transition-all duration-300 shadow-lg hover:shadow-xl backdrop-blur-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Content Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-pink-50 to-rose-50">
            <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 leading-tight mb-2">
                {{ $selectedArtikel->title }}
            </h3>
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">{{ $selectedArtikel->author->name }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ $selectedArtikel->topic }}</span>
                </div>
                @if($selectedArtikel->created_at)
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ $selectedArtikel->created_at->format('d M Y') }}</span>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Body Content -->
        <div class="p-6 overflow-y-auto flex-grow">
            <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed text-justify">
                {!! $selectedArtikel->content !!}
            </div>
        </div>
        
        <!-- Footer -->
        <div class="flex justify-between items-center p-6 border-t bg-gray-50">
            <div class="flex items-center gap-3">
                <div class="flex -space-x-1">
                    <div class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                        {{ substr($selectedArtikel->author->name, 0, 1) }}
                    </div>
                </div>
                <span class="text-sm text-gray-600">Ditulis oleh <span class="font-semibold">{{ $selectedArtikel->author->name }}</span></span>
            </div>
            <a 
                href="{{ route('artikel.index') }}" 
                class="inline-flex items-center gap-2 text-pink-600 hover:text-pink-700 font-medium transition-colors duration-300"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke daftar
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('article-modal');
    const closeBtn = document.getElementById('close-modal');
    const mainContent = document.getElementById('main-content');
    
    // Show modal with animation
    function showModal() {
        modal.classList.remove('hidden');
        mainContent.classList.add('content-blur');
        document.body.style.overflow = 'hidden';
        
        // Add entrance animation
        const modalContent = modal.querySelector('.bg-white');
        modalContent.classList.add('modal-enter');
    }
    
    // Hide modal with animation
    function hideModal() {
        const modalContent = modal.querySelector('.bg-white');
        modalContent.classList.remove('modal-enter');
        modalContent.classList.add('modal-exit');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            mainContent.classList.remove('content-blur');
            document.body.style.overflow = '';
            modalContent.classList.remove('modal-exit');
        }, 300);
    }
    
    // Show modal on page load
    showModal();
    
    // Close modal events
    closeBtn.addEventListener('click', hideModal);
    
    // Close on backdrop click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            hideModal();
        }
    });
    
    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            hideModal();
        }
    });
    
    // Smooth scrolling for modal content
    const modalBody = modal.querySelector('.overflow-y-auto');
    if (modalBody) {
        modalBody.style.scrollBehavior = 'smooth';
    }
});
</script>
@endif

</body>
</html>