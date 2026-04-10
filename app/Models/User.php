<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Sewa;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'no_ktp',
        'hp',
        'alamat'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // =========================
    // RELASI ROLE
    // =========================
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // =========================
    // RELASI SEWA (PENTING 🔥)
    // =========================
    public function sewas()
    {
        return $this->hasMany(Sewa::class);
    }

    // =========================
    // CEK ROLE
    // =========================
    public function hasRole(string $roleName): bool
    {
        return $this->role?->name === $roleName;
    }

    // =========================
    // HELPER NOTIF (OPSIONAL)
    // =========================
    public function unreadNotifCount()
    {
        return $this->unreadNotifications->count();
    }
}
