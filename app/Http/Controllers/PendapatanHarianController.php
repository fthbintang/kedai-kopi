<?php

namespace App\Http\Controllers;

use App\Models\PendapatanHarian;
use Illuminate\Http\Request;

class PendapatanHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transaksi.pendapatan-harian', [
            'title' => 'Pendapatan Harian',
            'pendapatans' => PendapatanHarian::all()
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
    public function show(PendapatanHarian $pendapatanHarian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PendapatanHarian $pendapatanHarian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PendapatanHarian $pendapatanHarian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PendapatanHarian $pendapatanHarian)
    {
        //
    }
}
