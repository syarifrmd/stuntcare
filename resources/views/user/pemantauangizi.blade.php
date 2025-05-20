<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pemantauan Gizi - StuntCare</title>

  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
    <x-app-layout>
        <span name="header"></span>
    </x-app-layout>
<div class="max-w-screen-xl mx-auto relative bg-white overflow-hidden">

  <!-- Main Content -->
  <div class="flex flex-col space-y-6 px-16">
    <!-- Statistics Section -->
    <div class="flex gap-6">
      <!-- Daily Statistics -->
      <div class="w-full h-auto md:w-2/3 bg-pink-50 rounded-2xl p-8">
        <h2 class="text-black text-4xl font-semibold font-['Poppins']">STATISTIK HARIAN</h2>
        
        <div class="mt-12 space-y-8">
          <!-- Protein Progress -->
          <div class="flex items-center gap-4">
            <span class="w-24 text-black text-base font-normal font-['Poppins']">Protein</span>
            <div class="relative w-full max-w-[528px] h-10 bg-zinc-300 rounded-full">
              <div class="absolute top-0 left-0 h-10 w-[88%] bg-rose-500 rounded-full"></div>
            </div>
            <span class="text-black text-base font-normal font-['Poppins']">91%</span>
          </div>
          
          <!-- Carbohydrate Progress -->
          <div class="flex items-center gap-4">
            <span class="w-24 text-black text-base font-normal font-['Poppins']">Karbohidrat</span>
            <div class="relative w-full max-w-[528px] h-10 bg-zinc-300 rounded-full">
              <div class="absolute top-0 left-0 h-10 w-[76%] bg-rose-300 rounded-full"></div>
            </div>
            <span class="text-black text-base font-normal font-['Poppins']">76%</span>
          </div>
          
          <!-- Energy Progress -->
          <div class="flex items-center gap-4">
            <span class="w-24 text-black text-base font-normal font-['Poppins']">Energi</span>
            <div class="relative w-full max-w-[528px] h-10 bg-zinc-300 rounded-full">
              <div class="absolute top-0 left-0 h-10 w-[84%] bg-slate-500 rounded-full"></div>
            </div>
            <span class="text-black text-base font-normal font-['Poppins']">84%</span>
          </div>
          
          <!-- Fat Progress -->
          <div class="flex items-center gap-4">
            <span class="w-24 text-black text-base font-normal font-['Poppins']">Lemak</span>
            <div class="relative w-full max-w-[528px] h-10 bg-zinc-300 rounded-full">
              <div class="absolute top-0 left-0 h-10 w-[64%] bg-sky-900 rounded-full"></div>
            </div>
            <span class="text-black text-base font-normal font-['Poppins']">64%</span>
          </div>
        </div>
      </div>
      
      <!-- Meal Summary -->
      <div class="w-full h-auto md:w-1/3  bg-pink-50 rounded-2xl p-6">
        <div class="space-y-4">
          <!-- Morning Meal -->
          <div class="w-full bg-white rounded-lg p-4">
            <div class="flex items-start gap-2">
              <div class="relative w-9 h-9">


              </div>
              <div>
                <h3 class="text-pink-500 text-base font-semibold font-['Poppins']">Pagi</h3>
                <p class="text-pink-500 text-xs font-normal font-['Poppins']">
                  Nasi putih (150 gr) – 210 kkal<br/>
                  Telur rebus (1 butir) – 77 kkal
                </p>
              </div>
            </div>
          </div>
          
          <!-- Afternoon Meal -->
          <div class="w-full bg-white rounded-lg p-4">
            <div class="flex items-start gap-2">
              <div class="relative w-8 h-8">

              </div>
              <div>
                <h3 class="text-pink-500 text-base font-semibold font-['Poppins']">Siang</h3>
                <p class="text-pink-500 text-xs font-normal font-['Poppins']">
                  Sayur bayam + nasi – 180 kkal<br/>
                  Tempe goreng – 90 kkal
                </p>
              </div>
            </div>
          </div>
          
          <!-- Evening Meal -->
          <div class="w-full bg-white rounded-lg p-4">
            <div class="flex items-start gap-2">
              <div class="relative w-9 h-9">

              </div>
              <div>
                <h3 class="text-pink-500 text-base font-semibold font-['Poppins']">Malam</h3>
                <p class="text-pink-500 text-xs font-normal font-['Poppins']">
                  Bubur ayam – 120 kkal<br/>
                  Susu UHT – 110 kkal
                </p>
              </div>
            </div>
          </div>
          
          <!-- Snack -->
          <div class="w-full bg-white rounded-lg p-4">
            <div class="flex items-start gap-2">
              <div class="relative w-9 h-9">

              </div>
              <div>
                <h3 class="text-pink-500 text-base font-semibold font-['Poppins']">Cemilan</h3>
                <p class="text-pink-500 text-xs font-normal font-['Poppins']">
                  Belum ditambahkan
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Add Food Button -->
    <div class="flex justify-center my-6">
      <button class="w-52 h-9 bg-pink-500 rounded text-white text-xs font-medium font-['Poppins']">
        Tambah Makanan
      </button>
    </div>
    
    <!-- Food List Section -->
    <div>
      <div class="flex items-center">
        <h2 class="text-pink-500 text-2xl font-semibold font-['Poppins']">Daftar Makanan</h2>
        <div class="w-36 h-0 ml-4 border-b-3 border-pink-500"></div>
      </div>
      
      <!-- Food Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mt-6">
        <!-- Food Card 1 -->
        <div class="w-44 h-56 bg-pink-50 rounded shadow-md p-2">
          <div class="w-40 h-24 bg-zinc-300 rounded mb-2">
            <img class="w-full h-full object-cover rounded" src="https://placehold.co/153x102" alt="Nasi" />
          </div>
          <h3 class="text-rose-900 text-[10px] font-medium font-['Poppins'] mb-1">Nasi - 100 gr</h3>
          
          <div class="flex justify-between text-rose-900 text-[10px] font-normal">
            <span>Energi</span>
            <span>±175 kkal</span>
          </div>
          
          <div class="flex justify-between items-center text-rose-900 text-[10px] font-normal">
            <span>Protein</span>
            <span>-</span>
          </div>
          
          <div class="flex justify-between text-rose-900 text-[10px] font-normal">
            <span>Lemak</span>
            <span>-</span>
          </div>
          
          <div class="flex justify-between text-rose-900 text-[10px] font-normal">
            <span>Karbohidrat</span>
            <span>±40 g</span>
          </div>
        </div>
        
        <!-- Food Card 2 -->
        <div class="w-44 h-56 bg-pink-50 rounded shadow-md p-2">
          <div class="w-40 h-24 bg-zinc-300 rounded mb-2">
            <img class="w-full h-full object-cover rounded" src="https://placehold.co/153x102" alt="Tempe Goreng" />
          </div>
          <h3 class="text-rose-900 text-[10px] font-medium font-['Poppins'] mb-1">Tempe Goreng - 50 gr</h3>
          
          <div class="flex justify-between text-rose-900 text-[10px] font-normal">
            <span>Energi</span>
            <span>±110 kkal</span>
          </div>
          
          <div class="flex justify-between items-center text-rose-900 text-[10px] font-normal">
            <span>Protein</span>
            <span>5 g</span>
          </div>
          
          <div class="flex justify-between text-rose-900 text-[10px] font-normal">
            <span>Lemak</span>
            <span>7 g</span>
          </div>
          
          <div class="flex justify-between text-rose-900 text-[10px] font-normal">
            <span>Karbohidrat</span>
            <span>±6 g</span>
          </div>
        </div>
        
        <!-- Food Card 3 -->
        <div class="w-44 h-56 bg-pink-50 rounded shadow-md p-2">
          <div class="w-40 h-24 bg-zinc-300 rounded mb-2">
            <img class="w-full h-full object-cover rounded" src="https://placehold.co/153x102" alt="Pisang Ambon" />
          </div>
          <h3 class="text-rose-900 text-[10px] font-medium font-['Poppins'] mb-1">Pisang Ambon - 75 gr</h3>
          
          <div class="flex justify-between text-rose-900 text-[10px] font-normal">
            <span>Energi</span>
            <span>±70 kkal</span>
          </div>
          
          <div class="flex justify-between items-center text-rose-900 text-[10px] font-normal">
            <span>Protein</span>
            <span>0,9 g</span>
          </div>
          
          <div class="flex justify-between text-rose-900 text-[10px] font-normal">
            <span>Lemak</span>
            <span>0,3 g</span>
          </div>
          
          <div class="flex justify-between text-rose-900 text-[10px] font-normal">
            <span>Karbohidrat</span>
            <span>±18 g</span>
          </div>
        </div>
        
        <!-- Food Card 4 -->
        <div class="w-44 h-56 bg-pink-50 rounded shadow-md p-2">
          <div class="w-40 h-24 bg-zinc-300 rounded mb-2">
            <img class="w-full h-full object-cover rounded" src="https://placehold.co/153x102" alt="Ayam Goreng Tepung" />
          </div>
          <h3 class="text-rose-900 text-[10px] font-medium font-['Poppins'] mb-1">Ayam Goreng Tepung - 40 gr</h3>
          
          <div class="flex justify-between text-rose-900 text-[10px] font-normal">
            <span>Energi</span>
            <span>±100 kkal</span>
          </div>
          
          <div class="flex justify-between items-center text-rose-900 text-[10px] font-normal">
            <span>Protein</span>
            <span>5 g</span>
          </div>
          
          <div class="flex justify-between text-rose-900 text-[10px] font-normal">
            <span>Lemak</span>
            <span>5 g</span>
          </div>
          
          <div class="flex justify-between text-rose-900 text-[10px] font-normal">
            <span>Karbohidrat</span>
            <span>±8 g</span>
          </div>
        </div>
        
        <!-- Food Card 5 -->
        <div class="w-44 h-56 bg-pink-50 rounded shadow-md p-2">
          <div class="w-40 h-24 bg-zinc-300 rounded mb-2">
            <img class="w-full h-full object-cover rounded" src="https://placehold.co/153x102" alt="Tahu Goreng" />
          </div>
          <h3 class="text-rose-900 text-[10px] font-medium font-['Poppins'] mb-1">Tahu Goreng - 100 gr</h3>
          
          <div class="flex justify-between text-rose-900 text-[10px] font-normal">
            <span>Energi</span>
            <span>±150 kkal</span>
          </div>
          
          <div class="flex justify-between items-center text-rose-900 text-[10px] font-normal">
            <span>Protein</span>
            <span>8 g</span>
          </div>
          
          <div class="flex justify-between text-rose-900 text-[10px] font-normal">
            <span>Lemak</span>
            <span>9 g</span>
          </div>
          
          <div class="flex justify-between text-rose-900 text-[10px] font-normal">
            <span>Karbohidrat</span>
            <span>±3 g</span>
          </div>
        </div>
      </div>
      
      <!-- See More Button -->
      <div class="flex justify-center items-center mt-6">
        <button class="w-7 h-7 bg-pink-500 rounded-full flex items-center justify-center">
          <div class="w-4 border-t-3 border-white"></div>
        </button>
        <span class="text-center text-rose-900 text-[10px] font-medium font-['Poppins'] ml-2">Lihat Lebih banyak</span>
      </div>
    </div>
  </div>
</div>
</body>
</html>
