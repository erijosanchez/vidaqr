<?php

namespace App\Http\Controllers;

use App\Services\SosService;
use Illuminate\Http\Request;

class SosAlertController extends Controller
{
    public function __construct(protected SosService $sosService) {}

    public function trigger(Request $request)
    {
        $user = auth()->user();

        // Solo usuarios premium pueden usar SOS
        if (!$user->isPremium()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'El botón SOS es una función Premium.'], 403);
            }
            return back()->with('error', 'El botón SOS es una función Premium. Actualiza tu plan para usarlo.');
        }

        $validated = $request->validate([
            'latitude'     => 'nullable|numeric',
            'longitude'    => 'nullable|numeric',
            'triggered_by' => 'nullable|in:manual,auto',
        ]);

        $alert = $this->sosService->trigger(
            $user,
            $validated['latitude'] ?? null,
            $validated['longitude'] ?? null,
            $validated['triggered_by'] ?? 'manual',
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Alerta SOS enviada a tus contactos.',
                'alert'   => $alert,
            ]);
        }

        return back()->with('success', 'Alerta SOS enviada a tus contactos de emergencia.');
    }
}
