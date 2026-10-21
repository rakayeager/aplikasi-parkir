@extends('layouts.app')
@section('title', 'Kelola Pengguna')

@section('content')
<div class="row">
    <!-- Tabel User (Full Width) -->
    <div class="col-12">
        <div class="nexa-card overflow-hidden">
            <div class="p-4 pb-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: #FAFAFA;">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 44px; height: 44px; background: #FCE178; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: #18181B;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Daftar Pengguna Sistem</h5>
                        <small class="text-muted">{{ $users->count() }} akun terdaftar dalam sistem</small>
                    </div>
                </div>

                <!-- Tombol Pemicu Modal Tambah -->
                <button type="button" class="nexa-btn-yellow" data-bs-toggle="modal" data-bs-target="#tambahUserModal">
                    <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
                </button>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: #FAFAFA;">
                            <tr>
                                <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Pengguna</th>
                                <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Username</th>
                                <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Role</th>
                                <th class="py-3 px-4 text-uppercase text-secondary" style="font-size: 0.75rem; font-weight: 700;">Status</th>
                                <th class="py-3 px-4 text-uppercase text-secondary text-end" style="font-size: 0.75rem; font-weight: 700;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                            <tr>
                                <td class="py-3 px-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 36px; height: 36px; background: #FCE178; color: #18181B; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.88rem;">
                                            {{ strtoupper(substr($u->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <span class="fw-bold text-dark">{{ $u->nama_lengkap }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4"><code class="px-2 py-1 bg-light text-dark rounded fw-bold">{{ $u->username }}</code></td>
                                <td class="py-3 px-4">
                                    <span class="badge" style="background: #FEF3C7; color: #92400E; font-weight: 700; border-radius: 6px; padding: 6px 12px;">
                                        {{ strtoupper($u->role) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="badge rounded-pill {{ $u->status_aktif ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                        {{ $u->status_aktif ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-end">
                                    @if($u->role !== 'owner')
                                    <button class="btn btn-sm rounded-pill px-3 py-1 fw-bold" style="background: #FCE178; color: #18181B;" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $u->id_user }}">
                                        <i class="bi bi-pencil-fill me-1"></i>Edit
                                    </button>
                                    @if(Auth::id() != $u->id_user)
                                    <form action="{{ route('admin.user.destroy', $u->id_user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger rounded-pill px-3 py-1 fw-bold ms-1" onclick="return confirm('Hapus user ini?')">
                                            <i class="bi bi-trash-fill me-1"></i>Hapus
                                        </button>
                                    </form>
                                    @endif
                                    @else
                                    <span class="text-muted small">Akun owner dilindungi</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Modal Edit User -->
                            @if($u->role !== 'owner')
                            <div class="modal fade" id="editUserModal{{ $u->id_user }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-4 shadow">
                                        <div class="modal-header bg-light border-0 py-3 px-4">
                                            <h6 class="modal-title fw-bold text-dark">
                                                <i class="bi bi-pencil-square me-2 text-warning"></i>Edit Pengguna: {{ $u->username }}
                                            </h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.user.update', $u->id_user) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Nama Lengkap</label>
                                                    <input type="text" name="nama_lengkap" class="form-control" value="{{ $u->nama_lengkap }}" required style="border-radius: 12px; padding: 10px 14px;">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Username</label>
                                                    <input type="text" name="username" class="form-control" value="{{ $u->username }}" required style="border-radius: 12px; padding: 10px 14px;">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Ganti Password (Kosongkan bila tidak diubah)</label>
                                                    <input type="password" name="password" class="form-control" placeholder="Password baru" style="border-radius: 12px; padding: 10px 14px;">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Role Akses</label>
                                                    <select name="role" class="form-select" required style="border-radius: 12px; padding: 10px 14px;">
                                                        <option value="petugas" {{ $u->role === 'petugas' ? 'selected' : '' }}>Petugas Loket</option>
                                                        <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                                                        <!-- <option value="owner" {{ $u->role === 'owner' ? 'selected' : '' }}>Owner / Pemilik</option> -->
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Status</label>
                                                    <select name="status_aktif" class="form-select" required style="border-radius: 12px; padding: 10px 14px;">
                                                        <option value="1" {{ $u->status_aktif == 1 ? 'selected' : '' }}>Aktif</option>
                                                        <option value="0" {{ $u->status_aktif == 0 ? 'selected' : '' }}>Nonaktif</option>
                                                    </select>
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
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pengguna Baru (Muncul saat tombol diklik) -->
<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 34px; height: 34px; background: #FCE178; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1rem; color: #18181B;">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <h6 class="modal-title mb-0 fw-bold text-dark">Tambah Pengguna Baru</h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama lengkap" required
                               style="border-radius: 12px; border: 2px solid #E4E4E7; padding: 11px 16px; font-weight: 600;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username unik" required
                               style="border-radius: 12px; border: 2px solid #E4E4E7; padding: 11px 16px; font-weight: 600;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password akun" required
                               style="border-radius: 12px; border: 2px solid #E4E4E7; padding: 11px 16px; font-weight: 600;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Role Akses</label>
                        <select name="role" class="form-select" required
                                style="border-radius: 12px; border: 2px solid #E4E4E7; padding: 11px 16px; font-weight: 600;">
                            <option value="petugas">Petugas Loket</option>
                            <option value="admin">Administrator</option>
                            <!-- <option value="owner">Owner / Pemilik</option> -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 0.85rem;">Status Akun</label>
                        <select name="status_aktif" class="form-select" required
                                style="border-radius: 12px; border: 2px solid #E4E4E7; padding: 11px 16px; font-weight: 600;">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3 px-4 bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="nexa-btn-yellow">
                        <i class="bi bi-check2-circle"></i> Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection