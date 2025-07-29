<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Events\MealReminderNotification;
use App\Notifications\MealReminderDb;

class NotifyMealReminder extends Command
{
    protected $signature = 'app:notify-meal-reminder';
    protected $description = 'Kirim notifikasi pengingat makan ke semua user';

    public function handle()
    {
        $message = 'Waktunya makan! Jangan lupa makan sesuai jadwal ya.';
        foreach (User::all() as $user) {
            broadcast(new MealReminderNotification($user->id, $message));
            $user->notify(new MealReminderDb($message));
        }
        $this->info('Notifikasi pengingat makan dikirim ke semua user.');
    }
}
