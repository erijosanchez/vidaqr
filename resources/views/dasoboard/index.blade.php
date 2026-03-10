@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <style>
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        }

        .stat-icon {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .stat-value {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: #1a1a1a;
        }

        .stat-label {
            font-size: 13px;
            color: #6b7280;
            margin-top: 2px;
        }

        .qr-preview-card {
            background: white;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 28px;
            margin-bottom: 20px;
        }

        .qr-image {
            width: 120px;
            height: 120px;
            flex-shrink: 0;
        }

        .qr-image img {
            width: 100%;
            height: 100%;
        }

        .qr-info h3 {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .qr-info p {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 14px;
        }

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

        .upgrade-banner {
            background: linear-gradient(135deg, #1a1a1a, #374151);
            border-radius: 16px;
            padding: 24px 28px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .upgrade-banner h4 {
            font-family: 'Syne', sans-serif;
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .upgrade-banner p {
            font-size: 13px;
            opacity: 0.65;
        }

        .btn-upgrade {
            background: #fbbf24;
            color: #1a1a1a;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            flex-shrink: 0;
        }
    </style>

    {{-- Stats --}}
    <div class="cards-grid">
        <div class="stat-card">
            <div class="stat-icon">📱</div>
            <div class="stat-value">{{ auth()->user()->qrToken?->scans_count ?? 0 }}</div>
            <div class="stat-label">Veces escaneado tu QR</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-value">{{ auth()->user()->emergencyContacts()->count() }}</div>
            <div class="stat-label">Contactos de emergencia</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🩺</div>
            <div class="stat-value">{{ auth()->user()->medicalProfile ? '✅' : '⚠️' }}</div>
            <div class="stat-label">{{ auth()->user()->medicalProfile ? 'Perfil completo' : 'Perfil incompleto' }}</div>
        </div>
    </div>

    {{-- QR Preview --}}
    @if (auth()->user()->qrToken)
        <div class="qr-preview-card">
            <div class="qr-image">
                <img src="{{ asset(auth()->user()->qrToken->qr_image_path) }}" alt="Mi QR">
            </div>
            <div class="qr-info">
                <h3>Tu QR de emergencia</h3>
                <p>Compártelo, imprímelo o úsalo en tu pulsera. Cualquiera puede escanearlo sin necesidad de app.</p>
                <a href="{{ route('qr.show') }}" class="btn-primary">📲 Ver mi QR</a>
            </div>
        </div>
    @else
        <div class="qr-preview-card">
            <div class="qr-info">
                <h3>Genera tu QR de emergencia</h3>
                <p>Completa tu perfil médico para generar tu código QR único.</p>
                <a href="{{ route('profile.edit') }}" class="btn-primary">🩺 Completar perfil</a>
            </div>
        </div>
    @endif

    {{-- Banner upgrade --}}
    @if (!auth()->user()->isPremium())
        <div class="upgrade-banner">
            <div>
                <h4>⭐ Actualiza a Premium</h4>
                <p>Desbloquea SOS, ubicación en tiempo real y contactos ilimitados por solo S/5 al mes.</p>
            </div>
            <a href="#" class="btn-upgrade">Actualizar</a>
        </div>
    @endif

@endsection
