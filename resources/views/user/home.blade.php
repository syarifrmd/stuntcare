<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuntCare - Tumbuh Kembang Optimal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .typing {
            border-right: 2px solid #ec4899;
            animation: blink 1s infinite;
            font-size: 1.5rem;
            color: #ec4899;
            font-weight: 600;
        }
        
        @keyframes blink {
            0%, 50% { border-color: transparent; }
            51%, 100% { border-color: #ec4899; }
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%);
        }
        
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-white">
<x-app-layout>
    <span name="header"></span>
    <!-- Main Content -->
    <main class="pt-28">
        <!-- Hero Section -->
        <section class="w-full min-h-screen relative hero-gradient">
            <div class="max-w-screen-xl mx-auto px-6 py-12">
                <div class="bg-pink-50 rounded-3xl shadow-lg overflow-hidden min-h-[708px] flex items-center">
                    <div class="flex flex-wrap w-full">
                        <!-- Left Content -->
                        <div class="w-full lg:w-1/2 p-12 flex flex-col justify-center">
                            <h1 class="text-5xl font-bold text-pink-500 leading-tight mb-8 font-['Poppins']">
                                Tumbuh Kembang Optimal
                            </h1>
                            <p class="text-xl text-pink-500 mb-8 font-['Poppins']">
                                Pantau perkembangan anak secara menyeluruh, jaga asupan gizi harian, dan wujudkan generasi sehat dan cerdas sejak dini bersama Stuntcare
                            </p>
                            <button class="bg-pink-500 text-white px-8 py-4 rounded-full text-lg font-medium hover:bg-pink-600 transition-all duration-300 w-48 shadow-lg hover:shadow-xl">
                                Mulai Sekarang
                            </button>
                        </div>

                        <!-- Right Image -->
                        <div class="hidden lg:block lg:w-1/2 relative">
                            <img class="w-full h-[px] object-cover absolute right-0 top-[-40px] rounded-tl-[90px] rounded-tr-3xl rounded-bl-[200px] rounded-br-3xl shadow-lg"
                                 src="https://placehold.co/637x747" alt="Ibu dan anak sehat">
                        </div>
                    </div>
                </div>

                <!-- Quote Section -->
                <div class="max-w-4xl mx-auto text-center mt-16">
                    <blockquote class="text-xl text-pink-500 font-normal font-['Poppins'] italic">
                        "Jangan biarkan stunting menghambat masa depan anak. Stuntcare hadir untuk bantu pantau dan jaga kesehatannya sejak dini."
                    </blockquote>
                </div>
            </div>
        </section>

        <!-- Welcome Section with Typing Animation -->
        <section class="py-16 bg-white">
            <div class="max-w-4xl mx-auto text-center px-6">
                <h2 class="text-4xl font-semibold text-gray-800 mb-6">
                    Selamat datang, <span class="text-pink-500">Nadine Abigail</span>
                </h2>
                <div class="flex justify-center items-center">
                    <span class="typing" id="typing">Mari mulai perjalanan sehat bersama StuntCare!</span>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="w-full bg-gradient-to-b from-pink-50 to-pink-100 rounded-tl-[100px] rounded-tr-[100px] py-24">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-5xl font-semibold text-pink-500 text-center mb-16 font-['Poppins']">
                    Wujudkan Generasi Sehat melalui Pemantauan Gizi Harian
                </h2>

                <!-- Main Feature Image -->
                <div class="flex justify-center mb-20">
                    <img class="w-full max-w-4xl h-auto rounded-3xl shadow-2xl" 
                         src="https://placehold.co/821x548" alt="Pemantauan gizi anak">
                </div>

                <!-- Features Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-20">
                    <!-- Feature 1 - Pencegahan Stunting -->
                    <div class="feature-card bg-white rounded-3xl p-6 shadow-lg">
                        <img class="w-full h-80 object-cover rounded-3xl mb-6" 
                             src="https://placehold.co/413x313" alt="Pencegahan stunting">
                        <h3 class="text-2xl font-semibold text-pink-500 mb-4">Pencegahan Stunting</h3>
                        <p class="text-lg text-gray-700 font-['Poppins']">
                            Stunting dapat dicegah melalui gizi seimbang, pemantauan tumbuh kembang rutin, dan perawatan sejak hamil hingga usia 5 tahun. Stuntcare hadir untuk mendukung orang tua dalam menjaga kesehatan anak setiap hari.
                        </p>
                    </div>

                    <!-- Feature 2 - Perkembangan Anak -->
                    <div class="feature-card bg-white rounded-3xl p-6 shadow-lg">
                        <img class="w-full h-64 object-cover rounded-3xl mb-6" 
                             src="https://placehold.co/371x259" alt="Perkembangan anak">
                        <h3 class="text-2xl font-semibold text-pink-500 mb-4">Perkembangan Cepat</h3>
                        <p class="text-lg text-gray-700 font-['Poppins']">
                            Perkembangan anak yang cepat adalah periode di mana anak mengalami peningkatan pertumbuhan fisik yang signifikan dalam waktu singkat. Ini sering terjadi pada bayi dan balita masa pubertas.
                        </p>
                    </div>

                    <!-- Feature 3 - Konsultasi Dokter -->
                    <div class="feature-card bg-white rounded-3xl p-6 shadow-lg">
                        <img class="w-full h-64 object-cover rounded-3xl mb-6" 
                             src="https://placehold.co/371x259" alt="Konsultasi dokter">
                        <h3 class="text-2xl font-semibold text-pink-500 mb-4">Konsultasi Dokter</h3>
                        <p class="text-lg text-gray-700 font-['Poppins']">
                            Dapatkan jawaban cepat dari dokter seputar pertumbuhan, pola makan, dan kesehatan anak. Fitur ini memudahkan orang tua berkonsultasi secara asinkron, cukup melalui aplikasi secara aman dan terpercaya.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Articles Carousel Section -->
        <section class="py-20 bg-white">
            <div class="max-w-6xl mx-auto px-6">
                <h2 class="text-4xl font-semibold text-pink-500 text-center mb-12 font-['Poppins']">
                    Artikel Terbaru
                </h2>
                
                <!-- Carousel -->
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <!-- Indicators -->
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    
                    <!-- Carousel Items -->
                    <div class="carousel-inner">
                        <!-- Article 1 -->
                        <div class="carousel-item active">
                            <div class="bg-pink-50 p-8 rounded-3xl shadow-lg mx-4">
                                <img src="https://placehold.co/800x400" class="w-full h-64 object-cover rounded-2xl mb-6" alt="Article Image">
                                <h3 class="text-2xl font-semibold text-pink-500 mb-4">Tips Mencegah Stunting Pada Anak</h3>
                                <p class="text-gray-700 text-lg mb-6">
                                    Stunting merupakan kondisi gagal tumbuh pada anak akibat kekurangan gizi kronis. Pelajari cara mencegahnya sejak dini dengan pola makan yang tepat dan pemantauan rutin.
                                </p>
                                <a href="#" class="inline-block bg-pink-500 text-white px-6 py-3 rounded-full hover:bg-pink-600 transition-all duration-300">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                        
                        <!-- Article 2 -->
                        <div class="carousel-item">
                            <div class="bg-pink-50 p-8 rounded-3xl shadow-lg mx-4">
                                <img src="https://placehold.co/800x400" class="w-full h-64 object-cover rounded-2xl mb-6" alt="Article Image">
                                <h3 class="text-2xl font-semibold text-pink-500 mb-4">Pentingnya Gizi Seimbang untuk Tumbuh Kembang</h3>
                                <p class="text-gray-700 text-lg mb-6">
                                    Gizi seimbang merupakan kunci utama dalam mendukung tumbuh kembang optimal anak. Ketahui komponen gizi yang dibutuhkan sesuai dengan usia anak.
                                </p>
                                <a href="#" class="inline-block bg-pink-500 text-white px-6 py-3 rounded-full hover:bg-pink-600 transition-all duration-300">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                        
                        <!-- Article 3 -->
                        <div class="carousel-item">
                            <div class="bg-pink-50 p-8 rounded-3xl shadow-lg mx-4">
                                <img src="https://placehold.co/800x400" class="w-full h-64 object-cover rounded-2xl mb-6" alt="Article Image">
                                <h3 class="text-2xl font-semibold text-pink-500 mb-4">Panduan Konsultasi dengan Dokter Anak</h3>
                                <p class="text-gray-700 text-lg mb-6">
                                    Mengetahui kapan dan bagaimana berkonsultasi dengan dokter anak sangat penting. Pelajari tips untuk mempersiapkan konsultasi yang efektif.
                                </p>
                                <a href="#" class="inline-block bg-pink-500 text-white px-6 py-3 rounded-full hover:bg-pink-600 transition-all duration-300">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="py-20 bg-gradient-to-r from-pink-500 to-pink-600">
            <div class="max-w-4xl mx-auto text-center px-6">
                <h2 class="text-4xl font-bold text-white mb-6 font-['Poppins']">
                    Mulai Perjalanan Sehat Anak Anda Hari Ini
                </h2>
                <p class="text-xl text-pink-100 mb-8">
                    Bergabunglah dengan ribuan orang tua yang telah mempercayakan kesehatan anak mereka bersama StuntCare
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button class="bg-white text-pink-500 px-8 py-4 rounded-full text-lg font-semibold hover:bg-pink-50 transition-all duration-300 shadow-lg">
                        Daftar Sekarang
                    </button>
                    <button class="border-2 border-white text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-white hover:text-pink-500 transition-all duration-300">
                        Pelajari Lebih Lanjut
                    </button>
                </div>
            </div>
        </section>
    </main>
    <!-- JavaScript for Typing Animation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const texts = [
                'Mari mulai perjalanan sehat bersama StuntCare!',
                'Pantau tumbuh kembang anak dengan mudah',
                'Konsultasi dengan dokter kapan saja',
                'Jaga gizi harian untuk masa depan yang cerah'
            ];
            
            let textIndex = 0;
            let charIndex = 0;
            const typingElement = document.getElementById('typing');
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
                    setTimeout(type, typingSpeed);
                }
            }
            
            // Start typing animation
            setTimeout(type, 1000);
        });
    </script>
</x-app-layout>
</body>
</html>