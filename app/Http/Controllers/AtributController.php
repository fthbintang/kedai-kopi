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
            'title' => 'Data Atribut'
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Atribut $atribut)
    {
        //
    }
}
