<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
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

        $gaji_karyawan_bln_sebelum = Gaji::where('date', Carbon::now()->subMonth()->format('Y-m-d'))->first();
        $gaji_karyawan_bln_ini = Gaji::where('date', Carbon::now()->format('Y-m-d'))->first();

        return view('dashboard', [
            'title' => 'Dashboard',
            'jumlah_barang_masuk' => BarangMasuk::where('status', 'Menunggu')->count(),
            'jumlah_barang_keluar' => BarangKeluar::where('status', 'Menunggu')->count(),
            'kehadiran_karyawan' => $kehadiran_karyawan,
            'status_gaji_bln_sebelum' => $gaji_karyawan_bln_sebelum,
            'status_gaji_bln_ini' => $gaji_karyawan_bln_ini,
        ]);
    }
}
