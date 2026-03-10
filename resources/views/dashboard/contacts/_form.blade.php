<style>
    .form-container {
        max-width: 520px;
    }

    .form-card {
        background: white;
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 16px;
    }

    .form-card h3 {
        font-family: 'Syne', sans-serif;
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 22px;
        padding-bottom: 14px;
        border-bottom: 1px solid #f0f0f0;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    input[type="text"],
    input[type="tel"],
    select {
        width: 100%;
        padding: 11px 14px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        color: #1a1a1a;
        background: #fafafa;
        transition: border-color 0.15s, box-shadow 0.15s;
        outline: none;
    }

    input:focus,
    select:focus {
        border-color: #e53e3e;
        box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.1);
        background: white;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px;
        background: #fafafa;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    .checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #e53e3e;
        cursor: pointer;
    }

    .checkbox-group label {
        margin: 0;
        font-size: 14px;
        cursor: pointer;
        color: #374151;
    }

    .error-msg {
        color: #dc2626;
        font-size: 12px;
        margin-top: 4px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #e53e3e;
        color: white;
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: opacity 0.15s;
    }

    .btn-primary:hover {
        opacity: 0.88;
    }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f3f4f6;
        color: #1a1a1a;
        padding: 12px 24px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
    }
</style>

<div class="form-container">
    <form method="POST" action="{{ $action }}">
        @csrf
        @method($method)

        <div class="form-card">
            <h3>👤 Datos del contacto</h3>

            <div class="form-group">
                <label>Nombre completo *</label>
                <input type="text" name="name" value="{{ old('name', $contact->name) }}"
                    placeholder="Ej: María García" required>
                @error('name')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Relación</label>
                <select name="relationship">
                    <option value="">Seleccionar...</option>
                    @foreach (['Padre', 'Madre', 'Esposo/a', 'Hijo/a', 'Hermano/a', 'Amigo/a', 'Médico', 'Otro'] as $rel)
                        <option value="{{ $rel }}"
                            {{ old('relationship', $contact->relationship) === $rel ? 'selected' : '' }}>
                            {{ $rel }}
                        </option>
                    @endforeach
                </select>
                @error('relationship')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Número de teléfono *</label>
                <input type="tel" name="phone" value="{{ old('phone', $contact->phone) }}"
                    placeholder="Ej: 999888777" required>
                @error('phone')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" name="is_primary" id="is_primary" value="1"
                        {{ old('is_primary', $contact->is_primary) ? 'checked' : '' }}>
                    <label for="is_primary">⭐ Marcar como contacto principal</label>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">💾 Guardar contacto</button>
            <a href="{{ route('contacts.index') }}" class="btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
