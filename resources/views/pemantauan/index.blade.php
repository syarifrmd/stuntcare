<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pemantauan Gizi - StuntCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    [x-cloak] { display: none !important; }
    .modal-backdrop {
      backdrop-filter: blur(4px);
    }
    .modal-enter {
      animation: modalEnter 0.1s ease-out;
    }
    .modal-exit {
      animation: modalExit 0.1s ease-in;
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
    .notification-enter {
      animation: notificationEnter 0.5s ease-out;
    }
    .notification-exit {
      animation: notificationExit 0.5s ease-in;
    }
    @keyframes notificationEnter {
      from {
        opacity: 0;
        transform: translateX(100%);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }
    @keyframes notificationExit {
      from {
        opacity: 1;
        transform: translateX(0);
      }
      to {
        opacity: 0;
        transform: translateX(100%);
      }
    }
    .loading-spinner {
      animation: spin 1s linear infinite;
    }
    @keyframes spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    .transition-custom {
      transition: all 0.3s ease;
    }
  </style>
</head>
<body class="bg-white pb-20">

<x-app-layout>
<span name="header"></span>

<div class="max-w-7xl mx-auto relative bg-white overflow-hidden px-6 md:px-10 py-10">
    <div class="flex items-center text-pink-500 font-semibold text-2xl text-center md:text-left">
      <a href="{{ route('children.create') }}" class="p-2 items-center text-pink-500 rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="36" fill="currentColor" class="bi bi-arrow-left mr-4" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
        </svg>
      </a>
      <h1 class="font-semibold text-2xl">Pemantauan Gizi</h1>
    </div>

    <h2 class="text-2xl md:text-3xl font-semibold text-pink-600 mb-4 pt-10">{{ $child->name }} ({{ $ageInMonths }} bulan)</h2>

    <div class="flex flex-col md:flex-row md:space-x-6">
      <!-- Statistik Harian -->
      <div class="w-full md:w-2/3 bg-pink-50 rounded-2xl p-6">
        <h3 class="text-xl font-semibold mb-4">Statistik Harian Gizi</h3>
        @if($summary)
          <div class="space-y-4">
            @foreach(['protein', 'carb', 'energy', 'fat'] as $nutrient)
              <div class="flex items-center gap-4">
                <span class="w-28 capitalize">{{ ucfirst($nutrient) }}</span>
                <div class="relative w-full h-8 bg-gray-200 rounded-full">
                  <div class="absolute top-0 left-0 h-8 bg-pink-500 rounded-full max-w-full" style="width: {{ $summary[$nutrient . '_percent'] ?? 0 }}%"></div>
                </div>
                <span>{{ $summary[$nutrient . '_percent'] ?? 0 }}%</span>
              </div>
            @endforeach
          </div>
        @else
          <p class="text-gray-600">Belum ada data pemantauan hari ini.</p>
        @endif

        <!-- Tabel Kebutuhan -->
        <div class="mt-6">
          <h4 class="text-lg font-semibold mb-2">Kebutuhan Gizi</h4>
          @if($nutritionNeeds)
            <table class="min-w-full text-sm">
              <thead class="bg-pink-500 text-white">
                <tr>
                  <th class="px-4 py-2">Kategori</th>
                  <th class="px-4 py-2">Kebutuhan</th>
                </tr>
              </thead>
              <tbody>
                <tr class="bg-pink-100">
                  <td class="px-4 py-2">Energi</td>
                  <td class="px-4 py-2">{{ $nutritionNeeds->energy }} kcal</td>
                </tr>
                <tr class="bg-white">
                  <td class="px-4 py-2">Protein</td>
                  <td class="px-4 py-2">{{ $nutritionNeeds->protein }} g</td>
                </tr>
                <tr class="bg-pink-100">
                  <td class="px-4 py-2">Lemak</td>
                  <td class="px-4 py-2">{{ $nutritionNeeds->fat }} g</td>
                </tr>
                <tr class="bg-white">
                  <td class="px-4 py-2">Karbohidrat</td>
                  <td class="px-4 py-2">{{ $nutritionNeeds->carbohydrate }} g</td>
                </tr>
              </tbody>
            </table>
          @else
            <p class="text-gray-600">Tidak ada data kebutuhan gizi untuk usia ini.</p>
          @endif
        </div>
      </div>

            <!-- Rangkuman Makan -->
            <div class="w-full md:w-1/3 bg-pink-50 rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-pink-500 mb-4">Rangkuman Makan Hari Ini</h3>
                @foreach(['Pagi', 'Siang', 'Malam', 'Cemilan'] as $waktu)
                    <div class="bg-white rounded-lg p-4 mb-3">
                        <div class="flex space-x-2 items-center">
                            <!-- Icon berdasarkan waktu -->
                            @if($waktu == 'Pagi')
                                <svg class="text-pink-500 mt-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sunrise-fill" viewBox="0 0 16 16">
                                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l1.5 1.5a.5.5 0 0 1-.708.708L8.5 2.707V4.5a.5.5 0 0 1-1 0V2.707l-.646.647a.5.5 0 1 1-.708-.708zM2.343 4.343a.5.5 0 0 1 .707 0l1.414 1.414a.5.5 0 0 1-.707.707L2.343 5.05a.5.5 0 0 1 0-.707m11.314 0a.5.5 0 0 1 0 .707l-1.414 1.414a.5.5 0 1 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0M11.709 11.5a4 4 0 1 0-7.418 0H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1h-3.79zM0 10a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 10m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
                                </svg>
                            @elseif($waktu == 'Siang')
                                <svg class="text-pink-500 mt-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-sun-fill" viewBox="0 0 16 16">
                                    <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.414a.5.5 0 1 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0M11.709 11.5a4 4 0 1 0-7.418 0H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1h-3.79zM0 10a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 0 10m13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
                                </svg>
                            @elseif($waktu == 'Malam')
                                <svg class="text-pink-500 mt-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-moon-stars-fill" viewBox="0 0 16 16">
                                    <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278"/>
                                    <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.73 1.73 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.73 1.73 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.73 1.73 0 0 0 1.097-1.097zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/>
                                </svg>
                            @elseif($waktu == 'Cemilan')
                                <svg class="text-pink-500 mt-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cake2-fill" viewBox="0 0 16 16">
                                    <path d="m2.899.804.595-.792.598.79A.747.747 0 0 1 4 1.806v4.886q-.532-.09-1-.201V1.813a.747.747 0 0 1-.1-1.01ZM13 1.806v4.685a15 15 0 0 1-1 .201v-4.88a.747.747 0 0 1-.1-1.007l.595-.792.598.79A.746.746 0 0 1 13 1.806m-3 0a.746.746 0 0 0 .092-1.004l-.598-.79-.595.792A.747.747 0 0 0 9 1.813v5.17q.512-.02 1-.055zm-3 0v5.176q-.512-.018-1-.054V1.813a.747.747 0 0 1-.1-1.01l.595-.79.598.789A.747.747 0 0 1 7 1.806"/>
                                    <path d="M4.5 6.988V4.226a23 23 0 0 1 1-.114V7.16c0 .131.101.24.232.25l.231.017q.498.037 1.02.055l.258.01a.25.25 0 0 0 .26-.25V4.003a29 29 0 0 1 1 0V7.24a.25.25 0 0 0 .258.25l.259-.009q.52-.018 1.019-.055l.231-.017a.25.25 0 0 0 .232-.25V4.112q.518.047 1 .114v2.762a.25.25 0 0 0 .292.246l.291-.049q.547-.091 1.033-.208l.192-.046a.25.25 0 0 0 .192-.243V4.621c.672.184 1.251.409 1.677.678.415.261.823.655.823 1.2V13.5c0 .546-.408.94-.823 1.201-.44.278-1.043.51-1.745.696-1.41.376-3.33.603-5.432.603s-4.022-.227-5.432-.603c-.702-.187-1.305-.418-1.745-.696C.408 14.44 0 14.046 0 13.5v-7c0-.546.408-.94.823-1.201.426-.269 1.005-.494 1.677-.678v2.067c0 .116.08.216.192.243l.192.046q.486.116 1.033.208l.292.05a.25.25 0 0 0 .291-.247M1 8.82v1.659a1.935 1.935 0 0 0 2.298.43.935.935 0 0 1 1.08.175l.348.349a2 2 0 0 0 2.615.185l.059-.044a1 1 0 0 1 1.2 0l.06.044a2 2 0 0 0 2.613-.185l.348-.348a.94.94 0 0 1 1.082-.175c.781.39 1.718.208 2.297-.426V8.833l-.68.907a.94.94 0 0 1-1.17.276 1.94 1.94 0 0 0-2.236.363l-.348.348a1 1 0 0 1-1.307.092l-.06-.044a2 2 0 0 0-2.399 0l-.06.044a1 1 0 0 1-1.306-.092l-.35-.35a1.935 1.935 0 0 0-2.233-.362.935.935 0 0 1-1.168-.277z"/>
                                </svg>
                            @endif

                            <h4 class="text-pink-500 font-semibold">{{ $waktu }}</h4>
                        </div>
                        <div class="pl-9">
                            <p class="text-xs text-pink-500">
                                @foreach($intakes->where('time_of_day', $waktu) as $item)
                                    {{ $item->food->name }} ({{ $item->portion }} porsi) - {{ $item->food->energy * $item->portion }} kkal<br>
                                @endforeach
                                @if($intakes->where('time_of_day', $waktu)->count() == 0)
                                    Belum ditambahkan
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
    </div>

    <!-- Tombol Histori -->
    <div class="flex justify-center mt-6">
      <a href="{{ route('histori.index', ['child_id' => $child->id]) }}" class="px-6 py-2 bg-pink-500 text-white rounded mb-4">Lihat Histori</a>
    </div>

    <!-- Daftar Makanan -->
    <h2 class="text-pink-500 text-2xl font-semibold">Daftar Makanan</h2>
    <div x-data="{ 
      showConfirmModal: false, 
      selectedFoodId: null, 
      selectedTime: 'Pagi', 
      selectedFoodName: '', 
      showDeleteModal: false, 
      deleteFormAction: '',
      openAddModal(foodId, foodName) {
        console.log('Opening modal for:', foodName);
        this.selectedFoodId = foodId;
        this.selectedFoodName = foodName;
        this.showConfirmModal = true;
      },
      openDeleteModal(action) {
        console.log('Opening delete modal');
        this.deleteFormAction = action;
        this.showDeleteModal = true;
      }
    }">
      <!-- Food Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 mt-4">
        @foreach($foods as $food)
          <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden food-card transition-custom">
            <!-- Food Image -->
            <div class="w-full h-32 sm:h-40 overflow-hidden">
              @if ($food->foto)
                <img src="{{ asset('storage/' . $food->foto) }}" alt="{{ $food->name }}" class="w-full h-full object-cover">
              @else
                <div class="w-full h-full flex items-center justify-center bg-pink-200 text-pink-400 text-sm">
                  Tidak ada gambar
                </div>
              @endif
            </div>

            <!-- Food Info -->
            <div class="p-4">
              <h3 class="text-sm sm:text-base font-semibold text-rose-900 mb-1">{{ $food->name }}</h3>
              <p class="text-xs text-gray-600 mb-2">Kategori: {{ $food->category }}</p>
              <div class="grid grid-cols-2 gap-1 text-xs text-gray-600 mb-4">
                <div>Energi: {{ $food->energy }} kkal</div>
                <div>Protein: {{ $food->protein }} g</div>
                <div>Lemak: {{ $food->fat }} g</div>
                <div>Karbohidrat: {{ $food->carbohydrate }} g</div>
              </div>

              <!-- Buttons -->
              <div class="flex items-center gap-2">
                <!-- Delete Button -->
                <button 
                  @click="openDeleteModal('{{ route('food.destroy', $food->id) }}')"
                  class="text-red-500 hover:text-red-700 p-2 rounded-full bg-red-50 hover:bg-red-100 transition" 
                  title="Hapus"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 
                      0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                  </svg>
                </button>

                <!-- Tambah ke Menu -->
                <button
                  @click="openAddModal({{ $food->id }}, '{{ $food->name }}')"
                  class="flex-1 bg-pink-500 text-white text-sm font-medium px-3 py-2 rounded-lg hover:bg-pink-600 transition-custom"
                >
                  + Tambah ke Menu
                </button>
              </div>

              <!-- Hidden form for JavaScript compatibility -->
              <form class="food-form hidden" data-food-name="{{ $food->name }}" method="POST" action="{{ route('intakes.storeDirect') }}">
                @csrf
                <input type="hidden" name="food_id" value="{{ $food->id }}">
                <input type="hidden" name="child_id" value="{{ $child->id }}">
                <select name="time_of_day" class="time-select">
                  <option value="Pagi">Pagi</option>
                  <option value="Siang">Siang</option>
                  <option value="Malam">Malam</option>
                  <option value="Cemilan">Cemilan</option>
                </select>
              </form>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Modal Konfirmasi Tambah Makanan (Alpine.js) -->
      <div 
        x-show="showConfirmModal"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-50 p-4 modal-backdrop"
        @click="showConfirmModal = false"
      >
        <div @click.stop class="bg-white rounded-xl shadow-lg w-full max-w-sm p-6">
          <h2 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Tambah Makanan</h2>
          <p class="text-sm text-gray-600 mb-2">Yakin ingin menambahkan <strong x-text="selectedFoodName"></strong> ke menu anak?</p>
          <p class="text-xs text-gray-500 mb-4">Pilih waktu makan:</p>

          <form method="POST" action="{{ route('intakes.storeDirect') }}">
            @csrf
            <input type="hidden" name="food_id" :value="selectedFoodId">
            <input type="hidden" name="child_id" value="{{ $child->id }}">
            <select name="time_of_day" x-model="selectedTime"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
              <option value="Pagi">Pagi</option>
              <option value="Siang">Siang</option>
              <option value="Malam">Malam</option>
              <option value="Cemilan">Cemilan</option>
            </select>

            <div class="flex justify-end gap-3">
              <button type="button" @click="showConfirmModal = false"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Batal</button>
              <button type="submit"
                class="px-4 py-2 bg-pink-500 text-white rounded hover:bg-pink-600 transition">Ya, Tambahkan</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Modal Konfirmasi Hapus -->
      <div 
        x-show="showDeleteModal"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-50 p-4 modal-backdrop"
        @click="showDeleteModal = false"
      >
        <div @click.stop class="bg-white rounded-xl shadow-lg w-full max-w-sm p-6">
          <h2 class="text-lg font-semibold text-red-600 mb-2">Konfirmasi Hapus</h2>
          <p class="text-sm text-gray-600 mb-4">Yakin ingin menghapus makanan ini? Tindakan ini tidak dapat dibatalkan.</p>

          <form :action="deleteFormAction" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-3">
              <button type="button" @click="showDeleteModal = false"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Batal</button>
              <button type="submit"
                class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">Ya, Hapus</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Konfirmasi untuk JavaScript (fallback) -->
    <div id="confirmModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-50 p-4 modal-backdrop hidden">
      <div class="modal-content bg-white rounded-xl shadow-lg w-full max-w-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Tambah Makanan</h2>
        <p class="text-sm text-gray-600 mb-2">Yakin ingin menambahkan <strong id="modalFoodName"></strong> ke menu anak pada waktu <strong id="modalTimeOfDay"></strong>?</p>

        <div class="flex justify-end gap-3 mt-4">
          <button type="button" id="cancelBtn"
            class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Batal</button>
          <button type="button" id="confirmBtn"
            class="px-4 py-2 bg-pink-500 text-white rounded hover:bg-pink-600 transition">
            <span class="confirm-text">Ya, Tambahkan</span>
            <span class="loading-text hidden">
              <i class="fa fa-spinner loading-spinner mr-2"></i>
              Menambahkan...
            </span>
          </button>
        </div>
      </div>
    </div>

    <!-- Tombol Tambah Makanan -->
    <div class="flex justify-center mt-10">
      <a href="{{ route('food.index', ['child_id' => $child->id]) }}" class="px-6 py-2 bg-pink-500 text-white rounded">Tambah Makanan Lainnya</a>
    </div>
</div>

<!-- Notifikasi Berhasil -->
<div id="successNotification" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 hidden">
  <div class="flex items-center">
    <i class="fa fa-check-circle mr-2"></i>
    <span>Makanan berhasil ditambahkan!</span>
  </div>
</div>

<!-- Notifikasi Error -->
<div id="errorNotification" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 hidden">
  <div class="flex items-center">
    <i class="fa fa-exclamation-circle mr-2"></i>
    <span>Terjadi kesalahan saat memproses permintaan!</span>
  </div>
</div>

</x-app-layout>

<script>
let currentForm = null;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize event listeners
    initializeFormHandlers();
    initializeModalHandlers();
    
    // Show success message if exists
    @if(session('success'))
        showSuccessNotification('{{ session('success') }}');
    @endif
    
    // Show error message if exists
    @if(session('error') || $errors->any())
        showErrorNotification('{{ session('error') ?? $errors->first() }}');
    @endif
});

