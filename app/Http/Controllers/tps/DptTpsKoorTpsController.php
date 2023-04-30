<?php

namespace App\Http\Controllers\tps;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorTps;
use Illuminate\Http\Request;

class DptTpsKoorTpsController extends Controller
{
    public function index(Request $request, $slug_tps)
    {
        $tps = KoorTps::with(['dpt' => function ($query) use ($request) {
            if ($request->has('cari')) {
                $query->where('name', 'like', '%' . $request->query('cari') . '%');
            }
        }])
            ->where('slug', $slug_tps)
            ->firstOrFail();
        return view('tps.tps.dpt', compact('tps'));
    }

    public function create($slug_tps)
    {
        $tps = KoorTps::where('slug', $slug_tps)->first();
        return view('tps.tps.create_dpt', compact('tps'));
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
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('koor.tps.dpt.index', [
            'slug_tps' => $tps->slug
        ]);
    }
    public function edit($slug_tps, $id_dpt)
    {
        $dpt = Dpt::where('id', $id_dpt)->first();
        return view('tps.tps.edit_dpt', compact('dpt'));
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
        $dpt->updated_by = auth()->user()->id;
        $dpt->save();

        $tps = KoorTps::findOrFail($id_tps);

        return redirect()->route('koor.tps.dpt.index', [
            'slug_tps' => $tps->slug
        ]);
    }

    public function update_voters(Request $request, $id_dpt)
    {
        $dpt = Dpt::findOrFail($id_dpt);
        $dpt->is_voters = $request->has('is_voters');
        $dpt->save();

        $id_tps = $dpt->tps_id;
        $tps = KoorTps::findOrFail($id_tps);

        return redirect()->route('koor.tps.dpt.index', [
            'slug_tps' => $tps->slug
        ]);
    }
}
