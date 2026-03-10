<?php

namespace App\Http\Controllers;

use App\Models\EmergencyContact;
use Illuminate\Http\Request;

class EmergencyContactController extends Controller
{
    public function index()
    {
        $contacts = auth()->user()->emergencyContacts()->orderByDesc('is_primary')->get();
        return view('dashboard.contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('dashboard.contacts.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // Plan free: máximo 1 contacto
        if (!$user->isPremium() && $user->emergencyContacts()->count() >= 1) {
            return back()->with('error', 'El plan gratuito solo permite 1 contacto de emergencia. Actualiza a Premium para agregar más.');
        }

        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'relationship' => 'nullable|string|max:50',
            'phone'        => 'required|string|max:20',
            'is_primary'   => 'boolean',
        ]);

        // Si se marca como primario, quitar el flag a los demás
        if (!empty($validated['is_primary'])) {
            $user->emergencyContacts()->update(['is_primary' => false]);
        }

        // Si es el primero, marcarlo como primario automáticamente
        if ($user->emergencyContacts()->count() === 0) {
            $validated['is_primary'] = true;
        }

        $user->emergencyContacts()->create($validated);

        return redirect()->route('contacts.index')->with('success', 'Contacto agregado correctamente.');
    }

    public function edit(EmergencyContact $contact)
    {
        $this->authorize('update', $contact);
        return view('dashboard.contacts.edit', compact('contact'));
    }

    public function update(Request $request, EmergencyContact $contact)
    {
        $this->authorize('update', $contact);

        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'relationship' => 'nullable|string|max:50',
            'phone'        => 'required|string|max:20',
            'is_primary'   => 'boolean',
        ]);

        if (!empty($validated['is_primary'])) {
            auth()->user()->emergencyContacts()->update(['is_primary' => false]);
        }

        $contact->update($validated);

        return redirect()->route('contacts.index')->with('success', 'Contacto actualizado correctamente.');
    }

    public function destroy(EmergencyContact $contact)
    {
        $this->authorize('delete', $contact);
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contacto eliminado.');
    }
}
