<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KecamatanController extends Controller
{
    public function index(Request $request, KoorKota $koorkota)
    {
        if (auth()->user()->level == 'KOOR_KAB_KOTA') {
            if ($koorkota->user_id !== auth()->id()) {
                abort(403, "Anda tidak diizinkan untuk mengakses halaman ini");
            }
        }

        $kecamatan = $koorkota->KoorKecamatans()->where('name', 'like', '%' . request('cari') . '%')->paginate(15);

        $user = User::where('level', 'KOOR_KECAMATAN')
            ->whereDoesntHave('koorKecamatan')
            ->get();

        return view('general.kecamatan.index', compact('koorkota', 'kecamatan',  'user'));
    }

    public function create_kecamatan($slug_kota)
    {
        $kota = KoorKota::where('slug', $slug_kota)->first();
        return view('general.kecamatan.create_kecamatan', compact('kota'));
    }

    public function store_kecamatan(Request $request, KoorKota $koorkota)
    {

        $request->validate([
            'name' => 'required|unique:koor_kecamatan,name,NULL,id,koor_kota_id,' . $koorkota->id,
            'user_id' => 'nullable',
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'Kecamatan sudah ada untuk kota ini.',
        ]);

        $slug = Str::slug($request->name);
        $count = 2;
        while (KoorKecamatan::where('slug', $slug)->first()) {
            $slug = Str::slug($request->name) . '-' . $count;
            $count++;
        }

        KoorKecamatan::create([
            "user_id" => $request->user,
            "koor_kota_id" => $koorkota->id,
            "name" => $request->name,
            'slug' => $slug,
            "created_by" => 1,
            "updated_by" => 1,
        ]);

        return redirect()->route('kecamatan.index', $koorkota);
    }

    public function edit(KoorKota $koorkota, KoorKecamatan $koorkecamatan)
    {
        $users = User::where('level', 'KOOR_KECAMATAN')
            ->whereDoesntHave('koorKecamatan')
            ->get();

        return view('general.kecamatan.edit', compact('koorkecamatan', 'users', 'koorkota'));
    }

    public function update(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'nullable',
        ]);

        $slug = Str::slug($request->name);
        $count = 2;
        while (KoorKecamatan::where('slug', $slug)->first()) {
            $slug = Str::slug($request->name) . '-' . $count;
            $count++;
        }

        $koorkecamatan->update([
            "user_id" => $request->user,
            "name" => $request->name,
            'slug' => $slug,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('kecamatan.index', $koorkota);
    }

    public function grafik(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan)
    {
        $koorDesas = KoorDesa::where('koor_kecamatan_id', $koorkecamatan->id)->pluck('id');

        $desaDptCounts = Dpt::whereIn('desa_id', $koorDesas)
            ->select('desa_id', DB::raw('count(*) as total_dpt'))
            ->groupBy('desa_id')
            ->orderBy('total_dpt', 'desc')
            ->take(10)
            ->get();

        $labels = [];
        $data = [];

        foreach ($desaDptCounts as $desaDptCount) {
            $desa = KoorDesa::find($desaDptCount->desa_id);
            if ($desa) {
                $labels[] = $desa->name;
                $data[] = $desaDptCount->total_dpt;
            }
        }

        return view('general.grafik.kecamatan.index', compact('labels', 'data'));
    }

    public function delete(KoorKota $koorkota, KoorKecamatan $koorkecamatan)
    {
        $koorkecamatan->delete();
        return redirect()->route('kecamatan.index', $koorkota);
    }
}
