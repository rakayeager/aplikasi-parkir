<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Tarif;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ==================== CRUD USER ====================
    public function userIndex()
    {
        $users = User::all();
        return view('admin.user', compact('users'));
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|max:50',
            'username'     => 'required|max:50|unique:tb_user,username',
            'password'     => 'required|min:6',
            'role'         => 'required|in:admin,petugas,owner',
            'status_aktif' => 'required|in:0,1'
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
            'status_aktif' => $request->status_aktif
        ]);

        LogAktivitas::create([
            'id_user'        => Auth::user()->id_user,
            'aktivitas'      => 'Menambahkan user baru: ' . $request->username,
            'waktu_aktivitas'=> now()
        ]);

        return back()->with('success', 'User berhasil ditambahkan.');
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'owner') {
            return back()->with('error', 'Akun dengan role owner tidak dapat diedit oleh admin.');
        }

        $request->validate([
            'nama_lengkap' => 'required|max:50',
            'username'     => 'required|max:50|unique:tb_user,username,' . $id . ',id_user',
            'role'         => 'required|in:admin,petugas,owner',
            'status_aktif' => 'required|in:0,1'
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'role'         => $request->role,
            'status_aktif' => $request->status_aktif,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        LogAktivitas::create([
            'id_user'        => Auth::user()->id_user,
            'aktivitas'      => 'Memperbarui data user: ' . $user->username,
            'waktu_aktivitas'=> now()
        ]);

        return back()->with('success', 'Data user berhasil diperbarui.');
    }

    public function userDestroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->with('error', 'Akun dengan role admin tidak dapat dihapus.');
        }

        if ($user->role === 'owner') {
            return back()->with('error', 'Akun dengan role owner tidak dapat dihapus oleh admin.');
        }

        if ((int) $user->id_user === (int) Auth::user()->id_user) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $username = $user->username;
        $user->delete();

        LogAktivitas::create([
            'id_user'        => Auth::user()->id_user,
            'aktivitas'      => 'Menghapus user: ' . $username,
            'waktu_aktivitas'=> now()
        ]);

        return back()->with('success', 'User berhasil dihapus.');
    }

    // ==================== CRUD TARIF ====================
    public function tarifIndex()
    {
        $tarifs = Tarif::all();
        return view('admin.tarif', compact('tarifs'));
    }

    public function tarifStore(Request $request)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|in:motor,mobil,lainnya',
            'tarif_per_jam'   => 'required|numeric|min:0'
        ]);

        Tarif::create([
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tarif_per_jam'   => $request->tarif_per_jam
        ]);

        LogAktivitas::create([
            'id_user'        => Auth::user()->id_user,
            'aktivitas'      => 'Menambahkan tarif jenis: ' . $request->jenis_kendaraan,
            'waktu_aktivitas'=> now()
        ]);

        return back()->with('success', 'Tarif baru berhasil ditambahkan.');
    }

    public function tarifUpdate(Request $request, $id)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|in:motor,mobil,lainnya',
            'tarif_per_jam'   => 'required|numeric|min:0'
        ]);

        $tarif = Tarif::findOrFail($id);
        $tarif->update([
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tarif_per_jam'   => $request->tarif_per_jam
        ]);

        LogAktivitas::create([
            'id_user'        => Auth::user()->id_user,
            'aktivitas'      => 'Memperbarui tarif: ' . $tarif->jenis_kendaraan,
            'waktu_aktivitas'=> now()
        ]);

        return back()->with('success', 'Tarif berhasil diperbarui.');
    }

    public function tarifDestroy($id)
    {
        $tarif = Tarif::findOrFail($id);
        $jenis = $tarif->jenis_kendaraan;
        $tarif->delete();

        LogAktivitas::create([
            'id_user'        => Auth::user()->id_user,
            'aktivitas'      => 'Menghapus tarif: ' . $jenis,
            'waktu_aktivitas'=> now()
        ]);

        return back()->with('success', 'Tarif berhasil dihapus.');
    }

    // ==================== CRUD AREA PARKIR ====================
    public function areaIndex()
    {
        $areas = AreaParkir::all();
        return view('admin.area', compact('areas'));
    }

    public function areaStore(Request $request)
    {
        $request->validate([
            'nama_area' => 'required|max:50',
            'kapasitas' => 'required|numeric|min:1'
        ]);

        AreaParkir::create([
            'nama_area' => $request->nama_area,
            'kapasitas' => $request->kapasitas,
            'terisi'    => 0
        ]);

        LogAktivitas::create([
            'id_user'        => Auth::user()->id_user,
            'aktivitas'      => 'Menambahkan area: ' . $request->nama_area,
            'waktu_aktivitas'=> now()
        ]);

        return back()->with('success', 'Area parkir berhasil ditambahkan.');
    }

    public function areaUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_area' => 'required|max:50',
            'kapasitas' => 'required|numeric|min:1'
        ]);

        $area = AreaParkir::findOrFail($id);
        $area->update([
            'nama_area' => $request->nama_area,
            'kapasitas' => $request->kapasitas
        ]);

        LogAktivitas::create([
            'id_user'        => Auth::user()->id_user,
            'aktivitas'      => 'Memperbarui area: ' . $area->nama_area,
            'waktu_aktivitas'=> now()
        ]);

        return back()->with('success', 'Area parkir berhasil diperbarui.');
    }

    public function areaDestroy($id)
    {
        $area = AreaParkir::findOrFail($id);
        $nama = $area->nama_area;
        $area->delete();

        LogAktivitas::create([
            'id_user'        => Auth::user()->id_user,
            'aktivitas'      => 'Menghapus area: ' . $nama,
            'waktu_aktivitas'=> now()
        ]);

        return back()->with('success', 'Area berhasil dihapus.');
    }

    // ==================== CRUD KENDARAAN ====================
    public function kendaraanIndex()
    {
        $kendaraans = Kendaraan::with('user')->get();
        return view('admin.kendaraan', compact('kendaraans'));
    }

    public function kendaraanStore(Request $request)
    {
        $request->validate([
            'plat_nomor'      => 'required|max:15|unique:tb_kendaraan,plat_nomor',
            'jenis_kendaraan' => 'required|max:20',
            'warna'           => 'nullable|max:20',
            'pemilik'         => 'nullable|max:100'
        ]);

        Kendaraan::create([
            'plat_nomor'      => strtoupper($request->plat_nomor),
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'warna'           => $request->warna ?? '-',
            'pemilik'         => $request->pemilik ?? 'Umum',
            'id_user'         => Auth::user()->id_user
        ]);

        LogAktivitas::create([
            'id_user'        => Auth::user()->id_user,
            'aktivitas'      => 'Menambahkan data kendaraan: ' . strtoupper($request->plat_nomor),
            'waktu_aktivitas'=> now()
        ]);

        return back()->with('success', 'Kendaraan berhasil didaftarkan.');
    }

    public function kendaraanUpdate(Request $request, $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        $request->validate([
            'plat_nomor'      => 'required|max:15|unique:tb_kendaraan,plat_nomor,' . $id . ',id_kendaraan',
            'jenis_kendaraan' => 'required|max:20',
            'warna'           => 'nullable|max:20',
            'pemilik'         => 'nullable|max:100'
        ]);

        $kendaraan->update([
            'plat_nomor'      => strtoupper($request->plat_nomor),
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'warna'           => $request->warna ?? '-',
            'pemilik'         => $request->pemilik ?? 'Umum'
        ]);

        LogAktivitas::create([
            'id_user'        => Auth::user()->id_user,
            'aktivitas'      => 'Memperbarui data kendaraan: ' . $kendaraan->plat_nomor,
            'waktu_aktivitas'=> now()
        ]);

        return back()->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    public function kendaraanDestroy($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        $plat = $kendaraan->plat_nomor;
        $kendaraan->delete();

        LogAktivitas::create([
            'id_user'        => Auth::user()->id_user,
            'aktivitas'      => 'Menghapus kendaraan: ' . $plat,
            'waktu_aktivitas'=> now()
        ]);

        return back()->with('success', 'Kendaraan berhasil dihapus.');
    }

    // ==================== LOG AKTIVITAS ====================
    public function logIndex()
    {
        $logs = LogAktivitas::with('user')->orderBy('id_log', 'desc')->limit(100)->get();
        return view('admin.log', compact('logs'));
    }
}