<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('bahan-baku', [
            'title' => 'Data Bahan Baku',
            'bahan_baku' => BahanBaku::all()
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
        $validatedData = $request->validate([
            'nama_bahan_baku' => 'required',
            'stok' => 'required|numeric|integer',
            'unit' => 'required'
        ]);
    
        try {
            BahanBaku::create($validatedData);
    
            return redirect('/bahan-baku')->with('success', 'Tambah Data Berhasil!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menambahkan data. Pastikan input yang Anda masukkan benar.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BahanBaku $bahanBaku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BahanBaku $bahanBaku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BahanBaku $bahanBaku)
    {
        $rules = [
            'nama_bahan_baku' => 'required',
            'stok' => 'required|numeric|integer',
            'unit' => 'required'
        ];

        $validatedData = $request->validate($rules);

        try {
            BahanBaku::where('id', $bahanBaku->id)
                ->update($validatedData);
    
            return redirect('/bahan-baku')->with('success', 'Data Bahan Baku berhasil diubah!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menambahkan data. Pastikan input yang Anda masukkan benar.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BahanBaku $bahanBaku)
    {
        BahanBaku::destroy($bahanBaku->id);

        return redirect('/bahan-baku')->with('success', 'Data Bahan Baku berhasil dihapus!');
    }
}
