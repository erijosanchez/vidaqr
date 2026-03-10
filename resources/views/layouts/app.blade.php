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

        /* ── Overlay mobile ── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }

        .sidebar-overlay.active {
            display: block;
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
            transition: transform 0.25s ease;
        }

        .sidebar-logo {
            font-family: 'Syne', sans-serif;
            font-size: 20px;
            font-weight: 800;
            color: white;
            padding: 0 24px 28px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-logo span {
            color: var(--red);
        }

        .btn-close-sidebar {
            display: none;
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.5);
            font-size: 22px;
            cursor: pointer;
            padding: 4px;
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

        .nav-icon {
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
            background: none;
            border: none;
            cursor: pointer;
            width: 100%;
            padding: 8px 0;
            transition: color 0.15s;
        }

        .btn-logout:hover {
            color: white;
        }

        /* ── Main ── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* ── Topbar ── */
        .topbar {
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .btn-hamburger {
            display: none;
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: var(--dark);
            padding: 4px;
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 800;
        }

        /* ── Content ── */
        .content {
            padding: 28px 32px;
            flex: 1;
        }

        /* ── Flash messages ── */
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
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

        /* ── Bottom nav mobile ── */
        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid var(--border);
            z-index: 30;
            padding: 8px 0 calc(8px + env(safe-area-inset-bottom));
        }

        .bottom-nav-items {
            display: flex;
            justify-content: space-around;
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            text-decoration: none;
            color: var(--gray);
            font-size: 10px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 10px;
            transition: color 0.15s;
        }

        .bottom-nav-item.active {
            color: var(--red);
        }

        .bottom-nav-item .bnav-icon {
            font-size: 20px;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .btn-close-sidebar {
                display: block;
            }

            .btn-hamburger {
                display: block;
            }

            .main {
                margin-left: 0;
            }

            .topbar {
                padding: 12px 16px;
            }

            .content {
                padding: 20px 16px 90px;
            }

            .bottom-nav {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <span><span style="color:white">Vida</span>QR</span>
            <button class="btn-close-sidebar" onclick="closeSidebar()">✕</button>
        </div>

        <nav>
            <a href="{{ route('dashboard') }}" class="nav-item @if (request()->routeIs('dashboard')) active @endif"
                onclick="closeSidebar()">
                <span class="nav-icon">🏠</span> Dashboard
            </a>
            <a href="{{ route('profile.show') }}" class="nav-item @if (request()->routeIs('profile.*')) active @endif"
                onclick="closeSidebar()">
                <span class="nav-icon">🩺</span> Perfil Médico
            </a>
            <a href="{{ route('contacts.index') }}" class="nav-item @if (request()->routeIs('contacts.*')) active @endif"
                onclick="closeSidebar()">
                <span class="nav-icon">👥</span> Contactos
            </a>
            <a href="{{ route('qr.show') }}" class="nav-item @if (request()->routeIs('qr.*')) active @endif"
                onclick="closeSidebar()">
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

    <main class="main">
        <div class="topbar">
            <div class="topbar-left">
                <button class="btn-hamburger" onclick="openSidebar()">☰</button>
                <div class="page-title">@yield('title', 'Dashboard')</div>
            </div>
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

    {{-- Bottom nav mobile --}}
    <nav class="bottom-nav">
        <div class="bottom-nav-items">
            <a href="{{ route('dashboard') }}" class="bottom-nav-item @if (request()->routeIs('dashboard')) active @endif">
                <span class="bnav-icon">🏠</span> Inicio
            </a>
            <a href="{{ route('profile.show') }}"
                class="bottom-nav-item @if (request()->routeIs('profile.*')) active @endif">
                <span class="bnav-icon">🩺</span> Perfil
            </a>
            <a href="{{ route('contacts.index') }}"
                class="bottom-nav-item @if (request()->routeIs('contacts.*')) active @endif">
                <span class="bnav-icon">👥</span> Contactos
            </a>
            <a href="{{ route('qr.show') }}" class="bottom-nav-item @if (request()->routeIs('qr.*')) active @endif">
                <span class="bnav-icon">📱</span> Mi QR
            </a>
        </div>
    </nav>

    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('sidebarOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js');
        }
    </script>
    @stack('scripts')
</body>

</html>
