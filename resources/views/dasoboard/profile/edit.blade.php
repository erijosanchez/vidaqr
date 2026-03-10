@extends('layouts.app')
@section('title', 'Editar Perfil Médico')

@section('content')
    <style>
        .form-container {
            max-width: 680px;
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
            margin-bottom: 20px;
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

        label .hint {
            font-weight: 400;
            color: #9ca3af;
            font-size: 12px;
        }

        input[type="text"],
        input[type="file"],
        select,
        textarea {
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
        select:focus,
        textarea:focus {
            border-color: #e53e3e;
            box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.1);
            background: white;
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        .blood-options {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .blood-option input {
            display: none;
        }

        .blood-option label {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 44px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-family: 'Syne', sans-serif;
            font-size: 13px;
            font-weight: 700;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.15s;
            margin: 0;
        }

        .blood-option input:checked+label {
            border-color: #e53e3e;
            background: #e53e3e;
            color: white;
        }

        .blood-option label:hover {
            border-color: #e53e3e;
            color: #e53e3e;
        }

        .photo-preview {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e53e3e;
            margin-bottom: 10px;
            display: block;
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
            border: none;
            cursor: pointer;
        }

        .error-msg {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
        }
    </style>

    <div class="form-container">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Foto y tipo de sangre --}}
            <div class="form-card">
                <h3>🧬 Datos principales</h3>

                <div class="form-group">
                    <label>Foto de perfil <span class="hint">(opcional, JPG/PNG máx 2MB)</span></label>
                    @if ($profile?->photo)
                        <img src="{{ $profile->photo_url }}" class="photo-preview" id="photoPreview">
                    @else
                        <img src="" class="photo-preview" id="photoPreview" style="display:none;">
                    @endif
                    <input type="file" name="photo" accept="image/jpeg,image/png" onchange="previewPhoto(this)">
                    @error('photo')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Tipo de sangre</label>
                    <div class="blood-options">
                        @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                            <div class="blood-option">
                                <input type="radio" name="blood_type" id="bt_{{ $type }}"
                                    value="{{ $type }}"
                                    {{ old('blood_type', $profile?->blood_type) === $type ? 'checked' : '' }}>
                                <label for="bt_{{ $type }}">{{ $type }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('blood_type')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Información médica --}}
            <div class="form-card">
                <h3>🩺 Información médica</h3>

                <div class="form-group">
                    <label>Alergias <span class="hint">(separadas por comas: penicilina, mariscos, polen)</span></label>
                    <textarea name="allergies" placeholder="Ej: Penicilina, Ibuprofeno, Mariscos">{{ old('allergies', $profile?->allergies) }}</textarea>
                    @error('allergies')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Enfermedades o condiciones</label>
                    <textarea name="diseases" placeholder="Ej: Diabetes tipo 2, Hipertensión">{{ old('diseases', $profile?->diseases) }}</textarea>
                    @error('diseases')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Medicamentos actuales</label>
                    <textarea name="medications" placeholder="Ej: Metformina 850mg, Enalapril 10mg">{{ old('medications', $profile?->medications) }}</textarea>
                    @error('medications')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Observaciones adicionales <span class="hint">(opcional)</span></label>
                    <textarea name="observations" placeholder="Ej: Usa marcapasos, donante de órganos">{{ old('observations', $profile?->observations) }}</textarea>
                    @error('observations')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">💾 Guardar perfil</button>
                <a href="{{ route('profile.show') }}" class="btn-secondary">Cancelar</a>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function previewPhoto(input) {
            const preview = document.getElementById('photoPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
