<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use App\Models\KoorTps;
use Illuminate\Http\Request;

class DptTpsController extends Controller
{
    public function index(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, KoorTps $koortps)
    {
        $dpt = $koortps->dpt()->where('name', 'like', '%' . request('cari') . '%')
            ->get();
        return view('general.tps.dpt', compact('dpt', 'koorkota', 'koorkecamatan', 'koordesa', 'koortps'));
    }

    public function create(KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, KoorTps $koortps)
    {
        return view('general.tps.create_dpt', compact('koorkota', 'koorkecamatan', 'koordesa', 'koortps'));
    }

    public function store(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, KoorTps $koortps)
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
            "tps_id" => $koortps->id,
            "name" => $request->name,
            "indentity_number" => $request->indentity_number,
            "phone_number" => $request->phone_number,
            "is_voters" => $request->is_voters,
            "date_of_birth" => $request->date_of_birth,
            "gender" => $request->gender,
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('tps.dpt.index', [$koorkota, $koorkecamatan, $koordesa, $koortps]);
    }

    public function edit(KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, KoorTps $koortps, Dpt $dpt)
    {
        return view('general.tps.edit_dpt', compact('dpt', 'koorkota', 'koorkecamatan', 'koordesa', 'koortps'));
    }

    public function update(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, KoorTps $koortps, Dpt $dpt)
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

        return redirect()->route('tps.dpt.index', [$koorkota, $koorkecamatan, $koordesa, $koortps]);
    }

    public function update_voters(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, KoorTps $koortps, Dpt $dpt)
    {
        $dpt->is_voters = $request->has('is_voters');
        $dpt->save();

        return redirect()->route('tps.dpt.index', [$koorkota, $koorkecamatan, $koordesa, $koortps]);
    }
}
