<?php

namespace App\Services;

use App\Models\QrToken;
use App\Models\User;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrGeneratorService
{
    public function generate(User $user): QrToken
    {
        $token = (string) Str::uuid();
        $url   = route('emergency.profile', $token);

        // Generar imagen SVG del QR
        $path = "qr/{$user->id}.svg";
        QrCode::format('svg')
            ->size(300)
            ->errorCorrection('H')
            ->generate($url, public_path($path));

        // Crear o actualizar el token del usuario
        $qrToken = QrToken::updateOrCreate(
            ['user_id' => $user->id],
            [
                'token'          => $token,
                'qr_image_path'  => $path,
                'is_active'      => true,
            ]
        );

        return $qrToken;
    }

    public function regenerate(User $user): QrToken
    {
        // Desactivar token anterior
        QrToken::where('user_id', $user->id)->update(['is_active' => false]);

        return $this->generate($user);
    }
}
