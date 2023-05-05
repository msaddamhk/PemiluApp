<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use Illuminate\Http\Request;

class DptKoorKecamatanController extends Controller
{

    public function index(Request $request, KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
    {
        $desa = $koordesa->dpts()->where('name', 'like', '%' . request('cari') . '%')
            ->get();
        return view('kecamatan.dpt.index', compact('desa', 'koorkecamatan', 'koordesa'));
    }

    public function create(KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
    {
        return view('kecamatan.dpt.create', compact('koorkecamatan', 'koordesa'));
    }

    public function store(Request $request, KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
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
            "name" => $request->name,
            "indentity_number" => $request->indentity_number,
            "phone_number" => $request->phone_number,
            "is_voters" => $request->is_voters,
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('koor.kecamatan.dpt.index', [$koorkecamatan, $koordesa]);
    }

    public function edit(KoorKecamatan $koorkecamatan, KoorDesa $koordesa, Dpt $dpt)
    {
        return view('kecamatan.dpt.edit', compact('dpt', 'koordesa', 'koorkecamatan'));
    }

    public function update(Request $request, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, Dpt $dpt)
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

        return redirect()->route('koor.kecamatan.dpt.index', [$koorkecamatan, $koordesa]);
    }

    public function update_voters(Request $request, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, Dpt $dpt)
    {
        $dpt->is_voters = $request->has('is_voters');
        $dpt->save();

        return redirect()->route('koor.kecamatan.dpt.index', [$koorkecamatan, $koordesa]);
    }
}
