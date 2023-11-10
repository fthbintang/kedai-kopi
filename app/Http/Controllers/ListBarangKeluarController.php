<?php

namespace App\Http\Controllers;

use App\Models\ListBarangKeluar;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

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
        //
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
        //
    }
}