function initializeFormHandlers() {
    document.querySelectorAll('.add-food-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            currentForm = this.closest('.food-form');
            showConfirmModal();
        });
    });
}

function initializeModalHandlers() {
    const modal = document.getElementById('confirmModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const confirmBtn = document.getElementById('confirmBtn');

    if (cancelBtn) cancelBtn.addEventListener('click', hideConfirmModal);
    
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            if (currentForm) {
                submitForm();
            }
        });
    }

    // Close modal when clicking backdrop
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                hideConfirmModal();
            }
        });
    }
}

function showConfirmModal() {
    if (!currentForm) return;
    
    const foodName = currentForm.dataset.foodName;
    const timeOfDay = currentForm.querySelector('.time-select').value;
    const modal = document.getElementById('confirmModal');
    const modalContent = modal.querySelector('.modal-content');
    
    // Update modal content
    const modalFoodName = document.getElementById('modalFoodName');
    const modalTimeOfDay = document.getElementById('modalTimeOfDay');
    
    if (modalFoodName) modalFoodName.textContent = foodName;
    if (modalTimeOfDay) modalTimeOfDay.textContent = timeOfDay;
    
    // Show modal with animation
    modal.classList.remove('hidden');
    modalContent.classList.add('modal-enter');
    
    // Remove animation class after animation completes
    setTimeout(() => {
        modalContent.classList.remove('modal-enter');
    }, 300);
}

