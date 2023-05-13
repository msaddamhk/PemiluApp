<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;

use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use Illuminate\Http\Request;

class DptController extends Controller
{
    public function index(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
    {
        if (auth()->user()->level == 'KOOR_KAB_KOTA') {
            if ($koorkota->user_id !== auth()->id()) {
                abort(403, "Anda tidak diizinkan untuk mengakses halaman ini");
            }
        }

        $dpt = $koordesa->dpts()->where('name', 'like', '%' . request('cari') . '%')
            ->paginate(15);
        return view('general.dpt.index', compact('dpt', 'koorkecamatan', 'koorkota', 'koordesa'));
    }

    public function create(KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
    {
        return view('general.dpt.create', compact('koorkecamatan', 'koorkota', 'koordesa'));
    }

    public function store(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
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

        return redirect()->route('dpt.index', [$koorkota, $koorkecamatan, $koordesa]);
    }

    public function edit(KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, Dpt $dpt)
    {
        return view('general.dpt.edit', compact('dpt', 'koordesa', 'koorkecamatan', 'koorkota'));
    }

    public function update(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, Dpt $dpt)
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

        return redirect()->route('dpt.index', [$koorkota, $koorkecamatan, $koordesa]);
    }

    public function update_voters(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, Dpt $dpt)
    {
        $dpt->is_voters = $request->has('is_voters');
        $dpt->save();

        return redirect()->route('dpt.index', [$koorkota, $koorkecamatan, $koordesa]);
    }
}
