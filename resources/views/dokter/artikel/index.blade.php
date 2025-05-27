<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Artikel - Dokter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-50">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ tambahModal: false, editModal: false, currentArtikel: {} }">

    <h1 class="text-3xl font-bold text-pink-600 mb-8">Kelola Artikel Saya</h1>

    @if (session('success'))
        <div class="mb-6 p-4 rounded bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="mb-6 bg-white p-4 rounded shadow">
        <form action="{{ route('dokter.artikel.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <input type="text" name="search" placeholder="Cari judul atau topik..."
                   value="{{ request('search') }}"
                   class="border rounded p-2 flex-grow">
            <select name="status" class="border rounded p-2 w-full md:w-48">
                <option value="">Semua Status</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
            </select>
            <button type="submit"
                    class="px-6 py-2 bg-pink-500 text-white rounded hover:bg-pink-600 transition">
                Filter
            </button>
        </form>
    </div>

    <!-- Tombol Tambah Artikel -->
    <div class="mb-6">
        <button @click="tambahModal = true"
                class="px-6 py-2 bg-pink-500 text-white rounded hover:bg-pink-600 transition">
            + Tambah Artikel Baru
        </button>
    </div>

    <!-- Daftar Artikel -->
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm">
            <thead class="bg-pink-100">
            <tr>
                <th class="px-4 py-3 text-left">Judul</th>
                <th class="px-4 py-3 text-left">Topik</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">Dibuat</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($artikels as $artikel)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-4">{{ $artikel->title }}</td>
                    <td class="px-4 py-4">{{ $artikel->topic }}</td>
                    <td class="px-4 py-4">
                        <span class="inline-block px-2 py-1 text-xs rounded {{ $artikel->status === 'published' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                            {{ ucfirst($artikel->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-gray-600 text-xs">
                        {{ $artikel->created_at->format('d M Y') }}
                    </td>
                    <td class="px-4 py-4 flex gap-2">
                        <button @click="editModal = true; currentArtikel = {{ json_encode($artikel) }}"
                                class="text-blue-500 hover:text-blue-700">
                            Edit
                        </button>
                        <form action="{{ route('dokter.artikel.destroy', $artikel->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-500 hover:text-red-700"
                                    onclick="return confirm('Yakin hapus artikel ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada artikel.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $artikels->appends(Request::all())->links() }}
    </div>

    <!-- Modal Tambah Artikel -->
    <div x-show="tambahModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div @click.away="tambahModal = false" class="bg-white rounded-lg p-6 w-full max-w-lg">
            <h2 class="text-xl font-semibold mb-4 text-pink-500">Tambah Artikel Baru</h2>
            <form action="{{ route('dokter.artikel.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="text" name="title" placeholder="Judul" class="border rounded p-2 w-full" required>
                <input type="text" name="topic" placeholder="Topik" class="border rounded p-2 w-full" required>
                <select name="status" class="border rounded p-2 w-full">
                    <option value="draft">Draft</option>
                    <option value="published">Publish</option>
                </select>
                <textarea name="content" placeholder="Isi artikel..." class="border rounded p-2 w-full" rows="6" required></textarea>
                <input type="file" name="foto_artikel" class="border rounded p-2 w-full">
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="tambahModal = false"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-6 py-2 bg-pink-500 text-white rounded hover:bg-pink-600">
                        Simpan Artikel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Artikel -->
    <div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div @click.away="editModal = false" class="bg-white p-6 rounded shadow w-full max-w-lg">
            <h2 class="text-lg font-semibold mb-4 text-pink-500">Edit Artikel</h2>
            <form :action="`/dokter/artikel/${currentArtikel.id}`" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="text" name="title" class="w-full border rounded p-2 mb-2" :value="currentArtikel.title" required>
                <input type="text" name="topic" class="w-full border rounded p-2 mb-2" :value="currentArtikel.topic" required>
                <select name="status" class="w-full border rounded p-2 mb-2">
                    <option value="draft" :selected="currentArtikel.status === 'draft'">Draft</option>
                    <option value="published" :selected="currentArtikel.status === 'published'">Published</option>
                </select>
                <textarea name="content" class="w-full border rounded p-2 mb-2" required x-text="currentArtikel.content"></textarea>
                <input type="file" name="foto_artikel" class="w-full border rounded p-2 mb-2">
                <div class="flex justify-end space-x-2">
                    <button type="button" @click="editModal = false"
                            class="px-4 py-2 bg-gray-400 text-white rounded">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
</body>
</html>
