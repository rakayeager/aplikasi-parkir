<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Parkir - @yield('title')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --nexa-yellow: #F6CE47;
            --nexa-yellow-dark: #E2BA36;
            --nexa-yellow-card1: #FDE68A;
            --nexa-yellow-card2: #EAB308;
            --nexa-yellow-card3: #FEF9C3;
            --nexa-yellow-card4: #FFFBEB;
            --nexa-black: #18181B;
            --nexa-black-soft: #27272A;
            --nexa-bg: #EEF0F3;
            --sidebar-width: 250px;
            --transition-speed: 0.25s;
        }

        * {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            box-sizing: border-box;
        }

        /* Hilangkan ikon mata bawaan browser Edge / IE */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        /* Plat Nomor Badge (Selalu Horizontal & Utuh) */
        .plat-badge {
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            font-weight: 800;
            letter-spacing: 1.5px;
            padding: 6px 14px;
            border-radius: 8px;
            background: #18181B;
            color: #FCE178;
            display: inline-block;
            white-space: nowrap !important;
            word-break: keep-all !important;
            border: 1px solid rgba(255, 255, 255, 0.15);
            text-align: center;
        }

        body {
            background-color: var(--nexa-bg);
            min-height: 100vh;
            color: var(--nexa-black);
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        /* ===== SIDEBAR KUNING (NEXAVERSE STYLE) ===== */
        .app-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--nexa-yellow);
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform var(--transition-speed) ease;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.04);
            border-right: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Sidebar Brand */
        .sidebar-brand {
            padding: 30px 24px 22px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand .brand-logo-mark {
            width: 44px;
            height: 44px;
            background: var(--nexa-black);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--nexa-yellow);
            font-size: 1.5rem;
            font-weight: 800;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            flex-shrink: 0;
        }

        .sidebar-brand .brand-title {
            color: var(--nexa-black);
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: -0.5px;
            margin: 0;
            line-height: 1.15;
        }

        .sidebar-brand .brand-subtitle {
            font-size: 0.72rem;
            font-weight: 600;
            color: rgba(24, 24, 27, 0.65);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Sidebar Nav Links */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 14px;
        }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.15); border-radius: 4px; }

        .nav-section-label {
            font-size: 0.68rem;
            font-weight: 700;
            color: rgba(24, 24, 27, 0.55);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 12px 14px 6px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            border-radius: 12px;
            color: var(--nexa-black);
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 600;
            transition: all var(--transition-speed) ease;
            margin-bottom: 4px;
        }

        .sidebar-link i {
            font-size: 1.25rem;
            width: 22px;
            text-align: center;
            color: var(--nexa-black);
            transition: transform var(--transition-speed) ease;
        }

        .sidebar-link:hover {
            background: rgba(0, 0, 0, 0.07);
            color: #000;
            transform: translateX(3px);
        }

        .sidebar-link.active {
            background: var(--nexa-black);
            color: #FFFFFF;
            box-shadow: 0 4px 14px rgba(24, 24, 27, 0.25);
        }

        .sidebar-link.active i {
            color: var(--nexa-yellow);
        }

        /* Sidebar Footer / Logout */
        .sidebar-footer {
            padding: 18px 20px 24px;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }

        .sidebar-user-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(0, 0, 0, 0.06);
            padding: 10px 12px;
            border-radius: 12px;
            margin-bottom: 12px;
        }

        .sidebar-user-pill .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--nexa-black);
            color: var(--nexa-yellow);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.95rem;
        }

        .sidebar-user-pill .user-details {
            overflow: hidden;
            flex: 1;
        }

        .sidebar-user-pill .user-name {
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--nexa-black);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-pill .user-role {
            font-size: 0.7rem;
            font-weight: 700;
            color: rgba(24, 24, 27, 0.6);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-sidebar-logout {
            width: 100%;
            background: transparent;
            border: none;
            color: var(--nexa-black);
            padding: 10px 14px;
            font-size: 0.92rem;
            font-weight: 700;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all var(--transition-speed) ease;
            cursor: pointer;
        }

        .btn-sidebar-logout:hover {
            background: rgba(0, 0, 0, 0.1);
            color: #000;
        }

        /* ===== MAIN CONTENT AREA ===== */
        .app-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left var(--transition-speed) ease;
        }

        /* Topbar Header */
        .app-topbar {
            padding: 24px 36px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            background: var(--nexa-bg);
            z-index: 1020;
        }

        .app-topbar .page-header-title {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--nexa-black);
            letter-spacing: -0.6px;
            margin: 0;
        }

        /* Topbar Right Search + Profile */
        .topbar-right-group {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-search-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .topbar-search-box input {
            background-color: var(--nexa-black);
            color: #FFFFFF;
            border: none;
            outline: none;
            border-radius: 9999px;
            padding: 11px 22px 11px 44px;
            font-size: 0.85rem;
            font-weight: 500;
            width: 290px;
            transition: all 0.2s ease;
        }

        .topbar-search-box input::placeholder {
            color: rgba(255, 255, 255, 0.55);
        }

        .topbar-search-box input:focus {
            box-shadow: 0 0 0 3px rgba(246, 206, 71, 0.4);
            width: 320px;
        }

        .topbar-search-box i {
            position: absolute;
            left: 18px;
            color: rgba(255, 255, 255, 0.55);
            font-size: 0.95rem;
            pointer-events: none;
        }

        .topbar-avatar-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: var(--nexa-yellow);
            color: var(--nexa-black);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.2s;
        }

        .topbar-avatar-btn:hover {
            transform: scale(1.05);
        }

        .topbar-mobile-toggle {
            display: none;
            background: var(--nexa-yellow);
            border: none;
            color: var(--nexa-black);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            font-size: 1.35rem;
            cursor: pointer;
        }

        /* Page Content Body */
        .app-content {
            padding: 8px 36px 40px;
            flex: 1;
        }

        /* Global Card Styling (NexaVerse Yellow Theme) */
        .nexa-card {
            background: #FFFFFF;
            border-radius: 20px;
            border: none;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .nexa-card-header {
            padding: 20px 24px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: none;
        }

        .nexa-card-header h5, .nexa-card-header h6 {
            font-weight: 800;
            color: var(--nexa-black);
            margin: 0;
            font-size: 1.1rem;
            letter-spacing: -0.3px;
        }

        .nexa-badge-black {
            background-color: var(--nexa-black);
            color: #FFFFFF;
            border-radius: 9999px;
            padding: 6px 14px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .nexa-btn-yellow {
            background-color: var(--nexa-yellow);
            color: var(--nexa-black);
            border: none;
            border-radius: 9999px;
            padding: 10px 20px;
            font-weight: 700;
            font-size: 0.88rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .nexa-btn-yellow:hover {
            background-color: var(--nexa-yellow-dark);
            color: #000;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(246, 206, 71, 0.4);
        }

        .nexa-btn-black {
            background-color: var(--nexa-black);
            color: #FFFFFF;
            border: none;
            border-radius: 9999px;
            padding: 10px 20px;
            font-weight: 700;
            font-size: 0.88rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .nexa-btn-black:hover {
            background-color: var(--nexa-black-soft);
            color: var(--nexa-yellow);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Toast Messages */
        .toast-container-custom {
            position: fixed;
            top: 24px;
            right: 28px;
            z-index: 1090;
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: min(440px, calc(100vw - 32px));
        }

        .toast-alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            border-radius: 14px;
            font-size: 0.9rem;
            font-weight: 600;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            animation: toastSlideIn 0.35s ease forwards;
            min-width: 0;
            max-width: 440px;
        }

        .toast-success {
            background: #FFFFFF;
            color: #15803D;
            border-left: 6px solid #22C55E;
        }

        .toast-error {
            background: #FFFFFF;
            color: #B91C1C;
            border-left: 6px solid #EF4444;
        }

        .toast-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: #71717A;
            margin-left: auto;
            padding: 0;
            display: flex;
            align-items: center;
        }

        @keyframes toastSlideIn {
            from { opacity: 0; transform: translateX(50px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @keyframes toastSlideOut {
            from { opacity: 1; transform: translateX(0); }
            to   { opacity: 0; transform: translateX(50px); }
        }

        /* Sidebar Overlay for Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1035;
            backdrop-filter: blur(2px);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991.98px) {
            .app-sidebar {
                width: min(290px, 86vw);
                transform: translateX(-100%);
            }

            .app-sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
            }

            .app-main {
                margin-left: 0;
                min-width: 0;
            }

            .topbar-mobile-toggle {
                display: block;
            }

            .app-topbar {
                padding: 18px 20px;
            }

            .topbar-search-box input {
                width: 180px;
            }

            .topbar-search-box input:focus {
                width: 210px;
            }

            .app-content {
                padding: 8px 20px 32px;
            }

            .app-topbar,
            .app-content {
                min-width: 0;
            }
        }

        @media (max-width: 576px) {
            .topbar-search-box {
                display: none;
            }

            .app-topbar {
                gap: 8px;
                padding: 14px 16px;
            }

            .app-topbar > .d-flex {
                flex: 1;
                min-width: 0;
                gap: 10px !important;
            }

            .app-topbar .page-header-title {
                min-width: 0;
                font-size: 1.25rem;
                line-height: 1.25;
                overflow-wrap: anywhere;
            }

            .topbar-right-group {
                flex-shrink: 0;
                gap: 0;
            }

            .topbar-avatar-btn {
                width: 38px;
                height: 38px;
                font-size: 1.1rem;
            }

            .app-content {
                padding: 8px 14px 28px;
            }

            .toast-container-custom {
                top: 12px;
                right: 12px;
                left: 12px;
                width: auto;
            }

            .toast-alert {
                width: 100%;
                padding: 12px 14px;
                font-size: 0.84rem;
            }

            .nexa-card-header {
                flex-wrap: wrap;
                gap: 12px;
                padding: 16px;
            }

            .nexa-card-header > button,
            .nexa-card-header > a {
                max-width: 100%;
            }

            .table-responsive {
                -webkit-overflow-scrolling: touch;
            }

            .modal-dialog {
                margin: 0.5rem;
            }

            .modal-content {
                max-height: calc(100dvh - 1rem);
            }

            .modal-body {
                overflow-y: auto;
                overscroll-behavior: contain;
            }

            .modal-footer {
                flex-wrap: wrap;
                gap: 8px;
            }

            .modal-footer > * {
                margin: 0 !important;
            }

            .nexa-btn-yellow,
            .nexa-btn-black,
            .btn {
                min-height: 42px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    @auth
    {{-- ===== SIDEBAR KUNING NEXAVERSE ===== --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <aside class="app-sidebar" id="appSidebar">
        {{-- Brand Logo --}}
        <div class="sidebar-brand">
            <div class="brand-logo-mark">
                <i class="bi bi-p-circle-fill"></i>
            </div>
            <div>
                <h4 class="brand-title">ParkirVerse</h4>
                <div class="brand-subtitle">Smart Parking System</div>
            </div>
        </div>

        {{-- Navigasi Role-based --}}
        <nav class="sidebar-nav">
            <div class="nav-section-label">Navigasi Utama</div>

            @if(Auth::user()->role === 'owner')
                {{-- Menu Owner --}}
                <a href="{{ route('owner.dashboard') }}" class="sidebar-link {{ Request::routeIs('owner.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('owner.rekap') }}" class="sidebar-link {{ Request::routeIs('owner.rekap') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i>
                    <span>Rekap Transaksi</span>
                </a>
                <a href="{{ route('owner.manajemen-data') }}" class="sidebar-link {{ Request::routeIs('owner.manajemen-data') ? 'active' : '' }}">
                    <i class="bi bi-database-fill-gear"></i>
                    <span>Manajemen Data</span>
                </a>

            @elseif(Auth::user()->role === 'petugas')
                {{-- Menu Petugas --}}
                <a href="{{ route('transaksi.index') }}" class="sidebar-link {{ Request::routeIs('transaksi.index') ? 'active' : '' }}">
                    <i class="bi bi-p-square-fill"></i>
                    <span>Loket Parkir</span>
                </a>
                <a href="{{ route('transaksi.masuk.form') }}" class="sidebar-link {{ Request::routeIs('transaksi.masuk.form') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Masuk Kendaraan</span>
                </a>

            @elseif(Auth::user()->role === 'admin')
                {{-- Menu Admin --}}
                <a href="{{ route('admin.user') }}" class="sidebar-link {{ Request::routeIs('admin.user') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Kelola Pengguna</span>
                </a>
                <a href="{{ route('admin.tarif') }}" class="sidebar-link {{ Request::routeIs('admin.tarif') ? 'active' : '' }}">
                    <i class="bi bi-cash-coin"></i>
                    <span>Tarif Parkir</span>
                </a>
                <a href="{{ route('admin.area') }}" class="sidebar-link {{ Request::routeIs('admin.area') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Area Parkir</span>
                </a>
                <a href="{{ route('admin.kendaraan') }}" class="sidebar-link {{ Request::routeIs('admin.kendaraan') ? 'active' : '' }}">
                    <i class="bi bi-car-front-fill"></i>
                    <span>Master Kendaraan</span>
                </a>
                <a href="{{ route('admin.log') }}" class="sidebar-link {{ Request::routeIs('admin.log') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Log Aktivitas</span>
                </a>
            @endif
        </nav>

        {{-- Sidebar Footer --}}
        <div class="sidebar-footer">
            <div class="sidebar-user-pill">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                </div>
                <div class="user-details">
                    <div class="user-name">{{ Auth::user()->nama_lengkap }}</div>
                    <div class="user-role">{{ strtoupper(Auth::user()->role) }}</div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-sidebar-logout">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Log out</span>
                </button>
            </form>
        </div>
    </aside>
    @endauth

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="app-main">
        @auth
        {{-- Topbar Header (NexaVerse Style) --}}
        <header class="app-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="topbar-mobile-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="page-header-title">@yield('title')</h1>
            </div>

            <div class="topbar-right-group">
                {{-- Search Bar Kapsul Hitam --}}
                <div class="topbar-search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Cari transaksi, plat, area..." id="globalSearchInput">
                </div>

                {{-- User Avatar Bulat Kuning --}}
                <div class="topbar-avatar-btn" title="{{ Auth::user()->nama_lengkap }}">
                    <i class="bi bi-person-fill"></i>
                </div>
            </div>
        </header>
        @endauth

        {{-- Flash Messages Toast --}}
        <div class="toast-container-custom" id="toastContainer">
            @if(session('success'))
                <div class="toast-alert toast-success" role="alert">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <span>{{ session('success') }}</span>
                    <button class="toast-close" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>
                </div>
            @endif
            @if(session('error'))
                <div class="toast-alert toast-error" role="alert">
                    <i class="bi bi-exclamation-circle-fill fs-5"></i>
                    <span>{{ session('error') }}</span>
                    <button class="toast-close" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>
                </div>
            @endif
        </div>

        {{-- Isi Halaman --}}
        <main class="app-content">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function() {
            // Mobile Sidebar Toggle
            const sidebar = document.getElementById('appSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggle  = document.getElementById('sidebarToggle');

            if (toggle && sidebar && overlay) {
                toggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                });
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }

            // Auto dismiss toast
            document.querySelectorAll('.toast-alert').forEach(function(toast) {
                setTimeout(function() {
                    toast.style.animation = 'toastSlideOut 0.35s ease forwards';
                    setTimeout(function() { toast.remove(); }, 350);
                }, 5000);
            });
        })();
    </script>
    @yield('scripts')
</body>
</html>