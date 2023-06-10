<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use Illuminate\Http\Request;

use Illuminate\Support\Collection;

use Illuminate\Support\Facades\DB;


class DashboardGeneralController extends Controller
{

    public function index()
    {

        $koorKota = new KoorKota();
        $kotaCount = $koorKota->getCountKotaForGeneral();
        $cityData = $koorKota->getDataTable();
        $getDataDiagram = $koorKota->getdataDiagram();

        $koorKecamatan = new KoorKecamatan();
        $kecamatanCount = $koorKecamatan->getCountKecamatanForGeneral();

        $koorDesa = new KoorDesa();
        $desaCount = $koorDesa->getCountForGeneral();

        $dpt = new Dpt();
        $dptCount = $dpt->getCountDptForGeneral();

        return view('general.dashboard.index', compact('cityData', 'desaCount', 'kotaCount', 'kecamatanCount', 'dptCount', 'getDataDiagram'));
    }
}
