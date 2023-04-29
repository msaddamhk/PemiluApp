<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;


use App\Models\KoorKota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KotaController extends Controller
{
    public function index()
    {
        if (auth()->user()->level == 'KOOR_KAB_KOTA') {
            $kota = KoorKota::where('user_id', auth()->user()->id)->get();
            return view('general.kota.index', compact('kota'));
        } elseif (request()->user()->can('isGeneral')) {
            $kota = KoorKota::all();
            $user = User::where('level', 'KOOR_KAB_KOTA')->get();
            return view('general.kota.index', compact('kota', 'user'));
        } else {
            abort(403);
        }
    }

    public function create()
    {
        return view('general.kota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user' => 'required',
        ]);

        KoorKota::create([
            "user_id" => $request->user,
            "name" => $request->name,
            'slug' => Str::slug($request->name),
            "created_by" => 1,
            "updated_by" => 1,
        ]);

        return redirect()->route('kota.index');
    }
}
