<?php

namespace App\Http\Controllers\desa;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use Illuminate\Http\Request;

class DptKoorDesaController extends Controller
{
    public function index(Request $request, KoorDesa $koordesa)
    {
        $desa = $koordesa->dpts()->where('name', 'like', '%' . request('cari') . '%')
            ->get();
        return view('desa.dpt.index', compact('desa', 'koordesa'));
    }

    public function create(KoorDesa $koordesa)
    {
        return view('desa.dpt.create', compact('koordesa'));
    }

    public function store(Request $request, KoorDesa $koordesa)
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

        return redirect()->route('koor.desa.dpt.index', [$koordesa]);
    }

    public function edit(KoorDesa $koordesa, Dpt $dpt)
    {
        return view('desa.dpt.edit', compact('dpt', 'koordesa'));
    }

    public function update(Request $request, KoorDesa $koordesa, Dpt $dpt)
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

        return redirect()->route('koor.desa.dpt.index', [$koordesa]);
    }

    public function update_voters(Request $request, KoorDesa $koordesa, Dpt $dpt)
    {
        $dpt->is_voters = $request->has('is_voters');
        $dpt->save();

        return redirect()->route('koor.desa.dpt.index', [$koordesa]);
    }
}
