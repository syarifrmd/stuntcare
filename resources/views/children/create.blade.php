<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tambah Data Anak - StuntCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
  <x-app-layout>
      <span name="header"></span>


  <div class="max-w-screen-xl mx-auto relative bg-white overflow-hidden py-10">
    <!-- Main Content -->
    <div class="flex flex-col space-y-6 px-4 md:px-16">
      <h2 class="text-2xl md:text-3xl font-semibold text-pink-600">Tambah Data Anak</h2>
      <form action="{{ route('children.store') }}" method="POST" class="space-y-6 mt-6">
        @csrf
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nama Anak</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
          @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
          <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
          <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
          @error('birth_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
          <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
          <select id="gender" name="gender" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
          </select>
          @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
          <button type="submit" class="w-full bg-pink-500 text-white py-2 rounded">Simpan Data Anak</button>
        </div>
      </form>
    </div>
  </div>
  </x-app-layout>
</body>
</html>
