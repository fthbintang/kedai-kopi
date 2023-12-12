<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('karyawan.jadwal', [
            'title' => 'Data Jadwal Karyawan',
            'jadwal' => Jadwal::all(),
            'karyawan' => User::doesntHave('jadwal')->where('level', 3)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'create_user_id' => 'required',
                'create_shift' => 'required',
            ],
            [
                // Name custom message for validation
                'create_name.required' => 'Nama Karyawan Wajib Diisi !',
                'create_shift.required' => 'Shift Wajib Diisi !',
            ],
        );

        try {

            if ($validatedData['create_shift'] == 'shift-1') {
                $waktu_mulai = "08:00:00";
                $waktu_selesai = "15:30:00";
            } else if ($validatedData['create_shift'] == 'shift-2') {
                $waktu_mulai = "15:30:00";
                $waktu_selesai = "23:00:00";
            } else {
                $waktu_mulai = "Libur";
                $waktu_selesai = "Libur";
            }

            // Simpan data ke database
            Jadwal::create([
                'user_id'           => $validatedData['create_user_id'],
                'waktu_mulai'       => $waktu_mulai,
                'waktu_selesai'     => $waktu_selesai,
            ]);

            return redirect('/dashboard/jadwal-karyawan')->with('success', 'Tambah Jadwal Berhasil!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jadwal $jadwal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate(
            [
                'edit_name' => 'required',
                'edit_shift' => 'required',
            ],
            [
                // Name custom message for validation
                'edit_name.required' => 'Nama Karyawan Wajib Diisi !',
                'edit_shift.required' => 'Shift Wajib Diisi !',
            ],
        );

        try {
            // Simpan data user ke database

            if ($validatedData['edit_shift'] == 'shift-1') {
                $waktu_mulai = "08:00:00";
                $waktu_selesai = "15:30:00";
            } else if ($validatedData['edit_shift'] == 'shift-2') {
                $waktu_mulai = "15:30:00";
                $waktu_selesai = "23:00:00";
            } else {
                $waktu_mulai = "Libur";
                $waktu_selesai = "Libur";
            }

            $update = [
                'waktu_mulai'   => $waktu_mulai,
                'waktu_selesai' => $waktu_selesai,
            ];

            Jadwal::where('id', $id)->update($update);

            return redirect('/dashboard/jadwal-karyawan')->with('success', 'Jadwal Berhasil diubah !');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal mengubah jadwal karyawan. Pastikan input yang Anda masukkan benar.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Jadwal::destroy($id);

        return redirect('/dashboard/jadwal-karyawan')->with('success', 'Hapus Jadwal Berhasil!');
    }
}
