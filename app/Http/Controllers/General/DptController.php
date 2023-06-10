<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Imports\DptImport;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
            "tps_id" => $request->tps,
            "name" => $request->name,
            "indentity_number" => $request->indentity_number,
            "phone_number" => $request->phone_number,
            "is_voters" => "1",
            "date_of_birth" => $request->date_of_birth,
            "gender" => $request->gender,
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);


        return redirect()->route('dpt.index', [$koorkota, $koorkecamatan, $koordesa]);
    }

    public function import(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            $desaId = $koordesa->id;
            $file = $request->file('excel_file');
            $namefile = $file->getClientOriginalName();
            $file->move('DptImport', $namefile);
            Excel::import(new DptImport($desaId, Auth::user()), \public_path('/DptImport/' . $namefile));
            return redirect()->back()->with('success', 'Data Berhasi di Impor');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Tidak Berhasi Di Upload, perhatikan jika ada persamaan data');
        }
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
        $dpt->tps_id = $request->tps;
        $dpt->indentity_number = $request->indentity_number;
        $dpt->phone_number = $request->phone_number;
        $dpt->date_of_birth = $request->date_of_birth;
        $dpt->gender = $request->gender;
        $dpt->updated_by = auth()->user()->id;
        $dpt->save();

        return redirect()->route('dpt.index', [$koorkota, $koorkecamatan, $koordesa]);
    }

    public function delete(KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, Dpt $dpt)
    {
        $dpt->delete();
        return redirect()->route('dpt.index', [$koorkota, $koorkecamatan, $koordesa]);
    }
}
