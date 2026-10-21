<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;

/*
|--------------------------------------------------------------------------
| Web Routes - Aplikasi Parkir
|--------------------------------------------------------------------------
*/

// ==================== AUTENTIKASI ====================
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/api/monitoring-slot', [AuthController::class, 'getMonitoringSlot'])->name('api.monitoring-slot');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== DASHBOARD REDIRECT ====================
Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    if ($role === 'admin') {
        return redirect()->route('admin.user');
    }
    if ($role === 'petugas') {
        return redirect()->route('transaksi.index');
    }
    if ($role === 'owner') {
        return redirect()->route('owner.dashboard');
    }
    return redirect()->route('login');
})->middleware('auth')->name('dashboard');

// ==================== ROLE: PETUGAS ====================
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/masuk', [TransaksiController::class, 'createMasuk'])->name('transaksi.masuk.form');
    Route::post('/transaksi/masuk', [TransaksiController::class, 'masuk'])->name('transaksi.masuk');
    Route::post('/transaksi/keluar/{id}', [TransaksiController::class, 'keluar'])->name('transaksi.keluar');
    Route::get('/transaksi/struk/{id}', [TransaksiController::class, 'cetakStruk'])->name('transaksi.struk');
});

// ==================== ROLE: ADMIN (CRUD MASTER) ====================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // CRUD User
    Route::get('/user', [AdminController::class, 'userIndex'])->name('user');
    Route::post('/user', [AdminController::class, 'userStore'])->name('user.store');
    Route::put('/user/{id}', [AdminController::class, 'userUpdate'])->name('user.update');
    Route::delete('/user/{id}', [AdminController::class, 'userDestroy'])->name('user.destroy');

    // CRUD Tarif Parkir
    Route::get('/tarif', [AdminController::class, 'tarifIndex'])->name('tarif');
    Route::post('/tarif', [AdminController::class, 'tarifStore'])->name('tarif.store');
    Route::put('/tarif/{id}', [AdminController::class, 'tarifUpdate'])->name('tarif.update');
    Route::delete('/tarif/{id}', [AdminController::class, 'tarifDestroy'])->name('tarif.destroy');

    // CRUD Area Parkir
    Route::get('/area', [AdminController::class, 'areaIndex'])->name('area');
    Route::post('/area', [AdminController::class, 'areaStore'])->name('area.store');
    Route::put('/area/{id}', [AdminController::class, 'areaUpdate'])->name('area.update');
    Route::delete('/area/{id}', [AdminController::class, 'areaDestroy'])->name('area.destroy');

    // CRUD Kendaraan
    Route::get('/kendaraan', [AdminController::class, 'kendaraanIndex'])->name('kendaraan');
    Route::post('/kendaraan', [AdminController::class, 'kendaraanStore'])->name('kendaraan.store');
    Route::put('/kendaraan/{id}', [AdminController::class, 'kendaraanUpdate'])->name('kendaraan.update');
    Route::delete('/kendaraan/{id}', [AdminController::class, 'kendaraanDestroy'])->name('kendaraan.destroy');

    // Monitoring Log Aktivitas
    Route::get('/log', [AdminController::class, 'logIndex'])->name('log');
});

// ==================== ROLE: OWNER ====================
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');
    Route::get('/api/realtime-metrics', [OwnerController::class, 'getRealtimeMetrics'])->name('api.metrics');
    Route::get('/rekap', [OwnerController::class, 'rekap'])->name('rekap');
    Route::get('/manajemen-data', [OwnerController::class, 'manajemenData'])->name('manajemen-data');
    Route::get('/backup', [OwnerController::class, 'backup'])->name('backup');
    Route::post('/restore', [OwnerController::class, 'restore'])->name('restore');
    Route::delete('/data', [OwnerController::class, 'deleteData'])->name('data.delete');
});