<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $artikel->title }} – Stunting Watch</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white font-['Poppins']">

    <!-- Navigation Bar (sama seperti index) -->
    <header class="w-full h-28 bg-white rounded-bl-[40px] rounded-br-[40px] shadow-[0px_10px_100px_-44px_rgba(0,0,0,1.00)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between mt-6">
            <div class="flex items-center">
                <img class="w-20 h-20" src="https://placehold.co/86x76" alt="Logo" />
            </div>
            <nav class="flex items-center space-x-8">
                <a href="/" class="text-black text-xl font-medium">Home</a>
                <a href="#" class="text-black text-xl font-medium">About</a>
                <a href="#" class="text-black text-xl font-medium">Feature</a>
                <a href="#" class="text-black text-xl font-medium">Contact</a>
                <a href="#" class="text-black text-xl font-medium">FAQ</a>
                <a href="#" class="text-black text-xl font-semibold">Sign In</a>
                <a href="#" class="bg-pink-500 text-white text-xl font-semibold px-4 py-1 rounded-[5px]">Register</a>
            </nav>
        </div>
    </header>

    <!-- Main Content Artikel Lengkap -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <h1 class="text-pink-500 text-4xl font-semibold mb-6">{{ $artikel->title }}</h1>

        <div class="prose prose-pink max-w-none text-rose-900">
            {!! $artikel->content !!}
        </div>

        <div class="mt-10">
            <a href="{{ route('artikel.index') }}" class="text-pink-500 hover:underline">&larr; Kembali ke daftar artikel</a>
        </div>

    </main>

</body>
</html>
