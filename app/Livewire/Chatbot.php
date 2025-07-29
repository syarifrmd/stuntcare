<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\GeminiService;

class Chatbot extends Component
{
    public $showModal = false;
    public $message = '';
    public $chat = [];
    public $isLoading = false;

    private $faq = [
        [
            'keywords' => ['siapa kamu' , 'anda siapa', 'kamu cowo atau cewe' , 'kamu siapa', 'namamu siapa', 'nama kamu siapa'],
            'answer' => 'Saya adalah <b>StuntBot</b>, chatbot yang dapat membantu Anda dalam mengatasi berbagai pertanyaan terkait StuntCare.'
        ],
        [
            'keywords' => ['apa itu stuntbot', 'tentang stuntbot', 'stuntbot itu apa'],
            'answer' => '<b>StuntBot</b> adalah chatbot yang dapat membantu Anda dalam mengatasi berbagai pertanyaan terkait StuntCare.'
        ],
        [
            'keywords' => ['apa itu stuntcare', 'tentang stuntcare', 'stuntcare itu apa'],
            'answer' => '<b>StuntCare</b> adalah aplikasi berbasis web yang dirancang untuk membantu orang tua memantau asupan gizi anak dan mendeteksi potensi kekurangan gizi yang bisa memicu stunting. Kami menyediakan informasi nutrisi, grafik pertumbuhan, dan berbagai fitur pendukung lainnya.'
        ],
        [
            'keywords' => ['fitur stuntcare', 'fitur utama', 'apa saja fitur'],
            'answer' => '<b>Fitur utama StuntCare:</b><ul><li>Pemantauan Gizi Anak</li><li>Informasi Nutrisi</li><li>Grafik Pertumbuhan & Statistik Gizi</li><li>Artikel Edukatif</li><li>Konsultasi Dokter</li></ul>'
        ],
        [
            'keywords' => ['cara daftar', 'cara registrasi', 'bagaimana daftar'],
            'answer' => 'Pengguna yang belum memiliki akun bisa melakukan registrasi melalui halaman yang telah disediakan. Anda akan diminta untuk mengisi email aktif dan data awal anak sebelum bisa mengakses fitur utama.'
        ],
        [
            'keywords' => ['akses seluler', 'bisa diakses hp', 'mobile', 'ponsel'],
            'answer' => 'Ya, StuntCare adalah aplikasi berbasis web yang dapat diakses dari berbagai perangkat, termasuk ponsel dan tablet.'
        ],
        [
            'keywords' => ['siapa yang bisa akses data', 'data anak', 'privasi'],
            'answer' => 'Data anak yang Anda inputkan hanya dapat diakses oleh Anda sebagai orang tua terdaftar. Admin hanya mengelola sistem, bukan data pribadi Anda.'
        ],
        [
            'keywords' => ['biaya', 'berbayar', 'langganan'],
            'answer' => 'Informasi biaya atau model berlangganan StuntCare akan dijelaskan saat registrasi atau pada tautan yang tersedia.'
        ],
        [
            'keywords' => ['bantuan', 'pertanyaan lain', 'support', 'kontak'],
            'answer' => 'Jika Anda punya pertanyaan lain atau butuh bantuan teknis, silakan hubungi tim support kami melalui menu bantuan di aplikasi.'
        ],
    ];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function mount()
    {
        $this->chat = session()->get('chatbot_chat', []);
    }

    public function sendMessage()
    {
        $userMessage = $this->message;
        $this->chat[] = ['sender' => 'user', 'text' => $userMessage];
        $this->message = '';

        // Cek FAQ
        $faqAnswer = $this->getFaqAnswer($userMessage);
        if ($faqAnswer) {
            $this->chat[] = ['sender' => 'ai', 'text' => $faqAnswer];
            session(['chatbot_chat' => $this->chat]);
            return;
        }

        $this->isLoading = true;
        $this->getAiReply(count($this->chat) - 1, $userMessage);
    }

    public function getListeners()
    {
        return array_merge(
            [
                'getAiReply' => 'getAiReply',
            ],
            parent::getListeners()
        );
    }

    public function getAiReply($index, $userMessage)
    {
        $gemini = new GeminiService();
        $aiReply = $gemini->ask($userMessage);
        $aiReply = $this->parseMarkdown($aiReply);
        $this->chat[] = ['sender' => 'ai', 'text' => $aiReply];
        $this->isLoading = false;
        session(['chatbot_chat' => $this->chat]);
        $this->dispatch('chatbot-scroll');
    }

    private function parseMarkdown($text)
    {
        // Bold **text** or __text__
        $text = preg_replace('/\*\*(.*?)\*\*/s', '<b>$1</b>', $text);
        $text = preg_replace('/__(.*?)__/s', '<b>$1</b>', $text);
        // Italic *text* or _text_
        $text = preg_replace('/\*(.*?)\*/s', '<i>$1</i>', $text);
        $text = preg_replace('/_(.*?)_/s', '<i>$1</i>', $text);
        // Line breaks
        $text = nl2br($text);
        // Capitalize sentences
        $text = preg_replace_callback('/([.!?]\s*)([a-z])/', function ($matches) {
            return $matches[1] . strtoupper($matches[2]);
        }, ucfirst($text));
        return $text;
    }

    private function getFaqAnswer($message)
    {
        $msg = strtolower($message);
        foreach ($this->faq as $faq) {
            foreach ($faq['keywords'] as $keyword) {
                if (str_contains($msg, $keyword)) {
                    return $faq['answer'];
                }
            }
        }
        return null;
    }

    public function render()
    {
        return view('livewire.chatbot');
    }
} 