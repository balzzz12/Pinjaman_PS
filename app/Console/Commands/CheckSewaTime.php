<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sewa;
use Carbon\Carbon;
use App\Notifications\SewaReminderNotification;

class CheckSewaTime extends Command
{
    protected $signature = 'sewa:check-time';
    protected $description = 'Cek waktu sewa dan kirim notifikasi';

    public function handle()
    {
        $sewas = Sewa::where('status', 'dipinjam')->get();

        foreach ($sewas as $sewa) {

            if (!$sewa->waktu_mulai) continue;

            $end = Carbon::parse($sewa->waktu_mulai)
                ->addMinutes($sewa->durasi);

            $now = now();

            // selisih menit (negatif = belum habis)
            $diff = $end->diffInMinutes($now, false);

            // ⏰ NOTIF 15 MENIT (sekali saja)
            if (!$sewa->notif_15_menit && $diff >= -15 && $diff <= -14) {

                $sewa->user->notify(
                    new SewaReminderNotification("Waktu sewa akan habis 15 menit lagi, segera dikembalikan!")
                );

                $sewa->notif_15_menit = true;
                $sewa->save();
            }

            // 🚨 NOTIF HABIS (sekali saja)
            if (!$sewa->notif_habis && $diff >= 0) {

                // masih dalam toleransi 2 jam
                if ($diff <= 120) {

                    $sewa->user->notify(
                        new SewaReminderNotification("Waktu sewa sudah habis! Segera kembalikan (toleransi 2 jam)")
                    );

                    $sewa->notif_habis = true;
                    $sewa->save();
                }
            }
        }
    }
}
