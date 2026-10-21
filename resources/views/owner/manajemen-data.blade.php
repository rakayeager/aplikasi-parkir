@extends('layouts.app')
@section('title', 'Manajemen Data')
@section('content')

<div class="nexa-card p-4">
    <div class="d-flex align-items-center gap-3 mb-3">
        <div style="width: 44px; height: 44px; background: #FCE178; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: #18181B;">
            <i class="bi bi-database-fill-gear"></i>
        </div>
        <div>
            <h5 class="mb-0 fw-bold text-dark">Cadangan & Pemulihan Basis Data</h5>
            <small class="text-muted">Unduh file cadangan sebelum melakukan pembersihan data sistem.</small>
        </div>
    </div>

    <div class="p-3 mb-4 rounded-4" style="background: #FFFBEB; border: 1px solid #FEF08A; font-size: 0.88rem; color: #92400E;">
        <i class="bi bi-info-circle-fill me-1"></i>
        Fitur ini memungkinkan Anda mencadangkan seluruh data transaksi, kendaraan, tarif, area, dan riwayat aktivitas dalam format file JSON aman.
    </div>

    <div class="row g-4 align-items-end">
        {{-- Card Backup --}}
        <div class="col-lg-4">
            <div class="p-4 rounded-4 text-center h-100 d-flex flex-direction-column justify-content-between" style="background: #FAFAFA; border: 1px solid #E4E4E7; flex-direction: column;">
                <div>
                    <i class="bi bi-download fs-1 text-warning mb-2 d-block"></i>
                    <h6 class="fw-bold text-dark mb-1">Cadangkan Data</h6>
                    <p class="text-muted small mb-4">Unduh snapshot database lengkap saat ini.</p>
                </div>
                <a href="{{ route('owner.backup') }}" class="nexa-btn-yellow w-100">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i> Unduh File Backup
                </a>
            </div>
        </div>

        {{-- Card Restore --}}
        <div class="col-lg-4">
            <div class="p-4 rounded-4 h-100 d-flex flex-direction-column justify-content-between" style="background: #FAFAFA; border: 1px solid #E4E4E7; flex-direction: column;">
                <div>
                    <i class="bi bi-upload fs-1 text-success mb-2 d-block text-center"></i>
                    <h6 class="fw-bold text-dark mb-1 text-center">Pulihkan Data</h6>
                    <p class="text-muted small mb-3 text-center">Restore database dari file cadangan JSON.</p>
                </div>
                <form action="{{ route('owner.restore') }}" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Restore akan menimpa seluruh data saat ini. Lanjutkan?')">
                    @csrf
                    <div class="mb-2">
                        <input type="file" name="backup_file" id="backup_file" class="form-control form-control-sm" accept=".json,application/json" required style="border-radius: 8px;">
                    </div>
                    <button type="submit" class="nexa-btn-black w-100">
                        <i class="bi bi-arrow-repeat"></i> Pulihkan Sekarang
                    </button>
                    @error('backup_file')
                        <div class="text-danger small mt-1 text-center">{{ $message }}</div>
                    @enderror
                </form>
            </div>
        </div>

        {{-- Card Hapus Data --}}
        <div class="col-lg-4">
            <div class="p-4 rounded-4 text-center h-100 d-flex flex-direction-column justify-content-between" style="background: #FEF2F2; border: 1px solid #FECACA; flex-direction: column;">
                <div>
                    <i class="bi bi-exclamation-triangle-fill fs-1 text-danger mb-2 d-block"></i>
                    <h6 class="fw-bold text-danger mb-1">Hapus Semua Data</h6>
                    <p class="text-danger-emphasis small mb-4">Reset seluruh transaksi dan master data.</p>
                </div>
                <form action="{{ route('owner.data.delete') }}" method="POST" onsubmit="return confirm('PERINGATAN KERAS: Semua transaksi, kendaraan, tarif, area, log, dan akun selain akun owner ini akan dihapus permanen. Lanjutkan?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100 fw-bold rounded-pill py-2">
                        <i class="bi bi-trash-fill"></i> Kosongkan Data
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection