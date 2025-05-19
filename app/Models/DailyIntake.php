<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DailyIntake extends Model
{
    use HasFactory;

    protected $table = 'daily_intakes';
    protected $fillable = [
        'child_id',
        'food_id',
        'time_of_day',
        'portion',
        'date',
    ];

    public function child()
    {
        return $this->belongsTo(Children::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
