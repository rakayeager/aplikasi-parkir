<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogAktivitas;
use App\Models\AreaParkir;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $areas = AreaParkir::all();
        $totalKapasitas = $areas->sum('kapasitas');
        $totalTerisi = $areas->sum('terisi');
        $totalTersedia = max(0, $totalKapasitas - $totalTerisi);

        return view('auth.login', compact('areas', 'totalKapasitas', 'totalTerisi', 'totalTersedia'));
    }

    public function getMonitoringSlot()
    {
        $areas = AreaParkir::all();
        $totalKapasitas = $areas->sum('kapasitas');
        $totalTerisi = $areas->sum('terisi');
        $totalTersedia = max(0, $totalKapasitas - $totalTerisi);

        return response()->json([
            'status' => 'success',
            'total_area' => $areas->count(),
            'total_kapasitas' => $totalKapasitas,
            'total_terisi' => $totalTerisi,
            'total_tersedia' => $totalTersedia,
            'areas' => $areas->map(function ($area) {
                $persen = $area->kapasitas > 0 ? round(($area->terisi / $area->kapasitas) * 100) : 0;
                $sisa = max(0, $area->kapasitas - $area->terisi);
                return [
                    'id_area' => $area->id_area,
                    'nama_area' => $area->nama_area,
                    'kapasitas' => $area->kapasitas,
                    'terisi' => $area->terisi,
                    'sisa' => $sisa,
                    'persen' => $persen
                ];
            })
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.'
        ]);

        $user = User::where('username', $request->username)->first();

        // 1. Cek apakah username terdaftar
        if (!$user) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Username tidak terdaftar dalam sistem!')
                ->withErrors(['username' => 'Username tidak terdaftar!']);
        }

        // 2. Cek apakah password benar
        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Password salah! Periksa kembali password Anda.')
                ->withErrors(['password' => 'Password yang Anda masukkan salah!']);
        }

        // 3. Cek status aktif akun
        if (!$user->status_aktif) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Akun Anda dinonaktifkan. Silakan hubungi Administrator!')
                ->withErrors(['username' => 'Akun Anda dinonaktifkan.']);
        }

        // 4. Lakukan otentikasi login
        Auth::login($user);

        LogAktivitas::create([
            'id_user' => $user->id_user,
            'aktivitas' => 'Login ke sistem',
            'waktu_aktivitas' => now()
        ]);

        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            LogAktivitas::create([
                'id_user' => Auth::user()->id_user,
                'aktivitas' => 'Logout dari sistem',
                'waktu_aktivitas' => now()
            ]);
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}