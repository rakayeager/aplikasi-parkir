@extends('layouts.app')
@section('title', 'Dashboard')

@section('styles')
<style>
    /* ===== TOP 4 METRIC CARDS (NEXAVERSE STYLE) ===== */
    .metric-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    .metric-card {
        border-radius: 24px;
        padding: 24px 26px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 140px;
        position: relative;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
    }

    .metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
    }

    .metric-card-1 {
        background-color: #FCE178;
        color: #18181B;
    }

    .metric-card-2 {
        background-color: #E2B734;
        color: #18181B;
    }

    .metric-card-3 {
        background-color: #FEF9C3;
        color: #18181B;
    }

    .metric-card-4 {
        background-color: #FFFDE7;
        color: #18181B;
    }

    .metric-title {
        font-size: 0.88rem;
        font-weight: 700;
        margin-bottom: 12px;
        opacity: 0.9;
    }

    .metric-value {
        font-size: 2.25rem;
        font-weight: 800;
        letter-spacing: -1px;
        line-height: 1.1;
        margin-bottom: 6px;
    }

    .metric-subtext {
        font-size: 0.76rem;
        font-weight: 600;
        opacity: 0.8;
    }

    /* ===== CONTENT GRID ROWS ===== */
    .dashboard-row-2 {
        display: grid;
        grid-template-columns: 1.45fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    .dashboard-row-3 {
        display: grid;
        grid-template-columns: 1.3fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    /* Nexa Cards */
    .nexa-box {
        background: #FFFFFF;
        border-radius: 24px;
        padding: 26px;
        box-shadow: 0 2px 14px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0, 0, 0, 0.03);
    }

    .nexa-box-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .nexa-box-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #18181B;
        margin: 0;
        letter-spacing: -0.3px;
    }

    .pill-filter-black {
        background: #18181B;
        color: #FFFFFF;
        border-radius: 9999px;
        padding: 6px 16px;
        font-size: 0.75rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Transactions List */
    .trx-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #F4F4F5;
    }

    .trx-item:last-child {
        border-bottom: none;
    }

    .trx-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .trx-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #FEF3C7;
        color: #B45309;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.75rem;
    }

    .trx-name {
        font-size: 0.85rem;
        font-weight: 700;
        color: #18181B;
        margin: 0;
        line-height: 1.2;
    }

    .trx-plate {
        font-size: 0.72rem;
        color: #71717A;
        font-weight: 600;
    }

    .trx-tag-badge {
        background: #FCE178;
        color: #18181B;
        border-radius: 6px;
        font-size: 0.68rem;
        font-weight: 800;
        padding: 3px 8px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .trx-amount {
        font-size: 0.85rem;
        font-weight: 800;
        color: #18181B;
    }

    .btn-view-all-trx {
        display: block;
        width: 100%;
        background-color: #FCE178;
        color: #18181B;
        font-weight: 800;
        font-size: 0.88rem;
        text-align: center;
        padding: 12px;
        border-radius: 14px;
        text-decoration: none;
        margin-top: 18px;
        transition: all 0.2s ease;
    }

    .btn-view-all-trx:hover {
        background-color: #E2B734;
        color: #000;
        transform: translateY(-1px);
    }

    /* Area List Style (Tickets Style) */
    .filter-pills-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
    }

    .filter-pill-tab {
        border-radius: 9999px;
        padding: 5px 14px;
        font-size: 0.75rem;
        font-weight: 700;
        border: 1px solid #E4E4E7;
        background: transparent;
        color: #71717A;
        cursor: pointer;
        transition: all 0.2s;
    }

    .filter-pill-tab.active {
        background: #FCE178;
        color: #18181B;
        border-color: #FCE178;
    }

    .area-row-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 14px;
        border-radius: 14px;
        background: #FAFAFA;
        margin-bottom: 10px;
        transition: background 0.2s;
    }

    .area-row-item:hover {
        background: #F4F4F5;
    }

    .area-bullet {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 10px;
    }

    .bullet-yellow { background-color: #E2B734; }
    .bullet-green { background-color: #22C55E; }
    .bullet-red { background-color: #EF4444; }

    /* Responsive */
    @media (max-width: 1200px) {
        .metric-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .dashboard-row-2 {
            grid-template-columns: 1fr;
        }
        .dashboard-row-3 {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .metric-grid {
            grid-template-columns: 1fr;
        }

        .metric-card {
            min-width: 0;
            padding: 20px 18px;
            border-radius: 18px;
        }

        .metric-value {
            font-size: 1.9rem;
            overflow-wrap: anywhere;
        }

        .metric-subtext {
            overflow-wrap: anywhere;
        }

        .nexa-box {
            min-width: 0;
            padding: 18px;
            border-radius: 18px;
        }

        .nexa-box-header {
            flex-wrap: wrap;
            align-items: flex-start;
            gap: 10px;
        }

        .filter-pills-row {
            flex-wrap: wrap;
        }

        .area-row-item {
            flex-wrap: wrap;
            gap: 10px;
            padding: 10px;
        }

        .dashboard-chart {
            height: 230px !important;
        }
    }
</style>
@endsection

@section('content')

{{-- ===== BARIS 1: 4 KARTU METRIK UTAMA (NEXAVERSE PALETTE) ===== --}}
<div class="metric-grid">
    <!-- Card 1: Total Pendapatan Bulan Ini -->
    <div class="metric-card metric-card-1">
        <div class="metric-title">Pendapatan Bulan Ini</div>
        <div class="metric-value">Rp <span id="pendapatanBulanIniVal">{{ number_format($totalPendapatanBulanIni / 1000, 0) }}</span>k</div>
        <div class="metric-subtext">
            <i class="bi bi-wallet2 me-1"></i> Total Keseluruhan: Rp <span id="pendapatanSemuaVal">{{ number_format($totalPendapatanSemua) }}</span>
        </div>
    </div>

    <!-- Card 2: Jumlah Transaksi Selesai -->
    <div class="metric-card metric-card-2">
        <div class="metric-title">Transaksi Selesai</div>
        <div class="metric-value" id="totalTransaksiSelesaiVal">{{ number_format($totalTransaksiSelesai) }}</div>
        <div class="metric-subtext">
            <i class="bi bi-check2-circle me-1"></i> Total transaksi parkir selesai
        </div>
    </div>

    <!-- Card 3: Kendaraan Sedang Parkir (Live Update Real-time) -->
    <div class="metric-card metric-card-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="metric-title mb-0">Kendaraan Aktif</div>
            <span class="badge bg-dark text-warning rounded-pill px-2 py-1" style="font-size: 0.68rem; font-weight: 700;">
                <span style="width: 6px; height: 6px; background-color: #22C55E; border-radius: 50%; display: inline-block; margin-right: 4px;"></span> Real-time
            </span>
        </div>
        <div class="metric-value mt-2">
            <span id="kendaraanAktifVal">{{ $kendaraanAktif }}</span> <span style="font-size: 1.1rem; font-weight: 700;">unit</span>
        </div>
        <div class="metric-subtext">
            <i class="bi bi-geo-alt-fill me-1"></i> Unit di tempat parkir saat ini
        </div>
    </div>

    <!-- Card 4: Okupansi Parkir -->
    <div class="metric-card metric-card-4">
        <div class="metric-title">Okupansi Slot Parkir</div>
        <div class="metric-value"><span id="occupancyRateVal">{{ $occupancyRate }}</span>%</div>
        <div class="metric-subtext">
            <i class="bi bi-pie-chart-fill me-1"></i> <span id="totalTerisiVal">{{ $totalTerisi }}</span> dari <span id="totalKapasitasVal">{{ $totalKapasitas }}</span> slot terpakai
        </div>
    </div>
</div>

{{-- ===== BARIS 2: TREND PARKIR & DISTRIBUSI JENIS KENDARAAN (FOKUS 2 KOLOM) ===== --}}
<div class="dashboard-row-2">
    <!-- Trend Chart (Bar Chart Lebar) -->
    <div class="nexa-box">
        <div class="nexa-box-header">
            <div>
                <h3 class="nexa-box-title">Trend Parkir</h3>
                <div class="d-flex align-items-center gap-3 mt-1" style="font-size: 0.75rem; font-weight: 700;">
                    <span style="color: #E2B734;"><i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> Pendapatan (Ribu Rp)</span>
                    <span style="color: #FCE178;"><i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> Volume Kendaraan</span>
                </div>
            </div>
            <span class="pill-filter-black">
                <i class="bi bi-calendar3"></i> 7 Bulan Terakhir
            </span>
        </div>
        <div class="dashboard-chart" style="height: 290px; position: relative;">
            <canvas id="trendChart"></canvas>
        </div>
    </div>

    <!-- Distribusi Jenis Kendaraan (Donut Chart & Detail Proporsi) -->
    <div class="nexa-box d-flex flex-column justify-content-between">
        <div>
            <div class="nexa-box-header">
                <div>
                    <h3 class="nexa-box-title">Jenis Kendaraan</h3>
                    <small class="text-muted" style="font-size: 0.76rem; font-weight: 600;">Proporsi Armada Terdaftar</small>
                </div>
                <span class="pill-filter-black">Proporsi</span>
            </div>

            <div class="row align-items-center g-3 my-1">
                <!-- Donut Chart -->
                <div class="col-sm-5">
                    <div style="height: 190px; position: relative; display: flex; align-items: center; justify-content: center;">
                        <canvas id="salesDonutChart"></canvas>
                        <div style="position: absolute; text-align: center; pointer-events: none;">
                            <div style="font-size: 1.65rem; font-weight: 800; color: #18181B; line-height: 1;">{{ $totalKendaraan }}</div>
                            <small style="font-size: 0.68rem; font-weight: 700; color: #71717A; text-transform: uppercase;">Unit</small>
                        </div>
                    </div>
                </div>

                <!-- Breakdown List Jenis Kendaraan -->
                <div class="col-sm-7">
                    <div class="d-flex flex-column gap-2">
                        @forelse($distribusiJenis as $dj)
                        @php
                            $isMotor = strtolower($dj->jenis_kendaraan) === 'motor';
                            $icon = $isMotor ? 'bi-bicycle' : 'bi-car-front-fill';
                            $percentVal = $totalKendaraan > 0 ? round(($dj->total / $totalKendaraan) * 100) : 0;
                        @endphp
                        <div class="p-2 px-3 rounded-3 d-flex align-items-center justify-content-between" style="background: #FAFAFA; border: 1px solid #F4F4F5;">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 34px; height: 34px; background: #FEF3C7; color: #B45309; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                                    <i class="bi {{ $icon }}"></i>
                                </div>
                                <div>
                                    <div class="fw-bold" style="font-size: 0.88rem; color: #18181B;">{{ ucfirst($dj->jenis_kendaraan) }}</div>
                                    <small class="text-muted" style="font-size: 0.72rem;">Rp {{ number_format($dj->tarif_per_jam ?? 0) }}/jam</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold" style="font-size: 0.9rem; color: #18181B;">{{ $dj->total }} unit</div>
                                <span class="badge" style="background: #FCE178; color: #18181B; font-size: 0.7rem; font-weight: 800; border-radius: 6px; padding: 2px 7px;">
                                    {{ $percentVal }}%
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted small">
                            Belum ada data armada kendaraan.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('owner.rekap') }}" class="btn-view-all-trx mt-2 py-2" style="font-size: 0.82rem;">
            <i class="bi bi-file-earmark-bar-graph-fill me-1"></i> Buka Rekapitulasi Lengkap
        </a>
    </div>
</div>

<div class="nexa-box mb-4">
    <div class="nexa-box-header">
        <div>
            <h3 class="nexa-box-title">Pendapatan Tiap Petugas</h3>
            <small class="text-muted" style="font-size: 0.76rem; font-weight: 600;">Dihitung dari transaksi yang sudah selesai</small>
        </div>
        <span class="pill-filter-black"><i class="bi bi-people-fill"></i> {{ $pendapatanPetugas->count() }} Petugas</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background: #FAFAFA;">
                <tr>
                    <th class="py-3 px-3 text-uppercase text-secondary" style="font-size: 0.72rem; font-weight: 700;">Nama Petugas</th>
                    <th class="py-3 px-3 text-uppercase text-secondary text-center" style="font-size: 0.72rem; font-weight: 700;">Transaksi Selesai</th>
                    <th class="py-3 px-3 text-uppercase text-secondary text-end" style="font-size: 0.72rem; font-weight: 700;">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendapatanPetugas as $petugas)
                <tr>
                    <td class="py-3 px-3 fw-bold text-dark">{{ $petugas->nama_lengkap }}</td>
                    <td class="py-3 px-3 text-center">
                        <span class="badge rounded-pill" style="background: #FEF3C7; color: #92400E;" id="petugas-transaksi-{{ $petugas->id_user }}">{{ number_format($petugas->jumlah_transaksi_selesai) }}</span>
                    </td>
                    <td class="py-3 px-3 text-end fw-bold text-dark">Rp <span id="petugas-pendapatan-{{ $petugas->id_user }}">{{ number_format($petugas->total_pendapatan) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-muted">Belum ada akun petugas yang terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ===== BARIS 3: MONITORING AREA & STATISTIK SISTEM ===== --}}
<div class="dashboard-row-3">
    <!-- Monitoring Area Parkir (Tickets Style) -->
    <div class="nexa-box">
        <div class="nexa-box-header">
            <h3 class="nexa-box-title">Monitoring Slot Area Parkir</h3>
            <span class="pill-filter-black">Real-time</span>
        </div>

        <div class="filter-pills-row">
            <button class="filter-pill-tab active">Semua Area (<span id="ownerTotalAreaTab">{{ $areas->count() }}</span>)</button>
            <button class="filter-pill-tab">Total Slot: <span id="ownerTotalKapasitasTab">{{ $totalKapasitas }}</span></button>
            <button class="filter-pill-tab">Tersedia: <span id="ownerTotalTersediaTab">{{ $totalKapasitas - $totalTerisi }}</span></button>
        </div>

        <div class="area-list-group">
            @forelse($areas as $area)
            @php
                $persen = $area->kapasitas > 0 ? round(($area->terisi / $area->kapasitas) * 100) : 0;
                $bulletColor = $persen >= 90 ? 'bullet-red' : ($persen >= 50 ? 'bullet-yellow' : 'bullet-green');
            @endphp
            <div class="area-row-item" id="owner-area-row-{{ $area->id_area }}">
                <div class="d-flex align-items-center">
                    <span class="area-bullet {{ $bulletColor }}"></span>
                    <div>
                        <div class="fw-bold" style="font-size: 0.9rem; color: #18181B;">{{ $area->nama_area }}</div>
                        <small class="text-muted" style="font-size: 0.75rem;">
                            Terisi: <b class="owner-area-terisi">{{ $area->terisi }}</b> / {{ $area->kapasitas }} Slot
                            (Sisa: <b class="owner-area-sisa">{{ max(0, $area->kapasitas - $area->terisi) }}</b>)
                        </small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 120px;" class="d-none d-sm-block">
                        <div class="progress" style="height: 7px; border-radius: 9999px; background-color: #E4E4E7;">
                            <div class="progress-bar owner-area-bar" style="width: {{ $persen }}%; background-color: #E2B734; border-radius: 9999px;"></div>
                        </div>
                    </div>
                    <span class="badge owner-area-badge" style="background: #FCE178; color: #18181B; font-weight: 800; border-radius: 8px; padding: 6px 10px;">
                        {{ $persen }}%
                    </span>
                </div>
            </div>
            @empty
            <div class="text-center py-4 text-muted small">
                Belum ada data area parkir.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Ringkasan Performa & Operasional -->
    <div class="nexa-box">
        <div class="nexa-box-header">
            <h3 class="nexa-box-title">Ringkasan Operasional</h3>
            <span class="pill-filter-black">Status</span>
        </div>

        <div class="p-3 mb-3 rounded-4" style="background: #FEF9C3; border: 1px solid #FEF08A;">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="fw-bold" style="font-size: 0.85rem; color: #854D0E;">Efisiensi Pintu Loket</span>
                <span class="badge bg-warning text-dark fw-bold">Optimal</span>
            </div>
            <div class="small text-muted mb-2" style="font-size: 0.78rem;">Sistem otomatis mengkalkulasi tarif keluar & karcis dengan barcode.</div>
            <div class="progress" style="height: 6px; border-radius: 9999px; background: rgba(0,0,0,0.06);">
                <div class="progress-bar" style="width: 94%; background: #E2B734;"></div>
            </div>
        </div>

        <div class="row g-2">
            <div class="col-6">
                <div class="p-3 rounded-4 text-center" style="background: #FAFAFA;">
                    <div class="fw-bold" style="font-size: 1.4rem; color: #18181B;">{{ $totalTransaksiSelesai }}</div>
                    <div class="text-muted" style="font-size: 0.75rem; font-weight: 700;">Tiket Selesai</div>
                </div>
            </div>
            <div class="col-6">
                <div class="p-3 rounded-4 text-center" style="background: #FAFAFA;">
                    <div class="fw-bold" style="font-size: 1.4rem; color: #18181B;">{{ $areas->count() }}</div>
                    <div class="text-muted" style="font-size: 0.75rem; font-weight: 700;">Zona Terbuka</div>
                </div>
            </div>
        </div>

        <div class="mt-3 text-center">
            <a href="{{ route('owner.manajemen-data') }}" class="nexa-btn-black w-100">
                <i class="bi bi-database-gear"></i> Kelola Cadangan & Basis Data
            </a>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // ===== TREND CHART (BAR CHART NEXAVERSE PALETTE) =====
        const ctxTrend = document.getElementById('trendChart');
        if (ctxTrend) {
            const labels = {!! json_encode($trendLabels) !!};
            const dataPendapatan = {!! json_encode($trendPendapatan) !!};
            const dataVolume = {!! json_encode($trendVolume) !!};

            new Chart(ctxTrend, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Pendapatan (Ribu Rp)',
                            data: dataPendapatan.map(v => Math.round(v / 1000)),
                            backgroundColor: '#E2B734',
                            borderRadius: 8,
                            barPercentage: 0.55,
                            categoryPercentage: 0.75,
                            maxBarThickness: 34
                        },
                        {
                            label: 'Volume Kendaraan',
                            data: dataVolume,
                            backgroundColor: '#FCE178',
                            borderRadius: 8,
                            barPercentage: 0.55,
                            categoryPercentage: 0.75,
                            maxBarThickness: 34
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#71717A',
                                font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 11 }
                            }
                        },
                        y: {
                            grid: { color: '#F4F4F5' },
                            ticks: {
                                color: '#71717A',
                                font: { family: 'Plus Jakarta Sans', size: 10 }
                            }
                        }
                    }
                }
            });
        }

        // ===== DONUT CHART (DISTRIBUSI KENDARAAN) =====
        const ctxDonut = document.getElementById('salesDonutChart');
        if (ctxDonut) {
            const distData = {!! json_encode($distribusiJenis) !!};
            const labels = distData.map(d => d.jenis_kendaraan ? d.jenis_kendaraan.toUpperCase() : 'LAINNYA');
            const totals = distData.map(d => d.total);

            const colors = ['#E2B734', '#FCE178', '#FDE68A', '#FEF9C3', '#FEF08A'];

            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: labels.length > 0 ? labels : ['KENDARAAN'],
                    datasets: [{
                        data: totals.length > 0 ? totals : [1],
                        backgroundColor: colors.slice(0, Math.max(labels.length, 1)),
                        borderWidth: 3,
                        borderColor: '#FFFFFF',
                        cutout: '72%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#18181B',
                            titleFont: { family: 'Plus Jakarta Sans', weight: 'bold' },
                            bodyFont: { family: 'Plus Jakarta Sans' },
                            padding: 10,
                            cornerRadius: 8
                        }
                    }
                }
            });
        }

        // ===== REAL-TIME LIVE UPDATE METRICS (KENDARAAN AKTIF, TRANSAKSI SELESAI, DLL) =====
        function updateOwnerRealtimeMetrics() {
            fetch("{{ route('owner.api.metrics') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        // 1. Update Card Kendaraan Aktif (unit di tempat parkir)
                        const elAktif = document.getElementById('kendaraanAktifVal');
                        if (elAktif) elAktif.innerText = data.kendaraan_aktif;

                        // 2. Update Card Transaksi Selesai
                        const elTrxSelesai = document.getElementById('totalTransaksiSelesaiVal');
                        if (elTrxSelesai) elTrxSelesai.innerText = data.total_transaksi_selesai;

                        // 3. Update Pendapatan
                        const elPendBulanIni = document.getElementById('pendapatanBulanIniVal');
                        if (elPendBulanIni) elPendBulanIni.innerText = data.total_pendapatan_bulan_ini_k;
                        const elPendSemua = document.getElementById('pendapatanSemuaVal');
                        if (elPendSemua) elPendSemua.innerText = data.total_pendapatan_semua;

                        // 4. Update Okupansi
                        const elOkupansi = document.getElementById('occupancyRateVal');
                        if (elOkupansi) elOkupansi.innerText = data.occupancy_rate;
                        const elTerisi = document.getElementById('totalTerisiVal');
                        if (elTerisi) elTerisi.innerText = data.total_terisi;
                        const elKapasitas = document.getElementById('totalKapasitasVal');
                        if (elKapasitas) elKapasitas.innerText = data.total_kapasitas;

                        // 5. Update Tab Pills
                        const tabTersedia = document.getElementById('ownerTotalTersediaTab');
                        if (tabTersedia) tabTersedia.innerText = (data.total_kapasitas - data.total_terisi);

                        // 6. Update Monitoring Slot Area Parkir
                        if (data.areas && Array.isArray(data.areas)) {
                            data.areas.forEach(area => {
                                const row = document.getElementById('owner-area-row-' + area.id_area);
                                if (row) {
                                    const terisiEl = row.querySelector('.owner-area-terisi');
                                    const sisaEl = row.querySelector('.owner-area-sisa');
                                    const barEl = row.querySelector('.owner-area-bar');
                                    const badgeEl = row.querySelector('.owner-area-badge');
                                    const bulletEl = row.querySelector('.area-bullet');

                                    if (terisiEl) terisiEl.innerText = area.terisi;
                                    if (sisaEl) sisaEl.innerText = area.sisa;
                                    if (barEl) barEl.style.width = area.persen + '%';
                                    if (badgeEl) badgeEl.innerText = area.persen + '%';
                                    if (bulletEl) {
                                        bulletEl.className = 'area-bullet ' + (area.persen >= 90 ? 'bullet-red' : (area.persen >= 50 ? 'bullet-yellow' : 'bullet-green'));
                                    }
                                }
                            });
                        }

                        if (data.pendapatan_petugas && Array.isArray(data.pendapatan_petugas)) {
                            const formatter = new Intl.NumberFormat('id-ID');
                            data.pendapatan_petugas.forEach(petugas => {
                                const pendapatanEl = document.getElementById('petugas-pendapatan-' + petugas.id_user);
                                const transaksiEl = document.getElementById('petugas-transaksi-' + petugas.id_user);
                                if (pendapatanEl) pendapatanEl.innerText = formatter.format(petugas.total_pendapatan);
                                if (transaksiEl) transaksiEl.innerText = formatter.format(petugas.jumlah_transaksi);
                            });
                        }
                    }
                })
                .catch(err => {
                    // Fail silently
                });
        }

        // Polling setiap 3 detik agar selalu real-time
        setInterval(updateOwnerRealtimeMetrics, 3000);
    });
</script>
@endsection

