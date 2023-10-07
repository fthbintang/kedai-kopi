<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AtributController;
use App\Http\Controllers\TembakauController;
use App\Http\Controllers\BahanBakuController;
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

// ========================= LOGIN ============================
Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::resource('/dashboard/atribut', AtributController::class)->middleware('auth');

Route::resource('/bahan-baku', BahanBakuController::class)->middleware('auth');

// Route::get('/bahan-baku', [BahanBakuController::class, 'index'])->middleware('auth');

Route::get('/tembakau', [TembakauController::class, 'index'])->middleware('auth');

Route::get('/pembelian-kopi', [PembelianKopiController::class, 'index'])->middleware('auth');

Route::get('/pembelian-tembakau', [PembelianTembakauController::class, 'index'])->middleware('auth');

