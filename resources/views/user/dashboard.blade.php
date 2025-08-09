<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuntCare - Tumbuh Kembang Optimal</title>
  <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pink-stunt': '#FF69B4', // Main brand pink
                        'pink-light': '#FFD1DC', // Lighter pink
                        'pink-dark': '#D1478E',  // Darker pink for hover/accents
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Custom CSS untuk animasi ketik dan styling tambahan jika diperlukan */
        .typing {
            border-right: 2px solid #ec4899; /* Warna pink Tailwind */
            animation: blink 1s infinite;
            font-size: 1.5rem; /* Tailwind: text-2xl */
            font-weight: 600; /* Tailwind: font-semibold */
        }
        
        @keyframes blink {
            0%, 50% { border-color: transparent; }
            51%, 100% { border-color: #ec4899; } /* Warna pink Tailwind */
        }
        /* .feature-card styling bisa langsung menggunakan Tailwind utilities di HTML */
    </style>
    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef"/>
        <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
        <link rel="manifest" href="{{ asset('/manifest.json') }}">
</head>
<body class="font-['Poppins'] bg-gray-50 text-gray-800">
<button id="pwa-install-btn" class="bg-pink-500" style="display:none; position: fixed; bottom: 20px; right: 20px; padding: 10px 20px; color: white; border: none; border-radius: 8px; z-index: 1000;">
   Install App
</button>
<x-app-layout>
    <span name="header"></span>
    <main class="">
        <section class="py-16 bg-white">
            <div class="max-w-4xl mx-auto text-center px-6">
                <h2 class="text-4xl font-semibold text-gray-800 mb-6">
                    Selamat datang, <span class="text-pink-500">{{ Auth::user()->name }}</span>
                </h2>
                <div class="flex justify-center items-center min-h-[3rem]">
                    <span class="typing" id="typing"></span>
                </div>
            </div>
        </section>

        <section class="w-full relative bg-white pb-12">
            <div class="max-w-screen-xl mx-auto px-6">
                <div class="rounded-3xl overflow-hidden min-h-[600px] md:min-h-[708px] flex items-center bg-pink-100 ">
                    <div class="flex flex-wrap w-full">
                        <div class="w-full lg:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                            <h1 class="text-4xl md:text-5xl font-bold text-pink-600 leading-tight mb-8">
                                Tumbuh Kembang Optimal
                            </h1>
                            <p class="text-lg md:text-xl text-pink-700 mb-8">
                                Pantau perkembangan anak secara menyeluruh, jaga asupan gizi harian, dan wujudkan generasi sehat dan cerdas sejak dini bersama StuntCare.
                            </p>
                        </div>
                        <div class="hidden lg:block lg:w-1/2 relative">
                            <img class="w-full h-auto max-h-[700px] object-cover relative lg:right-0 lg:top-[-40px] rounded-tl-[90px] rounded-tr-3xl rounded-bl-[200px] rounded-br-3xl"
                                 src="{{asset('images/dokteranak2.png')}}" 
                                 alt="Ibu dan anak sehat">
                        </div>
                    </div>
                </div>

                <div class="max-w-4xl mx-auto text-center mt-16">
                    <blockquote class="text-xl text-pink-600 font-normal italic">
                        "Jangan biarkan stunting menghambat masa depan anak. StuntCare hadir untuk bantu pantau dan jaga kesehatannya sejak dini."
                    </blockquote>
                </div>
            </div>
        </section>

        <section class="py-20 bg-gradient-to-b from-white to-pink-50">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-4xl font-semibold text-pink-600 text-center mb-12">
                    Artikel Terbaru
                </h2>
                
                @if(isset($articles) && $articles->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($articles as $article)
                    <div class="bg-white border border-pink-200 rounded-3xl shadow-lg overflow-hidden flex flex-col hover:shadow-xl transition-shadow duration-300">
                        <div class="bg-pink-500 py-4 px-6 text-white text-xl md:text-2xl font-semibold">
                            {{ $article->title }}
                        </div>
                        @if ($article->foto_artikel)
                            <img src="{{ asset('storage/' . $article->foto_artikel) }}" alt="{{ $article->title }}"
                                class="w-full h-full object-cover rounded transition-transform duration-300 hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500 text-xs sm:text-sm">
                                Tidak ada gambar
                            </div>
                        @endif
                        <div class="p-6 text-gray-700 flex-grow">
                            <p class="text-base md:text-lg">{{ \Illuminate\Support\Str::limit(strip_tags($article->content), 120, '...') }}</p>
                        </div>
                        <div class="p-6 pt-0">
                            <button 
                                type="button"
                                onclick="openArticleModal({{ json_encode($article) }})"
                                class="w-full bg-pink-500 text-white font-medium rounded-lg text-base px-5 py-3 hover:bg-pink-600 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-75"
                            >
                                Baca Selengkapnya
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-center text-gray-600 text-xl">Belum ada artikel yang tersedia saat ini.</p>
                @endif
            </div>
        </section>

        <section class="w-full bg-pink-50 py-24">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-4xl md:text-5xl font-semibold text-pink-600 text-center mb-16">
                    Wujudkan Generasi Sehat melalui Pemantauan Gizi Harian
                </h2>

                <div class="flex justify-center mb-12 md:mb-20">
                    <img class="w-full max-w-4xl h-auto rounded-3xl shadow-2xl" 
                         src="{{asset('images/pemantauan.png')}}" 
                         alt="Pemantauan gizi anak">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12 md:mt-20">
                    <div class="feature-card bg-white rounded-3xl p-6 shadow-lg hover:translate-y-[-10px] hover:shadow-xl transition-all duration-300 ease-in-out">
                        <img class="w-full h-56 md:h-64 object-cover rounded-2xl mb-6" 
                             src="{{asset('images/makananbergizi.jpg')}}" 
                             onerror="this.src='https://placehold.co/413x313/fce7f3/831843?text=Error';"
                             alt="Pencegahan stunting">
                        <h3 class="text-2xl font-semibold text-pink-600 mb-4">Pencegahan Stunting</h3>
                        <p class="text-base md:text-lg text-gray-700">
                            Stunting dapat dicegah melalui gizi seimbang, pemantauan tumbuh kembang rutin, dan perawatan sejak hamil hingga usia 5 tahun. StuntCare hadir untuk mendukung orang tua.
                        </p>
                    </div>
                    <div class="feature-card bg-white rounded-3xl p-6 shadow-lg hover:translate-y-[-10px] hover:shadow-xl transition-all duration-300 ease-in-out">
                        <img class="w-full h-56 md:h-64 object-cover rounded-2xl mb-6" 
                             src="{{asset('images/akusedangtinggi.jpeg')}}" 
                             onerror="this.src='https://placehold.co/371x259/fbcfe8/9d174d?text=Error';"
                             alt="Perkembangan anak">
                        <h3 class="text-2xl font-semibold text-pink-600 mb-4">Perkembangan Cepat</h3>
                        <p class="text-base md:text-lg text-gray-700">
                            Anak mengalami peningkatan pertumbuhan fisik yang signifikan dalam waktu singkat. Ini sering terjadi pada bayi, balita, dan masa pubertas. Pantau terus perkembangannya.
                        </p>
                    </div>
                    <div class="feature-card bg-white rounded-3xl p-6 shadow-lg hover:translate-y-[-10px] hover:shadow-xl transition-all duration-300 ease-in-out">
                        <img class="w-full h-56 md:h-64 object-cover rounded-2xl mb-6" 
                             src="{{asset('images/konsuldokter.jpg')}}" 
                             onerror="this.src='https://placehold.co/371x259/fce7f3/831843?text=Error';"
                             alt="Konsultasi dokter">
                        <h3 class="text-2xl font-semibold text-pink-600 mb-4">Konsultasi Dokter</h3>
                        <p class="text-base md:text-lg text-gray-700">
                            Dapatkan jawaban cepat dari dokter seputar pertumbuhan, pola makan, dan kesehatan anak. Fitur ini memudahkan orang tua berkonsultasi secara aman dan terpercaya.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div id="article-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50 hidden p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] flex flex-col">
            <div class="flex items-center justify-between p-5 border-b border-gray-200">
                <h3 id="modal-title" class="text-2xl font-semibold text-pink-600"></h3>
                <button id="close-modal-button" class="text-gray-400 hover:text-gray-600 transition-colors text-3xl leading-none font-bold focus:outline-none">&times;</button>
            </div>
            <div class="p-6 space-y-4 text-gray-700 overflow-y-auto">
                <img id="modal-image" src="" class="w-full h-auto max-h-80 object-contain rounded-lg mb-4 shadow" alt="Gambar Artikel Detail" style="display:none;">
                <div id="modal-content" class="prose max-w-none text-base md:text-lg leading-relaxed">
                    </div>
            </div>
            <div class="flex justify-end p-5 border-t border-gray-200">
                <button id="close-modal-footer-button" class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <livewire:chatbot />
    <script src="{{ asset('pwa-install.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Typing Animation Script
            const typingElement = document.getElementById('typing');
            if (typingElement) {
                const texts = [
                    'Pantau tumbuh kembang anak dengan mudah.',
                    'Konsultasi dengan dokter kapan saja.',
                    'Jaga gizi harian untuk masa depan yang cerah.'
                ];
                let textIndex = 0;
                let charIndex = 0;
                const typingSpeed = 100;
                const erasingSpeed = 50;
                const delayBetweenTexts = 2000;

                function type() {
                    if (charIndex < texts[textIndex].length) {
                        typingElement.textContent += texts[textIndex].charAt(charIndex);
                        charIndex++;
                        setTimeout(type, typingSpeed);
                    } else {
                        setTimeout(erase, delayBetweenTexts);
                    }
                }

                function erase() {
                    if (charIndex > 0) {
                        typingElement.textContent = texts[textIndex].substring(0, charIndex - 1);
                        charIndex--;
                        setTimeout(erase, erasingSpeed);
                    } else {
                        textIndex = (textIndex + 1) % texts.length;
                        setTimeout(type, typingSpeed / 2); // Start typing next text a bit faster
                    }
                }
                if (texts.length > 0) {
                     setTimeout(type, 1000); // Initial delay before starting
                }
            }

            // Modal Script
            const modal = document.getElementById('article-modal');
            const modalTitle = document.getElementById('modal-title');
            const modalImage = document.getElementById('modal-image');
            const modalContent = document.getElementById('modal-content');
            const closeModalButton = document.getElementById('close-modal-button');
            const closeModalFooterButton = document.getElementById('close-modal-footer-button');

            window.openArticleModal = function(article) {
                if (!modal || !modalTitle || !modalContent || !modalImage) {
                    console.error('Modal elements not found!');
                    return;
                }
                modalTitle.textContent = article.title || 'Detail Artikel';
                
                if (article.image_url) {
                    modalImage.src = article.image_url;
                    modalImage.alt = `Gambar Artikel: ${article.title || ''}`;
                    modalImage.style.display = 'block';
                     modalImage.onerror = () => {
                        modalImage.src = 'https://placehold.co/600x400/fce7f3/db2777?text=Gambar+Error';
                        modalImage.alt = 'Gambar tidak dapat dimuat';
                    };
                } else {
                    modalImage.style.display = 'none';
                }
                // Pastikan konten adalah HTML yang aman atau proses sesuai kebutuhan
                modalContent.innerHTML = article.content || '<p>Konten tidak tersedia.</p>'; 
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }

            function closeArticleModal() {
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto'; // Restore background scrolling
                }
            }

            if (closeModalButton) closeModalButton.addEventListener('click', closeArticleModal);
            if (closeModalFooterButton) closeModalFooterButton.addEventListener('click', closeArticleModal);

            // Close modal on escape key
            document.addEventListener('keydown', function (event) {
                if (event.key === "Escape" && modal && !modal.classList.contains('hidden')) {
                    closeArticleModal();
                }
            });

            // Close modal when clicking outside of the modal content
            if (modal) {
                modal.addEventListener('click', function(event) {
                    if (event.target === modal) { // Check if the click is on the backdrop
                        closeArticleModal();
                    }
                });
            }
        });

            <!-- Include notification and service worker scripts for authenticated users -->
    @auth
        <x-notification-scripts />
    @endauth

    
</x-app-layout>
</body>
</html>

