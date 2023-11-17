<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\PembelianKopiController;
use App\Http\Controllers\ListBarangMasukController;
use App\Http\Controllers\ListBarangKeluarController;
use App\Http\Controllers\PembelianTembakauController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ReportController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Login Route
Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

// Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/dashboard/profile', ProfileController::class)->middleware(['web']);
});

// Presensi Karyawan Only
Route::middleware(['auth', 'user-access:3'])->group(function () {
    Route::post('/dashboard/presensi/checkin/{id}', [PresensiController::class, 'checkin']);
    Route::put('/dashboard/presensi/checkout/{id}', [PresensiController::class, 'checkout']);
});

// Multi user login
/* NOTE : 

    User Role :
    1 : Admin
    2 : Owner
    3 : Karyawan
    
*/
Route::middleware(['auth', 'user-access:1|3', 'checked-in'])->group(function () {
    // Master Data
    Route::resource('/dashboard/barang', BarangController::class);

    Route::resource('/dashboard/barang-masuk', BarangMasukController::class);

    Route::resource('/dashboard/barang-masuk/list-barang-masuk', ListBarangMasukController::class);
    Route::get('/dashboard/barang-masuk/{id}/acc', [BarangMasukController::class, 'acc']);
    Route::get('/dashboard/barang-masuk/{id}/not-acc', [BarangMasukController::class, 'notAcc']);

    Route::resource('/dashboard/barang-keluar', BarangKeluarController::class);
    Route::get('/dashboard/barang-keluar/{id}/acc', [BarangKeluarController::class, 'acc']);
    Route::get('/dashboard/barang-keluar/{id}/not-acc', [BarangKeluarController::class, 'notAcc']);

    Route::resource('/dashboard/barang-keluar/list-barang-keluar', ListBarangKeluarController::class);
    Route::get('/dashboard/barang-keluar/{id}/acc', [BarangKeluarController::class, 'acc']);
    Route::get('/dashboard/barang-keluar/{id}/not-acc', [BarangKeluarController::class, 'notAcc']);

    // Transaksi
    Route::get('/dashboard/pembelian-kopi', [PembelianKopiController::class, 'index']);
    Route::get('/dashboard/pembelian-tembakau', [PembelianTembakauController::class, 'index']);
});

Route::middleware(['auth', 'user-access:1|2'])->group(function () {
    // User Route
    Route::resource('/dashboard/pengguna', UserController::class);

    // Karyawan Section
    Route::resource('/dashboard/jadwal-karyawan', JadwalController::class);
    Route::resource('/dashboard/gaji-karyawan', GajiController::class);

    Route::get('/dashboard/generate-laporan', [ReportController::class, 'index']);
    Route::post('/dashboard/generate-laporan/presensi', [ReportController::class, 'presensi']);
});
