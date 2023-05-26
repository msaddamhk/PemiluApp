<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;

use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use App\Models\KoorTps;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TpsController extends Controller
{
    public function index(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
    {
        if (auth()->user()->level == 'KOOR_KAB_KOTA') {
            if ($koorkota->user_id !== auth()->id()) {
                abort(403, "Anda tidak diizinkan untuk mengakses halaman ini");
            }
        }

        $user = User::where('level', 'KOOR_TPS')
            ->whereDoesntHave('tps')
            ->get();

        $tps = $koordesa->koortps()
            ->where('name', 'like', '%' . request('cari') . '%')
            ->withCount(['dpt', 'dptIsVoters' => function ($query) {
                $query->where('is_voters', true);
            }])
            ->paginate(15);

        return view('general.tps.index', compact('tps', 'koorkecamatan', 'koorkota', 'koordesa', 'user'));
    }

    public function store(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
    {

        $request->validate([
            'name' => 'required|unique:koor_tps,name,NULL,id,koor_desa_id,' . $koordesa->id,
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'TPS sudah ada untuk Desa ini.',
        ]);

        $slug = Str::slug($request->name);
        $count = 2;
        while (KoorTps::where('slug', $slug)->first()) {
            $slug = Str::slug($request->name) . '-' . $count;
            $count++;
        }

        KoorTps::create([
            "user_id" => $request->user,
            "koor_desa_id" => $koordesa->id,
            "total_dpt_by_tps" => $request->total_dpt_by_tps,
            'slug' => $slug,
            "name" => $request->name,
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('tps.index', [$koorkota, $koorkecamatan, $koordesa]);
    }

    public function edit(KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, KoorTps $koortps)
    {
        $users = User::where('level', 'KOOR_TPS')->get();
        return view('general.tps.edit', compact('koorkecamatan', 'users', 'koorkota', 'koordesa', 'koortps'));
    }

    public function update(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, KoorTps $koortps)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $slug = Str::slug($request->name);
        $count = 2;
        while (KoorTps::where('slug', $slug)->first()) {
            $slug = Str::slug($request->name) . '-' . $count;
            $count++;
        }

        $koortps->update([
            "user_id" => $request->user,
            "name" => $request->name,
            "total_dpt_by_tps" => $request->total_dpt_by_tps,
            'slug' => $slug,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('tps.index', [$koorkota, $koorkecamatan, $koordesa]);
    }
}
