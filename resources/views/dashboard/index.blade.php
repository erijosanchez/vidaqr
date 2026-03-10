@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <style>
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 14px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        }

        .stat-icon {
            font-size: 26px;
            margin-bottom: 10px;
        }

        .stat-value {
            font-family: 'Syne', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: #1a1a1a;
        }

        .stat-label {
            font-size: 13px;
            color: #6b7280;
            margin-top: 2px;
        }

        /* ── Botón SOS ── */
        .sos-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 16px;
            text-align: center;
        }

        .sos-card h3 {
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .sos-card p {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 18px;
        }

        .btn-sos {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            padding: 18px;
            background: #e53e3e;
            color: white;
            border: none;
            border-radius: 16px;
            font-family: 'Syne', sans-serif;
            font-size: 20px;
            font-weight: 800;
            cursor: pointer;
            letter-spacing: 1px;
            box-shadow: 0 6px 20px rgba(229, 62, 62, 0.4);
            transition: transform 0.15s, box-shadow 0.15s;
            position: relative;
            overflow: hidden;
        }

        .btn-sos:active {
            transform: scale(0.97);
            box-shadow: 0 2px 10px rgba(229, 62, 62, 0.3);
        }

        .btn-sos::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.1);
            border-radius: inherit;
            animation: sosPulse 2s infinite;
        }

        @keyframes sosPulse {

            0%,
            100% {
                opacity: 0;
                transform: scale(1);
            }

            50% {
                opacity: 1;
                transform: scale(1.03);
            }
        }

        .btn-sos-locked {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            padding: 18px;
            background: #f3f4f6;
            color: #9ca3af;
            border: 2px dashed #d1d5db;
            border-radius: 16px;
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 800;
            cursor: not-allowed;
            letter-spacing: 1px;
        }

        .sos-sending {
            display: none;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 15px;
            color: #6b7280;
            margin-top: 10px;
        }

        /* ── QR preview ── */
        .qr-preview-card {
            background: white;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 16px;
        }

        .qr-thumb {
            width: 80px;
            height: 80px;
            flex-shrink: 0;
        }

        .qr-thumb img {
            width: 100%;
            height: 100%;
        }

        .qr-info h3 {
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .qr-info p {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 12px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #e53e3e;
            color: white;
            padding: 9px 16px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: opacity 0.15s;
        }

        .btn-primary:hover {
            opacity: 0.88;
        }

        /* ── Upgrade banner ── */
        .upgrade-banner {
            background: linear-gradient(135deg, #1a1a1a, #374151);
            border-radius: 16px;
            padding: 20px 22px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 16px;
        }

        .upgrade-banner h4 {
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .upgrade-banner p {
            font-size: 12px;
            opacity: 0.65;
        }

        .btn-upgrade {
            background: #fbbf24;
            color: #1a1a1a;
            padding: 9px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            flex-shrink: 0;
        }

        @media (max-width: 480px) {
            .upgrade-banner {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-upgrade {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    {{-- Stats --}}
    <div class="cards-grid">
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-value">{{ auth()->user()->qrToken?->scans_count ?? 0 }}</div>
            <div class="stat-label">Escaneos de tu QR</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-value">{{ auth()->user()->emergencyContacts()->count() }}</div>
            <div class="stat-label">Contactos</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">{{ auth()->user()->medicalProfile ? '✅' : '⚠️' }}</div>
            <div class="stat-value" style="font-size:14px; margin-top:4px;">
                {{ auth()->user()->medicalProfile ? 'Completo' : 'Incompleto' }}
            </div>
            <div class="stat-label">Perfil médico</div>
        </div>
    </div>

    {{-- Botón SOS --}}
    <div class="sos-card">
        <h3>🚨 Botón de Emergencia SOS</h3>
        <p>Envía tu ubicación a todos tus contactos de emergencia al instante.</p>

        @if (auth()->user()->isPremium())
            <button class="btn-sos" id="btnSos" onclick="triggerSOS()">
                🆘 ENVIAR SOS
            </button>
            <div class="sos-sending" id="sosSending">
                ⏳ Enviando alerta a tus contactos...
            </div>
        @else
            <div class="btn-sos-locked">
                🔒 SOS — Solo Premium
            </div>
        @endif
    </div>

    {{-- QR preview --}}
    @if (auth()->user()->qrToken)
        <div class="qr-preview-card">
            <div class="qr-thumb">
                <img src="{{ asset(auth()->user()->qrToken->qr_image_path) }}" alt="Mi QR">
            </div>
            <div class="qr-info">
                <h3>Tu QR de emergencia</h3>
                <p>Cualquiera puede escanearlo sin app.</p>
                <a href="{{ route('qr.show') }}" class="btn-primary">Ver mi QR →</a>
            </div>
        </div>
    @else
        <div class="qr-preview-card">
            <div class="qr-info">
                <h3>Genera tu QR</h3>
                <p>Completa tu perfil para generar tu QR único.</p>
                <a href="{{ route('profile.edit') }}" class="btn-primary">Completar perfil →</a>
            </div>
        </div>
    @endif

    {{-- Banner upgrade --}}
    @if (!auth()->user()->isPremium())
        <div class="upgrade-banner">
            <div>
                <h4>⭐ Actualiza a Premium</h4>
                <p>SOS, ubicación en tiempo real y contactos ilimitados por S/5 al mes.</p>
            </div>
            <a href="#" class="btn-upgrade">Actualizar</a>
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        function triggerSOS() {
            if (!confirm('¿Confirmas enviar la alerta SOS a tus contactos de emergencia?')) return;

            const btn = document.getElementById('btnSos');
            const sending = document.getElementById('sosSending');

            btn.disabled = true;
            btn.style.opacity = '0.7';
            sending.style.display = 'flex';

            // Obtener ubicación GPS
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    pos => sendSOS(pos.coords.latitude, pos.coords.longitude),
                    () => sendSOS(null, null)
                );
            } else {
                sendSOS(null, null);
            }
        }

        function sendSOS(lat, lng) {
            fetch('{{ route('sos.trigger') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        latitude: lat,
                        longitude: lng,
                        triggered_by: 'manual'
                    })
                })
                .then(r => r.json())
                .then(data => {
                    document.getElementById('sosSending').style.display = 'none';
                    alert('✅ Alerta SOS enviada a tus contactos.');
                    document.getElementById('btnSos').disabled = false;
                    document.getElementById('btnSos').style.opacity = '1';
                })
                .catch(() => {
                    alert('❌ Error al enviar la alerta. Intenta de nuevo.');
                    document.getElementById('btnSos').disabled = false;
                    document.getElementById('btnSos').style.opacity = '1';
                    document.getElementById('sosSending').style.display = 'none';
                });
        }
    </script>
@endpush
