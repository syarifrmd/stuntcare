<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal Konsultasi - {{ Auth::user()->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'poppins': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
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
        .modal-body::-webkit-scrollbar { width: 8px; }
        .modal-body::-webkit-scrollbar-thumb { background-color: #f472b6; border-radius: 10px; }
        .modal-body::-webkit-scrollbar-track { background-color: #fce7f3; }
    </style>
</head>
<body class="bg-gradient-to-l from-pink-50 to-pink-400/30 text-gray-800">

    <header class="bg-pink-600 text-white text-center py-6 sm:py-8 shadow-lg flex ">
        <button onclick="window.history.back()" class=" relative text-gray-400 hover:text-gray-600 focus:outline-none pl-16">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
            </svg>
        </button>

      
        <div class="container mx-auto px-4">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold font-montserrat">Kelola Jadwal Konsultasi Anda</h1>
            <p class="mt-1 sm:mt-2 text-sm sm:text-base opacity-90">Lihat, tambah, edit, hapus, dan konfirmasi jadwal konsultasi.</p>
        </div>

       
       
    </header>

    <main class="container mx-auto py-8 px-4 sm:px-6 lg:px-8" x-data="dokterJadwalData()">
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

            <div class="mb-6 text-right">
                <button @click="initCreateModal()"
                   class="bg-pink-500 text-white px-5 py-2.5 sm:px-6 sm:py-3 rounded-lg font-medium hover:bg-pink-600 transition-colors duration-300 shadow hover:shadow-lg text-sm sm:text-base inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Tambah Jadwal Baru
                </button>
            </div>

            @php
                $allJadwals = isset($jadwals) ? collect($jadwals) : collect([]);
                if ($allJadwals->isEmpty() && app()->environment('local')) {
                    $authUserId = Auth::id();
                    $authUserNama = Auth::user()->name;
                    $allJadwals = collect([
                        (object)['id' => 1, 'dokter_id' => $authUserId, 'user_id' => 101, 'nama_dokter' => $authUserNama, 'no_wa_dokter' => '081234567890', 'waktu_konsultasi' => \Carbon\Carbon::now()->addDays(1)->setHour(10)->format('Y-m-d H:i:s'), 'status' => 'Memesan', 'user' => (object)['name' => 'User Pemesan 1', 'email' => 'user1@example.com']],
                        (object)['id' => 2, 'dokter_id' => $authUserId, 'user_id' => null, 'nama_dokter' => $authUserNama, 'no_wa_dokter' => '081234567891', 'waktu_konsultasi' => \Carbon\Carbon::now()->addDays(2)->setHour(14)->format('Y-m-d H:i:s'), 'status' => 'Tersedia', 'user' => null],
                        (object)['id' => 3, 'dokter_id' => $authUserId, 'user_id' => 102, 'nama_dokter' => $authUserNama, 'no_wa_dokter' => '081234567892', 'waktu_konsultasi' => \Carbon\Carbon::now()->addDays(3)->setHour(9)->format('Y-m-d H:i:s'), 'status' => 'Dipesan', 'user' => (object)['name' => 'User Pemesan 2', 'email' => 'user2@example.com']],
                        (object)['id' => 4, 'dokter_id' => $authUserId, 'user_id' => 103, 'nama_dokter' => $authUserNama, 'no_wa_dokter' => '081234567893', 'waktu_konsultasi' => \Carbon\Carbon::now()->subDays(1)->setHour(11)->format('Y-m-d H:i:s'), 'status' => 'Selesai', 'user' => (object)['name' => 'User Pemesan 3', 'email' => 'user3@example.com']],
                        (object)['id' => 5, 'dokter_id' => $authUserId, 'user_id' => null, 'nama_dokter' => $authUserNama, 'no_wa_dokter' => '081234567894', 'waktu_konsultasi' => \Carbon\Carbon::now()->addDays(1)->setHour(15)->format('Y-m-d H:i:s'), 'status' => 'Tidak Tersedia', 'user' => null],
                        (object)['id' => 6, 'dokter_id' => $authUserId, 'user_id' => 104, 'nama_dokter' => $authUserNama, 'no_wa_dokter' => '081234567895', 'waktu_konsultasi' => \Carbon\Carbon::now()->addDays(1)->setHour(16)->format('Y-m-d H:i:s'), 'status' => 'Dibatalkan', 'user' => (object)['name' => 'User Pemesan 4', 'email' => 'user4@example.com']],
                        (object)['id' => 7, 'dokter_id' => $authUserId, 'user_id' => null, 'nama_dokter' => $authUserNama, 'no_wa_dokter' => '081234567896', 'waktu_konsultasi' => \Carbon\Carbon::now()->subDays(2)->setHour(16)->format('Y-m-d H:i:s'), 'status' => 'Selesai', 'user' => null],
                    ]);
                }

                $jadwalsDipesan = $allJadwals->where('status', 'Dipesan')->sortBy('waktu_konsultasi');
                $jadwalsMemesan = $allJadwals->where('status', 'Memesan')->sortBy('waktu_konsultasi');
                $jadwalsTersedia = $allJadwals->where('status', 'Tersedia')->sortBy('waktu_konsultasi');
                $jadwalsLainnyaAktif = $allJadwals->whereIn('status', ['Tidak Tersedia', 'Dibatalkan'])->sortBy('waktu_konsultasi');
                $jadwalsSelesai = $allJadwals->where('status', 'Selesai')->sortByDesc('waktu_konsultasi');

                $activeJadwalsExist = $jadwalsDipesan->isNotEmpty() || $jadwalsMemesan->isNotEmpty() || $jadwalsTersedia->isNotEmpty() || $jadwalsLainnyaAktif->isNotEmpty();
            @endphp

            <h2 class="text-xl sm:text-2xl font-semibold text-pink-700 font-montserrat mb-4">Jadwal Aktif</h2>
            <div class="border border-pink-200/50 rounded-xl shadow-md overflow-x-auto">
                <table class="table-auto w-full min-w-[800px]">
                    <thead class="bg-pink-50">
                        <tr>
                            <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-pink-700 uppercase tracking-wider">Waktu Konsultasi</th>
                            <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-pink-700 uppercase tracking-wider">No. WA</th>
                            <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-pink-700 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-pink-700 uppercase tracking-wider">Dipesan Oleh</th>
                            <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-pink-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-pink-200/50">
                        @if($activeJadwalsExist)
                            @foreach($jadwalsDipesan as $jadwal)
                                {{-- Konten dari partial jadwal_row.blade.php --}}
                                <tr class="hover:bg-pink-50/50 transition-colors duration-150 text-sm">
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">
                                        {{ \Carbon\Carbon::parse($jadwal->waktu_konsultasi)->isoFormat('dddd, D MMM YYYY') }}<br>
                                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($jadwal->waktu_konsultasi)->isoFormat('HH:mm') }} WIB</span>
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">{{ $jadwal->no_wa_dokter }}</td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap">
                                        <span class="status-badge
                                            @if($jadwal->status == 'Tersedia') bg-green-100 text-green-800
                                            @elseif($jadwal->status == 'Memesan') bg-yellow-100 text-yellow-800
                                            @elseif($jadwal->status == 'Dipesan') bg-blue-100 text-blue-800
                                            @elseif($jadwal->status == 'Selesai') bg-gray-200 text-gray-700
                                            @elseif($jadwal->status == 'Dibatalkan') bg-purple-100 text-purple-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $jadwal->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">
                                        @if($jadwal->user_id && $jadwal->user)
                                            {{ $jadwal->user->name }} <br>
                                            <span class="text-xs text-gray-500">({{ $jadwal->user->email }})</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap font-medium">
                                        <div class="flex items-center space-x-2">
                                            @if(!isset($isHistory) || !$isHistory) {{-- Hanya tampilkan aksi jika bukan histori --}}
                                                @if($jadwal->status == 'Memesan')
                                                    <form action="{{ route('dokter.konsultasi.confirmPemesanan', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengkonfirmasi pemesanan ini?');">
                                                        @csrf
                                                        <button type="submit"
                                                                class="bg-green-500 text-white px-3 py-1.5 rounded-md hover:bg-green-600 transition-colors text-xs shadow focus:outline-none focus:ring-2 focus:ring-green-400"
                                                                title="Konfirmasi Pesanan">
                                                            Konfirmasi
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($jadwal->status != 'Selesai')
                                                <button @click="initEditModal({{ json_encode($jadwal) }})"
                                                   class="text-yellow-600 hover:text-yellow-800 transition-colors duration-150 p-1 rounded-md hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                                   title="Edit Jadwal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                                </button>
                                                @endif

                                                <form action="{{ route('dokter.konsultasi.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini? Ini tidak bisa dibatalkan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-800 transition-colors duration-150 p-1 rounded-md hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-400"
                                                            title="Hapus Jadwal">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs italic">Tidak ada aksi</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach($jadwalsMemesan as $jadwal)
                                 {{-- Konten dari partial jadwal_row.blade.php --}}
                                <tr class="hover:bg-pink-50/50 transition-colors duration-150 text-sm">
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">
                                        {{ \Carbon\Carbon::parse($jadwal->waktu_konsultasi)->isoFormat('dddd, D MMM YYYY') }}<br>
                                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($jadwal->waktu_konsultasi)->isoFormat('HH:mm') }} WIB</span>
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">{{ $jadwal->no_wa_dokter }}</td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap">
                                        <span class="status-badge
                                            @if($jadwal->status == 'Tersedia') bg-green-100 text-green-800
                                            @elseif($jadwal->status == 'Memesan') bg-yellow-100 text-yellow-800
                                            @elseif($jadwal->status == 'Dipesan') bg-blue-100 text-blue-800
                                            @elseif($jadwal->status == 'Selesai') bg-gray-200 text-gray-700
                                            @elseif($jadwal->status == 'Dibatalkan') bg-purple-100 text-purple-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $jadwal->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">
                                        @if($jadwal->user_id && $jadwal->user)
                                            {{ $jadwal->user->name }} <br>
                                            <span class="text-xs text-gray-500">({{ $jadwal->user->email }})</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap font-medium">
                                        <div class="flex items-center space-x-2">
                                            @if(!isset($isHistory) || !$isHistory) {{-- Hanya tampilkan aksi jika bukan histori --}}
                                                @if($jadwal->status == 'Memesan')
                                                    <form action="{{ route('dokter.konsultasi.confirmPemesanan', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengkonfirmasi pemesanan ini?');">
                                                        @csrf
                                                        <button type="submit"
                                                                class="bg-green-500 text-white px-3 py-1.5 rounded-md hover:bg-green-600 transition-colors text-xs shadow focus:outline-none focus:ring-2 focus:ring-green-400"
                                                                title="Konfirmasi Pesanan">
                                                            Konfirmasi
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($jadwal->status != 'Selesai')
                                                <button @click="initEditModal({{ json_encode($jadwal) }})"
                                                   class="text-yellow-600 hover:text-yellow-800 transition-colors duration-150 p-1 rounded-md hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                                   title="Edit Jadwal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                                </button>
                                                @endif

                                                <form action="{{ route('dokter.konsultasi.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini? Ini tidak bisa dibatalkan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-800 transition-colors duration-150 p-1 rounded-md hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-400"
                                                            title="Hapus Jadwal">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs italic">Tidak ada aksi</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach($jadwalsTersedia as $jadwal)
                                 {{-- Konten dari partial jadwal_row.blade.php --}}
                                <tr class="hover:bg-pink-50/50 transition-colors duration-150 text-sm">
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">
                                        {{ \Carbon\Carbon::parse($jadwal->waktu_konsultasi)->isoFormat('dddd, D MMM YYYY') }}<br>
                                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($jadwal->waktu_konsultasi)->isoFormat('HH:mm') }} WIB</span>
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">{{ $jadwal->no_wa_dokter }}</td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap">
                                        <span class="status-badge
                                            @if($jadwal->status == 'Tersedia') bg-green-100 text-green-800
                                            @elseif($jadwal->status == 'Memesan') bg-yellow-100 text-yellow-800
                                            @elseif($jadwal->status == 'Dipesan') bg-blue-100 text-blue-800
                                            @elseif($jadwal->status == 'Selesai') bg-gray-200 text-gray-700
                                            @elseif($jadwal->status == 'Dibatalkan') bg-purple-100 text-purple-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $jadwal->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">
                                        @if($jadwal->user_id && $jadwal->user)
                                            {{ $jadwal->user->name }} <br>
                                            <span class="text-xs text-gray-500">({{ $jadwal->user->email }})</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap font-medium">
                                        <div class="flex items-center space-x-2">
                                            @if(!isset($isHistory) || !$isHistory) {{-- Hanya tampilkan aksi jika bukan histori --}}
                                                @if($jadwal->status == 'Memesan')
                                                    <form action="{{ route('dokter.konsultasi.confirmPemesanan', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengkonfirmasi pemesanan ini?');">
                                                        @csrf
                                                        <button type="submit"
                                                                class="bg-green-500 text-white px-3 py-1.5 rounded-md hover:bg-green-600 transition-colors text-xs shadow focus:outline-none focus:ring-2 focus:ring-green-400"
                                                                title="Konfirmasi Pesanan">
                                                            Konfirmasi
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($jadwal->status != 'Selesai')
                                                <button @click="initEditModal({{ json_encode($jadwal) }})"
                                                   class="text-yellow-600 hover:text-yellow-800 transition-colors duration-150 p-1 rounded-md hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                                   title="Edit Jadwal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                                </button>
                                                @endif

                                                <form action="{{ route('dokter.konsultasi.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini? Ini tidak bisa dibatalkan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-800 transition-colors duration-150 p-1 rounded-md hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-400"
                                                            title="Hapus Jadwal">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs italic">Tidak ada aksi</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach($jadwalsLainnyaAktif as $jadwal)
                                 {{-- Konten dari partial jadwal_row.blade.php --}}
                                <tr class="hover:bg-pink-50/50 transition-colors duration-150 text-sm">
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">
                                        {{ \Carbon\Carbon::parse($jadwal->waktu_konsultasi)->isoFormat('dddd, D MMM YYYY') }}<br>
                                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($jadwal->waktu_konsultasi)->isoFormat('HH:mm') }} WIB</span>
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">{{ $jadwal->no_wa_dokter }}</td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap">
                                        <span class="status-badge
                                            @if($jadwal->status == 'Tersedia') bg-green-100 text-green-800
                                            @elseif($jadwal->status == 'Memesan') bg-yellow-100 text-yellow-800
                                            @elseif($jadwal->status == 'Dipesan') bg-blue-100 text-blue-800
                                            @elseif($jadwal->status == 'Selesai') bg-gray-200 text-gray-700
                                            @elseif($jadwal->status == 'Dibatalkan') bg-purple-100 text-purple-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $jadwal->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">
                                        @if($jadwal->user_id && $jadwal->user)
                                            {{ $jadwal->user->name }} <br>
                                            <span class="text-xs text-gray-500">({{ $jadwal->user->email }})</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap font-medium">
                                        <div class="flex items-center space-x-2">
                                            @if(!isset($isHistory) || !$isHistory) {{-- Hanya tampilkan aksi jika bukan histori --}}
                                                @if($jadwal->status == 'Memesan')
                                                    <form action="{{ route('dokter.konsultasi.confirmPemesanan', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengkonfirmasi pemesanan ini?');">
                                                        @csrf
                                                        <button type="submit"
                                                                class="bg-green-500 text-white px-3 py-1.5 rounded-md hover:bg-green-600 transition-colors text-xs shadow focus:outline-none focus:ring-2 focus:ring-green-400"
                                                                title="Konfirmasi Pesanan">
                                                            Konfirmasi
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($jadwal->status != 'Selesai')
                                                <button @click="initEditModal({{ json_encode($jadwal) }})"
                                                   class="text-yellow-600 hover:text-yellow-800 transition-colors duration-150 p-1 rounded-md hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                                   title="Edit Jadwal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                                </button>
                                                @endif

                                                <form action="{{ route('dokter.konsultasi.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini? Ini tidak bisa dibatalkan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-800 transition-colors duration-150 p-1 rounded-md hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-400"
                                                            title="Hapus Jadwal">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs italic">Tidak ada aksi</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 text-sm">
                                Anda belum memiliki jadwal aktif.
                                <button @click="initCreateModal()" class="text-pink-500 hover:underline font-semibold">Buat Jadwal Baru</button>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- Bagian Histori Jadwal Selesai --}}
            <div class="mt-12">
                <h2 class="text-xl sm:text-2xl font-semibold text-pink-700 font-montserrat mb-4">Histori Jadwal Selesai</h2>
                <div class="border border-gray-200 rounded-xl shadow-md overflow-x-auto">
                    <table class="table-auto w-full min-w-[800px]">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">Waktu Konsultasi</th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">No. WA</th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">Dipesan Oleh</th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($jadwalsSelesai as $jadwal)
                                {{-- Konten dari partial jadwal_row.blade.php (dengan $isHistory = true) --}}
                                <tr class="hover:bg-gray-50/50 transition-colors duration-150 text-sm">
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">
                                        {{ \Carbon\Carbon::parse($jadwal->waktu_konsultasi)->isoFormat('dddd, D MMM YYYY') }}<br>
                                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($jadwal->waktu_konsultasi)->isoFormat('HH:mm') }} WIB</span>
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">{{ $jadwal->no_wa_dokter }}</td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap">
                                        <span class="status-badge
                                            @if($jadwal->status == 'Tersedia') bg-green-100 text-green-800
                                            @elseif($jadwal->status == 'Memesan') bg-yellow-100 text-yellow-800
                                            @elseif($jadwal->status == 'Dipesan') bg-blue-100 text-blue-800
                                            @elseif($jadwal->status == 'Selesai') bg-gray-200 text-gray-700
                                            @elseif($jadwal->status == 'Dibatalkan') bg-purple-100 text-purple-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $jadwal->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap text-gray-700">
                                        @if($jadwal->user_id && $jadwal->user)
                                            {{ $jadwal->user->name }} <br>
                                            <span class="text-xs text-gray-500">({{ $jadwal->user->email }})</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 sm:px-6 sm:py-4 whitespace-nowrap font-medium">
                                        <div class="flex items-center space-x-2">
                                            {{-- Aksi untuk histori biasanya terbatas, contoh: lihat detail atau tidak ada aksi --}}
                                            <span class="text-gray-400 text-xs italic">Tidak ada aksi</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 text-sm">
                                    Tidak ada histori jadwal yang selesai.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal untuk Tambah Jadwal --}}
        <div x-show="openCreateModal" x-cloak
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4">
            <div @click.outside="openCreateModal = false" class="bg-white rounded-xl shadow-2xl w-full max-w-md md:max-w-lg transform transition-all">
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-pink-700 font-montserrat">Tambah Jadwal Baru</h2>
                    <button @click="openCreateModal = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <form action="{{ route('dokter.konsultasi.store') }}" method="POST" class="modal-body p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                    @csrf
                    <input type="hidden" name="form_type" value="create_jadwal">
                    <div>
                        <label for="create_no_wa_dokter" class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp Dokter</label>
                        <input type="tel" id="create_no_wa_dokter" name="no_wa_dokter" x-model="newJadwal.no_wa_dokter"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500 text-sm"
                               placeholder="cth: 081234567890" required>
                        @error('no_wa_dokter') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="create_waktu_konsultasi" class="block text-sm font-medium text-gray-700 mb-1">Waktu Konsultasi</label>
                        <input type="datetime-local" id="create_waktu_konsultasi" name="waktu_konsultasi" x-model="newJadwal.waktu_konsultasi"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500 text-sm" required>
                        @error('waktu_konsultasi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="create_status" class="block text-sm font-medium text-gray-700 mb-1">Status Awal</label>
                        <select id="create_status" name="status" x-model="newJadwal.status"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500 text-sm bg-white" required>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                        </select>
                        @error('status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="pt-2 text-right space-x-3">
                        <button type="button" @click="openCreateModal = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm font-medium">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors shadow hover:shadow-md text-sm font-medium">
                            Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal untuk Edit Jadwal --}}
        <div x-show="openEditModal" x-cloak
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4">
            <div @click.outside="openEditModal = false" class="bg-white rounded-xl shadow-2xl w-full max-w-md md:max-w-lg transform transition-all">
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-pink-700 font-montserrat">Edit Jadwal Konsultasi</h2>
                    <button @click="openEditModal = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <form :action="editJadwal.id ? `{{ url('dokter/konsultasi') }}/${editJadwal.id}` : '#'" method="POST" class="modal-body p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_type" value="edit_jadwal">
                    <input type="hidden" name="jadwal_id_edit" :value="editJadwal.id">

                    <div>
                        <label for="edit_no_wa_dokter" class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp Dokter</label>
                        <input type="tel" id="edit_no_wa_dokter" name="no_wa_dokter" x-model="editJadwal.no_wa_dokter"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500 text-sm"
                               placeholder="cth: 081234567890" required>
                        @error('no_wa_dokter') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="edit_waktu_konsultasi" class="block text-sm font-medium text-gray-700 mb-1">Waktu Konsultasi</label>
                        <input type="datetime-local" id="edit_waktu_konsultasi" name="waktu_konsultasi" x-model="editJadwal.waktu_konsultasi_formatted"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500 text-sm" required>
                        @error('waktu_konsultasi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="edit_status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="edit_status" name="status" x-model="editJadwal.status"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500 text-sm bg-white" required>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                            <option value="Dipesan" :disabled="!editJadwal.user_id">Dipesan (oleh user)</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                        @error('status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        <p x-show="editJadwal.status === 'Tersedia' && editJadwal.user_id" class="text-xs text-orange-600 mt-1">Mengubah status ke 'Tersedia' akan menghapus data pemesan.</p>
                    </div>
                    <div class="pt-2 text-right space-x-3">
                        <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors text-sm font-medium">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors shadow hover:shadow-md text-sm font-medium">
                            Update Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="bg-pink-600 text-white text-center py-6 mt-auto">
        <p class="text-sm opacity-90">&copy; {{ date('Y') }} StuntCare - Hak Cipta Dilindungi</p>
    </footer>

    <script>
    function dokterJadwalData() {
        return {
            openCreateModal: false,
            openEditModal: false,
            newJadwal: {
                no_wa_dokter: '{{ Auth::user()->telepon ?? "" }}',
                waktu_konsultasi: '',
                status: 'Tersedia'
            },
            editJadwal: {
                id: null,
                no_wa_dokter: '',
                waktu_konsultasi: '',
                waktu_konsultasi_formatted: '',
                status: '',
                user_id: null
            },
            initCreateModal() {
                this.newJadwal = {
                    no_wa_dokter: '{{ Auth::user()->telepon ?? "" }}',
                    waktu_konsultasi: '',
                    status: 'Tersedia'
                };
                this.openCreateModal = true;
            },
            initEditModal(jadwal) {
                this.editJadwal = JSON.parse(JSON.stringify(jadwal)); 
                this.editJadwal.waktu_konsultasi_formatted = ''; 
                if (this.editJadwal.waktu_konsultasi) {
                    let dateStr = this.editJadwal.waktu_konsultasi;
                    if (dateStr.includes(' ')) dateStr = dateStr.replace(' ', 'T');
                    if (dateStr.length > 16 && dateStr[16] === ':') { 
                        dateStr = dateStr.substring(0, 16);
                    }
                    
                    const date = new Date(dateStr);
                    if (!isNaN(date.getTime())) {
                        const year = date.getFullYear();
                        const month = ('0' + (date.getMonth() + 1)).slice(-2);
                        const day = ('0' + date.getDate()).slice(-2);
                        const hours = ('0' + date.getHours()).slice(-2);
                        const minutes = ('0' + date.getMinutes()).slice(-2);
                        this.editJadwal.waktu_konsultasi_formatted = `${year}-${month}-${day}T${hours}:${minutes}`;
                    } else {
                        if(dateStr.includes('T') && dateStr.length === 16){
                             this.editJadwal.waktu_konsultasi_formatted = dateStr;
                        } else {
                             console.warn("Gagal memformat tanggal untuk modal edit:", this.editJadwal.waktu_konsultasi);
                             this.editJadwal.waktu_konsultasi_formatted = '';
                        }
                    }
                }
                this.openEditModal = true;
            }
        };
    }

    document.addEventListener('DOMContentLoaded', () => {
        @if ($errors->any())
            const alpineDataElement = document.querySelector('[x-data="dokterJadwalData()"]');
            if (alpineDataElement && alpineDataElement.__x) {
                const alpineInstance = alpineDataElement.__x;
                @if (old('form_type') === 'create_jadwal' && ($errors->has('no_wa_dokter') || $errors->has('waktu_konsultasi') || $errors->has('status')))
                    alpineInstance.openCreateModal = true;
                    alpineInstance.newJadwal.no_wa_dokter = '{{ old('no_wa_dokter', Auth::user()->telepon ?? '') }}';
                    alpineInstance.newJadwal.waktu_konsultasi = '{{ old('waktu_konsultasi') }}';
                    alpineInstance.newJadwal.status = '{{ old('status', 'Tersedia') }}';
                @elseif (old('form_type') === 'edit_jadwal' && old('jadwal_id_edit') && ($errors->has('no_wa_dokter') || $errors->has('waktu_konsultasi') || $errors->has('status')))
                    let jadwalToReopen = @json($allJadwals->firstWhere('id', (int)old('jadwal_id_edit')) ?? null);
                    if (jadwalToReopen) {
                        jadwalToReopen.no_wa_dokter = '{{ old('no_wa_dokter') }}' || jadwalToReopen.no_wa_dokter;
                        jadwalToReopen.waktu_konsultasi = '{{ old('waktu_konsultasi') }}' || jadwalToReopen.waktu_konsultasi; 
                        jadwalToReopen.status = '{{ old('status') }}' || jadwalToReopen.status;
                        alpineInstance.initEditModal(jadwalToReopen);
                    }
                @endif
            }
        @endif
    });
    </script>
</body>
</html>