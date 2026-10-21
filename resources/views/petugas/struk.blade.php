<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karcis Parkir #{{ $transaksi->id_parkir }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 14px;
            background-color: #EEF0F3;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 16px;
        }

        .receipt-container {
            width: min(340px, 100%);
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            position: relative;
        }

        .receipt-header {
            background-color: #F6CE47;
            padding: 28px 24px 24px;
            text-align: center;
            position: relative;
            color: #18181B;
        }

        .parking-icon {
            width: 56px;
            height: 56px;
            background: #18181B;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .parking-icon i {
            font-size: 1.8rem;
            color: #F6CE47;
        }

        .receipt-title {
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: -0.3px;
            margin-bottom: 2px;
        }

        .receipt-subtitle {
            font-size: 0.75rem;
            color: rgba(24, 24, 27, 0.7);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .receipt-body {
            padding: 24px 20px 20px;
        }

        .ticket-badge {
            background-color: #FEF9C3;
            border: 1px solid #FEF08A;
            border-radius: 12px;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .ticket-badge .label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #854D0E;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .ticket-badge .id {
            font-size: 1.1rem;
            font-weight: 800;
            color: #18181B;
            letter-spacing: -0.3px;
        }

        .plate-box {
            background: #18181B;
            color: #F6CE47;
            border-radius: 12px;
            padding: 12px 16px;
            text-align: center;
            margin-bottom: 20px;
        }

        .plate-box .label {
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }

        .plate-box .number {
            font-family: monospace;
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 16px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px dashed #E4E4E7;
            font-size: 0.82rem;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #71717A;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-label i {
            color: #E2B734;
        }

        .info-value {
            font-weight: 700;
            color: #18181B;
            text-align: right;
        }

        .total-box {
            background-color: #FCE178;
            border-radius: 14px;
            padding: 14px 18px;
            margin-top: 14px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .total-box .total-label {
            font-size: 0.8rem;
            font-weight: 800;
            color: #18181B;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .total-box .total-amount {
            font-size: 1.35rem;
            font-weight: 800;
            color: #18181B;
            letter-spacing: -0.5px;
        }

        .receipt-footer {
            text-align: center;
            padding-top: 12px;
            border-top: 1px dashed #E4E4E7;
        }

        .receipt-footer p {
            font-size: 0.72rem;
            color: #A1A1AA;
            line-height: 1.5;
        }

        .btn-action-group {
            padding: 0 20px 24px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .btn-print {
            width: 100%;
            background-color: #F6CE47;
            color: #18181B;
            border: none;
            border-radius: 9999px;
            padding: 12px;
            font-size: 0.9rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-print:hover {
            background-color: #E2B734;
            transform: translateY(-1px);
        }

        .btn-back {
            width: 100%;
            background: #F4F4F5;
            color: #71717A;
            border: none;
            border-radius: 9999px;
            padding: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-back:hover {
            background: #E4E4E7;
            color: #18181B;
        }

        @media (max-width: 360px) {
            body {
                padding: 10px;
            }

            .receipt-header {
                padding: 22px 16px 20px;
            }

            .receipt-body {
                padding: 18px 14px 16px;
            }

            .total-box {
                padding: 12px;
                gap: 8px;
            }

            .total-box .total-amount {
                font-size: 1.15rem;
                text-align: right;
                overflow-wrap: anywhere;
            }
        }

        @media print {
            body { background: #fff; padding: 0; }
            .receipt-container { box-shadow: none; border-radius: 0; width: 100%; }
            .btn-action-group { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header Karcis -->
        <div class="receipt-header">
            <div class="parking-icon">
                <i class="bi bi-p-circle-fill"></i>
            </div>
            <div class="receipt-title">ParkirVerse</div>
            <div class="receipt-subtitle">Bukti Karcis Parkir Resmi</div>
        </div>

        <!-- Isi Karcis -->
        <div class="receipt-body">
            <div class="ticket-badge">
                <span class="label">ID Tiket</span>
                <span class="id">#{{ $transaksi->id_parkir }}</span>
            </div>

            <div class="plate-box">
                <div class="label">Nomor Kendaraan</div>
                <div class="number">{{ $transaksi->kendaraan->plat_nomor }}</div>
            </div>

            <div class="info-table">
                <div class="info-row">
                    <span class="info-label"><i class="bi bi-person"></i> Petugas</span>
                    <span class="info-value">{{ $transaksi->petugas->nama_lengkap ?? 'Petugas' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="bi bi-geo-alt"></i> Area</span>
                    <span class="info-value">{{ $transaksi->area->nama_area }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="bi bi-box-arrow-in-right"></i> Masuk</span>
                    <span class="info-value">{{ $transaksi->waktu_masuk }}</span>
                </div>
                @if($transaksi->status === 'keluar')
                <div class="info-row">
                    <span class="info-label"><i class="bi bi-box-arrow-right"></i> Keluar</span>
                    <span class="info-value">{{ $transaksi->waktu_keluar }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="bi bi-hourglass-split"></i> Durasi</span>
                    <span class="info-value">{{ $transaksi->durasi_jam }} Jam</span>
                </div>
                @endif
            </div>

            @if($transaksi->status === 'keluar')
            <div class="total-box">
                <span class="total-label">Total Biaya</span>
                <span class="total-amount">Rp {{ number_format($transaksi->biaya_total) }}</span>
            </div>
            @endif

            <div class="receipt-footer">
                <p>Simpan tiket ini dengan baik.<br>Kehilangan tiket dikenakan denda sesuai ketentuan.</p>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="btn-action-group">
            <button type="button" class="btn-print" onclick="window.print()">
                <i class="bi bi-printer-fill"></i> Cetak Karcis
            </button>
            <a href="{{ route('transaksi.index') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Loket
            </a>
        </div>
    </div>
</body>
</html>