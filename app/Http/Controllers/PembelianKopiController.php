<?php

namespace App\Http\Controllers;

use App\Models\PembelianKopi;
use Illuminate\Http\Request;

class PembelianKopiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.transaksi.pembelian-kopi', [
            'title' => 'Pembelian Kopi'
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
    public function show(PembelianKopi $pembelianKopi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PembelianKopi $pembelianKopi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PembelianKopi $pembelianKopi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PembelianKopi $pembelianKopi)
    {
        //
    }
}
