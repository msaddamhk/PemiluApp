<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class KoorDesaController extends Controller
{
    public function index(Request $request, KoorKecamatan $koorkecamatan)
    {

        $user = User::where('level', 'KOOR_DESA')->get();
        $desa = $koorkecamatan->koorDesas()->where('name', 'like', '%' . request('cari') . '%')
            ->withCount(['dpts', 'dpts as dpt_is_voters_count' => function ($query) {
                $query->where('is_voters', true);
            }])->get();

        return view('kecamatan.desa.index', compact('koorkecamatan', 'desa', 'user'));
    }


    public function store(Request $request, KoorKecamatan $koorkecamatan)
    {

        $request->validate([
            'name' => 'required|unique:koor_desa,name,NULL,id,koor_kecamatan_id,' . $koorkecamatan->id,
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'Desa sudah ada untuk Kecamatan ini.',
        ]);

        $slug = Str::slug($request->name);
        $count = 2;
        while (KoorDesa::where('slug', $slug)->first()) {
            $slug = Str::slug($request->name) . '-' . $count;
            $count++;
        }

        KoorDesa::create([
            "user_id" => $request->user,
            "koor_kecamatan_id" => $koorkecamatan->id,
            "name" => $request->name,
            'slug' => $slug,
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);
        return redirect()->route('koor.kecamatan.desa.index', [$koorkecamatan]);
    }
}
