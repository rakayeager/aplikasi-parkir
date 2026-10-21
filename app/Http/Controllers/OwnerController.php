<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kendaraan;
use App\Models\AreaParkir;
use App\Models\Tarif;
use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use JsonException;
use Throwable;

class OwnerController extends Controller
{
    private const BACKUP_TABLES = [
        'tb_user',
        'tb_tarif',
        'tb_area_parkir',
        'tb_kendaraan',
        'tb_transaksi',
        'tb_log_aktivitas',
    ];

    public function dashboard()
    {
        // Metric Utama
        $totalPendapatanSemua = Transaksi::where('status', 'keluar')->sum('biaya_total');
        $totalPendapatanBulanIni = Transaksi::where('status', 'keluar')
            ->whereMonth('waktu_keluar', date('m'))
            ->whereYear('waktu_keluar', date('Y'))
            ->sum('biaya_total');

        $totalKendaraan = Kendaraan::count();
        $kendaraanAktif = Transaksi::where('status', 'masuk')->count();
        $totalTransaksiSelesai = Transaksi::where('status', 'keluar')->count();

        $ringkasanPendapatanPetugas = $this->ringkasanPendapatanPetugas();
        $pendapatanPetugas = User::where('role', 'petugas')
            ->orderBy('nama_lengkap')
            ->get()
            ->map(function ($petugas) use ($ringkasanPendapatanPetugas) {
                $ringkasan = $ringkasanPendapatanPetugas->get($petugas->id_user);
                $petugas->jumlah_transaksi_selesai = (int) ($ringkasan->jumlah_transaksi ?? 0);
                $petugas->total_pendapatan = (int) ($ringkasan->total_pendapatan ?? 0);

                return $petugas;
            })
            ->sortByDesc('total_pendapatan')
            ->values();

        // Area & Kapasitas
        $areas = AreaParkir::all();
        $totalKapasitas = $areas->sum('kapasitas');
        $totalTerisi = $areas->sum('terisi');
        $occupancyRate = $totalKapasitas > 0 ? round(($totalTerisi / $totalKapasitas) * 100) : 0;

        // Distribusi Jenis Kendaraan (Donut Chart)
        $distribusiJenis = Transaksi::join('tb_tarif', 'tb_transaksi.id_tarif', '=', 'tb_tarif.id_tarif')
            ->select('tb_tarif.jenis_kendaraan', 'tb_tarif.tarif_per_jam', DB::raw('count(*) as total'))
            ->groupBy('tb_tarif.jenis_kendaraan', 'tb_tarif.tarif_per_jam')
            ->get();

        // Data Trend Bulanan (7 Bulan Terakhir untuk Bar Chart)
        $trendLabels = [];
        $trendPendapatan = [];
        $trendVolume = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('m');
            $year = $date->format('Y');
            $trendLabels[] = $date->translatedFormat('M');

            $pendapatan = Transaksi::where('status', 'keluar')
                ->whereMonth('waktu_keluar', $month)
                ->whereYear('waktu_keluar', $year)
                ->sum('biaya_total');

            $volume = Transaksi::whereMonth('waktu_masuk', $month)
                ->whereYear('waktu_masuk', $year)
                ->count();

            $trendPendapatan[] = (int) $pendapatan;
            $trendVolume[] = (int) $volume;
        }

        // Transaksi Terkini (7 transaksi terbaru)
        $transaksiTerkini = Transaksi::with(['kendaraan', 'tarif', 'area', 'petugas'])
            ->orderBy('id_parkir', 'desc')
            ->limit(7)
            ->get();

