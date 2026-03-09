<?php

namespace App\Services;

use App\Models\SosAlert;
use App\Models\User;
use App\Notifications\SosAlertNotification;

class SosService
{
    public function trigger(User $user, ?float $latitude, ?float $longitude, string $triggeredBy = 'manual'): SosAlert
    {
        // Crear la alerta
        $alert = SosAlert::create([
            'user_id'      => $user->id,
            'latitude'     => $latitude,
            'longitude'    => $longitude,
            'triggered_by' => $triggeredBy,
            'status'       => 'sent',
        ]);

        // Notificar a todos los contactos de emergencia
        $contacts = $user->emergencyContacts;

        foreach ($contacts as $contact) {
            try {
                $contact->notify(new SosAlertNotification($user, $alert));
            } catch (\Exception $e) {
                // Log error pero no detener el proceso
                \Log::error("Error notificando contacto {$contact->id}: " . $e->getMessage());
            }
        }

        return $alert;
    }
}
