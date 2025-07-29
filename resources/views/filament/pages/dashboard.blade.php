<x-filament-panels::page>
    @php
        // Data untuk chart persentase pencapaian
        $persentaseData = \App\Models\DailyNutritionSummaries::select(
            DB::raw('AVG(energy_percent) as avg_energy'),
            DB::raw('AVG(protein_percent) as avg_protein'),
            DB::raw('AVG(fat_percent) as avg_fat'),
            DB::raw('AVG(carb_percent) as avg_carb')
        )->first();

        // Data untuk chart status nutrisi
        $totalRecords = \App\Models\DailyNutritionSummaries::count();

        $energyData = \App\Models\DailyNutritionSummaries::select(
            DB::raw('CASE 
                WHEN energy_percent >= 80 THEN "Baik"
                WHEN energy_percent >= 60 THEN "Cukup"
                ELSE "Kurang"
            END as status'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();

        $proteinData = \App\Models\DailyNutritionSummaries::select(
            DB::raw('CASE 
                WHEN protein_percent >= 80 THEN "Baik"
                WHEN protein_percent >= 60 THEN "Cukup"
                ELSE "Kurang"
            END as status'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();

        $fatData = \App\Models\DailyNutritionSummaries::select(
            DB::raw('CASE 
                WHEN fat_percent >= 80 THEN "Baik"
                WHEN fat_percent >= 60 THEN "Cukup"
                ELSE "Kurang"
            END as status'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();

        $carbData = \App\Models\DailyNutritionSummaries::select(
            DB::raw('CASE 
                WHEN carb_percent >= 80 THEN "Baik"
                WHEN carb_percent >= 60 THEN "Cukup"
                ELSE "Kurang"
            END as status'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();
    @endphp

    <div class="space-y-6">
        {{-- Stats Overview --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            {{-- Total Anak --}}
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-success-100">
                        <x-heroicon-m-users class="w-6 h-6 text-success-600" />
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold">{{ \App\Models\Children::count() }}</h2>
                        <p class="text-sm text-gray-600">Total Anak</p>
                    </div>
                </div>
            </div>

            {{-- Total User --}}
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-primary-100">
                        <x-heroicon-m-user-group class="w-6 h-6 text-primary-600" />
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold">{{ \App\Models\User::where('role', 'user')->count() }}</h2>
                        <p class="text-sm text-gray-600">Total User</p>
                    </div>
                </div>
            </div>

            {{-- Total Dokter --}}
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-info-100">
                        <x-heroicon-m-user class="w-6 h-6 text-info-600" />
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold">{{ \App\Models\User::where('role', 'dokter')->count() }}</h2>
                        <p class="text-sm text-gray-600">Total Dokter</p>
                    </div>
                </div>
            </div>

            {{-- Total Makanan --}}
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-warning-100">
                        <x-heroicon-m-cake class="w-6 h-6 text-warning-600" />
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold">{{ \App\Models\Food::count() }}</h2>
                        <p class="text-sm text-gray-600">Total Makanan</p>
                    </div>
                </div>
            </div>

            {{-- Total Artikel --}}
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100">
                        <x-heroicon-m-document-text class="w-6 h-6 text-purple-600" />
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold">{{ \App\Models\Artikel::count() }}</h2>
                        <p class="text-sm text-gray-600">Total Artikel</p>
                    </div>
                </div>
            </div>

            {{-- Jadwal Konsultasi Tersedia --}}
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-emerald-100">
                        <x-heroicon-m-calendar class="w-6 h-6 text-emerald-600" />
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold">{{ \App\Models\KonsultasiDokter::where('status', 'tersedia')->count() }}</h2>
                        <p class="text-sm text-gray-600">Jadwal Konsultasi Tersedia</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            {{-- Chart Status Nutrisi --}}
            <div class="p-6 bg-white rounded-lg shadow">
                <h3 class="text-lg font-medium">Status Nutrisi Anak</h3>
                <div class="mt-4" style="height: 300px;">
                    <canvas id="nutrisiChart"></canvas>
                </div>
            </div>

            {{-- Chart Persentase Nutrisi --}}
            <div class="p-6 bg-white rounded-lg shadow">
                <h3 class="text-lg font-medium">Persentase Pencapaian Nutrisi</h3>
                <div class="mt-4" style="height: 300px;">
                    <canvas id="persentaseChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data untuk chart status nutrisi
        const nutrisiData = {
            energy: @json($energyData),
            protein: @json($proteinData),
            fat: @json($fatData),
            carb: @json($carbData)
        };

        // Helper function untuk mendapatkan total berdasarkan status
        function getTotalByStatus(data, status) {
            return data[status] || 0;
        }

        // Chart Status Nutrisi
        new Chart(document.getElementById('nutrisiChart'), {
            type: 'bar',
            data: {
                labels: ['Energi', 'Protein', 'Lemak', 'Karbohidrat'],
                datasets: [
                    {
                        label: 'Baik',
                        data: [
                            getTotalByStatus(nutrisiData.energy, 'Baik'),
                            getTotalByStatus(nutrisiData.protein, 'Baik'),
                            getTotalByStatus(nutrisiData.fat, 'Baik'),
                            getTotalByStatus(nutrisiData.carb, 'Baik')
                        ],
                        backgroundColor: '#10B981'
                    },
                    {
                        label: 'Cukup',
                        data: [
                            getTotalByStatus(nutrisiData.energy, 'Cukup'),
                            getTotalByStatus(nutrisiData.protein, 'Cukup'),
                            getTotalByStatus(nutrisiData.fat, 'Cukup'),
                            getTotalByStatus(nutrisiData.carb, 'Cukup')
                        ],
                        backgroundColor: '#F59E0B'
                    },
                    {
                        label: 'Kurang',
                        data: [
                            getTotalByStatus(nutrisiData.energy, 'Kurang'),
                            getTotalByStatus(nutrisiData.protein, 'Kurang'),
                            getTotalByStatus(nutrisiData.fat, 'Kurang'),
                            getTotalByStatus(nutrisiData.carb, 'Kurang')
                        ],
                        backgroundColor: '#EF4444'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Anak'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw + ' anak';
                            }
                        }
                    }
                }
            }
        });

        // Chart Persentase Nutrisi
        new Chart(document.getElementById('persentaseChart'), {
            type: 'radar',
            data: {
                labels: ['Energi', 'Protein', 'Lemak', 'Karbohidrat'],
                datasets: [{
                    label: 'Persentase Pencapaian',
                    data: [
                        {{ $persentaseData->avg_energy ?? 0 }},
                        {{ $persentaseData->avg_protein ?? 0 }},
                        {{ $persentaseData->avg_fat ?? 0 }},
                        {{ $persentaseData->avg_carb ?? 0 }}
                    ],
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    borderColor: '#10B981',
                    pointBackgroundColor: '#10B981',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#10B981'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 20
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw.toFixed(2) + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-filament-panels::page> 