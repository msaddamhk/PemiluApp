<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\KoorTps;
use App\Models\QuickCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuickCountController extends Controller
{

    public function index(Request $request, $slug_kota, $slug_kecamatan, $slug_desa, $slug_tps)
    {
        $tps = KoorTps::with(['quickCount' => function ($query) use ($request) {
            if ($request->has('cari')) {
                $query->where('number_of_votes', 'like', '%' . $request->query('cari') . '%');
            }
        }])
            ->where('slug', $slug_tps)
            ->firstOrFail();

        return view('general.quickcount.index', compact('tps'));
    }

    public function create($slug_kota, $slug_kecamatan, $slug_desa, $slug_tps)
    {
        $tps = KoorTps::where('slug', $slug_tps)->first();
        return view('general.quickcount.create', compact('tps'));
    }

    public function store(Request $request, $id_tps)
    {
        $tps = KoorTps::findOrFail($id_tps);
        $request->validate([
            'number_of_votes' => 'required',
            'total_votes' => 'required',
            'result_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:3048',
        ]);

        $request->result_photo?->store('public/img/quick_count');

        QuickCount::create([
            "koor_tps_id" => $id_tps,
            "number_of_votes" => $request->number_of_votes,
            "total_votes" => $request->total_votes,
            'result_photo' => $request->result_photo?->hashName(),
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('quick_count.index', [
            'slug_kota' => $tps->KoorDesa->kecamatan->kota->slug,
            'slug_kecamatan' => $tps->KoorDesa->kecamatan->slug,
            'slug_desa' => $tps->KoorDesa->slug,
            'slug_tps' => $tps->slug
        ]);
    }

    public function edit($slug_kota, $slug_kecamatan, $slug_desa, $slug_tps, $id_quick_count)
    {
        $quick_count = QuickCount::where('id', $id_quick_count)->first();
        return view('general.quickcount.edit', compact('quick_count'));
    }

    public function update(Request $request, $id_quick_count)
    {

        $quickCount = QuickCount::findOrFail($id_quick_count);
        $id_tps = $quickCount->koor_tps_id;
        $tps = KoorTps::findOrFail($id_tps);

        $request->validate([
            'number_of_votes' => 'required',
            'total_votes' => 'required',
            'result_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $quickCount->number_of_votes = $request->number_of_votes;
        $quickCount->total_votes = $request->total_votes;

        if ($request->hasFile('result_photo')) {
            Storage::delete('public/img/quick_count/' . $quickCount->result_photo);
            $request->file('result_photo')->store('public/img/quick_count');
            $quickCount->result_photo = $request->file('result_photo')->hashName();
        }

        $quickCount->updated_by = auth()->user()->id;
        $quickCount->save();

        return redirect()->route('quick_count.index', [
            'slug_kota' => $tps->KoorDesa->kecamatan->kota->slug,
            'slug_kecamatan' => $tps->KoorDesa->kecamatan->slug,
            'slug_desa' => $tps->KoorDesa->slug,
            'slug_tps' => $tps->slug
        ]);
    }
}
