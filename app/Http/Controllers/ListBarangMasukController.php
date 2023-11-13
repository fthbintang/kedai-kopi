<?php

namespace App\Http\Controllers;

use App\Models\ListBarangMasuk;
use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListBarangMasukController extends Controller
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
            'stok_masuk.*' => 'required|integer',
        ];
    
        $messages = [
            'barang_id.*.required' => 'Nama Barang wajib diisi',
            'barang_id.*.exists' => 'Nama Barang tidak valid',
            'stok_sebelum.*.required' => 'Stok wajib diisi',
            'stok_sebelum.*.integer' => 'Stok harus berupa angka',
            'stok_masuk.*.required' => 'Stok Masuk wajib diisi',
            'stok_masuk.*.integer' => 'Stok Masuk harus berupa angka',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return redirect('/dashboard/barang-masuk/list-barang-masuk')
                ->withErrors($validator)
                ->withInput()
                ->with('error-store', 'Gagal menambahkan data. Pastikan input yang Anda masukkan benar.');
        }
    
        // Loop untuk mengambil dan memproses input dinamis
        $barangIds = $request->input('barang_id');
        $stokSebelums = $request->input('stok_sebelum');
        $stokMasuks = $request->input('stok_masuk');
        $barangMasukID = $request->input('barang_masuk_id');
    
        foreach ($barangIds as $index => $barangId) {
            $stokSebelum = $stokSebelums[$index];
            $stokMasuk = $stokMasuks[$index];
            $stokSesudah = $stokSebelum + $stokMasuk;
    
            // Simpan data ke database
            ListBarangMasuk::create([
                'barang_id' => $barangId,
                'barang_masuk_id' => $barangMasukID,
                'stok_sebelum' => $stokSebelum,
                'stok_masuk' => $stokMasuk,
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
        // $listBarangMasuk = ListBarangMasuk::where('id', $id)->get();
        return view('master.list-barang-masuk', [
            'title' => 'List Barang Masuk',
            'listBarangMasuk' => ListBarangMasuk::where('barang_masuk_id', $id)->get(),
            'barangMasuk' => BarangMasuk::findOrFail($id),
            'barangs' => Barang::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ListBarangMasuk $listBarangMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ListBarangMasuk $listBarangMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListBarangMasuk $listBarangMasuk)
    {    
        ListBarangMasuk::destroy($listBarangMasuk->id);

        return redirect()->back()->with('success', 'Data List Barang Masuk berhasil dihapus.');
    }
    
}
