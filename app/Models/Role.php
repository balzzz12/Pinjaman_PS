<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'ket'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'access_menus');
    }
}
