@extends('layouts.app')
@section('title', 'Area Parkir')

@section('content')
<div class="row">
    <!-- Tabel Status Area Parkir (Full Width) -->
    <div class="col-12">
        <div class="nexa-card overflow-hidden">
            <div class="p-4 pb-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: #FAFAFA;">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 44px; height: 44px; background: #FCE178; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: #18181B;">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Status Kapasitas Area Parkir</h5>
                        <small class="text-muted">{{ $areas->count() }} zona parkir aktif terdaftar</small>
                    </div>
                </div>

                <!-- Tombol Pemicu Modal Tambah -->
                <button type="button" class="nexa-btn-yellow" data-bs-toggle="modal" data-bs-target="#tambahAreaModal">
                    <i class="bi bi-plus-circle-fill"></i> Tambah Area Parkir
                </button>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: #FAFAFA;">
                            <tr>
                                <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Nama Area</th>
                                <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Kapasitas</th>
                                <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Terisi</th>
                                <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Tersisa</th>
                                <th class="py-3 px-4 text-uppercase text-secondary text-end" style="font-size: 0.75rem; font-weight: 700;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($areas as $a)
                            <tr>
                                <td class="py-3 px-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-p-square-fill text-warning fs-5"></i>
                                        <span class="fw-bold text-dark fs-6">{{ $a->nama_area }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-secondary">{{ $a->kapasitas }} Slot</td>
                                <td class="py-3 px-4 fw-bold text-dark">{{ $a->terisi }} Slot</td>
                                <td class="py-3 px-4">
                                    <span class="badge" style="background: #FEF3C7; color: #92400E; font-weight: 800; border-radius: 6px; padding: 6px 12px;">
                                        {{ $a->kapasitas - $a->terisi }} Slot Tersedia
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-end">
                                    <button class="btn btn-sm rounded-pill px-3 py-1 fw-bold" style="background: #FCE178; color: #18181B;" data-bs-toggle="modal" data-bs-target="#editAreaModal{{ $a->id_area }}">
                                        <i class="bi bi-pencil-fill me-1"></i>Edit
                                    </button>
                                    <form action="{{ route('admin.area.destroy', $a->id_area) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger rounded-pill px-3 py-1 fw-bold ms-1" onclick="return confirm('Hapus area ini?')">
                                            <i class="bi bi-trash-fill me-1"></i>Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit Area -->
                            <div class="modal fade" id="editAreaModal{{ $a->id_area }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-4 shadow">
                                        <div class="modal-header bg-light border-0 py-3 px-4">
                                            <h6 class="modal-title fw-bold text-dark">
                                                <i class="bi bi-pencil-square me-2 text-warning"></i>Edit Area: {{ $a->nama_area }}
                                            </h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.area.update', $a->id_area) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Nama Area</label>
                                                    <input type="text" name="nama_area" class="form-control" value="{{ $a->nama_area }}" required style="border-radius: 12px; padding: 10px 14px;">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Kapasitas Slot</label>
                                                    <input type="number" name="kapasitas" class="form-control" value="{{ $a->kapasitas }}" min="1" required style="border-radius: 12px; padding: 10px 14px;">
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 p-3 px-4 bg-light">
                                                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="nexa-btn-yellow">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Area Baru (Muncul saat tombol diklik) -->
<div class="modal fade" id="tambahAreaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 34px; height: 34px; background: #FCE178; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1rem; color: #18181B;">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h6 class="modal-title mb-0 fw-bold text-dark">Tambah Area Parkir Baru</h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.area.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Nama Area</label>
                        <input type="text" name="nama_area" class="form-control" placeholder="Contoh: Area A - Mobil" required
                               style="border-radius: 12px; border: 2px solid #E4E4E7; padding: 11px 16px; font-weight: 600;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Kapasitas Slot</label>
                        <input type="number" name="kapasitas" class="form-control" min="1" required placeholder="Contoh: 50"
                               style="border-radius: 12px; border: 2px solid #E4E4E7; padding: 11px 16px; font-weight: 600;">
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 px-4 bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="nexa-btn-yellow">
                        <i class="bi bi-plus-circle-fill"></i> Simpan Area
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection