<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class VerifikasiEmailKustom extends VerifyEmailBase
{
    /**
     * Buat pesan email.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        // --- INILAH BAGIAN YANG KITA KUSTOMISASI ---
        return (new MailMessage)
            ->subject(Lang::get('Verifikasi Alamat Email Anda'))
            ->line(Lang::get('Mohon klik tombol di bawah ini untuk memverifikasi alamat email Anda.'))
            ->action(Lang::get('Verifikasi Alamat Email'), $verificationUrl)
            ->line(Lang::get('Jika Anda tidak merasa membuat akun ini, Anda dapat mengabaikan email ini.'));
    }
}
