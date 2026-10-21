@extends('layouts.app')
@section('title', 'Rekap Transaksi')

@section('styles')
<style>
    @media (max-width: 576px) {
        .rekap-summary-card {
            gap: 12px;
            padding: 18px !important;
        }

        .rekap-summary-card h2 {
            font-size: 1.55rem !important;
            overflow-wrap: anywhere;
        }

        .rekap-table-header {
            flex-wrap: wrap;
            gap: 12px;
        }

        .rekap-table-header > div {
            min-width: 0;
            overflow-wrap: anywhere;
        }

        .rekap-table-header button {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')

{{-- Filter Tanggal (NexaVerse Style) --}}
<div class="nexa-card p-4 mb-4">
    <form method="GET" action="{{ route('owner.rekap') }}" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">
                <i class="bi bi-calendar-event me-1"></i>Tanggal Mulai
            </label>
            <input type="date" name="tgl_mulai" class="form-control" value="{{ $tglMulai }}"
                   style="border-radius: 12px; border: 2px solid #E4E4E7; padding: 11px 16px; font-weight: 600;">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">
                <i class="bi bi-calendar-check me-1"></i>Tanggal Akhir
            </label>
            <input type="date" name="tgl_akhir" class="form-control" value="{{ $tglAkhir }}"
                   style="border-radius: 12px; border: 2px solid #E4E4E7; padding: 11px 16px; font-weight: 600;">
        </div>
        <div class="col-md-4">
            <button type="submit" class="nexa-btn-yellow w-100" style="padding: 12px;">
                <i class="bi bi-funnel-fill"></i> Terapkan Filter
            </button>
        </div>
    </form>
</div>

{{-- Top 2 Summary Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="rekap-summary-card p-4 rounded-4 d-flex align-items-center justify-content-between" style="background-color: #FCE178; color: #18181B; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
            <div>
                <span class="text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.8px; opacity: 0.85;">Total Kendaraan Selesai</span>
                <h2 class="fw-bold mb-0 mt-1" style="font-size: 2.2rem; letter-spacing: -0.5px;">{{ number_format($totalKendaraan) }} <span style="font-size: 1.1rem; font-weight: 600;">Unit</span></h2>
            </div>
            <div style="width: 56px; height: 56px; background: rgba(24, 24, 27, 0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">
                <i class="bi bi-car-front-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="rekap-summary-card p-4 rounded-4 d-flex align-items-center justify-content-between" style="background-color: #E2B734; color: #18181B; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
            <div>
                <span class="text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.8px; opacity: 0.85;">Total Pendapatan Parkir</span>
                <h2 class="fw-bold mb-0 mt-1" style="font-size: 2.2rem; letter-spacing: -0.5px;">Rp {{ number_format($totalPendapatan) }}</h2>
            </div>
            <div style="width: 56px; height: 56px; background: rgba(24, 24, 27, 0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;">
                <i class="bi bi-wallet2"></i>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Detail Transaksi --}}
<div class="nexa-card overflow-hidden">
    <div class="nexa-card-header rekap-table-header bg-white p-4 d-flex align-items-center justify-content-between border-bottom">
        <div>
            <h5 class="mb-1 fw-bold text-dark">Rincian Transaksi Selesai</h5>
            <small class="text-muted">Periode: {{ \Carbon\Carbon::parse($tglMulai)->translatedFormat('d M Y') }} s/d {{ \Carbon\Carbon::parse($tglAkhir)->translatedFormat('d M Y') }}</small>
        </div>
        <button onclick="window.print()" class="nexa-btn-black">
            <i class="bi bi-printer-fill"></i> Cetak Laporan
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #FAFAFA;">
                    <tr>
                        <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Plat Nomor</th>
                        <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Area Parkir</th>
                        <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Waktu Masuk</th>
                        <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Waktu Keluar</th>
                        <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Durasi</th>
                        <th class="py-3 px-4 text-uppercase text-secondary text-end" style="font-size: 0.75rem; font-weight: 700;">Biaya Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $t)
                    <tr>
                        <td class="py-3 px-4">
                            <span class="badge bg-dark text-warning fs-6 px-3 py-2" style="font-family: monospace; border-radius: 8px;">
                                {{ $t->kendaraan->plat_nomor }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <i class="bi bi-geo-alt-fill text-warning me-1"></i>
                            <span class="fw-semibold text-dark">{{ $t->area->nama_area }}</span>
                        </td>
                        <td class="py-3 px-4 text-secondary small">{{ $t->waktu_masuk }}</td>
                        <td class="py-3 px-4 text-secondary small">{{ $t->waktu_keluar }}</td>
                        <td class="py-3 px-4">
                            <span class="badge" style="background: #FEF3C7; color: #92400E; border-radius: 9999px; padding: 6px 12px; font-weight: 700;">
                                {{ $t->durasi_jam }} Jam
                            </span>
                        </td>
                        <td class="py-3 px-4 text-end">
                            <span class="fw-bold fs-6" style="color: #18181B;">
                                Rp {{ number_format($t->biaya_total) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-warning"></i>
                            <span class="fw-semibold">Tidak ada transaksi pada periode yang dipilih.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection