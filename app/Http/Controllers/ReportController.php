<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Exports\GajiReport;
use Illuminate\Http\Request;
use App\Exports\PresensiReport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PendapatanHarian;
use App\Exports\PendapatanReport;
use App\Models\BarangMasuk;
use App\Exports\BarangMasukReport;
use App\Models\BarangKeluar;
use App\Exports\BarangKeluarReport;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index', [
            'title' => 'Generate Laporan',
            'karyawan' => User::where('level', 3)->where('status', 'aktif')->get(),
        ]);
    }

    // Ini Report Buat Presensi
    public function presensi(Request $request)
    {
        $date = Carbon::parse($request->date)->format('m-Y');
        $status = $request->status;
        $userId = $request->user_id;

        $query = User::select('users.name', 'users.status as user_status', 'presensis.date', 'presensis.waktu_masuk', 'presensis.waktu_keluar', DB::raw('(CASE WHEN presensis.is_late = "0" THEN "Tepat Waktu" WHEN presensis.is_late = "1" THEN "Terlambat" END ) as is_late'))
            ->leftJoin('presensis', 'users.id', 'presensis.user_id')
            ->whereRaw("DATE_FORMAT(date, '%m-%Y') = '$date'")
            ->where('users.level', 3);

        if ($status) {
            $query->where('presensis.is_late', $status);
        }

        if ($userId) {
            $query->where('presensis.user_id', $userId);
        }

        // $query->get();

        // Ini perkondisian ekstensi apa yang dipilih
        if ($request->ekstensi == 'pdf') {
            return Excel::download(new PresensiReport($query->get()), 'rekap_kehadiran_' . $date . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        } elseif ($request->ekstensi == 'csv') {
            return Excel::download(new PresensiReport($query->get()), 'rekap_kehadiran_' . $date . '.csv', \Maatwebsite\Excel\Excel::CSV);
        } else {
            return Excel::download(new PresensiReport($query->get()), 'rekap_kehadiran_' . $date . '.xlsx');
        }
    }

    // Ini Report Buat Presensi
    public function gaji(Request $request)
    {
        $date = Carbon::parse($request->date)->format('m-Y');
        $is_paid = $request->is_paid;
        $userId = $request->user_id;

        $query = User::select('users.name', 'users.status as user_status', 'gajis.date', 'gajis.gaji', DB::raw('(CASE WHEN gajis.gaji IS NULL THEN "Belum Dibayar" WHEN gajis.gaji IS NOT NULL THEN "Dibayar" END ) as is_paid'))
            ->leftJoin('gajis', function ($join) use ($date) {
                $join->on('users.id', '=', 'gajis.user_id')
                    ->whereRaw("DATE_FORMAT(date, '%m-%Y') = '$date'");
            })
            ->where('users.level', 3)
            ->where('users.status', '=', 'aktif');

        if ($is_paid == 'dibayar') {
            $query->whereNotNull('gajis.gaji');
        } elseif ($is_paid == 'belum_dibayar') {
            $query->whereNull('gajis.gaji');
        }

        if ($userId) {
            $query->where('users.id', $userId);
        }

        // Ini perkondisian ekstensi apa yang dipilih
        if ($request->ekstensi == 'pdf') {
            return Excel::download(new GajiReport($query->get()), 'rekap_gaji_' . $date . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        } elseif ($request->ekstensi == 'csv') {
            return Excel::download(new GajiReport($query->get()), 'rekap_gaji_' . $date . '.csv', \Maatwebsite\Excel\Excel::CSV);
        } else {
            return Excel::download(new GajiReport($query->get()), 'rekap_gaji_' . $date . '.xlsx');
        }
    }

    public function pendapatan(Request $request)
    {
        $date = Carbon::parse($request->date)->format('Y-m');

        // Ambil data pendapatan berdasarkan bulan dan tahun yang dipilih
        $pendapatan = PendapatanHarian::whereYear('tanggal', Carbon::parse($date)->year)
            ->whereMonth('tanggal', Carbon::parse($date)->month)
            ->get();

        // Check jika ada data pendapatan untuk bulan dan tahun yang dipilih
        if ($pendapatan->isEmpty()) {
            return redirect('/dashboard')->with('error', 'Tidak ada data pendapatan untuk bulan dan tahun yang dipilih.');
        }

        // Lakukan export ke Excel menggunakan class PendapatanReport
        if ($request->ekstensi == 'pdf') {
            return Excel::download(new PendapatanReport($pendapatan), 'laporan_pendapatan_' . $date . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        } elseif ($request->ekstensi == 'csv') {
            return Excel::download(new PendapatanReport($pendapatan), 'laporan_pendapatan_' . $date . '.csv', \Maatwebsite\Excel\Excel::CSV);
        } else {
            return Excel::download(new PendapatanReport($pendapatan), 'laporan_pendapatan_' . $date . '.xlsx');
        }
    }

    // Ini Report Buat Barang Masuk
    public function barangMasuk(Request $request)
    {
        $date = Carbon::parse($request->date)->format('Y-m');

        // Ambil data barang masuk berdasarkan bulan dan tahun yang dipilih
        $barangMasuk = BarangMasuk::with(['listBarangMasuk.barang'])
            ->whereYear('created_at', Carbon::parse($date)->year)
            ->whereMonth('created_at', Carbon::parse($date)->month)
            ->get();

        // Check jika ada data barang masuk untuk bulan dan tahun yang dipilih
        if ($barangMasuk->isEmpty()) {
            return redirect('/dashboard')->with('error', 'Tidak ada data barang masuk untuk bulan dan tahun yang dipilih.');
        }

        // Lakukan export ke Excel menggunakan class BarangMasukReport
        if ($request->ekstensi == 'pdf') {
            return Excel::download(new BarangMasukReport($barangMasuk), 'laporan_barang_masuk_' . $date . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        } elseif ($request->ekstensi == 'csv') {
            return Excel::download(new BarangMasukReport($barangMasuk), 'laporan_barang_masuk_' . $date . '.csv', \Maatwebsite\Excel\Excel::CSV);
        } else {
            return Excel::download(new BarangMasukReport($barangMasuk), 'laporan_barang_masuk_' . $date . '.xlsx');
        }
    }

        // Ini Report Buat Barang Keluar
        public function barangKeluar(Request $request)
        {
            $date = Carbon::parse($request->date)->format('Y-m');
    
            // Ambil data barang keluar berdasarkan bulan dan tahun yang dipilih
            $barangKeluar = BarangKeluar::with(['listBarangKeluar.barang'])
                ->whereYear('created_at', Carbon::parse($date)->year)
                ->whereMonth('created_at', Carbon::parse($date)->month)
                ->get();
    
            // Check jika ada data barang masuk untuk bulan dan tahun yang dipilih
            if ($barangKeluar->isEmpty()) {
                return redirect('/dashboard')->with('error', 'Tidak ada data barang keluar untuk bulan dan tahun yang dipilih.');
            }
    
            // Lakukan export ke Excel menggunakan class BarangMasukReport
            if ($request->ekstensi == 'pdf') {
                return Excel::download(new BarangKeluarReport($barangKeluar), 'laporan_barang_keluar_' . $date . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
            } elseif ($request->ekstensi == 'csv') {
                return Excel::download(new BarangKeluarReport($barangKeluar), 'laporan_barang_keluar_' . $date . '.csv', \Maatwebsite\Excel\Excel::CSV);
            } else {
                return Excel::download(new BarangKeluarReport($barangKeluar), 'laporan_barang_keluar_' . $date . '.xlsx');
            }
        }

}
