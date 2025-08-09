<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Konsultasi Dokter</title>
    @vite('resources/css/app.css') 
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="container mx-auto px-4 py-6">
        <a href="{{ route('konsultasi.index') }}" class="text-sm text-pink-600 hover:underline mb-4 inline-block">← Kembali ke daftar</a>

        <div class="bg-white shadow-md rounded-lg p-6 max-w-2xl mx-auto border border-gray-100">
            <h1 class="text-2xl font-bold text-pink-600 mb-4">Detail Konsultasi</h1>

            <div class="mb-4">
                <p class="text-gray-600 font-medium">Nama Dokter:</p>
                <p class="text-lg text-gray-800">{{ $konsultasi->nama_dokter }}</p>
            </div>

            <div class="mb-4">
                <p class="text-gray-600 font-medium">Status:</p>
                <p class="text-gray-700">{{ ucfirst($konsultasi->status) }}</p>
            </div>

            <div class="mb-4">
                <p class="text-gray-600 font-medium">Waktu Konsultasi:</p>
                <p class="text-gray-700">
                    {{ optional($konsultasi->waktu_konsultasi)->format('d M Y H:i') ?? '-' }}
                </p>
            </div>

            <div class="mb-4">
                <p class="text-gray-600 font-medium">Deskripsi / Catatan:</p>
                <p class="text-gray-700 whitespace-pre-line">
                    {{ $konsultasi->deskripsi ?? '-' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Include notification and service worker scripts -->
    @auth
        <x-notification-scripts />
    @endauth

</body>
</html>