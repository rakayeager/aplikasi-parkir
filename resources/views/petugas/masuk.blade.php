@extends('layouts.app')
@section('title', 'Masuk Kendaraan')

@section('styles')
<style>
    .masuk-form-card {
        background: #FFFFFF;
        border-radius: 24px;
        border: 1px solid rgba(0, 0, 0, 0.04);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .form-header-badge {
        width: 46px;
        height: 46px;
        background: #FCE178;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: #18181B;
    }

    .input-nexa {
        border-radius: 14px;
        border: 2px solid #E4E4E7;
        padding: 13px 18px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background: #FAFAFA;
    }

    .input-nexa:focus {
        border-color: #E2B734;
        background: #FFFFFF;
        box-shadow: 0 0 0 4px rgba(226, 183, 52, 0.25);
    }

    .plat-input-preview {
        background: #18181B;
        color: #FCE178;
        border-radius: 14px;
        padding: 12px 18px;
        font-family: 'JetBrains Mono', 'Courier New', monospace;
        font-weight: 800;
        letter-spacing: 2px;
        font-size: 1.4rem;
        text-align: center;
        border: 2px dashed #E2B734;
        margin-bottom: 20px;
    }

    /* Area Status Tiles */
    .area-status-tile {
        background: #FAFAFA;
        border-radius: 18px;
        padding: 16px 18px;
        border: 1px solid #E4E4E7;
        margin-bottom: 12px;
        transition: all 0.2s ease;
    }

    .area-status-tile:hover {
        background: #FFFFFF;
        border-color: #E2B734;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.04);
    }

    .progress-bar-slot {
        height: 7px;
        background: #E4E4E7;
        border-radius: 9999px;
        overflow: hidden;
        margin-top: 8px;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #E2B734, #F59E0B);
        border-radius: 9999px;
        transition: width 0.4s ease;
    }
</style>
@endsection

@section('content')

{{-- Header Navigasi Cepat --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">Loket Check-in Masuk</h4>
        <p class="text-muted small mb-0">Catat nomor plat dan cetak karcis bukti parkir baru</p>
    </div>
    <a href="{{ route('transaksi.index') }}" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold" style="font-size: 0.88rem;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Loket Parkir
    </a>
</div>

<div class="row g-4">
    {{-- Form Masuk Kendaraan (Kolom Utama) --}}
    <div class="col-lg-7">
        <div class="masuk-form-card">
            <div class="p-4 border-bottom d-flex align-items-center gap-3" style="background: #FAFAFA;">
                <div class="form-header-badge">
                    <i class="bi bi-plus-circle-fill"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold text-dark">Formulir Masuk Kendaraan</h5>
                    <small class="text-muted">Isi data identitas kendaraan yang memasuki area parkir</small>
                </div>
            </div>

            <div class="p-4 p-md-5">
                {{-- Live Preview Plat Nomor --}}
                <div class="text-center mb-2">
                    <span class="text-muted text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 1px;">PREVIEW PLAT NOMOR</span>
                </div>
                <div class="plat-input-preview" id="platPreview">
                    _ _ _ _ _ _ _
                </div>

                <form action="{{ route('transaksi.masuk') }}" method="POST">
                    @csrf

                    {{-- 1. Input Plat Nomor --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.88rem;">
                            <i class="bi bi-credit-card-2-front me-1 text-warning"></i>Plat Nomor Kendaraan
                        </label>
                        <input type="text" name="plat_nomor" id="inputPlatNomor" class="form-control input-nexa text-uppercase" placeholder="Contoh: B 1234 ABC" required autofocus>
                        <small class="text-muted">Gunakan spasi antara kode wilayah, angka, dan seri huruf.</small>
                    </div>

                    {{-- 2. Tarif Kendaraan --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.88rem;">
                            <i class="bi bi-cash-stack me-1 text-warning"></i>Kategori Tarif Kendaraan
                        </label>
                        <select name="id_tarif" id="selectTarif" class="form-select input-nexa" required>
                            @foreach($tarifs as $t)
                                <option value="{{ $t->id_tarif }}" data-jenis="{{ strtolower($t->jenis_kendaraan) }}">
                                    {{ ucfirst($t->jenis_kendaraan) }} — Rp {{ number_format($t->tarif_per_jam) }}/jam
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 3. Model Kendaraan --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.88rem;">
                            <i class="bi bi-tag-fill me-1 text-warning"></i>Model / Tipe Kendaraan
                        </label>
                        <input type="text" name="jenis_kendaraan" id="inputModel" class="form-control input-nexa" placeholder="Contoh: Beat / Vario / Avanza" required>
                    </div>

                    {{-- 4. Pilih Area Parkir --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.88rem;">
                            <i class="bi bi-geo-alt-fill me-1 text-warning"></i>Pilih Area Parkir
                        </label>
                        <select name="id_area" id="selectArea" class="form-select input-nexa" required>
                            @foreach($areas as $a)
                                @php $tersedia = $a->kapasitas - $a->terisi; @endphp
                                <option value="{{ $a->id_area }}" data-nama="{{ strtolower($a->nama_area) }}" {{ $tersedia <= 0 ? 'disabled' : '' }}>
                                    {{ $a->nama_area }} (Tersedia: {{ $tersedia }} dari {{ $a->kapasitas }} Slot)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="d-grid gap-2">
                        <button type="submit" class="nexa-btn-yellow py-3 fs-6">
                            <i class="bi bi-ticket-perforated-fill me-2 fs-5"></i> Simpan Masuk & Cetak Karcis
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Info Sisa Slot Area Parkir & Panduan (Kolom Samping) --}}
    <div class="col-lg-5">
        {{-- Card Ketersediaan Area --}}
        <div class="nexa-card p-4 mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 34px; height: 34px; background: #FEF9C3; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: #854D0E;">
                        <i class="bi bi-pie-chart-fill"></i>
                    </div>
                    <h6 class="mb-0 fw-bold text-dark">Kapasitas Area Saat Ini</h6>
                </div>
                <span class="badge bg-success rounded-pill px-2 py-1" style="font-size: 0.7rem;">Real-time</span>
            </div>

            @foreach($areas as $area)
            @php
                $sisa = max(0, $area->kapasitas - $area->terisi);
                $persen = $area->kapasitas > 0 ? round(($area->terisi / $area->kapasitas) * 100) : 0;
                $isMotor = stripos($area->nama_area, 'motor') !== false;
            @endphp
            <div class="area-status-tile">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        @if($isMotor)
                            <i class="bi bi-bicycle text-warning fs-5"></i>
                        @else
                            <i class="bi bi-car-front-fill text-warning fs-5"></i>
                        @endif
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $area->nama_area }}</div>
                            <small class="text-muted">Terisi: {{ $area->terisi }} / {{ $area->kapasitas }}</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge {{ $sisa > 0 ? 'bg-dark text-warning' : 'bg-danger text-white' }} px-2 py-1 rounded-pill" style="font-size: 0.75rem; font-weight: 700;">
                            {{ $sisa }} Sisa Slot
                        </span>
                    </div>
                </div>
                <div class="progress-bar-slot">
                    <div class="progress-fill" style="width: {{ $persen }}%;"></div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Petunjuk Loket --}}
        <div class="nexa-card p-4" style="background: #FEF9C3; border-color: #FDE68A;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-info-circle-fill text-warning fs-5"></i>
                <h6 class="mb-0 fw-bold text-dark">Petunjuk Petugas</h6>
            </div>
            <ul class="mb-0 ps-3 text-dark" style="font-size: 0.82rem; line-height: 1.6;">
                <li>Pastikan nomor plat yang diketik sesuai dengan fisik kendaraan.</li>
                <li>Pilihan area parkir otomatis menyesuaikan kategori tarif (motor/mobil).</li>
                <li>Setelah tombol diklik, struk karcis masuk akan langsung dibuat dan siap dicetak.</li>
            </ul>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputPlat = document.getElementById('inputPlatNomor');
        const platPreview = document.getElementById('platPreview');
        const selectTarif = document.getElementById('selectTarif');
        const selectArea = document.getElementById('selectArea');
        const inputModel = document.getElementById('inputModel');

        // Live preview nomor plat
        if (inputPlat && platPreview) {
            inputPlat.addEventListener('input', function() {
                const val = this.value.trim().toUpperCase();
                platPreview.innerText = val ? val : '_ _ _ _ _ _ _';
            });
        }

        // Sinkronisasi otomatis tarif dengan pilihan area & placeholder model
        function syncAreaWithTarif() {
            if (!selectTarif || !selectArea) return;
            const selectedOpt = selectTarif.options[selectTarif.selectedIndex];
            if (!selectedOpt) return;

            const jenis = (selectedOpt.getAttribute('data-jenis') || '').toLowerCase();

            // Ubah placeholder model kendaraan sesuai jenis yang dipilih
            if (inputModel) {
                if (jenis.includes('motor')) {
                    inputModel.placeholder = 'Contoh: Beat / Vario / NMAX / Scoopy';
                } else if (jenis.includes('mobil')) {
                    inputModel.placeholder = 'Contoh: Avanza / Innova / Brio / Pajero';
                } else {
                    inputModel.placeholder = 'Contoh: Truk / Bus / Box';
                }
            }

            // Cari opsi area parkir yang sesuai dengan jenis kendaraan
            let matched = false;
            for (let i = 0; i < selectArea.options.length; i++) {
                const opt = selectArea.options[i];
                if (opt.disabled) continue;

                const namaArea = (opt.getAttribute('data-nama') || '').toLowerCase();

                if (jenis.includes('mobil') && namaArea.includes('mobil')) {
                    selectArea.selectedIndex = i;
                    matched = true;
                    break;
                } else if (jenis.includes('motor') && namaArea.includes('motor')) {
                    selectArea.selectedIndex = i;
                    matched = true;
                    break;
                }
            }

            // Efek highlight saat otomatis terpilih
            if (matched) {
                selectArea.style.transition = 'all 0.3s ease';
                selectArea.style.borderColor = '#E2B734';
                selectArea.style.backgroundColor = '#FEF9C3';
                setTimeout(() => {
                    selectArea.style.borderColor = '#E4E4E7';
                    selectArea.style.backgroundColor = '#FFFFFF';
                }, 500);
            }
        }

        if (selectTarif) {
            selectTarif.addEventListener('change', syncAreaWithTarif);
            syncAreaWithTarif();
        }
    });
</script>
@endsection

