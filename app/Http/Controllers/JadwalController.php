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
                'create_waktu_mulai' => 'required',
                'create_waktu_selesai' => 'required',
            ],
            [
                // Name custom message for validation
                'create_name.required' => 'Nama Karyawan Wajib Diisi !',
                'create_waktu_mulai.required' => 'Waktu Mulai Wajib Diisi !',
                'create_waktu_selesai.required' => 'Waktu Selesai Wajib Diisi !',
            ],
        );

        try {
            // Simpan data ke database
            Jadwal::create([
                'user_id'           => $validatedData['create_user_id'],
                'waktu_mulai'       => $validatedData['create_waktu_mulai'],
                'waktu_selesai'     => $validatedData['create_waktu_selesai'],
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
                'edit_waktu_mulai' => 'required',
                'edit_waktu_selesai' => 'required',
            ],
            [
                // Name custom message for validation
                'edit_name.required' => 'Nama Karyawan Wajib Diisi !',
                'edit_waktu_mulai.required' => 'Waktu Mulai Wajib Diisi !',
                'edit_waktu_selesai.required' => 'Waktu Selesai Wajib Diisi !',
            ],
        );

        try {
            // Simpan data user ke database
            $update = [
                'waktu_mulai'   => $validatedData['edit_waktu_mulai'],
                'waktu_selesai' => $validatedData['edit_waktu_selesai'],
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
