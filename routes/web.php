<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembelianKopiController;
use App\Http\Controllers\PembelianTembakauController;
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
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

// User Route
Route::resource('/dashboard/pengguna', UserController::class)->middleware('auth');
Route::resource('/dashboard/profile', ProfileController::class)->middleware(['auth', 'web']);

// Master Data
Route::resource('/dashboard/barang', BarangController::class)->middleware('auth');

// Transaksi
Route::get('dashboard/pembelian-kopi', [PembelianKopiController::class, 'index'])->middleware('auth');
Route::get('/dashboard/pembelian-tembakau', [PembelianTembakauController::class, 'index'])->middleware('auth');
