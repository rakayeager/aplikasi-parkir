<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ParkirVerse</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --nexa-yellow: #F6CE47;
            --nexa-yellow-dark: #E2B734;
            --nexa-black: #18181B;
            --nexa-bg: #EEF0F3;
        }

        * {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background-color: var(--nexa-bg);
            margin: 0;
            padding: 0;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* Left Branding Panel (Kuning NexaVerse) */
        .brand-panel {
            flex: 1.25;
            background-color: var(--nexa-yellow);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 50px 40px;
            position: relative;
            overflow: hidden;
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            width: 480px;
            height: 480px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            top: -120px;
            right: -120px;
            pointer-events: none;
        }

        .brand-panel::after {
            content: '';
            position: absolute;
            width: 320px;
            height: 320px;
            background: rgba(0, 0, 0, 0.04);
            border-radius: 50%;
            bottom: -80px;
            left: -80px;
            pointer-events: none;
        }

        .brand-icon {
            width: 76px;
            height: 76px;
            background: var(--nexa-black);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
            z-index: 1;
        }

        .brand-icon i {
            font-size: 2.5rem;
            color: var(--nexa-yellow);
        }

        .brand-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--nexa-black);
            margin-bottom: 6px;
            letter-spacing: -1px;
            text-align: center;
            z-index: 1;
        }

        .brand-subtitle {
            font-size: 0.92rem;
            font-weight: 600;
            color: rgba(24, 24, 27, 0.75);
            text-align: center;
            max-width: 420px;
            line-height: 1.5;
            margin-bottom: 28px;
            z-index: 1;
        }

        /* ===== WIDGET MONITORING SLOT PARKIR LIQUID GLASS STYLE ===== */
        .liquid-glass-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.58) 0%, rgba(255, 255, 255, 0.28) 100%);
            backdrop-filter: blur(24px) saturate(190%);
            -webkit-backdrop-filter: blur(24px) saturate(190%);
            border: 1.5px solid rgba(255, 255, 255, 0.8);
            border-radius: 28px;
            padding: 24px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08), 
                        inset 0 1px 2px rgba(255, 255, 255, 0.95), 
                        inset 0 -1px 2px rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Efek Shimmer Kilau Permukaan Kaca Cair (Liquid Sheen) */
        .liquid-glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 48%;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.45) 0%, rgba(255, 255, 255, 0.02) 100%);
            border-radius: 28px 28px 120% 120%;
            pointer-events: none;
        }

        .liquid-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            position: relative;
            z-index: 2;
        }

        .liquid-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--nexa-black);
            margin: 0;
            letter-spacing: -0.4px;
        }

        .liquid-subtitle {
            font-size: 0.76rem;
            font-weight: 600;
            color: rgba(24, 24, 27, 0.7);
            margin-top: 2px;
        }

        .liquid-realtime-badge {
            background: rgba(24, 24, 27, 0.88);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            color: #FFFFFF;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 6px 13px;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .pulse-dot {
            width: 7px;
            height: 7px;
            background-color: #22C55E;
            border-radius: 50%;
            box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.4);
            animation: pulseAnimation 1.6s infinite;
        }

        @keyframes pulseAnimation {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }

        /* Grid Dua Area Parkir: Motor & Mobil */
        .liquid-grid-areas {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
            margin-bottom: 16px;
            position: relative;
            z-index: 2;
        }

        .liquid-area-tile {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.82) 0%, rgba(255, 255, 255, 0.48) 100%);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1.5px solid rgba(255, 255, 255, 0.9);
            border-radius: 22px;
            padding: 18px 16px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.05), inset 0 1px 2px rgba(255, 255, 255, 0.95);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .liquid-area-tile:hover {
            transform: translateY(-3px);
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.92) 0%, rgba(255, 255, 255, 0.6) 100%);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.08), inset 0 1px 3px rgba(255, 255, 255, 1);
            border-color: #FFFFFF;
        }

        .liquid-tile-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .liquid-icon-bubble {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06), inset 0 1px 1px rgba(255, 255, 255, 0.9);
        }

        .bubble-motor {
            background: linear-gradient(135deg, #FEF08A 0%, #FDE047 100%);
            color: #854D0E;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .bubble-mobil {
            background: linear-gradient(135deg, #18181B 0%, #27272A 100%);
            color: #FCE178;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .liquid-status-badge {
            font-size: 0.68rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 9999px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .badge-tersedia {
            background: rgba(34, 197, 94, 0.15);
            color: #15803D;
            border: 1px solid rgba(34, 197, 94, 0.35);
        }

        .badge-penuh {
            background: rgba(239, 68, 68, 0.15);
            color: #B91C1C;
            border: 1px solid rgba(239, 68, 68, 0.35);
        }

        .liquid-area-label {
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--nexa-black);
            letter-spacing: -0.2px;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .liquid-slot-hero {
            margin-bottom: 12px;
        }

        .liquid-slot-number {
            font-size: 2.15rem;
            font-weight: 900;
            color: var(--nexa-black);
            line-height: 1;
            letter-spacing: -1px;
        }

        .liquid-slot-unit {
            font-size: 0.85rem;
            font-weight: 700;
            color: #52525B;
            margin-left: 3px;
        }

        .liquid-slot-sub {
            font-size: 0.72rem;
            font-weight: 600;
            color: #71717A;
            margin-top: 4px;
        }

        /* Glass Progress Bar */
        .liquid-progress-container {
            background: rgba(0, 0, 0, 0.06);
            height: 6px;
            border-radius: 9999px;
            overflow: hidden;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.5);
            margin-bottom: 6px;
        }

        .liquid-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #E2B734 0%, #F59E0B 100%);
            border-radius: 9999px;
            transition: width 0.4s ease;
            box-shadow: 0 0 6px rgba(226, 183, 52, 0.35);
        }

        .liquid-progress-text {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.7rem;
            font-weight: 700;
            color: #71717A;
        }

        .slot-percent-badge {
            background-color: #FCE178;
            color: var(--nexa-black);
            font-size: 0.72rem;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 6px;
        }

        /* Footer Liquid Ringkasan */
        .liquid-footer {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.85);
            border-radius: 16px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.76rem;
            font-weight: 700;
            color: var(--nexa-black);
        }

        /* Right Form Panel */
        .form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: #FFFFFF;
        }

        .login-card {
            width: 100%;
            max-width: 390px;
        }

        .login-card h2 {
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--nexa-black);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-card p.subtitle {
            color: #71717A;
            font-size: 0.95rem;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--nexa-black);
            margin-bottom: 8px;
            display: block;
        }

        .input-icon-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-wrapper > i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #71717A;
            font-size: 1.15rem;
            pointer-events: none;
            z-index: 2;
        }

        .input-icon-wrapper input {
            width: 100%;
            padding: 13px 48px 13px 48px;
            border: 2px solid #E4E4E7;
            border-radius: 14px;
            font-size: 0.95rem;
            transition: all 0.2s;
            background: #FAFAFA;
            font-weight: 600;
        }

        .input-icon-wrapper input:focus {
            outline: none;
            border-color: var(--nexa-yellow-dark);
            background: #FFFFFF;
            box-shadow: 0 0 0 4px rgba(246, 206, 71, 0.35);
        }

        /* Hilangkan ikon mata bawaan browser Edge / Internet Explorer */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
        }

        /* Hilangkan ikon autofill bawaan WebKit */
        input[type="password"]::-webkit-credentials-auto-fill-button,
        input[type="password"]::-webkit-contacts-auto-fill-button {
            visibility: hidden !important;
            pointer-events: none !important;
            display: none !important;
        }

        .input-icon-wrapper input.input-error {
            border-color: #EF4444 !important;
            background-color: #FEF2F2 !important;
        }

        .input-icon-wrapper input.input-error:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.25) !important;
        }

        @keyframes inputShake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }

        .animate-shake {
            animation: inputShake 0.4s ease-in-out;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #71717A;
            cursor: pointer;
            font-size: 1.15rem;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            line-height: 1;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--nexa-black);
        }

        .password-toggle i {
            position: static !important;
            transform: none !important;
            font-size: 1.15rem;
            line-height: 1;
            display: block;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: var(--nexa-yellow);
            border: none;
            border-radius: 9999px;
            color: var(--nexa-black);
            font-size: 1rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: var(--nexa-yellow-dark);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(246, 206, 71, 0.45);
        }

        .test-creds {
            margin-top: 26px;
            padding: 16px 18px;
            background: #FEF9C3;
            border-radius: 14px;
            border: 1px solid #FEF08A;
        }

        .test-creds .label {
            font-size: 0.75rem;
            font-weight: 800;
            color: #854D0E;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .test-creds .creds {
            font-size: 0.85rem;
            color: #713F12;
            line-height: 1.6;
            font-weight: 600;
        }

        .test-creds code {
            background: rgba(0, 0, 0, 0.08);
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.85rem;
            color: #18181B;
            font-weight: 700;
        }

        @media (max-width: 992px) {
            .login-wrapper {
                flex-direction: column;
            }
            .brand-panel {
                padding: 40px 24px;
                min-height: auto;
            }
            .brand-title { font-size: 1.85rem; }
            .brand-subtitle { margin-bottom: 20px; font-size: 0.88rem; }
            .slot-monitoring-card { max-width: 100%; }
            .form-panel {
                padding: 36px 24px;
            }
        }

        @media (max-width: 576px) {
            .brand-panel {
                padding: 32px 16px;
            }

            .brand-title {
                font-size: 1.6rem;
            }

            .brand-subtitle {
                font-size: 0.82rem;
            }

            .liquid-glass-card {
                padding: 18px 16px;
                border-radius: 20px;
            }

            .liquid-header {
                align-items: flex-start;
                gap: 8px;
            }

            .liquid-title {
                font-size: 1rem;
            }

            .liquid-grid-areas {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .form-panel {
                padding: 32px 16px;
            }

            .login-card h2 {
                font-size: 1.55rem;
            }

            .login-card p.subtitle {
                margin-bottom: 22px;
            }

            .test-creds {
                padding: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Panel Kiri Branding Kuning NexaVerse dengan Monitoring Slot Real-time -->
        <div class="brand-panel">
            <div class="brand-icon">
                <i class="bi bi-p-circle-fill"></i>
            </div>
            <h1 class="brand-title">ParkirVerse</h1>
            <p class="brand-subtitle">Platform digital manajemen parkir modern, cepat, transparan, dan terintegrasi.</p>

            <!-- Card Monitoring Slot Area Parkir (Liquid Glass Style) -->
            <div class="liquid-glass-card">
                <div class="liquid-header">
                    <div>
                        <h5 class="liquid-title">Monitoring Slot Parkir</h5>
                        <div class="liquid-subtitle">Status sisa slot ruang parkir saat ini</div>
                    </div>
                    <span class="liquid-realtime-badge">
                        <span class="pulse-dot"></span> Real-time
                    </span>
                </div>

                <div class="liquid-grid-areas" id="slotListContainer">
                    @forelse($areas as $area)
                    @php
                        $isMotor = stripos($area->nama_area, 'motor') !== false;
                        $persen = $area->kapasitas > 0 ? round(($area->terisi / $area->kapasitas) * 100) : 0;
                        $sisa = max(0, $area->kapasitas - $area->terisi);
                        $isFull = $sisa <= 0;
                    @endphp
                    <div class="liquid-area-tile" id="area-card-{{ $area->id_area }}">
                        <div class="liquid-tile-top">
                            <div class="liquid-icon-bubble {{ $isMotor ? 'bubble-motor' : 'bubble-mobil' }}">
                                @if($isMotor)
                                    <i class="bi bi-bicycle"></i>
                                @else
                                    <i class="bi bi-car-front-fill"></i>
                                @endif
                            </div>
                            <span class="liquid-status-badge {{ $isFull ? 'badge-penuh' : 'badge-tersedia' }}">
                                {{ $isFull ? 'Penuh' : 'Tersedia' }}
                            </span>
                        </div>

                        <div class="liquid-area-label" title="{{ $area->nama_area }}">
                            {{ $area->nama_area }}
                        </div>

                        <div class="liquid-slot-hero">
                            <div class="liquid-slot-number">
                                <span class="val-sisa">{{ $sisa }}</span>
                                <span class="liquid-slot-unit">Slot Sisa</span>
                            </div>
                            <div class="liquid-slot-sub">
                                dari <b class="val-kapasitas">{{ $area->kapasitas }}</b> total kapasitas
                            </div>
                        </div>

                        <div>
                            <div class="liquid-progress-container">
                                <div class="liquid-progress-bar" style="width: {{ $persen }}%;"></div>
                            </div>
                            <div class="liquid-progress-text">
                                <span>Terisi: <b class="val-terisi">{{ $area->terisi }}</b></span>
                                <span class="slot-percent-badge">{{ $persen }}%</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-3 text-muted small" style="grid-column: 1 / -1;">
                        Belum ada area parkir yang terdaftar.
                    </div>
                    @endforelse
                </div>

                <div class="liquid-footer">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-shield-check text-success"></i>
                        <span>Total Tersedia: <b id="countTersedia" class="text-dark">{{ $totalTersedia }}</b> Slot</span>
                    </div>
                    <span class="text-muted" style="font-size: 0.72rem;">Kapasitas: <b id="countTotal">{{ $totalKapasitas }}</b></span>
                </div>
            </div>
        </div>

        <!-- Panel Kanan Form Login -->
        <div class="form-panel">
            <div class="login-card">
                <h2>Selamat Datang! 👋</h2>
                <p class="subtitle">Masuk ke akun Anda untuk mulai mengelola</p>

                @if(session('error') || $errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 py-3 px-4 d-flex align-items-center gap-3 animate-shake" style="background: #FEF2F2; color: #991B1B; border-left: 5px solid #EF4444 !important;">
                        <div style="width: 38px; height: 38px; border-radius: 50%; background: #FEE2E2; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold" style="font-size: 0.95rem;">Login Gagal</div>
                            <div style="font-size: 0.85rem; font-weight: 600;">
                                {{ session('error') ?? ($errors->first('password') ?? ($errors->first('username') ?? $errors->first())) }}
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 py-3 px-4 d-flex align-items-center gap-3" style="background: #ECFDF5; color: #065F46; border-left: 5px solid #10B981 !important;">
                        <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                        <span style="font-weight: 600; font-size: 0.88rem;">{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Username</label>
                        <div class="input-icon-wrapper">
                            <i class="bi bi-person"></i>
                            <input type="text" name="username" value="{{ old('username') }}" required autofocus placeholder="Masukkan username" class="{{ $errors->has('username') ? 'input-error animate-shake' : '' }}">
                        </div>
                        @if($errors->has('username'))
                            <div class="text-danger mt-1 ms-1 d-flex align-items-center gap-1" style="font-size: 0.8rem; font-weight: 700;">
                                <i class="bi bi-x-circle-fill"></i>
                                <span>{{ $errors->first('username') }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-icon-wrapper">
                            <i class="bi bi-lock"></i>
                            <input type="password" name="password" id="passwordInput" required placeholder="Masukkan password" class="{{ ($errors->has('password') || session('error')) ? 'input-error animate-shake' : '' }}">
                            <button type="button" class="password-toggle" onclick="togglePassword()" tabindex="-1">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @if($errors->has('password'))
                            <div class="text-danger mt-1 ms-1 d-flex align-items-center gap-1" style="font-size: 0.8rem; font-weight: 700;">
                                <i class="bi bi-x-circle-fill"></i>
                                <span>{{ $errors->first('password') }}</span>
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn-login">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Masuk Sekarang
                    </button>
                </form>

                <div class="test-creds">
                    <div class="label"><i class="bi bi-info-circle-fill me-1"></i> Akun Pengujian</div>
                    <div class="creds">
                        Username: <code>owner1</code> / <code>petugas1</code> / <code>admin1</code><br>
                        Password: <code>role+123</code>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        // Live polling update status slot area parkir setiap 3 detik
        function updateLiveSlots() {
            fetch("{{ route('api.monitoring-slot') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const countTotalEl = document.getElementById('countTotal');
                        const countTersediaEl = document.getElementById('countTersedia');

                        if (countTotalEl) countTotalEl.innerText = data.total_kapasitas;
                        if (countTersediaEl) countTersediaEl.innerText = data.total_tersedia;

                        if (data.areas && Array.isArray(data.areas)) {
                            data.areas.forEach(area => {
                                const card = document.getElementById('area-card-' + area.id_area);
                                if (card) {
                                    const valTerisi = card.querySelector('.val-terisi');
                                    const valSisa = card.querySelector('.val-sisa');
                                    const valKapasitas = card.querySelector('.val-kapasitas');
                                    const bar = card.querySelector('.liquid-progress-bar');
                                    const badge = card.querySelector('.slot-percent-badge');
                                    const statusBadge = card.querySelector('.liquid-status-badge');

                                    if (valTerisi) valTerisi.innerText = area.terisi;
                                    if (valSisa) valSisa.innerText = area.sisa;
                                    if (valKapasitas) valKapasitas.innerText = area.kapasitas;
                                    if (bar) bar.style.width = area.persen + '%';
                                    if (badge) badge.innerText = area.persen + '%';
                                    if (statusBadge) {
                                        const isFull = area.sisa <= 0;
                                        statusBadge.className = 'liquid-status-badge ' + (isFull ? 'badge-penuh' : 'badge-tersedia');
                                        statusBadge.innerText = isFull ? 'Penuh' : 'Tersedia';
                                    }
                                }
                            });
                        }
                    }
                })
                .catch(err => {
                    // Fail silently on network glitch
                });
        }

        // Jalankan polling setiap 3 detik
        setInterval(updateLiveSlots, 3000);
    </script>
</body>
</html>