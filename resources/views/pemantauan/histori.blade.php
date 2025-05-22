<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Histori Pemantauan Gizi - StuntCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
<x-app-layout>
    <span name="header"></span>

    <div class="max-w-full px-6 md:px-20 mx-auto relative bg-white overflow-hidden py-10">
        <div class="text-pink-500 mb-4 font-semibold text-2xl text-center md:text-left">
            <h1>Kalender</h1>
        </div>    
        
        <!-- Pilihan Hari -->
        <div class="flex flex-wrap justify-between items-center mb-6">
            <div class="flex gap-4 md:gap-6 flex-wrap justify-center md:justify-start">
                <button id="monday" type="button" class="px-8 py-2 text-2xl no-underline hover:underline underline-offset-8 hover:text-pink-500 text-pink-700 mb-2 md:mb-0" onclick="filterByDay('Monday', this)">Senin</button>
                <button id="tuesday" type="button" class="px-8 py-2 text-2xl no-underline hover:underline underline-offset-8 hover:text-pink-500 text-pink-700 mb-2 md:mb-0" onclick="filterByDay('Tuesday', this)">Selasa</button>
                <button id="wednesday" type="button" class="px-8 py-2 text-2xl no-underline hover:underline underline-offset-8 hover:text-pink-500 text-pink-700 mb-2 md:mb-0" onclick="filterByDay('Wednesday', this)">Rabu</button>
                <button id="thursday" type="button" class="px-8 py-2 text-2xl no-underline hover:underline underline-offset-8 hover:text-pink-500 text-pink-700 mb-2 md:mb-0" onclick="filterByDay('Thursday', this)">Kamis</button>
                <button id="friday" type="button" class="px-8 py-2 text-2xl no-underline hover:underline underline-offset-8 hover:text-pink-500 text-pink-700 mb-2 md:mb-0" onclick="filterByDay('Friday', this)">Jumat</button>
                <button id="saturday" type="button" class="px-8 py-2 text-2xl no-underline hover:underline underline-offset-8 hover:text-pink-500 text-pink-700 mb-2 md:mb-0" onclick="filterByDay('Saturday', this)">Sabtu</button>
                <button id="sunday" type="button" class="px-8 py-2 text-2xl no-underline hover:underline underline-offset-8 hover:text-pink-500 text-pink-700 mb-2 md:mb-0" onclick="filterByDay('Sunday', this)">Minggu</button>
            </div>
            
            <input type="date" id="date" name="date" class="border px-4 py-2 rounded-full focus:outline-none focus:ring-2 focus:ring-pink-500 mt-4 md:mt-0" value="{{ $date }}" onchange="filterByDate()">
        </div>

        <!-- Statistik Harian & Rangkuman Makan -->
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Statistik Harian -->
            <div class="w-full bg-pink-50 rounded-2xl p-6 mb-6 md:mb-0">
                <h2 class="text-2xl md:text-3xl font-semibold text-pink-600">Statistik Harian Gizi</h2>
                @if($summary)
                    <div class="mt-6 space-y-6">
                        @foreach(['protein', 'carb', 'energy', 'fat'] as $nutrient)
                            <div class="flex items-center gap-4">
                                <span class="w-28 capitalize text-black">{{ ucfirst($nutrient) }}</span>
                                
                                <div class="relative w-full h-10 bg-gray-200 rounded-full">
                                    <!-- Bar Progress -->
                                    <div class="absolute max-w-full top-0 left-0 h-10 bg-pink-500 rounded-full" style="width: {{ $summary[$nutrient . '_percent'] ?? 0 }}%">
                                        <!-- Nutrient Value (in the middle) -->
                                        <span class="absolute inset-0 flex items-center justify-center text-white font-semibold">
                                            {{ number_format($summary[$nutrient . '_total'] ?? 0, 0) }}  <!-- Display total value here -->
                                        </span>
                                    </div>
                                </div>

                                <!-- Display the percentage on the right -->
                                <span class="text-black">{{ $summary[$nutrient . '_percent'] ?? 0 }}%</span>
                            </div>
                        @endforeach
                    </div>
                @else
                <div class="relative items-center content-center">
                    <div class="bg-pink-500 w-40 mx-auto rounded-2xl">
                        <img src="{{ asset('images/dokter.png') }}" alt="">
                    </div>    
                    <p class="mt-4 text-center text-pink-600">Belum ada data pemantauan hari ini.</p>

                </div>
                @endif
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
    </div>

    <script>
        function filterByDate() {
            var selectedDate = document.getElementById('date').value;
            
            if (selectedDate) {
                window.location.href = "{{ route('histori.index') }}" + "?date=" + selectedDate;
            }
        }
        // Function to update the URL with the selected day and reload
        function filterByDay(day) {
            window.location.search = "?day=" + day;
        }

        window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const activeDay = urlParams.get('day');

        // If there's a "day" query parameter, underline the corresponding button
        if (activeDay) {
            const activeButton = document.getElementById(activeDay.toLowerCase());
            if (activeButton) {
                activeButton.classList.add('underline', 'text-pink-500');  
                activeButton.classList.remove('no-underline','text-pink-700');
            }
        }
    }
    </script>

</x-app-layout>
</body>
</html>
