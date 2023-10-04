<?php

namespace App\Http\Controllers;

use App\Models\Atribut;
use Illuminate\Http\Request;

class AtributController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('atribut', [
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
        // $validatedData = $request->validate([
        //     'nama_barang' => 'required',
        //     'stok' => 'required|numeric|integer',
        //     'harga' => 'required|numeric|integer'
        // ]);

        // Atribut::create($validatedData);

        // return redirect('/atribut')->with('success', 'Tambah Data Berhasil!');

        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'stok' => 'required|numeric|integer',
            'harga' => 'required|numeric|integer'
        ]);
    
        try {
            Atribut::create($validatedData);
    
            return redirect('/atribut')->with('success', 'Tambah Data Berhasil!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menambahkan data. Pastikan input yang Anda masukkan benar.');
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
            'nama_barang' => 'required',
            'stok' => 'required',
            'harga' => 'required'
        ];

        $validatedData = $request->validate($rules);

        Atribut::where('id', $atribut->id)
            ->update($validatedData);

        return redirect('/atribut')->with('success', 'Data Atribut berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Atribut $atribut)
    {
        Atribut::destroy($atribut->id);

        return redirect('/atribut')->with('success', 'Data Atribut berhasil dihapus!');
    }
}
