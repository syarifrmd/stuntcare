<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pemantauan Gizi - StuntCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    .modal-backdrop {
      backdrop-filter: blur(4px);
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
  </style>
</head>
<body class="bg-white">

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
      <div class="w-full md:w-1/3 bg-pink-50 rounded-2xl p-6 mt-6 md:mt-0">
        <h3 class="text-xl font-semibold text-pink-500 mb-4">Rangkuman Makan Hari Ini</h3>
        @foreach(['Pagi', 'Siang', 'Malam', 'Cemilan'] as $waktu)
          <div class="bg-white rounded-lg p-4 mb-3">
            <div class="flex space-x-2 items-center">
              <!-- Icon berdasarkan waktu -->
              @if($waktu == 'Pagi')
                <i class="fa fa-sun text-pink-500"></i>
              @elseif($waktu == 'Siang')
                <i class="fa fa-sun text-yellow-500"></i>
              @elseif($waktu == 'Malam')
                <i class="fa fa-moon text-purple-500"></i>
              @elseif($waktu == 'Cemilan')
                <i class="fa fa-cookie-bite text-green-500"></i>
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
        <div x-data="{ showConfirmModal: false, selectedFoodId: null, selectedTime: 'Pagi' }">
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
            <!-- Delete -->
            <form action="{{ route('food.destroy', $food->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus makanan ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 hover:text-red-700 p-2 rounded-full bg-red-50 hover:bg-red-100 transition" title="Hapus">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 
                    0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                </svg>
              </button>
            </form>

            <!-- Tambah ke Menu -->
            <button
              @click="selectedFoodId = {{ $food->id }}; showConfirmModal = true"
              class="flex-1 bg-pink-500 text-white text-sm font-medium px-3 py-2 rounded-lg hover:bg-pink-600 transition-custom"
            >
              + Tambah ke Menu
            </button>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Modal Konfirmasi -->
  <div 
    x-show="showConfirmModal"
    x-transition
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-50 p-4"
    style="display: none;"
  >
    <div @click.away="showConfirmModal = false" class="bg-white rounded-xl shadow-lg w-full max-w-sm p-6">
      <h2 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Tambah Makanan</h2>
      <p class="text-sm text-gray-600 mb-4">Yakin ingin menambahkan makanan ini ke menu anak?</p>

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
            class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Batal</button>
          <button type="submit"
            class="px-4 py-2 bg-pink-500 text-white rounded hover:bg-pink-600">Ya, Tambahkan</button>
        </div>
      </form>
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

</x-app-layout>

<script>
let currentForm = null;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize event listeners
    initializeFormHandlers();
    initializeModalHandlers();
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

    cancelBtn.addEventListener('click', hideConfirmModal);
    
    confirmBtn.addEventListener('click', function() {
        if (currentForm) {
            submitForm();
        }
    });

    // Close modal when clicking backdrop
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            hideConfirmModal();
        }
    });
}

function showConfirmModal() {
    if (!currentForm) return;
    
    const foodName = currentForm.dataset.foodName;
    const timeOfDay = currentForm.querySelector('.time-select').value;
    const modal = document.getElementById('confirmModal');
    const modalContent = modal.querySelector('.modal-content');
    
    // Update modal content
    document.getElementById('modalFoodName').textContent = foodName;
    document.getElementById('modalTimeOfDay').textContent = timeOfDay;
    
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
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        hideConfirmModal();
        if (data.success) {
            showSuccessNotification();
            // Optionally update the page content or refresh
            location.reload();
        } else {
            alert('Terjadi kesalahan saat menambahkan makanan');
        }
    })
    .catch(error => {
        hideConfirmModal();
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menambahkan makanan');
    });
}

function resetConfirmButton() {
    const confirmBtn = document.getElementById('confirmBtn');
    const confirmText = confirmBtn.querySelector('.confirm-text');
    const loadingText = confirmBtn.querySelector('.loading-text');
    
    confirmText.classList.remove('hidden');
    loadingText.classList.add('hidden');
    confirmBtn.disabled = false;
}

function showSuccessNotification() {
    const notification = document.getElementById('successNotification');
    
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
    
    notification.classList.add('notification-exit');
    
    setTimeout(() => {
        notification.classList.add('hidden');
        notification.classList.remove('notification-exit');
    }, 500);
}
</script>
</body>
</html>
