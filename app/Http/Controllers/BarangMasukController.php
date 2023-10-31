<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.barang-masuk', [
            'title' => 'Data Barang Masuk',
            'barangMasuk' => BarangMasuk::all(),
            'barangs' => Barang::all()
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
                'barang_id' => 'required',
                'stok_sebelum' => 'required|integer',
                'stok_masuk' => 'required|integer',
            ],
            [
                'barang_id.required' => 'Nama Barang Wajib Diisi !',
                'stok_sebelum.required' => 'Stok Wajib Diisi !',
                'stok_sebelum.integer' => 'Stok Diisi dengan Angka !',
            ]
        );

        try {
            $stokSebelum = $validatedData['stok_sebelum'];
            $stokMasuk = $validatedData['stok_masuk'];
            $stokSesudah = $stokSebelum + $stokMasuk;

            // Membuat entri baru dalam tabel barang_masuks
            BarangMasuk::create([
                'barang_id' => $validatedData['barang_id'],
                'user_id' => auth()->user()->id,
                'stok_sebelum' => $stokSebelum,
                'stok_masuk' => $stokMasuk,
                'stok_sesudah' => $stokSesudah,
            ]);

            // Update atribut stok di tabel barangs
            $barang = Barang::find($validatedData['barang_id']);
            $barang->stok = $stokSesudah;
            $barang->save();

            return redirect('/dashboard/barang-masuk')->with('success', 'Tambah Data Berhasil!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error-store', 'Gagal menambahkan data. Pastikan input yang Anda masukkan benar.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangMasuk $barangMasuk)
    {
        BarangMasuk::destroy($barangMasuk->id);

        return redirect('/dashboard/barang-masuk')->with('success', 'Data Barang Masuk berhasil dihapus.');
    }
}
