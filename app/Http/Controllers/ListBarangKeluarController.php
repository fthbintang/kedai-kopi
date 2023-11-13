<?php

namespace App\Http\Controllers;

use App\Models\ListBarangKeluar;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListBarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            return redirect('/dashboard/barang-keluar/list-barang-keluar')
                ->withErrors($validator)
                ->withInput()
                ->with('error-store', 'Gagal menambahkan data. Pastikan input yang Anda masukkan benar.');
        }
    
        // Loop untuk mengambil dan memproses input dinamis
        $barangIds = $request->input('barang_id');
        $stokSebelums = $request->input('stok_sebelum');
        $stokKeluars = $request->input('stok_keluar');
        $barangKeluarID = $request->input('barang_keluar_id');
    
        foreach ($barangIds as $index => $barangId) {
            $stokSebelum = $stokSebelums[$index];
            $stokKeluar = $stokKeluars[$index];
            $stokSesudah = $stokSebelum - $stokKeluar;
    
            // Simpan data ke database
            ListBarangKeluar::create([
                'barang_id' => $barangId,
                'barang_keluar_id' => $barangKeluarID,
                'stok_sebelum' => $stokSebelum,
                'stok_keluar' => $stokKeluar,
                'stok_sesudah' => $stokSesudah,
            ]);
        }
    
        return redirect()->back()->with('success', 'Tambah Data Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('master.list-barang-keluar', [
            'title' => 'List Barang Keluar',
            'listBarangKeluar' => ListBarangKeluar::where('barang_keluar_id', $id)->get(),
            'barangKeluar' => BarangKeluar::findOrFail($id),
            'barangs' => Barang::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ListBarangKeluar $listBarangKeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ListBarangKeluar $listBarangKeluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListBarangKeluar $listBarangKeluar)
    {    
        ListBarangKeluar::destroy($listBarangKeluar->id);

        return redirect()->back()->with('success', 'Data List Barang Keluar berhasil dihapus.');
    }
    
}
