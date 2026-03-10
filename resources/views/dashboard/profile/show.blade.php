@extends('layouts.app')
@section('title', 'Perfil Médico')

@section('topbar-actions')
    <a href="{{ route('profile.edit') }}" class="btn-primary">✏️ Editar perfil</a>
@endsection

@section('content')
    <style>
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #e53e3e;
            color: white;
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: opacity 0.15s;
        }

        .btn-primary:hover {
            opacity: 0.88;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 20px;
            align-items: start;
        }

        .photo-card {
            background: white;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #e53e3e;
            margin: 0 auto 16px;
            display: block;
        }

        .profile-photo-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #fff0f0;
            border: 4px solid #e53e3e;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 48px;
            font-weight: 800;
            color: #e53e3e;
            margin: 0 auto 16px;
        }

        .photo-name {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .blood-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #e53e3e;
            color: white;
            font-family: 'Syne', sans-serif;
            font-size: 14px;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 20px;
        }

        .info-card {
            background: white;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        }

        .field-group {
            padding: 16px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .field-group:first-child {
            padding-top: 0;
        }

        .field-group:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .field-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .field-value {
            font-size: 15px;
            color: #1a1a1a;
            line-height: 1.6;
        }

        .tag-list {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .tag {
            background: #fff0f0;
            color: #c0392b;
            font-size: 13px;
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid #fecaca;
        }

        .no-data {
            color: #9ca3af;
            font-size: 14px;
            font-style: italic;
        }

        .incomplete-banner {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 14px;
            color: #92400e;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @if (!$profile)
        <div class="incomplete-banner">
            ⚠️ Aún no has completado tu perfil médico. <a href="{{ route('profile.edit') }}"
                style="color:#e53e3e;font-weight:600;">Completarlo ahora</a>
        </div>
    @endif

    <div class="profile-grid">

        {{-- Foto y tipo de sangre --}}
        <div class="photo-card">
            @if ($profile?->photo)
                <img src="{{ $profile->photo_url }}" alt="Foto" class="profile-photo">
            @else
                <div class="profile-photo-placeholder">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif

            <div class="photo-name">{{ auth()->user()->name }}</div>

            @if ($profile?->blood_type)
                <div class="blood-badge">🩸 {{ $profile->blood_type }}</div>
            @else
                <span class="no-data">Tipo de sangre no registrado</span>
            @endif
        </div>

        {{-- Datos médicos --}}
        <div class="info-card">

            <div class="field-group">
                <div class="field-label">Alergias</div>
                @if ($profile?->allergies)
                    <div class="tag-list">
                        @foreach (explode(',', $profile->allergies) as $item)
                            <span class="tag">{{ trim($item) }}</span>
                        @endforeach
                    </div>
                @else
                    <div class="no-data">Sin alergias registradas</div>
                @endif
            </div>

            <div class="field-group">
                <div class="field-label">Enfermedades</div>
                @if ($profile?->diseases)
                    <div class="field-value">{{ $profile->diseases }}</div>
                @else
                    <div class="no-data">Sin enfermedades registradas</div>
                @endif
            </div>

            <div class="field-group">
                <div class="field-label">Medicamentos</div>
                @if ($profile?->medications)
                    <div class="field-value">{{ $profile->medications }}</div>
                @else
                    <div class="no-data">Sin medicamentos registrados</div>
                @endif
            </div>

            <div class="field-group">
                <div class="field-label">Observaciones</div>
                @if ($profile?->observations)
                    <div class="field-value">{{ $profile->observations }}</div>
                @else
                    <div class="no-data">Sin observaciones</div>
                @endif
            </div>

        </div>
    </div>
@endsection
