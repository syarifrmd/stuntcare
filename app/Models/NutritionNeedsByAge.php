<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NutritionNeedsByAge extends Model
{
    protected $table = 'nutrition_needs_by_ages';

    protected $fillable = [
        'age_range',
        'energy',
        'protein',
        'fat',
        'carbohydrate',
    ];
}