function hideConfirmModal() {
    const modal = document.getElementById('confirmModal');
    const modalContent = modal.querySelector('.modal-content');
    
    modalContent.classList.add('modal-exit');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modalContent.classList.remove('modal-exit');
        resetConfirmButton();
        currentForm = null;
    }, 300);
}

function submitForm() {
    if (!currentForm) return;
    
    const confirmBtn = document.getElementById('confirmBtn');
    const confirmText = confirmBtn.querySelector('.confirm-text');
    const loadingText = confirmBtn.querySelector('.loading-text');
    
    // Show loading state
    confirmText.classList.add('hidden');
    loadingText.classList.remove('hidden');
    confirmBtn.disabled = true;
    
    // Submit the form via AJAX
    const formData = new FormData(currentForm);
    
    fetch('{{ route("intakes.storeDirect") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        hideConfirmModal();
        if (data.success) {
            showSuccessNotification(data.message || 'Makanan berhasil ditambahkan!');
            // Optionally update the page content or refresh
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showErrorNotification(data.message || 'Terjadi kesalahan saat menambahkan makanan');
        }
    })
    .catch(error => {
        hideConfirmModal();
        console.error('Error:', error);
        showErrorNotification('Terjadi kesalahan saat menambahkan makanan');
    });
}

function resetConfirmButton() {
    const confirmBtn = document.getElementById('confirmBtn');
    if (!confirmBtn) return;
    
    const confirmText = confirmBtn.querySelector('.confirm-text');
    const loadingText = confirmBtn.querySelector('.loading-text');
    
    if (confirmText) confirmText.classList.remove('hidden');
    if (loadingText) loadingText.classList.add('hidden');
    confirmBtn.disabled = false;
}

