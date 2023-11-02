<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Barang;
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
            'barangs' => Barang::all(),
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
        $rules = [
            'barang_id.*' => 'required|exists:barangs,id',
            'stok_sebelum.*' => 'required|integer',
            'stok_keluar.*' => 'required|integer',
        ];
    
        $messages = [
            'barang_id.*.required' => 'Nama Barang wajib diisi',
            'barang_id.*.exists' => 'Nama Barang tidak valid',
            'stok_sebelum.*.required' => 'Stok wajib diisi',
            'stok_sebelum.*.integer' => 'Stok harus berupa angka',
            'stok_keluar.*.required' => 'Stok Keluar wajib diisi',
            'stok_keluar.*.integer' => 'Stok Keluar harus berupa angka',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return redirect('/dashboard/barang-masuk')
                ->withErrors($validator)
                ->withInput()
                ->with('error-store', 'Gagal menambahkan data. Pastikan input yang Anda masukkan benar.');
        }
    
        // Loop untuk mengambil dan memproses input dinamis
        $barangIds = $request->input('barang_id');
        $stokSebelums = $request->input('stok_sebelum');
        $stokKeluars = $request->input('stok_keluar');
    
        foreach ($barangIds as $index => $barangId) {
            $stokSebelum = $stokSebelums[$index];
            $stokKeluar = $stokKeluars[$index];
            $stokSesudah = $stokSebelum - $stokKeluar;
    
            // Simpan data ke database
            BarangKeluar::create([
                'barang_id' => $barangId,
                'user_id' => auth()->user()->id,
                'stok_sebelum' => $stokSebelum,
                'stok_keluar' => $stokKeluar,
                'stok_sesudah' => $stokSesudah,
            ]);
    
            // Update atribut stok di tabel barangs
            $barang = Barang::find($barangId);
            $barang->stok = $stokSesudah;
            $barang->save();
        }
    
        return redirect('/dashboard/barang-keluar')->with('success', 'Tambah Data Berhasil!');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangKeluar $barangKeluar)
    {
        //
    }
}
