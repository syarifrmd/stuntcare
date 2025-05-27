<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tambah Data Anak - StuntCare</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-white">
  <x-app-layout>
      <span name="header"></span>
      <div class="bg-white">
      <div class=" bg-white max-w-screen-xl mx-auto relative overflow-hidden py-10">
         <h2 class="text-2xl px-6 py-2 font-semibold text-pink-600 ">Data Anak Anda</h2>
      <div x-data="{ open: false }" class="px-6 py-2 "> <!-- Tombol buka modal --> <button @click="open = true" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600 transition"> + Tambah Data Anak </button>
      <!-- Modal -->
      <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
          <div @click.away="open = false" class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
              <h2 class="text-xl font-semibold text-pink-600 mb-4">Tambah Data Anak</h2>

              <form action="{{ route('children.store') }}" method="POST" class="space-y-4">
                  @csrf

                  <div>
                      <label for="name" class="block text-sm font-medium text-gray-700">Nama Anak</label>
                      <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                      @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                  </div>

                  <div>
                      <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                      <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                            class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                      @error('birth_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                  </div>

                  <div>
                      <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                      <select name="gender" id="gender" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                          <option value="">Pilih</option>
                          <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                          <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                      </select>
                      @error('gender') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                  </div>

                  <div class="flex justify-end gap-3 pt-4">
                      <button type="button" @click="open = false"
                              class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                          Batal
                      </button>
                      <button type="submit"
                              class="px-4 py-2 bg-pink-500 text-white rounded hover:bg-pink-600">
                          Simpan
                      </button>
                  </div>
              </form>
          </div>
      </div>
        
    </div>
      
      
    <div class="max-w-screen-xl mx-auto relative overflow-hidden py-5" >
    @if ($children->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 ">
            @foreach ($children as $child)
                <div x-data="{ openEdit{{ $child->id }}: false }" class="bg-pink-50 border border-pink-200 rounded-xl shadow-md p-6 m-4 hover:shadow-lg transition duration-300">
    
    <!-- Identitas Anak -->
    <div class="flex items-center gap-4 mb-3">
        <div class="w-12 h-12 bg-pink-200 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 10a4 4 0 100-8 4 4 0 000 8zM2 18a8 8 0 1116 0H2z" />
            </svg>
        </div>
        <div>
            <p class="text-base font-semibold text-rose-900">{{ $child->name }}</p>
            <p class="text-sm text-gray-600">{{ $child->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
        </div>
    </div>

    <!-- Tanggal Lahir -->
    <div class="text-sm text-gray-700 mb-4">
        <p><span class="font-medium">Tanggal Lahir:</span> {{ \Carbon\Carbon::parse($child->birth_date)->format('d M Y') }}</p>
    </div>

    <!-- Tombol Edit & Hapus -->
    <div class="flex gap-2 mb-4">
        <button @click="openEdit{{ $child->id }} = true"
            class="w-1/2 text-center  bg-transparent border-2 border-pink-500  text-black px-3 py-2 rounded-lg hover:bg-pink-200 transition">
            Edit
        </button>

        <form action="{{ route('children.destroy', ['child' => $child->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data anak ini?');" class="w-1/2">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="w-full text-center bg-pink-500 text-white px-3 py-2 rounded-lg hover:bg-pink-600 transition">
                Hapus
            </button>
        </form>
    </div>

    <!-- Tombol Input Makanan -->
    <a href="{{ route('pemantauan.index', ['child_id' => $child->id]) }}"
        class="block w-full text-center bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition">
        + Input Makanan
    </a>

    <!-- Modal Edit -->
    <div x-show="openEdit{{ $child->id }}" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="openEdit{{ $child->id }} = false" class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
            <h2 class="text-xl font-semibold text-pink-600 mb-4">Edit Data Anak</h2>

            <form action="{{ route('children.update', $child->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="name{{ $child->id }}" class="block text-sm font-medium text-gray-700">Nama Anak</label>
                    <input type="text" name="name" id="name{{ $child->id }}" value="{{ $child->name }}"
                        class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                </div>

                <div>
                    <label for="birth_date{{ $child->id }}" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="birth_date" id="birth_date{{ $child->id }}" value="{{ $child->birth_date }}"
                        class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                </div>

                <div>
                    <label for="gender{{ $child->id }}" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="gender" id="gender{{ $child->id }}" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                        <option value="">Pilih</option>
                        <option value="L" {{ $child->gender == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $child->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" @click="openEdit{{ $child->id }} = false"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-pink-500 text-white rounded hover:bg-pink-600">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

            @endforeach
        </div>
    @else
        <p class="mt-6 text-gray-500 text-center">Belum ada data anak.</p>
    @endif
</div>




  {{-- <div class="max-w-screen-xl mx-auto relative bg-white overflow-hidden py-10">
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
  </div> --}}

</div>
  </x-app-layout>
</body>
</html>
