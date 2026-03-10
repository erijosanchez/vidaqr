<?php

namespace App\Http\Controllers;

use App\Models\MedicalProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicalProfileController extends Controller
{
    public function show()
    {
        $profile = auth()->user()->medicalProfile;
        return view('dashboard.profile.show', compact('profile'));
    }

    public function edit()
    {
        $profile = auth()->user()->medicalProfile ?? new MedicalProfile();
        return view('dashboard.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'blood_type'   => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'allergies'    => 'nullable|string|max:1000',
            'diseases'     => 'nullable|string|max:1000',
            'medications'  => 'nullable|string|max:1000',
            'observations' => 'nullable|string|max:1000',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        // Manejar la foto
        if ($request->hasFile('photo')) {
            // Eliminar foto anterior si existe
            if ($user->medicalProfile?->photo) {
                Storage::disk('public')->delete($user->medicalProfile->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $user->medicalProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('profile.show')->with('success', 'Perfil médico actualizado correctamente.');
    }
}
