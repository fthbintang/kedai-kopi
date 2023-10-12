<?php

namespace App\Http\Controllers;

use App\Models\Atribut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AtributController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.master.atribut', [
            'title' => 'Data Atribut',
            'atribut' => Atribut::all()
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
            'create_nama_barang' => 'required',
            'create_stok' => 'required|integer',
            'create_gambar' => 'image|file|max:1024'
        ],
        [
            // Username custom message for validation
            'create_nama_barang.required' => 'Nama Barang Wajib Diisi !',

            // Stok custom message for validation
            'create_stok.required' => 'Stok Wajib Diisi !',
            'create_stok.integer' => 'Stok Diisi dengan Angka !',

            // Gambar custom message for validation
            'create_unit.required' => 'Unit Wajib Dipilih !',

            // Gambar custom message for validation
            'create_gambar.image' => 'Unggah File Gambar dengan Format JPG/JPEG/PNG/GIF',
        ]);

        try {
            $gambarPath = null;

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $gambarPath = $gambar->store('gambar-atribut', 'public'); // Simpan gambar ke storage public/gambar
            }

            // Simpan data atribut ke database
            Atribut::create([
                'nama_barang' => $validatedData['nama_barang'],
                'stok' => $validatedData['stok'],
                'gambar' => $gambarPath,
            ]);

            return redirect('/dashboard/atribut')->with('success', 'Tambah Data Berhasil!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error-store', 'Gagal menambahkan data. Pastikan input yang Anda masukkan benar.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Atribut $atribut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Atribut $atribut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Atribut $atribut)
    {
        $rules = [
            'edit_nama_barang' => 'required',
            'edit_stok' => 'required|numeric|integer',
            'edit_unit' => 'required',
            'edit_gambar' => 'image|file|max:1024'
        ];

        $customMessages = [
            'edit_nama_barang.required' => 'Nama Barang Wajib Diisi!',
            'edit_stok.required' => 'Stok Wajib Diisi!',
            'edit_stok.numeric' => 'Stok Diisi dengan Angka!',
            'edit_stok.integer' => 'Stok Harus Bilangan Bulat!',
            'edit_unit.required' => 'Unit Wajib Dipilih!',
            'edit_gambar.image' => 'Unggah File Gambar dengan Format JPG/JPEG/PNG/GIF!',
            'edit_gambar.file' => 'Unggah File Gambar dengan Format JPG/JPEG/PNG/GIF!',
            'edit_gambar.max' => 'Ukuran Gambar Tidak Boleh Lebih Dari 1 MB!',
        ];

        $validatedData = $request->validate($rules, $customMessages);

        // Simpan path gambar lama untuk penghapusan nantinya
        $oldImagePath = $atribut->gambar;

        if ($request->file('gambar')) {
            // Simpan gambar baru
            $validatedData['gambar'] = $request->file('gambar')->store('gambar-barang', 'public');

            // Hapus gambar lama jika ada
            if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        // Update data Atribut
        $atribut->update($validatedData);

        return redirect('/dashboard/atribut')->with('success', 'Atribut berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Atribut $atribut)
    {
        if ($atribut->gambar) {
            Storage::delete($atribut->gambar);
        }
        Atribut::destroy($atribut->id);

        return redirect('/dashboard/atribut')->with('success', 'Atribut berhasil dihapus.');
    }
}
