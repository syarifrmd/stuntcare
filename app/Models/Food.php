<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'name',
        'category',
        'energy',
        'protein',
        'fat',
        'carbohydrate',
        'created_by',
        'foto',
    ];

    /**
     * Relasi: makanan ini ditambahkan oleh user tertentu (admin/user).
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
