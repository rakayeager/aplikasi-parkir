@extends('layouts.app')
@section('title', 'Log Aktivitas')

@section('content')
<div class="nexa-card overflow-hidden">
    <div class="p-4 pb-3 border-bottom d-flex align-items-center justify-content-between" style="background: #FAFAFA;">
        <div class="d-flex align-items-center gap-2">
            <div style="width: 36px; height: 36px; background: #FCE178; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: #18181B;">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold text-dark">Jejak Audit Aktivitas Sistem</h6>
                <small class="text-muted">Riwayat tindakan pengguna di dalam aplikasi</small>
            </div>
        </div>
        <span class="badge bg-dark text-warning px-3 py-2 rounded-pill" style="font-size: 0.78rem;">
            {{ $logs->count() }} Catatan Log
        </span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #FAFAFA;">
                    <tr>
                        <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Waktu</th>
                        <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Pengguna</th>
                        <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Role</th>
                        <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="py-3 px-4 small text-secondary">
                            <i class="bi bi-calendar3 me-1 text-warning"></i>{{ $log->waktu_aktivitas }}
                        </td>
                        <td class="py-3 px-4 fw-bold text-dark">
                            {{ $log->user->nama_lengkap ?? 'Sistem' }}
                        </td>
                        <td class="py-3 px-4">
                            <span class="badge" style="background: #FEF3C7; color: #92400E; font-weight: 700; border-radius: 6px; padding: 5px 10px;">
                                {{ strtoupper($log->user->role ?? '-') }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-dark font-monospace" style="font-size: 0.88rem;">
                            {{ $log->aktivitas }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            Belum ada riwayat aktivitas yang tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection