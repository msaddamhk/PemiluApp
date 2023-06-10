<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use Illuminate\Support\Facades\DB;

class DashboardKoorKecamatanController extends Controller
{
    public function index()
    {
        $kecamatan = KoorKecamatan::where('user_id', auth()->user()->id)->first();
        $koorDesas = KoorDesa::where('koor_kecamatan_id', $kecamatan->id)->pluck('id');
        $dpts = Dpt::whereIn('desa_id', $koorDesas)->get();
        $jumlahDpt = $dpts->count();

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

        $desa = $kecamatan->koorDesas()->withCount(['dpts', 'dpts as dpt_is_voters_count' => function ($query) {
            $query->where('is_voters', true);
        }])->paginate(15);

        return view('kecamatan.dashboard.index', compact('desa', 'kecamatan', 'labels', 'data', 'jumlahDpt'));
    }
}
