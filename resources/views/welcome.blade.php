<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>StuntCare - Pantau Gizi Anak Cegah Stunting</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pink-stunt': '#FF69B4',
                        'pink-light': '#FFD1DC',
                    }
                }
            }
        }
    </script>
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(180deg, #FFF 0%, #FFE6F0 100%);
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white py-4 shadow-sm">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <a href="#" class="flex items-center">
                <div class="text-pink-stunt mr-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Dokter StuntCare" class="mx-auto w-fit h-10">
                </div>
            </a>
            
            <div class="hidden md:flex space-x-8">
                <a href="#" class="text-gray-800 font-medium">Home</a>
                <a href="#" class="text-gray-800 font-medium">About</a>
                <a href="#" class="text-gray-800 font-medium">Feature</a>
                <a href="#" class="text-gray-800 font-medium">Contact</a>
                <a href="#" class="text-gray-800 font-medium">FAQ</a>
            </div>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="text-gray-800 font-medium">Sign In</a>
                <a href="{{ route('register') }}" class="bg-pink-stunt hover:bg-pink-600 text-white font-medium px-6 py-2 rounded-full transition duration-300">Register</a>
            </div>

        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-20 bg-pink-50">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-12 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold text-pink-stunt leading-tight mb-4">
                    Pantau Gizi Anak<br>Cegah Stunting<br>Lebih Awal
                </h1>
                <p class="text-gray-700 text-lg mb-8">
                    Dengan fitur pemantauan makanan, edukasi artikel, dan pengingat harian, StuntCare
                    hadir sebagai partner Anda dalam tumbuh kembang anak yang optimal
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#" class="bg-pink-stunt hover:bg-pink-600 text-center text-white font-medium px-8 py-3 rounded-full transition duration-300">Ayo Pantau!</a>
                    <a href="#" class="border border-pink-stunt text-center text-pink-stunt hover:bg-pink-50 font-medium px-8 py-3 rounded-full transition duration-300">Jelajahi</a>
                </div>
            </div>
            
            <div class="md:w-1/2 relative">
                <div class="bg-pink-200 rounded-lg p-6 relative">
                    <img src="{{ asset('images/dokter.png') }}" alt="Dokter StuntCare" class="mx-auto rounded-lg w-fit h-96">
                    
                    <div class="absolute top-6  right-0 w-max bg-white rounded-lg p-3 shadow-md">
                        <div class="flex items-center">
                            <div>
                                <p class="font-semibold text-sm">Dr. Nadine A Sp.A</p>
                                <p class="text-xs text-gray-500">Salah satu dokter terbaik di StuntCare</p>
                            </div>
                            <img src="{{ asset('images/dokter.png') }}" alt="Doctor Avatar" class="w-8 h-8 rounded-full ml-2">
                        </div>
                        <div class="bg-pink-stunt text-white text-xs font-medium px-2 py-1 rounded mt-1 text-center">
                            Terverifikasi
                        </div>
                    </div>
                    
                    <div class="absolute bottom-6 left-6 bg-white rounded-lg p-4 shadow-md w-64">
                        <p class="font-semibold text-sm mb-2">Pemantauan Harian</p>
                        
                        <div class="space-y-2">
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span>Karbohidrat</span>
                                    <span>60%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-pink-stunt h-2 rounded-full" style="width: 60%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span>Protein</span>
                                    <span>75%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-pink-stunt h-2 rounded-full" style="width: 75%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span>Vitamin</span>
                                    <span>100%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-pink-stunt h-2 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span>Mineral</span>
                                    <span>100%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-pink-stunt h-2 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span>Lemak</span>
                                    <span>100%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-pink-stunt h-2 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                        
                        <button class="bg-pink-stunt hover:bg-pink-600 text-white text-xs font-medium px-4 py-2 rounded-lg w-full mt-3 transition duration-300">
                            Belum Terpenuhi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-pink-stunt text-center mb-16">Fitur StuntCare</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg transition duration-300">
                    <div class="bg-pink-100 text-pink-stunt p-3 rounded-lg inline-block mb-4">
                        <i class="fas fa-chart-bar text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-pink-stunt mb-4">Pemantauan Gizi</h3>
                    <p class="text-gray-600">
                        Lacak asupan energi, protein, lemak, dan karbohidrat anak setiap hari.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg transition duration-300">
                    <div class="bg-pink-100 text-pink-stunt p-3 rounded-lg inline-block mb-4">
                        <i class="fas fa-globe text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-pink-stunt mb-4">Artikel Edukasi</h3>
                    <p class="text-gray-600">
                        Dapatkan konten informatif seputar nutrisi dan pencegahan stunting.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg transition duration-300">
                    <div class="bg-pink-100 text-pink-stunt p-3 rounded-lg inline-block mb-4">
                        <i class="fas fa-bell text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-pink-stunt mb-4">Pengingat Harian</h3>
                    <p class="text-gray-600">
                        Ingatkan konsumsi makanan sesuai kebutuhan harian anak.
                    </p>
                </div>
                
                <!-- Feature 4 -->
                <div class="bg-white rounded-lg p-8 shadow-md hover:shadow-lg transition duration-300">
                    <div class="bg-pink-100 text-pink-stunt p-3 rounded-lg inline-block mb-4">
                        <i class="fas fa-stethoscope text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-pink-stunt mb-4">Konsultasi Dokter</h3>
                    <p class="text-gray-600">
                        Terhubung ke dokter anak langsung via WhatsApp.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About StuntCare Section -->
    <section class="py-16 bg-pink-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/3 mb-8 md:mb-0">
                    <img src="{{ asset('images/dokteranak.png') }}" alt="Keluarga dengan anak" class="rounded-lg w-full h-auto">
                </div>
                
                <div class="md:w-2/3 md:pl-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-pink-stunt mb-6">Tentang StuntCare</h2>
                    
                    <p class="text-gray-700 mb-4">
                        StuntCare adalah aplikasi pintar yang dirancang untuk membantu orang tua dalam memantau asupan gizi anak sehari-hari. Kami percaya bahwa pencegahan stunting dimulai dari pengetahuan stunting dimulai dari pengetahuan tepat yang didukung oleh teknologi.
                    </p>
                    
                    <p class="text-gray-700 mb-4">
                        Dengan menggabungkan data gizi, edukasi kesehatan, serta pengingat harian, StuntCare hadir sebagai solusi praktis dan terpercaya untuk memaksimalkan tumbuh kembang anak Anda.
                    </p>
                    
                    <p class="text-gray-700">
                        Kami tidak hanya menyajikan data, tapi juga menghadirkan pemahaman — ingat selalu orang tua hebat membuat keputusan terbaik untuk buah hati tercinta.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-pink-stunt text-center mb-16">Apa Orang Bilang?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/budinda.png') }}" alt="Bu Dinda" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <p class="font-medium">Bu Dinda</p>
                            <p class="text-gray-600 text-sm">Ibu 2 Anak</p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic">
                        "Sejak pakai StuntCare, saya lebih tenang karena bisa pantau kebutuhan gizi anak setiap hari."
                    </p>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/budinda.png') }}" alt="Bu Dinda" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <p class="font-medium">Bu Dinda</p>
                            <p class="text-gray-600 text-sm">Ibu 2 Anak</p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic">
                        "Sejak pakai StuntCare, saya lebih tenang karena bisa pantau kebutuhan gizi anak setiap hari."
                    </p>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/budinda.png') }}" alt="Bu Dinda" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <p class="font-medium">Bu Dinda</p>
                            <p class="text-gray-600 text-sm">Ibu 2 Anak</p>
                        </div>
                    </div>
                    <p class="text-gray-700 italic">
                        "Sejak pakai StuntCare, saya lebih tenang karena bisa pantau kebutuhan gizi anak setiap hari."
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Feedback Section -->
    <section class="py-16 bg-pink-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h2 class="text-3xl md:text-4xl font-bold text-pink-stunt mb-4">Berikan Umpan Balik</h2>
                    <p class="text-lg text-pink-stunt font-medium mb-6">Umpan Balikmu Sangat Berarti Untuk Perkembangan Aplikasi StuntCare</p>
                    
                    <div class="relative mt-12">
                        <img src="{{ asset('images/dokterpesan.png') }}" alt="Dokter StuntCare" class="w-3/4 mx-auto">
                        <div class="absolute inset-0 bg-pink-200 rounded-full -z-10 transform translate-y-8 scale-90"></div>
                    </div>
                </div>
                
                <div class="md:w-1/2 md:pl-12">
                    <p class="text-gray-700 mb-6">Punya pertanyaan atau umpan balik? Berikan ke kami</p>
                    
                    <form class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-stunt">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-stunt">
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                            <input type="text" id="subject" name="subject" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-stunt">
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                            <textarea id="message" name="message" rows="6" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-stunt"></textarea>
                        </div>
                        
                        <div class="text-right">
                            <button type="submit" class="bg-pink-stunt hover:bg-pink-600 text-white font-medium px-8 py-3 rounded-lg transition duration-300">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-pink-stunt text-center mb-16">Pertanyaan yang sering ditanyakan?</h2>
            
            <div class="max-w-3xl mx-auto space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-pink-500 rounded-xl overflow-hidden">
                    <button class="flex justify-between items-center w-full text-left text-white px-6 py-4">
                        <span class="font-medium">Apakah aplikasi StuntCare gratis?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="hidden bg-white px-6 py-4">
                        <p class="text-gray-700">Ya, aplikasi StuntCare dapat digunakan secara gratis dengan fitur dasar. Untuk fitur premium, tersedia paket berlangganan dengan berbagai pilihan harga.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="bg-pink-500 rounded-xl overflow-hidden">
                    <button class="flex justify-between items-center w-full text-left text-white px-6 py-4">
                        <span class="font-medium">Apakah data anak saya aman di aplikasi ini?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="hidden bg-white px-6 py-4">
                        <p class="text-gray-700">Keamanan data anak Anda adalah prioritas utama kami. Semua data dienkripsi dan disimpan dengan aman sesuai standar keamanan internasional.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="bg-pink-500 rounded-xl overflow-hidden">
                    <button class="flex justify-between items-center w-full text-left text-white px-6 py-4">
                        <span class="font-medium">Bagaimana cara saya berkonsultasi dengan dokter?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="hidden bg-white px-6 py-4">
                        <p class="text-gray-700">Anda dapat berkonsultasi dengan dokter anak berpengalaman melalui fitur chat WhatsApp yang terintegrasi. Cukup klik tombol "Konsultasi Dokter" pada aplikasi.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="bg-pink-500 rounded-xl overflow-hidden">
                    <button class="flex justify-between items-center w-full text-left text-white px-6 py-4">
                        <span class="font-medium">Apakah data anak saya aman di aplikasi ini?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="hidden bg-white px-6 py-4">
                        <p class="text-gray-700">Keamanan data anak Anda adalah prioritas utama kami. Semua data dienkripsi dan disimpan dengan aman sesuai standar keamanan internasional.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 5 -->
                <div class="bg-pink-500 rounded-xl overflow-hidden">
                    <button class="flex justify-between items-center w-full text-left text-white px-6 py-4">
                        <span class="font-medium">Bagaimana cara saya berkonsultasi dengan dokter?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="hidden bg-white px-6 py-4">
                        <p class="text-gray-700">Anda dapat berkonsultasi dengan dokter anak berpengalaman melalui fitur chat WhatsApp yang terintegrasi. Cukup klik tombol "Konsultasi Dokter" pada aplikasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-pink-500 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <a href="#" class="flex items-center mb-4">
                        <div class="text-white mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                <circle cx="16" cy="6.5" r="1.5" fill="white"/>
                            </svg>
                        </div>
                        <span class="text-white font-bold text-lg">StuntCare</span>
                    </a>
                    <p class="text-white text-sm opacity-80">
                        Solusi Kami!
                    </p>
                    <div class="flex space-x-3 mt-4">
                        <a href="#" class="bg-white text-pink-500 p-2 rounded-full hover:bg-pink-100 transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-white text-pink-500 p-2 rounded-full hover:bg-pink-100 transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-white text-pink-500 p-2 rounded-full hover:bg-pink-100 transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                <div class="md:col-span-3 md:flex justify-between">
                    <div>
                        <h4 class="text-white font-semibold mb-4">Home</h4>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">About</h4>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Features</h4>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Contact</h4>
                    </div>
                </div>
            </div>
            
            <div class="text-center border-t border-pink-400 pt-8">
                <p class="text-sm opacity-80">
                    &copy; StuntCare. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Accordion Script for FAQ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const accordionButtons = document.querySelectorAll('.bg-pink-500 button');
            
            accordionButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const content = button.nextElementSibling;
                    
                    // Toggle current item
                    content.classList.toggle('hidden');
                    
                    // Change icon
                    const icon = button.querySelector('svg');
                    if (content.classList.contains('hidden')) {
                        icon.innerHTML = '<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />';
                    } else {
                        icon.innerHTML = '<path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />';
                    }
                });
            });
        });
    </script>
</body>
</html>