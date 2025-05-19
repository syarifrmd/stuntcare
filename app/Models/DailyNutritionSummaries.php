<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyNutritionSummaries extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'date',
        'energy_total',
        'protein_total',
        'fat_total',
        'carb_total',
        'energy_percent',
        'protein_percent',
        'fat_percent',
        'carb_percent',
        'energy_status',
        'protein_status',
        'fat_status',
        'carb_status',
    ];

    public function child()
    {
        return $this->belongsTo(Children::class);
    }
}
