<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\QuickCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KoorKecamatanDesaQuickCountControler extends Controller
{
    public function index(
        Request $request,
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
    ) {
        if ($koorkecamatan->user_id !== auth()->id()) {
            abort(403);
        }

        $quick_count = $koordesa->quickCount()->where('number_of_votes', 'like', '%' . request('cari') . '%')
            ->get();

        return view(
            'kecamatan.desa_quickcount.index',
            compact('quick_count', 'koorkecamatan', 'koordesa')
        );
    }


    public function create(
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
    ) {
        return view(
            'kecamatan.desa_quickcount.create',
            compact('koorkecamatan', 'koordesa')
        );
    }


    public function store(
        Request $request,
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
    ) {

        $request->validate([
            'number_of_votes' => 'required',
            'total_votes' => 'required',
            'koor_tps_id' => 'nullable',
            'name_tps' => 'nullable|unique:quick_count,name_tps,',
            'result_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $request->result_photo?->store('public/img/quick_count');

        QuickCount::create([
            "koor_desa_id" => $koordesa->id,
            "number_of_votes" => $request->number_of_votes,
            "total_votes" => $request->total_votes,
            "name_tps" => $request->name_tps,
            'result_photo' => $request->result_photo?->hashName(),
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('koor.kecamatan.desa.quick_count.index', [$koorkecamatan, $koordesa]);
    }


    public function edit(
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
        QuickCount $quickcount
    ) {
        return view(
            'kecamatan.desa_quickcount.edit',
            compact('quickcount', 'koorkecamatan', 'koordesa')
        );
    }

    public function update(
        Request $request,
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
        QuickCount $quickcount
    ) {

        $request->validate([
            'number_of_votes' => 'required',
            'total_votes' => 'required',
            'name_tps' => 'nullable|unique:quick_count,name_tps,' . $quickcount->id,
            'koor_tps_id' => 'nullable',
            'result_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $quickcount->number_of_votes = $request->number_of_votes;
        $quickcount->total_votes = $request->total_votes;
        $quickcount->name_tps = $request->name_tps;

        if ($request->hasFile('result_photo')) {
            Storage::delete('public/img/quick_count/' . $quickcount->result_photo);
            $request->file('result_photo')->store('public/img/quick_count');
            $quickcount->result_photo = $request->file('result_photo')->hashName();
        }

        $quickcount->updated_by = auth()->user()->id;
        $quickcount->save();

        return redirect()->route('koor.kecamatan.desa.quick_count.index', [$koorkecamatan, $koordesa]);
    }
}
