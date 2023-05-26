<?php

namespace App\Http\Controllers\desa;

use App\Http\Controllers\Controller;
use App\Models\KoorDesa;
use App\Models\QuickCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KoorDesaDesaQuickCountControler extends Controller
{
    public function index(Request $request, KoorDesa $koordesa)
    {
        if ($koordesa->user_id !== auth()->id()) {
            abort(403);
        }

        $quick_count = $koordesa->quickCount()->where('number_of_votes', 'like', '%' . request('cari') . '%')
            ->get();

        return view(
            'desa.desa_quickcount.index',
            compact('quick_count', 'koordesa')
        );
    }


    public function create(KoorDesa $koordesa)
    {
        return view(
            'desa.desa_quickcount.create',
            compact('koordesa')
        );
    }


    public function store(Request $request, KoorDesa $koordesa)
    {

        $request->validate([
            'number_of_votes' => 'required',
            'total_votes' => 'required',
            'name_tps' => 'nullable|unique:quick_count,name_tps,',
            'result_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:3048',
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

        return redirect()->route('koor.desa.desa.quick_count.index', [$koordesa]);
    }


    public function edit(KoorDesa $koordesa, QuickCount $quickcount)
    {
        return view(
            'desa.desa_quickcount.edit',
            compact('quickcount', 'koordesa')
        );
    }

    public function update(Request $request, KoorDesa $koordesa, QuickCount $quickcount)
    {

        $request->validate([
            'number_of_votes' => 'required',
            'total_votes' => 'required',
            'name_tps' => 'nullable|unique:quick_count,name_tps,' . $quickcount->id,
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

        return redirect()->route('koor.desa.desa.quick_count.index', [$koordesa]);
    }
}
