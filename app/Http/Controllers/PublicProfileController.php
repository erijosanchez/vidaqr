<?php

namespace App\Http\Controllers;

use App\Models\QrToken;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    /**
     * Página pública que se abre al escanear el QR.
     * No requiere autenticación.
     */
    public function show(string $token)
    {
        $qr = QrToken::where('token', $token)
            ->where('is_active', true)
            ->firstOrFail();

        // Registrar el escaneo
        $qr->registerScan();

        $user     = $qr->user;
        $profile  = $user->medicalProfile;
        $contacts = $user->emergencyContacts()->orderByDesc('is_primary')->get();
        $location = $user->location;

        return view('emergency.profile', compact('user', 'profile', 'contacts', 'location', 'qr'));
    }
}
