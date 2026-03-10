<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergencia — {{ $user->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --red: #e53e3e;
            --red-dark: #c0392b;
            --red-soft: #fff0f0;
            --dark: #1a1a1a;
            --gray: #6b7280;
            --border: #f0f0f0;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f7f7f7;
            color: var(--dark);
            min-height: 100vh;
        }

        /* ── Header de emergencia ── */
        .emergency-header {
            background: var(--red);
            color: white;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(229, 62, 62, 0.3);
        }

        .emergency-header .pulse {
            width: 12px;
            height: 12px;
            background: white;
            border-radius: 50%;
            animation: pulse 1.4s infinite;
            flex-shrink: 0;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.4);
            }
        }

        .emergency-header span {
            font-family: 'Syne', sans-serif;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* ── Card principal ── */
        .container {
            max-width: 480px;
            margin: 0 auto;
            padding: 20px 16px 40px;
        }

        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 28px 24px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
            margin-bottom: 16px;
            animation: fadeUp 0.4s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .profile-photo {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--red);
            flex-shrink: 0;
        }

        .profile-photo-placeholder {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: var(--red-soft);
            border: 3px solid var(--red);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: var(--red);
            flex-shrink: 0;
        }

        .profile-info h1 {
            font-family: 'Syne', sans-serif;
            font-size: 22px;
            font-weight: 800;
            line-height: 1.2;
            color: var(--dark);
        }

        .blood-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--red);
            color: white;
            font-family: 'Syne', sans-serif;
            font-size: 13px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            margin-top: 6px;
        }

        /* ── Secciones médicas ── */
        .medical-section {
            margin-bottom: 16px;
        }

        .section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--gray);
            margin-bottom: 6px;
        }

        .section-value {
            font-size: 15px;
            color: var(--dark);
            line-height: 1.5;
        }

        .tag-list {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .tag {
            background: var(--red-soft);
            color: var(--red-dark);
            font-size: 13px;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 20px;
            border: 1px solid #fecaca;
        }

        .no-data {
            color: #9ca3af;
            font-size: 14px;
            font-style: italic;
        }

        /* ── Botones de emergencia ── */
        .emergency-buttons {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
            margin-bottom: 16px;
            animation: fadeUp 0.4s 0.1s ease both;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--gray);
            margin-bottom: 14px;
        }

        .btn-emergency {
            display: flex;
            align-items: center;
            gap: 14px;
            width: 100%;
            padding: 16px 18px;
            border-radius: 14px;
            border: none;
            text-decoration: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
            margin-bottom: 10px;
        }

        .btn-emergency:active {
            transform: scale(0.97);
        }

        .btn-emergency:last-child {
            margin-bottom: 0;
        }

        .btn-ambulancia {
            background: var(--red);
            color: white;
            box-shadow: 0 4px 16px rgba(229, 62, 62, 0.35);
        }

        .btn-policia {
            background: #1d4ed8;
            color: white;
            box-shadow: 0 4px 16px rgba(29, 78, 216, 0.25);
        }

        .btn-bomberos {
            background: #d97706;
            color: white;
            box-shadow: 0 4px 16px rgba(217, 119, 6, 0.25);
        }

        .btn-contacto {
            background: #059669;
            color: white;
            box-shadow: 0 4px 16px rgba(5, 150, 105, 0.25);
        }

        .btn-ubicacion {
            background: #7c3aed;
            color: white;
            box-shadow: 0 4px 16px rgba(124, 58, 237, 0.25);
        }

        .btn-icon {
            font-size: 24px;
            flex-shrink: 0;
        }

        .btn-text {
            text-align: left;
        }

        .btn-number {
            font-size: 12px;
            opacity: 0.85;
            font-weight: 400;
        }

        /* ── Contactos ── */
        .contacts-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
            margin-bottom: 16px;
            animation: fadeUp 0.4s 0.2s ease both;
        }

        .contact-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .contact-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .contact-item:first-child {
            padding-top: 0;
        }

        .contact-info .contact-name {
            font-weight: 600;
            font-size: 15px;
        }

        .contact-info .contact-rel {
            font-size: 13px;
            color: var(--gray);
        }

        .contact-actions {
            display: flex;
            gap: 8px;
        }

        .btn-call {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.15s;
        }

        .btn-call:active {
            transform: scale(0.9);
        }

        .btn-call-phone {
            background: #dcfce7;
            color: #059669;
        }

        .btn-call-wa {
            background: #dcfce7;
            color: #25d366;
        }

        /* ── Footer ── */
        .footer {
            text-align: center;
            padding: 20px 0 0;
            animation: fadeUp 0.4s 0.3s ease both;
        }

        .footer-logo {
            font-family: 'Syne', sans-serif;
            font-size: 13px;
            font-weight: 700;
            color: var(--gray);
            letter-spacing: 1px;
        }

        .footer-logo span {
            color: var(--red);
        }
    </style>
