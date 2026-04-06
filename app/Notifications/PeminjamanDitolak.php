<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class PeminjamanDitolak extends Notification
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
            'message' => 'Peminjaman PS ' . $this->sewa->playstation->nama . ' ditolak.',
            'sewa_id' => $this->sewa->id
        ];
    }
}