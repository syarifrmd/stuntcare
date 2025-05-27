<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Jadwal Konsultasi Dokter - StuntCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        main {
            flex-grow: 1;
        }
        .status-badge {
            padding: 0.25rem 0.75rem; /* py-1 px-3 */
            font-size: 0.75rem; /* text-xs */
            line-height: 1.25rem; /* leading-5 */
            font-weight: 600; /* font-semibold */
            border-radius: 9999px; /* rounded-full */
            display: inline-flex;
            align-items: center;
            text-transform: capitalize;
        }
        [x-cloak] { display: none !important; }
        input[type="date"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            opacity: 0.6;
        }
        input[type="date"]:hover::-webkit-calendar-picker-indicator {
            opacity: 1;
        }
    </style>
</head>

<body class="bg-gradient-to-l from-pink-50 to-pink-400/30 text-gray-800">
<x-app-layout>
    <div class="bg-white">
    <span name="header"></span>
        <div class="container mx-auto px-6 pt-8 pb-4">
            <h1 class=" text-pink-500 text-2xl sm:text-3xl lg:text-3xl font-bold font-montserrat">Jadwal Konsultasi Dokter</h1>
        </div>
    <main class="container mx-auto pb-8 px-4 sm:px-6 lg:px-8" x-data="jadwalPemesananData()">
        <div class="bg-white rounded-xl shadow-xl p-4 sm:p-6 md:p-8">

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md mb-6 text-sm sm:text-base" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md mb-6 text-sm sm:text-base" role="alert">
                    <p class="font-bold">Gagal!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            {{-- Fitur Pencarian dan Filter untuk Jadwal Aktif --}}
            <div class="mb-6 p-4 sm:p-6 bg-pink-50 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-pink-700 mb-3">Filter Jadwal Aktif</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                    <div>
                        <label for="searchDokterActive" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama Dokter</label>
                        <input type="text" id="searchDokterActive" x-model.debounce.300ms="filters.searchDokter" placeholder="Ketik nama dokter..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 text-sm">
                    </div>
                    <div>
                        <label for="filterTanggalActive" class="block text-sm font-medium text-gray-700 mb-1">Filter Tanggal</label>
                        <input type="date" id="filterTanggalActive" x-model="filters.selectedDate"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 text-sm">
                    </div>
                    <div>
                        <label for="filterHariActive" class="block text-sm font-medium text-gray-700 mb-1">Filter Hari</label>
                        <select id="filterHariActive" x-model="filters.selectedDay"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 text-sm bg-white">
                            <option value="">Semua Hari</option>
                            <option value="1">Senin</option>
                            <option value="2">Selasa</option>
                            <option value="3">Rabu</option>
                            <option value="4">Kamis</option>
                            <option value="5">Jumat</option>
                            <option value="6">Sabtu</option>
                            <option value="0">Minggu</option>
                        </select>
                    </div>
                    <div>
                        <label for="filterWaktuActive" class="block text-sm font-medium text-gray-700 mb-1">Filter Sesi Waktu</label>
                        <select id="filterWaktuActive" x-model="filters.selectedTimeSession"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 text-sm bg-white">
                            <option value="">Semua Sesi</option>
                            <option value="pagi">Pagi (07:00 - 11:59)</option>
                            <option value="siang">Siang (12:00 - 15:59)</option>
                            <option value="sore">Sore (16:00 - 18:59)</option>
                            <option value="malam">Malam (19:00 - 22:00)</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 text-right">
                    <button @click="resetFilters()" class="text-sm text-pink-600 hover:text-pink-800 hover:underline">
                        Reset Filter Aktif
                    </button>
                </div>
            </div>

            {{-- Tabel Jadwal Aktif --}}
            <div class="border border-pink-200/50 rounded-xl shadow-md overflow-x-auto">
                <table class="table-auto w-full min-w-[700px]">
                    <thead class="bg-pink-50">
                        <tr>
                            <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-pink-700 uppercase tracking-wider">Nama Dokter</th>
                            <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-pink-700 uppercase tracking-wider">No WA Dokter</th>
                            <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-pink-700 uppercase tracking-wider">Waktu Konsultasi</th>
                            <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-pink-700 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-pink-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-pink-200/50">
                        <template x-if="activeJadwals.length === 0">
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 text-sm">
                                    Tidak ada jadwal konsultasi aktif yang sesuai dengan filter Anda atau belum ada jadwal yang tersedia.
                                </td>
                            </tr>
                        </template>
                        <template x-for="jadwal in activeJadwals" :key="jadwal.id">
                            <tr class="hover:bg-pink-50/50 transition-colors duration-150 text-sm">
                                <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700" x-text="jadwal.nama_dokter"></td>
                                <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700" x-text="jadwal.no_wa_dokter"></td>
                                <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">
                                    <span x-text="formatTanggalWaktu(jadwal.waktu_konsultasi)"></span>
                                </td>
                                <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap">
                                    <span class="status-badge"
                                          :class="{
                                            'bg-green-100 text-green-800': jadwal.status == 'Tersedia',
                                            'bg-yellow-100 text-yellow-800': jadwal.status == 'Memesan',
                                            'bg-blue-100 text-blue-800': jadwal.status == 'Dipesan',
                                            'bg-purple-100 text-purple-800': jadwal.status == 'Dibatalkan',
                                            'bg-red-100 text-red-800': !['Tersedia', 'Memesan', 'Dipesan', 'Dibatalkan'].includes(jadwal.status) // Untuk 'Tidak Tersedia' dll
                                          }"
                                          x-text="jadwal.status">
                                    </span>
                                </td>
                                <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap font-medium">
                                    <template x-if="jadwal.status == 'Tersedia'">
                                        <form :action="`{{ url('konsultasidokter') }}/${jadwal.id}/book`" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memesan jadwal ini?');">
                                            @csrf
                                            <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition-colors text-xs sm:text-sm shadow hover:shadow-md">
                                                Pesan
                                            </button>
                                        </form>
                                    </template>
                                    <template x-if="jadwal.status == 'Memesan'">
                                        <span class="text-yellow-600" x-text="jadwal.user_id == {{ Auth::id() ?? 'null' }} ? 'Menunggu Konfirmasi Dokter' : 'Sedang diproses'"></span>
                                    </template>
                                    <template x-if="jadwal.status == 'Dipesan'">
                                        <span class="text-blue-600" x-text="jadwal.user_id == {{ Auth::id() ?? 'null' }} ? 'Jadwal Anda Dipesan' : 'Sudah Dipesan'"></span>
                                    </template>
                                    <template x-if="!['Tersedia', 'Memesan', 'Dipesan'].includes(jadwal.status)">
                                        <span class="text-gray-500 italic" x-text="jadwal.status"></span>
                                    </template>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            {{-- Tombol untuk Tampilkan/Sembunyikan Histori --}}
            <div class="mt-8 text-center">
                <button @click="toggleHistory()"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors duration-300 shadow hover:shadow-md text-sm sm:text-base">
                    <span x-text="showHistory ? 'Sembunyikan Riwayat Konsultasi' : 'Lihat Riwayat Konsultasi'"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block ml-2 transition-transform duration-300" :class="{'rotate-180': showHistory}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>

            {{-- Bagian Histori Jadwal Selesai --}}
            <div x-show="showHistory" x-cloak x-transition class="mt-8">
                <h3 class="text-xl sm:text-2xl font-semibold text-gray-700 font-montserrat mb-4">Histori Jadwal Konsultasi</h3>
                 {{-- Filter untuk Histori --}}
                <div class="mb-6 p-4 sm:p-6 bg-gray-100 rounded-lg shadow">
                    <h4 class="text-md font-semibold text-gray-600 mb-3">Filter Histori</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                        <div>
                            <label for="searchDokterHistory" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama Dokter</label>
                            <input type="text" id="searchDokterHistory" x-model.debounce.300ms="historyFilters.searchDokter" placeholder="Ketik nama dokter..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 text-sm">
                        </div>
                        <div>
                            <label for="filterTanggalHistory" class="block text-sm font-medium text-gray-700 mb-1">Filter Tanggal</label>
                            <input type="date" id="filterTanggalHistory" x-model="historyFilters.selectedDate"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 text-sm">
                        </div>
                        <div>
                            <label for="filterHariHistory" class="block text-sm font-medium text-gray-700 mb-1">Filter Hari</label>
                            <select id="filterHariHistory" x-model="historyFilters.selectedDay"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 text-sm bg-white">
                                <option value="">Semua Hari</option>
                                <option value="1">Senin</option>
                                <option value="2">Selasa</option>
                                <option value="3">Rabu</option>
                                <option value="4">Kamis</option>
                                <option value="5">Jumat</option>
                                <option value="6">Sabtu</option>
                                <option value="0">Minggu</option>
                            </select>
                        </div>
                        <div>
                            <label for="filterWaktuHistory" class="block text-sm font-medium text-gray-700 mb-1">Filter Sesi Waktu</label>
                            <select id="filterWaktuHistory" x-model="historyFilters.selectedTimeSession"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 text-sm bg-white">
                                <option value="">Semua Sesi</option>
                                <option value="pagi">Pagi (07:00 - 11:59)</option>
                                <option value="siang">Siang (12:00 - 15:59)</option>
                                <option value="sore">Sore (16:00 - 18:59)</option>
                                <option value="malam">Malam (19:00 - 22:00)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <button @click="resetHistoryFilters()" class="text-sm text-gray-600 hover:text-gray-800 hover:underline">
                            Reset Filter Histori
                        </button>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-xl shadow-md overflow-x-auto">
                    <table class="table-auto w-full min-w-[700px]">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">Nama Dokter</th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">No WA Dokter</th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">Waktu Konsultasi</th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <template x-if="filteredHistoryJadwals.length === 0">
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 text-sm">
                                        Tidak ada histori konsultasi yang sesuai dengan filter Anda atau belum ada histori.
                                    </td>
                                </tr>
                            </template>
                            <template x-for="jadwal in filteredHistoryJadwals" :key="jadwal.id">
                                <tr class="hover:bg-gray-50/50 transition-colors duration-150 text-sm">
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700" x-text="jadwal.nama_dokter"></td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700" x-text="jadwal.no_wa_dokter"></td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">
                                        <span x-text="formatTanggalWaktu(jadwal.waktu_konsultasi)"></span>
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap">
                                        <span class="status-badge bg-gray-200 text-gray-700" x-text="jadwal.status"></span>
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap font-medium">
                                        <span class="text-gray-400 italic text-xs">Tidak ada aksi</span>
                                        {{-- Atau tombol lihat detail jika ada:
                                        <button class="text-blue-500 hover:underline text-xs">Lihat Detail</button>
                                        --}}
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    </div>

