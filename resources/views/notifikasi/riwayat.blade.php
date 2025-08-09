<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Notifikasi - StuntCare</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-pink-50 to-white min-h-screen">
    <!-- Header with Back Button -->
    <div class="bg-white shadow-sm border-b border-pink-100">
        <div class="max-w-4xl mx-auto px-4 py-4">
            <div class="flex items-center space-x-4">
                <button onclick="history.back()" class="flex items-center justify-center w-10 h-10 rounded-full bg-pink-50 hover:bg-pink-100 transition-colors duration-200 group">
                    <i class="fas fa-arrow-left text-pink-600 group-hover:text-pink-700"></i>
                </button>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-pink-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-bell text-white text-sm"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Riwayat Notifikasi</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 py-8">
        @if($notifikasis->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-bell-slash text-pink-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Notifikasi</h3>
                <p class="text-gray-500 max-w-md mx-auto">Notifikasi Anda akan muncul di sini ketika ada pembaruan atau pengingat dari StuntCare.</p>
            </div>
        @else
            <!-- Notifications List -->
            <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">
                <div class="divide-y divide-pink-50">
                    @foreach($notifikasis as $notif)
                        <div class="p-6 hover:bg-pink-25 transition-colors duration-200 {{ is_null($notif->read_at) ? 'bg-pink-25 border-l-4 border-l-pink-500' : '' }}">
                            <div class="flex items-start space-x-4">
                                <!-- Notification Icon -->
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center {{ is_null($notif->read_at) ? 'bg-pink-500 text-white' : 'bg-gray-100 text-gray-400' }}">
                                        @php
                                            $message = '';
                                            if (isset($notif->data['message'])) {
                                                if (is_array($notif->data['message'])) {
                                                    $message = implode(' ', $notif->data['message']);
                                                } else {
                                                    $message = $notif->data['message'];
                                                }
                                            }
                                        @endphp
                                        @if(str_contains(strtolower($message), 'makan'))
                                            <i class="fas fa-utensils text-lg"></i>
                                        @elseif(str_contains(strtolower($message), 'nutrisi'))
                                            <i class="fas fa-apple-alt text-lg"></i>
                                        @elseif(str_contains(strtolower($message), 'konsultasi'))
                                            <i class="fas fa-user-md text-lg"></i>
                                        @else
                                            <i class="fas fa-info text-lg"></i>
                                        @endif
                                    </div>
                                </div>

                                <!-- Notification Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900 leading-relaxed mb-2">
                                                @php
                                                    $displayMessage = 'Notifikasi';
                                                    if (isset($notif->data['message'])) {
                                                        if (is_array($notif->data['message'])) {
                                                            $displayMessage = implode(' ', $notif->data['message']);
                                                        } else {
                                                            $displayMessage = $notif->data['message'];
                                                        }
                                                    }
                                                @endphp
                                                {{ $displayMessage }}
                                            </p>
                                            <div class="flex items-center space-x-2 text-sm text-gray-500">
                                                <i class="fas fa-clock text-xs"></i>
                                                <span>{{ $notif->created_at->diffForHumans() }}</span>
                                                @if(is_null($notif->read_at))
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-700 ml-2">
                                                        <i class="fas fa-circle text-xs mr-1"></i>
                                                        Baru
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Mark as Read Button -->
                                        @if(is_null($notif->read_at))
                                            <a href="{{ route('notifikasi.read', $notif->id) }}" 
                                               class="ml-4 inline-flex items-center px-3 py-1.5 text-sm font-medium text-pink-600 bg-pink-50 rounded-lg hover:bg-pink-100 transition-colors duration-200">
                                                <i class="fas fa-check text-xs mr-2"></i>
                                                Tandai Dibaca
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Mark All as Read Button -->
            <div class="mt-8 flex justify-center ">
                <form method="POST" action="{{ route('notifikasi.readAll') }}">
                    @csrf
                    <div class="flex items-center justify-center bg-gradient-to-r from-pink-500 to-pink-600" >
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3  text-white font-medium rounded-xl hover:from-pink-600 hover:to-pink-700 focus:outline-none focus:ring-4 focus:ring-pink-200 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-check-double mr-2"></i>
                        Tandai Semua Dibaca
                    </button>
                    </div>
                    
                </form>
            </div>
        @endif
    </div>

    <!-- Footer Spacing -->
    <div class="h-8"></div>

    <style>
        .bg-pink-25 {
            background-color: #fdf2f8;
        }
        
        /* Custom hover effects */
        .hover\:bg-pink-25:hover {
            background-color: #fdf2f8;
        }
        
        /* Smooth animations */
        * {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>

    <!-- Include notification and service worker scripts -->
    @auth
        <x-notification-scripts />
    @endauth
</body>
</html>