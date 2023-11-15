<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('karyawan.gaji', [
            'title' => 'Data Gaji Karyawan',
            'pekerja' => User::where('level', 3)
                ->where('status', 'aktif')->get(),
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
        // return $request;
        $validatedData = $request->validate(
            [
                'create_gaji' => 'required|numeric',
            ],
            [
                'create_gaji.required' => 'Jumlah Uang Wajib Diisi !',
                'create_gaji.numeric' => 'Input Harus Berupa Angka  !',
            ]
        );

        try {
            Gaji::create([
                'user_id' => $request->create_user_id,
                'gaji' => $validatedData['create_gaji'],
                'date' => Carbon::now()->format('Y-m-d'),
            ]);

            return redirect('/dashboard/gaji-karyawan/' . $request->create_user_id)->with('success', 'Tambah Gaji Berhasil!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error-store', 'Gagal menambahkan data. Pastikan input yang Anda masukkan benar.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('karyawan.detail-gaji', [
            'title' => 'Detail Gaji Karyawan',
            'pekerja' => User::find($id),
            'gaji' => Gaji::where('user_id', $id)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gaji $gaji)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gaji $gaji)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Gaji $gaji)
    {
        $user_id = $request->user_id;
        Gaji::destroy($gaji->id);

        return redirect('/dashboard/gaji-karyawan/' . $user_id)->with('success', 'Hapus Gaji Berhasil!');
    }
}
