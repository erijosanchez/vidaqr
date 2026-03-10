<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — VidaQR</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#e53e3e">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --red: #e53e3e;
            --dark: #1a1a1a;
            --gray: #6b7280;
            --light: #f7f7f7;
            --white: #ffffff;
            --border: #e5e7eb;
            --sidebar-w: 240px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--light);
            color: var(--dark);
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--dark);
            display: flex;
            flex-direction: column;
            padding: 28px 0;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 50;
        }

        .sidebar-logo {
            font-family: 'Syne', sans-serif;
            font-size: 20px;
            font-weight: 800;
            color: white;
            padding: 0 24px 28px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 20px;
        }

        .sidebar-logo span {
            color: var(--red);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            color: rgba(255, 255, 255, 0.55);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.15s;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            color: white;
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-item.active {
            color: white;
            border-left-color: var(--red);
            background: rgba(229, 62, 62, 0.08);
        }

        .nav-item .nav-icon {
            font-size: 18px;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding: 20px 24px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--red);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            color: white;
            font-size: 14px;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .plan-badge {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.45);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .plan-badge.premium {
            color: #fbbf24;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.4);
            font-size: 13px;
            text-decoration: none;
            transition: color 0.15s;
            background: none;
            border: none;
            cursor: pointer;
            width: 100%;
            padding: 8px 0;
        }

        .btn-logout:hover {
            color: white;
        }

        /* ── Main content ── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 20px;
            font-weight: 800;
        }

        .content {
            padding: 32px;
            flex: 1;
        }

        /* ── Flash messages ── */
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* ── Mobile ── */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main {
                margin-left: 0;
            }

            .content {
                padding: 20px 16px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="sidebar-logo"><span>Vida</span>QR</div>

        <nav>
            <a href="{{ route('dashboard') }}" class="nav-item @if (request()->routeIs('dashboard')) active @endif">
                <span class="nav-icon">🏠</span> Dashboard
            </a>
            <a href="{{ route('profile.show') }}" class="nav-item @if (request()->routeIs('profile.*')) active @endif">
                <span class="nav-icon">🩺</span> Perfil Médico
            </a>
            <a href="{{ route('contacts.index') }}" class="nav-item @if (request()->routeIs('contacts.*')) active @endif">
                <span class="nav-icon">👥</span> Contactos
            </a>
            <a href="{{ route('qr.show') }}" class="nav-item @if (request()->routeIs('qr.*')) active @endif">
                <span class="nav-icon">📱</span> Mi QR
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="plan-badge @if (auth()->user()->isPremium()) premium @endif">
                        {{ auth()->user()->isPremium() ? '⭐ Premium' : 'Plan Gratis' }}
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">🚪 Cerrar sesión</button>
            </form>
        </div>
    </aside>

    {{-- Main --}}
    <main class="main">
        <div class="topbar">
            <div class="page-title">@yield('title', 'Dashboard')</div>
            @yield('topbar-actions')
        </div>

        <div class="content">
            @if (session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error">❌ {{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js');
        }
    </script>
    @stack('scripts')
</body>

</html>
