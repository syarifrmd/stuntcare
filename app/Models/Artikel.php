<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikels';

    protected $fillable = [
        'title',
        'content',
        'topic',
        'author_id',
    ];

    /**
     * Relasi ke user (penulis artikel)
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
