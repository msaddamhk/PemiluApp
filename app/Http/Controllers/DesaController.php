<?php

namespace App\Http\Controllers;

use App\Models\koor_desa;
use App\Models\koor_kecamatan;
use Illuminate\Http\Request;

class DesaController extends Controller
{

    public function index($id_kecamatan)
    {
        $kecamatan = koor_kecamatan::findOrFail($id_kecamatan);
        $desa = koor_desa::where('koor_kecamatan_id', $id_kecamatan)->get();
        return view('desa.index', compact('kecamatan', 'desa'));
    }

    public function create($id_kecamatan)
    {
        return view('desa.create', ['id_kecamatan' => $id_kecamatan]);
    }

    public function store(Request $request, $id_kecamatan)
    {
        $request->validate([
            'name' => 'required',
            'total_dpt' => 'required',
        ]);

        $desa = koor_desa::create([
            "user_id" => 1,
            "koor_kecamatan_id" => $id_kecamatan,
            "name" => $request->name,
            "total_dpt" => $request->total_dpt,
            "created_by" => 1,
            "updated_by" => 1,
        ]);

        return redirect($id_kecamatan . '/desa');
    }
}
