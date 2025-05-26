<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Konsultasi Dokter</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-pink-600 mb-6">Daftar Konsultasi Dokter</h1>

        @if ($konsultasi->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-md shadow-sm">
                <p class="font-bold">Belum Ada Konsultasi</p>
                <p>Data konsultasi dokter belum tersedia.</p>
            </div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($konsultasi as $k)
                <div class="bg-white shadow-md rounded-lg p-5 border border-gray-100 hover:shadow-lg transition">
                    <h2 class="text-lg font-semibold text-gray-800">{{ $k->nama_dokter }}</h2>

                    <p class="text-sm text-gray-500 mt-1">
                        <span class="font-medium">Status:</span> {{ ucfirst($k->status) }}
                    </p>

                    <p class="text-sm text-gray-500">
                        <span class="font-medium">Waktu:</span>
                        {{ optional($k->waktu_konsultasi)->format('d M Y H:i') ?? '-' }}
                    </p>

                    <div class="mt-4">
                        <a href="{{ route('konsultasi.show', $k) }}" 
                           class="text-pink-600 hover:underline text-sm font-medium">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $konsultasi->links() }}
            </div>
        @endif
    </div>

</body>
</html>
