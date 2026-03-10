<?php

// ─── routes/api.php ────────────────────────────────────────────────────────
// Usado en la Fase 2 cuando tengamos la app Flutter

use App\Http\Controllers\MedicalProfileController;
use App\Http\Controllers\SosAlertController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    // Perfil médico
    Route::get('/perfil', [MedicalProfileController::class, 'show']);
    Route::put('/perfil', [MedicalProfileController::class, 'update']);

    // SOS
    Route::post('/sos', [SosAlertController::class, 'trigger']);
});