@extends('layouts.app')
@section('title', 'Contactos de Emergencia')

@section('topbar-actions')
    @if (auth()->user()->isPremium() || $contacts->count() < 1)
        <a href="{{ route('contacts.create') }}" class="btn-primary">+ Agregar contacto</a>
    @endif
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

        .contacts-card {
            background: white;
            border-radius: 20px;
            padding: 8px 0;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 16px;
        }

        .contact-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            border-bottom: 1px solid #f0f0f0;
            gap: 16px;
        }

        .contact-row:last-child {
            border-bottom: none;
        }

        .contact-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .contact-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #fff0f0;
            border: 2px solid #fecaca;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 16px;
            font-weight: 800;
            color: #e53e3e;
            flex-shrink: 0;
        }

        .contact-name {
            font-weight: 600;
            font-size: 15px;
        }

        .contact-meta {
            font-size: 13px;
            color: #6b7280;
        }

        .primary-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #dcfce7;
            color: #166534;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
            margin-left: 8px;
        }

        .contact-actions {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s;
        }

        .btn-edit {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-edit:hover {
            background: #e5e7eb;
        }

        .btn-delete:hover {
            background: #fecaca;
        }

        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: #6b7280;
        }

        .empty-state .empty-icon {
            font-size: 48px;
            margin-bottom: 12px;
        }

        .empty-state p {
            font-size: 15px;
            margin-bottom: 20px;
        }

        .upgrade-banner {
            background: linear-gradient(135deg, #1a1a1a, #374151);
            border-radius: 16px;
            padding: 20px 24px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .upgrade-banner h4 {
            font-family: 'Syne', sans-serif;
            font-size: 15px;
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
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            flex-shrink: 0;
        }
    </style>

    @if ($contacts->isEmpty())
        <div class="contacts-card">
            <div class="empty-state">
                <div class="empty-icon">👥</div>
                <p>Aún no tienes contactos de emergencia.</p>
                <a href="{{ route('contacts.create') }}" class="btn-primary">+ Agregar primer contacto</a>
            </div>
        </div>
    @else
        <div class="contacts-card">
            @foreach ($contacts as $contact)
                <div class="contact-row">
                    <div class="contact-left">
                        <div class="contact-avatar">{{ strtoupper(substr($contact->name, 0, 1)) }}</div>
                        <div>
                            <div class="contact-name">
                                {{ $contact->name }}
                                @if ($contact->is_primary)
                                    <span class="primary-badge">⭐ Principal</span>
                                @endif
                            </div>
                            <div class="contact-meta">{{ $contact->relationship ?? 'Contacto' }} · {{ $contact->phone }}
                            </div>
                        </div>
                    </div>
                    <div class="contact-actions">
                        <a href="{{ route('contacts.edit', $contact) }}" class="btn-icon btn-edit">✏️</a>
                        <form method="POST" action="{{ route('contacts.destroy', $contact) }}"
                            onsubmit="return confirm('¿Eliminar a {{ $contact->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-icon btn-delete">🗑️</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if (!auth()->user()->isPremium() && $contacts->count() >= 1)
        <div class="upgrade-banner">
            <div>
                <h4>⭐ ¿Tienes más contactos?</h4>
                <p>El plan Premium te permite agregar contactos ilimitados.</p>
            </div>
            <a href="#" class="btn-upgrade">Actualizar</a>
        </div>
    @endif

@endsection
