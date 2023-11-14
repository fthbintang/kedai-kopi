<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $kehadiran_karyawan = Presensi::select('*')
            ->whereBetween('date', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ])
            ->where('user_id', auth()->user()->id)
            ->get();

        return view('dashboard', [
            'title' => 'Dashboard',
            'jumlah_barang_masuk' => BarangMasuk::where('status', 'Menunggu')->count(),
            'jumlah_barang_keluar' => BarangKeluar::where('status', 'Menunggu')->count(),
            'kehadiran_karyawan' => $kehadiran_karyawan,
        ]);
    }
}
