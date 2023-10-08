<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'unit' => 'required',
            'gambar' => 'image|file|max:1024'
        ]);
    
        try {
            $gambarPath = null;
    
            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarPath = $gambar->store('gambar-bahan-baku', 'public'); // Simpan gambar ke storage public/gambar
            }
    
            // Simpan data atribut ke database
            BahanBaku::create([
                'nama_bahan_baku' => $validatedData['nama_bahan_baku'],
                'stok' => $validatedData['stok'],
                'unit' => $validatedData['unit'],
                'gambar' => $gambarPath,
            ]);
    
            return redirect('/dashboard/bahan-baku')->with('success', 'Tambah Data Berhasil!');
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
            'unit' => 'required',
            'gambar' => 'image|file|max:1024'
        ];

        $validatedData = $request->validate($rules);

       // Simpan path gambar lama untuk penghapusan nantinya
        $oldImagePath = $bahanBaku->gambar;

        if ($request->file('gambar')) {
            // Simpan gambar baru
            $validatedData['gambar'] = $request->file('gambar')->store('gambar-bahan-baku', 'public');

           // Hapus gambar lama jika ada
            if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }

       // Update data Atribut
        $bahanBaku->update($validatedData);

        return redirect('/dashboard/bahan-baku')->with('success', 'Bahan Baku berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BahanBaku $bahanBaku)
    {
        if($bahanBaku->gambar) {
            Storage::delete($bahanBaku->gambar);
        }
        BahanBaku::destroy($bahanBaku->id);

        return redirect('/dashboard/bahan-baku')->with('success', 'Data Bahan Baku berhasil dihapus!');
    }
}
