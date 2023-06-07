<?php

namespace App\Http\Controllers\desa;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorTps;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KoorDesaController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->input('cari');
        $desa = KoorDesa::where('user_id', auth()->user()->id)
            ->where('name', 'like', '%' . $cari . '%')
            ->get();
        return view('desa.desa.index', compact('desa'));
    }

    public function edit(KoorDesa $koordesa)
    {
        $users = User::where('level', 'KOOR_DESA')->get();
        return view('desa.desa.edit', compact('users', 'koordesa'));
    }

    public function update(Request $request, KoorDesa $koordesa)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $slug = Str::slug($request->name);
        $count = 2;
        while (KoorDesa::where('slug', $slug)->first()) {
            $slug = Str::slug($request->name) . '-' . $count;
            $count++;
        }

        $koordesa->update([
            "user_id" => $request->user,
            "name" => $request->name,
            "total_dpt" => $request->total_dpt,
            'slug' => $slug,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('koor.desa.index');
    }

    public function grafik(Request $request, KoorDesa $koordesa)
    {
        $koorTps = KoorTps::where('koor_desa_id', $koordesa->id)->pluck('id');

        $tpsDptCounts = Dpt::whereIn('tps_id', $koorTps)
            ->select('tps_id', DB::raw('count(*) as total_dpt'))
            ->groupBy('tps_id')
            ->orderBy('total_dpt', 'desc')
            ->get();

        $labels = [];
        $data = [];

        foreach ($tpsDptCounts as $tpsDptCount) {
            $tps = KoorTps::find($tpsDptCount->tps_id);
            if ($tps) {
                $labels[] = $tps->name;
                $data[] = $tpsDptCount->total_dpt;
            }
        }

        return view('desa.grafik.desa.index', compact('labels', 'data'));
    }
}
