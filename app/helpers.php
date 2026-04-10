<?php

use App\Models\LogAktivitas;

if (!function_exists('logAktivitas')) {
    function logAktivitas($aktivitas, $deskripsi = null)
    {
        if (auth()->check()) {
            $user = auth()->user();

            LogAktivitas::create([
                'user_id'   => $user->id,
                'role'      => optional($user->role)->name ?? 'user', // 🔥 aman
                'aktivitas' => $aktivitas,
                'deskripsi' => $deskripsi
            ]);
        }
    }
}