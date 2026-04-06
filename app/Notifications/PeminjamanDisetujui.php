<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PeminjamanDisetujui extends Notification
{
    protected $sewa;

    public function __construct($sewa)
    {
        $this->sewa = $sewa;
    }

    public function via($notifiable)
    {
        return ['database']; // simpan ke database
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Peminjaman kamu telah disetujui oleh petugas. Silakan datang untuk mengambil dan membawa dokumen yang telah kamu pilih.',
            'sewa_id' => $this->sewa->id
        ];
    }
}