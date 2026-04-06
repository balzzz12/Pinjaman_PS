<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SewaReminderNotification extends Notification
{
    use Queueable;

    protected $message;

    /**
     * Kirim pesan dinamis
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Kirim ke database + email (opsional)
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail']; // bisa hapus 'mail' kalau tidak perlu email
    }

    /**
     * Simpan ke database
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => $this->message
        ];
    }

    /**
     * Email (opsional)
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pengingat Sewa Playstation')
            ->line($this->message)
            ->action('Lihat Riwayat', url('/riwayat-sewa'))
            ->line('Terima kasih telah menggunakan layanan kami!');
    }

    /**
     * Array (fallback)
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message
        ];
    }
}