        return view('owner.dashboard', compact(
            'totalPendapatanSemua',
            'totalPendapatanBulanIni',
            'totalKendaraan',
            'kendaraanAktif',
            'totalTransaksiSelesai',
            'pendapatanPetugas',
            'areas',
            'totalKapasitas',
            'totalTerisi',
            'occupancyRate',
            'distribusiJenis',
            'trendLabels',
            'trendPendapatan',
            'trendVolume',
            'transaksiTerkini'
        ));
    }

    public function getRealtimeMetrics()
    {
        $kendaraanAktif = Transaksi::where('status', 'masuk')->count();
        $totalTransaksiSelesai = Transaksi::where('status', 'keluar')->count();
        $totalPendapatanSemua = Transaksi::where('status', 'keluar')->sum('biaya_total');
        $totalPendapatanBulanIni = Transaksi::where('status', 'keluar')
            ->whereMonth('waktu_keluar', date('m'))
            ->whereYear('waktu_keluar', date('Y'))
            ->sum('biaya_total');

        $areas = AreaParkir::all();
        $totalKapasitas = $areas->sum('kapasitas');
        $totalTerisi = $areas->sum('terisi');
        $occupancyRate = $totalKapasitas > 0 ? round(($totalTerisi / $totalKapasitas) * 100) : 0;

        $transaksiTerkini = Transaksi::with(['kendaraan', 'tarif', 'area'])
            ->orderBy('id_parkir', 'desc')
            ->limit(7)
            ->get()
            ->map(function ($trx) {
                return [
                    'id_parkir' => $trx->id_parkir,
                    'plat_nomor' => $trx->kendaraan->plat_nomor ?? '-',
                    'nama_area' => $trx->area->nama_area ?? 'Area',
                    'jenis_kendaraan' => ucfirst($trx->tarif->jenis_kendaraan ?? 'Umum'),
                    'status' => $trx->status,
                    'biaya_total' => $trx->biaya_total ? 'Rp ' . number_format($trx->biaya_total) : '-',
                ];
            });

        return response()->json([
            'status' => 'success',
            'kendaraan_aktif' => $kendaraanAktif,
            'total_transaksi_selesai' => $totalTransaksiSelesai,
            'total_pendapatan_semua' => number_format($totalPendapatanSemua),
            'total_pendapatan_bulan_ini_k' => number_format($totalPendapatanBulanIni / 1000, 0),
            'total_pendapatan_bulan_ini' => number_format($totalPendapatanBulanIni),
            'total_kapasitas' => $totalKapasitas,
            'total_terisi' => $totalTerisi,
            'occupancy_rate' => $occupancyRate,
            'pendapatan_petugas' => $this->ringkasanPendapatanPetugas()->map(function ($summary) {
                return [
                    'id_user' => (int) $summary->id_user,
                    'jumlah_transaksi' => (int) $summary->jumlah_transaksi,
                    'total_pendapatan' => (int) $summary->total_pendapatan,
                ];
            })->values(),
            'areas' => $areas->map(function ($a) {
                $persen = $a->kapasitas > 0 ? round(($a->terisi / $a->kapasitas) * 100) : 0;
                $sisa = max(0, $a->kapasitas - $a->terisi);
                return [
                    'id_area' => $a->id_area,
                    'nama_area' => $a->nama_area,
                    'kapasitas' => $a->kapasitas,
                    'terisi' => $a->terisi,
                    'sisa' => $sisa,
                    'persen' => $persen
                ];
            }),
            'transaksi_terkini' => $transaksiTerkini
        ]);
    }

    private function ringkasanPendapatanPetugas()
    {
        return Transaksi::select(
            'id_user',
            DB::raw('COUNT(*) as jumlah_transaksi'),
            DB::raw('COALESCE(SUM(biaya_total), 0) as total_pendapatan')
        )
            ->where('status', 'keluar')
            ->groupBy('id_user')
            ->get()
            ->keyBy('id_user');
    }

    public function rekap(Request $request)
    {
        $tglMulai = $request->input('tgl_mulai', date('Y-m-01'));
        $tglAkhir = $request->input('tgl_akhir', date('Y-m-d'));

        $transaksis = Transaksi::with(['kendaraan', 'tarif', 'area', 'petugas'])
            ->where('status', 'keluar')
            ->whereDate('waktu_keluar', '>=', $tglMulai)
            ->whereDate('waktu_keluar', '<=', $tglAkhir)
            ->orderBy('waktu_keluar', 'desc')
            ->get();

        $totalPendapatan = $transaksis->sum('biaya_total');
        $totalKendaraan = $transaksis->count();

        return view('owner.rekap', compact('transaksis', 'tglMulai', 'tglAkhir', 'totalPendapatan', 'totalKendaraan'));
    }

    public function manajemenData()
    {
        return view('owner.manajemen-data');
    }

    public function backup()
    {
        $tables = [];

        foreach (self::BACKUP_TABLES as $table) {
            $tables[$table] = DB::table($table)->get()->map(function ($row) {
                return (array) $row;
            })->all();
        }

        $backup = [
            'format' => 'web-parkir-backup',
            'version' => 1,
            'created_at' => now()->toIso8601String(),
            'tables' => $tables,
        ];

        return response()->streamDownload(function () use ($backup) {
            echo json_encode($backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }, 'web-parkir-backup-' . now()->format('Y-m-d-His') . '.json', [
            'Content-Type' => 'application/json; charset=UTF-8',
        ]);
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:json|max:20480',
        ]);

        try {
            $backup = json_decode(
                file_get_contents($request->file('backup_file')->getRealPath()),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $exception) {
            return back()->with('error', 'File backup bukan JSON yang valid.');
        }

        if (!is_array($backup)
            || ($backup['format'] ?? null) !== 'web-parkir-backup'
            || ($backup['version'] ?? null) !== 1
            || !isset($backup['tables'])
            || !is_array($backup['tables'])) {
            return back()->with('error', 'Format file backup tidak dikenali.');
        }

        foreach (self::BACKUP_TABLES as $table) {
            if (!isset($backup['tables'][$table]) || !is_array($backup['tables'][$table])) {
                return back()->with('error', 'File backup tidak berisi data tabel yang lengkap.');
            }

            foreach ($backup['tables'][$table] as $row) {
                if (!is_array($row)) {
                    return back()->with('error', 'Struktur data pada file backup tidak valid.');
                }
            }
        }

        $currentOwnerId = (int) Auth::user()->id_user;
        $currentOwner = collect($backup['tables']['tb_user'])->first(function ($user) use ($currentOwnerId) {
            return isset($user['id_user']) && (int) $user['id_user'] === $currentOwnerId;
        });

        if (!$currentOwner || ($currentOwner['role'] ?? null) !== 'owner' || empty($currentOwner['status_aktif'])) {
            return back()->with('error', 'Backup harus memuat akun owner aktif yang sedang digunakan.');
        }

        try {
            DB::transaction(function () use ($backup) {
                foreach (array_reverse(self::BACKUP_TABLES) as $table) {
                    DB::table($table)->delete();
                }

                foreach (self::BACKUP_TABLES as $table) {
                    if ($backup['tables'][$table]) {
                        DB::table($table)->insert($backup['tables'][$table]);
                    }
                }
            });
        } catch (Throwable $exception) {
            return back()->with('error', 'Restore gagal. Data sebelumnya tetap dipertahankan.');
        }

        LogAktivitas::create([
            'id_user' => $currentOwnerId,
            'aktivitas' => 'Memulihkan data dari file backup',
            'waktu_aktivitas' => now(),
        ]);

        return back()->with('success', 'Data berhasil dipulihkan dari backup.');
    }

    public function deleteData()
    {
        $currentOwnerId = (int) Auth::user()->id_user;

        try {
            DB::transaction(function () use ($currentOwnerId) {
                foreach (array_reverse(self::BACKUP_TABLES) as $table) {
                    if ($table === 'tb_user') {
                        DB::table($table)->where('id_user', '!=', $currentOwnerId)->delete();
                    } else {
                        DB::table($table)->delete();
                    }
                }
            });
        } catch (Throwable $exception) {
            return back()->with('error', 'Penghapusan gagal. Data sebelumnya tetap dipertahankan.');
        }

        return back()->with('success', 'Semua data aplikasi telah dihapus. Akun owner tetap tersedia agar Anda dapat melakukan restore.');
    }
}