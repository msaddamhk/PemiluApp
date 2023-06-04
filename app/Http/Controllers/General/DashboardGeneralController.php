<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardGeneralController extends Controller
{

    public function index()
    {
        $koorDesa = new KoorDesa();
        $desaCount = $koorDesa->getCountForGeneral();
        $koorKota = new KoorKota();
        $kotaCount = $koorKota->getCountKotaForGeneral();
        $koorKecamatan = new KoorKecamatan();
        $kecamatanCount = $koorKecamatan->getCountKecamatanForGeneral();
        $dpt = new Dpt();
        $dptCount = $dpt->getCountDptForGeneral();

        $koorkotas = Koorkota::all();

        $cityData = $koorkotas->map(function ($koorkota) {
            $countDPT = DB::table('koor_desa')
                ->join('dpt', 'koor_desa.id', '=', 'dpt.desa_id')
                ->whereIn('koor_desa.koor_kecamatan_id', function ($query) use ($koorkota) {
                    $query->select('id')
                        ->from('koor_kecamatan')
                        ->where('koor_kecamatan.koor_kota_id', $koorkota->id);
                })
                ->count();

            $totalPopulation = KoorDesa::whereIn('koor_kecamatan_id', function ($query) use ($koorkota) {
                $query->select('id')
                    ->from('koor_kecamatan')
                    ->where('koor_kecamatan.koor_kota_id', $koorkota->id);
            })
                ->sum('total_dpt');

            $percentage = $totalPopulation > 0 ? number_format(($countDPT / $totalPopulation) * 100, 2) : 0;

            return [
                'kota' => $koorkota->name,
                'slug' => $koorkota->slug,
                'total_dpt' => $countDPT,
                'total_penduduk' => $totalPopulation,
                'persentase' => $percentage,
            ];
        });

        return view('general.dashboard.index', compact('cityData', 'desaCount', 'kotaCount', 'kecamatanCount', 'dptCount'));
    }
}
