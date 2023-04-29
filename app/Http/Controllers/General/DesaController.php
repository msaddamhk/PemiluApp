<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;

use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DesaController extends Controller
{
    public function index($slug_kota, $slug_kecamatan)
    {
        $user = User::where('level', 'KOOR_DESA')->get();
        $kecamatan = KoorKecamatan::with(['koor_desa' => function ($query) {
            $query->withCount(['dpt', 'dpt as dpt_is_voters_count' => function ($query) {
                $query->where('is_voters', true);
            }]);
        }])->where('slug', $slug_kecamatan)->firstOrFail();
        return view('general.desa.index', compact('kecamatan', 'user'));
    }

    public function create($slug_kota, $slug_kecamatan)
    {
        $kecamatan = KoorKecamatan::where('slug', $slug_kecamatan)->first();
        return view('general.desa.create', compact('kecamatan'));
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
            "user_id" => 1,
            "koor_kecamatan_id" => $id_kecamatan,
            "name" => $request->name,
            'slug' => Str::slug($request->name),
            "created_by" => 1,
            "updated_by" => 1,
        ]);

        $kecamatan = KoorKecamatan::findOrFail($id_kecamatan);
        return redirect()->route('desa.index', ['slug_kota'
        => $kecamatan->kota->slug, 'slug_kecamatan' => $kecamatan->slug]);
    }
}
