<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - StuntCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-2xl w-full">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('dokter.dashboard') }}" class="text-pink-500 hover:text-pink-600">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                </a>
            </div>

            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <form action="{{ route('dokter.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Profile Image -->
                    <div class="flex flex-col items-center">
                        <div class="relative w-32 h-32 mb-4">
                            <div class="w-full h-full rounded-full overflow-hidden border-4 border-pink-500">
                                @if(Auth::user()->fotoprofil)
                                    <img src="{{ asset('storage/fotoprofil/' . Auth::user()->fotoprofil) }}" 
                                         alt="Foto Profil" 
                                         class="w-full h-full object-cover"
                                         id="preview-image">
                                @else
                                    <img src="https://avatar.iran.liara.run/username?username={{ urlencode(Auth::user()->name) }}" 
                                         alt="Default Avatar" 
                                         class="w-full h-full object-cover"
                                         id="preview-image">
                                @endif
                            </div>
                            <label for="fotoprofil" class="absolute bottom-0 right-0 bg-pink-500 text-white p-2 rounded-full cursor-pointer hover:bg-pink-600 transition-colors">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" 
                                   name="fotoprofil" 
                                   id="fotoprofil" 
                                   class="hidden" 
                                   accept="image/*"
                                   onchange="previewImage(this)">
                        </div>
                        <p class="text-sm text-gray-500">Klik ikon kamera untuk mengubah foto</p>
                    </div>

                    <!-- Form Fields -->
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ Auth::user()->name }}"
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                                   required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ Auth::user()->email }}"
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                                   required>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" 
                                   name="password" 
                                   id="password"
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation"
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="px-6 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html> 