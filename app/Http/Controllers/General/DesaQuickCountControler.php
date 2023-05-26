<?php

namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use App\Models\QuickCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DesaQuickCountControler extends Controller
{
    public function index(
        Request $request,
        KoorKota $koorkota,
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
    ) {

        if (auth()->user()->level == 'KOOR_KAB_KOTA') {
            if ($koorkota->user_id !== auth()->id()) {
                abort(403, "Anda tidak diizinkan untuk mengakses halaman ini");
            }
        }

        $quick_count = $koordesa->quickCount()->where('number_of_votes', 'like', '%' . request('cari') . '%')
            ->get();

        return view(
            'general.desa_quickcount.index',
            compact('quick_count', 'koorkota', 'koorkecamatan', 'koordesa')
        );
    }


    public function create(
        KoorKota $koorkota,
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
    ) {
        return view(
            'general.desa_quickcount.create',
            compact('koorkota', 'koorkecamatan', 'koordesa')
        );
    }


    public function store(
        Request $request,
        KoorKota $koorkota,
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
    ) {

        $request->validate([
            'number_of_votes' => 'required',
            'total_votes' => 'required',
            'koor_tps_id' => 'nullable',
            'name_tps' => 'nullable',
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

        return redirect()->route('desa.quick_count.index', [$koorkota, $koorkecamatan, $koordesa]);
    }


    public function edit(
        KoorKota $koorkota,
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
        QuickCount $quickcount
    ) {
        return view(
            'general.desa_quickcount.edit',
            compact('quickcount', 'koorkota', 'koorkecamatan', 'koordesa')
        );
    }

    public function update(
        Request $request,
        KoorKota $koorkota,
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
        QuickCount $quickcount
    ) {

        $request->validate([
            'number_of_votes' => 'required',
            'total_votes' => 'required',
            'name_tps' => 'nullable',
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

        return redirect()->route('desa.quick_count.index', [$koorkota, $koorkecamatan, $koordesa]);
    }
}
