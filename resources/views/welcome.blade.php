<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuntCare - Pantau Gizi Anak Cegah Stunting</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pink-stunt': '#FF69B4', // Main brand pink
                        'pink-light': '#FFD1DC', // Lighter pink
                        'pink-dark': '#D1478E',  // Darker pink for hover/accents
                    },
                    animation: {
                        'slide-in-left': 'slideInFromLeft 0.7s ease-out forwards',
                        'slide-in-right': 'slideInFromRight 0.7s ease-out forwards',
                        'fade-in': 'fadeIn 1s ease-out forwards',
                        'pop-in': 'popIn 0.6s cubic-bezier(0.68, -0.55, 0.27, 1.55) forwards',
                        'pop-in-tr': 'popInTR 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55) 0.5s forwards', // Delay for top-right
                        'pop-in-bl': 'popInBL 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55) 0.7s forwards', // Delay for bottom-left
                        'subtle-bob': 'subtleBob 3s ease-in-out infinite alternate',
                    },
                    keyframes: {
                        slideInFromLeft: {
                            '0%': { transform: 'translateX(-50px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        slideInFromRight: {
                            '0%': { transform: 'translateX(50px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        popIn: {
                            '0%': { transform: 'scale(0.8)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        },
                        popInTR: { // Pop in from Top Right
                            '0%': { transform: 'translate(30px, -30px) scale(0.8)', opacity: '0' },
                            '100%': { transform: 'translate(0, 0) scale(1)', opacity: '1' },
                        },
                        popInBL: { // Pop in from Bottom Left
                            '0%': { transform: 'translate(-30px, 30px) scale(0.8)', opacity: '0' },
                            '100%': { transform: 'translate(0, 0) scale(1)', opacity: '1' },
                        },
                        subtleBob: {
                            '0%': { transform: 'translateY(0px)' },
                            '100%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <style>
        .typing {
            border-right: 2px solid #ec4899;
            animation: blink 1s infinite;
            font-size: 2.5rem;
            font-weight: 600;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(180deg, #FFFFFF 0%, #FFF0F7 100%); /* Softer pink gradient */
            overflow-x: hidden; /* Prevent horizontal scrollbars */
        }
        /* Styling for the 3D canvas container in Hero */
        #threejs-hero-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0; /* Behind other hero content elements */
            opacity: 0.6; /* Make it subtle */
            pointer-events: none; /* Allow clicks to pass through */
        }
        /* Ensure hero content is above the 3D canvas */
        .hero-content-item {
            position: relative;
            z-index: 1;
        }
        .hero-interactive-card {
            transition: transform 0.3s ease-out, box-shadow 0.3s ease-out;
        }
        .hero-interactive-card:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 10px 20px rgba(255, 105, 180, 0.3); /* pink-stunt shadow */
        }
        .feature-card, .testimonial-card {
            transition: transform 0.3s ease-out, box-shadow 0.3s ease-out;
        }
        .feature-card:hover, .testimonial-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        }
        .faq-button {
            transition: background-color 0.3s ease;
        }
        .faq-button:hover {
            background-color: #D1478E; /* pink-dark */
        }
        .faq-content {
            transition: max-height 0.5s ease-in-out, opacity 0.5s ease-in-out, padding 0.5s ease-in-out;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            padding: 0 1.5rem;
        }
        .faq-content.open {
            opacity: 1;
            max-height: 1000px; /* Increased max-height to accommodate longer content */
            padding: 1.5rem;
        }
        /* Smooth scroll for nav links */
        html {
            scroll-behavior: smooth;
        }
        
        /* Scroll Animation Classes */
        .scroll-animation {
            opacity: 0;
            transition: all 0.8s ease-out;
            will-change: transform, opacity;
        }
        
        .scroll-animation.fade-up {
            transform: translateY(50px);
        }
        
        .scroll-animation.fade-down {
            transform: translateY(-50px);
        }
        
        .scroll-animation.fade-left {
            transform: translateX(50px);
        }
        
        .scroll-animation.fade-right {
            transform: translateX(-50px);
        }
        
        .scroll-animation.zoom-in {
            transform: scale(0.8);
        }
        
        .scroll-animation.active {
            opacity: 1;
            transform: translate(0) scale(1);
        }

        .scroll-animation.inactive {
            opacity: 0;
        }

        /* Message section specific animations */
        .message-section .scroll-animation.inactive.fade-left {
            transform: translateX(50px);
        }

        .message-section .scroll-animation.inactive.fade-right {
            transform: translateX(-50px);
        }

        /* FAQ specific animations */
        .faq-item {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease-out;
        }

        .faq-item.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
        <!-- PWA  -->
        <meta name="theme-color" content="#6777ef"/>
        <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
        <link rel="manifest" href="{{ asset('/manifest.json') }}">
</head>
<body class="min-h-screen">
<button id="pwa-install-btn" class="bg-pink-500" style="display:none; position: fixed; bottom: 20px; right: 20px; padding: 10px 20px; color: white; border: none; border-radius: 8px; z-index: 1000;">
   Install App
</button>
    <nav class="bg-white py-4 shadow-md fixed w-full z-50 top-0">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <a href="#hero" class="flex items-center">
                <img src="{{asset('images/logo.png')}}" alt="StuntCare Logo" class="h-10">
            </a>
            
            <div class="hidden md:flex space-x-8">
                <a href="#hero" class="text-gray-700 hover:text-pink-stunt font-medium transition-colors duration-300">Home</a>
                <a href="#about" class="text-gray-700 hover:text-pink-stunt font-medium transition-colors duration-300">About</a>
                <a href="#features" class="text-gray-700 hover:text-pink-stunt font-medium transition-colors duration-300">Feature</a>
                <a href="#feedback" class="text-gray-700 hover:text-pink-stunt font-medium transition-colors duration-300">Contact</a>
                <a href="#faq" class="text-gray-700 hover:text-pink-stunt font-medium transition-colors duration-300">FAQ</a>
            </div>
            
            <div class="flex items-center space-x-4">
                 <a href="{{route('login')}}" class="text-gray-700 hover:text-pink-stunt font-medium transition-colors duration-300">Sign In</a>
                 <a href="{{route('register')}}" class="bg-pink-stunt hover:bg-pink-dark text-white font-medium px-6 py-2 rounded-full transition-all duration-300 transform hover:scale-105">Register</a>
            </div>
        </div>
    </nav>

    <section id="hero" class="pt-32 pb-20 bg-pink-50 relative overflow-hidden">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-12 md:mb-0 scroll-animation fade-left hero-content-item">
                <div class="text-7xl md:text-5xl font-bold text-pink-stunt leading-tight mb-6">
                    <span class="typing" id="typing">Mari mulai perjalanan sehat bersama StuntCare!</span>
                </div>
                <p class="text-gray-700 text-lg mb-10">
                    Dengan fitur pemantauan makanan, edukasi artikel, dan pengingat harian, StuntCare
                    hadir sebagai partner Anda dalam tumbuh kembang anak yang optimal.
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{route('login')}}" class="bg-pink-stunt hover:bg-pink-dark text-center text-white font-medium px-8 py-3 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">Ayo Pantau!</a>
                    <a href="#features" class="border-2 border-pink-stunt text-center text-pink-stunt hover:bg-pink-stunt hover:text-white font-medium px-8 py-3 rounded-full transition-all duration-300 transform hover:scale-105">Jelajahi</a>
                </div>
            </div>

            <div class="md:w-1/2 relative scroll-animation fade-right">
                <div class="bg-pink-200/50 backdrop-blur-sm rounded-xl p-2 sm:p-6 relative shadow-2xl">
                    <img src="{{asset('images/dokter.png')}}" alt="Dokter StuntCare" class="mx-auto rounded-lg w-auto h-72 sm:h-96 object-contain animate-subtle-bob">
                    
                    <div class="hero-interactive-card absolute top-1 sm:top-6 right-1 sm:right-0 bg-white rounded-lg p-1.5 sm:p-3 shadow-md animate-pop-in-tr w-32 sm:w-max">
                        <div class="flex items-center">
                            <div>
                                <p class="font-semibold text-[10px] sm:text-sm">Dr. Nadine A Sp.A</p>
                                <p class="text-[8px] sm:text-xs text-gray-500">Salah satu dokter terbaik</p>
                            </div>
                            <img src="{{asset('images/dokter.png')}}" alt="Doctor Avatar" class="w-5 h-5 sm:w-8 sm:h-8 rounded-full ml-1 sm:ml-2 hidden sm:block">
                        </div>
                        <div class="bg-pink-stunt text-white text-[8px] sm:text-xs font-medium px-1.5 py-0.5 sm:px-2 sm:py-1 rounded mt-0.5 sm:mt-1 text-center">
                            Terverifikasi
                        </div>
                    </div>

                    <div class="hero-interactive-card absolute bottom-1 sm:bottom-6 left-1 sm:left-6 bg-white rounded-lg p-1.5 sm:p-4 shadow-md w-36 sm:w-64 animate-pop-in-bl">
                        <p class="font-semibold text-[10px] sm:text-sm mb-1 sm:mb-2">Pemantauan Harian</p>
                        <div class="space-y-0.5 sm:space-y-2">
                            <div>
                                <div class="flex justify-between text-[8px] sm:text-xs mb-0.5 sm:mb-1"><span>Karbohidrat</span><span>60%</span></div>
                                <div class="w-full bg-gray-200 rounded-full h-0.5 sm:h-2"><div class="bg-pink-stunt h-0.5 sm:h-2 rounded-full" style="width: 60%"></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between text-[8px] sm:text-xs mb-0.5 sm:mb-1"><span>Protein</span><span>75%</span></div>
                                <div class="w-full bg-gray-200 rounded-full h-0.5 sm:h-2"><div class="bg-pink-stunt h-0.5 sm:h-2 rounded-full" style="width: 75%"></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between text-[8px] sm:text-xs mb-0.5 sm:mb-1"><span>Vitamin</span><span>100%</span></div>
                                <div class="w-full bg-gray-200 rounded-full h-0.5 sm:h-2"><div class="bg-pink-stunt h-0.5 sm:h-2 rounded-full" style="width: 100%"></div></div>
                            </div>
                        </div>
                        <button class="bg-pink-stunt hover:bg-pink-dark text-white text-[8px] sm:text-xs font-medium px-1.5 py-0.5 sm:px-4 sm:py-2 rounded-md sm:rounded-lg w-full mt-1 sm:mt-3 transition duration-300">
                            Belum Terpenuhi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-pink-stunt text-center mb-16 scroll-animation fade-down">Fitur StuntCare</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="feature-card bg-white rounded-lg p-6 sm:p-8 shadow-lg hover:shadow-xl scroll-animation fade-up" style="transition-delay: 0.1s">
                    <div class="bg-pink-light text-pink-stunt p-3 rounded-lg inline-block mb-4"><i class="fas fa-chart-bar text-2xl"></i></div>
                    <h3 class="text-xl font-semibold text-pink-stunt mb-3">Pemantauan Gizi</h3>
                    <p class="text-gray-600 text-sm">Lacak asupan energi, protein, lemak, dan karbohidrat anak setiap hari.</p>
                </div>
                <div class="feature-card bg-white rounded-lg p-6 sm:p-8 shadow-lg hover:shadow-xl scroll-animation fade-up" style="transition-delay: 0.2s">
                    <div class="bg-pink-light text-pink-stunt p-3 rounded-lg inline-block mb-4"><i class="fas fa-book-open text-2xl"></i></div> <h3 class="text-xl font-semibold text-pink-stunt mb-3">Artikel Edukasi</h3>
                    <p class="text-gray-600 text-sm">Dapatkan konten informatif seputar nutrisi dan pencegahan stunting.</p>
                </div>
                <div class="feature-card bg-white rounded-lg p-6 sm:p-8 shadow-lg hover:shadow-xl scroll-animation fade-up" style="transition-delay: 0.3s">
                    <div class="bg-pink-light text-pink-stunt p-3 rounded-lg inline-block mb-4"><i class="fas fa-bell text-2xl"></i></div>
                    <h3 class="text-xl font-semibold text-pink-stunt mb-3">Pengingat Harian</h3>
                    <p class="text-gray-600 text-sm">Ingatkan konsumsi makanan sesuai kebutuhan harian anak.</p>
                </div>
                <div class="feature-card bg-white rounded-lg p-6 sm:p-8 shadow-lg hover:shadow-xl scroll-animation fade-up" style="transition-delay: 0.4s">
                    <div class="bg-pink-light text-pink-stunt p-3 rounded-lg inline-block mb-4"><i class="fas fa-stethoscope text-2xl"></i></div>
                    <h3 class="text-xl font-semibold text-pink-stunt mb-3">Konsultasi Dokter</h3>
                    <p class="text-gray-600 text-sm">Terhubung ke dokter anak langsung via WhatsApp.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="py-16 bg-pink-50 overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                <div class="md:w-1/3 scroll-animation fade-left">
                    <img src="{{asset('images/dokteranak.png')}}" alt="Keluarga dengan anak" class="rounded-lg shadow-xl w-full h-auto object-cover">
                </div>
                <div class="md:w-2/3 scroll-animation fade-right">
                    <h2 class="text-3xl md:text-4xl font-bold text-pink-stunt mb-6">Tentang StuntCare</h2>
                    <p class="text-gray-700 mb-4 leading-relaxed">StuntCare adalah aplikasi pintar yang dirancang untuk membantu orang tua dalam memantau asupan gizi anak sehari-hari. Kami percaya bahwa pencegahan stunting dimulai dari pengetahuan tepat yang didukung oleh teknologi.</p>
                    <p class="text-gray-700 mb-4 leading-relaxed">Dengan menggabungkan data gizi, edukasi kesehatan, serta pengingat harian, StuntCare hadir sebagai solusi praktis dan terpercaya untuk memaksimalkan tumbuh kembang anak Anda.</p>
                    <p class="text-gray-700 leading-relaxed">Kami tidak hanya menyajikan data, tapi juga menghadirkan pemahaman — ingat selalu orang tua hebat membuat keputusan terbaik untuk buah hati tercinta.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-pink-stunt text-center mb-16 scroll-animation fade-down">Apa Kata Mereka?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="testimonial-card bg-white p-6 rounded-lg shadow-lg hover:shadow-xl scroll-animation zoom-in" style="transition-delay: 0.1s">
                    <div class="flex items-center mb-4">
                        <img src="https://placehold.co/48x48/FFD1DC/4A4A4A?text=AD&font=Poppins" alt="Bu Dinda" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <p class="font-medium text-pink-stunt">Arya D.</p>
                            <p class="text-gray-500 text-sm">Ibu 2 Anak</p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic text-sm">"Sejak pakai StuntCare, saya lebih tenang karena bisa pantau kebutuhan gizi anak setiap hari. Aplikasinya mudah digunakan!"</p>
                </div>
                <div class="testimonial-card bg-white p-6 rounded-lg shadow-lg hover:shadow-xl scroll-animation zoom-in" style="transition-delay: 0.2s">
                    <div class="flex items-center mb-4">
                        <img src="https://placehold.co/48x48/FFD1DC/4A4A4A?text=BS&font=Poppins" alt="Pak Budi" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <p class="font-medium text-pink-stunt">Budi S.</p>
                            <p class="text-gray-500 text-sm">Ayah 1 Anak</p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic text-sm">"Artikel edukasinya sangat membantu saya memahami lebih dalam tentang stunting. Fitur pengingat juga top!"</p>
                </div>
                <div class="testimonial-card bg-white p-6 rounded-lg shadow-lg hover:shadow-xl scroll-animation zoom-in" style="transition-delay: 0.3s">
                    <div class="flex items-center mb-4">
                        <img src="https://placehold.co/48x48/FFD1DC/4A4A4A?text=CD&font=Poppins" alt="Bu Citra" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <p class="font-medium text-pink-stunt">Citra D.</p>
                            <p class="text-gray-500 text-sm">Ibu Baru</p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic text-sm">"Konsultasi dengan dokter via StuntCare praktis banget. Nggak perlu repot keluar rumah. Recommended!"</p>
                </div>
            </div>
        </div>
    </section>
    
    <section id="feedback" class="py-16 bg-pink-50 overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                <div class="md:w-1/2 mb-8 md:mb-0 scroll-animation fade-left">
                    <h2 class="text-3xl md:text-4xl font-bold text-pink-stunt mb-4">Berikan Umpan Balik</h2>
                    <p class="text-lg text-pink-dark font-medium mb-6">Umpan Balikmu Sangat Berarti Untuk Perkembangan Aplikasi StuntCare!</p>
                    <div class="relative mt-8 sm:mt-12">
                        <img src="{{asset('images/dokterpesan.png')}}" alt="Dokter StuntCare menerima pesan" class="w-3/4 sm:w-2/3 mx-auto rounded-lg animate-subtle-bob">
                        <div class="absolute inset-0 bg-pink-200/70 rounded-full -z-10 transform translate-y-8 scale-95 blur-xl"></div>
                    </div>
                </div>
                <div class="md:w-1/2 md:pl-8 scroll-animation fade-right">
                    <p class="text-gray-700 mb-6">Punya pertanyaan atau umpan balik? Sampaikan kepada kami!</p>
                    <form action="#" method="POST" class="space-y-6 bg-white p-8 rounded-xl shadow-xl">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" id="name" name="name" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-stunt focus:border-pink-stunt transition-shadow">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-stunt focus:border-pink-stunt transition-shadow">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                            <input type="text" id="subject" name="subject" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-stunt focus:border-pink-stunt transition-shadow">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                            <textarea id="message" name="message" rows="5" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-stunt focus:border-pink-stunt transition-shadow"></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="bg-pink-stunt hover:bg-pink-dark text-white font-medium px-8 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">Kirim Pesan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <section id="faq" class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-pink-stunt text-center mb-16 scroll-animation fade-down">Pertanyaan yang Sering Diajukan</h2>
            <div class="max-w-3xl mx-auto space-y-4" id="faqAccordion">
                <div class="faq-item max-h-60 bg-pink-stunt rounded-xl overflow-hidden shadow-md">
                    <button class="faq-button flex justify-between items-center w-full text-left text-white px-6 py-4 focus:outline-none">
                        <span class="font-medium">Apakah aplikasi StuntCare gratis?</span>
                        <svg class="h-5 w-5 transform transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                    <div class="faq-content bg-white">
                        <p class="text-gray-700 text-sm">Ya, aplikasi StuntCare dapat digunakan secara gratis dengan mengakses semua fitur</p>
                    </div>
                </div>
                <div class="faq-item max-h-60 bg-pink-stunt rounded-xl overflow-hidden shadow-md">
                    <button class="faq-button flex justify-between items-center w-full text-left text-white px-6 py-4 focus:outline-none">
                        <span class="font-medium">Apakah data anak saya aman di aplikasi ini?</span>
                        <svg class="h-5 w-5 transform transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                    <div class="faq-content bg-white">
                        <p class="text-gray-700 text-sm">Keamanan data anak Anda adalah prioritas utama kami. Semua data dienkripsi dan disimpan dengan aman menggunakan standar keamanan internasional terkini.</p>
                    </div>
                </div>
                <div class="faq-item max-h-60 bg-pink-stunt rounded-xl overflow-hidden shadow-md">
                    <button class="faq-button flex justify-between items-center w-full text-left text-white px-6 py-4 focus:outline-none">
                        <span class="font-medium">Bagaimana cara saya berkonsultasi dengan dokter?</span>
                        <svg class="h-5 w-5 transform transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                    <div class="faq-content bg-white">
                        <p class="text-gray-700 text-sm">Anda dapat berkonsultasi dengan dokter anak berpengalaman melalui fitur chat WhatsApp yang terintegrasi. Cukup klik tombol "Konsultasi Dokter" pada aplikasi dan ikuti petunjuknya.</p>
                    </div>
                </div>
                <div class="faq-item max-h-60 bg-pink-stunt rounded-xl overflow-hidden shadow-md">
                    <button class="faq-button flex justify-between items-center w-full text-left text-white px-6 py-4 focus:outline-none">
                        <span class="font-medium">Bisakah saya melacak gizi lebih dari satu anak?</span>
                        <svg class="h-5 w-5 transform transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                    <div class="faq-content bg-white">
                        <p class="text-gray-700 text-sm">Tentu saja! StuntCare dirancang untuk mendukung pemantauan gizi untuk beberapa anak dalam satu akun, memudahkan Anda mengelola kesehatan seluruh buah hati.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-pink-dark text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <a href="#hero" class="flex items-center mb-4">
                        <div class="text-white mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                <circle cx="16" cy="6.5" r="2" fill="#FFD1DC"/> </svg>
                        </div>
                        <span class="text-white font-bold text-xl">StuntCare</span>
                    </a>
                    <p class="text-pink-light text-sm opacity-90 leading-relaxed">
                        Partner terpercaya Anda dalam memantau gizi dan mencegah stunting pada anak.
                    </p>
                    <div class="flex space-x-3 mt-6">
                        <a href="#" class="bg-white text-pink-dark p-2 rounded-full hover:bg-pink-light hover:text-pink-stunt transition-all duration-300 transform hover:scale-110"><i class="fab fa-facebook-f fa-fw"></i></a>
                        <a href="#" class="bg-white text-pink-dark p-2 rounded-full hover:bg-pink-light hover:text-pink-stunt transition-all duration-300 transform hover:scale-110"><i class="fab fa-instagram fa-fw"></i></a>
                        <a href="#" class="bg-white text-pink-dark p-2 rounded-full hover:bg-pink-light hover:text-pink-stunt transition-all duration-300 transform hover:scale-110"><i class="fab fa-twitter fa-fw"></i></a>
                        <a href="#" class="bg-white text-pink-dark p-2 rounded-full hover:bg-pink-light hover:text-pink-stunt transition-all duration-300 transform hover:scale-110"><i class="fab fa-youtube fa-fw"></i></a>
                    </div>
                </div>
                <div class="md:col-span-3 grid grid-cols-2 sm:grid-cols-3 gap-8">
                    <div>
                        <h4 class="text-white font-semibold mb-4 text-lg">Navigasi</h4>
                        <ul class="space-y-2">
                            <li><a href="#hero" class="text-pink-light hover:text-white hover:underline transition-colors">Home</a></li>
                            <li><a href="#about" class="text-pink-light hover:text-white hover:underline transition-colors">Tentang Kami</a></li>
                            <li><a href="#features" class="text-pink-light hover:text-white hover:underline transition-colors">Fitur</a></li>
                            <li><a href="#testimonials" class="text-pink-light hover:text-white hover:underline transition-colors">Testimoni</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4 text-lg">Dukungan</h4>
                        <ul class="space-y-2">
                            <li><a href="#faq" class="text-pink-light hover:text-white hover:underline transition-colors">FAQ</a></li>
                            <li><a href="#feedback" class="text-pink-light hover:text-white hover:underline transition-colors">Kontak Kami</a></li>
                            <li><a href="#" class="text-pink-light hover:text-white hover:underline transition-colors">Kebijakan Privasi</a></li>
                            <li><a href="#" class="text-pink-light hover:text-white hover:underline transition-colors">Syarat & Ketentuan</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4 text-lg">Alamat Kantor</h4>
                        <p class="text-pink-light text-sm leading-relaxed">Jl. Kesehatan Anak No. 123<br>Jakarta Sehat, Indonesia 12345<br>Email: support@stuntcare.id</p>
                    </div>
                </div>
            </div>
            <div class="text-center border-t border-pink-stunt/50 pt-8 mt-8">
                <p class="text-sm text-pink-light opacity-90">
                    &copy; <span id="currentYear"></span> StuntCare. All rights reserved. Dibuat dengan <i class="fas fa-heart text-pink-stunt"></i> untuk generasi Indonesia sehat.
                </p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('/sw.js') }}"></script>
<script>
   if ("serviceWorker" in navigator) {
      // Register a service worker hosted at the root of the
      // site using the default scope.
      navigator.serviceWorker.register("/sw.js").then(
      (registration) => {
         console.log("Service worker registration succeeded:", registration);
      },
      (error) => {
         console.error(`Service worker registration failed: ${error}`);
      },
    );
  } else {
     console.error("Service workers are not supported.");
  }
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const texts = [
                'Pantau tumbuh kembang anak dengan mudah',
                'Konsultasi dengan dokter kapan saja',
                'Jaga gizi harian untuk masa depan yang cerah',
                'StuntCare mendorong anak Indonesia sehat',
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

        // Set current year in footer
        document.getElementById('currentYear').textContent = new Date().getFullYear();

        // FAQ Accordion
        document.addEventListener('DOMContentLoaded', function() {
            const faqAccordion = document.getElementById('faqAccordion');
            if (faqAccordion) {
                const accordionButtons = faqAccordion.querySelectorAll('.faq-button');
                
                accordionButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const content = button.nextElementSibling;
                        const icon = button.querySelector('svg');
                        const isOpen = content.classList.contains('open');
                        
                        // Close all other items
                        accordionButtons.forEach(otherButton => {
                            if (otherButton !== button) {
                                const otherContent = otherButton.nextElementSibling;
                                const otherIcon = otherButton.querySelector('svg');
                                if (otherContent.classList.contains('open')) {
                                    otherContent.classList.remove('open');
                                    otherIcon.classList.remove('rotate-180');
                                }
                            }
                        });
                        
                        if (isOpen) {
                            content.classList.remove('open');
                            icon.classList.remove('rotate-180');
                        } else {
                            content.classList.add('open');
                            icon.classList.add('rotate-180');
                        }
                    });
                });
            }
        });

        // Three.js Animation for Hero Section
        function initThreeJSAnimation() {
            const container = document.getElementById('threejs-hero-container');
            if (!container) return;

            let scene, camera, renderer, objects = [];

            // Scene
            scene = new THREE.Scene();

            // Camera
            camera = new THREE.PerspectiveCamera(75, container.clientWidth / container.clientHeight, 0.1, 1000);
            camera.position.z = 5;

            // Renderer
            renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true }); // alpha for transparent background
            renderer.setSize(container.clientWidth, container.clientHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            container.appendChild(renderer.domElement);

            // Lighting
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.6); // Soft white light
            scene.add(ambientLight);
            const pointLight = new THREE.PointLight(0xFFD1DC, 1, 100); // Pinkish light
            pointLight.position.set(5, 5, 5);
            scene.add(pointLight);

            // Geometry and Materials
            const geometries = [
                new THREE.IcosahedronGeometry(0.8, 0), // Crystal-like
                new THREE.TorusKnotGeometry(0.6, 0.15, 100, 16), // Abstract knot
                new THREE.SphereGeometry(0.5, 16, 16) // Simple sphere
            ];
            const materials = [
                new THREE.MeshStandardMaterial({ color: 0xFF69B4, roughness: 0.3, metalness: 0.4 }), // pink-stunt
                new THREE.MeshStandardMaterial({ color: 0xFFD1DC, roughness: 0.5, metalness: 0.2 }), // pink-light
                new THREE.MeshPhongMaterial({ color: 0xFFFFFF, transparent: true, opacity: 0.7, shininess: 80 }) // semi-transparent white
            ];

            // Create and position objects
            for (let i = 0; i < 5; i++) { // Create a few objects
                const geometry = geometries[Math.floor(Math.random() * geometries.length)];
                const material = materials[Math.floor(Math.random() * materials.length)];
                const object = new THREE.Mesh(geometry, material);

                object.position.x = (Math.random() - 0.5) * 8;
                object.position.y = (Math.random() - 0.5) * 6;
                object.position.z = (Math.random() - 0.5) * 2 -1; // Slightly in front or behind camera plane

                object.rotation.x = Math.random() * 2 * Math.PI;
                object.rotation.y = Math.random() * 2 * Math.PI;

                // Store random rotation speeds
                object.userData.rotationSpeedX = (Math.random() - 0.5) * 0.005;
                object.userData.rotationSpeedY = (Math.random() - 0.5) * 0.005;
                
                scene.add(object);
                objects.push(object);
            }
            
            // Animation loop
            function animate() {
                requestAnimationFrame(animate);

                objects.forEach(object => {
                    object.rotation.x += object.userData.rotationSpeedX;
                    object.rotation.y += object.userData.rotationSpeedY;
                });

                renderer.render(scene, camera);
            }
            animate();

            // Handle window resize
            window.addEventListener('resize', () => {
                if (container.clientWidth > 0 && container.clientHeight > 0) {
                    camera.aspect = container.clientWidth / container.clientHeight;
                    camera.updateProjectionMatrix();
                    renderer.setSize(container.clientWidth, container.clientHeight);
                }
            });
        }
        
        // Initialize Three.js animation when the DOM is ready
        if (typeof THREE !== 'undefined') {
            document.addEventListener('DOMContentLoaded', initThreeJSAnimation);
        } else {
            console.warn('Three.js library not loaded. 3D animation will not run.');
        }

        // Enhanced Scroll Animation
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            // Message section observer
            const messageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        entry.target.classList.remove('inactive');
                    } else {
                        entry.target.classList.remove('active');
                        entry.target.classList.add('inactive');
                    }
                });
            }, observerOptions);

            // FAQ items observer
            const faqObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    } else {
                        entry.target.classList.remove('active');
                    }
                });
            }, {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            });

            // Observe message section elements
            document.querySelectorAll('.message-section .scroll-animation').forEach((element) => {
                messageObserver.observe(element);
            });

            // Observe FAQ items
            document.querySelectorAll('.faq-item').forEach((element, index) => {
                element.style.transitionDelay = `${index * 0.2}s`;
                faqObserver.observe(element);
            });

            // Other section observers remain the same
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        entry.target.classList.remove('inactive');
                    } else {
                        const rect = entry.target.getBoundingClientRect();
                        const isScrollingDown = rect.top < 0;
                        
                        if (isScrollingDown) {
                            entry.target.style.transform = 'translateY(-50px)';
                        } else {
                            entry.target.style.transform = 'translateY(50px)';
                        }
                        
                        entry.target.classList.remove('active');
                        entry.target.classList.add('inactive');
                    }
                });
            }, observerOptions);

            // Observe other elements
            document.querySelectorAll('.scroll-animation:not(.message-section *)').forEach((element) => {
                observer.observe(element);
            });
        });
    </script>
    <script src="{{ asset('pwa-install.js') }}"></script>
    
    <!-- Include notification and service worker scripts for authenticated users -->
    @auth
        <x-notification-scripts />
    @endauth
    
</body>
</html>
