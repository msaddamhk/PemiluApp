<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use Illuminate\Http\Request;

class DashboardGeneralController extends Controller
{

    public function index()
    {
        $koorDesa = new KoorDesa();
        $desaCount = $koorDesa->getCountForGeneral();
        $koorKota = new KoorKota();
        $kotaCount = $koorKota->getCountKotaForGeneral();
        $koorKecamatan =new KoorKecamatan();
        $kecamatanCount = $koorKecamatan->getCountKecamatanForGeneral();
        $dpt = new Dpt();
        $dptCount = $dpt->getCountDptForGeneral();
        return view('general.dashboard.index', compact('desaCount', 'kotaCount', 'kecamatanCount', 'dptCount'));
    }
}
