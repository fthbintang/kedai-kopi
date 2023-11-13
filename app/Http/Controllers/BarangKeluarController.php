<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.barang-keluar', [
            'title' => 'Data Barang Keluar',
            'barangKeluar' => BarangKeluar::all(),
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
                'nama_sesi' => 'required',
                'keterangan' => 'nullable',
            ],
            [
                'nama_sesi' => 'Nama Sesi Wajib Diisi!',
            ]
        );

        try {
            // Tambahkan data barang masuk
            BarangKeluar::create([
                'nama_sesi' => $validatedData['nama_sesi'],
                'keterangan' => $validatedData['keterangan'],
                'user_id' => auth()->user()->id,
                'status' => 'Menunggu',
            ]);

            return redirect('/dashboard/barang-keluar')->with('success', 'Tambah Data Berhasil!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error-store', 'Gagal menambahkan data. Pastikan input yang Anda masukkan benar.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BarangKeluar $barangKeluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangKeluar $barangKeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangKeluar $barangKeluar)
    {
        $validatedData = $request->validate([
            'nama_sesi' => 'required',
            'keterangan' => 'nullable',
        ], [
            'nama_sesi.required' => 'Nama Wajib Diisi !',
        ]);

        try {
            $keterangan = $validatedData['keterangan'];
            $nama_sesi = $validatedData['nama_sesi'];

            // Update atribut stok di tabel barang_masuks
            $barangKeluar->keterangan = $keterangan;
            $barangKeluar->nama_sesi = $nama_sesi;
            $barangKeluar->save();

            return redirect()->back()->with('success', 'Edit Data Berhasil!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error-update', 'Gagal mengedit data. Pastikan input yang Anda masukkan benar.');
        }
    }

    public function acc($id)
    {
        $barangKeluar = BarangKeluar::find($id);

        if ($barangKeluar) {
            $barangKeluar->status = 'ACC';
            $barangKeluar->save();
        }

        return redirect()->back()->with('success', 'Status ACC!');
    }

    public function notAcc($id)
    {
        $barangKeluar = BarangKeluar::find($id);

        if ($barangKeluar) {
            $barangKeluar->status = 'Tidak ACC';
            $barangKeluar->save();
        }

        return back()->with('notAcc', 'Status Tidak ACC!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangKeluar $barangKeluar)
    {
        BarangKeluar::destroy($barangKeluar->id);

        return redirect('/dashboard/barang-keluar')->with('success', 'Data Barang Keluar berhasil dihapus.');
    }
}
