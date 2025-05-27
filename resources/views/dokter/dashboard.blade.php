<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter - StuntCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="font-['Poppins'] bg-gray-50 text-gray-800">
    <x-app-layout>
        <main class="py-16">
            <!-- Header Dashboard Dokter -->
            <section class="text-center mb-8">
                <h2 class="text-4xl font-semibold text-gray-800 mb-6">
                    Selamat datang, Dokter <span class="text-pink-500">{{ Auth::user()->name }}</span>
                </h2>
                <p class="text-lg text-gray-600">Ini adalah dashboard untuk dokter. Anda dapat mengelola konsultasi
                    dokter dan artikel terkait kesehatan.</p>
            </section>

            <!-- Profil Dokter -->
            <section class="w-full bg-white py-16">
                <div class="max-w-4xl mx-auto text-center">
                    <h3 class="text-2xl font-semibold text-pink-600 mb-6">Profil Dokter</h3>
                    <div class="bg-pink-50 p-8 rounded-xl shadow-lg">
                            <div class="mx-auto w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 bg-zinc-300 rounded-full overflow-hidden flex-shrink-0">
                                @if(Auth::user()->fotoprofil)
                                    <img src="{{ asset('storage/fotoprofil/' . Auth::user()->fotoprofil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                @else
                                    <img src="https://avatar.iran.liara.run/username?username={{ urlencode(Auth::user()->name) }}" alt="Default Avatar" class="w-full h-full object-cover">
                                @endif
                            </div>
                        <p class="text-xl text-gray-700 mb-4">Nama: <span
                                class="font-semibold">{{ Auth::user()->name }}</span></p>
                        <p class="text-xl text-gray-700 mb-4">Email: <span
                                class="font-semibold">{{ Auth::user()->email }}</span></p>
                        <p class="text-xl text-gray-700 mb-4">Role: <span class="font-semibold">{{ Auth::user()->role }}</span></p>
                    </div>
                </div>
            </section>

            <!-- Konsultasi Dokter -->
            <section class="py-16 bg-gradient-to-b from-white to-pink-50">
                <div class="max-w-7xl mx-auto px-6">
                    <h2 class="text-4xl font-semibold text-pink-600 text-center mb-12">
                        Konsultasi Dokter
                    </h2>
                    <div class="text-center mb-8">
                        <a href="{{ route('dokter.konsultasi.index') }}"
                            class="bg-pink-500 text-white px-6 py-3 rounded-lg hover:bg-pink-600 transition-colors duration-300">
                            Lihat Konsultasi Dokter
                        </a>
                    </div>
                </div>
            </section>

            <!-- Artikel Terbaru -->
            <section class="w-full bg-white py-16">
                <div class="max-w-7xl mx-auto px-6">
                    <h2 class="text-4xl font-semibold text-pink-600 text-center mb-12">
                        Artikel Terbaru
                    </h2>
                <div class="text-center mb-8">
                        <a href="{{ route('dokter.artikel.index') }}"
                            class="bg-pink-500 text-white px-6 py-3 rounded-lg hover:bg-pink-600 transition-colors duration-300">
                            Lihat Artikel
                        </a>
                    </div>

                    @if(isset($artikels) && $artikels->count() > 0)
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($artikels as $artikel)
                                <div class="bg-white border border-pink-200 rounded-3xl shadow-lg overflow-hidden flex flex-col hover:shadow-xl transition-shadow duration-300">
                                    <div class="bg-pink-500 py-4 px-6 text-white text-xl md:text-2xl font-semibold">
                                        {{ $artikel->title }}
                                    </div>
                                    <img src="{{ $artikel->image_url ?? 'https://placehold.co/400x250/fce7f3/db2777?text=Artikel' }}"
                                         onerror="this.src='https://placehold.co/400x250/fce7f3/db2777?text=Error';"
                                         class="w-full h-48 md:h-56 object-cover" alt="Gambar Artikel: {{ $artikel->title }}">
                                    <div class="p-6 text-gray-700 flex-grow">
                                        <p class="text-base md:text-lg">{{ \Illuminate\Support\Str::limit(strip_tags($artikel->content), 120, '...') }}</p>
                                    </div>
                                    <div class="p-6 pt-0">
                                        <button type="button"
                                                onclick="openArticleModal({{ json_encode($artikel) }})"
                                                class="w-full bg-pink-500 text-white font-medium rounded-lg text-base px-5 py-3 hover:bg-pink-600 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-75">
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

        </main>

        <!-- Modal untuk Artikel -->
        <div id="article-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50 hidden p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] flex flex-col">
                <div class="flex items-center justify-between p-5 border-b border-gray-200">
                    <h3 id="modal-title" class="text-2xl font-semibold text-pink-600"></h3>
                    <button id="close-modal-button"
                            class="text-gray-400 hover:text-gray-600 transition-colors text-3xl leading-none font-bold focus:outline-none">&times;</button>
                </div>
                <div class="p-6 space-y-4 text-gray-700 overflow-y-auto">
                    <img id="modal-image" src="" class="w-full h-auto max-h-80 object-contain rounded-lg mb-4 shadow" alt="Gambar Artikel Detail" style="display:none;">
                    <div id="modal-content" class="prose max-w-none text-base md:text-lg leading-relaxed">
                    </div>
                </div>
                <div class="flex justify-end p-5 border-t border-gray-200">
                    <button id="close-modal-footer-button"
                            class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-pink-400">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
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

                window.openArticleModal = function (article) {
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
                    modal.addEventListener('click', function (event) {
                        if (event.target === modal) { // Check if the click is on the backdrop
                            closeArticleModal();
                        }
                    });
                }
            });
        </script>
    </x-app-layout>
</body>

</html>
