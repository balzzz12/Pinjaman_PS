<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'playstation_id',
        'durasi',
        'dokumen',
        'aksi',
        'total_harga',
        'status',
        'booking_code',
        'waktu_mulai',

        // 🔥 PENGEMBALIAN
        'kondisi',
        'catatan_kembali',
        'foto_kembali',
        'waktu_kembali',
        'status_pengembalian',
        'denda'
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke playstation
    public function playstation()
    {
        return $this->belongsTo(PlayStation::class);
    }
}