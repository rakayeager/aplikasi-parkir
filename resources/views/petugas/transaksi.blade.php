@extends('layouts.app')
@section('title', 'Loket Parkir')

@section('styles')
<style>
    .parking-summary-box {
        background-color: #FCE178;
        color: #18181B;
        border-radius: 18px;
        padding: 16px 22px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        position: relative;
        overflow: hidden;
    }

    .btn-action-masuk {
        background-color: #18181B;
        color: #FCE178;
        border-radius: 9999px;
        padding: 9px 18px;
        font-weight: 800;
        font-size: 0.84rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 2px solid #18181B;
    }

    .btn-action-masuk:hover {
        background-color: #000000;
        color: #FFFFFF;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    }

    .table-search-input {
        border-radius: 9999px;
        border: 2px solid #E4E4E7;
        padding: 7px 16px 7px 34px;
        font-size: 0.82rem;
        font-weight: 600;
        background: #FAFAFA;
        transition: all 0.2s ease;
        width: 230px;
    }

    .table-search-input:focus {
        outline: none;
        border-color: #E2B734;
        background: #FFFFFF;
        box-shadow: 0 0 0 3px rgba(226, 183, 52, 0.2);
    }

    .plat-badge {
        font-family: 'JetBrains Mono', 'Courier New', monospace;
        font-weight: 800;
        font-size: 0.82rem;
        letter-spacing: 1px;
        padding: 4px 10px;
        border-radius: 6px;
        background: #18181B;
        color: #FCE178;
        display: inline-block;
        white-space: nowrap !important;
        word-break: keep-all !important;
        border: 1px solid rgba(255, 255, 255, 0.15);
        text-align: center;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.12);
        line-height: 1.4;
    }

    @media (max-width: 768px) {
        .parking-summary-box {
            padding: 20px;
            flex-direction: column;
            align-items: flex-start !important;
            gap: 16px;
        }

        .btn-action-masuk {
            width: 100%;
            justify-content: center;
        }

        .table-search-input {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')

{{-- ===== SUMMARY BAR KUNING (FULL WIDTH COMPACT) ===== --}}
<div class="row mb-3">
    <div class="col-12">
        <div class="parking-summary-box d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: rgba(24, 24, 27, 0.08); border-radius: 12px;">
                    <i class="bi bi-car-front-fill" style="font-size: 1.45rem; color: #18181B;"></i>
                </div>
                <div>
                    <span class="text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.7px; opacity: 0.85;">KENDARAAN TERPARKIR SAAT INI</span>
                    <h3 class="mb-0 fw-bold" style="letter-spacing: -0.5px; font-size: 1.45rem;">
                        <span id="totalKendaraanCount">{{ $transaksis->count() }}</span>
                        <span style="font-size: 0.95rem; font-weight: 600;">Kendaraan</span>
                    </h3>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-dark text-warning px-3 py-2 rounded-pill d-none d-lg-inline-flex align-items-center gap-2" style="font-size: 0.76rem; font-weight: 700;">
                    <span style="width: 6px; height: 6px; background-color: #22C55E; border-radius: 50%; display: inline-block;"></span>
                    Loket Operasional Aktif
                </span>

                <a href="{{ route('transaksi.masuk.form') }}" class="btn-action-masuk">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Masuk Kendaraan Baru</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12 col-md-6 col-xl-4">
        <div class="nexa-card p-3 p-sm-4 d-flex align-items-center gap-3 h-100">
            <div class="d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background: #DCFCE7; border-radius: 12px; color: #15803D; font-size: 1.25rem;">
                <i class="bi bi-wallet2"></i>
            </div>
            <div class="min-w-0">
                <div class="text-secondary text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Pendapatan Saya</div>
                <div class="fw-bold text-dark" style="font-size: 1.25rem; overflow-wrap: anywhere;">Rp {{ number_format($totalPendapatanPetugas) }}</div>
                <small class="text-muted">Total dari transaksi selesai</small>
            </div>
        </div>
    </div>
</div>

{{-- ===== TABEL DAFTAR KENDARAAN DI LOKASI (FULL WIDTH) ===== --}}
<div class="row">
    <div class="col-12">
        <div class="nexa-card overflow-hidden">
            <div class="p-3 px-4 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3" style="background: #FAFAFA;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 32px; height: 32px; background: #FCE178; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1rem; color: #18181B;">
                        <i class="bi bi-p-square-fill"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark" style="letter-spacing: -0.3px;">Daftar Kendaraan di Lokasi</h6>
                        <small class="text-muted" style="font-size: 0.75rem;">{{ $transaksis->count() }} unit aktif sedang berada di area parkir</small>
                    </div>
                </div>

                {{-- Pencarian Cepat di Tabel --}}
                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 0.8rem;"></i>
                    <input type="text" id="filterLokasiInput" class="table-search-input" placeholder="Cari plat, area, tipe...">
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="tabelKendaraanLokasi">
                        <thead style="background: #FAFAFA;">
                            <tr>
                                <th class="py-2.5 px-3 text-uppercase text-secondary text-nowrap" style="font-size: 0.72rem; font-weight: 700;">No. Karcis</th>
                                <th class="py-2.5 px-3 text-uppercase text-secondary text-nowrap" style="font-size: 0.72rem; font-weight: 700;">Plat Nomor</th>
                                <th class="py-2.5 px-3 text-uppercase text-secondary text-nowrap" style="font-size: 0.72rem; font-weight: 700;">Model Kendaraan</th>
                                <th class="py-2.5 px-3 text-uppercase text-secondary text-nowrap" style="font-size: 0.72rem; font-weight: 700;">Tarif / Jam</th>
                                <th class="py-2.5 px-3 text-uppercase text-secondary text-nowrap" style="font-size: 0.72rem; font-weight: 700;">Area Parkir</th>
                                <th class="py-2.5 px-3 text-uppercase text-secondary text-nowrap" style="font-size: 0.72rem; font-weight: 700;">Waktu Masuk</th>
                                <th class="py-2.5 px-3 text-uppercase text-secondary text-end text-nowrap" style="font-size: 0.72rem; font-weight: 700;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $trx)
                            <tr class="trx-row">
                                <td class="py-2.5 px-3 fw-bold text-secondary text-nowrap">
                                    <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 0.75rem;">
                                        #{{ $trx->id_parkir }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-3 text-nowrap">
                                    <span class="plat-badge">
                                        {{ $trx->kendaraan->plat_nomor }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-3">
                                    <div class="d-flex align-items-center gap-2">
                                        @if(stripos($trx->tarif->jenis_kendaraan ?? '', 'motor') !== false)
                                            <i class="bi bi-bicycle text-warning fs-5"></i>
                                        @else
                                            <i class="bi bi-car-front-fill text-warning fs-5"></i>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size: 0.85rem;">
                                                {{ $trx->kendaraan->jenis_kendaraan ?? '-' }}
                                            </div>
                                            <small class="text-muted" style="font-size: 0.72rem;">{{ ucfirst($trx->tarif->jenis_kendaraan ?? 'Umum') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2.5 px-3">
                                    <span class="fw-semibold text-dark" style="font-size: 0.84rem;">
                                        Rp {{ number_format($trx->tarif->tarif_per_jam ?? 0) }}
                                    </span>
                                    <span class="text-muted" style="font-size: 0.72rem;">/jam</span>
                                </td>
                                <td class="py-2.5 px-3">
                                    <div class="d-flex align-items-center gap-1.5">
                                        <i class="bi bi-geo-alt-fill text-warning" style="font-size: 0.85rem;"></i>
                                        <span class="fw-semibold text-dark" style="font-size: 0.84rem;">{{ $trx->area->nama_area }}</span>
                                    </div>
                                </td>
                                <td class="py-2.5 px-3">
                                    <div class="fw-semibold text-dark" style="font-size: 0.82rem;">
                                        {{ date('d M Y, H:i', strtotime($trx->waktu_masuk)) }}
                                    </div>
                                    <small class="text-muted" style="font-size: 0.72rem;">
                                        {{ \Carbon\Carbon::parse($trx->waktu_masuk)->diffForHumans() }}
                                    </small>
                                </td>
                                <td class="py-2.5 px-3 text-end">
                                    <div class="d-inline-flex align-items-center gap-1.5">
                                        <form action="{{ route('transaksi.keluar', $trx->id_parkir) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.75rem;" onclick="return confirm('Proses checkout keluar kendaraan {{ $trx->kendaraan->plat_nomor }}?')">
                                                <i class="bi bi-box-arrow-right me-1"></i>Keluar
                                            </button>
                                        </form>
                                        <a href="{{ route('transaksi.struk', $trx->id_parkir) }}" class="btn btn-sm rounded-pill px-2.5 py-1 fw-bold" style="background: #FCE178; color: #18181B; font-size: 0.75rem;" title="Cetak Karcis">
                                            <i class="bi bi-receipt me-1"></i>Karcis
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <div style="width: 60px; height: 60px; background: #FEF9C3; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;">
                                        <i class="bi bi-check2-circle fs-2 text-warning"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">Tidak Ada Kendaraan di Lokasi</h6>
                                    <p class="text-muted small mb-3">Semua area parkir saat ini dalam keadaan kosong.</p>
                                    <a href="{{ route('transaksi.masuk.form') }}" class="btn btn-sm nexa-btn-yellow px-3 py-2">
                                        <i class="bi bi-plus-circle-fill me-1"></i> Catat Kendaraan Masuk
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Filter Pencarian di Tabel Kendaraan di Lokasi
        const filterInput = document.getElementById('filterLokasiInput');
        if (filterInput) {
            filterInput.addEventListener('keyup', function() {
                const keyword = this.value.toLowerCase();
                const rows = document.querySelectorAll('#tabelKendaraanLokasi tbody tr.trx-row');

                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(keyword) ? '' : 'none';
                });
            });
        }
    });
</script>
@endsection