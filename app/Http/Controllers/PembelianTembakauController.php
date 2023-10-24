<?php

namespace App\Http\Controllers;

use App\Models\PembelianTembakau;
use Illuminate\Http\Request;

class PembelianTembakauController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transaksi.pembelian-tembakau', [
            'title' => 'Pembelian Tembakau'
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PembelianTembakau $pembelianTembakau)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PembelianTembakau $pembelianTembakau)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PembelianTembakau $pembelianTembakau)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PembelianTembakau $pembelianTembakau)
    {
        //
    }
}
