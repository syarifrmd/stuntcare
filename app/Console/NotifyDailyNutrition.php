<?php

namespace App\Console;

use Illuminate\Console\Command;
use App\Models\User;
use App\Events\DailyNutritionNotification;
use App\Models\DailyNutritionSummaries;
use Carbon\Carbon;

class NotifyDailyNutrition extends Command
{
    protected $signature = 'notify:daily-nutrition';
    protected $description = 'Kirim notifikasi gizi harian ke user yang belum memenuhi kebutuhan gizi';

    public function handle()
    {
        $today = Carbon::today();
        $message = 'Kebutuhan gizi harian Anda belum terpenuhi. Segera lengkapi asupan hari ini!';
        $users = User::all();
        foreach ($users as $user) {
            $summary = DailyNutritionSummaries::where('user_id', $user->id)
                ->whereDate('created_at', $today)
                ->first();
            if (!$summary || !$summary->is_fulfilled) {
                broadcast(new DailyNutritionNotification($user->id, $message));
            }
        }
        $this->info('Notifikasi gizi harian dikirim ke user yang belum terpenuhi.');
    }
} 