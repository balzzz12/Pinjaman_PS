<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PlayStation;

class Category extends Model
{
    protected $fillable = ['name'];

    // 🔥 TAMBAHKAN INI
    public function playstations()
    {
        return $this->hasMany(PlayStation::class);
    }
}