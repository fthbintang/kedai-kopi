<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
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
            'karyawan' => User::where('level', 3)->get(),
        ]);
    }

    // Ini Report Buat Presensi
    public function presensi(Request $request)
    {
        $date = Carbon::parse($request->date)->format('m-Y');
        $status = $request->status;
        $userId = $request->user_id;

        $query = User::select('users.name', 'users.status as user_status', 'presensis.waktu_masuk', 'presensis.waktu_keluar', DB::raw('(CASE WHEN presensis.is_late = "0" THEN "Tepat Waktu" WHEN presensis.is_late = "1" THEN "Terlambat" END ) as is_late'))
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
            return (new PresensiReport($query->get()))->download('rekap_kehadiran.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        } elseif ($request->ekstensi == 'csv') {
            return (new PresensiReport($query->get()))->download('rekap_kehadiran.csv', \Maatwebsite\Excel\Excel::CSV);
        } else {
            // return (new PresensiReport($query))->download('rekap_kehadiran.xlsx');
            return Excel::download(new PresensiReport($query->get()), 'rekap_kehadiran.xlsx');
        }
    }
}
