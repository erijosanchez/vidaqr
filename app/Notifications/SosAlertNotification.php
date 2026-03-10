<?php

namespace App\Notifications;

use App\Models\SosAlert;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SosAlertNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected User     $user,
        protected SosAlert $alert
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('🚨 ALERTA SOS — ' . $this->user->name . ' necesita ayuda')
            ->greeting('⚠️ Alerta de Emergencia')
            ->line($this->user->name . ' ha activado el botón SOS y podría necesitar ayuda urgente.')
            ->line('**Fecha y hora:** ' . $this->alert->created_at->format('d/m/Y H:i:s'))
            ->line('**Activado por:** ' . ($this->alert->triggered_by === 'manual' ? 'El usuario manualmente' : 'Detección automática'));

        if ($this->alert->latitude && $this->alert->longitude) {
            $mail->action(
                '📍 Ver ubicación en Google Maps',
                "https://maps.google.com/?q={$this->alert->latitude},{$this->alert->longitude}"
            );
        }

        $mail->line('Si no puedes comunicarte con ' . $this->user->name . ', contacta a los servicios de emergencia:')
            ->line('🚑 Ambulancia: **106** | 🚔 Policía: **105** | 🚒 Bomberos: **116**')
            ->salutation('VidaQR Perú — Sistema de Emergencias');

        return $mail;
    }
}
