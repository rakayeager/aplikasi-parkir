<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\Kendaraan;
use App\Models\AreaParkir;
use App\Models\Tarif;
use App\Models\LogAktivitas;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['kendaraan', 'tarif', 'area'])
            ->where('status', 'masuk')
            ->orderBy('id_parkir', 'desc')
            ->get();

        $areas = AreaParkir::all();
        $totalPendapatanPetugas = Transaksi::where('id_user', Auth::user()->id_user)
            ->where('status', 'keluar')
            ->sum('biaya_total');

        return view('petugas.transaksi', compact('transaksis', 'areas', 'totalPendapatanPetugas'));
    }

    public function createMasuk()
    {
        $areas = AreaParkir::all();
        $tarifs = Tarif::all();

        return view('petugas.masuk', compact('areas', 'tarifs'));
    }

    public function masuk(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|max:15',
            'jenis_kendaraan' => 'required',
            'id_area' => 'required|exists:tb_area_parkir,id_area',
            'id_tarif' => 'required|exists:tb_tarif,id_tarif'
        ]);

        try {
            DB::beginTransaction();

            $area = AreaParkir::where('id_area', $request->id_area)->lockForUpdate()->first();

            if ($area->terisi >= $area->kapasitas) {
                DB::rollBack();
                return back()->with('error', 'Area parkir penuh!');
            }

            $kendaraan = Kendaraan::firstOrCreate(
                ['plat_nomor' => strtoupper($request->plat_nomor)],
                [
                    'jenis_kendaraan' => $request->jenis_kendaraan,
                    'warna' => $request->warna ?? '-',
                    'pemilik' => $request->pemilik ?? 'Umum',
                    'id_user' => Auth::user()->id_user
                ]
            );

            $transaksi = Transaksi::create([
                'id_kendaraan' => $kendaraan->id_kendaraan,
                'waktu_masuk' => now(),
                'id_tarif' => $request->id_tarif,
                'status' => 'masuk',
                'id_user' => Auth::user()->id_user,
                'id_area' => $area->id_area
            ]);

            $area->increment('terisi');

            LogAktivitas::create([
                'id_user' => Auth::user()->id_user,
                'aktivitas' => 'Kendaraan Masuk: ' . $kendaraan->plat_nomor,
                'waktu_aktivitas' => now()
            ]);

            DB::commit();

            return redirect()->route('transaksi.struk', $transaksi->id_parkir)
                ->with('success', 'Kendaraan berhasil dicatat masuk!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function keluar($id)
    {
        try {
            DB::beginTransaction();

            $transaksi = Transaksi::with(['tarif', 'area', 'kendaraan'])
                ->where('id_parkir', $id)
                ->where('status', 'masuk')
                ->lockForUpdate()
                ->firstOrFail();

            $waktuMasuk = Carbon::parse($transaksi->waktu_masuk);
            $waktuKeluar = now();

            $durasiMenit = $waktuMasuk->diffInMinutes($waktuKeluar);
            $durasiJam = max(1, (int) ceil($durasiMenit / 60));

            $biayaTotal = $durasiJam * $transaksi->tarif->tarif_per_jam;

            $transaksi->update([
                'waktu_keluar' => $waktuKeluar,
                'durasi_jam' => $durasiJam,
                'biaya_total' => $biayaTotal,
                'status' => 'keluar'
            ]);

            $area = AreaParkir::where('id_area', $transaksi->id_area)->lockForUpdate()->first();
            if ($area->terisi > 0) {
                $area->decrement('terisi');
            }

            LogAktivitas::create([
                'id_user' => Auth::user()->id_user,
                'aktivitas' => 'Kendaraan Keluar: ' . $transaksi->kendaraan->plat_nomor,
                'waktu_aktivitas' => now()
            ]);

            DB::commit();

            return redirect()->route('transaksi.index')
                ->with('success', 'Kendaraan ' . $transaksi->kendaraan->plat_nomor . ' berhasil checkout. Biaya: Rp ' . number_format($biayaTotal));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses checkout: ' . $e->getMessage());
        }
    }

    public function cetakStruk($id)
    {
        $transaksi = Transaksi::with(['kendaraan', 'tarif', 'area', 'petugas'])->findOrFail($id);
        return view('petugas.struk', compact('transaksi'));
    }
}