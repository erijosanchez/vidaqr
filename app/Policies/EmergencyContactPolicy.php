<?php

namespace App\Policies;

use App\Models\EmergencyContact;
use App\Models\User;

class EmergencyContactPolicy
{
    /**
     * Solo el dueño del contacto puede editarlo o eliminarlo.
     */
    public function update(User $user, EmergencyContact $contact): bool
    {
        return $user->id === $contact->user_id;
    }

    public function delete(User $user, EmergencyContact $contact): bool
    {
        return $user->id === $contact->user_id;
    }
}