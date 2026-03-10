@extends('layouts.app')
@section('title', 'Mi QR')

@section('content')
    <style>
        .qr-container {
            max-width: 480px;
            margin: 0 auto;
        }

        .qr-card {
            background: white;
            border-radius: 20px;
            padding: 36px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
            text-align: center;
            margin-bottom: 20px;
        }

        .qr-card img {
            width: 240px;
            height: 240px;
            margin: 0 auto 20px;
            display: block;
        }

        .qr-url {
            font-size: 12px;
            color: #6b7280;
            word-break: break-all;
            background: #f7f7f7;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #e53e3e;
            color: white;
            padding: 12px 20px;
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

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f3f4f6;
            color: #1a1a1a;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .info-card {
            background: white;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        }

        .info-card h4 {
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .info-item {
            display: flex;
            gap: 10px;
            font-size: 14px;
            color: #374151;
            margin-bottom: 8px;
        }

        .scan-stat {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff0f0;
            color: #e53e3e;
            font-weight: 600;
            font-size: 13px;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 16px;
        }
    </style>

    <div class="qr-container">
        <div class="qr-card">
            <div class="scan-stat">📊 {{ $qrToken->scans_count }} escaneos</div>

            <img src="{{ asset($qrToken->qr_image_path) }}" alt="Mi QR VidaQR">

            <div class="qr-url">{{ $qrToken->public_url }}</div>

            <div class="btn-group">
                <a href="{{ asset($qrToken->qr_image_path) }}" download="vidaqr-{{ auth()->user()->id }}.svg"
                    class="btn-primary">
                    ⬇ Descargar QR
                </a>
                <button
                    onclick="navigator.clipboard.writeText('{{ $qrToken->public_url }}').then(() => alert('Link copiado ✅'))"
                    class="btn-secondary">
                    🔗 Copiar link
                </button>
            </div>
        </div>

        <div class="info-card">
            <h4>💡 ¿Cómo usar tu QR?</h4>
            <div class="info-item">📥 Descarga el QR e imprímelo</div>
            <div class="info-item">⌚ Colócalo en tu pulsera, casco, mochila o cartera</div>
            <div class="info-item">📲 Cualquier persona puede escanearlo sin necesidad de app</div>
            <div class="info-item">🩺 Verán tu información médica y podrán llamar ayuda inmediatamente</div>
            <br>
            <form method="POST" action="{{ route('qr.regenerate') }}"
                onsubmit="return confirm('¿Estás seguro? El QR anterior dejará de funcionar.')">
                @csrf
                <button type="submit" class="btn-secondary" style="width:100%; justify-content:center;">
                    🔄 Regenerar QR
                </button>
            </form>
        </div>
    </div>
@endsection
