<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrController;
use App\Http\Controllers\SosAlertController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\MedicalProfileController;
use App\Http\Controllers\EmergencyContactController;

// ── Públicas (sin auth) ───────────────────────────────────────────────────
Route::get('/e/{token}', [PublicProfileController::class, 'show'])
    ->name('emergency.profile');

// ── Autenticadas ──────────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');

    // Perfil médico
    Route::get('/perfil',         [MedicalProfileController::class, 'show'])->name('profile.show');
    Route::get('/perfil/editar',  [MedicalProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil',         [MedicalProfileController::class, 'update'])->name('profile.update');

    // Contactos de emergencia
    Route::resource('contactos', EmergencyContactController::class)->names([
        'index'   => 'contacts.index',
        'create'  => 'contacts.create',
        'store'   => 'contacts.store',
        'edit'    => 'contacts.edit',
        'update'  => 'contacts.update',
        'destroy' => 'contacts.destroy',
    ]);

    // QR
    Route::get('/mi-qr',          [QrController::class, 'show'])->name('qr.show');
    Route::post('/mi-qr/regenerar', [QrController::class, 'regenerate'])->name('qr.regenerate');

    // SOS
    Route::post('/sos', [SosAlertController::class, 'trigger'])->name('sos.trigger');
});


require __DIR__.'/auth.php';
