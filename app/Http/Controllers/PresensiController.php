<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Presensi;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function checkin(string $id)
    {
        if ($id) {

            $user = User::find($id);
            $idJadwal = $user->jadwal->id;
            $waktuMasuk = $user->jadwal->waktu_mulai;
            $is_late = 0;

            if (Carbon::now('GMT+8')->format('H:i:s') > Carbon::parse($waktuMasuk)->addMinutes(20)->format('H:i:s')) {
                $is_late = 1;
            }

            Presensi::create([
                'user_id' => $id,
                'jadwal_id' => $idJadwal,
                'date' => Carbon::now()->format('Y-m-d'),
                'waktu_masuk' => Carbon::now('GMT+8')->format('H:i:s'),
                'waktu_keluar' => null,
                'is_late' => $is_late,
            ]);

            return redirect('/dashboard')->with('success', 'Berhasil Melakukan Check In !');
        }
        return redirect('/dashboard')->with('error', 'Gagal Melakukan Check In !');
    }

    public function checkout(string $id)
    {
        if ($id) {
            $user = User::find($id);
            $thisDate = Carbon::now('GMT+8')->format('Y-m-d');
            $thisTime = Carbon::now('GMT+8')->format('H:i:s');

            $idPresensi = Presensi::where('user_id', $user->id)
                ->where('date', $thisDate)->first();

            // Simpan data user ke database
            $update = [
                'waktu_keluar'      => $thisTime,
            ];

            Presensi::where('id', $idPresensi->id)->update($update);

            return redirect('/dashboard')->with('success', 'Berhasil Melakukan Check Out !');
        }
        return redirect('/dashboard')->with('error', 'Gagal Melakukan Check Out !');
    }
}
