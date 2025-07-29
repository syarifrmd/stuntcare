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
        <div class="flex items-center text-pink-500 mb-4 font-semibold text-2xl text-center md:text-left">
            <a href="{{ route('pemantauan.index', ['child_id' => $child->id]) }}" class="p-2 flex items-center text-pink-500 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="36" fill="currentColor" class="bi bi-arrow-left mr-4" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg>
            </a>
            <h1>Kalender</h1>
        </div>    

        <!-- Filter Hari dan Tanggal -->
        <div class="flex flex-wrap justify-between items-center mb-6">
            <div class="flex gap-4 md:gap-6 flex-wrap justify-center md:justify-start">
                @foreach(['Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu','Sunday'=>'Minggu'] as $eng=>$ind)
                    <button id="{{ strtolower($eng) }}" type="button" 
                        class="px-8 py-2 text-2xl no-underline hover:underline underline-offset-8 hover:text-pink-500 text-pink-700 mb-2 md:mb-0" 
                        onclick="filterByDay('{{ $eng }}')">{{ $ind }}</button>
                @endforeach
            </div>

            <input type="date" id="date" name="date" class="border px-4 py-2 rounded-full focus:outline-none focus:ring-2 focus:ring-pink-500 mt-4 md:mt-0" 
                   value="{{ $date }}" onchange="filterByDate()">
        </div>

        <!-- Statistik Harian -->
        <div class="flex flex-col md:flex-row gap-6">
            <div class="w-full bg-pink-50 rounded-2xl p-6 mb-6 md:mb-0">
                <h2 class="text-2xl md:text-3xl font-semibold text-pink-600">Statistik Harian Gizi</h2>
                @if($summary)
                    <div class="mt-6 space-y-6">
                        @foreach(['protein','carb','energy','fat'] as $nutrient)
                            <div class="flex items-center gap-4">
                                <span class="w-28 capitalize text-black">{{ ucfirst($nutrient) }}</span>
                                <div class="relative w-full h-10 bg-gray-200 rounded-full">
                                    <div class="absolute max-w-full top-0 left-0 h-10 bg-pink-500 rounded-full" style="width: {{ $summary[$nutrient.'_percent'] ?? 0 }}%">
                                        <span class="absolute inset-0 flex items-center justify-center text-white font-semibold">
                                            {{ number_format($summary[$nutrient.'_total'] ?? 0, 0) }}
                                        </span>
                                    </div>
                                </div>
                                <span class="text-black">{{ $summary[$nutrient.'_percent'] ?? 0 }}%</span>
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
                @foreach(['Pagi','Siang','Malam','Cemilan'] as $waktu)
                    <div class="bg-white rounded-lg p-4 mb-3">
                        <h4 class="text-pink-500 font-semibold">{{ $waktu }}</h4>
                        <p class="text-xs text-pink-500 pl-2">
                            @php $data = $intakes->where('time_of_day',$waktu); @endphp
                            @forelse($data as $item)
                                {{ $item->food->name }} ({{ $item->portion }} porsi) - {{ $item->food->energy * $item->portion }} kkal<br>
                            @empty
                                Belum ditambahkan
                            @endforelse
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
function filterByDate() {
    const selectedDate = document.getElementById('date').value;
    if (selectedDate) {
        const childId = "{{ $child->id }}";
        const url = "{{ route('histori.index') }}" + "?child_id=" + childId + "&date=" + selectedDate;
        window.location.href = url;
    }
}
</script>

<script>
function filterByDay(day) {
    const dateInput = document.getElementById('date');
    const currentDate = dateInput && dateInput.value ? dateInput.value : new Date().toISOString().split('T')[0];
    const childId = "{{ $child->id }}";

    let url = "{{ route('histori.index') }}" + "?child_id=" + childId + "&day=" + day + "&date=" + currentDate;
    window.location.href = url;
}
</script>


<script>
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const activeDay = urlParams.get('day');

    // Tandai button active
    if (activeDay) {
        const activeButton = document.getElementById(activeDay.toLowerCase());
        if (activeButton) {
            activeButton.classList.add('underline', 'text-pink-500');
            activeButton.classList.remove('no-underline', 'text-pink-700');
        }
    }

};
</script>


</x-app-layout>
</body>
</html>
