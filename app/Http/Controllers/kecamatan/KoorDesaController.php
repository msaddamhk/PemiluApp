<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorTps;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KoorDesaController extends Controller
{

    public function index(Request $request, KoorKecamatan $koorkecamatan)
    {
        if ($koorkecamatan->user_id !== auth()->id()) {
            abort(403);
        }

        $user = User::where('level', 'KOOR_DESA')->get();
        $desa = $koorkecamatan->koorDesas()->where('name', 'like', '%' . request('cari') . '%')
            ->withCount(['dpts', 'dpts as dpt_is_voters_count' => function ($query) {
                $query->where('is_voters', true);
            }])->paginate(15);

        return view('kecamatan.desa.index', compact('koorkecamatan', 'desa', 'user'));
    }


    public function store(Request $request, KoorKecamatan $koorkecamatan)
    {

        $request->validate([
            'name' => 'required|unique:koor_desa,name,NULL,id,koor_kecamatan_id,' . $koorkecamatan->id,
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'Desa sudah ada untuk Kecamatan ini.',
        ]);

        $slug = Str::slug($request->name);
        $count = 2;
        while (KoorDesa::where('slug', $slug)->first()) {
            $slug = Str::slug($request->name) . '-' . $count;
            $count++;
        }

        KoorDesa::create([
            "user_id" => $request->user,
            "koor_kecamatan_id" => $koorkecamatan->id,
            "name" => $request->name,
            "total_dpt" => $request->total_dpt,
            'slug' => $slug,
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);
        return redirect()->route('koor.kecamatan.desa.index', [$koorkecamatan]);
    }

    public function edit(KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
    {
        $users = User::where('level', 'KOOR_DESA')->get();
        return view('kecamatan.desa.edit', compact('koorkecamatan', 'users', 'koordesa'));
    }

    public function update(Request $request, KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
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

        return redirect()->route('koor.kecamatan.desa.index', [$koorkecamatan]);
    }

    public function grafik(Request $request, KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
    {
        $koorTps = KoorTps::where('koor_desa_id', $koordesa->id)->pluck('id');

        $tpsDptCounts = Dpt::whereIn('tps_id', $koorTps)
            ->select('tps_id', DB::raw('count(*) as total_dpt'))
            ->groupBy('tps_id')
            ->orderBy('total_dpt', 'desc')
            ->take(10)
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

        return view('kecamatan.grafik.desa.index', compact('labels', 'data'));
    }
}
