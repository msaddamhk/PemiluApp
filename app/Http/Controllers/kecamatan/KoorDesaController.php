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
    public function index(Request $request, $slug_kecamatan)
    {
        $user = User::where('level', 'KOOR_DESA')->get();
        $kecamatan = KoorKecamatan::with(['koor_desa' => function ($query) use ($request) {
            if ($request->has('cari')) {
                $query->where('name', 'like', '%' . $request->query('cari') . '%');
            }
            $query->withCount(['dpt', 'dpt as dpt_is_voters_count' => function ($query) {
                $query->where('is_voters', true);
            }]);
        }])->where('slug', $slug_kecamatan)->firstOrFail();
        return view('kecamatan.desa.index', compact('kecamatan', 'user'));
    }


    public function store(Request $request, $id_kecamatan)
    {
        $request->validate([
            'name' => 'required|unique:koor_desa,name,NULL,id,koor_kecamatan_id,' . $id_kecamatan,
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'Desa sudah ada untuk Kecamatan ini.',
        ]);

        KoorDesa::create([
            "user_id" => $request->user,
            "koor_kecamatan_id" => $id_kecamatan,
            "name" => $request->name,
            'slug' => Str::slug($request->name),
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        $kecamatan = KoorKecamatan::findOrFail($id_kecamatan);
        return redirect()->route('koor.kecamatan.desa.index', ['slug_kecamatan' => $kecamatan->slug]);
    }
}
