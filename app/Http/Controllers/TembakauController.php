<?php

namespace App\Http\Controllers;

use App\Models\Tembakau;
use Illuminate\Http\Request;

class TembakauController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.master.tembakau', [
            'title' => 'Data Tembakau'
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
    public function show(Tembakau $tembakau)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tembakau $tembakau)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tembakau $tembakau)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tembakau $tembakau)
    {
        //
    }
}
