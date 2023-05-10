<?php

namespace App\Http\Controllers\desa;

use App\Http\Controllers\Controller;
use App\Models\KoorDesa;
use App\Models\KoorTps;
use App\Models\QuickCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KoorDesaQuickCountController extends Controller
{
    public function index(Request $request, KoorDesa $koordesa, KoorTps $koortps)
    {
        if ($koordesa->user_id !== auth()->id()) {
            abort(403);
        }

        $quick_count = $koortps->quickCount()->where('number_of_votes', 'like', '%' . request('cari') . '%')
            ->get();

        return view(
            'desa.quickcount.index',
            compact('quick_count', 'koordesa', 'koortps')
        );
    }


    public function create(KoorDesa $koordesa, KoorTps $koortps)
    {
        return view(
            'desa.quickcount.create',
            compact('koordesa', 'koortps')
        );
    }


    public function store(Request $request, KoorDesa $koordesa, KoorTps $koortps)
    {

        $request->validate([
            'number_of_votes' => 'required',
            'total_votes' => 'required',
            'result_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:3048',
        ]);

        $request->result_photo?->store('public/img/quick_count');

        QuickCount::create([
            "koor_tps_id" => $koortps->id,
            "number_of_votes" => $request->number_of_votes,
            "total_votes" => $request->total_votes,
            'result_photo' => $request->result_photo?->hashName(),
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('koor.desa.quick_count.index', [$koordesa, $koortps]);
    }


    public function edit(KoorDesa $koordesa, KoorTps $koortps, QuickCount $quickcount)
    {
        return view(
            'desa.quickcount.edit',
            compact('quickcount', 'koordesa', 'koortps')
        );
    }

    public function update(Request $request, KoorDesa $koordesa, KoorTps $koortps, QuickCount $quickcount)
    {

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

        return redirect()->route('koor.desa.quick_count.index', [$koordesa, $koortps]);
    }
}
