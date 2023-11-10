<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.barang', [
            'title' => 'Data Barang',
            'barang' => Barang::all()
        ]);
    }

    public function daftarBarang()
    {
        $daftarBarang = Barang::all();
        return response()->json($daftarBarang);
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
                'create_nama_barang' => 'required',
                'create_stok' => 'required|integer',
                'create_unit' => 'required',
                'create_jenis' => 'required',
                'create_gambar' => 'image|file|max:1024'
            ],
            [
                'create_nama_barang.required' => 'Nama Barang Wajib Diisi !',
                'create_stok.required' => 'Stok Wajib Diisi !',
                'create_stok.integer' => 'Stok Diisi dengan Angka !',
                'create_unit.required' => 'Unit Wajib Dipilih !',
                'create_jenis.required' => 'Jenis Wajib Dipilih !',
                'create_gambar.image' => 'Unggah File Gambar dengan Format JPG/JPEG/PNG/GIF',
                'create_gambar.max' => 'Unggahan File Gambar Maksimal 1 MB'
            ]
        );

        try {
            $gambarPath = null;

            if ($request->hasFile('create_gambar')) { // Mengganti 'gambar' dengan 'create_gambar'
                $gambar = $request->file('create_gambar');
                $gambarPath = $gambar->store('gambar-barang', 'public');
            }

            Barang::create([
                'nama_barang' => $validatedData['create_nama_barang'],
                'stok' => $validatedData['create_stok'],
                'unit' => $validatedData['create_unit'],
                'jenis' => $validatedData['create_jenis'],
                'gambar' => $gambarPath
            ]);

            return redirect('/dashboard/barang')->with('success', 'Tambah Data Berhasil!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error-store', 'Gagal menambahkan data. Pastikan input yang Anda masukkan benar.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $rules = [
            'edit_nama_barang' => 'required',
            'edit_stok' => 'required|integer',
            'edit_unit' => 'required',
            'edit_jenis' => 'required',
            'edit_gambar' => 'image|file|max:1024'
        ];

        $customMessages = [
            'edit_nama_barang.required' => 'Nama Barang Wajib Diisi!',
            'edit_stok.required' => 'Stok Wajib Diisi!',
            'edit_stok.integer' => 'Stok Harus Bilangan Bulat!',
            'edit_unit.required' => 'Unit Wajib Dipilih!',
            'edit_jenis.required' => 'Jenis Wajib Dipilih!',
            'edit_gambar.image' => 'Unggah File Gambar dengan Format JPG/JPEG/PNG/GIF!',
            'edit_gambar.file' => 'Unggah File Gambar dengan Format JPG/JPEG/PNG/GIF!',
            'edit_gambar.max' => 'Ukuran Gambar Tidak Boleh Lebih Dari 1 MB!',
        ];

        $request->validate($rules, $customMessages);

        // Cek apakah ada gambar baru yang diunggah
        if ($request->hasFile('edit_gambar')) {
            // Validasi dan simpan gambar baru
            $request->validate([
                'edit_gambar' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            ]);

            $gambarPath = $request->file('edit_gambar')->store('gambar-barang', 'public');

            // Hapus gambar lama jika ada
            if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                Storage::disk('public')->delete($barang->gambar);
            }

            // Perbarui path gambar di dalam $barang
            $barang->gambar = $gambarPath;
        }

        // Perbarui data Atribut
        $barang->nama_barang = $request->input('edit_nama_barang');
        $barang->stok = $request->input('edit_stok');
        $barang->unit = $request->input('edit_unit');
        $barang->jenis = $request->input('edit_jenis');
        $barang->save();

        return redirect('/dashboard/barang')->with('success', 'Barang berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        if ($barang->gambar) {
            Storage::delete($barang->gambar);
        }
        Barang::destroy($barang->id);

        return redirect('/dashboard/barang')->with('success', 'Barang berhasil dihapus.');
    }
}
