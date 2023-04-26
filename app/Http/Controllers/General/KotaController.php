<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;


use App\Models\KoorKota;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KotaController extends Controller
{

    public function index()
    {
        $kota = KoorKota::all();
        return view('general.kota.index', compact('kota'));
    }

    public function create()
    {
        return view('general.kota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        KoorKota::create([
            "user_id" => 1,
            "name" => $request->name,
            'slug' => Str::slug($request->name),
            "created_by" => 1,
            "updated_by" => 1,
        ]);

        return redirect()->route('kota.index');
    }
}
