<?php

namespace App\Http\Controllers;

use App\Services\QrGeneratorService;
use Illuminate\Http\Request;

class QrController extends Controller
{
    public function __construct(protected QrGeneratorService $qrService) {}

    public function show()
    {
        $user    = auth()->user();
        $qrToken = $user->qrToken;

        // Si no tiene QR generado, generarlo automáticamente
        if (!$qrToken) {
            $qrToken = $this->qrService->generate($user);
        }

        return view('dashboard.qr.show', compact('qrToken'));
    }

    public function regenerate()
    {
        $user    = auth()->user();
        $qrToken = $this->qrService->regenerate($user);

        return redirect()->route('qr.show')->with('success', 'Tu QR ha sido regenerado exitosamente.');
    }
}
