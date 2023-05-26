<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use App\Models\KoorTps;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesaController extends Controller
{
    public function index(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan)
    {
        if (auth()->user()->level == 'KOOR_KAB_KOTA') {
            if ($koorkota->user_id !== auth()->id()) {
                abort(403, "Anda tidak diizinkan untuk mengakses halaman ini");
            }
        }

        $user = User::where('level', 'KOOR_DESA')
            ->whereDoesntHave('koorDesa')
            ->get();

        $desa = $koorkecamatan->koorDesas()->where('name', 'like', '%' . request('cari') . '%')
            ->withCount(['dpts', 'dpts as dpt_is_voters_count' => function ($query) {
                $query->where('is_voters', true);
            }])->paginate(15);
        return view('general.desa.index', compact('koorkota', 'koorkecamatan', 'desa', 'user'));
    }

    public function store(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan)
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

        return redirect()->route('desa.index', [$koorkota, $koorkecamatan]);
    }

    public function edit(KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
    {
        $users = User::where('level', 'KOOR_DESA')
            ->whereDoesntHave('koorDesa')
            ->get();

        return view('general.desa.edit', compact('koorkecamatan', 'users', 'koorkota', 'koordesa'));
    }

    public function update(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
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

        return redirect()->route('desa.index', [$koorkota, $koorkecamatan]);
    }

    public function grafik(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
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

        return view('general.grafik.desa.index', compact('labels', 'data'));
    }
}
