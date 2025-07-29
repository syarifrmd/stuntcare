<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuntCare - Dashboard Dokter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

        /* Swiper 3D Styles */
        .swiper {
            width: 100%;
            height: 100%;
            padding: 50px 0;
        }

        .swiper-slide {
            width: 300px;
            height: 400px;
            position: relative;
            transition: transform 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .swiper-slide-active {
            transform: scale(1.2);
            z-index: 2;
        }

        .swiper-slide-prev,
        .swiper-slide-next {
            transform: scale(0.8);
            opacity: 0.5;
        }

        .slide-content {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            text-align: center;
            overflow: hidden;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem;
            position: relative;
            flex-shrink: 0;
        }

        .edit-profile-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ec4899;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            z-index: 10;
        }

        .edit-profile-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.2);
        }

        .logout-btn {
            font-size: 0.875rem;
            color: #6b7280;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            color: #ec4899;
            background: #fdf2f8;
        }

        .profile-image::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            padding: 3px;
            background: linear-gradient(45deg, #ec4899, #f472b6);
            -webkit-mask: 
                linear-gradient(#fff 0 0) content-box, 
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }

        .action-button {
            background: #ec4899;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3);
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #ec4899;
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 18px;
        }

        .swiper-pagination-bullet {
            background: #ec4899;
            opacity: 0.5;
        }

        .swiper-pagination-bullet-active {
            opacity: 1;
            transform: scale(1.2);
        }

        .article-image {
            width: 100%;
            height: 200px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .article-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .article-image:hover img {
            transform: scale(1.1);
        }

        .article-modal-content {
            max-height: 70vh;
            overflow-y: auto;
        }

        .article-modal-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1rem 0;
        }

        .article-modal-content p {
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .swal2-popup {
            border-radius: 1rem !important;
        }

        .swal2-title {
            color: #1f2937 !important;
            font-size: 1.5rem !important;
        }

        .swal2-html-container {
            margin: 1rem 0 !important;
        }

        .swal2-confirm {
            background-color: #ec4899 !important;
        }

        .swal2-confirm:hover {
            background-color: #db2777 !important;
        }
    </style>
</head>
<body class="bg-white">
    <main class="w-full">
        <div class="w-full bg-white pb-8 pt-12">
            <div class="max-w-screen-xl mx-auto">
                <div class="rounded-3xl overflow-hidden min-h-[600px] flex flex-wrap items-center bg-pink-100">
                    <!-- Welcome Section -->
                    <div class="w-full lg:w-1/2 p-8 flex flex-col justify-center">
                        <div class="py-6 bg-pink-100 rounded-2xl">
                            <div class="text-center">
                                <h2 class="text-4xl font-semibold text-gray-800 mb-6">
                                    Selamat datang Dokter <span class="text-pink-500">{{ Auth::user()->name }}</span>
                                </h2>
                                <div class="flex justify-center">
                                    <span class="typing" id="typing"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3D Carousel Section -->
                    <div class="w-full lg:w-1/2 p-4">
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <!-- Slide 1 - Profil -->
                                <div class="swiper-slide">
                                    <div class="slide-content">
                                        <h3 class="text-2xl font-semibold text-pink-600 mb-6">Profil Dokter</h3>
                                        <a href="{{ route('dokter.profile.edit') }}" class="edit-profile-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <div class="profile-image">
                                            @if(Auth::user()->fotoprofil)
                                                <img src="{{ asset('storage/fotoprofil/' . Auth::user()->fotoprofil) }}" alt="Foto Profil">
                                            @else
                                                <img src="https://avatar.iran.liara.run/username?username={{ urlencode(Auth::user()->name) }}" alt="Default Avatar">
                                            @endif
                                        </div>
                                        <div class="space-y-2 mb-4">
                                            <p class="text-gray-700">Nama: <strong>{{ Auth::user()->name }}</strong></p>
                                            <p class="text-gray-700">Email: <strong>{{ Auth::user()->email }}</strong></p>
                                            <p class="text-gray-700">Role: <strong>{{ Auth::user()->role }}</strong></p>
                                            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                                @csrf
                                                <button type="submit" class="logout-btn bg-pink-500 text-neutral-50">
                                                    Logout
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Slide 2 - Konsultasi -->
                                <div class="swiper-slide">
                                    <div class="slide-content">
                                        <h3 class="text-2xl font-semibold text-pink-600 mb-6">Konsultasi Dokter</h3>
                                        <div class="mb-6">
                                            <i class="fas fa-stethoscope text-5xl text-pink-500 mb-4"></i>
                                            <p class="text-gray-600">Kelola konsultasi pasien Anda dengan mudah</p>
                                        </div>
                                        <a href="{{ route('dokter.konsultasi.index') }}" class="action-button">
                                            Lihat Konsultasi
                                        </a>
                                    </div>
                                </div>

                                <!-- Slide 3 - Artikel -->
                                <div class="swiper-slide">
                                    <div class="slide-content">
                                        <h3 class="text-2xl font-semibold text-pink-600 mb-6">Artikel Terbaru</h3>
                                        @if(isset($artikels) && $artikels->count() > 0)
                                            @foreach($artikels->take(1) as $artikel)
                                                <div class="article-image">
                                                    <img src="{{ $artikel->image_url }}" alt="Gambar Artikel">
                                                </div>
                                                <h4 class="text-xl font-bold mb-2">{{ $artikel->title }}</h4>
                                                <p class="text-gray-700 mb-4">{{ \Illuminate\Support\Str::limit(strip_tags($artikel->content), 100, '...') }}</p>
                                                <a href="#" 
                                                   class="article-link action-button"
                                                   data-title="{{ $artikel->title }}"
                                                   data-content="{{ $artikel->content }}"
                                                   data-image="{{ $artikel->image_url }}">
                                                    Baca Selengkapnya
                                                </a>
                                            @endforeach
                                        @else
                                            <p class="text-gray-500">Belum ada artikel.</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Slide 4 - Tambah Artikel -->
                                <div class="swiper-slide">
                                    <div class="slide-content">
                                        <h3 class="text-2xl font-semibold text-pink-600 mb-6">Tambahkan Artikel</h3>
                                        <div class="mb-6">
                                            <i class="fas fa-pen-fancy text-5xl text-pink-500 mb-4"></i>
                                            <p class="text-gray-600">Bagikan pengetahuan Anda melalui artikel</p>
                                        </div>
                                        <a href="{{ route('dokter.artikel.index') }}" class="action-button">
                                            Tambahkan Artikel
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Typing Animation Script
            const typingElement = document.getElementById('typing');
            if (typingElement) {
                const texts = [
                    'Pantau pertumbuhan anak dengan mudah!',
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
                        setTimeout(type, typingSpeed / 2);
                    }
                }
                if (texts.length > 0) {
                    setTimeout(type, 1000);
                }
            }

            // Initialize Swiper
            const swiper = new Swiper('.mySwiper', {
                effect: 'coverflow',
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: 'auto',
                coverflowEffect: {
                    rotate: 50,
                    stretch: 0,
                    depth: 100,
                    modifier: 1,
                    slideShadows: true,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                keyboard: {
                    enabled: true,
                },
                mousewheel: {
                    thresholdDelta: 50,
                },
            });

            // Article Modal Function
            function showArticleModal(article) {
                Swal.fire({
                    title: article.title,
                    html: `
                        <div class="article-modal-content">
                            <img src="${article.image_url}" alt="Article Image" class="w-full">
                            <div class="prose max-w-none">
                                ${article.content}
                            </div>
                        </div>
                    `,
                    showCloseButton: true,
                    showConfirmButton: false,
                    width: '800px',
                    padding: '2rem',
                    customClass: {
                        container: 'article-modal',
                        popup: 'article-modal-popup',
                        content: 'article-modal-content'
                    }
                });
            }

            // Add click event to article links
            document.querySelectorAll('.article-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const articleData = {
                        title: this.dataset.title,
                        content: this.dataset.content,
                        image_url: this.dataset.image
                    };
                    showArticleModal(articleData);
                });
            });
        });
    </script>
</body>
</html>
