<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorTps;
use Illuminate\Http\Request;

class DptTpsKoorKecamatanController extends Controller
{

    public function index(Request $request, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, KoorTps $koortps)
    {
        if ($koorkecamatan->user_id !== auth()->id()) {
            abort(403);
        }
        $dpt = $koortps->dpt()->where('name', 'like', '%' . request('cari') . '%')
            ->get();
        return view('kecamatan.tps.dpt', compact('dpt', 'koorkecamatan', 'koordesa', 'koortps'));
    }

    public function create(KoorKecamatan $koorkecamatan, KoorDesa $koordesa, KoorTps $koortps)
    {
        return view('kecamatan.tps.create_dpt', compact('koorkecamatan', 'koordesa', 'koortps'));
    }

    public function store(Request $request, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, KoorTps $koortps)
    {

        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'is_voters' => 'required',
            'indentity_number' => 'required|unique:dpt,indentity_number,',
        ], [
            'indentity_number.unique' => 'No identitas sudah terdaftar.',
        ]);

        Dpt::create([
            "desa_id" => $koordesa->id,
            "tps_id" => $koortps->id,
            "name" => $request->name,
            "indentity_number" => $request->indentity_number,
            "phone_number" => $request->phone_number,
            "is_voters" => $request->is_voters,
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('koor.kecamatan.tps.dpt.index', [$koorkecamatan, $koordesa, $koortps]);
    }

    public function edit(KoorKecamatan $koorkecamatan, KoorDesa $koordesa, KoorTps $koortps, Dpt $dpt)
    {
        return view('kecamatan.tps.edit_dpt', compact('dpt', 'koorkecamatan', 'koordesa', 'koortps'));
    }

    public function update(Request $request, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, KoorTps $koortps, Dpt $dpt)
    {

        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'is_voters' => 'required',
            'indentity_number' => 'required|unique:dpt,indentity_number,' . $dpt->id . ',id',

        ], [
            'indentity_number.unique' => 'No identitas sudah terdaftar.',
        ]);

        $dpt->name = $request->name;
        $dpt->indentity_number = $request->indentity_number;
        $dpt->phone_number = $request->phone_number;
        $dpt->is_voters = $request->is_voters;
        $dpt->updated_by = auth()->user()->id;
        $dpt->save();

        return redirect()->route('koor.kecamatan.tps.dpt.index', [$koorkecamatan, $koordesa, $koortps]);
    }

    public function update_voters(Request $request, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, KoorTps $koortps, Dpt $dpt)
    {
        $dpt->is_voters = $request->has('is_voters');
        $dpt->save();

        return redirect()->route('koor.kecamatan.tps.dpt.index', [$koorkecamatan, $koordesa, $koortps]);
    }
}
