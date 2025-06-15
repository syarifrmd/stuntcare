<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuntCare - Dashboard Dokter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .typing {
            border-right: 2px solid #ec4899;
            animation: blink 1s infinite;
            color: #ec4899;
            font-weight: 600;
        }
        @keyframes blink {
            0%, 50% { border-color: transparent; }
            51%, 100% { border-color: #ec4899; }
        }
        .feature-card {
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-10px);
        }
    </style>
</head>
<body class="bg-white">
    <main class="w-full">
        <div class="w-full bg-white pb-8 pt-2">
            <div class="max-w-screen-xl mx-auto px-6">
                <div class="rounded-3xl overflow-hidden min-h-[600px] flex flex-wrap items-center bg-pink-100">
                    <!-- Welcome Section -->
                    <div class="w-full lg:w-1/2 p-8 flex flex-col justify-center">
                        <div class="py-6 bg-pink-100 rounded-2xl">
                            <div class="text-center">
                                <h2 class="text-4xl font-semibold text-gray-800 mb-6">
                                    Selamat datang Dokter <span class="text-pink-500">{{ Auth::user()->name }}</span>
                                </h2>
                                <div class="flex justify-center">
                                    <span class="typing" id="typing">Pantau pertumbuhan anak dengan mudah!</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carousel Section -->
                    <div class="w-full lg:w-1/2 p-4">
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <!-- Slide 1 - Profil -->
                                <div class="carousel-item active">
                                    <div class="bg-white p-6 rounded-3xl text-center">
                                        <h3 class="text-2xl font-semibold text-pink-600 mb-4">Profil Dokter</h3>
                                        <div class="w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden">
                                            @if(Auth::user()->fotoprofil)
                                                <img src="{{ asset('storage/fotoprofil/' . Auth::user()->fotoprofil) }}" alt="Foto Profil" class="object-cover w-full h-full">
                                            @else
                                                <img src="https://avatar.iran.liara.run/username?username={{ urlencode(Auth::user()->name) }}" alt="Default Avatar" class="object-cover w-full h-full">
                                            @endif
                                        </div>
                                        <p class="text-lg text-gray-700">Nama: <strong>{{ Auth::user()->name }}</strong></p>
                                        <p class="text-lg text-gray-700">Email: <strong>{{ Auth::user()->email }}</strong></p>
                                        <p class="text-lg text-gray-700">Role: <strong>{{ Auth::user()->role }}</strong></p>
                                    </div>
                                </div>

                                <!-- Slide 2 - Konsultasi -->
                                <div class="carousel-item">
                                    <div class="bg-white p-6 rounded-3xl text-center">
                                        <h3 class="text-2xl font-semibold text-pink-600 mb-4">Konsultasi Dokter</h3>
                                        <a href="{{ route('dokter.konsultasi.index') }}" class="bg-pink-500 text-white px-6 py-3 rounded-lg hover:bg-pink-600 transition">Lihat Konsultasi</a>
                                    </div>
                                </div>

                                <!-- Slide 3 - Artikel -->
                                <div class="carousel-item">
                                    <div class="bg-white p-6 rounded-3xl ">
                                        <h3 class="text-2xl font-semibold text-pink-600 text-center mb-6">Artikel Terbaru</h3>
                                        @if(isset($artikels) && $artikels->count() > 0)
                                            @foreach($artikels->take(1) as $artikel)
                                                <div class="text-center">
                                                    <h4 class="text-xl font-bold mb-2">{{ $artikel->title }}</h4>
                                                    <img src="{{ $artikel->image_url }}" alt="Gambar Artikel" class="w-full h-48 object-cover rounded mb-4">
                                                    <p class="text-gray-700">{{ \Illuminate\Support\Str::limit(strip_tags($artikel->content), 100, '...') }}</p>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-center text-gray-500">Belum ada artikel.</p>
                                        @endif
                                    </div>
                                </div>

                                                                <!-- Slide 4 - Artikel -->
                                <div class="carousel-item">
                                    <div class="bg-white p-6 rounded-3xl text-center">
                                        <h3 class="text-2xl font-semibold text-pink-600 mb-4">Tambahkan Artikel</h3>
                                        <a href="{{ route('dokter.artikel.index') }}" class="bg-pink-500 text-white px-6 py-3 rounded-lg hover:bg-pink-600 transition">Tambahkan Artikel</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Carousel Controls -->
                            <div class="flex justify-between items-center mt-4 px-8">
                                <button class="carousel-control-prev " type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="outline-pink-600 carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                 <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="hidden">Next</span>
                                </button>
                                <!-- <button class="custom-carousel-control" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    ‹
                                </button>
                                <button class="custom-carousel-control" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    ›
                                </button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Typing Animation Script
                const typingElement = document.getElementById('typing');
                if (typingElement) {
                    const texts = [

                    'Pantau pertumbuhan anak dari berbagai data gizi harian.',
                    'Kelola konsultasi pasien dengan cepat dan efisien.',
                    'Berikan edukasi melalui artikel kesehatan terpercaya.',
                    'Wujudkan generasi sehat melalui kolaborasi digital.'

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
</body>
</html>
