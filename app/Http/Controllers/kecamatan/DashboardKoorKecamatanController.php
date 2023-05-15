<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardKoorKecamatanController extends Controller
{
    public function index()
    {
        $kecamatan = KoorKecamatan::where('user_id', auth()->user()->id)->first();
        $koorDesas = KoorDesa::where('koor_kecamatan_id', $kecamatan->id)->pluck('id');
        $jumlahDpt = Dpt::whereIn('desa_id', $koorDesas)->count();

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

        $jumlahdptlaki = Dpt::whereIn('desa_id', $koorDesas)
            ->where('gender', 'laki-laki')
            ->count();

        $jumlahdptperempuan = Dpt::whereIn('desa_id', $koorDesas)
            ->where('gender', 'perempuan')
            ->count();

        return view('kecamatan.dashboard.index', compact('kecamatan', 'labels', 'data', 'jumlahDpt', 'jumlahdptlaki', 'jumlahdptperempuan'));
    }
}
