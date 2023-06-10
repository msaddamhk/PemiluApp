<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use App\Models\KoorTps;
use App\Models\QuickCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuickCountController extends Controller
{

    public function index(
        Request $request,
        KoorKota $koorkota,
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
        KoorTps $koortps
    ) {

        if (auth()->user()->level == 'KOOR_KAB_KOTA') {
            if ($koorkota->user_id !== auth()->id()) {
                abort(403, "Anda tidak diizinkan untuk mengakses halaman ini");
            }
        }

        $quick_count = $koortps->quickCount()->where('number_of_votes', 'like', '%' . request('cari') . '%')
            ->get();

        return view(
            'general.quickcount.index',
            compact('quick_count', 'koorkota', 'koorkecamatan', 'koordesa', 'koortps')
        );
    }


    public function create(
        KoorKota $koorkota,
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
        KoorTps $koortps
    ) {
        return view(
            'general.quickcount.create',
            compact('koorkota', 'koorkecamatan', 'koordesa', 'koortps')
        );
    }


    public function store(
        Request $request,
        KoorKota $koorkota,
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
        KoorTps $koortps
    ) {

        $request->validate([
            'number_of_votes' => 'required',
            'total_votes' => 'required',
            'result_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:3048',
        ]);

        $request->result_photo?->store('public/img/quick_count');

        QuickCount::create([
            "koor_desa_id" => $koordesa->id,
            "koor_tps_id" => $koortps->id,
            "number_of_votes" => $request->number_of_votes,
            "total_votes" => $request->total_votes,
            'result_photo' => $request->result_photo?->hashName(),
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('quick_count.index', [$koorkota, $koorkecamatan, $koordesa, $koortps]);
    }


    public function edit(
        KoorKota $koorkota,
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
        KoorTps $koortps,
        QuickCount $quickcount
    ) {
        return view(
            'general.quickcount.edit',
            compact('quickcount', 'koorkota', 'koorkecamatan', 'koordesa', 'koortps')
        );
    }

    public function update(
        Request $request,
        KoorKota $koorkota,
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
        KoorTps $koortps,
        QuickCount $quickcount
    ) {

        $request->validate([
            'number_of_votes' => 'required',
            'total_votes' => 'required',
            'result_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $quickcount->number_of_votes = $request->number_of_votes;
        $quickcount->total_votes = $request->total_votes;

        if ($request->hasFile('result_photo')) {
            Storage::delete('public/img/quick_count/' . $quickcount->result_photo);
            $request->file('result_photo')->store('public/img/quick_count');
            $quickcount->result_photo = $request->file('result_photo')->hashName();
        }

        $quickcount->updated_by = auth()->user()->id;
        $quickcount->save();

        return redirect()->route('quick_count.index', [$koorkota, $koorkecamatan, $koordesa, $koortps]);
    }
}
