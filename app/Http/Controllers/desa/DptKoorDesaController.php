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
        if ($koordesa->user_id !== auth()->id()) {
            abort(403);
        }
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
            'phone_number' => 'nullable|numeric|unique:dpt,phone_number,',
            'is_voters' => 'nullable',
            'gender' => 'nullable',
            'date_of_birth' => 'nullable|date',
            'indentity_number' => 'nullable|numeric|unique:dpt,indentity_number,',
        ], [
            'indentity_number.unique' => 'No identitas sudah terdaftar.',
            'phone_number.unique' => 'No HP sudah terdaftar.',
            'phone_number.numeric' => 'No Hp Wajib Angka',
            'date_of_birth.date' => 'Tanggal Lahir Format Tanggal',

        ]);

        Dpt::create([
            "desa_id" => $koordesa->id,
            "name" => $request->name,
            "indentity_number" => $request->indentity_number,
            "phone_number" => $request->phone_number,
            "is_voters" => $request->is_voters,
            "date_of_birth" => $request->date_of_birth,
            "gender" => $request->gender,
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
            'phone_number' => 'nullable|numeric|unique:dpt,phone_number,' . $dpt->id . ',id',
            'is_voters' => 'nullable',
            'gender' => 'nullable',
            'date_of_birth' => 'nullable|date',
            'indentity_number' => 'nullable|numeric|unique:dpt,indentity_number,' . $dpt->id . ',id',
        ], [
            'indentity_number.unique' => 'No identitas sudah terdaftar.',
            'phone_number.unique' => 'No HP sudah terdaftar.',
            'phone_number.numeric' => 'No Hp Wajib Angka',
            'date_of_birth.date' => 'Tanggal Lahir Format Tanggal',
        ]);

        $dpt->name = $request->name;
        $dpt->indentity_number = $request->indentity_number;
        $dpt->phone_number = $request->phone_number;
        $dpt->is_voters = $request->is_voters;
        $dpt->date_of_birth = $request->date_of_birth;
        $dpt->gender = $request->gender;
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
