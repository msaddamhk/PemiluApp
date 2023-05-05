<?php

namespace App\Http\Controllers\tps;

use App\Http\Controllers\Controller;
use App\Models\KoorTps;
use App\Models\QuickCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KoorTpsQuickCountController extends Controller
{
    public function index(Request $request, KoorTps $koortps)
    {

        $quick_count = $koortps->quickCount()->where('number_of_votes', 'like', '%' . request('cari') . '%')
            ->get();

        return view(
            'tps.quickcount.index',
            compact('quick_count', 'koortps')
        );
    }


    public function create(KoorTps $koortps)
    {
        return view(
            'tps.quickcount.create',
            compact('koortps')
        );
    }


    public function store(Request $request, KoorTps $koortps)
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

        return redirect()->route('koor.tps.quick_count.index', [$koortps]);
    }


    public function edit(KoorTps $koortps, QuickCount $quickcount)
    {
        return view(
            'tps.quickcount.edit',
            compact('quickcount', 'koortps')
        );
    }

    public function update(Request $request, KoorTps $koortps, QuickCount $quickcount)
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

        return redirect()->route('koor.tps.quick_count.index', [$koortps]);
    }
}
