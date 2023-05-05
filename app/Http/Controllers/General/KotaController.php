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
            $kota = KoorKota::where('user_id', auth()->user()->id)
                ->where('name', 'like', '%' . (request('cari') ?? '') . '%')
                ->get();

            return view('general.kota.index', compact('kota'));
        } elseif (request()->user()->can('isGeneral')) {
            $kota = KoorKota::where('name', 'like', '%' . (request('cari') ?? '') . '%')->get();

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

        $slug = Str::slug($request->name);
        $count = 2;
        while (KoorKota::where('slug', $slug)->first()) {
            $slug = Str::slug($request->name) . '-' . $count;
            $count++;
        }

        KoorKota::create([
            "user_id" => $request->user,
            "name" => $request->name,
            'slug' => $slug,
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('kota.index');
    }
}
