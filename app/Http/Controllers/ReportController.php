<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Exports\GajiReport;
use Illuminate\Http\Request;
use App\Exports\PresensiReport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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
}
