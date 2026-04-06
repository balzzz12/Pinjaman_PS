<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayStation extends Model
{
    protected $fillable = [
        'nama',
        'category_id',
        'harga',
        'stok',
        'status',
        'photo',
        'video',
        'deskripsi' // TAMBAHAN
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}