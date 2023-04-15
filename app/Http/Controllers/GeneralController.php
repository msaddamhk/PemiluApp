<?php

namespace App\Http\Controllers;

use App\Models\koor_kecamatan;
use App\Models\koor_kota;
use Illuminate\Http\Request;

class GeneralController extends Controller
{

    public function index()
    {
        $kota = koor_kota::all();
        return view('general.index', compact('kota'));
    }

    public function create()
    {
        return view('general.create');
    }

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

    public function show($id_kota)
    {
        $kota = koor_kota::findOrFail($id_kota);
        $kecamatan = koor_kecamatan::where('koor_kota_id', $id_kota)->get();
        return view('general.detail', compact('kecamatan', 'kota'));
    }

    public function create_kecamatan($id_kota)
    {
        return view('general.create_kecamatan', ['id_kota' => $id_kota]);
    }

    public function store_kecamatan(Request $request, $id_kota)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $kecamatan = koor_kecamatan::create([
            "user_id" => 1,
            "koor_kota_id" => $id_kota,
            "name" => $request->name,
            "created_by" => 1,
            "updated_by" => 1,
        ]);

        return redirect('/kota/' . $id_kota);
    }
}
