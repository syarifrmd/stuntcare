<?php

namespace App\Console;

use Illuminate\Console\Command;
use App\Models\User;
use App\Events\MealReminderNotification;

class NotifyMealReminder extends Command
{
    protected $signature = 'notify:meal-reminder';
    protected $description = 'Kirim notifikasi pengingat makan ke semua user';

    public function handle()
    {
        $message = 'Waktunya makan! Jangan lupa makan sesuai jadwal ya.';
        foreach (User::all() as $user) {
            broadcast(new MealReminderNotification($user->id, $message));
        }
        $this->info('Notifikasi pengingat makan dikirim ke semua user.');
    }
} 