</x-app-layout>

    <script>
    function jadwalPemesananData() {
        return {
            allJadwals: @json($jadwals ?? []),
            showHistory: false,
            filters: {
                searchDokter: '',
                selectedDate: '',
                selectedDay: '',
                selectedTimeSession: '',
            },
            historyFilters: {
                searchDokter: '',
                selectedDate: '',
                selectedDay: '',
                selectedTimeSession: '',
            },
            init() {
                if (this.allJadwals.length === 0 && '{{ app()->environment('local') }}') {
                    console.log("Menggunakan dummy data untuk jadwal pemesanan (user view).");
                    this.allJadwals = [
                        {id: 1, dokter_id: 101, user_id: null, nama_dokter: 'Dr. Budi Santoso', no_wa_dokter: '081234567890', waktu_konsultasi: '{{ \Carbon\Carbon::now()->addHours(2)->format('Y-m-d\TH:i') }}', status: 'Tersedia'},
                        {id: 2, dokter_id: 102, user_id: {{ Auth::id() ?? 999 }}, nama_dokter: 'Dr. Siti Aminah', no_wa_dokter: '089876543210', waktu_konsultasi: '{{ \Carbon\Carbon::now()->addDays(1)->setHour(14)->setMinute(30)->format('Y-m-d\TH:i') }}', status: 'Memesan'},
                        {id: 3, dokter_id: 103, user_id: 998, nama_dokter: 'Dr. Agus Wijaya', no_wa_dokter: '087654321098', waktu_konsultasi: '{{ \Carbon\Carbon::now()->addDays(1)->setHour(9)->setMinute(0)->format('Y-m-d\TH:i') }}', status: 'Dipesan'},
                        {id: 4, dokter_id: 101, user_id: 997, nama_dokter: 'Dr. Budi Santoso', no_wa_dokter: '081234567890', waktu_konsultasi: '{{ \Carbon\Carbon::now()->subDays(1)->setHour(11)->setMinute(0)->format('Y-m-d\TH:i') }}', status: 'Selesai'},
                        {id: 5, dokter_id: 102, user_id: null, nama_dokter: 'Dr. Siti Aminah', no_wa_dokter: '089876543210', waktu_konsultasi: '{{ \Carbon\Carbon::now()->addDays(2)->setHour(16)->setMinute(0)->format('Y-m-d\TH:i') }}', status: 'Tidak Tersedia'},
                        {id: 6, dokter_id: 104, user_id: null, nama_dokter: 'Dr. Candra Dewi', no_wa_dokter: '08111222333', waktu_konsultasi: '{{ \Carbon\Carbon::now()->addDays(3)->setHour(10)->setMinute(0)->format('Y-m-d\TH:i') }}', status: 'Tersedia'},
                        {id: 7, dokter_id: 105, user_id: null, nama_dokter: 'Dr. Budi Santoso', no_wa_dokter: '08222333444', waktu_konsultasi: '{{ \Carbon\Carbon::now()->addDays(1)->setHour(19)->setMinute(0)->format('Y-m-d\TH:i') }}', status: 'Tersedia'},
                        {id: 8, dokter_id: 102, user_id: {{ Auth::id() ?? 999 }}, nama_dokter: 'Dr. Siti Aminah', no_wa_dokter: '089876543210', waktu_konsultasi: '{{ \Carbon\Carbon::now()->subDays(2)->setHour(10)->setMinute(0)->format('Y-m-d\TH:i') }}', status: 'Selesai'},
                        {id: 9, dokter_id: 101, user_id: null, nama_dokter: 'Dr. Budi Santoso', no_wa_dokter: '081234567890', waktu_konsultasi: '{{ \Carbon\Carbon::now()->addDays(5)->setHour(11)->setMinute(0)->format('Y-m-d\TH:i') }}', status: 'Tersedia'},
                        {id: 10, dokter_id: 104, user_id: 1000, nama_dokter: 'Dr. Candra Dewi', no_wa_dokter: '08111222333', waktu_konsultasi: '{{ \Carbon\Carbon::now()->addDays(2)->setHour(17)->setMinute(0)->format('Y-m-d\TH:i') }}', status: 'Dipesan'},
                    ];
                }
            },
            get activeJadwals() {
                let jadwals = this.allJadwals.filter(j => j.status !== 'Selesai');
                const currentUser = {{ Auth::id() ?? 'null' }};

                if (this.filters.searchDokter.trim() !== '') {
                    jadwals = jadwals.filter(j =>
                        j.nama_dokter.toLowerCase().includes(this.filters.searchDokter.toLowerCase())
                    );
                }
                if (this.filters.selectedDate) {
                    jadwals = jadwals.filter(j => {
                        const jadwalDate = new Date(j.waktu_konsultasi).toISOString().split('T')[0];
                        return jadwalDate === this.filters.selectedDate;
                    });
                }
                if (this.filters.selectedDay !== '') {
                    jadwals = jadwals.filter(j => new Date(j.waktu_konsultasi).getDay() == this.filters.selectedDay);
                }
                if (this.filters.selectedTimeSession !== '') {
                    jadwals = jadwals.filter(j => {
                        const hour = new Date(j.waktu_konsultasi).getHours();
                        switch (this.filters.selectedTimeSession) {
                            case 'pagi': return hour >= 7 && hour < 12;
                            case 'siang': return hour >= 12 && hour < 16;
                            case 'sore': return hour >= 16 && hour < 19;
                            case 'malam': return hour >= 19 && hour < 23;
                            default: return true;
                        }
                    });
                }
                
                return jadwals.sort((a, b) => {
                    const getOrder = (item) => {
                        if (item.status === 'Memesan' && item.user_id === currentUser) return 1;
                        if (item.status === 'Dipesan' && item.user_id === currentUser) return 2;
                        if (item.status === 'Tersedia') return 3;
                        if (item.status === 'Memesan') return 4; 
                        if (item.status === 'Dipesan') return 5;  
                        return 6; // Tidak Tersedia, Dibatalkan
                    };
                    const aOrder = getOrder(a);
                    const bOrder = getOrder(b);
                    if (aOrder !== bOrder) return aOrder - bOrder;
                    return new Date(a.waktu_konsultasi) - new Date(b.waktu_konsultasi);
                });
            },
            get filteredHistoryJadwals() {
                if (!this.showHistory) return [];
                let jadwals = this.allJadwals.filter(j => j.status === 'Selesai');

                if (this.historyFilters.searchDokter.trim() !== '') {
                    jadwals = jadwals.filter(j =>
                        j.nama_dokter.toLowerCase().includes(this.historyFilters.searchDokter.toLowerCase())
                    );
                }
                if (this.historyFilters.selectedDate) {
                    jadwals = jadwals.filter(j => {
                        const jadwalDate = new Date(j.waktu_konsultasi).toISOString().split('T')[0];
                        return jadwalDate === this.historyFilters.selectedDate;
                    });
                }
                if (this.historyFilters.selectedDay !== '') {
                    jadwals = jadwals.filter(j => new Date(j.waktu_konsultasi).getDay() == this.historyFilters.selectedDay);
                }
                if (this.historyFilters.selectedTimeSession !== '') {
                    jadwals = jadwals.filter(j => {
                        const hour = new Date(j.waktu_konsultasi).getHours();
                        switch (this.historyFilters.selectedTimeSession) {
                            case 'pagi': return hour >= 7 && hour < 12;
                            case 'siang': return hour >= 12 && hour < 16;
                            case 'sore': return hour >= 16 && hour < 19;
                            case 'malam': return hour >= 19 && hour < 23;
                            default: return true;
                        }
                    });
                }
                return jadwals.sort((a, b) => new Date(b.waktu_konsultasi) - new Date(a.waktu_konsultasi));
            },
            resetFilters() {
                this.filters.searchDokter = '';
                this.filters.selectedDate = '';
                this.filters.selectedDay = '';
                this.filters.selectedTimeSession = '';
            },
            resetHistoryFilters() {
                this.historyFilters.searchDokter = '';
                this.historyFilters.selectedDate = '';
                this.historyFilters.selectedDay = '';
                this.historyFilters.selectedTimeSession = '';
            },
            toggleHistory() {
                this.showHistory = !this.showHistory;
            },
            formatTanggalWaktu(dateTimeString) {
                if (!dateTimeString) return '-';
                try {
                    const date = new Date(dateTimeString);
                    const optionsDate = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
                    const optionsTime = { hour: '2-digit', minute: '2-digit', hour12: false };
                    const formattedDate = date.toLocaleDateString('id-ID', optionsDate);
                    const formattedTime = date.toLocaleTimeString('id-ID', optionsTime).replace(/\./g,':');
                    return `${formattedDate}, ${formattedTime} WIB`;
                } catch (e) {
                    console.error("Error formatting date:", dateTimeString, e);
                    return dateTimeString; 
                }
            }
        };
    }
    </script>
</body>
</html>
