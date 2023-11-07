<?php

namespace App\Http\Controllers;

use App\Models\ListBarangMasuk;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $listBarangMasuk = ListBarangMasuk::where('id', $id)->get();
        return view('master.list-barang-masuk', [
            'title' => 'List Barang Masuk',
            'listBarangMasuk' => ListBarangMasuk::where('id', $id)->get(),
            'barangMasuk' => BarangMasuk::findOrFail($id)
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
        //
    }
}