function showSuccessNotification(message = 'Operasi berhasil!') {
    const notification = document.getElementById('successNotification');
    if (!notification) return;
    
    const messageSpan = notification.querySelector('span');
    if (messageSpan) messageSpan.textContent = message;
    
    notification.classList.remove('hidden');
    notification.classList.add('notification-enter');
    
    setTimeout(() => {
        notification.classList.remove('notification-enter');
    }, 500);
    
    // Auto hide after 3 seconds
    setTimeout(() => {
        hideSuccessNotification();
    }, 3000);
}

function hideSuccessNotification() {
    const notification = document.getElementById('successNotification');
    if (!notification) return;
    
    notification.classList.add('notification-exit');
    
    setTimeout(() => {
        notification.classList.add('hidden');
        notification.classList.remove('notification-exit');
    }, 500);
}

function showErrorNotification(message = 'Terjadi kesalahan!') {
    const notification = document.getElementById('errorNotification');
    if (!notification) return;
    
    const messageSpan = notification.querySelector('span');
    if (messageSpan) messageSpan.textContent = message;
    
    notification.classList.remove('hidden');
    notification.classList.add('notification-enter');
    
    setTimeout(() => {
        notification.classList.remove('notification-enter');
    }, 500);
    
    // Auto hide after 4 seconds
    setTimeout(() => {
        hideErrorNotification();
    }, 4000);
}

function hideErrorNotification() {
    const notification = document.getElementById('errorNotification');
    if (!notification) return;
    
    notification.classList.add('notification-exit');
    
    setTimeout(() => {
        notification.classList.add('hidden');
        notification.classList.remove('notification-exit');
    }, 500);
}
</script>

<!-- Include notification and service worker scripts -->
@auth
    <x-notification-scripts />
@endauth
</body>
</html>