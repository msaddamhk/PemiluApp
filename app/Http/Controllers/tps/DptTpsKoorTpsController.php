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
        if ($koortps->user_id !== auth()->id()) {
            abort(403);
        }

        $dpt = $koortps->dpt()->where('name', 'like', '%' . request('cari') . '%')
            ->paginate(15);
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
            "desa_id" => $koortps->koor_desa_id,
            "tps_id" => $koortps->id,
            "name" => $request->name,
            "indentity_number" => $request->indentity_number,
            "phone_number" => $request->phone_number,
            "is_voters" => "1",
            "date_of_birth" => $request->date_of_birth,
            "gender" => $request->gender,
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
        $dpt->date_of_birth = $request->date_of_birth;
        $dpt->gender = $request->gender;
        $dpt->updated_by = auth()->user()->id;
        $dpt->save();

        return redirect()->route('koor.tps.dpt.index', [$koortps]);
    }
}
