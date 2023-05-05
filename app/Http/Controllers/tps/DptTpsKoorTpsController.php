<?php

namespace App\Http\Controllers\tps;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorTps;
use Illuminate\Http\Request;

class DptTpsKoorTpsController extends Controller
{
    public function index(Request $request, KoorTps $koortps)
    {
        $dpt = $koortps->dpt()->where('name', 'like', '%' . request('cari') . '%')
            ->get();
        return view('tps.tps.dpt', compact('dpt', 'koortps'));
    }

    public function create(KoorTps $koortps)
    {
        return view('tps.tps.create_dpt', compact('koortps'));
    }

    public function store(Request $request, KoorTps $koortps)
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
            "desa_id" => $koortps->koor_desa_id,
            "tps_id" => $koortps->id,
            "name" => $request->name,
            "indentity_number" => $request->indentity_number,
            "phone_number" => $request->phone_number,
            "is_voters" => $request->is_voters,
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('koor.tps.dpt.index', [$koortps]);
    }

    public function edit(KoorTps $koortps, Dpt $dpt)
    {
        return view('tps.tps.edit_dpt', compact('dpt', 'koortps'));
    }

    public function update(Request $request, KoorTps $koortps, Dpt $dpt)
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

        return redirect()->route('koor.tps.dpt.index', [$koortps]);
    }

    public function update_voters(Request $request, KoorTps $koortps, Dpt $dpt)
    {
        $dpt->is_voters = $request->has('is_voters');
        $dpt->save();

        return redirect()->route('koor.tps.dpt.index', [$koortps]);
    }
}
