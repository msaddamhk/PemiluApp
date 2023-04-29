<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorTps;
use Illuminate\Http\Request;

class DptTpsController extends Controller
{
    public function index($slug_kota, $slug_kecamatan, $slug_desa, $slug_tps)
    {
        $tps = KoorTps::with('dpt')->where('slug', $slug_tps)->firstOrFail();
        return view('general.tps.dpt', compact('tps'));
    }

    public function create($slug_kota, $slug_kecamatan, $slug_desa, $slug_tps)
    {
        $tps = KoorTps::where('slug', $slug_tps)->first();
        return view('general.tps.create_dpt', compact('tps'));
    }

    public function store(Request $request, $id_desa, $id_tps)
    {
        $tps = KoorTps::findOrFail($id_tps);
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'is_voters' => 'required',
            'indentity_number' => 'required|unique:dpt,indentity_number,',
        ], [
            'indentity_number.unique' => 'No identitas sudah terdaftar.',
        ]);

        Dpt::create([
            "desa_id" => $id_desa,
            "tps_id" => $id_tps,
            "name" => $request->name,
            "indentity_number" => $request->indentity_number,
            "phone_number" => $request->phone_number,
            "is_voters" => $request->is_voters,
            "created_by" => 1,
            "updated_by" => 1,
        ]);

        return redirect()->route('tps.dpt.index', [
            'slug_kota' => $tps->KoorDesa->kecamatan->kota->slug,
            'slug_kecamatan' => $tps->KoorDesa->kecamatan->slug,
            'slug_desa' => $tps->KoorDesa->slug,
            'slug_tps' => $tps->slug
        ]);
    }
    public function edit($slug_kota, $slug_kecamatan, $slug_desa, $slug_tps, $id_dpt)
    {
        $dpt = Dpt::where('id', $id_dpt)->first();
        return view('general.tps.edit_dpt', compact('dpt'));
    }

    public function update(Request $request, $id_dpt)
    {
        $dpt = Dpt::findOrFail($id_dpt);
        $id_tps = $dpt->tps_id;
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'is_voters' => 'required',
            'indentity_number' => 'required|unique:dpt,indentity_number,' . $id_dpt . ',id',

        ], [
            'indentity_number.unique' => 'No identitas sudah terdaftar.',
        ]);

        $dpt->name = $request->name;
        $dpt->indentity_number = $request->indentity_number;
        $dpt->phone_number = $request->phone_number;
        $dpt->is_voters = $request->is_voters;
        $dpt->updated_by = 1;
        $dpt->save();

        $tps = KoorTps::findOrFail($id_tps);

        return redirect()->route('tps.dpt.index', [
            'slug_kota' => $tps->KoorDesa->kecamatan->kota->slug,
            'slug_kecamatan' => $tps->KoorDesa->kecamatan->slug,
            'slug_desa' => $tps->KoorDesa->slug,
            'slug_tps' => $tps->slug
        ]);
    }
}
