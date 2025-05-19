<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Children extends Model
{
    use HasFactory;

    protected $table = 'children';

    protected $fillable = [
        'user_id',
        'name',
        'birth_date',
        'gender',
    ];

    /**
     * Relasi: Children milik satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * (Opsional) Format tanggal jika diperlukan.
     */
    protected $casts = [
        'birth_date' => 'date',
    ];
}
