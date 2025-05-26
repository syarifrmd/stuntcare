<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KonsultasiDokter extends Model
{
    use HasFactory;

    protected $table = 'konsultasi_dokters'; // pastikan sesuai dengan nama tabel di database

    protected $fillable = [
        'nama_dokter',
        'no_wa_dokter',
        'whatsapp_log',
        'waktu_konsultasi',
        'status',
        'catatan_user',
        'catatan_dokter',
    ];
}