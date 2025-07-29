<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Events\DailyNutritionNotification;
use App\Models\DailyNutritionSummaries;
use Carbon\Carbon;
use App\Notifications\DailyNutritionDb;

class NotifyDailyNutrition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-daily-nutrition';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi gizi harian ke user yang belum memenuhi kebutuhan gizi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $message = 'Kebutuhan gizi harian Anda belum terpenuhi. Segera lengkapi asupan hari ini!';
        $users = User::has('children')->get();
        foreach ($users as $user) {
            $children = $user->children ?? [];
            foreach ($children as $child) {
                $summary = DailyNutritionSummaries::where('child_id', $child->id)
                    ->whereDate('created_at', $today)
                    ->first();
                if (!$summary || !$summary->is_fulfilled) {
                    broadcast(new DailyNutritionNotification($user->id, $message));
                    $user->notify(new DailyNutritionDb($message));
                    break; // cukup satu notifikasi per user
                }
            }
        }
        $this->info('Notifikasi gizi harian dikirim ke user yang belum terpenuhi.');
    }
}