</head>

<body>

    <div class="emergency-header">
        <div class="pulse"></div>
        <span>⚠ Perfil de Emergencia</span>
    </div>

    <div class="container">

        {{-- Card perfil médico --}}
        <div class="profile-card">
            <div class="profile-header">
                @if ($profile?->photo)
                    <img src="{{ $profile->photo_url }}" alt="{{ $user->name }}" class="profile-photo">
                @else
                    <div class="profile-photo-placeholder">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div class="profile-info">
                    <h1>{{ $user->name }}</h1>
                    @if ($profile?->blood_type)
                        <div class="blood-badge">🩸 {{ $profile->blood_type }}</div>
                    @endif
                </div>
            </div>

            {{-- Alergias --}}
            <div class="medical-section">
                <div class="section-label">Alergias</div>
                @if ($profile?->allergies)
                    <div class="tag-list">
                        @foreach (explode(',', $profile->allergies) as $allergy)
                            <span class="tag">{{ trim($allergy) }}</span>
                        @endforeach
                    </div>
                @else
                    <div class="no-data">Sin alergias registradas</div>
                @endif
            </div>

            {{-- Enfermedades --}}
            <div class="medical-section">
                <div class="section-label">Enfermedades</div>
                @if ($profile?->diseases)
                    <div class="section-value">{{ $profile->diseases }}</div>
                @else
                    <div class="no-data">Sin enfermedades registradas</div>
                @endif
            </div>

            {{-- Medicamentos --}}
            <div class="medical-section">
                <div class="section-label">Medicamentos</div>
                @if ($profile?->medications)
                    <div class="section-value">{{ $profile->medications }}</div>
                @else
                    <div class="no-data">Sin medicamentos registrados</div>
                @endif
            </div>

            {{-- Observaciones --}}
            @if ($profile?->observations)
                <div class="medical-section">
                    <div class="section-label">Observaciones</div>
                    <div class="section-value">{{ $profile->observations }}</div>
                </div>
            @endif
        </div>

        {{-- Botones de emergencia --}}
        <div class="emergency-buttons">
            <div class="section-title">Llamar emergencias</div>

            <a href="tel:106" class="btn-emergency btn-ambulancia">
                <span class="btn-icon">🚑</span>
                <div class="btn-text">
                    <div>Ambulancia</div>
                    <div class="btn-number">106 — SAMU</div>
                </div>
            </a>

            <a href="tel:105" class="btn-emergency btn-policia">
                <span class="btn-icon">🚔</span>
                <div class="btn-text">
                    <div>Policía</div>
                    <div class="btn-number">105 — PNP</div>
                </div>
            </a>

            <a href="tel:116" class="btn-emergency btn-bomberos">
                <span class="btn-icon">🚒</span>
                <div class="btn-text">
                    <div>Bomberos</div>
                    <div class="btn-number">116 — Cuerpo de Bomberos</div>
                </div>
            </a>

            {{-- Contacto primario --}}
            @if ($contacts->isNotEmpty())
                @php $primary = $contacts->firstWhere('is_primary', true) ?? $contacts->first(); @endphp
                <a href="tel:{{ $primary->phone }}" class="btn-emergency btn-contacto">
                    <span class="btn-icon">👤</span>
                    <div class="btn-text">
                        <div>{{ $primary->name }}</div>
                        <div class="btn-number">{{ $primary->relationship ?? 'Contacto de emergencia' }} ·
                            {{ $primary->phone }}</div>
                    </div>
                </a>
            @endif

            {{-- Ubicación --}}
            @if ($location && $location->isSharedActive())
                <a href="{{ $location->maps_link }}" target="_blank" class="btn-emergency btn-ubicacion">
                    <span class="btn-icon">📍</span>
                    <div class="btn-text">
                        <div>Ver ubicación</div>
                        <div class="btn-number">Última ubicación registrada</div>
                    </div>
                </a>
            @endif
        </div>

        {{-- Todos los contactos --}}
        @if ($contacts->count() > 1)
            <div class="contacts-card">
                <div class="section-title">Contactos de emergencia</div>
                @foreach ($contacts as $contact)
                    <div class="contact-item">
                        <div class="contact-info">
                            <div class="contact-name">{{ $contact->name }}</div>
                            <div class="contact-rel">{{ $contact->relationship ?? 'Contacto' }} ·
                                {{ $contact->phone }}</div>
                        </div>
                        <div class="contact-actions">
                            <a href="{{ $contact->call_link }}" class="btn-call btn-call-phone">📞</a>
                            <a href="{{ $contact->whatsapp_link }}" target="_blank" class="btn-call btn-call-wa">💬</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="footer">
            <div class="footer-logo"><span>Vida</span>QR Perú</div>
        </div>

    </div>

</body>

</html>
