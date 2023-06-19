<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use App\Models\User;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KoorKecamatanController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->input('cari');
        $kecamatan = KoorKecamatan::where('user_id', auth()->user()->id)
            ->where('name', 'like', '%' . $cari . '%')
            ->get();
        return view('kecamatan.index', compact('kecamatan'));
    }

    public function edit(KoorKecamatan $koorkecamatan)
    {
        return view('kecamatan.edit', compact('koorkecamatan'));
    }

    public function update(Request $request, KoorKecamatan $koorkecamatan)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $slug = Str::slug($request->name);
        $count = 2;
        while (KoorKecamatan::where('slug', $slug)->first()) {
            $slug = Str::slug($request->name) . '-' . $count;
            $count++;
        }

        $koorkecamatan->update([
            "name" => $request->name,
            'slug' => $slug,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('koor.kecamatan.index');
    }

    public function grafik(Request $request, KoorKecamatan $koorkecamatan)
    {
        $koorDesas = KoorDesa::where('koor_kecamatan_id', $koorkecamatan->id)->pluck('id');
        $dpts = Dpt::whereIn('desa_id', $koorDesas)->get();
        $jumlahDpt = $dpts->count();
        $jumlahdptlaki = $dpts->where('gender', 'laki-laki')->count();
        $jumlahdptperempuan = $jumlahDpt - $jumlahdptlaki;

        $desaDptCounts = Dpt::whereIn('desa_id', $koorDesas)
            ->select('desa_id', DB::raw('count(*) as total_dpt'))
            ->groupBy('desa_id')
            ->orderBy('total_dpt', 'desc')
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

        return view('kecamatan.grafik.kecamatan.index', compact('labels', 'data'));
    }
}
