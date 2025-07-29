<div>
    {{-- Tombol Aksi Terapung untuk membuka Chatbot --}}
    <button wire:click="openModal" class="bg-pink-500 hover:bg-pink-600 text-white rounded-full shadow-lg p-4 flex items-center justify-center fixed bottom-6 right-6 z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v8a2 2 0 01-2 2H7a2 2 0 01-2-2v-2m12-6V6a2 2 0 00-2-2H7a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2z" />
        </svg>
    </button>

    {{-- Modal Chatbot --}}
    @if($showModal)
        <div
            x-data
            x-init="
                $nextTick(() => {
                    var el = document.getElementById('chatbot-messages');
                    if (el) el.scrollTop = el.scrollHeight;
                });
            "
            class="fixed inset-0 flex items-center justify-center z-50"
            style="background: linear-gradient(135deg, rgba(236,72,153,0.25) 0%, rgba(255,255,255,0.7) 100%);"
        >
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md flex flex-col h-[80vh] border-2 border-pink-200">
                {{-- Header Chatbot --}}
                <div class="flex justify-between items-center p-4 border-b border-pink-100 bg-pink-50 rounded-t-2xl">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-full">
                            <img src="/images/logo.png" alt="StuntCare Logo" class="object-cover" />
                        </div>
                        <span class="text-lg font-bold text-pink-600">StuntBot</span>
                    </div>
                    <button wire:click="closeModal" class="text-pink-400 hover:text-pink-600 text-2xl font-bold">&times;</button>
                </div>

                {{-- Area Pesan --}}
                <div
                    id="chatbot-messages"
                    class="flex-1 p-4 overflow-y-auto flex flex-col gap-2 bg-pink-50"
                    x-data
                    x-on:chatbot-scroll.window="
                        $nextTick(() => {
                            var el = $el;
                            if (el) el.scrollTop = el.scrollHeight;
                        });
                    "
                >
                    {{-- Loop Pesan --}}
                    @foreach($chat as $item)
                        <div class="flex {{ $item['sender'] === 'user' ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[80%] px-4 py-2 rounded-2xl shadow {{ $item['sender'] === 'user' ? 'bg-pink-500 text-white rounded-br-none' : 'bg-white text-gray-800 rounded-bl-none border border-pink-200' }}">
                                @if($item['sender'] === 'user')
                                    <span class="text-xs font-semibold block mb-1 text-right">Anda</span>
                                    <span>{{ $item['text'] }}</span>
                                @else
                                    <span class="text-xs font-semibold block mb-1 text-left text-pink-600">StuntBot</span>
                                    <span>{!! $item['text'] !!}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                    {{-- Indikator Mengetik --}}
                    <div wire:loading wire:target="sendMessage" class="flex justify-start">
                        <div class="max-w-[80%] px-4 py-2 rounded-2xl shadow bg-white text-gray-800 rounded-bl-none border border-pink-200">
                            <div class="flex items-center">
                                <span class="text-xs font-semibold block mb-1 text-left text-pink-600">StuntBot</span>
                            </div>
                            <div class="flex items-center mt-1">
                                <svg class="animate-spin h-5 w-5 text-pink-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V8h8a8 8 0 01-16 0z"></path>
                                </svg>
                                <span class="ml-2 text-sm text-gray-600">Mengetik...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tanya Cepat -->
                <div class="p-3 border-t border-pink-100 bg-white" x-data="{ isQuickQuestionsOpen: false }">
                    {{-- Trigger untuk Buka/Tutup --}}
                    <div @click="isQuickQuestionsOpen = !isQuickQuestionsOpen" class="flex justify-between items-center cursor-pointer select-none">
                        <p class="text-sm font-medium text-pink-600">Pilih Pertanyaan Cepat</p>
                        <div>
                            {{-- Ikon Panah ke Bawah (Tampil saat tertutup) --}}
                            <svg x-show="!isQuickQuestionsOpen" class="w-5 h-5 text-pink-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            </svg>
                            {{-- Ikon Panah ke Atas (Tampil saat terbuka) --}}
                            <svg x-show="isQuickQuestionsOpen" style="display: none;" class="w-5 h-5 text-pink-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                    
                    {{-- Konten yang bisa disembunyikan --}}
                    <div x-show="isQuickQuestionsOpen" x-transition class="mt-3">
                        <div class="flex flex-wrap justify-center gap-2">
                            @php
                                $quickQuestions = [
                                    'Apa itu StuntCare?',
                                    'Fitur utama apa saja yang ada di StuntCare',
                                    'Bagaimana cara memulai menggunakan StuntCare?',
                                    'Apakah StuntCare bisa diakses melalui perangkat seluler?',
                                    'Siapa yang dapat mengakses data anak saya?',
                                    'Apakah ada biaya untuk menggunakan StuntCare?',
                                ];
                            @endphp
                            @foreach($quickQuestions as $question)
                                <button
                                    x-on:click="
                                        $wire.set('message', '{{ addslashes($question) }}');
                                        $wire.sendMessage();
                                    "
                                    class="bg-pink-100 text-pink-700 text-sm px-3 py-1 rounded-full hover:bg-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-300 transition-colors disabled:opacity-50"
                                    :disabled="@js($isLoading)">
                                    {{ $question }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Formulir Input Pesan --}}
                <form x-data="{ msg: '' }"
                    @submit.prevent="
                        if (msg.trim() === '') return;
                        $wire.set('message', msg);
                        msg = '';
                        $wire.sendMessage();
                    "
                    class="flex items-center p-4 border-t gap-2 bg-white rounded-b-2xl"
                >
                    <input type="text" x-model="msg" class="flex-1 border border-pink-200 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-300" placeholder="Ketik pesan..." autocomplete="off" :disabled="@js($isLoading)" />
                    <button type="submit" class="bg-pink-500 text-white p-2.5 rounded-full hover:bg-pink-600 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 disabled:opacity-50" :disabled="@js($isLoading)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>