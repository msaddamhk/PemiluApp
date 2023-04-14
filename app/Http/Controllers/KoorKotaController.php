<?php

namespace App\Http\Controllers;

use App\Models\koor_kota;
use Illuminate\Http\Request;

class KoorKotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kota = koor_kota::all();
        return view('general.index', compact('kota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('general.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $kota = koor_kota::create([
            "user_id" => 1,
            "name" => $request->name,
            "created_by" => 1,
            "updated_by" => 1,
        ]);

        return redirect()->route('kota.index');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
