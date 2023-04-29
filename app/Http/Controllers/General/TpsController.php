<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;

use App\Models\KoorDesa;
use App\Models\KoorTps;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TpsController extends Controller
{
    public function index($slug_kota, $slug_kecamatan, $slug_desa)
    {
        $desa = KoorDesa::with([
            'tps' => function ($query) {
                $query->withCount('dpt');
                $query->withCount(['dptIsVoters' => function ($query) {
                    $query->where('is_voters', true);
                }]);
            }
        ])->where('slug', $slug_desa)->firstOrFail();
        return view('general.tps.index', compact('desa'));
    }

    public function create($slug_kota, $slug_kecamatan, $slug_desa)
    {
        $desa = KoorDesa::where('slug', $slug_desa)->first();
        return view('general.tps.create', compact('desa'));
    }

    public function store(Request $request, $id_desa)
    {
        $desa = KoorDesa::findOrFail($id_desa);
        $request->validate([
            'name' => 'required|unique:koor_tps,name,NULL,id,koor_desa_id,' . $id_desa,
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'TPS sudah ada untuk Desa ini.',
        ]);

        KoorTps::create([
            "user_id" => 1,
            "koor_desa_id" => $id_desa,
            'slug' => Str::slug($request->name),
            "name" => $request->name,
            "created_by" => 1,
            "updated_by" => 1,
        ]);

        return redirect()->route('tps.index', [
            'slug_kota' => $desa->kecamatan->kota->slug,
            'slug_kecamatan' => $desa->kecamatan->slug,
            'slug_desa' => $desa->slug
        ]);
    }
}
