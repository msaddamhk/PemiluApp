<?php

namespace App\Http\Controllers\desa;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use Illuminate\Http\Request;

class DptKoorDesaController extends Controller
{
    public function index(Request $request, $slug_desa)
    {
        $desa = KoorDesa::with(['dpt' => function ($query) use ($request) {
            if ($request->has('cari')) {
                $query->where('name', 'like', '%' . $request->query('cari') . '%');
            }
        }])
            ->where('slug', $slug_desa)
            ->firstOrFail();

        return view('desa.dpt.index', compact('desa'));
    }

    public function create($slug_desa)
    {
        $desa = KoorDesa::where('slug', $slug_desa)->first();
        return view('desa.dpt.create', compact('desa'));
    }

    public function store(Request $request, $id_desa)
    {
        $desa = KoorDesa::findOrFail($id_desa);
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
            "name" => $request->name,
            "indentity_number" => $request->indentity_number,
            "phone_number" => $request->phone_number,
            "is_voters" => $request->is_voters,
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('koor.desa.dpt.index', [
            'slug_desa' => $desa->slug
        ]);
    }

    public function edit($slug_desa, $id_dpt)
    {
        $dpt = Dpt::where('id', $id_dpt)->first();
        return view('desa.dpt.edit', compact('dpt'));
    }

    public function update(Request $request, $id_dpt)
    {
        $dpt = Dpt::findOrFail($id_dpt);
        $id_desa = $dpt->desa_id;
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'is_voters' => 'required',
            // 'indentity_number' => 'required|unique:dpt,indentity_number,' . $id_desa,
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

        $desa = KoorDesa::findOrFail($id_desa);

        return redirect()->route('koor.desa.dpt.index', [
            'slug_desa' => $desa->slug
        ]);
    }

    public function update_voters(Request $request, $id_dpt)
    {
        $dpt = Dpt::findOrFail($id_dpt);
        $dpt->is_voters = $request->has('is_voters');
        $dpt->save();

        $id_desa = $dpt->desa_id;
        $desa = KoorDesa::findOrFail($id_desa);

        return redirect()->route('koor.desa.dpt.index', [
            'slug_desa' => $desa->slug
        ]);
    }
}